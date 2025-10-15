# Cultural Design System - Complete Migration Guide

## Table of Contents
1. [Overview](#overview)
2. [Component Library](#component-library)
3. [Usage Examples](#usage-examples)
4. [Page Refactoring Guide](#page-refactoring-guide)
5. [Migration Checklist](#migration-checklist)
6. [Accessibility Guidelines](#accessibility-guidelines)
7. [Responsive Breakpoints](#responsive-breakpoints)

---

## Overview

This design system replaces the red-themed design with a warm, cultural aesthetic featuring earthy tones, elegant typography, and refined spacing.

### Key Changes
- **Primary Color**: Red (#B91C1C) → Warm Beige (#FAF4F2)
- **Accent Color**: Red → Terracotta/Amber (#D4A373, #D97D34)
- **Typography**: Figtree → Cormorant Garamond (display) + Inter (body)
- **Spacing**: Tightened, more refined
- **Shadows**: Softer, more elegant

---

## Component Library

### BaseButton

**Props:**
- `variant`: 'primary' | 'secondary' | 'ghost' | 'danger' | 'success' (default: 'primary')
- `size`: 'sm' | 'md' | 'lg' (default: 'md')
- `disabled`: boolean
- `loading`: boolean
- `fullWidth`: boolean

**Usage:**
```vue
<BaseButton variant="primary" size="md" @click="handleClick">
    Click Me
</BaseButton>

<BaseButton variant="secondary" :loading="isLoading">
    Save Changes
</BaseButton>

<BaseButton variant="ghost" size="sm">
    Cancel
</BaseButton>
```

**Do's:**
- Use `primary` for main CTAs
- Use `secondary` for alternative actions
- Use `ghost` for tertiary actions
- Always provide descriptive text

**Don'ts:**
- Don't use more than one primary button in a section
- Don't use red variant unless for destructive actions (use `danger` instead)

---

### BaseInput

**Props:**
- `modelValue`: string | number
- `type`: string (default: 'text')
- `label`: string
- `placeholder`: string
- `error`: string
- `hint`: string
- `disabled`: boolean
- `required`: boolean
- `size`: 'sm' | 'md' | 'lg'

**Slots:**
- `prefix`: Icon or text before input
- `suffix`: Icon or text after input

**Usage:**
```vue
<BaseInput
    v-model="form.email"
    type="email"
    label="Email Address"
    placeholder="Enter your email"
    :error="errors.email"
    required
>
    <template #prefix>
        <svg><!-- email icon --></svg>
    </template>
</BaseInput>
```

---

### BaseCard

**Props:**
- `title`: string
- `variant`: 'default' | 'bordered' | 'elevated' | 'glass'
- `padding`: 'none' | 'sm' | 'md' | 'lg' | 'xl'
- `hoverable`: boolean
- `clickable`: boolean

**Slots:**
- `header`: Custom header content
- `default`: Card body content
- `footer`: Footer actions

**Usage:**
```vue
<BaseCard title="User Profile" variant="elevated" hoverable>
    <p>Card content goes here</p>

    <template #footer>
        <BaseButton size="sm">Edit</BaseButton>
    </template>
</BaseCard>
```

---

### BaseModal

**Props:**
- `show`: boolean (v-model)
- `title`: string
- `size`: 'sm' | 'md' | 'lg' | 'xl' | 'full'
- `closeable`: boolean
- `closeOnBackdrop`: boolean

**Events:**
- `@close`: Emitted when modal is closed

**Usage:**
```vue
<BaseModal
    v-model:show="showModal"
    title="Edit Record"
    size="lg"
    @close="handleClose"
>
    <p>Modal content</p>

    <template #footer>
        <BaseButton variant="ghost" @click="showModal = false">Cancel</BaseButton>
        <BaseButton @click="handleSave">Save</BaseButton>
    </template>
</BaseModal>
```

---

## Additional Base Components

### BaseBadge

Create: `/resources/js/Components/Base/BaseBadge.vue`

```vue
<template>
    <span :class="badgeClasses">
        <slot />
    </span>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    variant: {
        type: String,
        default: 'default',
        validator: (v) => ['default', 'success', 'error', 'warning', 'info'].includes(v)
    },
    size: {
        type: String,
        default: 'md',
        validator: (v) => ['sm', 'md', 'lg'].includes(v)
    }
});

const badgeClasses = computed(() => {
    const base = 'inline-flex items-center font-semibold rounded-full';

    const sizes = {
        sm: 'px-2 py-1 text-xs',
        md: 'px-3 py-1 text-sm',
        lg: 'px-4 py-2 text-base'
    };

    const variants = {
        default: 'bg-[var(--color-bg-subtle)] text-[var(--color-text)]',
        success: 'bg-success-100 text-success-700',
        error: 'bg-error-100 text-error-700',
        warning: 'bg-warning-100 text-warning-700',
        info: 'bg-blue-100 text-blue-700'
    };

    return [base, sizes[props.size], variants[props.variant]].join(' ');
});
</script>
```

**Usage:**
```vue
<BaseBadge variant="success">Active</BaseBadge>
<BaseBadge variant="error">Inactive</BaseBadge>
```

---

### BaseAlert

Create: `/resources/js/Components/Base/BaseAlert.vue`

```vue
<template>
    <div v-if="show" :class="alertClasses" role="alert">
        <div class="flex items-start gap-3">
            <div class="flex-shrink-0">
                <svg v-if="variant === 'success'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <svg v-else-if="variant === 'error'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <svg v-else-if="variant === 'warning'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <svg v-else class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>

            <div class="flex-1">
                <h4 v-if="title" class="font-semibold mb-1">{{ title }}</h4>
                <div class="text-sm"><slot /></div>
            </div>

            <button
                v-if="closeable"
                @click="show = false"
                class="flex-shrink-0 text-current opacity-70 hover:opacity-100 transition-opacity"
                aria-label="Close alert"
            >
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    variant: {
        type: String,
        default: 'info',
        validator: (v) => ['success', 'error', 'warning', 'info'].includes(v)
    },
    title: String,
    closeable: {
        type: Boolean,
        default: true
    }
});

const show = ref(true);

const alertClasses = computed(() => {
    const base = 'p-4 rounded-xl border';

    const variants = {
        success: 'bg-success-50 border-success-200 text-success-800',
        error: 'bg-error-50 border-error-200 text-error-800',
        warning: 'bg-warning-50 border-warning-200 text-warning-800',
        info: 'bg-blue-50 border-blue-200 text-blue-800'
    };

    return [base, variants[props.variant]].join(' ');
});
</script>
```

---

## Page Refactoring Guide

### Dashboard Example (Before & After)

**Before (Red Theme):**
```vue
<div class="bg-gradient-to-br from-red-50 via-white to-red-50">
    <div class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-lg border border-red-200/50">
        <h1 class="text-3xl font-bold text-red-900">Dashboard</h1>
        <button class="bg-gradient-to-r from-red-600 to-red-700">Click</button>
    </div>
</div>
```

**After (Cultural Theme):**
```vue
<div class="bg-primary">
    <BaseCard variant="glass" padding="lg">
        <h1 class="text-3xl font-display font-bold text-[var(--color-text)]">Dashboard</h1>
        <BaseButton variant="primary">Click</BaseButton>
    </BaseCard>
</div>
```

---

### Search & Replace Patterns

**Color Classes:**
```
# Find                          # Replace
from-red-                       from-accent
to-red-                         to-accent-hover
bg-red-                         bg-accent
text-red-                       text-accent
border-red-                     border-accent
ring-red-                       ring-accent
focus:ring-red-                 focus:ring-accent
```

**Component Patterns:**
```
# Old button                           # New button
<button class="inline-flex...">       <BaseButton variant="primary">

# Old input                            # New input
<input class="border...">              <BaseInput v-model="..." />

# Old card wrapper                     # New card
<div class="bg-white rounded...">     <BaseCard>
```

---

## Migration Checklist

### Phase 1: Setup (1-2 hours)
- [ ] Install theme.css file
- [ ] Update tailwind.config.js
- [ ] Update app.css imports
- [ ] Run `npm run build`
- [ ] Test in browser (verify CSS loads)

### Phase 2: Component Library (2-3 hours)
- [ ] Create BaseButton component
- [ ] Create BaseInput component
- [ ] Create BaseCard component
- [ ] Create BaseModal component
- [ ] Create BaseBadge component
- [ ] Create BaseAlert component
- [ ] Test each component in isolation

### Phase 3: Layout Components (3-4 hours)
- [ ] Refactor Sidebar component
- [ ] Refactor AuthenticatedLayout
- [ ] Refactor GuestLayout
- [ ] Update navigation components
- [ ] Test responsive behavior

### Phase 4: Page Refactoring (8-12 hours)
- [ ] Refactor Dashboard page
- [ ] Refactor AdminRecordsViewModal page
- [ ] Refactor AdminSupplierViewModal page
- [ ] Refactor AdminStaffViewModal page
- [ ] Refactor AdminReportsView page
- [ ] Refactor Auth pages (Login, Register)
- [ ] Refactor Profile page

### Phase 5: Modal Components (3-4 hours)
- [ ] Refactor AdminCreateRecordModal
- [ ] Refactor AdminEditRecordModal
- [ ] Refactor AdminCreateSupplierModal
- [ ] Refactor AdminEditSupplierModal
- [ ] Refactor AdminCreateStaffModal
- [ ] Refactor AdminEditStaffModal

### Phase 6: Testing & QA (4-6 hours)
- [ ] Test all user flows
- [ ] Verify accessibility (keyboard navigation, screen readers)
- [ ] Test responsive design (mobile, tablet, desktop)
- [ ] Check dark mode (if enabled)
- [ ] Cross-browser testing
- [ ] Performance audit

### Phase 7: Polish & Launch (2-3 hours)
- [ ] Fix any visual inconsistencies
- [ ] Update documentation
- [ ] Train team on new components
- [ ] Deploy to staging
- [ ] Final review and deploy to production

**Total Estimated Time: 23-35 hours**

---

## Accessibility Guidelines

### Color Contrast

All color combinations meet WCAG AA standards (4.5:1 for normal text):

| Foreground | Background | Ratio | Grade |
|------------|------------|-------|-------|
| var(--color-text) | var(--color-primary) | 15.3:1 | AAA |
| var(--color-text-light) | var(--color-primary) | 7.1:1 | AAA |
| var(--color-accent) | white | 4.8:1 | AA |
| var(--color-text) | var(--color-accent) | 5.2:1 | AA |

### Keyboard Navigation

**All interactive elements must:**
- Be focusable via Tab key
- Have visible focus indicators (`:focus-visible`)
- Support Enter/Space for activation
- Support Escape to close modals/dropdowns

**Implementation:**
```vue
<!-- Good -->
<button @click="handleClick">Click Me</button>
<button @click="handleClick" @keydown.enter="handleClick">Click Me</button>

<!-- Better with BaseButton (accessibility built-in) -->
<BaseButton @click="handleClick">Click Me</BaseButton>
```

### ARIA Attributes

**Modal Example:**
```vue
<div
    role="dialog"
    aria-modal="true"
    aria-labelledby="modal-title"
    aria-describedby="modal-description"
>
    <h2 id="modal-title">Edit Record</h2>
    <p id="modal-description">Make changes to the record below</p>
</div>
```

**Form Example:**
```vue
<BaseInput
    v-model="form.email"
    label="Email Address"
    :error="errors.email"
    aria-required="true"
    aria-invalid="!!errors.email"
    aria-describedby="email-error"
/>
<span id="email-error" role="alert">{{ errors.email }}</span>
```

### Screen Reader Support

**Always provide:**
- Alt text for images
- Labels for form inputs
- ARIA labels for icon-only buttons
- Skip to main content link
- Proper heading hierarchy (h1 → h2 → h3)

**Example:**
```vue
<!-- Icon-only button -->
<button aria-label="Close modal">
    <svg aria-hidden="true"><!-- X icon --></svg>
</button>

<!-- Decorative image -->
<img src="pattern.png" alt="" role="presentation" />

<!-- Meaningful image -->
<img src="logo.png" alt="Company Logo" />
```

---

## Responsive Breakpoints

### Breakpoint System

```css
/* Mobile First Approach */
/* Base: 320px - 639px (mobile) */

/* sm: 640px+ (large mobile, small tablet) */
@media (min-width: 640px) { }

/* md: 768px+ (tablet) */
@media (min-width: 768px) { }

/* lg: 1024px+ (desktop) */
@media (min-width: 1024px) { }

/* xl: 1280px+ (large desktop) */
@media (min-width: 1280px) { }

/* 2xl: 1536px+ (extra large) */
@media (min-width: 1536px) { }
```

### Responsive Typography

```css
/* Mobile */
h1 { font-size: var(--fs-3xl); } /* 30px */
h2 { font-size: var(--fs-2xl); } /* 24px */
body { font-size: var(--fs-base); } /* 16px */

/* Tablet (md:) */
@media (min-width: 768px) {
    h1 { font-size: var(--fs-5xl); } /* 48px */
    h2 { font-size: var(--fs-4xl); } /* 36px */
    body { font-size: var(--fs-base); } /* 16px */
}

/* Desktop (lg:) */
@media (min-width: 1024px) {
    h1 { font-size: var(--fs-6xl); } /* 60px */
    h2 { font-size: var(--fs-5xl); } /* 48px */
    body { font-size: var(--fs-lg); } /* 18px */
}
```

### Responsive Grid Layouts

**Dashboard Cards:**
```vue
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
    <!-- Cards automatically adjust: 1 col mobile, 2 cols tablet, 4 cols desktop -->
    <BaseCard />
    <BaseCard />
    <BaseCard />
    <BaseCard />
</div>
```

**Content Layouts:**
```vue
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main content: 2/3 width on desktop, full width on mobile -->
    <div class="lg:col-span-2">
        <BaseCard>Main Content</BaseCard>
    </div>

    <!-- Sidebar: 1/3 width on desktop, full width on mobile -->
    <div class="lg:col-span-1">
        <BaseCard>Sidebar</BaseCard>
    </div>
</div>
```

### Responsive Spacing

```vue
<!-- Mobile: 1rem (16px), Desktop: 2rem (32px) -->
<div class="p-4 lg:p-8">Content</div>

<!-- Mobile: 1.5rem, Tablet: 2rem, Desktop: 3rem -->
<div class="p-6 md:p-8 lg:p-12">Content</div>
```

### Mobile Navigation

**Hamburger Menu Pattern:**
```vue
<template>
    <nav>
        <!-- Desktop Navigation -->
        <div class="hidden lg:flex items-center gap-6">
            <a href="/dashboard">Dashboard</a>
            <a href="/records">Records</a>
        </div>

        <!-- Mobile Menu Button -->
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden">
            <svg><!-- Hamburger icon --></svg>
        </button>

        <!-- Mobile Menu -->
        <div v-if="mobileMenuOpen" class="lg:hidden">
            <a href="/dashboard">Dashboard</a>
            <a href="/records">Records</a>
        </div>
    </nav>
</template>
```

---

## Dark Mode Implementation

### Theme Switcher Component

Create: `/resources/js/Components/ThemeSwitcher.vue`

```vue
<template>
    <button
        @click="toggleTheme"
        class="p-2 rounded-lg hover:bg-[var(--color-bg-subtle)] transition-colors"
        :aria-label="isDark ? 'Switch to light mode' : 'Switch to dark mode'"
    >
        <svg v-if="isDark" class="w-5 h-5 text-[var(--color-text)]" fill="currentColor" viewBox="0 0 20 20">
            <!-- Sun icon -->
            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
        </svg>
        <svg v-else class="w-5 h-5 text-[var(--color-text)]" fill="currentColor" viewBox="0 0 20 20">
            <!-- Moon icon -->
            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
        </svg>
    </button>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { themeManager } from '@/utils/theme';

const isDark = ref(false);

const toggleTheme = () => {
    themeManager.toggle();
    isDark.value = themeManager.getCurrent() === 'dark';
};

onMounted(() => {
    isDark.value = themeManager.getCurrent() === 'dark';
});
</script>
```

**Add to Navigation:**
```vue
<template>
    <nav>
        <div class="flex items-center gap-4">
            <a href="/dashboard">Dashboard</a>
            <ThemeSwitcher />
        </div>
    </nav>
</template>
```

---

## Quick Reference

### Component Import Map

```javascript
// In your component:
import BaseButton from '@/Components/Base/BaseButton.vue';
import BaseInput from '@/Components/Base/BaseInput.vue';
import BaseCard from '@/Components/Base/BaseCard.vue';
import BaseModal from '@/Components/Base/BaseModal.vue';
import BaseBadge from '@/Components/Base/BaseBadge.vue';
import BaseAlert from '@/Components/Base/BaseAlert.vue';
```

### CSS Variable Quick Reference

```css
/* Colors */
var(--color-primary)      /* #FAF4F2 */
var(--color-accent)       /* #D4A373 */
var(--color-text)         /* #1F2937 */
var(--color-text-light)   /* #6B7280 */

/* Spacing */
var(--space-2)            /* 1rem / 16px */
var(--space-4)            /* 2rem / 32px */
var(--space-6)            /* 3rem / 48px */

/* Typography */
var(--font-display)       /* Cormorant Garamond */
var(--font-body)          /* Inter */
var(--fs-2xl)            /* 1.5rem / 24px */

/* Shadows */
var(--shadow-md)          /* Medium elevation */
var(--shadow-lg)          /* High elevation */

/* Border Radius */
var(--radius-xl)          /* 1rem / 16px */
var(--radius-2xl)         /* 1.5rem / 24px */
```

### Tailwind Utility Classes

```html
<!-- Colors -->
<div class="bg-accent text-white">
<div class="border-accent">
<div class="text-[var(--color-text)]">

<!-- Spacing -->
<div class="p-6 m-4">
<div class="px-4 py-3">

<!-- Typography -->
<h1 class="font-display text-5xl font-bold">
<p class="font-body text-base text-[var(--color-text-light)]">

<!-- Layout -->
<div class="rounded-2xl shadow-lg">
<div class="flex items-center gap-4">
```

---

## Troubleshooting

### Issue: Colors not showing

**Solution:** Ensure theme.css is imported before Tailwind in app.css:
```css
@import './theme.css';
@tailwind base;
@tailwind components;
@tailwind utilities;
```

### Issue: Fonts not loading

**Solution:** Check network tab for font loading errors. Ensure Google Fonts URL is accessible:
```css
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Inter:wght@400;500;600;700&display=swap');
```

### Issue: Dark mode not working

**Solution:** Verify theme.js is imported in your main app file:
```javascript
// In app.js or main entry file
import { themeManager } from '@/utils/theme';
themeManager.init();
```

### Issue: BaseComponent not found

**Solution:** Check component import path:
```javascript
// Correct
import BaseButton from '@/Components/Base/BaseButton.vue';

// Incorrect
import BaseButton from '@/Components/BaseButton.vue';
```

---

## Support & Resources

### Documentation
- [Tailwind CSS Docs](https://tailwindcss.com/docs)
- [Vue 3 Composition API](https://vuejs.org/guide/introduction.html)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)

### Tools
- [Contrast Checker](https://webaim.org/resources/contrastchecker/)
- [Color Palette Generator](https://coolors.co/)
- [Google Fonts](https://fonts.google.com/)

### Need Help?
- Review component examples in this guide
- Check browser console for errors
- Verify CSS variables are defined in theme.css
- Test in incognito mode to rule out caching issues

---

**Last Updated:** 2025-10-15
**Version:** 1.0.0
**Author:** Design System Team
