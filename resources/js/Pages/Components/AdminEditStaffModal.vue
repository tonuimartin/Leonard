<template>
    <!-- Edit Staff Modal -->
    <div
        v-if="showModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
    >
        <div
            class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white"
        >
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    Edit Staff Member
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
                            >Email</label
                        >
                        <input
                            v-model="formData.email"
                            type="email"
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
                            Update Staff
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
    staffData: {
        type: Object,
        default: () => ({}),
    },
});

const emit = defineEmits(["close", "updated"]);

const formData = ref({
    name: "",
    email: "",
    phone_number: "",
});

// Watch for changes in staffData prop and populate form
watch(
    () => props.staffData,
    (newData) => {
        if (newData && Object.keys(newData).length > 0) {
            formData.value = {
                name: newData.name || "",
                email: newData.email || "",
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
        email: "",
        phone_number: "",
    };
};

const handleSubmit = async () => {
    if (!props.staffData.id) {
        console.log("Staff Data:", props.staffData); // Debugging line
        alert("Error: No staff ID provided");
        return;
    }

    // Ensure phone_number is always a string
    const submitData = {
        name: formData.value.name,
        email: formData.value.email,
        phone_number: formData.value.phone_number
            ? String(formData.value.phone_number)
            : "",
        _method: "PUT", // Laravel method spoofing
    };

    try {
        console.log(`Making PUT request to /staff/${props.staffData.id}`); // Debugging line
        console.log("Submit data:", submitData); // Debugging line

        const response = await fetch(`/staff/${props.staffData.id}`, {
            method: "POST", // Use POST with method spoofing
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                "Content-Type": "application/json",
                Accept: "application/json", // Add this to ensure JSON response
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
            console.log("Error response:", errorData); // Debugging line
            alert(
                "Error updating staff member: " +
                    (errorData.message || "Unknown error")
            );
        }
    } catch (error) {
        console.error("Error:", error);
        alert("Error updating staff member");
    }
};

const handleCancel = () => {
    emit("close");
};
</script>
