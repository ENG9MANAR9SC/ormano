<template>
    <v-container fluid class="pa-6">
        <v-btn variant="text" prepend-icon="mdi-arrow-left" class="mb-4" :to="{ name: 'users.index' }">
            Back to users
        </v-btn>

        <v-alert v-if="error" type="error" variant="tonal" class="mb-4">{{ error }}</v-alert>

        <v-progress-circular v-if="loading" indeterminate color="primary" class="ma-8" />

        <template v-else-if="u">
            <div class="d-flex flex-wrap justify-space-between align-start gap-4 mb-6">
                <div>
                    <h1 class="text-h4 font-weight-bold text-secondary">{{ u.name }}</h1>
                    <div class="text-body-2 text-medium-emphasis">
                        {{ u.role || 'Role not set' }}
                        <span v-if="u.is_active"> · Active</span>
                        <span v-else> · Inactive</span>
                    </div>
                </div>
                <div class="d-flex ga-2">
                    <v-btn variant="outlined" rounded="xl" :to="{ name: 'users.edit', params: { id: u.id } }">
                        Edit
                    </v-btn>
                    <v-btn color="error" variant="tonal" rounded="xl" @click="deleteUser"> Delete </v-btn>
                </div>
            </div>

            <v-card rounded="xl" elevation="0" class="border pa-4">
                <v-row dense>
                    <v-col cols="12" sm="6">
                        <div class="text-caption text-medium-emphasis">Email</div>
                        <div>{{ u.email || '—' }}</div>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <div class="text-caption text-medium-emphasis">Role</div>
                        <div>{{ u.role || '—' }}</div>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <div class="text-caption text-medium-emphasis">Status</div>
                        <div>
                            <v-chip
                                :color="u.is_active ? 'success' : 'error'"
                                class="text-capitalize"
                                small
                            >
                                {{ u.is_active ? 'Active' : 'Inactive' }}
                            </v-chip>
                        </div>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <div class="text-caption text-medium-emphasis">Created At</div>
                        <div>{{ u.created_at || '—' }}</div>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <div class="text-caption text-medium-emphasis">Updated At</div>
                        <div>{{ u.updated_at || '—' }}</div>
                    </v-col>
                </v-row>
            </v-card>
        </template>
    </v-container>
</template>

<script setup>
import { ref, watch } from 'vue';
import { useRouter } from 'vue-router';
import http from '../../api/http.js';

const props = defineProps({
    id: { type: [String, Number], required: true },
});

const router = useRouter();
const u = ref(null);
const loading = ref(true);
const error = ref('');

async function fetchUser() {
    loading.value = true;
    error.value = '';
    try {
        const { data } = await http.get(`/api/v1/users/${props.id}`);
        u.value = data.data;
    } catch (e) {
        error.value = e.response?.data?.message || 'User not found.';
        u.value = null;
    } finally {
        loading.value = false;
    }
}

async function deleteUser() {
    if (!confirm('Delete this user?')) return;
    try {
        await http.delete(`/api/v1/users/${props.id}`);
        router.push({ name: 'users.index' });
    } catch (e) {
        error.value = e.response?.data?.message || 'Could not delete user.';
    }
}

watch(
    () => props.id,
    () => fetchUser(),
    { immediate: true },
);
</script>