<template>
    <v-container fluid class="pa-6">
        <div class="d-flex flex-wrap align-center justify-space-between gap-4 mb-6">
            <div>
                <div class="text-h5 font-weight-bold text-secondary">Task calendar</div>
                <div class="text-body-2 text-medium-emphasis">Upcoming open tasks by due date.</div>
            </div>
            <v-btn variant="outlined" rounded="xl" :to="{ name: 'tasks.index' }">Back to list</v-btn>
        </div>

        <v-alert v-if="error" type="error" variant="tonal" class="mb-4" closable @click:close="error = ''">
            {{ error }}
        </v-alert>

        <v-card rounded="xl" elevation="0" class="border">
            <v-progress-linear v-if="loading" indeterminate color="primary" />
            <v-table v-else>
                <thead>
                    <tr>
                        <th class="text-left">Due date</th>
                        <th class="text-left">Task</th>
                        <th class="text-left">Case</th>
                        <th class="text-left">Assignee</th>
                        <th class="text-left">Priority</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in items" :key="row.id">
                        <td>{{ row.due_date ?? '—' }}</td>
                        <td>
                            <router-link :to="{ name: 'tasks.show', params: { id: row.id } }" class="text-primary">{{ row.title }}</router-link>
                        </td>
                        <td>{{ row.legal_case ? `${row.legal_case.case_number} - ${row.legal_case.title}` : '—' }}</td>
                        <td>{{ row.assignee?.name ?? '—' }}</td>
                        <td>{{ row.priority_label }}</td>
                    </tr>
                    <tr v-if="!items.length">
                        <td colspan="5" class="text-center text-medium-emphasis py-8">No open tasks with due dates.</td>
                    </tr>
                </tbody>
            </v-table>
        </v-card>
    </v-container>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import http from '../../api/http.js';

const items = ref([]);
const loading = ref(true);
const error = ref('');

async function load() {
    loading.value = true;
    error.value = '';
    try {
        const { data } = await http.get('/api/v1/tasks', { params: { per_page: 100 } });
        items.value = (data.data || [])
            .filter((row) => ['open', 'in_progress'].includes(row.status) && row.due_date)
            .sort((a, b) => a.due_date.localeCompare(b.due_date));
    } catch (e) {
        error.value = e.response?.data?.message || 'Failed to load calendar tasks.';
    } finally {
        loading.value = false;
    }
}

onMounted(load);
</script>
