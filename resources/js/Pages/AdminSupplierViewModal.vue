<template>
    <Head title="Suppliers" />
    <AuthenticatedLayout>
        <div
            class="p-6 sm:p-8 lg:p-10 bg-gradient-to-br from-red-50 via-white to-red-50 min-h-screen"
        >
            <div class="mx-auto max-w-7xl">
                <!-- Page Header (copied from Staff page for consistency) -->
                <div class="mb-8">
                    <div
                        class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-lg border border-red-200/50 p-6"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <h1
                                    class="text-3xl font-bold text-red-900 mb-2"
                                >
                                    Supplier Management
                                </h1>
                                <p class="text-red-600 font-medium">
                                    Manage your suppliers and their contact
                                    information
                                </p>
                            </div>
                            <div class="flex items-center gap-4">
                                <!-- Create Supplier Button -->
                                <button
                                    @click="showCreateModal = true"
                                    class="inline-flex items-center gap-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl"
                                >
                                    <svg
                                        class="w-5 h-5"
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
                                    Create Supplier
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- AG Grid -->
                <div
                    class="rounded-xl overflow-hidden border border-red-200/50 shadow-sm bg-white/70 backdrop-blur-sm p-6"
                >
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-red-900 mb-2">
                            Suppliers
                        </h2>
                        <p class="text-red-600">
                            View and manage all suppliers
                        </p>
                    </div>
                    <ag-grid-vue
                        class="ag-theme-alpine modern-grid"
                        style="width: 100%"
                        :domLayout="'autoHeight'"
                        :columnDefs="columnDefs"
                        :rowData="rowData"
                        :defaultColDef="defaultColDef"
                        :pagination="true"
                        :paginationPageSize="10"
                        :paginationPageSizeSelector="paginationPageSizeSelector"
                        theme="legacy"
                    />
                </div>
            </div>
        </div>
        <!-- Create Supplier Modal Component -->
        <AdminCreateSupplierModal
            :showModal="showCreateModal"
            @close="showCreateModal = false"
            @created="handleSupplierCreated"
            @error="handleSupplierError"
        />
        <!-- Edit Supplier Modal Component -->
        <AdminEditSupplierModal
            :showModal="showEditModal"
            :supplierData="selectedSupplier"
            @close="showEditModal = false"
            @updated="handleSupplierUpdated"
            @error="handleSupplierError"
        />
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, watch, computed } from "vue";
import { Head, router, usePage } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AdminCreateSupplierModal from "./Components/AdminCreateSupplierModal.vue";
import AdminEditSupplierModal from "./Components/AdminEditSupplierModal.vue";
import { AgGridVue } from "ag-grid-vue3";
import { ModuleRegistry, AllCommunityModule } from "ag-grid-community";
import Swal from "sweetalert2";
ModuleRegistry.registerModules([AllCommunityModule]);
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-alpine.css";

const page = usePage();

const props = defineProps({
    suppliers: {
        type: Array,
        default: () => [],
    },
});

const showCreateModal = ref(false);
const showEditModal = ref(false);
const selectedSupplier = ref({});

// Check if user is admin
const isAdmin = computed(() => {
    return page.props.auth?.user?.is_admin || false;
});

// Pagination page size options
const paginationPageSizeSelector = ref([5, 10, 15, 20, 50]);

const columnDefs = computed(() => [
    { headerName: "ID", field: "id", sortable: true, filter: true, width: 80 },
    { headerName: "Name", field: "name", sortable: true, filter: true },
    {
        headerName: "Phone",
        field: "phone_number",
        sortable: true,
        filter: true,
    },
    {
        headerName: "Actions",
        field: "actions",
        cellRenderer: (params) => {
            const editButton = `<button onclick="editSupplier(${params.data.id})" class="bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-semibold py-2 px-4 rounded-xl text-xs transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg mr-2">Edit</button>`;
            const deleteButton = isAdmin.value
                ? `<button onclick="deleteSupplier(${params.data.id})" class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold py-2 px-4 rounded-xl text-xs transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg">Delete</button>`
                : "";
            return `<div class='flex gap-2'>${editButton}${deleteButton}</div>`;
        },
        width: 200,
        sortable: false,
        filter: false,
    },
]);

const defaultColDef = ref({
    resizable: true,
    flex: 1,
});

const rowData = ref(props.suppliers);

watch(
    () => props.suppliers,
    (newVal) => {
        rowData.value = newVal;
        console.log("Updated supplier data:", newVal);
    }
);

// Make functions globally available for button clicks
window.editSupplier = (id) => {
    console.log("Edit supplier:", id);
    // Find the supplier data
    const supplier = props.suppliers.find((supplier) => supplier.id === id);
    if (supplier) {
        selectedSupplier.value = supplier;
        showEditModal.value = true;
    } else {
        alert("Supplier not found");
    }
};

window.deleteSupplier = async (id) => {
    if (!isAdmin.value) {
        Swal.fire({
            icon: "error",
            title: "Permission Denied",
            text: "You don't have permission to delete suppliers.",
            background: "#fff",
            color: "#7f1d1d",
            confirmButtonColor: "#b91c1c",
            customClass: {
                popup: "rounded-2xl shadow-2xl border border-red-100",
                title: "font-bold text-2xl bg-gradient-to-r from-red-900 to-red-700 bg-clip-text text-transparent",
                confirmButton: "rounded-xl px-6 py-2 font-semibold",
            },
            buttonsStyling: false,
        });
        return;
    }

    if (confirm("Are you sure you want to delete this supplier?")) {
        let deleteLoadingSwal;
        try {
            deleteLoadingSwal = Swal.fire({
                title: "Deleting...",
                text: "Please wait while the supplier is being deleted.",
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                },
                background: "#fff",
                color: "#7f1d1d",
                customClass: {
                    popup: "rounded-2xl shadow-2xl border border-red-100",
                    title: "font-bold text-2xl bg-gradient-to-r from-red-900 to-red-700 bg-clip-text text-transparent",
                    confirmButton: "rounded-xl px-6 py-2 font-semibold",
                },
                buttonsStyling: false,
            });
            const response = await fetch(`/suppliers/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                    "Content-Type": "application/json",
                },
            });

            if (response.ok) {
                // Remove the supplier from the table without reload and keep sorted
                rowData.value = rowData.value
                    .filter((s) => s.id !== id)
                    .sort((a, b) => a.id - b.id);
                Swal.fire({
                    icon: "success",
                    title: "Supplier Deleted!",
                    text: "The supplier was deleted successfully.",
                    background: "#fff",
                    color: "#7f1d1d",
                    confirmButtonColor: "#b91c1c",
                    customClass: {
                        popup: "rounded-2xl shadow-2xl border border-red-100",
                        title: "font-bold text-2xl bg-gradient-to-r from-red-900 to-red-700 bg-clip-text text-transparent",
                        confirmButton: "rounded-xl px-6 py-2 font-semibold",
                    },
                    buttonsStyling: false,
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: "Error deleting supplier.",
                    background: "#fff",
                    color: "#7f1d1d",
                    confirmButtonColor: "#b91c1c",
                    customClass: {
                        popup: "rounded-2xl shadow-2xl border border-red-100",
                        title: "font-bold text-2xl bg-gradient-to-r from-red-900 to-red-700 bg-clip-text text-transparent",
                        confirmButton: "rounded-xl px-6 py-2 font-semibold",
                    },
                    buttonsStyling: false,
                });
            }
        } catch (error) {
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: "Error deleting supplier.",
                background: "#fff",
                color: "#7f1d1d",
                confirmButtonColor: "#b91c1c",
                customClass: {
                    popup: "rounded-2xl shadow-2xl border border-red-100",
                    title: "font-bold text-2xl bg-gradient-to-r from-red-900 to-red-700 bg-clip-text text-transparent",
                    confirmButton: "rounded-xl px-6 py-2 font-semibold",
                },
                buttonsStyling: false,
            });
        }
    }
};

const handleSupplierCreated = (newSupplier) => {
    if (newSupplier && newSupplier.id) {
        // Add new supplier and sort by id ascending
        rowData.value = [
            ...rowData.value.filter((s) => s.id !== newSupplier.id),
            newSupplier,
        ].sort((a, b) => a.id - b.id);
    }
    Swal.fire({
        icon: "success",
        title: "Supplier Created!",
        text: "The supplier was created successfully.",
        background: "#fff",
        color: "#7f1d1d",
        confirmButtonColor: "#b91c1c",
        customClass: {
            popup: "rounded-2xl shadow-2xl border border-red-100",
            title: "font-bold text-2xl bg-gradient-to-r from-red-900 to-red-700 bg-clip-text text-transparent",
            confirmButton: "rounded-xl px-6 py-2 font-semibold",
        },
        buttonsStyling: false,
    });
};

const handleSupplierUpdated = (updatedSupplier) => {
    // Update the supplier in the table without reload
    if (updatedSupplier && updatedSupplier.id) {
        rowData.value = rowData.value
            .map((s) => (s.id === updatedSupplier.id ? updatedSupplier : s))
            .sort((a, b) => a.id - b.id); // Always keep sorted by id ascending
    }
    Swal.fire({
        icon: "success",
        title: "Supplier Updated!",
        text: "The supplier was updated successfully.",
        background: "#fff",
        color: "#7f1d1d",
        confirmButtonColor: "#b91c1c",
        customClass: {
            popup: "rounded-2xl shadow-2xl border border-red-100",
            title: "font-bold text-2xl bg-gradient-to-r from-red-900 to-red-700 bg-clip-text text-transparent",
            confirmButton: "rounded-xl px-6 py-2 font-semibold",
        },
        buttonsStyling: false,
    });
    selectedSupplier.value = {}; // Clear selected supplier
};

const handleSupplierError = (error) => {
    Swal.fire({
        icon: "error",
        title: "Error!",
        text: error?.message || "An error occurred. Please try again.",
        background: "#fff",
        color: "#7f1d1d",
        confirmButtonColor: "#b91c1c",
        customClass: {
            popup: "rounded-2xl shadow-2xl border border-red-100",
            title: "font-bold text-2xl bg-gradient-to-r from-red-900 to-red-700 bg-clip-text text-transparent",
            confirmButton: "rounded-xl px-6 py-2 font-semibold",
        },
        buttonsStyling: false,
    });
};

console.log("Supplier data received as prop:", props.suppliers);
</script>

<style>
.modern-grid {
    --ag-background-color: #ffffff;
    --ag-header-background-color: #f3f4f6;
    --ag-header-foreground-color: #111827;
    --ag-row-hover-color: #f9fafb;
    --ag-row-selected-color: #e5e7eb;
    --ag-border-color: #d1d5db;
}

.ag-theme-alpine {
    --ag-alpine-button-color: #ef4444;
    --ag-alpine-button-hover-color: #dc2626;
    --ag-alpine-button-active-color: #b91c1c;
}

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
    border-bottom: 1px solid rgb(254 202 202);
    background: transparent;
    transition: background 0.2s;
}

.modern-grid .ag-row:hover {
    background: rgb(254 242 242);
}

.modern-grid .ag-root-wrapper {
    border-radius: 12px;
    overflow: hidden;
}

.modern-grid .ag-paging-panel {
    border-top: 1px solid rgb(254 202 202);
    background-color: rgb(254 242 242);
    padding: 16px;
}
</style>
