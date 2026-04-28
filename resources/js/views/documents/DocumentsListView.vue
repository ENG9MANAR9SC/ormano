<template>
    <v-container fluid class="pa-6">
        <div class="d-flex flex-wrap align-center justify-space-between gap-4 mb-6">
            <div>
                <div class="text-h5 font-weight-bold text-secondary">Documents</div>
                <div class="text-body-2 text-medium-emphasis">Manage legal document records and drafts.</div>
            </div>
            <v-btn color="primary" rounded="xl" prepend-icon="mdi-plus" :to="{ name: 'documents.create' }">New document</v-btn>
        </div>

        <v-alert v-if="error" type="error" variant="tonal" class="mb-4" closable @click:close="error = ''">
            {{ error }}
        </v-alert>

        <v-card rounded="xl" elevation="0" class="border">
            <v-progress-linear v-if="loading" indeterminate color="primary" />
            <v-table v-else>
                <thead>
                    <tr>
                        <th class="text-left">Title</th>
                        <th class="text-left">Type</th>
                        <th class="text-left">Status</th>
                        <th class="text-left">Case</th>
                        <th class="text-left">Client</th>
                        <th class="text-left">Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in items" :key="row.id">
                        <td>
                            <router-link :to="{ name: 'documents.show', params: { id: row.id } }" class="text-primary">
                                {{ row.title }}
                            </router-link>
                        </td>
                        <td>{{ row.type_label }}</td>
                        <td>{{ row.status_label }}</td>
                        <td>{{ row.legal_case ? `${row.legal_case.case_number} - ${row.legal_case.title}` : '—' }}</td>
                        <td>{{ row.client?.full_name ?? '—' }}</td>
                        <td>{{ row.document_date ?? '—' }}</td>
                        <td class="text-end">
                            <v-btn icon="mdi-pencil-outline" variant="text" size="small" :to="{ name: 'documents.edit', params: { id: row.id } }" />
                            <v-btn icon="mdi-delete-outline" variant="text" size="small" color="error" @click="remove(row)" />
                        </td>
                    </tr>
                    <tr v-if="!items.length">
                        <td colspan="7" class="text-center text-medium-emphasis py-8">No documents yet.</td>
                    </tr>
                </tbody>
            </v-table>
        </v-card>

        <div v-if="meta && meta.last_page > 1" class="d-flex justify-center mt-6">
            <v-pagination v-model="page" :length="meta.last_page" rounded="circle" @update:model-value="load" />
        </div>
    </v-container>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import http from '../../api/http.js';

const items = ref([]);
const meta = ref(null);
const loading = ref(true);
const error = ref('');
const page = ref(1);

async function load(p = 1) {
    loading.value = true;
    error.value = '';
    try {
        const { data } = await http.get('/api/v1/documents', { params: { page: p } });
        items.value = data.data;
        meta.value = data.meta;
        page.value = data.meta.current_page;
    } catch (e) {
        error.value = e.response?.data?.message || 'Failed to load documents.';
    } finally {
        loading.value = false;
    }
}

async function remove(row) {
    if (!confirm(`Delete document "${row.title}"?`)) return;
    try {
        await http.delete(`/api/v1/documents/${row.id}`);
        await load(page.value);
    } catch (e) {
        error.value = e.response?.data?.message || 'Could not delete document.';
    }
}

onMounted(() => load(1));
</script>
