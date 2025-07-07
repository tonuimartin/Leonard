<script setup>
defineProps({
    type: {
        type: String,
        default: "button",
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center rounded-xl border border-red-200 bg-white px-6 py-3 text-sm font-semibold uppercase tracking-wide text-red-900 shadow-lg transition duration-200 ease-in-out hover:bg-red-50 hover:border-red-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-25 transform hover:scale-105"
    >
        <slot />
    </button>
</template>
