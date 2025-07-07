<script setup>
import { onMounted, ref } from "vue";

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="rounded-xl border-gray-300 shadow-lg focus:border-red-500 focus:ring-red-500 focus:ring-2 transition duration-200 ease-in-out hover:shadow-xl bg-white px-4 py-3"
        v-model="model"
        ref="input"
    />
</template>
