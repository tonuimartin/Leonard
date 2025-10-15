<template>
    <Head title="Records" />
    <AuthenticatedLayout>
        <div
            class="p-3 sm:p-4 lg:p-5 bg-primary min-h-screen"
        >
            <div class="mx-auto max-w-7xl">
                <!-- Page Header -->
                <div class="mb-3">
                    <div
                        class="bg-white/70 backdrop-blur-sm rounded-xl shadow-md border border-[#D1D5DB]/50 p-3"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <h1
                                    class="text-xl font-display font-bold text-[#1F2937] mb-1"
                                >
                                    Records Management
                                </h1>
                                <p class="text-accent text-sm font-medium font-body">
                                    Manage all transportation records and
                                    transactions
                                </p>
                            </div>
                            <div class="flex items-center gap-2">
                                <!-- Create Record Button -->
                                <button
                                    @click="showCreateModal = true"
                                    class="inline-flex items-center gap-1.5 bg-gradient-to-r from-accent to-accent-hover hover:from-accent-hover hover:to-accent-dark text-white font-semibold py-2 px-4 text-sm rounded-lg transition-all duration-200 transform hover:scale-[1.01] shadow-md hover:shadow-lg font-body"
                                >
                                    <svg
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                                        />
                                    </svg>
                                    Create Record
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white/70 backdrop-blur-sm rounded-xl shadow-md border border-[#D1D5DB]/50 p-3"
                >
                    <div class="text-gray-900">
                        <!-- Filters Section -->
                        <div
                            class="records-filters mb-3 p-3 bg-gradient-to-r from-primary to-white rounded-lg border border-accent/20 shadow-sm"
                        >
                            <h3 class="text-base font-display font-semibold mb-2 text-[#1F2937]">
                                Filters
                            </h3>
                            <div
                                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2"
                            >
                                <!-- Date Range Filter -->
                                <div>
                                    <label
                                        class="block text-xs font-medium mb-1 font-body"
                                        >Date From</label
                                    >
                                    <input
                                        v-model="filters.dateFrom"
                                        type="date"
                                        class="w-full modern-input"
                                        @change="applyFilters"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-medium mb-1 font-body"
                                        >Date To</label
                                    >
                                    <input
                                        v-model="filters.dateTo"
                                        type="date"
                                        class="w-full modern-input"
                                        @change="applyFilters"
                                    />
                                </div>

                                <!-- Supplier Filter -->
                                <div>
                                    <label
                                        class="block text-xs font-medium mb-1 font-body"
                                        >Suppliers</label
                                    >
                                    <div class="relative">
                                        <!-- Search input with tags inside -->
                                        <div class="relative">
                                            <div
                                                class="w-full min-h-[40px] border border-[#D1D5DB] rounded-lg px-3 py-1.5 pr-8 focus-within:ring-2 focus-within:ring-accent focus-within:border-accent flex flex-wrap items-center gap-1 bg-white shadow-sm"
                                            >
                                                <!-- Selected suppliers tags inside input -->
                                                <span
                                                    v-for="supplier in selectedSuppliers"
                                                    :key="supplier.id"
                                                    class="inline-flex items-center px-3 py-1 text-sm bg-accent/10 text-accent-hover rounded-full shadow-sm"
                                                >
                                                    {{ supplier.name }}
                                                    <button
                                                        @click="
                                                            removeSupplier(
                                                                supplier.id
                                                            )
                                                        "
                                                        class="ml-2 text-accent hover:text-accent-hover text-lg font-bold"
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
                                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-accent/60 hover:text-accent-hover text-xl"
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
                                                class="absolute z-10 w-full mt-1 bg-white border border-accent/20 rounded-xl shadow-2xl max-h-40 overflow-y-auto backdrop-blur-lg"
                                                style="top: 100%"
                                            >
                                                <div
                                                    v-for="supplier in filteredSuppliers"
                                                    :key="supplier.id"
                                                    @mousedown="
                                                        selectSupplier(supplier)
                                                    "
                                                    class="px-4 py-3 cursor-pointer hover:bg-accent/10 flex items-center justify-between transition-colors duration-200"
                                                >
                                                    <span
                                                        class="text-gray-900"
                                                        >{{
                                                            supplier.name
                                                        }}</span
                                                    >
                                                    <span
                                                        v-if="
                                                            isSupplierSelected(
                                                                supplier.id
                                                            )
                                                        "
                                                        class="text-accent-hover font-bold"
                                                        >✓</span
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Clear Filters Button -->
                                <div class="flex items-end">
                                    <button
                                        @click="clearFilters"
                                        class="w-full modern-btn py-3 px-6"
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
                                        class="block text-xs font-medium mb-1 font-body"
                                        >Min Amount (KES)</label
                                    >
                                    <input
                                        v-model.number="filters.minAmount"
                                        type="number"
                                        placeholder="0"
                                        class="w-full modern-input"
                                        @input="applyFilters"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-medium mb-1 font-body"
                                        >Max Amount (KES)</label
                                    >
                                    <input
                                        v-model.number="filters.maxAmount"
                                        type="number"
                                        placeholder="1000000"
                                        class="w-full modern-input"
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


                        <!-- AG Grid with Modern Styling -->
                        <div
                            class="rounded-xl overflow-hidden border border-accent/20 shadow-sm"
                        >
                            <ag-grid-vue
                                class="ag-theme-alpine modern-grid"
                                style="
                                    width: 100%;
                                    --ag-grid-size: 8px;
                                    --ag-border-color: #D1D5DB;
                                    --ag-header-background-color: #FAF4F2;
                                    --ag-header-foreground-color: #1F2937;
                                    --ag-odd-row-background-color: #ffffff;
                                    --ag-row-hover-color: rgba(212, 163, 115, 0.1);
                                "
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
                                :loading="false"
                                theme="legacy"
                            />
                        </div>
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
            class="fixed inset-0 bg-gray-900 bg-opacity-75 overflow-y-auto h-full w-full z-50 backdrop-blur-sm"
        >
            <div
                class="relative top-20 mx-auto p-4 border w-11/12 md:w-3/4 lg:w-1/2 shadow-2xl rounded-2xl bg-white/95 backdrop-blur-lg border-accent/20"
            >
                <div class="mt-2">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h3 class="text-xl font-display font-bold text-[#1F2937] mb-1">
                                Record Details
                            </h3>
                            <p class="text-accent text-sm">
                                View complete record information
                            </p>
                        </div>
                        <button
                            @click="showViewModal = false"
                            class="view-modal-close text-2xl font-bold"
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
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <!-- Basic Info -->
                        <div class="space-y-2">
                            <div>
                                <label class="view-modal-label"
                                    >Record ID</label
                                >
                                <div class="view-modal-value">
                                    {{ viewRecord.id }}
                                </div>
                            </div>
                            <div>
                                <label class="view-modal-label">Supplier</label>
                                <div class="view-modal-value">
                                    {{ viewRecord.supplier_name }}
                                </div>
                            </div>
                            <div>
                                <label class="view-modal-label"
                                    >Date Created</label
                                >
                                <div class="view-modal-value">
                                    {{ viewRecord.created_at }}
                                </div>
                            </div>
                        </div>

                        <!-- Transport Details -->
                        <div class="space-y-2">
                            <div>
                                <label class="view-modal-label"
                                    >Lorry Amount</label
                                >
                                <div class="view-modal-value">
                                    {{
                                        formatCurrency(viewRecord.lorry_amount)
                                    }}
                                </div>
                            </div>
                            <div>
                                <label class="view-modal-label"
                                    >Lorry Units</label
                                >
                                <div class="view-modal-value">
                                    {{ viewRecord.lorry_units }} m³
                                </div>
                            </div>
                            <div>
                                <label class="view-modal-label"
                                    >Tractor Amount</label
                                >
                                <div class="view-modal-value">
                                    {{
                                        formatCurrency(
                                            viewRecord.tractor_amount
                                        )
                                    }}
                                </div>
                            </div>
                        </div>

                        <!-- More Details -->
                        <div class="space-y-2">
                            <div>
                                <label class="view-modal-label"
                                    >Tractor Units</label
                                >
                                <div class="view-modal-value">
                                    {{ viewRecord.tractor_units }} m³
                                </div>
                            </div>
                            <div>
                                <label class="view-modal-label"
                                    >Confirmed Cubic Meters</label
                                >
                                <div class="view-modal-value">
                                    {{ viewRecord.confirmed_cubic_meters }} m³
                                </div>
                            </div>
                            <div>
                                <label class="view-modal-label"
                                    >Extra Cubic</label
                                >
                                <div class="view-modal-value">
                                    {{ viewRecord.extra_cubic }} m³
                                </div>
                            </div>
                        </div>

                        <!-- Profit Details -->
                        <div class="space-y-2">
                            <div>
                                <label class="view-modal-label"
                                    >Less Cubic</label
                                >
                                <div class="view-modal-value">
                                    {{ viewRecord.less_cubic }} m³
                                </div>
                            </div>
                            <div>
                                <label class="view-modal-label"
                                    >Lorry Profit</label
                                >
                                <div class="view-modal-value">
                                    {{
                                        formatCurrency(
                                            viewRecord.expected_profit_lorry
                                        )
                                    }}
                                </div>
                            </div>
                            <div>
                                <label class="view-modal-label"
                                    >Tractor Profit</label
                                >
                                <div class="view-modal-value">
                                    {{
                                        formatCurrency(
                                            viewRecord.expected_profit_tractor
                                        )
                                    }}
                                </div>
                            </div>
                            <div>
                                <label class="view-modal-label"
                                    >Total Profit</label
                                >
                                <div
                                    class="view-modal-value view-modal-value-bold"
                                >
                                    {{
                                        formatCurrency(viewRecord.total_profit)
                                    }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Profit - Full Width -->
                    <div class="mt-3">
                        <label class="block text-sm font-medium text-gray-700 font-body"
                            >Total Expected Profit</label
                        >
                        <div
                            class="mt-1 text-base font-bold text-green-600 bg-green-50 px-3 py-2 rounded-lg"
                        >
                            {{
                                formatCurrency(viewRecord.total_expected_profit)
                            }}
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-end mt-4">
                        <button
                            @click="showViewModal = false"
                            class="view-modal-close py-2 px-5"
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
import Swal from "sweetalert2";
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
        field: "created_at_iso",
        sortable: true,
        filter: true, // changed from 'agDateColumnFilter'
        width: 160,
        valueFormatter: (params) => {
            // Show original human-readable date if available, else fallback
            return params.data && params.data.created_at
                ? params.data.created_at
                : params.value || "-";
        },
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

            const viewButton = `<button onclick="viewRecord(${params.data.id})" class="bg-gradient-to-r from-[#6B7280] to-[#4B5563] hover:from-[#4B5563] hover:to-[#374151] text-white font-semibold py-1.5 px-2.5 rounded-lg text-xs transition-all duration-200 shadow-sm hover:shadow-md" style="min-width: 45px; font-size: 10px;">
                View
            </button>`;

            const editButton = `<button onclick="editRecord(${params.data.id})" class="bg-gradient-to-r from-[#D4A373] to-[#C89363] hover:from-[#C89363] hover:to-[#B88353] text-white font-semibold py-1.5 px-2.5 rounded-lg text-xs transition-all duration-200 shadow-sm hover:shadow-md" style="min-width: 40px; font-size: 10px;">
                Edit
            </button>`;

            const deleteButton = isUserAdmin
                ? `<button onclick="deleteRecord(${params.data.id})" class="bg-gradient-to-r from-[#DC2626] to-[#B91C1C] hover:from-[#B91C1C] hover:to-[#991B1B] text-white font-semibold py-1.5 px-2.5 rounded-lg text-xs transition-all duration-200 shadow-sm hover:shadow-md" style="min-width: 45px; font-size: 10px;">
                    Delete
                </button>`
                : "";

            const buttonCount = isUserAdmin ? 3 : 2;
            const containerWidth = buttonCount === 3 ? "140px" : "95px";

            return `<div style="display: flex; gap: 3px; justify-content: center; align-items: center; height: 100%; width: ${containerWidth}; flex-wrap: nowrap; overflow: hidden;">${viewButton}${editButton}${deleteButton}</div>`;
        },
        flex: 0,
        width: 150,
        minWidth: 150,
        maxWidth: 150,
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

// --- Local rowData for AG Grid (reactive, like suppliers page) ---
const rowData = ref([]);

// Helper to map a record to the correct structure (numeric fields, etc.)
function mapRecord(record) {
    return {
        ...record,
        lorry_amount: Number(record.lorry_amount),
        lorry_units: Number(record.lorry_units),
        tractor_amount: Number(record.tractor_amount),
        tractor_units: Number(record.tractor_units),
        expected_profit_lorry: Number(record.expected_profit_lorry),
        expected_profit_tractor: Number(record.expected_profit_tractor),
        total_expected_profit: Number(record.total_expected_profit),
        confirmed_cubic_meters: Number(record.confirmed_cubic_meters),
        extra_cubic: Number(record.extra_cubic),
        less_cubic: Number(record.less_cubic),
        created_at_iso: record.created_at_iso || record.created_at, // fallback if needed
    };
}

// Watch for prop changes and keep rowData in sync (initial load or parent update)
watch(
    () => props.records,
    (newVal) => {
        rowData.value = newVal.map((record) => mapRecord(record));
    },
    { immediate: true }
);

// --- CRUD event handlers for real-time updates ---
const handleRecordCreated = (newRecord) => {
    console.log("[DEBUG] handleRecordCreated called with:", newRecord);
    if (newRecord && newRecord.id) {
        // Add new record and sort by created_at_iso descending (latest first)
        const filtered = rowData.value.filter((r) => r.id !== newRecord.id);
        const mapped = mapRecord(newRecord);
        console.log(
            "[DEBUG] rowData before add:",
            JSON.parse(JSON.stringify(rowData.value))
        );
        rowData.value = [...filtered, mapped].sort(
            (a, b) => new Date(b.created_at_iso) - new Date(a.created_at_iso)
        );
        console.log(
            "[DEBUG] rowData after add:",
            JSON.parse(JSON.stringify(rowData.value))
        );
    } else {
        console.warn(
            "[DEBUG] handleRecordCreated: newRecord missing id or is falsy",
            newRecord
        );
    }
    Swal.fire({
        icon: "success",
        title: "Record Created!",
        text: "The record was created successfully.",
        background: "#fff",
        color: "#1F2937",
        confirmButtonColor: "#D4A373",
        customClass: {
            popup: "rounded-2xl shadow-2xl border border-accent/20",
            title: "font-bold text-2xl text-accent",
            confirmButton: "rounded-xl px-6 py-2 font-semibold",
        },
        buttonsStyling: false,
    });
};

const handleRecordUpdated = (updatedRecord) => {
    console.log("[DEBUG] handleRecordUpdated called with:", updatedRecord);
    if (updatedRecord && updatedRecord.id) {
        const before = JSON.parse(JSON.stringify(rowData.value));
        rowData.value = rowData.value
            .map((r) =>
                r.id === updatedRecord.id ? mapRecord(updatedRecord) : r
            )
            .sort(
                (a, b) =>
                    new Date(b.created_at_iso) - new Date(a.created_at_iso)
            );
        const after = JSON.parse(JSON.stringify(rowData.value));
        console.log("[DEBUG] rowData before update:", before);
        console.log("[DEBUG] rowData after update:", after);
    } else {
        console.warn(
            "[DEBUG] handleRecordUpdated: updatedRecord missing id or is falsy",
            updatedRecord
        );
    }
    Swal.fire({
        icon: "success",
        title: "Record Updated!",
        text: "The record was updated successfully.",
        background: "#fff",
        color: "#1F2937",
        confirmButtonColor: "#D4A373",
        customClass: {
            popup: "rounded-2xl shadow-2xl border border-accent/20",
            title: "font-bold text-2xl text-accent",
            confirmButton: "rounded-xl px-6 py-2 font-semibold",
        },
        buttonsStyling: false,
    });
    selectedRecord.value = {}; // Clear selected record
};

window.deleteRecord = async (id) => {
    if (!isAdmin.value) {
        Swal.fire({
            icon: "error",
            title: "Permission Denied",
            text: "You don't have permission to delete records.",
            background: "#fff",
            color: "#1F2937",
            confirmButtonColor: "#D4A373",
            customClass: {
                popup: "rounded-2xl shadow-2xl border border-accent/20",
                title: "font-bold text-2xl text-accent",
                confirmButton: "rounded-xl px-6 py-2 font-semibold",
            },
            buttonsStyling: false,
        });
        return;
    }
    const result = await Swal.fire({
        title: "Are you sure?",
        text: "This will permanently delete the record.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DC2626",
        cancelButtonColor: "#d1d5db",
        confirmButtonText: "Yes, delete it!",
        background: "#fff",
        color: "#1F2937",
        customClass: {
            popup: "rounded-2xl shadow-2xl border border-accent/20",
            title: "font-bold text-2xl text-[#1F2937]",
            confirmButton: "rounded-xl px-6 py-2 font-semibold",
        },
        buttonsStyling: false,
    });
    if (result.isConfirmed) {
        let deleteLoadingSwal;
        try {
            deleteLoadingSwal = Swal.fire({
                title: "Deleting...",
                text: "Please wait while the record is being deleted.",
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                },
                background: "#fff",
                color: "#1F2937",
                customClass: {
                    popup: "rounded-2xl shadow-2xl border border-accent/20",
                    title: "font-bold text-2xl text-accent",
                    confirmButton: "rounded-xl px-6 py-2 font-semibold",
                },
                buttonsStyling: false,
            });
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
                // Remove the deleted record from rowData
                rowData.value = rowData.value.filter((r) => r.id !== id);
                Swal.fire({
                    icon: "success",
                    title: "Record Deleted!",
                    text: "The record was deleted successfully.",
                    background: "#fff",
                    color: "#1F2937",
                    confirmButtonColor: "#D4A373",
                    customClass: {
                        popup: "rounded-2xl shadow-2xl border border-accent/20",
                        title: "font-bold text-2xl text-accent",
                        confirmButton: "rounded-xl px-6 py-2 font-semibold",
                    },
                    buttonsStyling: false,
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: "Error deleting record.",
                    background: "#fff",
                    color: "#1F2937",
                    confirmButtonColor: "#D4A373",
                    customClass: {
                        popup: "rounded-2xl shadow-2xl border border-accent/20",
                        title: "font-bold text-2xl text-accent",
                        confirmButton: "rounded-xl px-6 py-2 font-semibold",
                    },
                    buttonsStyling: false,
                });
            }
        } catch (error) {
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: "Error deleting record.",
                background: "#fff",
                color: "#1F2937",
                confirmButtonColor: "#D4A373",
                customClass: {
                    popup: "rounded-2xl shadow-2xl border border-accent/20",
                    title: "font-bold text-2xl text-accent",
                    confirmButton: "rounded-xl px-6 py-2 font-semibold",
                },
                buttonsStyling: false,
            });
        }
    }
};

window.editRecord = function (id) {
    const record = filteredRecords.value.find((r) => r.id === id);
    if (record) {
        selectedRecord.value = { ...record };
        showEditModal.value = true;
    }
};
window.viewRecord = function (id) {
    const record = filteredRecords.value.find((r) => r.id === id);
    if (record) {
        viewRecord.value = { ...record };
        showViewModal.value = true;
    }
};

// --- Use rowData for AG Grid ---
const filteredRecords = computed(() => {
    let mapped = rowData.value.map((record) => {
        // Ensure numeric fields are numbers
        return {
            ...record,
            lorry_amount: Number(record.lorry_amount),
            lorry_units: Number(record.lorry_units),
            tractor_amount: Number(record.tractor_amount),
            tractor_units: Number(record.tractor_units),
            expected_profit_lorry: Number(record.expected_profit_lorry),
            expected_profit_tractor: Number(record.expected_profit_tractor),
            total_expected_profit: Number(record.total_expected_profit),
            confirmed_cubic_meters: Number(record.confirmed_cubic_meters),
            extra_cubic: Number(record.extra_cubic),
            less_cubic: Number(record.less_cubic),
        };
    });
    let filtered = [...mapped];
    // Date range filter (robust: only filter if valid date)
    if (filters.value.dateFrom && !isNaN(Date.parse(filters.value.dateFrom))) {
        filtered = filtered.filter((record) => {
            if (!record.created_at_iso) return false;
            const recordDate = new Date(record.created_at_iso);
            const fromDate = new Date(filters.value.dateFrom);
            return recordDate >= fromDate;
        });
    }
    if (filters.value.dateTo && !isNaN(Date.parse(filters.value.dateTo))) {
        filtered = filtered.filter((record) => {
            if (!record.created_at_iso) return false;
            const recordDate = new Date(record.created_at_iso);
            const toDate = new Date(filters.value.dateTo);
            toDate.setDate(toDate.getDate() + 1);
            return recordDate < toDate;
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
            (record) =>
                Number(record.total_expected_profit) >= filters.value.minAmount
        );
    }
    if (filters.value.maxAmount !== null && filters.value.maxAmount !== "") {
        filtered = filtered.filter(
            (record) =>
                Number(record.total_expected_profit) <= filters.value.maxAmount
        );
    }
    // Always sort by full datetime (created_at_iso) descending (latest at top)
    const sorted = filtered.sort((a, b) => {
        if (!a.created_at_iso && !b.created_at_iso) return 0;
        if (!a.created_at_iso) return 1;
        if (!b.created_at_iso) return -1;
        return (
            new Date(b.created_at_iso).getTime() -
            new Date(a.created_at_iso).getTime()
        );
    });
    // Convert proxies to plain objects for AG Grid
    return sorted.map((r) => JSON.parse(JSON.stringify(r)));
});

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

// Add clearFilters function to reset all filters
const clearFilters = () => {
    filters.value.dateFrom = "";
    filters.value.dateTo = "";
    filters.value.supplierIds = [];
    filters.value.minAmount = null;
    filters.value.maxAmount = null;
    selectedSuppliers.value = [];
    supplierSearch.value = "";
};

function formatCurrency(value) {
    if (value == null || isNaN(value)) return "-";
    return (
        "KES " +
        Number(value).toLocaleString("en-KE", {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        })
    );
}
</script>

<style>
.modern-grid .ag-header {
    font-weight: 600;
    font-size: 14px;
}

.modern-grid .ag-cell {
    display: flex;
    align-items: center;
    padding: 12px 16px;
}

.modern-grid .ag-row {
    border: none;
    border-bottom: 1px solid #D1D5DB;
    background: transparent;
    transition: background 0.2s;
}

.modern-grid .ag-row:hover {
    background: rgba(212, 163, 115, 0.1);
}

.modern-grid .ag-root-wrapper {
    border-radius: 12px;
    overflow: hidden;
}

.modern-grid .ag-paging-panel {
    border-top: 1px solid #D1D5DB;
    background-color: #FAF4F2;
    padding: 16px;
}

/* Modern filter and button styles */
.records-filters .ag-input,
.records-filters input[type="date"],
.records-filters input[type="number"] {
    border-radius: 0.5rem;
    border: 1px solid #D1D5DB;
    background: #fff;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    transition: border 0.2s, box-shadow 0.2s;
}
.records-filters input:focus {
    border-color: #D4A373;
    box-shadow: 0 0 0 2px rgba(212, 163, 115, 0.2);
}
.records-filters label {
    color: #1F2937;
    font-weight: 600;
}
.records-filters .modern-btn {
    background: linear-gradient(to right, #D4A373, #C89363);
    color: #fff;
    border-radius: 0.5rem;
    font-weight: 600;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
}
.records-filters .modern-btn:hover {
    background: linear-gradient(to right, #C89363, #B88353);
    box-shadow: 0 2px 6px 0 rgba(0, 0, 0, 0.15);
    transform: scale(1.01);
}

/* Responsive and modern improvements for records section */
@media (max-width: 1024px) {
    .modern-grid .ag-header,
    .modern-grid .ag-cell {
        font-size: 13px;
        padding: 10px 8px;
    }
    .records-filters {
        padding: 1rem !important;
    }
}
@media (max-width: 640px) {
    .modern-grid .ag-header,
    .modern-grid .ag-cell {
        font-size: 12px;
        padding: 8px 4px;
    }
    .modern-grid .ag-root-wrapper {
        border-radius: 10px;
    }
    .records-filters {
        padding: 0.5rem !important;
        border-radius: 1rem !important;
    }
    .records-filters .modern-btn {
        font-size: 0.95rem;
        padding: 0.6rem 1rem;
    }
}

/* Modern modal button for view modal */
.view-modal-close {
    background: linear-gradient(to right, #D4A373, #C89363);
    color: #fff;
    border-radius: 0.5rem;
    font-weight: 600;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
}
.view-modal-close:hover {
    background: linear-gradient(to right, #C89363, #B88353);
    box-shadow: 0 2px 6px 0 rgba(0, 0, 0, 0.15);
    transform: scale(1.01);
}

/* Modern modal field styles */
.view-modal-label {
    color: #1F2937;
    font-weight: 600;
}
.view-modal-value {
    background: #FAF4F2;
    color: #1F2937;
    border-radius: 0.5rem;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    margin-top: 0.25rem;
}
.view-modal-value-bold {
    background: rgba(212, 163, 115, 0.1);
    color: #D4A373;
    font-weight: bold;
}
</style>
