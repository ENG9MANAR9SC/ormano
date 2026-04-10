import './api/http.js';
import { createApp } from 'vue';
import { createVuetify } from 'vuetify';
import { aliases, mdi } from 'vuetify/iconsets/mdi';
import 'vuetify/styles';
import '@mdi/font/css/materialdesignicons.css';
import '../css/app.css';
import App from './App.vue';
import router from './router/index.js';

const vuetify = createVuetify({
    theme: {
        defaultTheme: 'ormano',
        themes: {
            ormano: {
                dark: false,
                colors: {
                    background: '#f5f7fb',
                    surface: '#ffffff',
                    primary: '#2563eb',
                    secondary: '#0f172a',
                    accent: '#14b8a6',
                    info: '#38bdf8',
                    success: '#22c55e',
                    warning: '#f59e0b',
                    error: '#ef4444',
                },
            },
        },
    },
    icons: {
        defaultSet: 'mdi',
        aliases,
        sets: { mdi },
    },
});

createApp(App).use(vuetify).use(router).mount('#app');
