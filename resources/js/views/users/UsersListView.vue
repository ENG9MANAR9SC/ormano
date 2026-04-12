<template>
    <v-container fluid class="pa-6">
        <div class="d-flex flex-wrap align-center justify-space-between gap-4 mb-6">
            <div>
                <div class="text-h5 font-weight-bold text-secondary">Users</div>
                <div class="text-body-2 text-medium-emphasis">Users directory and management.</div>
            </div>
            <v-btn color="primary" rounded="xl" prepend-icon="mdi-plus" :to="{ name: 'users.create' }">
                New user
            </v-btn>
        </div>

        <v-alert v-if="error" type="error" variant="tonal" class="mb-4" closable @click:close="error = ''">
            {{ error }}
        </v-alert>

        <v-card rounded="xl" elevation="0" class="border">
            <v-progress-linear v-if="loading" indeterminate color="primary" />
            <v-table v-else>
                <thead>
                    <tr>
                        <th class="text-left">Name</th>
                        <th class="text-left">Email</th>
                        <th class="text-left">Role</th>
                        <th class="text-left">Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in items" :key="row.id">
                        <td>
                            <router-link :to="{ name: 'users.show', params: { id: row.id } }" class="text-primary">
                                {{ row.name }}
                            </router-link>
                        </td>
                        <td>{{ row.email }}</td>
                        <td>{{ row.role }}</td>
                        <td>
                            <v-chip v-if="row.is_active" size="small" color="success" variant="tonal">Active</v-chip>
                            <v-chip v-else size="small" variant="tonal">Inactive</v-chip>
                        </td>
                        <td class="text-end">
                            <v-btn
                                icon="mdi-pencil-outline"
                                variant="text"
                                size="small"
                                :to="{ name: 'users.edit', params: { id: row.id } }"
                            />
                            <v-btn icon="mdi-delete-outline" variant="text" size="small" color="error" @click="remove(row)" />
                        </td>
                    </tr>
                    <tr v-if="!items.length">
                        <td colspan="5" class="text-center text-medium-emphasis py-8">No users yet.</td>
                    </tr>
                </tbody>
            </v-table>
        </v-card>

        <!-- <div v-if="meta && meta.last_page" > 1 class="d-flex justify-center mt-6"> -->
            <!-- <v-pagination v-model="page" :length="meta.last_page" rounded="circle" @update:model-value="load" /> -->
        <!-- </div> -->
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
        const { data } = await http.get('/api/v1/users', { params: { page: p } });
        items.value = data.data;
        meta.value = data.meta;
        page.value = data.meta.current_page;
    } catch (e) {
        error.value = e.response?.data?.message || 'Failed to load users.';
    } finally {
        loading.value = false;
    }
}

async function remove(row) {
    if (!confirm(`Delete user ${row.name}?`)) return;
    try {
        await http.delete(`/api/v1/users/${row.id}`);
        await load(page.value);
    } catch (e) {
        error.value = e.response?.data?.message || 'Could not delete user.';
    }
}

onMounted(() => load(1));
</script>