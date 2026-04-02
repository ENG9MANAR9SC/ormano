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
            <div class="text-caption text-medium-emphasis">Business dashboard</div>
          </div>
        </div>
      </div>

      <v-divider />

      <v-list nav class="px-2 py-4">
        <v-list-item
          v-for="item in navItems"
          :key="item.title"
          :prepend-icon="item.icon"
          :title="item.title"
          :subtitle="item.subtitle"
          rounded="xl"
          class="mb-2"
          color="primary"
        />
      </v-list>

      <template #append>
        <div class="pa-4">
          <v-card color="secondary" rounded="xl" class="text-white">
            <v-card-text>
              <div class="text-subtitle-2 font-weight-bold mb-1">Team sync at 14:00</div>
              <div class="text-caption text-white text-opacity-80">
                Review performance, revenue, and task progress in one place.
              </div>
            </v-card-text>
          </v-card>
        </div>
      </template>
    </v-navigation-drawer>

    <v-app-bar flat color="surface" class="border-b">
      <v-app-bar-nav-icon variant="text" @click="drawer = !drawer" />
      <v-toolbar-title class="font-weight-bold">Dashboard Overview</v-toolbar-title>
      <v-spacer />
      <v-text-field
        class="ormano-search mr-4"
        density="comfortable"
        hide-details
        prepend-inner-icon="mdi-magnify"
        variant="outlined"
        rounded="xl"
        placeholder="Search reports, teams, or projects"
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
      <v-container fluid class="pa-6">
        <v-row class="mb-2">
          <v-col cols="12" md="8">
            <div class="text-h4 font-weight-bold text-secondary mb-2">Welcome back to Ormano</div>
            <div class="text-body-1 text-medium-emphasis">
              A clean Laravel + Vue + Vuetify dashboard starter with simple navigation, useful summary cards,
              and a polished layout foundation.
            </div>
          </v-col>
          <v-col cols="12" md="4" class="d-flex align-center justify-md-end">
            <v-btn color="primary" rounded="xl" prepend-icon="mdi-plus">Create report</v-btn>
          </v-col>
        </v-row>

        <v-row>
          <v-col v-for="stat in stats" :key="stat.label" cols="12" sm="6" xl="3">
            <v-card rounded="xl" elevation="0" class="border stat-card h-100">
              <v-card-text>
                <div class="d-flex align-center justify-space-between mb-6">
                  <v-avatar :color="stat.color" variant="tonal" rounded="lg">
                    <v-icon>{{ stat.icon }}</v-icon>
                  </v-avatar>
                  <v-chip size="small" :color="stat.trendColor" variant="tonal">
                    {{ stat.trend }}
                  </v-chip>
                </div>
                <div class="text-caption text-medium-emphasis mb-2">{{ stat.label }}</div>
                <div class="text-h5 font-weight-bold text-secondary">{{ stat.value }}</div>
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
                <v-chip color="primary" variant="tonal">Updated 5 min ago</v-chip>
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
    </v-main>

    <v-footer app height="56" color="surface" class="border-t px-6">
      <div class="w-100 d-flex justify-space-between align-center text-body-2 text-medium-emphasis">
        <span>© 2026 Ormano Dashboard</span>
        <span>Built with Laravel 12, Vue 3, and Vuetify</span>
      </div>
    </v-footer>
  </v-app>
</template>

<script setup>
import { ref } from 'vue';

const drawer = ref(true);

const navItems = [
  { title: 'Overview', subtitle: 'Summary and KPIs', icon: 'mdi-view-dashboard-outline' },
  { title: 'Analytics', subtitle: 'Reports and charts', icon: 'mdi-chart-box-outline' },
  { title: 'Projects', subtitle: 'Active workspace items', icon: 'mdi-briefcase-outline' },
  { title: 'Customers', subtitle: 'Client management', icon: 'mdi-account-group-outline' },
];

const stats = [
  { label: 'Total Revenue', value: '$84,240', trend: '+12.4%', color: 'primary', trendColor: 'success', icon: 'mdi-currency-usd' },
  { label: 'New Orders', value: '1,284', trend: '+8.1%', color: 'accent', trendColor: 'success', icon: 'mdi-cart-outline' },
  { label: 'Open Tickets', value: '36', trend: '-4.3%', color: 'warning', trendColor: 'warning', icon: 'mdi-lifebuoy' },
  { label: 'Active Users', value: '5,492', trend: '+15.2%', color: 'info', trendColor: 'success', icon: 'mdi-account-multiple-outline' },
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
  { title: 'Finalize client proposal', subtitle: 'Marketing team · Due today', status: 'In review', color: 'primary', icon: 'mdi-file-document-outline' },
  { title: 'Prepare sprint planning', subtitle: 'Product team · Tomorrow', status: 'Scheduled', color: 'accent', icon: 'mdi-calendar-check-outline' },
  { title: 'Resolve support issues', subtitle: 'Customer care · 8 pending', status: 'Urgent', color: 'error', icon: 'mdi-headset' },
];
</script>
