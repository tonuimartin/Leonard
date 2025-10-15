<template>
    <div :class="cardClasses" @click="$emit('click', $event)">
        <div v-if="$slots.header || title" class="card-header" :class="headerClass">
            <slot name="header">
                <h3 v-if="title" class="text-xl font-display font-semibold text-[var(--color-text)]">
                    {{ title }}
                </h3>
            </slot>
        </div>

        <div class="card-body" :class="bodyClass">
            <slot />
        </div>

        <div v-if="$slots.footer" class="card-footer" :class="footerClass">
            <slot name="footer" />
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    title: {
        type: String,
        default: ''
    },
    variant: {
        type: String,
        default: 'default',
        validator: (value) => ['default', 'bordered', 'elevated', 'glass'].includes(value)
    },
    padding: {
        type: String,
        default: 'md',
        validator: (value) => ['none', 'sm', 'md', 'lg', 'xl'].includes(value)
    },
    hoverable: {
        type: Boolean,
        default: false
    },
    clickable: {
        type: Boolean,
        default: false
    },
    headerClass: {
        type: String,
        default: ''
    },
    bodyClass: {
        type: String,
        default: ''
    },
    footerClass: {
        type: String,
        default: ''
    }
});

defineEmits(['click']);

const cardClasses = computed(() => {
    const base = 'rounded-2xl transition-all duration-300';

    const variants = {
        default: 'bg-white border border-[var(--color-border)] shadow-sm',
        bordered: 'bg-white border-2 border-accent',
        elevated: 'bg-white shadow-lg',
        glass: 'bg-white/70 backdrop-blur-sm border border-[var(--color-border)]'
    };

    const paddings = {
        none: '',
        sm: 'p-3',
        md: 'p-6',
        lg: 'p-8',
        xl: 'p-10'
    };

    const interactive = [];
    if (props.hoverable) {
        interactive.push('hover:shadow-xl hover:-translate-y-1');
    }
    if (props.clickable) {
        interactive.push('cursor-pointer');
    }

    return [base, variants[props.variant], paddings[props.padding], ...interactive].join(' ');
});
</script>

<style scoped>
.card-header {
    padding-bottom: var(--space-4);
    border-bottom: 1px solid var(--color-border);
    margin-bottom: var(--space-4);
}

.card-footer {
    padding-top: var(--space-4);
    border-top: 1px solid var(--color-border);
    margin-top: var(--space-4);
}

/* Remove borders if padding is none */
:deep(.p-0) .card-header,
:deep(.p-0) .card-footer {
    border: none;
    margin: 0;
    padding: 0;
}
</style>
