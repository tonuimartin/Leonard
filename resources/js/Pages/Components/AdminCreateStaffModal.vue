<template>
    <!-- Create Staff Modal -->
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
                        Create New Staff
                    </h3>
                    <p class="text-red-600">
                        Add a new team member to your organization
                    </p>
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
                    <div>
                        <label
                            class="block text-red-900 text-sm font-semibold mb-3"
                            >Password</label
                        >
                        <input
                            v-model="formData.password"
                            type="password"
                            class="w-full py-3 px-4 rounded-xl border border-red-200 bg-white/90 text-gray-900 leading-tight focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent shadow-lg transition-all duration-200"
                            placeholder="Enter password"
                            required
                        />
                    </div>
                    <div class="flex gap-4 pt-4">
                        <button
                            type="submit"
                            class="flex-1 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-[1.02] shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 flex items-center justify-center"
                            :disabled="loading"
                        >
                            <span
                                v-if="loading"
                                class="animate-spin mr-2 h-5 w-5 border-2 border-white border-t-transparent rounded-full"
                            ></span>
                            <span>{{
                                loading ? "Creating..." : "Create Staff"
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
});

const emit = defineEmits(["close", "created", "error"]);

const formData = ref({
    name: "",
    email: "",
    phone_number: "",
    password: "",
});

const loading = ref(false);

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
        password: "",
    };
};

const handleSubmit = async () => {
    loading.value = true;
    // Ensure phone_number is always a string
    const submitData = {
        name: formData.value.name,
        email: formData.value.email,
        phone_number: formData.value.phone_number
            ? String(formData.value.phone_number)
            : "",
        password: formData.value.password,
    };

    try {
        router.post("/staff", submitData, {
            onSuccess: (page) => {
                // Find the created staff from the response if available
                let newStaff = null;
                if (page && page.props && page.props.staff) {
                    // Find the staff with the highest id (assuming auto-increment)
                    newStaff = Array.isArray(page.props.staff)
                        ? page.props.staff.reduce(
                              (a, b) => (a.id > b.id ? a : b),
                              { id: 0 }
                          )
                        : null;
                }
                emit("created", newStaff);
                emit("close");
                resetForm();
                loading.value = false;
            },
            onError: (errors) => {
                emit("error", errors);
                loading.value = false;
            },
        });
    } catch (error) {
        emit("error", error);
        loading.value = false;
    }
};

const handleCancel = () => {
    emit("close");
};
</script>
