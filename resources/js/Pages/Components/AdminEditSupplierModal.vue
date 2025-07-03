<template>
    <!-- Edit Supplier Modal -->
    <div
        v-if="showModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
    >
        <div
            class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white"
        >
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    Edit Supplier
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
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        >
                            Update Supplier
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
    supplierData: {
        type: Object,
        default: () => ({}),
    },
});

const emit = defineEmits(["close", "updated"]);

const formData = ref({
    name: "",
    phone_number: "",
});

// Watch for changes in supplierData prop and populate form
watch(
    () => props.supplierData,
    (newData) => {
        if (newData && Object.keys(newData).length > 0) {
            formData.value = {
                name: newData.name || "",
                phone_number: newData.phone_number
                    ? String(newData.phone_number)
                    : "",
            };
        }
    },
    { immediate: true }
);

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
    if (!props.supplierData.id) {
        alert("Error: No supplier ID provided");
        return;
    }

    // Ensure phone_number is always a string
    const submitData = {
        supplier_name: formData.value.name,
        phone_number: formData.value.phone_number
            ? String(formData.value.phone_number)
            : "",
        _method: "PUT", // Laravel method spoofing
    };

    try {
        const response = await fetch(`/supplier/${props.supplierData.id}`, {
            method: "POST", // Use POST with method spoofing
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                "Content-Type": "application/json",
            },
            body: JSON.stringify(submitData),
        });

        if (response.ok) {
            emit("updated");
            emit("close");
            // Refresh the page to show updated data
            router.reload();
        } else {
            const errorData = await response.json();
            alert(
                "Error updating supplier: " +
                    (errorData.message || "Unknown error")
            );
        }
    } catch (error) {
        console.error("Error:", error);
        alert("Error updating supplier");
    }
};

const handleCancel = () => {
    emit("close");
};
</script>
