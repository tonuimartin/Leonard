<template>
    <aside
        :class="[
            'min-h-screen h-full bg-gradient-to-b from-[#1F2937] via-[#1a202c] to-[#1F2937] border-r border-[#D1D5DB]/20 p-3 flex flex-col gap-3 shadow-2xl sticky top-0 backdrop-blur-sm transition-all duration-300',
            collapsed ? 'w-16 rounded-r-2xl' : 'w-56 rounded-r-2xl',
        ]"
        style="
            display: flex !important;
            background: linear-gradient(
                to bottom,
                #1F2937,
                #1a202c,
                #1F2937
            ) !important;
            border-right: 1px solid rgba(209, 213, 219, 0.2) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
        "
    >
        <!-- Collapse Toggle Button -->
        <div class="relative flex justify-end mb-1">
            <button
                @click="collapsed = !collapsed"
                class="bg-white/90 hover:bg-primary text-[#1F2937] border border-[#D1D5DB] shadow-lg rounded-full w-7 h-7 flex items-center justify-center transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-accent"
                :title="collapsed ? 'Expand sidebar' : 'Collapse sidebar'"
                style="
                    position: static;
                    right: auto;
                    top: auto;
                    margin-left: auto;
                "
            >
                <svg
                    v-if="!collapsed"
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 19l-7-7 7-7"
                    />
                </svg>
                <svg
                    v-else
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 5l7 7-7 7"
                    />
                </svg>
            </button>
        </div>
        <!-- Logo/Brand Section -->
        <div
            v-if="!collapsed"
            class="text-center py-2 border-b border-white/10 mb-3"
        >
            <div class="text-xl font-display font-bold text-white mb-1 tracking-wide">
                Leonard
            </div>
            <div class="text-white/70 text-xs font-medium font-body">
                Management System
            </div>
        </div>
        <div
            v-else
            class="flex flex-col items-center py-2 border-b border-white/10 mb-3"
        >
            <!-- App Logo (replace src with your logo path if available) -->
            <img
                src="/favicon.ico"
                alt="App Logo"
                class="w-8 h-8 rounded-lg shadow-md"
            />
        </div>
        <!-- Navigation Menu -->
        <nav class="flex flex-col gap-2 mt-2">
            <div
                v-if="!collapsed"
                class="text-white/70 text-[10px] uppercase tracking-widest font-semibold mb-2 px-2 font-body"
            >
                Main Menu
            </div>
            <!-- Home Menu Item -->
            <div
                class="group relative cursor-pointer transition-all duration-300 ease-in-out transform hover:scale-[1.02]"
                @click="goToHome"
            >
                <div
                    :class="[
                        'flex items-center gap-4 py-3 rounded-xl bg-white/5 hover:bg-gradient-to-r hover:from-accent/20 hover:to-accent-hover/20 border border-white/10 hover:border-accent/30 transition-all duration-300 backdrop-blur-sm',
                        collapsed ? 'justify-center px-2' : 'px-4',
                    ]"
                >
                    <div
                        class="w-10 h-10 rounded-lg bg-accent/20 flex items-center justify-center group-hover:bg-accent/30 transition-colors duration-300"
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
                                d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m4-8v8m5 0a2 2 0 002-2V7a2 2 0 00-2-2h-3.5a2 2 0 00-2 2v1"
                            />
                        </svg>
                    </div>
                    <span
                        v-if="!collapsed"
                        class="text-white font-medium font-body group-hover:text-accent transition-colors duration-300"
                        >Home</span
                    >
                </div>
            </div>
            <!-- Staff Menu Item -->
            <div
                v-if="isAdmin"
                class="group relative cursor-pointer transition-all duration-300 ease-in-out transform hover:scale-[1.02]"
                @click="goToStaff"
            >
                <div
                    :class="[
                        'flex items-center gap-4 py-3 rounded-xl bg-white/5 hover:bg-gradient-to-r hover:from-accent/20 hover:to-accent-hover/20 border border-white/10 hover:border-accent/30 transition-all duration-300 backdrop-blur-sm',
                        collapsed ? 'justify-center px-2' : 'px-4',
                    ]"
                >
                    <div
                        class="w-10 h-10 rounded-lg bg-accent/20 flex items-center justify-center group-hover:bg-accent/30 transition-colors duration-300"
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
                    <span
                        v-if="!collapsed"
                        class="text-white font-medium font-body group-hover:text-accent transition-colors duration-300"
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
                    :class="[
                        'flex items-center gap-4 py-3 rounded-xl bg-white/5 hover:bg-gradient-to-r hover:from-accent/20 hover:to-accent-hover/20 border border-white/10 hover:border-accent/30 transition-all duration-300 backdrop-blur-sm',
                        collapsed ? 'justify-center px-2' : 'px-4',
                    ]"
                >
                    <div
                        class="w-10 h-10 rounded-lg bg-accent/20 flex items-center justify-center group-hover:bg-accent/30 transition-colors duration-300"
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
                    <span
                        v-if="!collapsed"
                        class="text-white font-medium font-body group-hover:text-accent transition-colors duration-300"
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
                    :class="[
                        'flex items-center gap-4 py-3 rounded-xl bg-white/5 hover:bg-gradient-to-r hover:from-accent/20 hover:to-accent-hover/20 border border-white/10 hover:border-accent/30 transition-all duration-300 backdrop-blur-sm',
                        collapsed ? 'justify-center px-2' : 'px-4',
                    ]"
                >
                    <div
                        class="w-10 h-10 rounded-lg bg-accent/20 flex items-center justify-center group-hover:bg-accent/30 transition-colors duration-300"
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
                    <span
                        v-if="!collapsed"
                        class="text-white font-medium font-body group-hover:text-accent transition-colors duration-300"
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
                    :class="[
                        'flex items-center gap-4 py-3 rounded-xl bg-white/5 hover:bg-gradient-to-r hover:from-accent/20 hover:to-accent-hover/20 border border-white/10 hover:border-accent/30 transition-all duration-300 backdrop-blur-sm',
                        collapsed ? 'justify-center px-2' : 'px-4',
                    ]"
                >
                    <div
                        class="w-10 h-10 rounded-lg bg-accent/20 flex items-center justify-center group-hover:bg-accent/30 transition-colors duration-300"
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
                    <span
                        v-if="!collapsed"
                        class="text-white font-medium font-body group-hover:text-accent transition-colors duration-300"
                        >Reports</span
                    >
                </div>
            </div>
        </nav>
        <!-- Bottom Decorative Element -->
        <div class="mt-auto pt-3 border-t border-white/10">
            <div class="text-center">
                <div
                    class="w-8 h-8 mx-auto rounded-full bg-gradient-to-tr from-accent to-accent-hover flex items-center justify-center mb-2 shadow-lg"
                >
                    <svg
                        class="w-4 h-4 text-white"
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
                <div
                    v-if="!collapsed"
                    class="text-white/70 text-[10px] font-medium font-body"
                >
                    Powered by Leonard
                </div>
            </div>
        </div>
    </aside>
</template>

<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const page = usePage();
const collapsed = ref(false);

const isAdmin = computed(() => {
    return page.props.auth?.user?.is_admin || false;
});

function goToStaff() {
    router.visit("/staff");
}
function goToSupplier() {
    router.visit("/suppliers");
}
function goToRecords() {
    router.visit("/records");
}
function goToReports() {
    router.visit("/reports");
}
function goToHome() {
    router.visit("/");
}
</script>

<style scoped>
/* Reduce sidebar paddings, font sizes, and icon sizes for compactness */

aside {
    min-height: 100vh !important;
    height: 100vh !important;
    position: sticky !important;
    top: 0 !important;
    z-index: 30 !important;
    padding: 0.75rem !important;
}
nav {
    gap: 0.5rem !important;
}
nav > div {
    margin-bottom: 0.1rem !important;
}
nav .flex.items-center {
    padding-top: 0.5rem !important;
    padding-bottom: 0.5rem !important;
    padding-left: 0.5rem !important;
    padding-right: 0.5rem !important;
    min-height: 2.25rem !important;
}
nav .w-10.h-10 {
    width: 1.75rem !important;
    height: 1.75rem !important;
}
nav svg {
    width: 1rem !important;
    height: 1rem !important;
}
nav span {
    font-size: 0.95rem !important;
}
.text-xl {
    font-size: 1.1rem !important;
}
.text-xs {
    font-size: 0.65rem !important;
}
.mt-auto.pt-3 {
    padding-top: 0.5rem !important;
}
.w-8.h-8 {
    width: 2rem !important;
    height: 2rem !important;
}
.mb-2 {
    margin-bottom: 0.3rem !important;
}

/* Ensure dropdowns in sidebar always appear above all other content */
.group .absolute,
.group .z-10,
nav .absolute,
nav .z-10 {
    z-index: 9999 !important;
}
</style>
