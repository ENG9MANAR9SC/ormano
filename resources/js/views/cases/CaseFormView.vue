<template>
    <v-container fluid class="pa-6">
        <v-btn variant="text" prepend-icon="mdi-arrow-left" class="mb-4" :to="{ name: 'cases.index' }">
            Back to cases
        </v-btn>

        <div class="text-h5 font-weight-bold text-secondary mb-6">{{ isEdit ? 'Edit case' : 'New case' }}</div>

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
                        <v-text-field v-model="form.case_number" label="Case number *" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="form.title" label="Title *" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-select
                            v-model="form.type"
                            :items="enums.case_types"
                            item-title="label"
                            item-value="value"
                            label="Case type *"
                            variant="outlined"
                            rounded="lg"
                        />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-select
                            v-model="form.status"
                            :items="enums.case_statuses"
                            item-title="label"
                            item-value="value"
                            label="Status *"
                            variant="outlined"
                            rounded="lg"
                        />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-select
                            v-model="form.priority"
                            :items="enums.case_priorities"
                            item-title="label"
                            item-value="value"
                            label="Priority"
                            variant="outlined"
                            rounded="lg"
                            clearable
                        />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="form.filing_date" label="Filing date" type="date" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="form.start_date" label="Start date" type="date" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="form.end_date" label="End date" type="date" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field
                            v-model="form.next_hearing_date"
                            label="Next hearing"
                            type="date"
                            variant="outlined"
                            rounded="lg"
                        />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-select
                            v-model="form.client_id"
                            :items="options.clients"
                            item-title="label"
                            item-value="id"
                            label="Client *"
                            variant="outlined"
                            rounded="lg"
                        />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-select
                            v-model="form.court_id"
                            :items="options.courts"
                            item-title="label"
                            item-value="id"
                            label="Court"
                            variant="outlined"
                            rounded="lg"
                            clearable
                        />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-select
                            v-model="form.assigned_to"
                            :items="options.users"
                            item-title="name"
                            item-value="id"
                            label="Assigned to"
                            variant="outlined"
                            rounded="lg"
                            clearable
                        />
                    </v-col>
                    <v-col cols="12">
                        <v-textarea v-model="form.description" label="Description" variant="outlined" rounded="lg" rows="3" />
                    </v-col>
                    <v-col cols="12">
                        <v-textarea v-model="form.notes" label="Internal notes" variant="outlined" rounded="lg" rows="3" />
                    </v-col>
                </v-row>

                <div class="d-flex flex-wrap ga-3 mt-4">
                    <v-btn type="submit" color="primary" rounded="xl" :loading="saving"> Save </v-btn>
                    <v-btn variant="outlined" rounded="xl" :to="{ name: 'cases.index' }"> Cancel </v-btn>
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

const isEdit = computed(() => route.name === 'cases.edit');
const caseId = computed(() => route.params.id);

const enums = reactive({
    case_types: [],
    case_statuses: [],
    case_priorities: [],
});

const options = reactive({
    clients: [],
    courts: [],
    users: [],
});

const form = reactive({
    case_number: '',
    title: '',
    description: '',
    type: '',
    status: 'open',
    priority: '',
    filing_date: '',
    start_date: '',
    end_date: '',
    next_hearing_date: '',
    client_id: null,
    court_id: null,
    assigned_to: null,
    notes: '',
});

const bootLoading = ref(true);
const saving = ref(false);
const error = ref('');
const fieldErrors = ref(null);

function applyCasePayload(payload) {
    form.case_number = payload.case_number ?? '';
    form.title = payload.title ?? '';
    form.description = payload.description ?? '';
    form.type = payload.type ?? '';
    form.status = payload.status ?? 'open';
    form.priority = payload.priority ?? '';
    form.filing_date = payload.filing_date ?? '';
    form.start_date = payload.start_date ?? '';
    form.end_date = payload.end_date ?? '';
    form.next_hearing_date = payload.next_hearing_date ?? '';
    form.client_id = payload.client_id ?? null;
    form.court_id = payload.court_id ?? null;
    form.assigned_to = payload.assigned_to ?? null;
    form.notes = payload.notes ?? '';
}

async function boot() {
    bootLoading.value = true;
    error.value = '';
    try {
        const [eRes, fRes] = await Promise.all([
            http.get('/api/v1/meta/enums'),
            http.get('/api/v1/meta/case-form'),
        ]);
        Object.assign(enums, {
            case_types: eRes.data.case_types,
            case_statuses: eRes.data.case_statuses,
            case_priorities: eRes.data.case_priorities,
        });
        Object.assign(options, fRes.data);

        if (isEdit.value && caseId.value) {
            const { data } = await http.get(`/api/v1/cases/${caseId.value}`);
            applyCasePayload(data.data);
        }
    } catch (e) {
        error.value = e.response?.data?.message || 'Failed to load form.';
    } finally {
        bootLoading.value = false;
    }
}

function payload() {
    const p = { ...form };
    if (p.priority === '') p.priority = null;
    if (p.court_id === '' || p.court_id === undefined) p.court_id = null;
    if (p.assigned_to === '' || p.assigned_to === undefined) p.assigned_to = null;
    return p;
}

async function submit() {
    saving.value = true;
    error.value = '';
    fieldErrors.value = null;
    try {
        if (isEdit.value) {
            await http.put(`/api/v1/cases/${caseId.value}`, payload());
            router.push({ name: 'cases.show', params: { id: caseId.value } });
        } else {
            const { data } = await http.post('/api/v1/cases', payload());
            router.push({ name: 'cases.show', params: { id: data.data.id } });
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
