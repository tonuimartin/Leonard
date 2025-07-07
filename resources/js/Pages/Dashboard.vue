<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div
            class="p-6 sm:p-8 lg:p-10 bg-gradient-to-br from-red-50 via-white to-red-50 min-h-screen"
        >
            <div class="mx-auto max-w-7xl">
                <!-- Welcome Header -->
                <div class="mb-8">
                    <div
                        class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-lg border border-red-200/50 p-8"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <h1
                                    class="text-3xl font-bold text-red-900 mb-2"
                                >
                                    Welcome back,
                                    {{ $page.props.auth?.user?.name }}!
                                </h1>
                                <p class="text-red-600 text-lg font-medium">
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
                                    class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-red-600 to-red-500 flex items-center justify-center shadow-lg"
                                >
                                    <svg
                                        class="w-10 h-10 text-white"
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
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8"
                >
                    <!-- Total Records Card -->
                    <div
                        class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-lg border border-red-200/50 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <p
                                    class="text-red-600 text-sm font-semibold uppercase tracking-wide"
                                >
                                    Total Records
                                </p>
                                <p class="text-3xl font-bold text-red-900 mt-1">
                                    1,247
                                </p>
                                <p class="text-red-500 text-sm mt-1">
                                    +12% from last month
                                </p>
                            </div>
                            <div
                                class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center"
                            >
                                <svg
                                    class="w-6 h-6 text-red-600"
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
                        class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-lg border border-red-200/50 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <p
                                    class="text-red-600 text-sm font-semibold uppercase tracking-wide"
                                >
                                    Active Suppliers
                                </p>
                                <p class="text-3xl font-bold text-red-900 mt-1">
                                    89
                                </p>
                                <p class="text-red-500 text-sm mt-1">
                                    +3 new this week
                                </p>
                            </div>
                            <div
                                class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center"
                            >
                                <svg
                                    class="w-6 h-6 text-red-600"
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
                        class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-lg border border-red-200/50 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <p
                                    class="text-red-600 text-sm font-semibold uppercase tracking-wide"
                                >
                                    Staff Members
                                </p>
                                <p class="text-3xl font-bold text-red-900 mt-1">
                                    24
                                </p>
                                <p class="text-red-500 text-sm mt-1">
                                    All active
                                </p>
                            </div>
                            <div
                                class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center"
                            >
                                <svg
                                    class="w-6 h-6 text-red-600"
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
                        class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-lg border border-red-200/50 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <p
                                    class="text-red-600 text-sm font-semibold uppercase tracking-wide"
                                >
                                    Monthly Revenue
                                </p>
                                <p class="text-3xl font-bold text-red-900 mt-1">
                                    KSh 2.4M
                                </p>
                                <p class="text-red-500 text-sm mt-1">
                                    +8% from last month
                                </p>
                            </div>
                            <div
                                class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center"
                            >
                                <svg
                                    class="w-6 h-6 text-red-600"
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
                                <h2 class="text-xl font-bold text-red-900">
                                    Recent Activity
                                </h2>
                                <button
                                    class="text-red-600 hover:text-red-800 font-medium text-sm transition-colors duration-200"
                                >
                                    View All
                                </button>
                            </div>
                            <div class="space-y-4">
                                <!-- Activity Item -->
                                <div
                                    class="flex items-start gap-4 p-4 rounded-xl bg-red-50/50 border border-red-100"
                                >
                                    <div
                                        class="w-8 h-8 rounded-lg bg-red-200 flex items-center justify-center flex-shrink-0"
                                    >
                                        <svg
                                            class="w-4 h-4 text-red-700"
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
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-red-900 font-medium">
                                            New record created
                                        </p>
                                        <p class="text-red-600 text-sm">
                                            Record #1248 was added for Supplier
                                            ABC Ltd.
                                        </p>
                                        <p class="text-red-500 text-xs mt-1">
                                            2 minutes ago
                                        </p>
                                    </div>
                                </div>

                                <!-- Activity Item -->
                                <div
                                    class="flex items-start gap-4 p-4 rounded-xl bg-red-50/50 border border-red-100"
                                >
                                    <div
                                        class="w-8 h-8 rounded-lg bg-red-200 flex items-center justify-center flex-shrink-0"
                                    >
                                        <svg
                                            class="w-4 h-4 text-red-700"
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
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-red-900 font-medium">
                                            Supplier updated
                                        </p>
                                        <p class="text-red-600 text-sm">
                                            XYZ Suppliers contact information
                                            was modified.
                                        </p>
                                        <p class="text-red-500 text-xs mt-1">
                                            15 minutes ago
                                        </p>
                                    </div>
                                </div>

                                <!-- Activity Item -->
                                <div
                                    class="flex items-start gap-4 p-4 rounded-xl bg-red-50/50 border border-red-100"
                                >
                                    <div
                                        class="w-8 h-8 rounded-lg bg-red-200 flex items-center justify-center flex-shrink-0"
                                    >
                                        <svg
                                            class="w-4 h-4 text-red-700"
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
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-red-900 font-medium">
                                            Report generated
                                        </p>
                                        <p class="text-red-600 text-sm">
                                            Monthly report for December 2024 is
                                            ready.
                                        </p>
                                        <p class="text-red-500 text-xs mt-1">
                                            1 hour ago
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="lg:col-span-1">
                        <div
                            class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-lg border border-red-200/50 p-6"
                        >
                            <h2 class="text-xl font-bold text-red-900 mb-6">
                                Quick Actions
                            </h2>
                            <div class="space-y-3">
                                <button
                                    class="w-full text-left p-4 rounded-xl bg-gradient-to-r from-red-600 to-red-700 text-white hover:from-red-700 hover:to-red-800 transition-all duration-300 transform hover:scale-[1.02] shadow-lg"
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
                                        <span class="font-medium"
                                            >Add New Record</span
                                        >
                                    </div>
                                </button>

                                <button
                                    class="w-full text-left p-4 rounded-xl bg-white border-2 border-red-200 text-red-700 hover:bg-red-50 transition-all duration-300 transform hover:scale-[1.02]"
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
                                        <span class="font-medium"
                                            >Create Supplier</span
                                        >
                                    </div>
                                </button>

                                <button
                                    class="w-full text-left p-4 rounded-xl bg-white border-2 border-red-200 text-red-700 hover:bg-red-50 transition-all duration-300 transform hover:scale-[1.02]"
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
                                        <span class="font-medium"
                                            >Generate Report</span
                                        >
                                    </div>
                                </button>

                                <button
                                    class="w-full text-left p-4 rounded-xl bg-white border-2 border-red-200 text-red-700 hover:bg-red-50 transition-all duration-300 transform hover:scale-[1.02]"
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
                                        <span class="font-medium"
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
