<template>
    <!-- Create Staff Modal -->
    <div
        v-if="showModal"
        class="fixed inset-0 bg-gray-900 bg-opacity-75 overflow-y-auto h-full w-full z-50 backdrop-blur-sm"
    >
        <div
            class="relative top-20 mx-auto p-4 border w-full max-w-md shadow-2xl rounded-2xl bg-white/95 backdrop-blur-lg border-accent/20"
        >
            <div class="mt-2">
                <div class="mb-3">
                    <h3 class="text-xl font-display font-bold text-[#1F2937] mb-1">
                        Create Staff Member
                    </h3>
                    <p class="text-accent text-sm">
                        Add a new team member
                    </p>
                </div>
                <form @submit.prevent="handleSubmit" class="space-y-3">
                    <div>
                        <label class="block text-[#1F2937] text-sm font-semibold mb-1.5 font-body">Name</label>
                        <input
                            v-model="formData.name"
                            type="text"
                            class="w-full py-2 px-3 rounded-lg border border-[#D1D5DB] bg-white/90 text-gray-900 leading-tight focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent shadow-sm transition-all duration-200"
                            placeholder="Enter name"
                            required
                        />
                    </div>
                    <div>
                        <label class="block text-[#1F2937] text-sm font-semibold mb-1.5 font-body">Email</label>
                        <input
                            v-model="formData.email"
                            type="email"
                            class="w-full py-2 px-3 rounded-lg border border-[#D1D5DB] bg-white/90 text-gray-900 leading-tight focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent shadow-sm transition-all duration-200"
                            placeholder="Enter email"
                            required
                        />
                    </div>
                    <div class="flex gap-3 pt-3">
                        <button
                            type="submit"
                            class="flex-1 bg-gradient-to-r from-accent to-accent-hover hover:from-accent-hover hover:to-accent-dark text-white font-semibold py-2 px-4 rounded-lg transition-all duration-200 transform hover:scale-[1.01] shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2"
                            :disabled="loading"
                        >
                            Create
                        </button>
                        <button
                            type="button"
                            @click="handleCancel"
                            class="flex-1 bg-white border border-[#D1D5DB] hover:bg-gray-50 text-[#1F2937] font-semibold py-2 px-4 rounded-lg transition-all duration-200 transform hover:scale-[1.01] shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2"
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
import { ref } from "vue";

const props = defineProps({
    showModal: Boolean
});

const emit = defineEmits(["close", "created"]);

const formData = ref({
    name: "",
    email: ""
});

const loading = ref(false);

const handleSubmit = () => {
    emit("created", formData.value);
    emit("close");
};

const handleCancel = () => {
    emit("close");
};
</script>
