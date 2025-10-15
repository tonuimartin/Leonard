<template>
    <aside class="w-64 bg-gradient-to-b from-[#1F2937] via-[#1a202c] to-[#1F2937] text-white flex-shrink-0">
        <div class="p-4">
            <div class="mb-6">
                <h2 class="text-lg font-display font-bold text-white">Navigation</h2>
            </div>
            <nav class="space-y-1">
                <Link
                    href="/dashboard"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 hover:bg-gradient-to-r hover:from-accent/20 hover:to-accent-hover/20"
                    :class="{ 'bg-accent/20': $page.url === '/dashboard' }"
                >
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </Link>
            </nav>
        </div>
    </aside>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
</script>
