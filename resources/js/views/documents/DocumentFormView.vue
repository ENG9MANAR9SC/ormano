<template>
    <v-container fluid class="pa-6">
        <v-btn variant="text" prepend-icon="mdi-arrow-left" class="mb-4" :to="{ name: 'documents.index' }">Back to documents</v-btn>

        <div class="text-h5 font-weight-bold text-secondary mb-6">{{ isEdit ? 'Edit document' : 'New document' }}</div>

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
                    <v-col cols="12">
                        <v-text-field v-model="form.title" label="Title *" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-select v-model="form.type" :items="enums.document_types" item-title="label" item-value="value" label="Type *" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-select v-model="form.status" :items="enums.document_statuses" item-title="label" item-value="value" label="Status *" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="form.template_name" label="Template name" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="form.document_date" type="date" label="Document date" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-select v-model="form.case_id" :items="options.cases" item-title="label" item-value="id" label="Case" variant="outlined" rounded="lg" clearable />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-select v-model="form.client_id" :items="options.clients" item-title="label" item-value="id" label="Client" variant="outlined" rounded="lg" clearable />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-select v-model="form.created_by" :items="options.users" item-title="name" item-value="id" label="Created by" variant="outlined" rounded="lg" clearable />
                    </v-col>
                    <v-col cols="12">
                        <v-textarea v-model="form.content" label="Content" variant="outlined" rounded="lg" rows="6" />
                    </v-col>
                </v-row>
                <div class="d-flex flex-wrap ga-3 mt-4">
                    <v-btn type="submit" color="primary" rounded="xl" :loading="saving">Save</v-btn>
                    <v-btn variant="outlined" rounded="xl" :to="{ name: 'documents.index' }">Cancel</v-btn>
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
const isEdit = computed(() => route.name === 'documents.edit');
const documentId = computed(() => route.params.id);

const enums = reactive({ document_statuses: [], document_types: [] });
const options = reactive({ cases: [], clients: [], users: [] });
const form = reactive({
    title: '', type: 'general', status: 'draft', template_name: '', content: '', document_date: '', case_id: null, client_id: null, created_by: null,
});
const bootLoading = ref(true);
const saving = ref(false);
const error = ref('');
const fieldErrors = ref(null);

function applyPayload(payload) {
    form.title = payload.title ?? '';
    form.type = payload.type ?? 'general';
    form.status = payload.status ?? 'draft';
    form.template_name = payload.template_name ?? '';
    form.content = payload.content ?? '';
    form.document_date = payload.document_date ?? '';
    form.case_id = payload.case_id ?? null;
    form.client_id = payload.client_id ?? null;
    form.created_by = payload.created_by ?? null;
}

async function boot() {
    bootLoading.value = true;
    error.value = '';
    try {
        const [eRes, fRes] = await Promise.all([http.get('/api/v1/meta/enums'), http.get('/api/v1/meta/document-form')]);
        enums.document_statuses = eRes.data.document_statuses || [];
        enums.document_types = eRes.data.document_types || [];
        options.cases = fRes.data.cases || [];
        options.clients = fRes.data.clients || [];
        options.users = fRes.data.users || [];
        if (isEdit.value && documentId.value) {
            const { data } = await http.get(`/api/v1/documents/${documentId.value}`);
            applyPayload(data.data);
        }
    } catch (e) {
        error.value = e.response?.data?.message || 'Failed to load document form.';
    } finally {
        bootLoading.value = false;
    }
}

function payload() {
    const p = { ...form };
    if (p.case_id === '' || p.case_id === undefined) p.case_id = null;
    if (p.client_id === '' || p.client_id === undefined) p.client_id = null;
    if (p.created_by === '' || p.created_by === undefined) p.created_by = null;
    return p;
}

async function submit() {
    saving.value = true;
    error.value = '';
    fieldErrors.value = null;
    try {
        if (isEdit.value) {
            await http.put(`/api/v1/documents/${documentId.value}`, payload());
            router.push({ name: 'documents.show', params: { id: documentId.value } });
        } else {
            const { data } = await http.post('/api/v1/documents', payload());
            router.push({ name: 'documents.show', params: { id: data.data.id } });
        }
    } catch (e) {
        if (e.response?.status === 422) fieldErrors.value = e.response.data.errors || { message: e.response.data.message };
        error.value = e.response?.data?.message || 'Validation failed.';
    } finally {
        saving.value = false;
    }
}

watch(() => `${route.name}-${route.params.id ?? ''}`, () => boot(), { immediate: true });
</script>
