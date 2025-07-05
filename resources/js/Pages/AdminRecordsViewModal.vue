<template>
    <Head title="Records" />
    <AuthenticatedLayout>
        <div class="p-4 sm:p-6 lg:p-8 bg-gray-100 min-h-screen">
            <div class="mx-auto max-w-7xl">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Filters Section -->
                        <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                            <div
                                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4"
                            >
                                <!-- Date Range Filter -->
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                        >Date From</label
                                    >
                                    <input
                                        v-model="filters.dateFrom"
                                        type="date"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        @change="applyFilters"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                        >Date To</label
                                    >
                                    <input
                                        v-model="filters.dateTo"
                                        type="date"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        @change="applyFilters"
                                    />
                                </div>

                                <!-- Supplier Filter -->
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                        >Suppliers</label
                                    >
                                    <div class="relative">
                                        <!-- Search input with tags inside -->
                                        <div class="relative">
                                            <div
                                                class="w-full min-h-[42px] border border-gray-300 rounded-md px-3 py-2 pr-8 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 flex flex-wrap items-center gap-1"
                                            >
                                                <!-- Selected suppliers tags inside input -->
                                                <span
                                                    v-for="supplier in selectedSuppliers"
                                                    :key="supplier.id"
                                                    class="inline-flex items-center px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full"
                                                >
                                                    {{ supplier.name }}
                                                    <button
                                                        @click="
                                                            removeSupplier(
                                                                supplier.id
                                                            )
                                                        "
                                                        class="ml-1 text-blue-600 hover:text-blue-800 text-sm"
                                                        type="button"
                                                    >
                                                        ×
                                                    </button>
                                                </span>

                                                <!-- Search input -->
                                                <input
                                                    v-model="supplierSearch"
                                                    @focus="
                                                        showSupplierDropdown = true
                                                    "
                                                    @blur="hideDropdownDelayed"
                                                    type="text"
                                                    :placeholder="
                                                        selectedSuppliers.length ===
                                                        0
                                                            ? 'Search and select suppliers...'
                                                            : ''
                                                    "
                                                    class="flex-1 min-w-0 border-0 outline-none focus:ring-0 p-0 bg-transparent"
                                                    style="box-shadow: none"
                                                />
                                            </div>

                                            <!-- Clear all button -->
                                            <button
                                                v-if="
                                                    selectedSuppliers.length > 0
                                                "
                                                @click="clearAllSuppliers"
                                                class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                                type="button"
                                            >
                                                ×
                                            </button>

                                            <!-- Dropdown menu -->
                                            <div
                                                v-if="
                                                    showSupplierDropdown &&
                                                    filteredSuppliers.length > 0
                                                "
                                                class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-40 overflow-y-auto"
                                                style="top: 100%"
                                            >
                                                <div
                                                    v-for="supplier in filteredSuppliers"
                                                    :key="supplier.id"
                                                    @mousedown="
                                                        selectSupplier(supplier)
                                                    "
                                                    class="px-3 py-2 cursor-pointer hover:bg-blue-50 flex items-center justify-between"
                                                >
                                                    <span>{{
                                                        supplier.name
                                                    }}</span>
                                                    <span
                                                        v-if="
                                                            isSupplierSelected(
                                                                supplier.id
                                                            )
                                                        "
                                                        class="text-blue-600"
                                                    >
                                                        ✓
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Clear Filters Button -->
                                <div class="flex items-end">
                                    <button
                                        @click="clearFilters"
                                        class="w-full bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition-colors"
                                    >
                                        Clear Filters
                                    </button>
                                </div>
                            </div>

                            <!-- Amount Range Filters -->
                            <div
                                class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4"
                            >
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                        >Min Amount (KES)</label
                                    >
                                    <input
                                        v-model.number="filters.minAmount"
                                        type="number"
                                        placeholder="0"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        @input="applyFilters"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                        >Max Amount (KES)</label
                                    >
                                    <input
                                        v-model.number="filters.maxAmount"
                                        type="number"
                                        placeholder="1000000"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        @input="applyFilters"
                                    />
                                </div>
                                <div class="flex items-end">
                                    <div class="text-sm text-gray-600">
                                        Showing {{ filteredRecords.length }} of
                                        {{ records.length }} records
                                    </div>
                                </div>
                            </div>
                        </div>

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
                            :rowData="filteredRecords"
                            :defaultColDef="defaultColDef"
                            :pagination="true"
                            :paginationPageSize="10"
                            :paginationPageSizeSelector="
                                paginationPageSizeSelector
                            "
                            :gridOptions="gridOptions"
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
import { ref, watch, computed, onMounted } from "vue";
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
        flex: 0,
        width: 70,
        minWidth: 50,
        maxWidth: 100,
        suppressSizeToFit: true,
        autoHeaderHeight: true,
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
            const isUserAdmin = page.props.auth?.user?.is_admin || false;

            const viewButton = `<button onclick="viewRecord(${params.data.id})" class="bg-green-500 hover:bg-green-600 text-white font-medium py-1 px-2 rounded text-xs transition-colors" style="min-width: 40px; font-size: 10px;">
                View
            </button>`;

            const editButton = `<button onclick="editRecord(${params.data.id})" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-1 px-2 rounded text-xs transition-colors" style="min-width: 35px; font-size: 10px;">
                Edit
            </button>`;

            const deleteButton = isUserAdmin
                ? `<button onclick="deleteRecord(${params.data.id})" class="bg-red-500 hover:bg-red-600 text-white font-medium py-1 px-2 rounded text-xs transition-colors" style="min-width: 40px; font-size: 10px;">
                    Delete
                </button>`
                : "";

            const buttonCount = isUserAdmin ? 3 : 2;
            const containerWidth = buttonCount === 3 ? "125px" : "85px";

            return `<div style="display: flex; gap: 2px; justify-content: center; align-items: center; height: 100%; width: ${containerWidth}; flex-wrap: nowrap; overflow: hidden;">${viewButton}${editButton}${deleteButton}</div>`;
        },
        flex: 0,
        width: 130,
        minWidth: 130,
        maxWidth: 130,
        sortable: false,
        filter: false,
        suppressSizeToFit: true,
        cellStyle: {
            textAlign: "center",
            display: "flex",
            alignItems: "center",
            justifyContent: "center",
            padding: "2px",
        },
    },
]);

const defaultColDef = ref({
    resizable: true,
    flex: 1,
    minWidth: 100,
});

const rowData = ref(props.records);

// Grid reference for auto-sizing
const gridApi = ref(null);
const gridOptions = ref({
    onGridReady: (params) => {
        gridApi.value = params.api;
        // Auto-size the ID column after grid is ready
        setTimeout(() => {
            params.api.autoSizeColumns(["id"]);
        }, 100);
    },
});

// Filter state
const filters = ref({
    dateFrom: "",
    dateTo: "",
    supplierIds: [],
    minAmount: null,
    maxAmount: null,
});

// Multiselect dropdown variables
const supplierSearch = ref("");
const showSupplierDropdown = ref(false);
const selectedSuppliers = ref([]);
let hideDropdownTimeout = null;

// Computed filtered records
const filteredRecords = computed(() => {
    let filtered = [...props.records];

    // Date range filter
    if (filters.value.dateFrom) {
        filtered = filtered.filter((record) => {
            const recordDate = new Date(record.created_at);
            const fromDate = new Date(filters.value.dateFrom);
            return recordDate >= fromDate;
        });
    }

    if (filters.value.dateTo) {
        filtered = filtered.filter((record) => {
            const recordDate = new Date(record.created_at);
            const toDate = new Date(filters.value.dateTo);
            return recordDate <= toDate;
        });
    }

    // Supplier filter
    if (filters.value.supplierIds.length > 0) {
        filtered = filtered.filter((record) =>
            filters.value.supplierIds.includes(record.supplier_id)
        );
    }

    // Amount range filter
    if (filters.value.minAmount !== null && filters.value.minAmount !== "") {
        filtered = filtered.filter(
            (record) => record.total_expected_profit >= filters.value.minAmount
        );
    }

    if (filters.value.maxAmount !== null && filters.value.maxAmount !== "") {
        filtered = filtered.filter(
            (record) => record.total_expected_profit <= filters.value.maxAmount
        );
    }

    return filtered;
});

// Apply filters function
const applyFilters = () => {
    rowData.value = filteredRecords.value;
    // Auto-size ID column after filtering
    setTimeout(() => {
        if (gridApi.value) {
            gridApi.value.autoSizeColumns(["id"]);
        }
    }, 100);
};

// Clear filters function
const clearFilters = () => {
    filters.value = {
        dateFrom: "",
        dateTo: "",
        supplierIds: [],
        minAmount: null,
        maxAmount: null,
    };
    selectedSuppliers.value = [];
    supplierSearch.value = "";
    rowData.value = props.records;
};

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
        // Reset filters when records change (e.g., after create/edit/delete)
        if (
            filters.value.dateFrom ||
            filters.value.dateTo ||
            filters.value.supplierId ||
            filters.value.minAmount !== null ||
            filters.value.maxAmount !== null
        ) {
            applyFilters();
        } else {
            rowData.value = newVal;
        }
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

// Multiselect dropdown computed properties
const filteredSuppliers = computed(() => {
    if (!supplierSearch.value) {
        return props.suppliers.filter(
            (supplier) =>
                !selectedSuppliers.value.some(
                    (selected) => selected.id === supplier.id
                )
        );
    }
    return props.suppliers.filter(
        (supplier) =>
            supplier.name
                .toLowerCase()
                .includes(supplierSearch.value.toLowerCase()) &&
            !selectedSuppliers.value.some(
                (selected) => selected.id === supplier.id
            )
    );
});

// Multiselect dropdown methods
const selectSupplier = (supplier) => {
    if (!isSupplierSelected(supplier.id)) {
        selectedSuppliers.value.push(supplier);
        filters.value.supplierIds.push(supplier.id);
        applyFilters();
    }
    supplierSearch.value = "";
    showSupplierDropdown.value = false;
};

const removeSupplier = (supplierId) => {
    selectedSuppliers.value = selectedSuppliers.value.filter(
        (s) => s.id !== supplierId
    );
    filters.value.supplierIds = filters.value.supplierIds.filter(
        (id) => id !== supplierId
    );
    applyFilters();
};

const clearAllSuppliers = () => {
    selectedSuppliers.value = [];
    filters.value.supplierIds = [];
    supplierSearch.value = "";
    applyFilters();
};

const isSupplierSelected = (supplierId) => {
    return selectedSuppliers.value.some((s) => s.id === supplierId);
};

const hideDropdownDelayed = () => {
    hideDropdownTimeout = setTimeout(() => {
        showSupplierDropdown.value = false;
    }, 200);
};

const clearHideTimeout = () => {
    if (hideDropdownTimeout) {
        clearTimeout(hideDropdownTimeout);
        hideDropdownTimeout = null;
    }
};

console.log("Records data received as prop:", props.records);
console.log("Suppliers data received as prop:", props.suppliers);
</script>
