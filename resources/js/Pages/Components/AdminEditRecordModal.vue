<template>
    <!-- Edit Record Modal -->
    <div
        v-if="showModal"
        class="fixed inset-0 bg-gray-900 bg-opacity-75 overflow-y-auto h-full w-full z-50 backdrop-blur-sm"
    >
        <div
            class="relative top-10 mx-auto p-8 border w-[700px] shadow-2xl rounded-3xl bg-white/95 backdrop-blur-lg border-red-200"
        >
            <div class="mt-3">
                <div class="mb-6">
                    <h3 class="text-2xl font-bold text-red-900 mb-2">
                        Edit Record
                        {{ recordData?.id ? `(ID: ${recordData.id})` : "" }}
                    </h3>
                    <p class="text-red-600">
                        Update transportation record information
                    </p>
                </div>
                <!-- Debug info -->
                <div
                    v-if="true"
                    class="mb-4 text-xs text-red-600 bg-red-50 p-2 rounded-lg"
                >
                    Debug: Modal={{ showModal }}, RecordID={{ recordData?.id }},
                    Suppliers={{ suppliers.length }}
                </div>
                <form @submit.prevent="handleSubmit" class="space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Supplier Selection -->
                        <div class="col-span-2">
                            <label
                                class="block text-red-900 text-sm font-semibold mb-3"
                            >
                                Supplier
                            </label>
                            <select
                                v-model="formData.supplier_id"
                                class="w-full py-3 px-4 rounded-xl border border-red-200 bg-white/90 text-gray-900 leading-tight focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent shadow-lg transition-all duration-200"
                                required
                            >
                                <option value="">Select Supplier</option>
                                <option
                                    v-for="supplier in suppliers"
                                    :key="supplier.id"
                                    :value="supplier.id"
                                >
                                    {{ supplier.name }}
                                </option>
                            </select>
                        </div>

                        <!-- Lorry Section -->
                        <div>
                            <div class="flex items-center mb-3">
                                <label
                                    class="block text-red-900 text-sm font-semibold mr-4"
                                >
                                    Lorry Calculation
                                </label>

                                <button
                                    type="button"
                                    @click="lorryCalculationType = 'money'"
                                    :class="[
                                        'px-3 py-1 text-xs rounded transition-colors',
                                        lorryCalculationType === 'money'
                                            ? 'bg-blue-500 text-white'
                                            : 'text-gray-700 hover:bg-gray-300',
                                    ]"
                                >
                                    By Money
                                </button>

                                <div class="flex bg-gray-200 rounded p-1">
                                    <button
                                        type="button"
                                        @click="lorryCalculationType = 'units'"
                                        :class="[
                                            'px-3 py-1 text-xs rounded transition-colors',
                                            lorryCalculationType === 'units'
                                                ? 'bg-blue-500 text-white'
                                                : 'text-gray-700 hover:bg-gray-300',
                                        ]"
                                    >
                                        By Units
                                    </button>
                                </div>
                            </div>

                            <div v-if="lorryCalculationType === 'units'">
                                <label
                                    class="block text-red-900 text-sm font-semibold mb-3"
                                >
                                    Lorry Units (m³)
                                </label>
                                <input
                                    v-model.number="formData.lorry_units"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    class="w-full py-3 px-4 rounded-xl border border-red-200 bg-white/90 text-gray-900 leading-tight focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent shadow-lg transition-all duration-200"
                                    @input="calculateFromUnits('lorry')"
                                    placeholder="Enter units in m³"
                                />
                                <p
                                    class="text-xs text-red-600 mt-2 bg-red-50 p-2 rounded-lg"
                                >
                                    B.P: KSh 2,000, S.P: KSh 2,200, Profit per
                                    m³: KSh 200
                                </p>
                            </div>

                            <div v-else>
                                <label
                                    class="block text-red-900 text-sm font-semibold mb-3"
                                >
                                    Money to Spend on Lorry (KSh)
                                </label>
                                <input
                                    v-model.number="formData.lorry_money"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    class="w-full py-3 px-4 rounded-xl border border-red-200 bg-white/90 text-gray-900 leading-tight focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent shadow-lg transition-all duration-200"
                                    @input="calculateFromMoney('lorry')"
                                    placeholder="Enter amount in KSh"
                                />
                                <p
                                    class="text-xs text-red-600 mt-2 bg-red-50 p-2 rounded-lg"
                                >
                                    Cost per m³: KSh 2,000 | Units:
                                    {{
                                        (
                                            (formData.lorry_money || 0) / 2000
                                        ).toFixed(2)
                                    }}
                                    m³
                                </p>
                            </div>
                        </div>

                        <!-- Tractor Section -->
                        <div class="mb-4">
                            <div class="flex items-center mb-2">
                                <label
                                    class="block text-gray-700 text-sm font-bold mr-4"
                                >
                                    Tractor Calculation
                                </label>

                                <button
                                    type="button"
                                    @click="tractorCalculationType = 'money'"
                                    :class="[
                                        'px-3 py-1 text-xs rounded transition-colors',
                                        tractorCalculationType === 'money'
                                            ? 'bg-green-500 text-white'
                                            : 'text-gray-700 hover:bg-gray-300',
                                    ]"
                                >
                                    By Money
                                </button>
                                <div class="flex bg-gray-200 rounded p-1">
                                    <button
                                        type="button"
                                        @click="
                                            tractorCalculationType = 'units'
                                        "
                                        :class="[
                                            'px-3 py-1 text-xs rounded transition-colors',
                                            tractorCalculationType === 'units'
                                                ? 'bg-green-500 text-white'
                                                : 'text-gray-700 hover:bg-gray-300',
                                        ]"
                                    >
                                        By Units
                                    </button>
                                </div>
                            </div>

                            <div v-if="tractorCalculationType === 'units'">
                                <label
                                    class="block text-red-900 text-sm font-semibold mb-3"
                                >
                                    Tractor Units (m³)
                                </label>
                                <input
                                    v-model.number="formData.tractor_units"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    class="w-full py-3 px-4 rounded-xl border border-red-200 bg-white/90 text-gray-900 leading-tight focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent shadow-lg transition-all duration-200"
                                    @input="calculateFromUnits('tractor')"
                                    placeholder="Enter units in m³"
                                />
                                <p
                                    class="text-xs text-red-600 mt-2 bg-red-50 p-2 rounded-lg"
                                >
                                    B.P: KSh 2,200, S.P: KSh 2,400, Profit per
                                    m³: KSh 200
                                </p>
                            </div>

                            <div v-else>
                                <label
                                    class="block text-red-900 text-sm font-semibold mb-3"
                                >
                                    Money to Spend on Tractor (KSh)
                                </label>
                                <input
                                    v-model.number="formData.tractor_money"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    class="w-full py-3 px-4 rounded-xl border border-red-200 bg-white/90 text-gray-900 leading-tight focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent shadow-lg transition-all duration-200"
                                    @input="calculateFromMoney('tractor')"
                                    placeholder="Enter amount in KSh"
                                />
                                <p
                                    class="text-xs text-red-600 mt-2 bg-red-50 p-2 rounded-lg"
                                >
                                    Cost per m³: KSh 2,200 | Units:
                                    {{
                                        (
                                            (formData.tractor_money || 0) / 2200
                                        ).toFixed(2)
                                    }}
                                    m³
                                </p>
                            </div>
                        </div>

                        <!-- Confirmed Cubic Meters -->
                        <div>
                            <label
                                class="block text-red-900 text-sm font-semibold mb-3"
                            >
                                Confirmed Cubic Meters
                            </label>
                            <input
                                v-model.number="formData.confirmed_cubic_meters"
                                type="number"
                                step="0.01"
                                min="0"
                                class="w-full py-3 px-4 rounded-xl border border-red-200 bg-white/90 text-gray-900 leading-tight focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent shadow-lg transition-all duration-200"
                                placeholder="Enter confirmed cubic meters"
                            />
                        </div>

                        <!-- Extra Cubic -->
                        <div>
                            <label
                                class="block text-red-900 text-sm font-semibold mb-3"
                            >
                                Extra Cubic
                            </label>
                            <input
                                v-model.number="formData.extra_cubic"
                                type="number"
                                step="0.01"
                                min="0"
                                class="w-full py-3 px-4 rounded-xl border border-red-200 bg-white/90 text-gray-900 leading-tight focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent shadow-lg transition-all duration-200"
                                placeholder="Enter extra cubic meters"
                            />
                        </div>

                        <!-- Less Cubic -->
                        <div>
                            <label
                                class="block text-red-900 text-sm font-semibold mb-3"
                            >
                                Less Cubic
                            </label>
                            <input
                                v-model.number="formData.less_cubic"
                                type="number"
                                step="0.01"
                                min="0"
                                class="w-full py-3 px-4 rounded-xl border border-red-200 bg-white/90 text-gray-900 leading-tight focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent shadow-lg transition-all duration-200"
                                placeholder="Enter less cubic meters"
                            />
                        </div>
                    </div>

                    <!-- Profit Summary -->
                    <div class="mb-4 p-4 bg-gray-100 rounded">
                        <h4 class="font-bold text-gray-700 mb-2">
                            Expected Profit Summary:
                        </h4>
                        <div class="grid grid-cols-3 gap-4 text-sm">
                            <div>
                                <p>
                                    <strong>Lorry Profit:</strong>
                                    {{ formatCurrency(calculatedLorryProfit) }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ (actualLorryUnits || 0).toFixed(2) }} m³
                                    × KSh 200
                                </p>
                            </div>
                            <div>
                                <p>
                                    <strong>Tractor Profit:</strong>
                                    {{
                                        formatCurrency(calculatedTractorProfit)
                                    }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ (actualTractorUnits || 0).toFixed(2) }}
                                    m³ × KSh 200
                                </p>
                            </div>
                            <div>
                                <p>
                                    <strong>Total Profit:</strong>
                                    {{ formatCurrency(calculatedTotalProfit) }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    Total:
                                    {{
                                        (
                                            (actualLorryUnits || 0) +
                                            (actualTractorUnits || 0)
                                        ).toFixed(2)
                                    }}
                                    m³
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4 pt-6">
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
                                loading ? "Updating..." : "Update Record"
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
import { ref, watch, computed } from "vue";
import Swal from "sweetalert2";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    showModal: {
        type: Boolean,
        default: false,
    },
    recordData: {
        type: Object,
        default: () => ({}),
    },
    suppliers: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(["close", "updated", "error"]);

const formData = ref({
    supplier_id: "",
    lorry_units: 0,
    tractor_units: 0,
    lorry_money: 0,
    tractor_money: 0,
    confirmed_cubic_meters: 0,
    extra_cubic: 0,
    less_cubic: 0,
});

const lorryCalculationType = ref("money");
const tractorCalculationType = ref("money");
const loading = ref(false);

// Pricing constants
const LORRY_BUYING_PRICE = 2000;
const LORRY_SELLING_PRICE = 2200;
const TRACTOR_BUYING_PRICE = 2200;
const TRACTOR_SELLING_PRICE = 2400;
const PROFIT_PER_CUBIC = 200;

// Computed properties for actual units
const actualLorryUnits = computed(() => {
    const units =
        lorryCalculationType.value === "units"
            ? formData.value.lorry_units
            : formData.value.lorry_money / LORRY_BUYING_PRICE;
    return parseFloat(units) || 0;
});

const actualTractorUnits = computed(() => {
    const units =
        tractorCalculationType.value === "units"
            ? formData.value.tractor_units
            : formData.value.tractor_money / TRACTOR_BUYING_PRICE;
    return parseFloat(units) || 0;
});

// Computed properties for profits
const calculatedLorryProfit = computed(() => {
    return (actualLorryUnits.value || 0) * PROFIT_PER_CUBIC;
});

const calculatedTractorProfit = computed(() => {
    return (actualTractorUnits.value || 0) * PROFIT_PER_CUBIC;
});

const calculatedTotalProfit = computed(() => {
    return (
        (calculatedLorryProfit.value || 0) +
        (calculatedTractorProfit.value || 0)
    );
});

// Currency formatting function
const formatCurrency = (amount) => {
    return new Intl.NumberFormat("en-KE", {
        style: "currency",
        currency: "KES",
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    }).format(amount || 0);
};

// Calculation methods
const calculateFromMoney = (vehicleType) => {
    if (vehicleType === "lorry") {
        formData.value.lorry_units =
            formData.value.lorry_money / LORRY_BUYING_PRICE;
    } else if (vehicleType === "tractor") {
        formData.value.tractor_units =
            formData.value.tractor_money / TRACTOR_BUYING_PRICE;
    }
};

const calculateFromUnits = (vehicleType) => {
    if (vehicleType === "lorry") {
        formData.value.lorry_money =
            formData.value.lorry_units * LORRY_BUYING_PRICE;
    } else if (vehicleType === "tractor") {
        formData.value.tractor_money =
            formData.value.tractor_units * TRACTOR_BUYING_PRICE;
    }
};

// Watch for calculation type changes to update corresponding fields
watch(lorryCalculationType, () => {
    if (lorryCalculationType.value === "money") {
        calculateFromUnits("lorry");
    } else {
        calculateFromMoney("lorry");
    }
});

watch(tractorCalculationType, () => {
    if (tractorCalculationType.value === "money") {
        calculateFromUnits("tractor");
    } else {
        calculateFromMoney("tractor");
    }
});

// Watch for changes in recordData prop and populate form
watch(
    () => props.recordData,
    (newRecord) => {
        if (newRecord && newRecord.id) {
            console.log("Populating form with record data:", newRecord);
            const lorryUnits = parseFloat(newRecord.lorry_units) || 0;
            const tractorUnits = parseFloat(newRecord.tractor_units) || 0;

            formData.value = {
                supplier_id: newRecord.supplier_id || "",
                lorry_units: lorryUnits,
                tractor_units: tractorUnits,
                lorry_money: lorryUnits * LORRY_BUYING_PRICE,
                tractor_money: tractorUnits * TRACTOR_BUYING_PRICE,
                confirmed_cubic_meters: newRecord.confirmed_cubic_meters || 0,
                extra_cubic: newRecord.extra_cubic || 0,
                less_cubic: newRecord.less_cubic || 0,
            };

            // Default to money calculation view when modal opens
            lorryCalculationType.value = "money";
            tractorCalculationType.value = "money";
        }
    },
    { immediate: true, deep: true }
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
        supplier_id: "",
        lorry_units: 0,
        tractor_units: 0,
        lorry_money: 0,
        tractor_money: 0,
        confirmed_cubic_meters: 0,
        extra_cubic: 0,
        less_cubic: 0,
    };
    lorryCalculationType.value = "money";
    tractorCalculationType.value = "money";
};

const handleSubmit = async () => {
    if (!props.recordData.id) {
        Swal.fire({
            icon: "error",
            title: "Error!",
            text: "No record ID provided.",
            background: "#fff",
            color: "#7f1d1d",
            confirmButtonColor: "#b91c1c",
            customClass: {
                popup: "rounded-2xl shadow-2xl border border-red-100",
                title: "font-bold text-2xl bg-gradient-to-r from-red-900 to-red-700 bg-clip-text text-transparent",
                confirmButton: "rounded-xl px-6 py-2 font-semibold",
            },
            buttonsStyling: false,
        });
        return;
    }
    loading.value = true;
    const submitData = {
        ...formData.value,
        lorry_units: actualLorryUnits.value,
        tractor_units: actualTractorUnits.value,
        expected_profit_lorry: calculatedLorryProfit.value,
        expected_profit_tractor: calculatedTractorProfit.value,
        total_expected_profit: calculatedTotalProfit.value,
        _method: "PUT",
    };
    try {
        const response = await fetch(`/records/${props.recordData.id}`, {
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
            const updatedRecord = await response.json();
            emit("updated", updatedRecord);
            emit("close");
            Swal.fire({
                icon: "success",
                title: "Record Updated!",
                text: "The record was updated successfully.",
                background: "#fff",
                color: "#7f1d1d",
                confirmButtonColor: "#b91c1c",
                customClass: {
                    popup: "rounded-2xl shadow-2xl border border-red-100",
                    title: "font-bold text-2xl bg-gradient-to-r from-red-900 to-red-700 bg-clip-text text-transparent",
                    confirmButton: "rounded-xl px-6 py-2 font-semibold",
                },
                buttonsStyling: false,
            });
            resetForm();
        } else {
            const errorData = await response.json();
            emit("error", errorData);
            Swal.fire({
                icon: "error",
                title: "Error!",
                text:
                    errorData.message || "An error occurred. Please try again.",
                background: "#fff",
                color: "#7f1d1d",
                confirmButtonColor: "#b91c1c",
                customClass: {
                    popup: "rounded-2xl shadow-2xl border border-red-100",
                    title: "font-bold text-2xl bg-gradient-to-r from-red-900 to-red-700 bg-clip-text text-transparent",
                    confirmButton: "rounded-xl px-6 py-2 font-semibold",
                },
                buttonsStyling: false,
            });
        }
    } catch (error) {
        emit("error", error);
        Swal.fire({
            icon: "error",
            title: "Error!",
            text: error.message || "An error occurred. Please try again.",
            background: "#fff",
            color: "#7f1d1d",
            confirmButtonColor: "#b91c1c",
            customClass: {
                popup: "rounded-2xl shadow-2xl border border-red-100",
                title: "font-bold text-2xl bg-gradient-to-r from-red-900 to-red-700 bg-clip-text text-transparent",
                confirmButton: "rounded-xl px-6 py-2 font-semibold",
            },
            buttonsStyling: false,
        });
    } finally {
        loading.value = false;
    }
};

const handleCancel = () => {
    emit("close");
};
</script>

<style scoped>
/* Add any component-specific styles here */
</style>
