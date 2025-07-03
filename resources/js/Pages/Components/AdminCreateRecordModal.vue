<template>
    <!-- Create Record Modal -->
    <div
        v-if="showModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
    >
        <div
            class="relative top-10 mx-auto p-5 border w-[600px] shadow-lg rounded-md bg-white"
        >
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    Create New Record
                </h3>
                <form @submit.prevent="handleSubmit">
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Supplier Selection -->
                        <div class="col-span-2 mb-4">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                            >
                                Supplier
                            </label>
                            <select
                                v-model="formData.supplier_id"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
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
                        <div class="mb-4">
                            <div class="flex items-center mb-2">
                                <label
                                    class="block text-gray-700 text-sm font-bold mr-4"
                                >
                                    Lorry Calculation
                                </label>
                                <div class="flex bg-gray-200 rounded p-1">
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
                                    class="block text-gray-700 text-sm font-bold mb-2"
                                >
                                    Lorry Units (m³)
                                </label>
                                <input
                                    v-model.number="formData.lorry_units"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    @input="calculateProfits"
                                />
                                <p class="text-xs text-gray-500 mt-1">
                                    B.P: KSh 2,000, S.P: KSh 2,200, Profit per
                                    m³: KSh 200
                                </p>
                            </div>

                            <div v-else>
                                <label
                                    class="block text-gray-700 text-sm font-bold mb-2"
                                >
                                    Money to Spend on Lorry (KSh)
                                </label>
                                <input
                                    v-model.number="formData.lorry_money"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    @input="calculateFromMoney('lorry')"
                                    placeholder="0.00"
                                />
                                <p class="text-xs text-gray-500 mt-1">
                                    B.P: KSh 2,000, S.P: KSh 2,200, Profit per
                                    m³: KSh 200
                                    {{
                                        (formData.lorry_money / 2000).toFixed(2)
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
                                <div class="flex bg-gray-200 rounded p-1">
                                    <button
                                        type="button"
                                        @click="
                                            tractorCalculationType = 'money'
                                        "
                                        :class="[
                                            'px-3 py-1 text-xs rounded transition-colors',
                                            tractorCalculationType === 'money'
                                                ? 'bg-green-500 text-white'
                                                : 'text-gray-700 hover:bg-gray-300',
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
                                    class="block text-gray-700 text-sm font-bold mb-2"
                                >
                                    Tractor Units (m³)
                                </label>
                                <input
                                    v-model.number="formData.tractor_units"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    @input="calculateProfits"
                                />
                                <p class="text-xs text-gray-500 mt-1">
                                    B.P: KSh 2,200, S.P: KSh 2,400, Profit per
                                    m³: KSh 200
                                </p>
                            </div>

                            <div v-else>
                                <label
                                    class="block text-gray-700 text-sm font-bold mb-2"
                                >
                                    Money to Spend on Tractor (KSh)
                                </label>
                                <input
                                    v-model.number="formData.tractor_money"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    @input="calculateFromMoney('tractor')"
                                    placeholder="0.00"
                                />
                                <p class="text-xs text-gray-500 mt-1">
                                    B.P: KSh 2,200, S.P: KSh 2,400, Profit per
                                    m³: KSh 200
                                    {{
                                        (formData.tractor_money / 2200).toFixed(
                                            2
                                        )
                                    }}
                                    m³
                                </p>
                            </div>
                        </div>

                        <!-- Confirmed Cubic Meters -->
                        <div class="mb-4">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                            >
                                Confirmed Cubic Meters
                            </label>
                            <input
                                v-model.number="formData.confirmed_cubic_meters"
                                type="number"
                                step="0.01"
                                min="0"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            />
                        </div>

                        <!-- Extra Cubic -->
                        <div class="mb-4">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                            >
                                Extra Cubic
                            </label>
                            <input
                                v-model.number="formData.extra_cubic"
                                type="number"
                                step="0.01"
                                min="0"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            />
                        </div>

                        <!-- Less Cubic -->
                        <div class="mb-4">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                            >
                                Less Cubic
                            </label>
                            <input
                                v-model.number="formData.less_cubic"
                                type="number"
                                step="0.01"
                                min="0"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
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

                    <div class="flex items-center justify-between">
                        <button
                            type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        >
                            Create Record
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
