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
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, watch, computed } from "vue";
import { Head, router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AdminCreateRecordModal from "./Components/AdminCreateRecordModal.vue";
import AdminEditRecordModal from "./Components/AdminEditRecordModal.vue";
import { AgGridVue } from "ag-grid-vue3";
import { ModuleRegistry, AllCommunityModule } from "ag-grid-community";
ModuleRegistry.registerModules([AllCommunityModule]);
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-alpine.css";

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
const selectedRecord = ref({});

// Pagination page size options
const paginationPageSizeSelector = ref([5, 10, 15, 20, 50]);

const columnDefs = ref([
    { headerName: "ID", field: "id", sortable: true, filter: true, width: 60 },
    {
        headerName: "Supplier",
        field: "supplier_name",
        sortable: true,
        filter: true,
        width: 140,
    },
    {
        headerName: "Lorry Amount",
        field: "lorry_amount",
        sortable: true,
        filter: true,
        width: 120,
        valueFormatter: (params) => formatCurrency(params.value),
    },
    {
        headerName: "Lorry Units",
        field: "lorry_units",
        sortable: true,
        filter: true,
        width: 100,
        valueFormatter: (params) => `${params.value} m³`,
    },
    {
        headerName: "Tractor Amount",
        field: "tractor_amount",
        sortable: true,
        filter: true,
        width: 130,
        valueFormatter: (params) => formatCurrency(params.value),
    },
    {
        headerName: "Tractor Units",
        field: "tractor_units",
        sortable: true,
        filter: true,
        width: 110,
        valueFormatter: (params) => `${params.value} m³`,
    },
    {
        headerName: "Lorry Profit",
        field: "expected_profit_lorry",
        sortable: true,
        filter: true,
        width: 110,
        valueFormatter: (params) => formatCurrency(params.value),
    },
    {
        headerName: "Tractor Profit",
        field: "expected_profit_tractor",
        sortable: true,
        filter: true,
        width: 120,
        valueFormatter: (params) => formatCurrency(params.value),
    },
    {
        headerName: "Total Profit",
        field: "total_expected_profit",
        sortable: true,
        filter: true,
        width: 110,
        valueFormatter: (params) => formatCurrency(params.value),
    },
    {
        headerName: "Confirmed m³",
        field: "confirmed_cubic_meters",
        sortable: true,
        filter: true,
        width: 120,
        valueFormatter: (params) => `${params.value} m³`,
    },

    {
        headerName: "Actions",
        field: "actions",
        cellRenderer: (params) => {
            return `
                <button onclick="editRecord(${params.data.id})" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded text-xs mr-2">
                    Edit
                </button>
                <button onclick="deleteRecord(${params.data.id})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs">
                    Delete
                </button>
            `;
        },
        width: 150,
        sortable: false,
        filter: false,
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
window.editRecord = (id) => {
    console.log("Edit record clicked with ID:", id);
    console.log("Available records:", props.records);
    const record = props.records.find((record) => record.id === id);
    console.log("Found record:", record);
    if (record) {
        selectedRecord.value = record;
        showEditModal.value = true;
        console.log("Modal should be showing:", showEditModal.value);
        console.log("Selected record:", selectedRecord.value);
    } else {
        console.log("Record not found with ID:", id);
        alert("Record not found");
    }
};

window.deleteRecord = async (id) => {
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
