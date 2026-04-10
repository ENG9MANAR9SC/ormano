<template>
    <v-container fluid class="pa-6">
        <v-btn variant="text" prepend-icon="mdi-arrow-left" class="mb-4" :to="{ name: 'cases.index' }">
            Back to cases
        </v-btn>

        <v-alert v-if="error" type="error" variant="tonal" class="mb-4">{{ error }}</v-alert>

        <v-progress-circular v-if="loading" indeterminate color="primary" class="ma-8" />

        <template v-else-if="c">
            <div class="d-flex flex-wrap justify-space-between align-start gap-4 mb-6">
                <div>
                    <div class="text-caption text-primary">{{ c.type_label }}</div>
                    <h1 class="text-h4 font-weight-bold text-secondary">{{ c.title }}</h1>
                    <div class="text-body-2 text-medium-emphasis font-mono">
                        {{ c.case_number }} · {{ c.status_label }}
                        <span v-if="c.priority_label"> · {{ c.priority_label }} priority</span>
                    </div>
                </div>
                <div class="d-flex ga-2">
                    <v-btn variant="outlined" rounded="xl" :to="{ name: 'cases.edit', params: { id: c.id } }">
                        Edit
                    </v-btn>
                    <v-btn color="error" variant="tonal" rounded="xl" @click="archive"> Archive </v-btn>
                </div>
            </div>

            <v-row>
                <v-col cols="12" md="8">
                    <v-card rounded="xl" elevation="0" class="border pa-4 mb-4">
                        <div class="text-subtitle-2 text-medium-emphasis mb-2">Description</div>
                        <div class="text-body-1" style="white-space: pre-wrap">{{ c.description || '—' }}</div>
                        <v-divider class="my-4" />
                        <v-row dense>
                            <v-col cols="6" sm="4">
                                <div class="text-caption text-medium-emphasis">Filing</div>
                                <div>{{ c.filing_date || '—' }}</div>
                            </v-col>
                            <v-col cols="6" sm="4">
                                <div class="text-caption text-medium-emphasis">Next hearing</div>
                                <div>{{ c.next_hearing_date || '—' }}</div>
                            </v-col>
                            <v-col cols="6" sm="4">
                                <div class="text-caption text-medium-emphasis">Start / End</div>
                                <div>{{ c.start_date || '—' }} → {{ c.end_date || '—' }}</div>
                            </v-col>
                        </v-row>
                        <template v-if="c.notes">
                            <v-divider class="my-4" />
                            <div class="text-caption text-medium-emphasis mb-2">Internal notes</div>
                            <div class="text-body-2" style="white-space: pre-wrap">{{ c.notes }}</div>
                        </template>
                    </v-card>
                </v-col>
                <v-col cols="12" md="4">
                    <v-card rounded="xl" elevation="0" class="border pa-4">
                        <div class="text-subtitle-2 text-medium-emphasis mb-3">Links</div>
                        <div class="mb-3">
                            <div class="text-caption text-medium-emphasis">Client</div>
                            <router-link v-if="c.client" :to="{ name: 'clients.show', params: { id: c.client.id } }">
                                {{ c.client.full_name }}
                            </router-link>
                            <span v-else>—</span>
                        </div>
                        <div class="mb-3">
                            <div class="text-caption text-medium-emphasis">Court</div>
                            <router-link v-if="c.court" :to="{ name: 'courts.show', params: { id: c.court.id } }">
                                {{ c.court.name }}
                            </router-link>
                            <span v-else>—</span>
                        </div>
                        <div>
                            <div class="text-caption text-medium-emphasis">Assigned to</div>
                            <div>{{ c.assignee?.name ?? '—' }}</div>
                        </div>
                    </v-card>
                </v-col>
            </v-row>
        </template>
    </v-container>
</template>

<script setup>
import { ref, watch } from 'vue';
import { useRouter } from 'vue-router';
import http from '../../api/http.js';

const props = defineProps({
    id: {
        type: [String, Number],
        required: true,
    },
});

const router = useRouter();
const c = ref(null);
const loading = ref(true);
const error = ref('');

async function fetchCase() {
    loading.value = true;
    error.value = '';
    try {
        const { data } = await http.get(`/api/v1/cases/${props.id}`);
        c.value = data.data;
    } catch (e) {
        error.value = e.response?.data?.message || 'Case not found.';
        c.value = null;
    } finally {
        loading.value = false;
    }
}

async function archive() {
    if (!confirm('Archive this case?')) return;
    try {
        await http.delete(`/api/v1/cases/${props.id}`);
        router.push({ name: 'cases.index' });
    } catch (e) {
        error.value = e.response?.data?.message || 'Could not archive.';
    }
}

watch(
    () => props.id,
    () => fetchCase(),
    { immediate: true },
);
</script>
