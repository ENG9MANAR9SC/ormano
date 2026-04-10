<template>
    <v-container fluid class="pa-6">
        <v-btn variant="text" prepend-icon="mdi-arrow-left" class="mb-4" :to="{ name: 'clients.index' }">
            Back to clients
        </v-btn>

        <div class="text-h5 font-weight-bold text-secondary mb-6">{{ isEdit ? 'Edit client' : 'New client' }}</div>

        <v-alert v-if="error" type="error" variant="tonal" class="mb-4" closable @click:close="error = ''">
            {{ error }}
        </v-alert>

        <v-alert v-if="fieldErrors" type="warning" variant="tonal" class="mb-4">
            <div v-for="(msgs, key) in fieldErrors" :key="key" class="text-caption">
                <strong>{{ key }}:</strong> {{ Array.isArray(msgs) ? msgs.join(', ') : msgs }}
            </div>
        </v-alert>

        <v-progress-circular v-if="bootLoading" indeterminate color="primary" class="ma-8" />

        <v-form v-else @submit.prevent="submit">
            <v-card rounded="xl" elevation="0" class="border pa-4 pa-md-6">
                <v-row>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="form.first_name" label="First name *" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="form.last_name" label="Last name *" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="form.father_name" label="Father name" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="form.mother_name" label="Mother name" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="form.national_id" label="National ID" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="form.email" label="Email *" type="email" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="form.phone" label="Phone" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="form.birth_date" label="Birth date" type="date" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="form.country" label="Country *" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="form.city" label="City" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12">
                        <v-textarea v-model="form.address" label="Address" variant="outlined" rounded="lg" rows="2" />
                    </v-col>
                    <v-col cols="12">
                        <v-textarea v-model="form.notes" label="Notes" variant="outlined" rounded="lg" rows="3" />
                    </v-col>
                </v-row>

                <div class="d-flex flex-wrap ga-3 mt-4">
                    <v-btn type="submit" color="primary" rounded="xl" :loading="saving"> Save </v-btn>
                    <v-btn variant="outlined" rounded="xl" :to="{ name: 'clients.index' }"> Cancel </v-btn>
                </div>
            </v-card>
        </v-form>
    </v-container>
</template>

<script setup>
import { computed, reactive, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import http from '../../api/http.js';

const route = useRoute();
const router = useRouter();
const isEdit = computed(() => route.name === 'clients.edit');
const clientId = computed(() => route.params.id);

const form = reactive({
    first_name: '',
    last_name: '',
    father_name: '',
    mother_name: '',
    national_id: '',
    email: '',
    phone: '',
    country: '',
    city: '',
    address: '',
    birth_date: '',
    notes: '',
});

const bootLoading = ref(true);
const saving = ref(false);
const error = ref('');
const fieldErrors = ref(null);

function applyPayload(p) {
    form.first_name = p.first_name ?? '';
    form.last_name = p.last_name ?? '';
    form.father_name = p.father_name ?? '';
    form.mother_name = p.mother_name ?? '';
    form.national_id = p.national_id ?? '';
    form.email = p.email ?? '';
    form.phone = p.phone ?? '';
    form.country = p.country ?? '';
    form.city = p.city ?? '';
    form.address = p.address ?? '';
    form.birth_date = p.birth_date ?? '';
    form.notes = p.notes ?? '';
}

async function boot() {
    bootLoading.value = true;
    error.value = '';
    try {
        if (isEdit.value && clientId.value) {
            const { data } = await http.get(`/api/v1/clients/${clientId.value}`);
            applyPayload(data.data);
        } else {
            applyPayload({});
        }
    } catch (e) {
        error.value = e.response?.data?.message || 'Failed to load client.';
    } finally {
        bootLoading.value = false;
    }
}

function payload() {
    const p = { ...form };
    if (p.national_id === '') p.national_id = null;
    return p;
}

async function submit() {
    saving.value = true;
    error.value = '';
    fieldErrors.value = null;
    try {
        if (isEdit.value) {
            await http.put(`/api/v1/clients/${clientId.value}`, payload());
            router.push({ name: 'clients.show', params: { id: clientId.value } });
        } else {
            const { data } = await http.post('/api/v1/clients', payload());
            router.push({ name: 'clients.show', params: { id: data.data.id } });
        }
    } catch (e) {
        if (e.response?.status === 422) {
            fieldErrors.value = e.response.data.errors || { message: e.response.data.message };
        }
        error.value = e.response?.data?.message || 'Validation failed.';
    } finally {
        saving.value = false;
    }
}

watch(
    () => `${route.name}-${route.params.id ?? ''}`,
    () => boot(),
    { immediate: true },
);
</script>
