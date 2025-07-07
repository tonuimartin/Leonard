<template>
    <!-- Create Record Modal -->
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
                        Create New Record
                    </h3>
                    <p class="text-red-600">
                        Add a new transportation record to the system
                    </p>
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
                                <div
                                    class="flex bg-red-100 rounded-xl p-1 shadow-lg"
                                >
                                    <button
                                        type="button"
                                        @click="lorryCalculationType = 'money'"
                                        :class="[
                                            'px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200',
                                            lorryCalculationType === 'money'
                                                ? 'bg-red-600 text-white shadow-md'
                                                : 'text-red-700 hover:bg-red-200',
                                        ]"
                                    >
                                        By Money
                                    </button>
                                    <button
                                        type="button"
                                        @click="lorryCalculationType = 'units'"
                                        :class="[
                                            'px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200',
                                            lorryCalculationType === 'units'
                                                ? 'bg-red-600 text-white shadow-md'
                                                : 'text-red-700 hover:bg-red-200',
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
                                    @input="calculateProfits"
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
                                    B.P: KSh 2,000, S.P: KSh 2,200, Profit per
                                    m³: KSh 200 ({{
                                        (formData.lorry_money / 2000).toFixed(2)
                                    }}
                                    m³)
                                </p>
                            </div>
                        </div>

                        <!-- Tractor Section -->
                        <div>
                            <div class="flex items-center mb-3">
                                <label
                                    class="block text-red-900 text-sm font-semibold mr-4"
                                >
                                    Tractor Calculation
                                </label>
                                <div
                                    class="flex bg-green-100 rounded-xl p-1 shadow-lg"
                                >
                                    <button
                                        type="button"
                                        @click="
                                            tractorCalculationType = 'money'
                                        "
                                        :class="[
                                            'px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200',
                                            tractorCalculationType === 'money'
                                                ? 'bg-green-600 text-white shadow-md'
                                                : 'text-green-700 hover:bg-green-200',
                                        ]"
                                    >
                                        By Money
                                    </button>
                                    <button
                                        type="button"
                                        @click="
                                            tractorCalculationType = 'units'
                                        "
                                        :class="[
                                            'px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200',
                                            tractorCalculationType === 'units'
                                                ? 'bg-green-600 text-white shadow-md'
                                                : 'text-green-700 hover:bg-green-200',
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
                                    @input="calculateProfits"
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
                                    B.P: KSh 2,200, S.P: KSh 2,400, Profit per
                                    m³: KSh 200 ({{
                                        (formData.tractor_money / 2200).toFixed(
                                            2
                                        )
                                    }}
                                    m³)
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
                                    {{ actualLorryUnits.toFixed(2) }} m³ × KSh
                                    200
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
                                    {{ actualTractorUnits.toFixed(2) }} m³ × KSh
                                    200
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
                                            actualLorryUnits +
                                            actualTractorUnits
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
                            class="flex-1 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-[1.02] shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                        >
                            Create Record
                        </button>
                        <button
                            type="button"
                            @click="handleCancel"
                            class="flex-1 bg-white border border-red-200 hover:bg-red-50 text-red-900 font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-[1.02] shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
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
import { router } from "@inertiajs/vue3";

const props = defineProps({
    showModal: {
        type: Boolean,
        default: false,
    },
    suppliers: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(["close", "created"]);

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

// Pricing constants
const LORRY_BUYING_PRICE = 2000;
const LORRY_SELLING_PRICE = 2200;
const TRACTOR_BUYING_PRICE = 2200;
const TRACTOR_SELLING_PRICE = 2400;
const PROFIT_PER_CUBIC = 200;

// Computed properties for actual units
const actualLorryUnits = computed(() => {
    return lorryCalculationType.value === "units"
        ? formData.value.lorry_units
        : formData.value.lorry_money / LORRY_BUYING_PRICE;
});

const actualTractorUnits = computed(() => {
    return tractorCalculationType.value === "units"
        ? formData.value.tractor_units
        : formData.value.tractor_money / TRACTOR_BUYING_PRICE;
});

// Computed properties for profits
const calculatedLorryProfit = computed(() => {
    return actualLorryUnits.value * PROFIT_PER_CUBIC;
});

const calculatedTractorProfit = computed(() => {
    return actualTractorUnits.value * PROFIT_PER_CUBIC;
});

const calculatedTotalProfit = computed(() => {
    return calculatedLorryProfit.value + calculatedTractorProfit.value;
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

const calculateProfits = () => {
    // This method can be used for any additional calculations if needed
    // The computed properties handle most of the work automatically
};

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
    // Prepare data with actual units for submission
    const submitData = {
        ...formData.value,
        lorry_units: actualLorryUnits.value,
        tractor_units: actualTractorUnits.value,
        expected_profit_lorry: calculatedLorryProfit.value,
        expected_profit_tractor: calculatedTractorProfit.value,
        total_expected_profit: calculatedTotalProfit.value,
    };

    try {
        const response = await fetch("/records", {
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
            router.reload();
        } else {
            const errorData = await response.json();
            alert(
                "Error creating record: " +
                    (errorData.message || "Unknown error")
            );
        }
    } catch (error) {
        console.error("Error:", error);
        alert("Error creating record");
    }
};

const handleCancel = () => {
    emit("close");
};
</script>
