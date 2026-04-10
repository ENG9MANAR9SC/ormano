<template>
    <v-container fluid class="pa-6">
        <v-btn variant="text" prepend-icon="mdi-arrow-left" class="mb-4" :to="{ name: 'courts.index' }">
            Back to courts
        </v-btn>

        <v-alert v-if="error" type="error" variant="tonal" class="mb-4">{{ error }}</v-alert>

        <v-progress-circular v-if="loading" indeterminate color="primary" class="ma-8" />

        <template v-else-if="c">
            <div class="d-flex flex-wrap justify-space-between align-start gap-4 mb-6">
                <div>
                    <h1 class="text-h4 font-weight-bold text-secondary">{{ c.name }}</h1>
                    <div class="text-body-2 text-medium-emphasis">
                        {{ c.type_label || 'Type not set' }}
                        <span v-if="c.jurisdiction"> · {{ c.jurisdiction }}</span>
                    </div>
                </div>
                <div class="d-flex ga-2">
                    <v-btn variant="outlined" rounded="xl" :to="{ name: 'courts.edit', params: { id: c.id } }">
                        Edit
                    </v-btn>
                    <v-btn color="error" variant="tonal" rounded="xl" @click="archive"> Archive </v-btn>
                </div>
            </div>

            <v-card rounded="xl" elevation="0" class="border pa-4">
                <v-row dense>
                    <v-col cols="12" sm="6">
                        <div class="text-caption text-medium-emphasis">Code</div>
                        <div>{{ c.code || '—' }}</div>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <div class="text-caption text-medium-emphasis">City</div>
                        <div>{{ c.city || '—' }}</div>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <div class="text-caption text-medium-emphasis">Phone</div>
                        <div>{{ c.phone || '—' }}</div>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <div class="text-caption text-medium-emphasis">Email</div>
                        <div>{{ c.email || '—' }}</div>
                    </v-col>
                    <v-col cols="12">
                        <div class="text-caption text-medium-emphasis">Address</div>
                        <div>{{ c.address || '—' }}</div>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <div class="text-caption text-medium-emphasis">Linked cases</div>
                        <div>{{ c.legal_cases_count ?? '—' }}</div>
                    </v-col>
                    <v-col v-if="c.notes" cols="12">
                        <div class="text-caption text-medium-emphasis">Notes</div>
                        <div style="white-space: pre-wrap">{{ c.notes }}</div>
                    </v-col>
                </v-row>
            </v-card>
        </template>
    </v-container>
</template>

<script setup>
import { ref, watch } from 'vue';
import { useRouter } from 'vue-router';
import http from '../../api/http.js';

const props = defineProps({
    id: { type: [String, Number], required: true },
});

const router = useRouter();
const c = ref(null);
const loading = ref(true);
const error = ref('');

async function fetchCourt() {
    loading.value = true;
    error.value = '';
    try {
        const { data } = await http.get(`/api/v1/courts/${props.id}`);
        c.value = data.data;
    } catch (e) {
        error.value = e.response?.data?.message || 'Court not found.';
        c.value = null;
    } finally {
        loading.value = false;
    }
}

async function archive() {
    if (!confirm('Archive this court?')) return;
    try {
        await http.delete(`/api/v1/courts/${props.id}`);
        router.push({ name: 'courts.index' });
    } catch (e) {
        error.value = e.response?.data?.message || 'Could not archive.';
    }
}

watch(
    () => props.id,
    () => fetchCourt(),
    { immediate: true },
);
</script>
