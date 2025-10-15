<template>
    <div class="base-input-wrapper" :class="{ 'w-full': fullWidth }">
        <label
            v-if="label"
            :for="inputId"
            class="block text-sm font-semibold text-[var(--color-text)] mb-2"
        >
            {{ label }}
            <span v-if="required" class="text-error-600">*</span>
        </label>

        <div class="relative">
            <div v-if="$slots.prefix" class="absolute left-3 top-1/2 -translate-y-1/2 text-[var(--color-text-light)]">
                <slot name="prefix" />
            </div>

            <input
                :id="inputId"
                :type="type"
                :value="modelValue"
                :placeholder="placeholder"
                :disabled="disabled"
                :required="required"
                :readonly="readonly"
                :min="min"
                :max="max"
                :step="step"
                :class="inputClasses"
                @input="$emit('update:modelValue', $event.target.value)"
                @blur="$emit('blur', $event)"
                @focus="$emit('focus', $event)"
            />

            <div v-if="$slots.suffix" class="absolute right-3 top-1/2 -translate-y-1/2 text-[var(--color-text-light)]">
                <slot name="suffix" />
            </div>
        </div>

        <p v-if="error" class="mt-2 text-sm text-error-600">
            {{ error }}
        </p>

        <p v-else-if="hint" class="mt-2 text-sm text-[var(--color-text-light)]">
            {{ hint }}
        </p>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: [String, Number],
        default: ''
    },
    type: {
        type: String,
        default: 'text'
    },
    label: {
        type: String,
        default: ''
    },
    placeholder: {
        type: String,
        default: ''
    },
    error: {
        type: String,
        default: ''
    },
    hint: {
        type: String,
        default: ''
    },
    disabled: {
        type: Boolean,
        default: false
    },
    required: {
        type: Boolean,
        default: false
    },
    readonly: {
        type: Boolean,
        default: false
    },
    fullWidth: {
        type: Boolean,
        default: true
    },
    size: {
        type: String,
        default: 'md',
        validator: (value) => ['sm', 'md', 'lg'].includes(value)
    },
    min: {
        type: [String, Number],
        default: undefined
    },
    max: {
        type: [String, Number],
        default: undefined
    },
    step: {
        type: [String, Number],
        default: undefined
    }
});

defineEmits(['update:modelValue', 'blur', 'focus']);

const inputId = computed(() => `input-${Math.random().toString(36).substr(2, 9)}`);

const inputClasses = computed(() => {
    const base = 'w-full border rounded-xl font-body transition-all duration-200 focus:outline-none focus:ring-2 disabled:opacity-50 disabled:cursor-not-allowed';

    const sizes = {
        sm: 'px-3 py-2 text-sm',
        md: 'px-4 py-3 text-base',
        lg: 'px-5 py-4 text-lg'
    };

    const states = props.error
        ? 'border-error-600 focus:border-error-600 focus:ring-error-200'
        : 'border-[var(--color-border)] focus:border-accent focus:ring-[rgba(var(--color-accent-rgb),0.2)]';

    const prefix = props.$slots?.prefix ? 'pl-10' : '';
    const suffix = props.$slots?.suffix ? 'pr-10' : '';

    return [base, sizes[props.size], states, prefix, suffix].join(' ');
});
</script>

<style scoped>
.base-input-wrapper input::placeholder {
    color: var(--color-text-muted);
}

.base-input-wrapper input:disabled {
    background-color: var(--color-bg-subtle);
}
</style>
