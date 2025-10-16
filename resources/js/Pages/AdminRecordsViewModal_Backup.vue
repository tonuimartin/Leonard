<template>
    <Head title="Records" />
    <AuthenticatedLayout>
        <div class="bg-primary min-h-screen">
            <div class="mx-auto max-w-6xl">
                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center"
                                >
                                    <svg
                                        class="w-4 h-4 text-white"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                        ></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">
                                    Total Records
                                </div>
                                <div class="text-2xl font-bold text-gray-900">
                                    {{ totalRecords }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center"
                                >
                                    <svg
                                        class="w-4 h-4 text-white"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"
                                        ></path>
                                        <path
                                            fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                                            clip-rule="evenodd"
                                        ></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">
                                    Total Profit
                                </div>
                                <div class="text-2xl font-bold text-green-600">
                                    {{ formatCurrency(totalProfit) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center"
                                >
                                    <svg
                                        class="w-4 h-4 text-white"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"
                                        ></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">
                                    Total Volume
                                </div>
                                <div class="text-2xl font-bold text-purple-600">
                                    {{ totalVolume }} m³
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center"
                                >
                                    <svg
                                        class="w-4 h-4 text-white"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"
                                        ></path>
                                        <path
                                            d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"
                                        ></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">
                                    Avg Profit/Record
                                </div>
                                <div class="text-2xl font-bold text-orange-600">
                                    {{ formatCurrency(avgProfit) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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

                        <!-- AG Grid with grouped columns -->
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
                            :getRowStyle="getRowStyle"
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
const selectedRecord = ref({});

// Check if user is admin
const isAdmin = computed(() => {
    return page.props.auth?.user?.is_admin || false;
});

// Pagination page size options
const paginationPageSizeSelector = ref([5, 10, 15, 20, 50]);

const columnDefs = computed(() => [
    {
        headerName: "ID",
        field: "id",
        sortable: true,
        filter: true,
        width: 70,
        pinned: "left",
        cellStyle: { fontWeight: "bold", color: "#1f2937" },
    },
    {
        headerName: "Supplier",
        field: "supplier_name",
        sortable: true,
        filter: true,
        width: 150,
        pinned: "left",
        cellStyle: { fontWeight: "500", color: "#374151" },
    },
    {
        headerName: "Date",
        field: "created_at",
        sortable: true,
        filter: true,
        width: 120,
        cellStyle: { color: "#6b7280" },
    },
    {
        headerName: "Transport Details",
        children: [
            {
                headerName: "Lorry",
                children: [
                    {
                        headerName: "Amount",
                        field: "lorry_amount",
                        sortable: true,
                        filter: true,
                        width: 110,
                        valueFormatter: (params) =>
                            formatCurrency(params.value),
                        cellStyle: { textAlign: "right", fontWeight: "500" },
                    },
                    {
                        headerName: "Units (m³)",
                        field: "lorry_units",
                        sortable: true,
                        filter: true,
                        width: 90,
                        valueFormatter: (params) => `${params.value}`,
                        cellStyle: { textAlign: "right", color: "#059669" },
                    },
                ],
            },
            {
                headerName: "Tractor",
                children: [
                    {
                        headerName: "Amount",
                        field: "tractor_amount",
                        sortable: true,
                        filter: true,
                        width: 110,
                        valueFormatter: (params) =>
                            formatCurrency(params.value),
                        cellStyle: { textAlign: "right", fontWeight: "500" },
                    },
                    {
                        headerName: "Units (m³)",
                        field: "tractor_units",
                        sortable: true,
                        filter: true,
                        width: 90,
                        valueFormatter: (params) => `${params.value}`,
                        cellStyle: { textAlign: "right", color: "#059669" },
                    },
                ],
            },
        ],
    },
    {
        headerName: "Profit Analysis",
        children: [
            {
                headerName: "Lorry Profit",
                field: "expected_profit_lorry",
                sortable: true,
                filter: true,
                width: 110,
                valueFormatter: (params) => formatCurrency(params.value),
                cellStyle: (params) => ({
                    textAlign: "right",
                    fontWeight: "600",
                    color: params.value > 0 ? "#059669" : "#dc2626",
                }),
            },
            {
                headerName: "Tractor Profit",
                field: "expected_profit_tractor",
                sortable: true,
                filter: true,
                width: 120,
                valueFormatter: (params) => formatCurrency(params.value),
                cellStyle: (params) => ({
                    textAlign: "right",
                    fontWeight: "600",
                    color: params.value > 0 ? "#059669" : "#dc2626",
                }),
            },
            {
                headerName: "Total Profit",
                field: "total_expected_profit",
                sortable: true,
                filter: true,
                width: 120,
                valueFormatter: (params) => formatCurrency(params.value),
                cellStyle: (params) => ({
                    textAlign: "right",
                    fontWeight: "bold",
                    fontSize: "14px",
                    color:
                        params.value > 50000
                            ? "#059669"
                            : params.value > 20000
                            ? "#d97706"
                            : "#dc2626",
                    backgroundColor:
                        params.value > 50000
                            ? "#f0fdf4"
                            : params.value > 20000
                            ? "#fffbeb"
                            : "#fef2f2",
                }),
            },
        ],
    },
    {
        headerName: "Volume Details (m³)",
        children: [
            {
                headerName: "Confirmed",
                field: "confirmed_cubic_meters",
                sortable: true,
                filter: true,
                width: 100,
                valueFormatter: (params) => `${params.value}`,
                cellStyle: {
                    textAlign: "right",
                    color: "#059669",
                    fontWeight: "500",
                },
            },
            {
                headerName: "Extra",
                field: "extra_cubic",
                sortable: true,
                filter: true,
                width: 80,
                valueFormatter: (params) =>
                    params.value ? `+${params.value}` : "0",
                cellStyle: (params) => ({
                    textAlign: "right",
                    color: params.value > 0 ? "#059669" : "#6b7280",
                    fontWeight: params.value > 0 ? "600" : "normal",
                }),
            },
            {
                headerName: "Less",
                field: "less_cubic",
                sortable: true,
                filter: true,
                width: 80,
                valueFormatter: (params) =>
                    params.value ? `-${params.value}` : "0",
                cellStyle: (params) => ({
                    textAlign: "right",
                    color: params.value > 0 ? "#dc2626" : "#6b7280",
                    fontWeight: params.value > 0 ? "600" : "normal",
                }),
            },
        ],
    },
    {
        headerName: "Actions",
        field: "actions",
        cellRenderer: (params) => {
            const editButton = `<button onclick="editRecord(${params.data.id})" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-1 px-3 rounded text-xs mr-2 transition-colors">
                Edit
            </button>`;

            const deleteButton = isAdmin.value
                ? `<button onclick="deleteRecord(${params.data.id})" class="bg-red-500 hover:bg-red-600 text-white font-medium py-1 px-3 rounded text-xs transition-colors">
                    Delete
                </button>`
                : "";

            return editButton + deleteButton;
        },
        width: 140,
        sortable: false,
        filter: false,
        pinned: "right",
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

// Computed properties for summary cards
const totalRecords = computed(() => props.records.length);
const totalProfit = computed(() =>
    props.records.reduce((sum, record) => sum + record.total_expected_profit, 0)
);
const totalVolume = computed(() =>
    props.records.reduce(
        (sum, record) => sum + record.confirmed_cubic_meters,
        0
    )
);
const avgProfit = computed(() =>
    totalRecords.value > 0 ? totalProfit.value / totalRecords.value : 0
);

// Row styling function for better visual hierarchy
const getRowStyle = (params) => {
    const profit = params.data.total_expected_profit;
    if (profit > 50000) {
        return { backgroundColor: "#f0fdf4" }; // Light green for high profit
    } else if (profit > 20000) {
        return { backgroundColor: "#fffbeb" }; // Light yellow for medium profit
    } else if (profit < 10000) {
        return { backgroundColor: "#fef2f2" }; // Light red for low profit
    }
    return null;
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
