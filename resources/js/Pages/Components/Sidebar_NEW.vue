<template>
    <aside
        :class="[
            'min-h-screen h-full bg-gradient-to-b from-[var(--color-text)] via-[#1a202c] to-[var(--color-text)] border-r border-[var(--color-border)] p-3 flex flex-col gap-3 shadow-2xl sticky top-0 backdrop-blur-sm transition-all duration-300',
            collapsed ? 'w-16 rounded-r-2xl' : 'w-56 rounded-r-2xl',
        ]"
    >
        <!-- Collapse Toggle Button -->
        <div class="relative flex justify-end mb-1">
            <button
                @click="collapsed = !collapsed"
                class="bg-white/90 hover:bg-[var(--color-primary)] text-[var(--color-text)] border border-[var(--color-border)] shadow-lg rounded-full w-7 h-7 flex items-center justify-center transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-accent"
                :title="collapsed ? 'Expand sidebar' : 'Collapse sidebar'"
                :aria-label="collapsed ? 'Expand sidebar' : 'Collapse sidebar'"
            >
                <svg
                    v-if="!collapsed"
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
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
                    aria-hidden="true"
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
            <img
                src="/favicon.ico"
                alt="App Logo"
                class="w-8 h-8 rounded-lg shadow-md"
            />
        </div>

        <!-- Navigation Menu -->
        <nav class="flex flex-col gap-2 mt-2" role="navigation" aria-label="Main navigation">
            <div
                v-if="!collapsed"
                class="text-white/70 text-[10px] uppercase tracking-widest font-semibold mb-2 px-2 font-body"
            >
                Main Menu
            </div>

            <!-- Home Menu Item -->
            <a
                href="/dashboard"
                class="group relative cursor-pointer transition-all duration-300 ease-in-out transform hover:scale-[1.02] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--color-text)] rounded-xl"
                :aria-label="collapsed ? 'Home' : undefined"
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
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                            />
                        </svg>
                    </div>
                    <span
                        v-if="!collapsed"
                        class="text-white font-medium font-body group-hover:text-accent transition-colors duration-300"
                        >Home</span
                    >
                </div>
            </a>

            <!-- Staff Menu Item -->
            <a
                v-if="isAdmin"
                href="/staff"
                class="group relative cursor-pointer transition-all duration-300 ease-in-out transform hover:scale-[1.02] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--color-text)] rounded-xl"
                :aria-label="collapsed ? 'Staff' : undefined"
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
                            aria-hidden="true"
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
            </a>

            <!-- Suppliers Menu Item -->
            <a
                href="/suppliers"
                class="group relative cursor-pointer transition-all duration-300 ease-in-out transform hover:scale-[1.02] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--color-text)] rounded-xl"
                :aria-label="collapsed ? 'Suppliers' : undefined"
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
                            aria-hidden="true"
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
            </a>

            <!-- Records Menu Item -->
            <a
                href="/records"
                class="group relative cursor-pointer transition-all duration-300 ease-in-out transform hover:scale-[1.02] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--color-text)] rounded-xl"
                :aria-label="collapsed ? 'Records' : undefined"
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
                            aria-hidden="true"
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
            </a>

            <!-- Reports Menu Item -->
            <a
                v-if="isAdmin"
                href="/reports"
                class="group relative cursor-pointer transition-all duration-300 ease-in-out transform hover:scale-[1.02] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--color-text)] rounded-xl"
                :aria-label="collapsed ? 'Reports' : undefined"
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
                            aria-hidden="true"
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
            </a>
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
                        aria-hidden="true"
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
import { usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const page = usePage();
const collapsed = ref(false);

const isAdmin = computed(() => {
    return page.props.auth?.user?.is_admin || false;
});
</script>

<style scoped>
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

nav > a {
    margin-bottom: 0.1rem !important;
}

nav .flex.items-center {
    padding-top: 0.5rem !important;
    padding-bottom: 0.5rem !important;
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
</style>
