<template>
    <Head title="Staff" />
    <AuthenticatedLayout>
        <div class="p-4 sm:p-6 lg:p-8 bg-gray-100 min-h-screen">
            <div class="mx-auto max-w-7xl">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Create Staff Button -->
                        <div class="mb-4">
                            <button
                                @click="showCreateModal = true"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            >
                                Create Staff
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
        <!-- Create Staff Modal Component -->
        <AdminCreateStaffModal
            :showModal="showCreateModal"
            @close="showCreateModal = false"
            @created="handleStaffCreated"
        />

        <!-- Edit Staff Modal Component -->
        <AdminEditStaffModal
            :showModal="showEditModal"
            :staffData="selectedStaff"
            @close="showEditModal = false"
            @updated="handleStaffUpdated"
        />
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, watch, computed } from "vue";
import { Head, router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AdminCreateStaffModal from "./Components/AdminCreateStaffModal.vue";
import AdminEditStaffModal from "./Components/AdminEditStaffModal.vue";
import { AgGridVue } from "ag-grid-vue3";
import { ModuleRegistry, AllCommunityModule } from "ag-grid-community";
ModuleRegistry.registerModules([AllCommunityModule]);
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-alpine.css";

const props = defineProps({
    staff: {
        type: Array,
        default: () => [],
    },
});

const showCreateModal = ref(false);
const showEditModal = ref(false);
const selectedStaff = ref({});

// Pagination page size options
const paginationPageSizeSelector = ref([5, 10, 15, 20, 50]);

const columnDefs = ref([
    { headerName: "ID", field: "id", sortable: true, filter: true, width: 80 },
    { headerName: "Name", field: "name", sortable: true, filter: true },
    { headerName: "Email", field: "email", sortable: true, filter: true },
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
            return `
                <button onclick="editStaff(${params.data.id})" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded text-xs mr-2">
                    Edit
                </button>
                <button onclick="deleteStaff(${params.data.id})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs">
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

const rowData = ref(props.staff);

watch(
    () => props.staff,
    (newVal) => {
        rowData.value = newVal;
        console.log("Updated staff data:", newVal);
    }
);

// Make functions globally available for button clicks
window.editStaff = (id) => {
    console.log("Edit staff:", id);
    // Find the staff member data
    const staffMember = props.staff.find((staff) => staff.id === id);
    if (staffMember) {
        selectedStaff.value = staffMember;
        showEditModal.value = true;
    } else {
        alert("Staff member not found");
    }
};

window.deleteStaff = async (id) => {
    if (confirm("Are you sure you want to delete this staff member?")) {
        try {
            const response = await fetch(`/staff/${id}`, {
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
                alert("Error deleting staff member");
            }
        } catch (error) {
            console.error("Error:", error);
            alert("Error deleting staff member");
        }
    }
};

const handleStaffCreated = () => {
    console.log("Staff member created successfully!");
};

const handleStaffUpdated = () => {
    console.log("Staff member updated successfully!");
    selectedStaff.value = {}; // Clear selected staff
};

console.log("Staff data received as prop:", props.staff);
</script>
