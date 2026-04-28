<template>
    <v-app>
        <v-navigation-drawer v-model="drawer" permanent>
            <!-- Navigation List -->
            <v-list nav class="px-2 py-4">
                <v-icon>mdi-chevron-down</v-icon>
                <!-- Loop through groups -->
                <template v-for="(group, groupIndex) in navItems" :key="groupIndex">
                    <div class="nav-group">
                        <!-- Group Title -->
                        <div
                            class="group-title-btn"
                            @click="toggleGroup(group)"
                        >
                            <v-icon class="mr-2">{{ group.icon }}</v-icon>
                            <span class="group-title">{{ group.group }}</span>
                            <v-icon class="ml-auto">
                                {{ group.open ? 'mdi-chevron-up' : 'mdi-chevron-down' }}
                            </v-icon>
                        </div>

                        <!-- Group Items -->
                        <div v-if="group.open" class="group-items">
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
                        </div>
                    </div>
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
        group: 'Dashboard',
        icon: 'mdi-view-dashboard-outline',
        open: true,
        items: [
            { title: 'Overview', subtitle: 'Dashboard', icon: 'mdi-view-dashboard-outline', to: { name: 'dashboard' } },
        ],
    },
    {
        group: 'Work',
        icon: 'mdi-briefcase-outline',
        open: false, 
        items: [
            { title: 'Tasks', subtitle: 'Manage tasks', icon: 'mdi-clipboard-text-outline', to: { name: 'tasks.index' } },
            { title: 'Notifications', subtitle: 'Alerts', icon: 'mdi-bell-outline', to: { name: 'notifications.index' } },
        ],
    },
    {
        group: 'Legal',
        icon: 'mdi-scale-balance',
        open: false,
        items: [
            { title: 'Cases', subtitle: 'Legal matters', icon: 'mdi-briefcase-outline', to: { name: 'cases.index' } },
            { title: 'Clients', subtitle: 'People & parties', icon: 'mdi-account-group-outline', to: { name: 'clients.index' } },
            { title: 'Courts', subtitle: 'Directory', icon: 'mdi-bank-outline', to: { name: 'courts.index' } },
            // { title: 'Documents', subtitle: 'Case files', icon: 'mdi-file-document-outline', to: { name: 'documents.index' } },
            // { title: 'Templates', subtitle: 'Legal templates', icon: 'mdi-file-outline', to: { name: 'templates.index' } },
        ],
    },
    {
        group: 'AI Assistant',
        icon: 'mdi-scale-balance',
        open: false,
        items: [
            // { title: 'AI Agent', subtitle: 'Automation', icon: 'mdi-robot-outline', to: { name: 'ai.agent' } },
            // { title: 'Case Analyzer', subtitle: 'Insights', icon: 'mdi-magnify', to: { name: 'ai.caseAnalyzer' } },
            // { title: 'Draft Generator', subtitle: 'Document drafts', icon: 'mdi-file-edit-outline', to: { name: 'ai.draftGenerator' } },
            // { title: 'Proofreading', subtitle: 'Review documents', icon: 'mdi-spellcheck', to: { name: 'ai.proofreading' } },
        ],
    },
    {
        group: 'Finance',
        icon: 'mdi-scale-balance',
        open: false,
        items: [
            // { title: 'Invoices', subtitle: 'Billing', icon: 'mdi-receipt-outline', to: { name: 'finance.invoices' } },
            // { title: 'Payments', subtitle: 'Transactions', icon: 'mdi-cash-multiple', to: { name: 'finance.payments' } },
            // { title: 'Expenses', subtitle: 'Costs', icon: 'mdi-currency-usd', to: { name: 'finance.expenses' } },
            // { title: 'Subscriptions', subtitle: 'Recurring payments', icon: 'mdi-autorenew', to: { name: 'finance.subscriptions' } },
        ],
    },
    {
        group: 'Reports',
        icon: 'mdi-scale-balance',
        open: false,
        items: [
            // { title: 'Analytics', subtitle: 'Performance', icon: 'mdi-chart-line', to: { name: 'reports.analytics' } },
            // { title: 'Success Rate', subtitle: 'Case outcomes', icon: 'mdi-check-circle-outline', to: { name: 'reports.successRate' } },
            // { title: 'Financial Health', subtitle: 'Finance overview', icon: 'mdi-finance', to: { name: 'reports.financialHealth' } },
        ],
    },
    {
        group: 'Users',
        icon: 'mdi-scale-balance',
        open: false,
        items: [
             { title: 'Users', subtitle: 'Manage users', icon: 'mdi-account-outline', to: { name: 'users.index' } },
             { title: 'Roles & Permissions', subtitle: 'Access control', icon: 'mdi-shield-account-outline', to: { name: 'roles.index' } },
        ],
    },
    {
        group: 'Logs',
        icon: 'mdi-scale-balance',
        open: false,
        items: [
            // { title: 'Audit Logs', subtitle: 'Track changes', icon: 'mdi-file-document-box-outline', to: { name: 'logs.audit' } },
            // { title: 'Error Logs', subtitle: 'System issues', icon: 'mdi-alert-circle-outline', to: { name: 'logs.error' } },
        ],
    },
    {
        group: 'Settings',
        icon: 'mdi-scale-balance',
        open: false,
        items: [
            // { title: 'General', subtitle: 'System settings', icon: 'mdi-cog-outline', to: { name: 'settings.general' } },
            // { title: 'Feature Flags', subtitle: 'Toggle features', icon: 'mdi-toggle-switch-outline', to: { name: 'settings.featureFlags' } },
            // { title: 'Languages', subtitle: 'Localization', icon: 'mdi-translate', to: { name: 'settings.languages' } },
        ],
    },
]);

const pageTitle = computed(() => (route.meta.title ? String(route.meta.title) : 'Ormano'));

function toggleGroup(group) {
    group.open = !group.open;
}
</script>

<style>
.nav-group {
    margin: 0.5rem;
    margin-bottom: 1.5rem;
}
.group-title-btn {
    display: flex;
    align-items: center;
    cursor: pointer;
    padding: 0.5rem 0;
    transition: background-color 0.2s ease, color 0.2s ease;
}
.group-title-btn:hover {
    background-color: var(--v-theme-primary-lighten-4);
    color: var(--v-theme-primary);
}
.nav-item {
    margin: 0.5rem 0;
}
</style>