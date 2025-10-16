<template>
    <Head title="Reports" />
    <AuthenticatedLayout>
        <div class="bg-primary min-h-screen">
            <div class="mx-auto max-w-6xl">
                <div
                    class="overflow-hidden bg-white/90 backdrop-blur-lg shadow-xl sm:rounded-xl border border-accent/20"
                >
                    <div class="p-4 text-gray-900">
                        <h2
                            class="text-xl font-display font-bold mb-3 text-[#1F2937]"
                        >
                            Records Reports
                        </h2>

                        <!-- Filters Section -->
                        <div
                            class="reports-filters mb-3 p-3 bg-gradient-to-r from-primary to-white rounded-lg border border-accent/20 shadow-sm"
                        >
                            <h3 class="text-base font-display font-semibold mb-2 text-[#1F2937]">
                                Filters
                            </h3>
                            <div class="grid grid-cols-1 gap-4">
                                <!-- Supplier Filter -->
                                <div class="col-span-full">
                                    <label
                                        class="block text-sm font-medium mb-2"
                                    >
                                        Suppliers (Multiple Selection)
                                    </label>
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
                                                class="absolute right-2 top-1/2 transform -translate-y-1/2 text-accent/60 hover:text-accent-hover text-xl"
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
                                                    class="px-3 py-2 cursor-pointer hover:bg-accent/10 flex items-center justify-between rounded-lg mx-1 transition duration-200"
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
                            </div>

                            <!-- Time Period Filters -->
                            <div
                                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4 mt-4"
                            >
                                <!-- Year Filter -->
                                <div>
                                    <label
                                        class="block text-sm font-medium mb-2"
                                    >
                                        Select Year
                                    </label>
                                    <select
                                        v-model="filters.selectedYear"
                                        @change="updateFromYear"
                                        class="w-full modern-input"
                                    >
                                        <option value="">Select Year</option>
                                        <option
                                            v-for="year in availableYears"
                                            :key="year"
                                            :value="year"
                                        >
                                            {{ year }}
                                        </option>
                                    </select>
                                </div>

                                <!-- Month Filter -->
                                <div>
                                    <label
                                        class="block text-sm font-medium mb-2"
                                    >
                                        Select Month
                                    </label>
                                    <select
                                        v-model="filters.selectedMonth"
                                        @change="updateFromMonth"
                                        :disabled="!filters.selectedYear"
                                        class="w-full modern-input disabled:bg-gray-100"
                                    >
                                        <option value="">Select Month</option>
                                        <option
                                            v-for="month in availableMonths"
                                            :key="month.value"
                                            :value="month.value"
                                        >
                                            {{ month.name }}
                                        </option>
                                    </select>
                                </div>

                                <!-- Week Filter -->
                                <div>
                                    <label
                                        class="block text-sm font-medium mb-2"
                                    >
                                        Select Week
                                    </label>
                                    <select
                                        v-model="filters.selectedWeek"
                                        @change="updateFromWeek"
                                        :disabled="!filters.selectedMonth"
                                        class="w-full modern-input disabled:bg-gray-100"
                                    >
                                        <option value="">Select Week</option>
                                        <option
                                            v-for="week in availableWeeks"
                                            :key="week.value"
                                            :value="week.value"
                                        >
                                            {{ week.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Date Range Filters -->
                            <div
                                class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4"
                            >
                                <!-- Date From Filter -->
                                <div>
                                    <label
                                        class="block text-sm font-medium mb-2"
                                    >
                                        Date From
                                    </label>
                                    <input
                                        type="date"
                                        v-model="filters.dateFrom"
                                        class="w-full modern-input"
                                    />
                                </div>

                                <!-- Date To Filter -->
                                <div>
                                    <label
                                        class="block text-sm font-medium mb-2"
                                    >
                                        Date To
                                    </label>
                                    <input
                                        type="date"
                                        v-model="filters.dateTo"
                                        class="w-full modern-input"
                                    />
                                </div>
                            </div>

                            <!-- Filter Actions -->
                            <div class="mt-4 flex flex-wrap gap-2 sm:gap-4">
                                <button
                                    @click="applyFilters"
                                    class="modern-btn py-2 px-4 flex-shrink-0"
                                >
                                    Apply Filters
                                </button>
                                <button
                                    @click="clearFilters"
                                    class="modern-btn bg-gray-500 hover:bg-gray-700 py-2 px-4 flex-shrink-0"
                                >
                                    Clear Filters
                                </button>
                                <button
                                    @click="downloadPDF"
                                    :disabled="isDownloading"
                                    class="modern-btn bg-green-500 hover:bg-green-700 py-2 px-4 flex-shrink-0 disabled:opacity-50"
                                >
                                    {{
                                        isDownloading
                                            ? "Generating..."
                                            : "Download PDF"
                                    }}
                                </button>
                                <button
                                    @click="downloadExcel"
                                    :disabled="isDownloading"
                                    class="modern-btn bg-blue-500 hover:bg-blue-700 py-2 px-4 flex-shrink-0 disabled:opacity-50"
                                >
                                    {{
                                        isDownloading
                                            ? "Generating..."
                                            : "Download Excel"
                                    }}
                                </button>
                            </div>
                        </div>

                        <!-- Summary Section -->
                        <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                            <h3 class="text-lg font-semibold mb-2">Summary</h3>
                            <div
                                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4"
                            >
                                <div class="text-center sm:text-left">
                                    <span class="text-sm text-gray-600"
                                        >Total Records:</span
                                    >
                                    <span
                                        class="text-xl font-bold ml-2 block sm:inline"
                                        >{{ filteredRecords.length }}</span
                                    >
                                </div>
                                <div class="text-center sm:text-left">
                                    <span class="text-sm text-gray-600"
                                        >Total Expected Profit:</span
                                    >
                                    <span
                                        class="text-xl font-bold ml-2 block sm:inline"
                                        >{{ formatCurrency(totalProfit) }}</span
                                    >
                                </div>
                                <div class="text-center sm:text-left">
                                    <span class="text-sm text-gray-600"
                                        >Average Profit per Record:</span
                                    >
                                    <span
                                        class="text-xl font-bold ml-2 block sm:inline"
                                        >{{
                                            formatCurrency(averageProfit)
                                        }}</span
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Records Table -->
                        <div
                            class="rounded-xl overflow-hidden border border-accent/20 shadow-sm"
                        >
                            <ag-grid-vue
                                class="ag-theme-alpine modern-grid"
                                style="
                                    width: 100%;
                                    --ag-grid-size: 8px;
                                    --ag-border-color: rgb(254 202 202);
                                    --ag-header-background-color: rgb(
                                        254 242 242
                                    );
                                    --ag-header-foreground-color: rgb(
                                        127 29 29
                                    );
                                    --ag-odd-row-background-color: rgb(
                                        255 255 255
                                    );
                                    --ag-row-hover-color: rgb(254 242 242);
                                "
                                :domLayout="'autoHeight'"
                                :columnDefs="columnDefs"
                                :rowData="filteredRecords"
                                :defaultColDef="defaultColDef"
                                :pagination="true"
                                :paginationPageSize="20"
                                :paginationPageSizeSelector="
                                    paginationPageSizeSelector
                                "
                                theme="legacy"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import { Head, router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { AgGridVue } from "ag-grid-vue3";
import { ModuleRegistry, AllCommunityModule } from "ag-grid-community";
import Swal from "sweetalert2";
ModuleRegistry.registerModules([AllCommunityModule]);
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-alpine.css";

const props = defineProps({
    suppliers: {
        type: Array,
        default: () => [],
    },
    records: {
        type: Array,
        default: () => [],
    },
});

const filters = ref({
    supplierIds: [],
    dateFrom: "",
    dateTo: "",
    selectedWeek: "",
    selectedMonth: "",
    selectedYear: "",
});

const isDownloading = ref(false);
const allRecords = ref(props.records);
const filteredRecords = ref(props.records);

// Multiselect dropdown variables
const supplierSearch = ref("");
const showSupplierDropdown = ref(false);
const selectedSuppliers = ref([]);
let hideDropdownTimeout = null;

// Pagination options
const paginationPageSizeSelector = ref([10, 20, 50, 100]);

// AG Grid column definitions
const columnDefs = ref([
    {
        headerName: "ID",
        field: "id",
        sortable: true,
        filter: true,
        flex: 0.5,
        minWidth: 70,
    },
    {
        headerName: "Supplier",
        field: "supplier_name",
        sortable: true,
        filter: true,
        flex: 1.5,
        minWidth: 150,
    },
    {
        headerName: "Date Created",
        field: "created_at",
        sortable: true,
        filter: true,
        flex: 1,
        minWidth: 120,
        valueFormatter: (params) => formatDate(params.value),
    },
    {
        headerName: "Lorry Units",
        field: "lorry_units",
        sortable: true,
        filter: true,
        flex: 0.8,
        minWidth: 100,
        valueFormatter: (params) => `${params.value} m³`,
    },
    {
        headerName: "Tractor Units",
        field: "tractor_units",
        sortable: true,
        filter: true,
        flex: 0.8,
        minWidth: 100,
        valueFormatter: (params) => `${params.value} m³`,
    },
    {
        headerName: "Lorry Profit",
        field: "expected_profit_lorry",
        sortable: true,
        filter: true,
        flex: 1,
        minWidth: 120,
        valueFormatter: (params) => formatCurrency(params.value),
    },
    {
        headerName: "Tractor Profit",
        field: "expected_profit_tractor",
        sortable: true,
        filter: true,
        flex: 1,
        minWidth: 120,
        valueFormatter: (params) => formatCurrency(params.value),
    },
    {
        headerName: "Total Profit",
        field: "total_expected_profit",
        sortable: true,
        filter: true,
        flex: 1,
        minWidth: 120,
        valueFormatter: (params) => formatCurrency(params.value),
    },
    {
        headerName: "Confirmed m³",
        field: "confirmed_cubic_meters",
        sortable: true,
        filter: true,
        flex: 0.8,
        minWidth: 100,
        valueFormatter: (params) => `${params.value} m³`,
    },
]);

const defaultColDef = ref({
    resizable: true,
    sortable: true,
    filter: true,
});

// Currency formatting function
const formatCurrency = (amount) => {
    return new Intl.NumberFormat("en-KE", {
        style: "currency",
        currency: "KES",
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    }).format(amount || 0);
};

// Helper function to format date as "25 June 2024"
const formatDate = (dateString) => {
    const date = new Date(dateString);
    const options = { day: "numeric", month: "long", year: "numeric" };
    return date.toLocaleDateString("en-GB", options);
};

// Computed properties for summary
const totalProfit = computed(() => {
    return filteredRecords.value.reduce(
        (sum, record) => sum + (parseFloat(record.total_expected_profit) || 0),
        0
    );
});

const averageProfit = computed(() => {
    return filteredRecords.value.length > 0
        ? totalProfit.value / filteredRecords.value.length
        : 0;
});

// Available years for the year filter
const availableYears = computed(() => {
    const currentYear = new Date().getFullYear();
    const years = [];
    for (let year = currentYear - 5; year <= currentYear + 1; year++) {
        years.push(year);
    }
    return years;
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
};

const clearAllSuppliers = () => {
    selectedSuppliers.value = [];
    filters.value.supplierIds = [];
    supplierSearch.value = "";
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

// Available months for the month filter (only when year is selected)
const availableMonths = computed(() => {
    if (!filters.value.selectedYear) return [];

    const months = [
        { value: 1, name: "January" },
        { value: 2, name: "February" },
        { value: 3, name: "March" },
        { value: 4, name: "April" },
        { value: 5, name: "May" },
        { value: 6, name: "June" },
        { value: 7, name: "July" },
        { value: 8, name: "August" },
        { value: 9, name: "September" },
        { value: 10, name: "October" },
        { value: 11, name: "November" },
        { value: 12, name: "December" },
    ];

    return months;
});

// Available weeks for the week filter (only when month is selected)
const availableWeeks = computed(() => {
    if (!filters.value.selectedYear || !filters.value.selectedMonth) return [];

    const year = parseInt(filters.value.selectedYear);
    const month = parseInt(filters.value.selectedMonth);

    // Get the number of days in the month
    const daysInMonth = new Date(year, month, 0).getDate();

    const weeks = [];
    let weekNumber = 1;
    let currentDay = 1;

    while (currentDay <= daysInMonth) {
        const weekStartDay = currentDay;

        // Find the end of the week (Saturday)
        const weekStartDate = new Date(year, month - 1, weekStartDay);
        const daysToSaturday = (6 - weekStartDate.getDay()) % 7;
        let weekEndDay = weekStartDay + daysToSaturday;

        // If week end exceeds month, set it to last day of month
        if (weekEndDay > daysInMonth) {
            weekEndDay = daysInMonth;
        }

        weeks.push({
            value: `${year}-${String(month).padStart(2, "0")}-W${weekNumber}`,
            name: `Week ${weekNumber} (${weekStartDay}-${weekEndDay})`,
        });

        // Move to next week (Sunday)
        currentDay = weekEndDay + 1;
        weekNumber++;
    }

    return weeks;
});

// Computed properties to display dates in dd/mm/yyyy format
const displayDateFrom = computed(() => {
    if (!filters.value.dateFrom) return "";
    // Parse the YYYY-MM-DD format correctly
    const [year, month, day] = filters.value.dateFrom.split("-");
    return `${day}/${month}/${year}`;
});

const displayDateTo = computed(() => {
    if (!filters.value.dateTo) return "";
    // Parse the YYYY-MM-DD format correctly
    const [year, month, day] = filters.value.dateTo.split("-");
    return `${day}/${month}/${year}`;
});

// Time period filter methods
const updateFromYear = () => {
    if (filters.value.selectedYear) {
        // Clear dependent filters
        filters.value.selectedMonth = "";
        filters.value.selectedWeek = "";

        // Set date range to entire year (Jan 1 to Dec 31)
        const year = parseInt(filters.value.selectedYear);

        // Format dates as YYYY-MM-DD strings to avoid timezone issues
        filters.value.dateFrom = `${year}-01-01`;
        filters.value.dateTo = `${year}-12-31`;
    } else {
        // Clear all time-related filters
        filters.value.selectedMonth = "";
        filters.value.selectedWeek = "";
        filters.value.dateFrom = "";
        filters.value.dateTo = "";
    }
};

const updateFromMonth = () => {
    if (filters.value.selectedMonth && filters.value.selectedYear) {
        // Clear dependent filters
        filters.value.selectedWeek = "";

        // Set date range to entire month
        const year = parseInt(filters.value.selectedYear);
        const month = parseInt(filters.value.selectedMonth);

        // Get the number of days in the month
        const daysInMonth = new Date(year, month, 0).getDate();

        // Format dates as YYYY-MM-DD strings
        const monthStr = String(month).padStart(2, "0");
        filters.value.dateFrom = `${year}-${monthStr}-01`;
        filters.value.dateTo = `${year}-${monthStr}-${String(
            daysInMonth
        ).padStart(2, "0")}`;
    }
};

const updateFromWeek = () => {
    if (
        filters.value.selectedWeek &&
        filters.value.selectedMonth &&
        filters.value.selectedYear
    ) {
        const year = parseInt(filters.value.selectedYear);
        const month = parseInt(filters.value.selectedMonth);

        // Parse week number from the value
        const weekMatch = filters.value.selectedWeek.match(/W(\d+)$/);
        if (weekMatch) {
            const weekNumber = parseInt(weekMatch[1]);

            // Calculate the date range for this week within the month using string manipulation
            let currentDay = 1;
            let currentWeek = 1;

            // Find the start of the selected week
            while (currentWeek < weekNumber) {
                // Create date for current day to check day of week
                const tempDate = new Date(year, month - 1, currentDay);

                // Find the end of current week (Saturday)
                const daysToSaturday = (6 - tempDate.getDay()) % 7;
                currentDay += daysToSaturday + 1; // Move to next Sunday
                currentWeek++;
            }

            const weekStartDay = currentDay;

            // Find the end of the week (Saturday)
            const weekStartDate = new Date(year, month - 1, weekStartDay);
            const daysToSaturday = (6 - weekStartDate.getDay()) % 7;
            let weekEndDay = weekStartDay + daysToSaturday;

            // Ensure we don't go beyond the month
            const daysInMonth = new Date(year, month, 0).getDate();
            if (weekEndDay > daysInMonth) {
                weekEndDay = daysInMonth;
            }

            // Format dates as YYYY-MM-DD strings
            const monthStr = String(month).padStart(2, "0");
            const startDayStr = String(weekStartDay).padStart(2, "0");
            const endDayStr = String(weekEndDay).padStart(2, "0");

            filters.value.dateFrom = `${year}-${monthStr}-${startDayStr}`;
            filters.value.dateTo = `${year}-${monthStr}-${endDayStr}`;
        }
    }
};

// Apply filters function
const applyFilters = () => {
    let filtered = [...allRecords.value];

    // Filter by suppliers
    if (filters.value.supplierIds.length > 0) {
        filtered = filtered.filter((record) =>
            filters.value.supplierIds.includes(record.supplier_id)
        );
    }

    // Filter by date range
    if (filters.value.dateFrom) {
        filtered = filtered.filter((record) => {
            const recordDate = new Date(record.created_at);
            const fromDate = new Date(filters.value.dateFrom);
            recordDate.setHours(0, 0, 0, 0);
            fromDate.setHours(0, 0, 0, 0);
            return recordDate >= fromDate;
        });
    }

    if (filters.value.dateTo) {
        filtered = filtered.filter((record) => {
            const recordDate = new Date(record.created_at);
            const toDate = new Date(filters.value.dateTo);
            recordDate.setHours(23, 59, 59, 999);
            toDate.setHours(23, 59, 59, 999);
            return recordDate <= toDate;
        });
    }

    // Sort by created_at (newest first)
    filtered.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

    filteredRecords.value = filtered;

    // Show alert if no records found
    if (filtered.length === 0) {
        Swal.fire({
            icon: "info",
            title: "No Records Found",
            text: "No records match your current filter criteria. Please adjust your filters and try again.",
            confirmButtonColor: "#3b82f6",
        });
    }
};

// Clear filters function
const clearFilters = () => {
    filters.value = {
        supplierIds: [],
        dateFrom: "",
        dateTo: "",
        selectedWeek: "",
        selectedMonth: "",
        selectedYear: "",
    };
    selectedSuppliers.value = [];
    supplierSearch.value = "";
    filteredRecords.value = [...allRecords.value];
};

// Download PDF function
const downloadPDF = async () => {
    isDownloading.value = true;

    try {
        // Create a form and submit it to avoid CSRF issues with file downloads
        const form = document.createElement("form");
        form.method = "POST";
        form.action = "/reports/pdf";
        form.style.display = "none";

        // Add CSRF token
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute("content");

        if (!csrfToken) {
            await Swal.fire({
                icon: "error",
                title: "CSRF Token Missing",
                text: "CSRF token not found. Please refresh the page and try again.",
                confirmButtonColor: "#3b82f6",
            });
            return;
        }

        const csrfInput = document.createElement("input");
        csrfInput.type = "hidden";
        csrfInput.name = "_token";
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);

        // Add supplier_ids
        if (filters.value.supplierIds && filters.value.supplierIds.length > 0) {
            filters.value.supplierIds.forEach((id) => {
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "supplier_ids[]";
                input.value = id;
                form.appendChild(input);
            });
        }

        // Add date_from
        if (filters.value.dateFrom) {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "date_from";
            input.value = filters.value.dateFrom;
            form.appendChild(input);
        }

        // Add date_to
        if (filters.value.dateTo) {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "date_to";
            input.value = filters.value.dateTo;
            form.appendChild(input);
        }

        // First check if there are any records before attempting download
        const checkResponse = await fetch("/reports/check", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify({
                supplier_ids: filters.value.supplierIds,
                date_from: filters.value.dateFrom,
                date_to: filters.value.dateTo,
            }),
        });

        if (checkResponse.status === 422) {
            const errorData = await checkResponse.json();
            await Swal.fire({
                icon: "warning",
                title: "No Records Found",
                text:
                    errorData.message ||
                    "No records match your current filter criteria. Please adjust your filters and try again.",
                confirmButtonColor: "#3b82f6",
            });
            return;
        }

        if (!checkResponse.ok) {
            await Swal.fire({
                icon: "error",
                title: "Error",
                text: "Error checking records. Please try again.",
                confirmButtonColor: "#3b82f6",
            });
            return;
        }

        // If check passes, submit the form for download
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    } catch (error) {
        console.error("Error:", error);
        await Swal.fire({
            icon: "error",
            title: "Error",
            text: "Error generating PDF report. Please try again.",
            confirmButtonColor: "#3b82f6",
        });
    } finally {
        isDownloading.value = false;
    }
};

// Download Excel function
const downloadExcel = async () => {
    isDownloading.value = true;

    try {
        // Create a form and submit it to avoid CSRF issues with file downloads
        const form = document.createElement("form");
        form.method = "POST";
        form.action = "/reports/excel";
        form.style.display = "none";

        // Add CSRF token
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute("content");

        if (!csrfToken) {
            await Swal.fire({
                icon: "error",
                title: "CSRF Token Missing",
                text: "CSRF token not found. Please refresh the page and try again.",
                confirmButtonColor: "#3b82f6",
            });
            return;
        }

        const csrfInput = document.createElement("input");
        csrfInput.type = "hidden";
        csrfInput.name = "_token";
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);

        // Add supplier_ids
        if (filters.value.supplierIds && filters.value.supplierIds.length > 0) {
            filters.value.supplierIds.forEach((id) => {
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "supplier_ids[]";
                input.value = id;
                form.appendChild(input);
            });
        }

        // Add date_from
        if (filters.value.dateFrom) {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "date_from";
            input.value = filters.value.dateFrom;
            form.appendChild(input);
        }

        // Add date_to
        if (filters.value.dateTo) {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "date_to";
            input.value = filters.value.dateTo;
            form.appendChild(input);
        }

        // First check if there are any records before attempting download
        const checkResponse = await fetch("/reports/check", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify({
                supplier_ids: filters.value.supplierIds,
                date_from: filters.value.dateFrom,
                date_to: filters.value.dateTo,
            }),
        });

        if (checkResponse.status === 422) {
            const errorData = await checkResponse.json();
            await Swal.fire({
                icon: "warning",
                title: "No Records Found",
                text:
                    errorData.message ||
                    "No records match your current filter criteria. Please adjust your filters and try again.",
                confirmButtonColor: "#3b82f6",
            });
            return;
        }

        if (!checkResponse.ok) {
            await Swal.fire({
                icon: "error",
                title: "Error",
                text: "Error checking records. Please try again.",
                confirmButtonColor: "#3b82f6",
            });
            return;
        }

        // If check passes, submit the form for download
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    } catch (error) {
        console.error("Error:", error);
        await Swal.fire({
            icon: "error",
            title: "Error",
            text: "Error generating Excel report. Please try again.",
            confirmButtonColor: "#3b82f6",
        });
    } finally {
        isDownloading.value = false;
    }
};

// Watch for prop changes
watch(
    () => props.records,
    (newRecords) => {
        allRecords.value = newRecords;
        applyFilters(); // Reapply filters when data changes
    }
);

// Initialize with all records
applyFilters();
</script>

<style scoped>
/* Custom styles for the multiselect dropdown */
.relative input:focus + .absolute {
    display: block;
}

.cursor-pointer:hover {
    background-color: #fef2f2;
}

/* Ensure dropdown appears above other elements */
.z-10 {
    z-index: 10;
}

/* Modern AG Grid styles for reports */
.ag-theme-alpine.modern-grid .ag-header {
    font-weight: 600;
    font-size: 14px;
}
.ag-theme-alpine.modern-grid .ag-cell {
    display: flex;
    align-items: center;
    padding: 12px 16px;
}
.ag-theme-alpine.modern-grid .ag-row {
    border: none;
    border-bottom: 1px solid rgb(254 202 202);
    background: transparent;
    transition: background 0.2s;
}
.ag-theme-alpine.modern-grid .ag-row:hover {
    background: rgb(254 242 242);
}
.ag-theme-alpine.modern-grid .ag-root-wrapper {
    border-radius: 12px;
    overflow: hidden;
}
.ag-theme-alpine.modern-grid .ag-paging-panel {
    border-top: 1px solid rgb(254 202 202);
    background-color: rgb(254 242 242);
    padding: 16px;
}

/* Modern filter and button styles for reports */
.reports-filters .ag-input,
.reports-filters input[type="date"],
.reports-filters select {
    border-radius: 0.75rem;
    border: 1px solid #fecaca;
    background: #fff;
    box-shadow: 0 2px 8px 0 #fca5a5, 0 1.5px 4px 0 #fca5a5;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: border 0.2s, box-shadow 0.2s;
}

.reports-filters input:focus,
.reports-filters select:focus {
    border-color: #b91c1c;
    box-shadow: 0 0 0 2px #fecaca;
}

.reports-filters label {
    color: #7f1d1d;
    font-weight: 600;
}

.reports-filters .modern-btn {
    background: linear-gradient(to right, #dc2626, #b91c1c);
    color: #fff;
    border-radius: 0.75rem;
    font-weight: 600;
    box-shadow: 0 2px 8px 0 #fca5a5;
    transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
}

.reports-filters .modern-btn:hover {
    background: linear-gradient(to right, #b91c1c, #7f1d1d);
    box-shadow: 0 4px 16px 0 #fca5a5;
    transform: scale(1.03);
}

@media (max-width: 1024px) {
    .ag-theme-alpine .ag-header,
    .ag-theme-alpine .ag-cell {
        font-size: 13px;
        padding: 10px 8px;
    }

    .reports-filters {
        padding: 1rem !important;
    }
}

@media (max-width: 640px) {
    .ag-theme-alpine .ag-header,
    .ag-theme-alpine .ag-cell {
        font-size: 12px;
        padding: 8px 4px;
    }

    .ag-theme-alpine .ag-root-wrapper {
        border-radius: 10px;
    }

    .reports-filters {
        padding: 0.5rem !important;
        border-radius: 1rem !important;
    }

    .reports-filters .modern-btn {
        font-size: 0.95rem;
        padding: 0.6rem 1rem;
    }
}
</style>
