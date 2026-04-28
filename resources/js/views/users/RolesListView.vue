<template>
    <v-container fluid class="pa-6">
        <div class="d-flex flex-wrap align-center justify-space-between gap-4 mb-6">
            <div>
                <div class="text-h5 font-weight-bold text-secondary">Roles</div>
                <div class="text-body-2 text-medium-emphasis">Manage roles for users.</div>
            </div>
            <v-btn color="primary" rounded="xl" prepend-icon="mdi-plus" @click="openRoleDialog">
                New Role
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
                        <th class="text-left">Role</th>
                        <th class="text-left">Permissions</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="role in roles" :key="role.id">
                        <td>{{ role.name }}</td>
                        <td>
                            {{ role.permissions.length ? role.permissions.map(permission => permission.name).join(', ') : 'No permissions' }}
                        </td>
                        <td class="text-end">
                            <v-btn
                                icon="mdi-pencil-outline"
                                variant="text"
                                size="small"
                                @click="editRole(role)"
                            />
                            <v-btn
                                icon="mdi-delete-outline"
                                variant="text"
                                size="small"
                                color="error"
                                @click="deleteRole(role)"
                            />
                        </td>
                    </tr>
                    <tr v-if="!roles.length">
                        <td colspan="3" class="text-center text-medium-emphasis py-8">No roles yet.</td>
                    </tr>
                </tbody>
            </v-table>
        </v-card>

        <!-- Dialog for Creating a New Role -->
        <v-dialog v-model="roleDialog" max-width="500px">
            <v-card>
                <v-card-title>
                    <span class="text-h6">Create New Role</span>
                </v-card-title>
                <v-card-text>
                    <v-alert v-if="dialogError" type="error" variant="tonal" class="mb-4">
                        {{ dialogError }}
                    </v-alert>
                    <v-text-field
                        v-model="newRole.name"
                        label="Role Name"
                        outlined
                        dense
                        required
                    />
                    <v-select
                        v-model="newRole.permissions"
                        :items="permissions"
                        item-value="id"
                        item-text="name"
                        label="Assign Permissions"
                        multiple
                        outlined
                        dense
                    />
                </v-card-text>
                <v-card-actions>
                    <v-spacer />
                    <v-btn text @click="closeRoleDialog">Cancel</v-btn>
                    <v-btn color="primary" @click="createRole">Create</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import http from '../../api/http.js';

const roles = ref([]);
const permissions = ref([]);
const loading = ref(true);
const error = ref('');
const roleDialog = ref(false);
const dialogError = ref('');
const newRole = ref({
    name: '',
    permissions: [],
});

async function fetchPermissions() {
    try {
        const { data } = await http.get('/api/v1/permissions');
        permissions.value = data;
    } catch (e) {
        error.value = e.response?.data?.message || 'Failed to load permissions.';
    }
}

async function fetchRoles() {
    loading.value = true;
    error.value = '';
    try {
        const { data } = await http.get('/api/v1/roles');
        roles.value = data;
    } catch (e) {
        error.value = e.response?.data?.message || 'Failed to load roles.';
    } finally {
        loading.value = false;
    }
}

function openRoleDialog() {
    newRole.value = { name: '', permissions: [] }; // Reset the form
    dialogError.value = ''; // Clear any previous errors
    roleDialog.value = true; // Open the dialog
}

function closeRoleDialog() {
    roleDialog.value = false; // Close the dialog
}

async function createRole() {
    dialogError.value = ''; // Clear any previous errors
    try {
        const payload = {
            name: newRole.value.name,
            permissions: newRole.value.permissions,
        };
        await http.post('/api/v1/roles', payload); // Send the request to create a new role
        fetchRoles(); // Refresh the roles list
        closeRoleDialog(); // Close the dialog
    } catch (e) {
        dialogError.value = e.response?.data?.message || 'Failed to create role.';
    }
}
function editRole(role) {
    // Logic to edit a role
}

function deleteRole(role) {
    if (!confirm(`Delete role "${role.name}"?`)) return;
    try {
         http.delete(`/api/v1/roles/${role.id}`);
        fetchRoles();
    } catch (e) {
        error.value = e.response?.data?.message || 'Failed to delete role.';
    }
}

onMounted(() => {
    fetchRoles();
    fetchPermissions();
});
</script>