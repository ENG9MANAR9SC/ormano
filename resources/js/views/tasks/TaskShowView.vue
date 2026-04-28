<template>
    <v-container fluid class="pa-6">
        <v-btn variant="text" prepend-icon="mdi-arrow-left" class="mb-4" :to="{ name: 'tasks.index' }">Back to tasks</v-btn>

        <v-alert v-if="error" type="error" variant="tonal" class="mb-4" closable @click:close="error = ''">
            {{ error }}
        </v-alert>

        <v-progress-circular v-if="loading" indeterminate color="primary" class="ma-8" />

        <v-card v-else-if="task" rounded="xl" elevation="0" class="border pa-4 pa-md-6">
            <div class="d-flex flex-wrap justify-space-between align-start gap-3">
                <div>
                    <div class="text-h5 font-weight-bold text-secondary">{{ task.title }}</div>
                    <div class="text-body-2 text-medium-emphasis mt-1">Task details and assignment.</div>
                </div>
                <div class="d-flex ga-2">
                    <v-btn variant="outlined" rounded="xl" :to="{ name: 'tasks.edit', params: { id: task.id } }">Edit</v-btn>
                    <v-btn color="error" variant="text" rounded="xl" @click="remove">Delete</v-btn>
                </div>
            </div>

            <v-divider class="my-4" />
            <v-row>
                <v-col cols="12" md="6"><strong>Status:</strong> {{ task.status_label }}</v-col>
                <v-col cols="12" md="6"><strong>Priority:</strong> {{ task.priority_label }}</v-col>
                <v-col cols="12" md="6"><strong>Due date:</strong> {{ task.due_date ?? '—' }}</v-col>
                <v-col cols="12" md="6"><strong>Case:</strong> {{ task.legal_case ? `${task.legal_case.case_number} - ${task.legal_case.title}` : '—' }}</v-col>
                <v-col cols="12" md="6"><strong>Assigned to:</strong> {{ task.assignee?.name ?? '—' }}</v-col>
                <v-col cols="12" md="6"><strong>Created by:</strong> {{ task.creator?.name ?? '—' }}</v-col>
                <v-col cols="12"><strong>Description:</strong><div class="mt-1">{{ task.description || '—' }}</div></v-col>
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
const task = ref(null);
const loading = ref(true);
const error = ref('');

async function load() {
    loading.value = true;
    error.value = '';
    try {
        const { data } = await http.get(`/api/v1/tasks/${route.params.id}`);
        task.value = data.data;
    } catch (e) {
        error.value = e.response?.data?.message || 'Failed to load task.';
    } finally {
        loading.value = false;
    }
}

async function remove() {
    if (!task.value || !confirm(`Delete task "${task.value.title}"?`)) return;
    try {
        await http.delete(`/api/v1/tasks/${task.value.id}`);
        router.push({ name: 'tasks.index' });
    } catch (e) {
        error.value = e.response?.data?.message || 'Could not delete task.';
    }
}

onMounted(load);
</script>
