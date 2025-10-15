<template>
    <Teleport to="body">
        <Transition
            enter-active-class="transition-opacity duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="show"
                class="fixed inset-0 z-[var(--z-modal-backdrop)] bg-black/60 backdrop-blur-sm overflow-y-auto"
                @click="handleBackdropClick"
            >
                <div class="min-h-screen px-4 flex items-center justify-center py-8">
                    <Transition
                        enter-active-class="transition-all duration-300"
                        enter-from-class="opacity-0 scale-95 translate-y-4"
                        enter-to-class="opacity-100 scale-100 translate-y-0"
                        leave-active-class="transition-all duration-200"
                        leave-from-class="opacity-100 scale-100"
                        leave-to-class="opacity-0 scale-95"
                    >
                        <div
                            v-if="show"
                            :class="modalClasses"
                            @click.stop
                            role="dialog"
                            aria-modal="true"
                            :aria-labelledby="titleId"
                        >
                            <!-- Header -->
                            <div v-if="$slots.header || title" class="modal-header">
                                <slot name="header">
                                    <h3 :id="titleId" class="text-2xl font-display font-bold text-[var(--color-text)]">
                                        {{ title }}
                                    </h3>
                                </slot>
                                <button
                                    v-if="closeable"
                                    @click="close"
                                    class="text-[var(--color-text-light)] hover:text-[var(--color-text)] transition-colors p-2 rounded-lg hover:bg-[var(--color-bg-subtle)]"
                                    aria-label="Close modal"
                                >
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Body -->
                            <div class="modal-body">
                                <slot />
                            </div>

                            <!-- Footer -->
                            <div v-if="$slots.footer" class="modal-footer">
                                <slot name="footer" />
                            </div>
                        </div>
                    </Transition>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<script setup>
import { computed, watch, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    title: {
        type: String,
        default: ''
    },
    size: {
        type: String,
        default: 'md',
        validator: (value) => ['sm', 'md', 'lg', 'xl', 'full'].includes(value)
    },
    closeable: {
        type: Boolean,
        default: true
    },
    closeOnBackdrop: {
        type: Boolean,
        default: true
    }
});

const emit = defineEmits(['close', 'update:show']);

const titleId = computed(() => `modal-title-${Math.random().toString(36).substr(2, 9)}`);

const modalClasses = computed(() => {
    const base = 'relative bg-white rounded-2xl shadow-2xl w-full max-h-[90vh] overflow-y-auto border border-[var(--color-border)]';

    const sizes = {
        sm: 'max-w-md',
        md: 'max-w-2xl',
        lg: 'max-w-4xl',
        xl: 'max-w-6xl',
        full: 'max-w-[95vw]'
    };

    return [base, sizes[props.size]].join(' ');
});

const handleBackdropClick = () => {
    if (props.closeOnBackdrop) {
        close();
    }
};

const close = () => {
    emit('close');
    emit('update:show', false);
};

const handleEscape = (e) => {
    if (e.key === 'Escape' && props.show && props.closeable) {
        close();
    }
};

watch(() => props.show, (newValue) => {
    if (newValue) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
});

onMounted(() => {
    document.addEventListener('keydown', handleEscape);
});

onUnmounted(() => {
    document.removeEventListener('keydown', handleEscape);
    document.body.style.overflow = '';
});
</script>

<style scoped>
.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: var(--space-6);
    border-bottom: 1px solid var(--color-border);
}

.modal-body {
    padding: var(--space-6);
}

.modal-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: var(--space-3);
    padding: var(--space-6);
    border-top: 1px solid var(--color-border);
}
</style>
