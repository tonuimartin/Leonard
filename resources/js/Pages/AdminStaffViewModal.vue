<template>
    <Head title="Staff" />
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
                                    Staff Management
                                </h1>
                                <p class="text-accent text-sm font-medium font-body">
                                    Manage your team members and their access
                                </p>
                            </div>
                            <div class="flex items-center gap-2">
                                <!-- Create Staff Button -->
                                <button
                                    @click="showCreateModal = true"
                                    class="inline-flex items-center gap-1.5 bg-gradient-to-r from-accent to-accent-hover hover:from-accent-hover hover:to-accent-dark text-white font-semibold py-2 px-4 text-sm rounded-lg transition-all duration-200 transform hover:scale-[1.01] shadow-md hover:shadow-lg font-body"
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
                                    Create Staff
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Staff Grid Container -->
                <div
                    class="bg-white/70 backdrop-blur-sm rounded-xl shadow-md border border-accent/20 p-3"
                >
                    <div class="mb-3">
                        <h2 class="text-base font-display font-bold text-[#1F2937] mb-1">
                            Team Members
                        </h2>
                        <p class="text-accent text-sm">
                            View and manage all staff members
                        </p>
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
            @error="handleStaffError"
        />

        <!-- Edit Staff Modal Component -->
        <AdminEditStaffModal
            :showModal="showEditModal"
            :staffData="selectedStaff"
            @close="showEditModal = false"
            @updated="handleStaffUpdated"
            @error="handleStaffError"
        />
    </AuthenticatedLayout>
</template>

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
    border-bottom: 1px solid rgb(254 202 202);
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

<script setup>
import { ref, watch, computed } from "vue";
import { Head, router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AdminCreateStaffModal from "./Components/AdminCreateStaffModal.vue";
import AdminEditStaffModal from "./Components/AdminEditStaffModal.vue";
import { AgGridVue } from "ag-grid-vue3";
import { ModuleRegistry, AllCommunityModule } from "ag-grid-community";
import Swal from "sweetalert2";

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
                <div class="flex gap-2">
                    <button onclick="editStaff(${params.data.id})" class="bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-semibold py-2 px-4 rounded-xl text-xs transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg">
                        Edit
                    </button>
                    <button onclick="deleteStaff(${params.data.id})" class="bg-gradient-to-r from-[#DC2626] to-[#B91C1C] hover:from-[#B91C1C] hover:to-[#991B1B] text-white font-semibold py-1.5 px-3 rounded-lg text-xs transition-all duration-200 shadow-sm hover:shadow-md">
                        Delete
                    </button>
                </div>
            `;
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
    let deleteLoadingSwal;
    if (confirm("Are you sure you want to delete this staff member?")) {
        try {
            deleteLoadingSwal = Swal.fire({
                title: "Deleting...",
                text: "Please wait while the staff member is being deleted.",
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                },
                background: "#fff",
                color: "#7f1d1d",
                customClass: {
                    popup: "rounded-2xl shadow-2xl border border-accent/20",
                    title: "font-bold text-2xl text-accent",
                    confirmButton: "rounded-xl px-6 py-2 font-semibold",
                },
                buttonsStyling: false,
            });
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
                // Remove the staff from the table without reload and keep sorted
                rowData.value = rowData.value
                    .filter((s) => s.id !== id)
                    .sort((a, b) => a.id - b.id);
                Swal.fire({
                    icon: "success",
                    title: "Staff Deleted!",
                    text: "The staff member was deleted successfully.",
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
                    text: "Error deleting staff member.",
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
                text: "Error deleting staff member.",
                background: "#fff",
                color: "#7f1d1d",
                confirmButtonColor: "#b91c1c",
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

const handleStaffCreated = (newStaff) => {
    // Add the new staff to the table without reload
    if (newStaff && newStaff.id) {
        // Add new staff and sort by id ascending
        rowData.value = [
            ...rowData.value.filter((s) => s.id !== newStaff.id),
            newStaff,
        ].sort((a, b) => a.id - b.id);
    }
    Swal.fire({
        icon: "success",
        title: "Staff Created!",
        text: "The staff member was created successfully.",
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

const handleStaffUpdated = (updatedStaff) => {
    // Update the staff in the table without reload
    if (updatedStaff && updatedStaff.id) {
        rowData.value = rowData.value
            .map((s) => (s.id === updatedStaff.id ? updatedStaff : s))
            .sort((a, b) => a.id - b.id); // Always keep sorted by id ascending
    }
    Swal.fire({
        icon: "success",
        title: "Staff Updated!",
        text: "The staff member was updated successfully.",
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
    selectedStaff.value = {}; // Clear selected staff
};

const handleStaffError = (error) => {
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

console.log("Staff data received as prop:", props.staff);
</script>
