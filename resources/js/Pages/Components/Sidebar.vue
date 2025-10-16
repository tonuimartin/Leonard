<template>
    <aside class="w-64 bg-gradient-to-b from-[#1F2937] via-[#1a202c] to-[#1F2937] text-white flex-shrink-0 shadow-lg sticky top-0 h-screen overflow-y-auto">
        <div class="p-3">
            <!-- Collapse Button -->
            <div class="flex justify-end mb-4">
                <button
                    @click="toggleCollapse"
                    class="p-1 rounded-lg hover:bg-white/10 transition-colors duration-200"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path v-if="!isCollapsed" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                        <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
            
            <div class="mb-4" :class="{ 'hidden': isCollapsed }">
                <h2 class="text-lg font-display font-bold text-white">Navigation</h2>
            </div>
            <nav class="space-y-1">
                <Link
                    href="/dashboard"
                    class="flex items-center px-2 py-1 text-sm font-medium rounded-lg transition-colors duration-200 hover:bg-gradient-to-r hover:from-accent/20 hover:to-accent-hover/20"
                    :class="{ 'bg-accent/20': $page.url === '/dashboard' }"
                >
                    <svg class="w-4 h-4 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span :class="{ 'hidden': isCollapsed }">Dashboard</span>
                </Link>
                
                <Link
                    href="/records"
                    class="flex items-center px-2 py-1 text-sm font-medium rounded-lg transition-colors duration-200 hover:bg-gradient-to-r hover:from-accent/20 hover:to-accent-hover/20"
                    :class="{ 'bg-accent/20': $page.url.startsWith('/records') }"
                >
                    <svg class="w-4 h-4 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span :class="{ 'hidden': isCollapsed }">Records</span>
                </Link>
                
                <Link
                    href="/suppliers"
                    class="flex items-center px-2 py-1 text-sm font-medium rounded-lg transition-colors duration-200 hover:bg-gradient-to-r hover:from-accent/20 hover:to-accent-hover/20"
                    :class="{ 'bg-accent/20': $page.url.startsWith('/suppliers') }"
                >
                    <svg class="w-4 h-4 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span :class="{ 'hidden': isCollapsed }">Suppliers</span>
                </Link>
                
                <Link
                    href="/staff"
                    class="flex items-center px-2 py-1 text-sm font-medium rounded-lg transition-colors duration-200 hover:bg-gradient-to-r hover:from-accent/20 hover:to-accent-hover/20"
                    :class="{ 'bg-accent/20': $page.url.startsWith('/staff') }"
                >
                    <svg class="w-4 h-4 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                    <span :class="{ 'hidden': isCollapsed }">Staff</span>
                </Link>
                
                <Link
                    href="/reports"
                    class="flex items-center px-2 py-1 text-sm font-medium rounded-lg transition-colors duration-200 hover:bg-gradient-to-r hover:from-accent/20 hover:to-accent-hover/20"
                    :class="{ 'bg-accent/20': $page.url.startsWith('/reports') }"
                >
                    <svg class="w-4 h-4 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span :class="{ 'hidden': isCollapsed }">Reports</span>
                </Link>
            </nav>
        </div>
    </aside>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

const isCollapsed = ref(false);

const toggleCollapse = () => {
    isCollapsed.value = !isCollapsed.value;
};
</script>
