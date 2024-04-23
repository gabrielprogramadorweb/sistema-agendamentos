import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import SuccessModal from './Components/SuccessModal.vue'; // Ensure path correctness

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .component('SuccessModal', SuccessModal) // Registering SuccessModal globally
            .use(plugin)
            .use(ZiggyVue, Ziggy);

        app.mount(el);

        return app;
    },
    progress: {
        color: '#4B5563',
    },
});
