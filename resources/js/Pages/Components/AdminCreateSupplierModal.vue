<template>
    <!-- Create Supplier Modal -->
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
                        Create New Supplier
                    </h3>
                    <p class="text-red-600">
                        Add a new supplier to your organization
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
                            placeholder="Enter supplier name"
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
                            class="flex-1 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-[1.02] shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 flex items-center justify-center"
                            :disabled="loading"
                        >
                            <span
                                v-if="loading"
                                class="animate-spin mr-2 h-5 w-5 border-2 border-white border-t-transparent rounded-full"
                            ></span>
                            <span>{{
                                loading ? "Creating..." : "Create Supplier"
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
    phone_number: "",
});

const loading = ref(false);

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
    loading.value = true;
    // Ensure phone_number is always a string
    const submitData = {
        name: formData.value.name,
        phone_number: formData.value.phone_number
            ? String(formData.value.phone_number)
            : "",
    };

    console.log("[Supplier Modal] Submitting:", submitData);

    try {
        const response = await fetch("/supplier", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify(submitData),
        });

        console.log("[Supplier Modal] Response status:", response.status);

        if (response.ok) {
            let newSupplier = null;
            try {
                newSupplier = await response.json();
                console.log("[Supplier Modal] Backend returned:", newSupplier);
            } catch (e) {
                console.error("[Supplier Modal] Error parsing JSON:", e);
                newSupplier = null;
            }
            if (!newSupplier || !newSupplier.id) {
                console.error(
                    "[Supplier Modal] No valid supplier returned from backend:",
                    newSupplier
                );
                emit("error", {
                    message: "Failed to create supplier. Please try again.",
                });
                loading.value = false;
                return;
            }
            emit("created", newSupplier);
            console.log("[Supplier Modal] Emitted created:", newSupplier);
            emit("close");
            loading.value = false;
        } else {
            let errorData = null;
            try {
                errorData = await response.json();
            } catch (e) {
                errorData = { message: "Unknown error" };
            }
            console.error("[Supplier Modal] Backend error:", errorData);
            emit("error", errorData);
            loading.value = false;
        }
    } catch (error) {
        console.error("[Supplier Modal] Network or JS error:", error);
        emit("error", error);
        loading.value = false;
    }
};

const handleCancel = () => {
    emit("close");
};
</script>

<style scoped>
/* Add any additional styles here if needed */
</style>
