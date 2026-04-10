<template>
    <v-container fluid class="pa-6">
        <v-row class="mb-2">
            <v-col cols="12" md="8">
                <div class="text-h4 font-weight-bold text-secondary mb-2">Welcome back to Ormano</div>
                <div class="text-body-1 text-medium-emphasis">
                    Legal ERP dashboard: open Cases, Clients, and Courts from the sidebar to manage your practice.
                    Classic Blade forms remain available under the same paths without the hash (e.g. <code>/cases</code>).
                </div>
            </v-col>
            <v-col cols="12" md="4" class="d-flex align-center justify-md-end">
                <v-btn color="primary" rounded="xl" prepend-icon="mdi-briefcase-outline" :to="{ name: 'cases.index' }">
                    View cases
                </v-btn>
            </v-col>
        </v-row>

        <v-row>
            <v-col v-for="card in quickLinks" :key="card.title" cols="12" sm="6" md="4">
                <v-card
                    rounded="xl"
                    elevation="0"
                    class="border stat-card h-100 cursor-pointer"
                    @click="router.push(card.to)"
                >
                    <v-card-text>
                        <v-avatar :color="card.color" variant="tonal" rounded="lg" class="mb-4">
                            <v-icon>{{ card.icon }}</v-icon>
                        </v-avatar>
                        <div class="text-subtitle-1 font-weight-bold text-secondary">{{ card.title }}</div>
                        <div class="text-body-2 text-medium-emphasis">{{ card.subtitle }}</div>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

        <v-row class="mt-1">
            <v-col cols="12" lg="8">
                <v-card rounded="xl" elevation="0" class="border h-100">
                    <v-card-title class="d-flex align-center justify-space-between py-5">
                        <div>
                            <div class="text-h6 font-weight-bold">Performance</div>
                            <div class="text-body-2 text-medium-emphasis">Weekly activity across your workspace</div>
                        </div>
                        <v-chip color="primary" variant="tonal">Sample data</v-chip>
                    </v-card-title>
                    <v-divider />
                    <v-card-text class="pt-6">
                        <div class="chart-grid">
                            <div v-for="bar in performance" :key="bar.day" class="chart-col">
                                <div class="chart-track">
                                    <div class="chart-bar" :style="{ height: `${bar.value}%` }"></div>
                                </div>
                                <div class="text-caption text-medium-emphasis mt-3">{{ bar.day }}</div>
                            </div>
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" lg="4">
                <v-card rounded="xl" elevation="0" class="border mb-6">
                    <v-card-title class="py-5">
                        <div class="text-h6 font-weight-bold">Tasks</div>
                    </v-card-title>
                    <v-divider />
                    <v-list lines="two">
                        <v-list-item
                            v-for="task in tasks"
                            :key="task.title"
                            :title="task.title"
                            :subtitle="task.subtitle"
                        >
                            <template #prepend>
                                <v-avatar :color="task.color" variant="tonal" rounded="lg">
                                    <v-icon>{{ task.icon }}</v-icon>
                                </v-avatar>
                            </template>
                            <template #append>
                                <v-chip size="small" :color="task.color" variant="tonal">{{ task.status }}</v-chip>
                            </template>
                        </v-list-item>
                    </v-list>
                </v-card>

                <v-card rounded="xl" elevation="0" class="border">
                    <v-card-title class="py-5">
                        <div class="text-h6 font-weight-bold">Revenue target</div>
                    </v-card-title>
                    <v-divider />
                    <v-card-text>
                        <div class="d-flex align-center justify-space-between mb-3">
                            <span class="text-body-2 text-medium-emphasis">Monthly progress</span>
                            <span class="text-body-2 font-weight-bold">78%</span>
                        </div>
                        <v-progress-linear model-value="78" color="accent" height="10" rounded />
                        <div class="text-caption text-medium-emphasis mt-4">
                            You are close to this month’s goal. Keep the sales flow moving.
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

const quickLinks = [
    {
        title: 'Cases',
        subtitle: 'Matter list, status, and hearings',
        icon: 'mdi-briefcase-outline',
        color: 'primary',
        to: { name: 'cases.index' },
    },
    {
        title: 'Clients',
        subtitle: 'Parties and contact records',
        icon: 'mdi-account-group-outline',
        color: 'accent',
        to: { name: 'clients.index' },
    },
    {
        title: 'Courts',
        subtitle: 'Courts and chambers directory',
        icon: 'mdi-bank-outline',
        color: 'info',
        to: { name: 'courts.index' },
    },
];

const performance = [
    { day: 'Mon', value: 48 },
    { day: 'Tue', value: 72 },
    { day: 'Wed', value: 64 },
    { day: 'Thu', value: 88 },
    { day: 'Fri', value: 76 },
    { day: 'Sat', value: 58 },
    { day: 'Sun', value: 68 },
];

const tasks = [
    {
        title: 'Finalize client proposal',
        subtitle: 'Marketing team · Due today',
        status: 'In review',
        color: 'primary',
        icon: 'mdi-file-document-outline',
    },
    {
        title: 'Prepare sprint planning',
        subtitle: 'Product team · Tomorrow',
        status: 'Scheduled',
        color: 'accent',
        icon: 'mdi-calendar-check-outline',
    },
    {
        title: 'Resolve support issues',
        subtitle: 'Customer care · 8 pending',
        status: 'Urgent',
        color: 'error',
        icon: 'mdi-headset',
    },
];
</script>
