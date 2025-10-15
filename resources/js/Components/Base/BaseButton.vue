<template>
    <button
        :type="type"
        :disabled="disabled || loading"
        :class="buttonClasses"
        @click="$emit('click', $event)"
    >
        <span v-if="loading" class="btn-spinner" aria-hidden="true"></span>
        <span :class="{ 'opacity-0': loading }">
            <slot />
        </span>
    </button>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    variant: {
        type: String,
        default: 'primary',
        validator: (value) => ['primary', 'secondary', 'ghost', 'danger', 'success'].includes(value)
    },
    size: {
        type: String,
        default: 'md',
        validator: (value) => ['sm', 'md', 'lg'].includes(value)
    },
    type: {
        type: String,
        default: 'button'
    },
    disabled: {
        type: Boolean,
        default: false
    },
    loading: {
        type: Boolean,
        default: false
    },
    fullWidth: {
        type: Boolean,
        default: false
    }
});

defineEmits(['click']);

const buttonClasses = computed(() => {
    const base = 'inline-flex items-center justify-center font-semibold transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed relative';

    const sizes = {
        sm: 'px-4 py-2 text-sm rounded-lg',
        md: 'px-6 py-3 text-base rounded-xl',
        lg: 'px-8 py-4 text-lg rounded-xl'
    };

    const variants = {
        primary: 'bg-gradient-to-r from-accent to-accent-hover text-white shadow-md hover:shadow-lg hover:scale-[1.02] focus-visible:ring-accent active:scale-95',
        secondary: 'bg-transparent border-2 border-accent text-accent hover:bg-accent hover:text-white shadow-sm hover:shadow-md focus-visible:ring-accent',
        ghost: 'bg-transparent text-[var(--color-text)] hover:bg-[rgba(var(--color-accent-rgb),0.1)] focus-visible:ring-accent',
        danger: 'bg-gradient-to-r from-error-600 to-error-700 text-white shadow-md hover:shadow-lg hover:scale-[1.02] focus-visible:ring-error-500 active:scale-95',
        success: 'bg-gradient-to-r from-success-600 to-success-700 text-white shadow-md hover:shadow-lg hover:scale-[1.02] focus-visible:ring-success-500 active:scale-95'
    };

    const width = props.fullWidth ? 'w-full' : '';

    return [base, sizes[props.size], variants[props.variant], width].join(' ');
});
</script>

<style scoped>
.btn-spinner {
    position: absolute;
    width: 1rem;
    height: 1rem;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 0.6s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}
</style>
