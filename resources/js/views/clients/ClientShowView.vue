<template>
    <v-container fluid class="pa-6">
        <v-btn variant="text" prepend-icon="mdi-arrow-left" class="mb-4" :to="{ name: 'clients.index' }">
            Back to clients
        </v-btn>

        <v-alert v-if="error" type="error" variant="tonal" class="mb-4">{{ error }}</v-alert>

        <v-progress-circular v-if="loading" indeterminate color="primary" class="ma-8" />

        <template v-else-if="c">
            <div class="d-flex flex-wrap justify-space-between align-start gap-4 mb-6">
                <div>
                    <h1 class="text-h4 font-weight-bold text-secondary">{{ c.full_name }}</h1>
                    <div class="text-body-2 text-medium-emphasis">{{ c.email }}</div>
                </div>
                <div class="d-flex ga-2">
                    <v-btn variant="outlined" rounded="xl" :to="{ name: 'clients.edit', params: { id: c.id } }">
                        Edit
                    </v-btn>
                    <v-btn color="error" variant="tonal" rounded="xl" @click="remove"> Delete </v-btn>
                </div>
            </div>

            <v-card rounded="xl" elevation="0" class="border pa-4">
                <v-row dense>
                    <v-col cols="12" sm="6" md="4">
                        <div class="text-caption text-medium-emphasis">National ID</div>
                        <div>{{ c.national_id || '—' }}</div>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                        <div class="text-caption text-medium-emphasis">Phone</div>
                        <div>{{ c.phone || '—' }}</div>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                        <div class="text-caption text-medium-emphasis">Birth date</div>
                        <div>{{ c.birth_date || '—' }}</div>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                        <div class="text-caption text-medium-emphasis">Father / Mother</div>
                        <div>{{ c.father_name || '—' }} / {{ c.mother_name || '—' }}</div>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                        <div class="text-caption text-medium-emphasis">Location</div>
                        <div>{{ [c.city, c.country].filter(Boolean).join(', ') }}</div>
                    </v-col>
                    <v-col cols="12">
                        <div class="text-caption text-medium-emphasis">Address</div>
                        <div>{{ c.address || '—' }}</div>
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

async function fetchClient() {
    loading.value = true;
    error.value = '';
    try {
        const { data } = await http.get(`/api/v1/clients/${props.id}`);
        c.value = data.data;
    } catch (e) {
        error.value = e.response?.data?.message || 'Client not found.';
        c.value = null;
    } finally {
        loading.value = false;
    }
}

async function remove() {
    if (!confirm('Delete this client?')) return;
    try {
        await http.delete(`/api/v1/clients/${props.id}`);
        router.push({ name: 'clients.index' });
    } catch (e) {
        error.value = e.response?.data?.message || 'Could not delete.';
    }
}

watch(
    () => props.id,
    () => fetchClient(),
    { immediate: true },
);
</script>
