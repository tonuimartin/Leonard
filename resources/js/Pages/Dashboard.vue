<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { ref } from "vue";

// Example: these would come from the backend controller
const props = defineProps({
    totalRecords: Number,
    activeSuppliers: Number,
    staffMembers: Number,
    monthlyRevenue: Number,
    recentActivity: {
        type: Array,
        default: () => [],
    },
});

// Modal state (if you use modals for create actions)
const showCreateRecordModal = ref(false);
const showCreateSupplierModal = ref(false);
const showGenerateReportModal = ref(false);
const showManageStaffModal = ref(false);

function openCreateRecord() {
    // If you use a modal, set showCreateRecordModal.value = true
    // Otherwise, navigate to the records page
    router.visit("/records");
}
function openCreateSupplier() {
    router.visit("/suppliers");
}
function openGenerateReport() {
    router.visit("/reports");
}
function openManageStaff() {
    router.visit("/staff");
}
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div
            class="p-3 sm:p-4 lg:p-5 bg-primary min-h-screen"
        >
            <div class="mx-auto max-w-7xl">
                <!-- Welcome Header -->
                <div class="mb-4">
                    <div
                        class="bg-white/70 backdrop-blur-sm rounded-xl shadow-md border border-[#D1D5DB]/50 p-4"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <h1
                                    class="text-2xl font-display font-bold text-[#1F2937] mb-1"
                                >
                                    Welcome back,
                                    {{ $page.props.auth?.user?.name }}!
                                </h1>
                                <p class="text-accent text-sm font-medium font-body">
                                    {{
                                        new Date().toLocaleDateString("en-US", {
                                            weekday: "long",
                                            year: "numeric",
                                            month: "long",
                                            day: "numeric",
                                        })
                                    }}
                                </p>
                            </div>
                            <div class="hidden md:block">
                                <div
                                    class="w-14 h-14 rounded-xl bg-gradient-to-tr from-accent to-accent-hover flex items-center justify-center shadow-md"
                                >
                                    <svg
                                        class="w-7 h-7 text-white"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"
                                        />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats Cards -->
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-4"
                >
                    <!-- Total Records Card -->
                    <div
                        class="bg-white/70 backdrop-blur-sm rounded-xl shadow-md border border-[#D1D5DB]/50 p-3 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 cursor-pointer"
                        @click="openCreateRecord"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <p
                                    class="text-accent text-xs font-semibold uppercase tracking-wide font-body"
                                >
                                    Total Records
                                </p>
                                <p class="text-2xl font-display font-bold text-[#1F2937] mt-0.5">
                                    {{ totalRecords ?? "—" }}
                                </p>
                                <p class="text-[#6B7280] text-xs mt-0.5 font-body">
                                    Click to view records
                                </p>
                            </div>
                            <div
                                class="w-10 h-10 rounded-lg bg-accent/10 flex items-center justify-center"
                            >
                                <svg
                                    class="w-5 h-5 text-accent"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                    />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Active Suppliers Card -->
                    <div
                        class="bg-white/70 backdrop-blur-sm rounded-xl shadow-md border border-[#D1D5DB]/50 p-3 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 cursor-pointer"
                        @click="openCreateSupplier"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <p
                                    class="text-accent text-xs font-semibold uppercase tracking-wide font-body"
                                >
                                    Active Suppliers
                                </p>
                                <p class="text-2xl font-display font-bold text-[#1F2937] mt-0.5">
                                    {{ activeSuppliers ?? "—" }}
                                </p>
                                <p class="text-[#6B7280] text-xs mt-0.5 font-body">
                                    Click to view suppliers
                                </p>
                            </div>
                            <div
                                class="w-10 h-10 rounded-lg bg-accent/10 flex items-center justify-center"
                            >
                                <svg
                                    class="w-5 h-5 text-accent"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                                    />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Staff Members Card -->
                    <div
                        class="bg-white/70 backdrop-blur-sm rounded-xl shadow-md border border-[#D1D5DB]/50 p-3 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 cursor-pointer"
                        @click="openManageStaff"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <p
                                    class="text-accent text-xs font-semibold uppercase tracking-wide font-body"
                                >
                                    Staff Members
                                </p>
                                <p class="text-2xl font-display font-bold text-[#1F2937] mt-0.5">
                                    {{ staffMembers ?? "—" }}
                                </p>
                                <p class="text-[#6B7280] text-xs mt-0.5 font-body">
                                    Click to manage staff
                                </p>
                            </div>
                            <div
                                class="w-10 h-10 rounded-lg bg-accent/10 flex items-center justify-center"
                            >
                                <svg
                                    class="w-5 h-5 text-accent"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"
                                    />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Revenue Card -->
                    <div
                        class="bg-white/70 backdrop-blur-sm rounded-xl shadow-md border border-[#D1D5DB]/50 p-3 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 cursor-pointer"
                        @click="openGenerateReport"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <p
                                    class="text-accent text-xs font-semibold uppercase tracking-wide font-body"
                                >
                                    Monthly Revenue
                                </p>
                                <p class="text-2xl font-display font-bold text-[#1F2937] mt-0.5">
                                    KSh
                                    {{
                                        monthlyRevenue
                                            ? monthlyRevenue.toLocaleString(
                                                  "en-KE",
                                                  { minimumFractionDigits: 0 }
                                              )
                                            : "—"
                                    }}
                                </p>
                                <p class="text-[#6B7280] text-xs mt-0.5 font-body">
                                    Click to view reports
                                </p>
                            </div>
                            <div
                                class="w-10 h-10 rounded-lg bg-accent/10 flex items-center justify-center"
                            >
                                <svg
                                    class="w-5 h-5 text-accent"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                    />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Recent Activity -->
                    <div class="lg:col-span-2">
                        <div
                            class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-lg border border-red-200/50 p-6"
                        >
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-xl font-display font-bold text-[#1F2937]">
                                    Recent Activity
                                </h2>
                                <button
                                    class="text-accent hover:text-accent-hover font-medium text-sm transition-colors duration-200 font-body"
                                    @click="openCreateRecord"
                                >
                                    View All
                                </button>
                            </div>
                            <div class="space-y-4">
                                <template v-if="props.recentActivity.length">
                                    <div
                                        v-for="(
                                            activity, idx
                                        ) in props.recentActivity"
                                        :key="idx"
                                        class="flex items-start gap-4 p-4 rounded-xl bg-accent/5 border border-accent/10"
                                    >
                                        <div
                                            class="w-8 h-8 rounded-lg bg-accent/20 flex items-center justify-center flex-shrink-0"
                                        >
                                            <svg
                                                v-if="activity.icon === 'plus'"
                                                class="w-4 h-4 text-accent"
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
                                            <svg
                                                v-else-if="
                                                    activity.icon === 'edit'
                                                "
                                                class="w-4 h-4 text-accent"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                />
                                            </svg>
                                            <svg
                                                v-else-if="
                                                    activity.icon === 'check'
                                                "
                                                class="w-4 h-4 text-accent"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                                />
                                            </svg>
                                            <svg
                                                v-else
                                                class="w-4 h-4 text-accent"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <circle
                                                    cx="12"
                                                    cy="12"
                                                    r="10"
                                                    stroke-width="2"
                                                />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-[#1F2937] font-medium font-body">
                                                {{ activity.title }}
                                            </p>
                                            <p class="text-accent text-sm font-body">
                                                {{ activity.description }}
                                            </p>
                                            <p
                                                class="text-[#6B7280] text-xs mt-1 font-body"
                                            >
                                                {{ activity.timeAgo }}
                                            </p>
                                        </div>
                                    </div>
                                </template>
                                <div
                                    v-else
                                    class="text-[#9CA3AF] text-center py-8 font-body"
                                >
                                    No recent activity found.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="lg:col-span-1">
                        <div
                            class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-lg border border-red-200/50 p-6"
                        >
                            <h2 class="text-xl font-display font-bold text-[#1F2937] mb-6">
                                Quick Actions
                            </h2>
                            <div class="space-y-3">
                                <button
                                    class="w-full text-left p-4 rounded-xl bg-gradient-to-r from-accent to-accent-hover text-white hover:from-accent-hover hover:to-accent-dark transition-all duration-300 transform hover:scale-[1.02] shadow-lg"
                                    @click="openCreateRecord"
                                >
                                    <div class="flex items-center gap-3">
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
                                        <span class="font-medium font-body"
                                            >Add New Record</span
                                        >
                                    </div>
                                </button>

                                <button
                                    class="w-full text-left p-4 rounded-xl bg-white border-2 border-accent/20 text-accent hover:bg-accent/5 transition-all duration-300 transform hover:scale-[1.02]"
                                    @click="openCreateSupplier"
                                >
                                    <div class="flex items-center gap-3">
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
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                                            />
                                        </svg>
                                        <span class="font-medium font-body"
                                            >Create Supplier</span
                                        >
                                    </div>
                                </button>

                                <button
                                    class="w-full text-left p-4 rounded-xl bg-white border-2 border-accent/20 text-accent hover:bg-accent/5 transition-all duration-300 transform hover:scale-[1.02]"
                                    @click="openGenerateReport"
                                >
                                    <div class="flex items-center gap-3">
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
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                            />
                                        </svg>
                                        <span class="font-medium font-body"
                                            >Generate Report</span
                                        >
                                    </div>
                                </button>

                                <button
                                    class="w-full text-left p-4 rounded-xl bg-white border-2 border-accent/20 text-accent hover:bg-accent/5 transition-all duration-300 transform hover:scale-[1.02]"
                                    @click="openManageStaff"
                                >
                                    <div class="flex items-center gap-3">
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
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"
                                            />
                                        </svg>
                                        <span class="font-medium font-body"
                                            >Manage Staff</span
                                        >
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
