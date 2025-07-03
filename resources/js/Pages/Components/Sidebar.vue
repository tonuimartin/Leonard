<template>
    <aside
        class="w-64 min-h-screen h-full bg-white border-r border-gray-200 p-6 flex flex-col gap-4 shadow-sm justify-start sticky top-0"
        style="
            display: flex !important;
            background-color: #ffffff !important;
            border-right: 1px solid #e5e7eb !important;
        "
    >
        <div class="text-lg font-semibold mb-4 text-gray-800">Menu</div>
        <nav class="flex flex-col gap-3 mt-8">
            <span
                class="text-gray-700 hover:text-blue-600 cursor-pointer transition"
                @click="goToStaff"
                >Staff</span
            >
            <span
                class="text-gray-700 hover:text-blue-600 cursor-pointer transition"
                @click="goToSupplier"
                >Suppliers</span
            >
            <span
                class="text-gray-700 hover:text-blue-600 cursor-pointer transition"
                @click="goToRecords"
                >Records</span
            >
            <span
                class="text-gray-700 hover:text-blue-600 cursor-pointer transition"
                @click="goToReports"
                >Reports</span
            >
        </nav>
    </aside>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
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
