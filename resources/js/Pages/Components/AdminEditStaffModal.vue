<template>
    <!-- Edit Staff Modal -->
    <div
        v-if="showModal"
        class="fixed inset-0 bg-gray-900 bg-opacity-75 overflow-y-auto h-full w-full z-50 backdrop-blur-sm"
    >
        <div
            class="relative top-20 mx-auto p-8 border w-full max-w-md shadow-2xl rounded-3xl bg-white/95 backdrop-blur-lg border-red-200"
        >
            <div class="mt-3">
                <div class="mb-6">
                    <h3 class="text-2xl font-bold text-red-900 mb-2">
                        Edit Staff Member
                    </h3>
                    <p class="text-red-600">Update team member information</p>
                </div>
                <form @submit.prevent="handleSubmit" class="space-y-6">
                    <div>
                        <label
                            class="block text-red-900 text-sm font-semibold mb-3"
                            >Name</label
                        >
                        <input
                            v-model="formData.name"
                            type="text"
                            class="w-full py-3 px-4 rounded-xl border border-red-200 bg-white/90 text-gray-900 leading-tight focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent shadow-lg transition-all duration-200"
                            placeholder="Enter full name"
                            required
                        />
                    </div>
                    <div>
                        <label
                            class="block text-red-900 text-sm font-semibold mb-3"
                            >Email</label
                        >
                        <input
                            v-model="formData.email"
                            type="email"
                            class="w-full py-3 px-4 rounded-xl border border-red-200 bg-white/90 text-gray-900 leading-tight focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent shadow-lg transition-all duration-200"
                            placeholder="Enter email address"
                            required
                        />
                    </div>
                    <div>
                        <label
                            class="block text-red-900 text-sm font-semibold mb-3"
                            >Phone Number</label
                        >
                        <input
                            v-model="formData.phone_number"
                            type="text"
                            class="w-full py-3 px-4 rounded-xl border border-red-200 bg-white/90 text-gray-900 leading-tight focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent shadow-lg transition-all duration-200"
                            placeholder="Enter phone number"
                        />
                    </div>
                    <div class="flex gap-4 pt-4">
                        <button
                            type="submit"
                            class="flex-1 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-[1.02] shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 flex items-center justify-center"
                            :disabled="loading"
                        >
                            <span
                                v-if="loading"
                                class="animate-spin mr-2 h-5 w-5 border-2 border-white border-t-transparent rounded-full"
                            ></span>
                            <span>{{
                                loading ? "Updating..." : "Update Staff"
                            }}</span>
                        </button>
                        <button
                            type="button"
                            @click="handleCancel"
                            class="flex-1 bg-white border border-red-200 hover:bg-red-50 text-red-900 font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-[1.02] shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                            :disabled="loading"
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

const emit = defineEmits(["close", "updated", "error"]);

const formData = ref({
    name: "",
    email: "",
    phone_number: "",
});

const loading = ref(false);

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
            loading.value = false;
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
        emit("error", { message: "No staff ID provided" });
        return;
    }
    loading.value = true;
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
        const response = await fetch(`/staff/${props.staffData.id}`, {
            method: "POST", // Use POST with method spoofing
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify(submitData),
        });

        if (response.ok) {
            let updatedStaff = null;
            try {
                updatedStaff = await response.json();
            } catch (e) {
                // If not JSON, fallback to local data
                updatedStaff = null;
            }
            if (!updatedStaff || !updatedStaff.id) {
                // Fallback: use local form data and id
                updatedStaff = { ...formData.value, id: props.staffData.id };
            }
            emit("updated", updatedStaff);
            emit("close");
            loading.value = false;
        } else {
            const errorData = await response.json();
            emit("error", errorData);
            loading.value = false;
        }
    } catch (error) {
        emit("error", error);
        loading.value = false;
    }
};

const handleCancel = () => {
    emit("close");
};
</script>
