import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';

console.log('🚀 App.js loaded successfully');

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

console.log('📱 Creating Inertia app with name:', appName);

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        console.log('🔍 Resolving component:', name);
        return resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        );
    },
    setup({ el, App, props, plugin }) {
        console.log('⚙️ Setting up Vue app with element:', el);
        console.log('📦 App component:', App);
        console.log('🔧 Props:', props);
        
        const app = createApp({ render: () => h(App, props) })
            .use(plugin);
            
        console.log('🎯 Mounting app to element:', el);
        app.mount(el);
        
        console.log('✅ Vue app mounted successfully');
        return app;
    },
    progress: {
        color: '#D4A373',
    },
});
