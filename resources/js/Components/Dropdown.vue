<script setup>
import { computed, onMounted, onUnmounted, ref, nextTick, watch } from "vue";

const props = defineProps({
    align: {
        type: String,
        default: "right",
    },
    width: {
        type: String,
        default: "48",
    },
    contentClasses: {
        type: String,
        default: "py-1 bg-white",
    },
});

const closeOnEscape = (e) => {
    if (open.value && e.key === "Escape") {
        open.value = false;
    }
};

onMounted(() => document.addEventListener("keydown", closeOnEscape));
onUnmounted(() => document.removeEventListener("keydown", closeOnEscape));

const widthClass = computed(() => {
    return {
        48: "w-48",
    }[props.width.toString()];
});

const alignmentClasses = computed(() => {
    if (props.align === "left") {
        return "ltr:origin-top-left rtl:origin-top-right start-0";
    } else if (props.align === "right") {
        return "ltr:origin-top-right rtl:origin-top-left end-0";
    } else {
        return "origin-top";
    }
});

const open = ref(false);
const dropdownMenu = ref(null);
const dropdownStyle = ref({});
const triggerRef = ref(null);

function updateDropdownPosition() {
    const trigger = triggerRef.value;
    if (trigger && dropdownMenu.value) {
        const rect = trigger.getBoundingClientRect();
        dropdownStyle.value = {
            position: "fixed",
            top: `${rect.bottom + 4}px`,
            left: `${rect.left}px`,
            minWidth: `${rect.width}px`,
            zIndex: 100001,
        };
    }
}

watch(open, async (val) => {
    if (val) {
        await nextTick();
        updateDropdownPosition();
    }
});
</script>

<template>
    <div class="relative z-[100000]">
        <div ref="triggerRef" @click="open = !open">
            <slot name="trigger" />
        </div>

        <!-- Full Screen Dropdown Overlay -->
        <teleport to="body">
            <div
                v-show="open"
                class="fixed inset-0 z-[100000]"
                @click="open = false"
            ></div>
        </teleport>

        <teleport to="body">
            <Transition
                enter-active-class="transition ease-out duration-200"
                enter-from-class="opacity-0 scale-95"
                enter-to-class="opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75"
                leave-from-class="opacity-100 scale-100"
                leave-to-class="opacity-0 scale-95"
            >
                <div
                    v-show="open"
                    ref="dropdownMenu"
                    :style="dropdownStyle"
                    class="fixed z-[100001] rounded-2xl shadow-2xl border border-gray-200 backdrop-blur-lg"
                    @click="open = false"
                >
                    <div
                        class="rounded-2xl ring-1 ring-red-200 ring-opacity-20"
                        :class="contentClasses"
                    >
                        <slot name="content" />
                    </div>
                </div>
            </Transition>
        </teleport>
    </div>
</template>
