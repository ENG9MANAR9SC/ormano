<template>
    <v-app>
        <v-navigation-drawer v-model="drawer" permanent>
            <!-- Navigation List -->
            <v-list nav class="px-2 py-4">
                <!-- Loop through groups -->
                <template v-for="(group, groupIndex) in navItems" :key="groupIndex">
                    <!-- Group with toggle -->
                    <v-list-group
                        v-model="group.open" 
                        prepend-icon="mdi-chevron-down"
                        class="nav-group"
                    >
                        <template v-slot:activator>
                            <span class="group-title">{{ group.group }}</span>
                        </template>

                        <!-- Group Items -->
                        <v-list-item
                            v-for="item in group.items"
                            :key="item.title"
                            :to="item.to"
                            :prepend-icon="item.icon"
                            :title="item.title"
                            :subtitle="item.subtitle"
                            rounded="xl"
                            class="mb-2 nav-item"
                            color="primary"
                            link
                        />
                    </v-list-group>
                </template>
            </v-list>
        </v-navigation-drawer>
            
        <v-app-bar flat color="surface" class="border-b">
            <v-app-bar-nav-icon variant="text" @click="drawer = !drawer" />
            <v-toolbar-title class="font-weight-bold">{{ pageTitle }}</v-toolbar-title>
            <v-spacer />
            <v-text-field
                class="ormano-search mr-4 d-none d-md-flex"
                density="comfortable"
                hide-details
                prepend-inner-icon="mdi-magnify"
                variant="outlined"
                rounded="xl"
                placeholder="Search (coming soon)"
                disabled
            />
            <v-btn icon variant="text">
                <v-icon>mdi-bell-outline</v-icon>
            </v-btn>
            <v-btn icon variant="text" class="ml-2">
                <v-icon>mdi-cog-outline</v-icon>
            </v-btn>
            <v-avatar class="ml-4" color="primary" size="38">
                <span class="text-body-2 font-weight-bold">MA</span>
            </v-avatar>
        </v-app-bar>

        <v-main class="ormano-main">
            <router-view />
        </v-main>

        <v-footer app height="56" color="surface" class="border-t px-6">
            <div class="w-100 d-flex justify-space-between align-center text-body-2 text-medium-emphasis flex-wrap ga-2">
                <span>© 2026 Ormano</span>
                <span>Laravel 12 · Vue 3 · Vuetify</span>
            </div>
        </v-footer>
    </v-app>
</template>

<script setup>
import { computed, ref } from 'vue';
import { useRoute } from 'vue-router';

const drawer = ref(true);
const route = useRoute();

const navItems = ref([
    {
        group: '🏠 Dashboard',
        open: false,
        items: [
            { title: 'Overview', subtitle: 'Dashboard', icon: 'mdi-view-dashboard-outline', to: { name: 'dashboard' } },
        ],
    },
    {
        group: '🟩 Work',
        open: true,
        items: [
            { title: 'Tasks', subtitle: 'Manage tasks', icon: 'mdi-clipboard-text-outline', to: { name: 'tasks.index' } },
            // { title: 'Calendar', subtitle: 'Schedule', icon: 'mdi-calendar-outline', to: { name: 'calendar.index' } },
            // { title: 'Meetings', subtitle: 'Appointments', icon: 'mdi-video-outline', to: { name: 'meetings.index' } },
            { title: 'Notifications', subtitle: 'Alerts', icon: 'mdi-bell-outline', to: { name: 'notifications.index' } },
        ],
    },
    {
        group: '⚖️ Legal',
        open: true,
        items: [
            { title: 'Cases', subtitle: 'Legal matters', icon: 'mdi-briefcase-outline', to: { name: 'cases.index' } },
            { title: 'Clients', subtitle: 'People & parties', icon: 'mdi-account-group-outline', to: { name: 'clients.index' } },
            { title: 'Courts', subtitle: 'Directory', icon: 'mdi-bank-outline', to: { name: 'courts.index' } },
            // { title: 'Documents', subtitle: 'Case files', icon: 'mdi-file-document-outline', to: { name: 'documents.index' } },
            // { title: 'Templates', subtitle: 'Legal templates', icon: 'mdi-file-outline', to: { name: 'templates.index' } },
        ],
    },
    {
        group: '🤖 AI Assistant',
        open: false,
        items: [
            // { title: 'AI Agent', subtitle: 'Automation', icon: 'mdi-robot-outline', to: { name: 'ai.agent' } },
            // { title: 'Case Analyzer', subtitle: 'Insights', icon: 'mdi-magnify', to: { name: 'ai.caseAnalyzer' } },
            // { title: 'Draft Generator', subtitle: 'Document drafts', icon: 'mdi-file-edit-outline', to: { name: 'ai.draftGenerator' } },
            // { title: 'Proofreading', subtitle: 'Review documents', icon: 'mdi-spellcheck', to: { name: 'ai.proofreading' } },
        ],
    },
    {
        group: '💰 Finance',
        open: false,
        items: [
            // { title: 'Invoices', subtitle: 'Billing', icon: 'mdi-receipt-outline', to: { name: 'finance.invoices' } },
            // { title: 'Payments', subtitle: 'Transactions', icon: 'mdi-cash-multiple', to: { name: 'finance.payments' } },
            // { title: 'Expenses', subtitle: 'Costs', icon: 'mdi-currency-usd', to: { name: 'finance.expenses' } },
            // { title: 'Subscriptions', subtitle: 'Recurring payments', icon: 'mdi-autorenew', to: { name: 'finance.subscriptions' } },
        ],
    },
    {
        group: '📊 Reports',
        open: false,
        items: [
            // { title: 'Analytics', subtitle: 'Performance', icon: 'mdi-chart-line', to: { name: 'reports.analytics' } },
            // { title: 'Success Rate', subtitle: 'Case outcomes', icon: 'mdi-check-circle-outline', to: { name: 'reports.successRate' } },
            // { title: 'Financial Health', subtitle: 'Finance overview', icon: 'mdi-finance', to: { name: 'reports.financialHealth' } },
        ],
    },
    {
        group: '👥 Users',
        open: false,
        items: [
            // { title: 'Users', subtitle: 'Manage users', icon: 'mdi-account-outline', to: { name: 'users.index' } },
            // { title: 'Roles & Permissions', subtitle: 'Access control', icon: 'mdi-shield-account-outline', to: { name: 'roles.index' } },
        ],
    },
    {
        group: '🧾 Logs',
        open: false,
        items: [
            // { title: 'Audit Logs', subtitle: 'Track changes', icon: 'mdi-file-document-box-outline', to: { name: 'logs.audit' } },
            // { title: 'Error Logs', subtitle: 'System issues', icon: 'mdi-alert-circle-outline', to: { name: 'logs.error' } },
        ],
    },
    {
        group: '⚙️ Settings',
        open: false,
        items: [
            // { title: 'General', subtitle: 'System settings', icon: 'mdi-cog-outline', to: { name: 'settings.general' } },
            // { title: 'Feature Flags', subtitle: 'Toggle features', icon: 'mdi-toggle-switch-outline', to: { name: 'settings.featureFlags' } },
            // { title: 'Languages', subtitle: 'Localization', icon: 'mdi-translate', to: { name: 'settings.languages' } },
        ],
    },
]);

const pageTitle = computed(() => (route.meta.title ? String(route.meta.title) : 'Ormano'));
</script>

<style>
.nav-group {
    margin: 0.5rem;
    margin-bottom: 1.5rem;
}
.group-title {
    font-weight: bold;
    margin-bottom: 0.5rem;
}
.nav-item {
    margin: 0.5rem 0;
}
</style>