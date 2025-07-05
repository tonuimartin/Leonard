<template>
    <Head title="Suppliers" />
    <AuthenticatedLayout>
        <div class="p-4 sm:p-6 lg:p-8 bg-gray-100 min-h-screen">
            <div class="mx-auto max-w-7xl">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Create Supplier Button -->
                        <div class="mb-4">
                            <button
                                @click="showCreateModal = true"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            >
                                Create Supplier
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

        <!-- Create Supplier Modal Component -->
        <AdminCreateSupplierModal
            :showModal="showCreateModal"
            @close="showCreateModal = false"
            @created="handleSupplierCreated"
        />

        <!-- Edit Supplier Modal Component -->
        <AdminEditSupplierModal
            :showModal="showEditModal"
            :supplierData="selectedSupplier"
            @close="showEditModal = false"
            @updated="handleSupplierUpdated"
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
            const editButton = `<button onclick="editSupplier(${params.data.id})" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded text-xs mr-2">
                Edit
            </button>`;

            const deleteButton = isAdmin.value
                ? `<button onclick="deleteSupplier(${params.data.id})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs">
                    Delete
                </button>`
                : "";

            return editButton + deleteButton;
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
        alert("You don't have permission to delete suppliers.");
        return;
    }

    if (confirm("Are you sure you want to delete this supplier?")) {
        try {
            const response = await fetch(`/supplier/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                    "Content-Type": "application/json",
                },
            });

            if (response.ok) {
                // Refresh the page to show updated data
                router.reload();
            } else {
                alert("Error deleting supplier");
            }
        } catch (error) {
            console.error("Error:", error);
            alert("Error deleting supplier");
        }
    }
};

const handleSupplierCreated = () => {
    console.log("Supplier created successfully!");
};

const handleSupplierUpdated = () => {
    console.log("Supplier updated successfully!");
    selectedSupplier.value = {}; // Clear selected supplier
};

console.log("Supplier data received as prop:", props.suppliers);
</script>
