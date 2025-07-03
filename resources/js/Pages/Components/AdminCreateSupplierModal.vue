<template>
    <!-- Create Supplier Modal -->
    <div
        v-if="showModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
    >
        <div
            class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white"
        >
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    Create New Supplier
                </h3>
                <form @submit.prevent="handleSubmit">
                    <div class="mb-4">
                        <label
                            class="block text-gray-700 text-sm font-bold mb-2"
                            >Name</label
                        >
                        <input
                            v-model="formData.name"
                            type="text"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required
                        />
                    </div>
                    <div class="mb-4">
                        <label
                            class="block text-gray-700 text-sm font-bold mb-2"
                            >Phone Number</label
                        >
                        <input
                            v-model="formData.phone_number"
                            type="text"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        />
                    </div>
                    <div class="flex items-center justify-between">
                        <button
                            type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        >
                            Create Supplier
                        </button>
                        <button
                            type="button"
                            @click="handleCancel"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        >
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    showModal: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["close", "created"]);

const formData = ref({
    name: "",
    phone_number: "",
});

// Reset form when modal closes
watch(
    () => props.showModal,
    (newVal) => {
        if (!newVal) {
            resetForm();
        }
    }
);

const resetForm = () => {
    formData.value = {
        name: "",
        phone_number: "",
    };
};

const handleSubmit = async () => {
    // Ensure phone_number is always a string
    const submitData = {
        name: formData.value.name,
        phone_number: formData.value.phone_number
            ? String(formData.value.phone_number)
            : "",
    };

    try {
        const response = await fetch("/supplier", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                "Content-Type": "application/json",
            },
            body: JSON.stringify(submitData),
        });

        if (response.ok) {
            emit("created");
            emit("close");
            // Refresh the page to show updated data
            router.reload();
        } else {
            const errorData = await response.json();
            alert(
                "Error creating supplier: " +
                    (errorData.message || "Unknown error")
            );
        }
    } catch (error) {
        console.error("Error:", error);
        alert("Error creating supplier");
    }
};

const handleCancel = () => {
    emit("close");
};
</script>
