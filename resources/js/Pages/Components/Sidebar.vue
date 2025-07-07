<template>
    <aside
        class="w-72 min-h-screen h-full bg-gradient-to-b from-red-900 via-red-800 to-red-900 border-r border-red-700/30 p-6 flex flex-col gap-6 shadow-2xl sticky top-0 backdrop-blur-sm"
        style="
            display: flex !important;
            background: linear-gradient(
                to bottom,
                #7f1d1d,
                #991b1b,
                #7f1d1d
            ) !important;
            border-right: 1px solid rgba(185, 28, 28, 0.3) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
        "
    >
        <!-- Logo/Brand Section -->
        <div class="text-center py-4 border-b border-red-700/30 mb-6">
            <div class="text-2xl font-bold text-white mb-2 tracking-wide">
                Leonard
            </div>
            <div class="text-red-200 text-sm font-medium">
                Management System
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex flex-col gap-3 mt-4">
            <div
                class="text-red-200 text-xs uppercase tracking-widest font-semibold mb-4 px-3"
            >
                Main Menu
            </div>

            <!-- Staff Menu Item -->
            <div
                v-if="isAdmin"
                class="group relative cursor-pointer transition-all duration-300 ease-in-out transform hover:scale-[1.02]"
                @click="goToStaff"
            >
                <div
                    class="flex items-center gap-4 px-4 py-3 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/20 transition-all duration-300 backdrop-blur-sm"
                >
                    <div
                        class="w-10 h-10 rounded-lg bg-red-700/50 flex items-center justify-center group-hover:bg-red-600/60 transition-colors duration-300"
                    >
                        <svg
                            class="w-5 h-5 text-white"
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
                    <span
                        class="text-white font-medium group-hover:text-red-100 transition-colors duration-300"
                        >Staff</span
                    >
                </div>
            </div>

            <!-- Suppliers Menu Item -->
            <div
                class="group relative cursor-pointer transition-all duration-300 ease-in-out transform hover:scale-[1.02]"
                @click="goToSupplier"
            >
                <div
                    class="flex items-center gap-4 px-4 py-3 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/20 transition-all duration-300 backdrop-blur-sm"
                >
                    <div
                        class="w-10 h-10 rounded-lg bg-red-700/50 flex items-center justify-center group-hover:bg-red-600/60 transition-colors duration-300"
                    >
                        <svg
                            class="w-5 h-5 text-white"
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
                    <span
                        class="text-white font-medium group-hover:text-red-100 transition-colors duration-300"
                        >Suppliers</span
                    >
                </div>
            </div>

            <!-- Records Menu Item -->
            <div
                class="group relative cursor-pointer transition-all duration-300 ease-in-out transform hover:scale-[1.02]"
                @click="goToRecords"
            >
                <div
                    class="flex items-center gap-4 px-4 py-3 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/20 transition-all duration-300 backdrop-blur-sm"
                >
                    <div
                        class="w-10 h-10 rounded-lg bg-red-700/50 flex items-center justify-center group-hover:bg-red-600/60 transition-colors duration-300"
                    >
                        <svg
                            class="w-5 h-5 text-white"
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
                    <span
                        class="text-white font-medium group-hover:text-red-100 transition-colors duration-300"
                        >Records</span
                    >
                </div>
            </div>

            <!-- Reports Menu Item -->
            <div
                v-if="isAdmin"
                class="group relative cursor-pointer transition-all duration-300 ease-in-out transform hover:scale-[1.02]"
                @click="goToReports"
            >
                <div
                    class="flex items-center gap-4 px-4 py-3 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/20 transition-all duration-300 backdrop-blur-sm"
                >
                    <div
                        class="w-10 h-10 rounded-lg bg-red-700/50 flex items-center justify-center group-hover:bg-red-600/60 transition-colors duration-300"
                    >
                        <svg
                            class="w-5 h-5 text-white"
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
                    <span
                        class="text-white font-medium group-hover:text-red-100 transition-colors duration-300"
                        >Reports</span
                    >
                </div>
            </div>
        </nav>

        <!-- Bottom Decorative Element -->
        <div class="mt-auto pt-6 border-t border-red-700/30">
            <div class="text-center">
                <div
                    class="w-12 h-12 mx-auto rounded-full bg-gradient-to-tr from-red-600 to-red-500 flex items-center justify-center mb-3 shadow-lg"
                >
                    <svg
                        class="w-6 h-6 text-white"
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
                <div class="text-red-200 text-xs font-medium">
                    Powered by Leonard
                </div>
            </div>
        </div>
    </aside>
</template>

<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const page = usePage();

const isAdmin = computed(() => {
    return page.props.auth?.user?.is_admin || false;
});

function goToStaff() {
    router.visit("/staff");
}
function goToSupplier() {
    router.visit("/supplier");
}
function goToRecords() {
    router.visit("/records");
}
function goToReports() {
    router.visit("/reports");
}
</script>
