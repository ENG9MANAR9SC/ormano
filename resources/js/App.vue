<template>
    <v-app>
        <v-navigation-drawer v-model="drawer" rail-expand permanent elevation="0" class="border-e">
            <div class="px-4 py-5">
                <div class="d-flex align-center ga-3">
                    <v-avatar color="primary" size="42" rounded="lg">
                        <span class="text-subtitle-1 font-weight-bold">O</span>
                    </v-avatar>
                    <div>
                        <div class="text-subtitle-1 font-weight-bold text-secondary">Ormano</div>
                        <div class="text-caption text-medium-emphasis">Legal ERP</div>
                    </div>
                </div>
            </div>

            <v-divider />

            <v-list nav class="px-2 py-4">
                <v-list-item
                    v-for="item in navItems"
                    :key="item.title"
                    :to="item.to"
                    :prepend-icon="item.icon"
                    :title="item.title"
                    :subtitle="item.subtitle"
                    rounded="xl"
                    class="mb-2"
                    color="primary"
                    link
                />
            </v-list>

            <template #append>
                <div class="pa-4">
                    <v-card color="secondary" rounded="xl" class="text-white">
                        <v-card-text>
                            <div class="text-subtitle-2 font-weight-bold mb-1">Blade workspace</div>
                            <div class="text-caption text-white text-opacity-80 mb-2">
                                Server-rendered forms (no SPA): same data, classic HTML.
                            </div>
                            <div class="d-flex flex-column ga-1">
                                <a class="text-caption text-white" href="/cases">/cases</a>
                                <a class="text-caption text-white" href="/clients">/clients</a>
                                <a class="text-caption text-white" href="/courts">/courts</a>
                            </div>
                        </v-card-text>
                    </v-card>
                </div>
            </template>
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

const navItems = [
    { title: 'Overview', subtitle: 'Dashboard', icon: 'mdi-view-dashboard-outline', to: { name: 'dashboard' } },
    { title: 'Cases', subtitle: 'Legal matters', icon: 'mdi-briefcase-outline', to: { name: 'cases.index' } },
    { title: 'Clients', subtitle: 'People & parties', icon: 'mdi-account-group-outline', to: { name: 'clients.index' } },
    { title: 'Courts', subtitle: 'Directory', icon: 'mdi-bank-outline', to: { name: 'courts.index' } },
];

const pageTitle = computed(() => (route.meta.title ? String(route.meta.title) : 'Ormano'));
</script>
