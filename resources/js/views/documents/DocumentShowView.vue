<template>
    <v-container fluid class="pa-6">
        <v-btn variant="text" prepend-icon="mdi-arrow-left" class="mb-4" :to="{ name: 'documents.index' }">Back to documents</v-btn>

        <v-alert v-if="error" type="error" variant="tonal" class="mb-4" closable @click:close="error = ''">
            {{ error }}
        </v-alert>

        <v-progress-circular v-if="loading" indeterminate color="primary" class="ma-8" />

        <v-card v-else-if="documentItem" rounded="xl" elevation="0" class="border pa-4 pa-md-6">
            <div class="d-flex flex-wrap justify-space-between align-start gap-3">
                <div>
                    <div class="text-h5 font-weight-bold text-secondary">{{ documentItem.title }}</div>
                    <div class="text-body-2 text-medium-emphasis mt-1">Document details and content.</div>
                </div>
                <div class="d-flex ga-2">
                    <v-btn variant="outlined" rounded="xl" :to="{ name: 'documents.edit', params: { id: documentItem.id } }">Edit</v-btn>
                    <v-btn color="error" variant="text" rounded="xl" @click="remove">Delete</v-btn>
                </div>
            </div>

            <v-divider class="my-4" />
            <v-row>
                <v-col cols="12" md="6"><strong>Type:</strong> {{ documentItem.type_label }}</v-col>
                <v-col cols="12" md="6"><strong>Status:</strong> {{ documentItem.status_label }}</v-col>
                <v-col cols="12" md="6"><strong>Template:</strong> {{ documentItem.template_name || '—' }}</v-col>
                <v-col cols="12" md="6"><strong>Date:</strong> {{ documentItem.document_date ?? '—' }}</v-col>
                <v-col cols="12" md="6"><strong>Case:</strong> {{ documentItem.legal_case ? `${documentItem.legal_case.case_number} - ${documentItem.legal_case.title}` : '—' }}</v-col>
                <v-col cols="12" md="6"><strong>Client:</strong> {{ documentItem.client?.full_name ?? '—' }}</v-col>
                <v-col cols="12" md="6"><strong>Created by:</strong> {{ documentItem.creator?.name ?? '—' }}</v-col>
                <v-col cols="12"><strong>Content:</strong><div class="mt-1" style="white-space: pre-wrap">{{ documentItem.content || '—' }}</div></v-col>
            </v-row>
        </v-card>
    </v-container>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import http from '../../api/http.js';

const route = useRoute();
const router = useRouter();
const documentItem = ref(null);
const loading = ref(true);
const error = ref('');

async function load() {
    loading.value = true;
    error.value = '';
    try {
        const { data } = await http.get(`/api/v1/documents/${route.params.id}`);
        documentItem.value = data.data;
    } catch (e) {
        error.value = e.response?.data?.message || 'Failed to load document.';
    } finally {
        loading.value = false;
    }
}

async function remove() {
    if (!documentItem.value || !confirm(`Delete document "${documentItem.value.title}"?`)) return;
    try {
        await http.delete(`/api/v1/documents/${documentItem.value.id}`);
        router.push({ name: 'documents.index' });
    } catch (e) {
        error.value = e.response?.data?.message || 'Could not delete document.';
    }
}

onMounted(load);
</script>
