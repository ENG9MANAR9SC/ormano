<template>
    <v-container fluid class="pa-6">
        <v-btn variant="text" prepend-icon="mdi-arrow-left" class="mb-4" :to="{ name: 'courts.index' }">
            Back to courts
        </v-btn>

        <div class="text-h5 font-weight-bold text-secondary mb-6">{{ isEdit ? 'Edit court' : 'New court' }}</div>

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
                        <v-text-field v-model="form.name" label="Court name *" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="form.code" label="Code" variant="outlined" rounded="lg" hint="Optional unique code" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-select
                            v-model="form.type"
                            :items="courtTypes"
                            item-title="label"
                            item-value="value"
                            label="Court type"
                            variant="outlined"
                            rounded="lg"
                            clearable
                        />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="form.jurisdiction" label="Jurisdiction" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="form.city" label="City" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="form.phone" label="Phone" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="form.email" label="Email" type="email" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12">
                        <v-textarea v-model="form.address" label="Address" variant="outlined" rounded="lg" rows="2" />
                    </v-col>
                    <v-col cols="12">
                        <v-textarea v-model="form.notes" label="Notes" variant="outlined" rounded="lg" rows="3" />
                    </v-col>
                    <v-col cols="12">
                        <v-switch v-model="form.is_active" color="primary" label="Active (accept new case links)" hide-details />
                    </v-col>
                </v-row>

                <div class="d-flex flex-wrap ga-3 mt-4">
                    <v-btn type="submit" color="primary" rounded="xl" :loading="saving"> Save </v-btn>
                    <v-btn variant="outlined" rounded="xl" :to="{ name: 'courts.index' }"> Cancel </v-btn>
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
const isEdit = computed(() => route.name === 'courts.edit');
const courtId = computed(() => route.params.id);

const courtTypes = ref([]);

const form = reactive({
    name: '',
    code: '',
    type: '',
    jurisdiction: '',
    city: '',
    address: '',
    phone: '',
    email: '',
    is_active: true,
    notes: '',
});

const bootLoading = ref(true);
const saving = ref(false);
const error = ref('');
const fieldErrors = ref(null);

function applyPayload(p) {
    form.name = p.name ?? '';
    form.code = p.code ?? '';
    form.type = p.type ?? '';
    form.jurisdiction = p.jurisdiction ?? '';
    form.city = p.city ?? '';
    form.address = p.address ?? '';
    form.phone = p.phone ?? '';
    form.email = p.email ?? '';
    form.is_active = p.is_active !== undefined ? Boolean(p.is_active) : true;
    form.notes = p.notes ?? '';
}

async function boot() {
    bootLoading.value = true;
    error.value = '';
    try {
        const { data } = await http.get('/api/v1/meta/enums');
        courtTypes.value = data.court_types;

        if (isEdit.value && courtId.value) {
            const res = await http.get(`/api/v1/courts/${courtId.value}`);
            applyPayload(res.data.data);
        } else {
            applyPayload({});
        }
    } catch (e) {
        error.value = e.response?.data?.message || 'Failed to load form.';
    } finally {
        bootLoading.value = false;
    }
}

function payload() {
    const p = { ...form };
    if (p.type === '' || p.type === undefined) p.type = null;
    return p;
}

async function submit() {
    saving.value = true;
    error.value = '';
    fieldErrors.value = null;
    try {
        if (isEdit.value) {
            await http.put(`/api/v1/courts/${courtId.value}`, payload());
            router.push({ name: 'courts.show', params: { id: courtId.value } });
        } else {
            const { data } = await http.post('/api/v1/courts', payload());
            router.push({ name: 'courts.show', params: { id: data.data.id } });
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
