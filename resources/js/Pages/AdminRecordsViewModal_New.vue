<template>
    <Head title="Records" />
    <AuthenticatedLayout>
        <div class="p-4 sm:p-6 lg:p-8 bg-gray-100 min-h-screen">
            <div class="mx-auto max-w-7xl">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Create Record Button -->
                        <div class="mb-4">
                            <button
                                @click="showCreateModal = true"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            >
                                Create Record
                            </button>
                        </div>
                        <!-- AG Grid -->
                        <ag-grid-vue
                            class="ag-theme-alpine"
                            style="width: 100%"
                            :domLayout="'autoHeight'"
                            :columnDefs="columnDefs"
                            :rowData="rowData"
                            :defaultColDef="defaultColDef"
                            :pagination="true"
                            :paginationPageSize="10"
                            :paginationPageSizeSelector="
                                paginationPageSizeSelector
                            "
                            theme="legacy"
                        />
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Record Modal Component -->
        <AdminCreateRecordModal
            :showModal="showCreateModal"
            :suppliers="suppliers"
            @close="showCreateModal = false"
            @created="handleRecordCreated"
        />

        <!-- Edit Record Modal Component -->
        <AdminEditRecordModal
            :showModal="showEditModal"
            :recordData="selectedRecord"
            :suppliers="suppliers"
            @close="showEditModal = false"
            @updated="handleRecordUpdated"
        />

        <!-- View Record Modal -->
        <div
            v-if="showViewModal"
            class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
        >
            <div
                class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white"
            >
                <div class="mt-3">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Record Details
                        </h3>
                        <button
                            @click="showViewModal = false"
                            class="text-gray-400 hover:text-gray-600"
                        >
                            <svg
                                class="w-6 h-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                ></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Record Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Basic Info -->
                        <div class="space-y-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Record ID</label
                                >
                                <div
                                    class="mt-1 text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded"
                                >
                                    {{ viewRecord.id }}
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Supplier</label
                                >
                                <div
                                    class="mt-1 text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded"
                                >
                                    {{ viewRecord.supplier_name }}
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Date Created</label
                                >
                                <div
                                    class="mt-1 text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded"
                                >
                                    {{ viewRecord.created_at }}
                                </div>
                            </div>
                        </div>

                        <!-- Transport Details -->
                        <div class="space-y-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Lorry Amount</label
                                >
                                <div
                                    class="mt-1 text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded"
                                >
                                    {{
                                        formatCurrency(viewRecord.lorry_amount)
                                    }}
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Lorry Units</label
                                >
                                <div
                                    class="mt-1 text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded"
                                >
                                    {{ viewRecord.lorry_units }} m³
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Tractor Amount</label
                                >
                                <div
                                    class="mt-1 text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded"
                                >
                                    {{
                                        formatCurrency(
                                            viewRecord.tractor_amount
                                        )
                                    }}
                                </div>
                            </div>
                        </div>

                        <!-- More Details -->
                        <div class="space-y-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Tractor Units</label
                                >
                                <div
                                    class="mt-1 text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded"
                                >
                                    {{ viewRecord.tractor_units }} m³
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Confirmed Cubic Meters</label
                                >
                                <div
                                    class="mt-1 text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded"
                                >
                                    {{ viewRecord.confirmed_cubic_meters }} m³
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Extra Cubic</label
                                >
                                <div
                                    class="mt-1 text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded"
                                >
                                    {{ viewRecord.extra_cubic }} m³
                                </div>
                            </div>
                        </div>

                        <!-- Profit Details -->
                        <div class="space-y-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Less Cubic</label
                                >
                                <div
                                    class="mt-1 text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded"
                                >
                                    {{ viewRecord.less_cubic }} m³
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Lorry Profit</label
                                >
                                <div
                                    class="mt-1 text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded"
                                >
                                    {{
                                        formatCurrency(
                                            viewRecord.expected_profit_lorry
                                        )
                                    }}
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Tractor Profit</label
                                >
                                <div
                                    class="mt-1 text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded"
                                >
                                    {{
                                        formatCurrency(
                                            viewRecord.expected_profit_tractor
                                        )
                                    }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Profit - Full Width -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700"
                            >Total Expected Profit</label
                        >
                        <div
                            class="mt-1 text-lg font-bold text-green-600 bg-green-50 px-3 py-2 rounded"
                        >
                            {{
                                formatCurrency(viewRecord.total_expected_profit)
                            }}
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-end mt-6">
                        <button
                            @click="showViewModal = false"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, watch, computed } from "vue";
import { Head, router, usePage } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AdminCreateRecordModal from "./Components/AdminCreateRecordModal.vue";
import AdminEditRecordModal from "./Components/AdminEditRecordModal.vue";
import { AgGridVue } from "ag-grid-vue3";
import { ModuleRegistry, AllCommunityModule } from "ag-grid-community";
ModuleRegistry.registerModules([AllCommunityModule]);
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-alpine.css";

const page = usePage();

const props = defineProps({
    records: {
        type: Array,
        default: () => [],
    },
    suppliers: {
        type: Array,
        default: () => [],
    },
});

const showCreateModal = ref(false);
const showEditModal = ref(false);
const showViewModal = ref(false);
const selectedRecord = ref({});
const viewRecord = ref({});

// Check if user is admin
const isAdmin = computed(() => {
    return page.props.auth?.user?.is_admin || false;
});

// Pagination page size options
const paginationPageSizeSelector = ref([5, 10, 15, 20, 50]);

// Simplified column definitions with essential fields only
const columnDefs = computed(() => [
    {
        headerName: "ID",
        field: "id",
        sortable: true,
        filter: true,
        width: 70,
    },
    {
        headerName: "Supplier",
        field: "supplier_name",
        sortable: true,
        filter: true,
        width: 150,
    },
    {
        headerName: "Date",
        field: "created_at",
        sortable: true,
        filter: true,
        width: 120,
    },
    {
        headerName: "Total Profit",
        field: "total_expected_profit",
        sortable: true,
        filter: true,
        width: 130,
        valueFormatter: (params) => formatCurrency(params.value),
        cellStyle: (params) => ({
            textAlign: "right",
            fontWeight: "bold",
            color: params.value > 0 ? "#059669" : "#dc2626",
        }),
    },
    {
        headerName: "Confirmed Vol.",
        field: "confirmed_cubic_meters",
        sortable: true,
        filter: true,
        width: 120,
        valueFormatter: (params) => `${params.value} m³`,
        cellStyle: { textAlign: "right" },
    },
    {
        headerName: "Actions",
        field: "actions",
        cellRenderer: (params) => {
            const viewButton = `<button onclick="viewRecord(${params.data.id})" class="bg-green-500 hover:bg-green-600 text-white font-medium py-1 px-3 rounded text-xs mr-2 transition-colors">
                View
            </button>`;

            const editButton = `<button onclick="editRecord(${params.data.id})" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-1 px-3 rounded text-xs mr-2 transition-colors">
                Edit
            </button>`;

            const deleteButton = isAdmin.value
                ? `<button onclick="deleteRecord(${params.data.id})" class="bg-red-500 hover:bg-red-600 text-white font-medium py-1 px-3 rounded text-xs transition-colors">
                    Delete
                </button>`
                : "";

            return viewButton + editButton + deleteButton;
        },
        width: 200,
        sortable: false,
        filter: false,
        cellStyle: { textAlign: "center" },
    },
]);

const defaultColDef = ref({
    resizable: true,
    flex: 1,
});

const rowData = ref(props.records);

// Currency formatting function
const formatCurrency = (amount) => {
    return new Intl.NumberFormat("en-KE", {
        style: "currency",
        currency: "KES",
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    }).format(amount || 0);
};

watch(
    () => props.records,
    (newVal) => {
        rowData.value = newVal;
        console.log("Updated records data:", newVal);
    }
);

// Make functions globally available for button clicks
window.viewRecord = (id) => {
    console.log("View record clicked with ID:", id);
    const record = props.records.find((record) => record.id === id);
    if (record) {
        viewRecord.value = record;
        showViewModal.value = true;
    } else {
        alert("Record not found");
    }
};

window.editRecord = (id) => {
    console.log("Edit record clicked with ID:", id);
    const record = props.records.find((record) => record.id === id);
    if (record) {
        selectedRecord.value = record;
        showEditModal.value = true;
    } else {
        alert("Record not found");
    }
};

window.deleteRecord = async (id) => {
    if (!isAdmin.value) {
        alert("You don't have permission to delete records.");
        return;
    }

    if (confirm("Are you sure you want to delete this record?")) {
        try {
            const response = await fetch(`/records/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                    "Content-Type": "application/json",
                },
            });

            if (response.ok) {
                router.reload();
            } else {
                alert("Error deleting record");
            }
        } catch (error) {
            console.error("Error:", error);
            alert("Error deleting record");
        }
    }
};

const handleRecordCreated = () => {
    console.log("Record created successfully!");
};

const handleRecordUpdated = () => {
    console.log("Record updated successfully!");
    selectedRecord.value = {};
};

console.log("Records data received as prop:", props.records);
console.log("Suppliers data received as prop:", props.suppliers);
</script>
