<template>
    <v-container fluid class="pa-6">
        <div class="d-flex flex-wrap align-center justify-space-between gap-4 mb-6">
            <div>
                <div class="text-h5 font-weight-bold text-secondary">Permissions</div>
                <div class="text-body-2 text-medium-emphasis">Manage permissions for roles.</div>
            </div>
            <v-btn color="primary" rounded="xl" prepend-icon="mdi-plus" @click="openPermissionDialog">
                New Permission
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
                        <th class="text-left">Permission</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="permission in permissions" :key="permission.id">
                        <td>{{ permission.name }}</td>
                        <td class="text-end">
                            <v-btn
                                icon="mdi-pencil-outline"
                                variant="text"
                                size="small"
                                @click="editPermission(permission)"
                            />
                            <v-btn
                                icon="mdi-delete-outline"
                                variant="text"
                                size="small"
                                color="error"
                                @click="deletePermission(permission)"
                            />
                        </td>
                    </tr>
                    <tr v-if="!permissions.length">
                        <td colspan="2" class="text-center text-medium-emphasis py-8">No permissions yet.</td>
                    </tr>
                </tbody>
            </v-table>
        </v-card>
    </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import http from '../../api/http.js';

const permissions = ref([]);
const loading = ref(true);
const error = ref('');

async function fetchPermissions() {
    loading.value = true;
    error.value = '';
    try {
        const { data } = await http.get('/api/v1/permissions');
        permissions.value = data;
    } catch (e) {
        error.value = e.response?.data?.message || 'Failed to load permissions.';
    } finally {
        loading.value = false;
    }
}

function openPermissionDialog() {
    // Logic to open a dialog for creating a new permission
}

function editPermission(permission) {
    // Logic to edit a permission
}

function deletePermission(permission) {
    if (!confirm(`Delete permission "${permission.name}"?`)) return;
    try {
         http.delete(`/api/v1/permissions/${permission.id}`);
        fetchPermissions();
    } catch (e) {
        error.value = e.response?.data?.message || 'Failed to delete permission.';
    }
}

onMounted(fetchPermissions);
</script>