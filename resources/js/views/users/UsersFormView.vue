<template>
    <v-container fluid class="pa-6">
        <v-btn variant="text" prepend-icon="mdi-arrow-left" class="mb-4" :to="{ name: 'users.index' }">
            Back to users
        </v-btn>

        <div class="text-h5 font-weight-bold text-secondary mb-6">{{ isEdit ? 'Edit user' : 'New user' }}</div>

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
                        <v-text-field v-model="form.name" label="Name *" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="form.email" label="Email *" type="email" variant="outlined" rounded="lg" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-select
                            v-model="form.role"
                            :items="roles"
                            label="Role *"
                            variant="outlined"
                            rounded="lg"
                            clearable
                        />
                    </v-col>
                    <v-col cols="12" md="6" v-if="!isEdit">
                        <v-text-field
                            v-model="form.password"
                            label="Password *"
                            type="password"
                            variant="outlined"
                            rounded="lg"
                        />
                    </v-col>
                    <v-col cols="12" md="6" v-if="!isEdit">
                        <v-text-field
                            v-model="form.password_confirmation"
                            label="Confirm Password *"
                            type="password"
                            variant="outlined"
                            rounded="lg"
                        />
                    </v-col>
                    <v-col cols="12">
                        <v-switch v-model="form.is_active" color="primary" label="Active (enable user)" hide-details />
                    </v-col>
                </v-row>

                <div class="d-flex flex-wrap ga-3 mt-4">
                    <v-btn type="submit" color="primary" rounded="xl" :loading="saving"> Save </v-btn>
                    <v-btn variant="outlined" rounded="xl" :to="{ name: 'users.index' }"> Cancel </v-btn>
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
const isEdit = computed(() => route.name === 'users.edit');
const userId = computed(() => route.params.id);

const roles = ref(['Admin', 'User']); // Available roles

const form = reactive({
    name: '',
    email: '',
    role: '',
    password: '',
    password_confirmation: '',
    is_active: true,
});

const bootLoading = ref(true);
const saving = ref(false);
const error = ref('');
const fieldErrors = ref(null);

function applyPayload(p) {
    form.name = p.name ?? '';
    form.email = p.email ?? '';
    form.role = p.role ?? '';
    form.is_active = p.is_active !== undefined ? Boolean(p.is_active) : true;
}

async function boot() {
    bootLoading.value = true;
    error.value = '';
    try {
        if (isEdit.value && userId.value) {
            const res = await http.get(`/api/v1/users/${userId.value}`);
            applyPayload(res.data.data);
        } else {
            applyPayload({});
        }
    } catch (e) {
        error.value = e.response?.data?.message || 'Failed to load form.';
    } finally {
        bootLoading.value = false;
    }
}

function payload() {
    const p = { ...form };
    if (!isEdit.value) {
        p.password = form.password;
        p.password_confirmation = form.password_confirmation;
    }
    return p;
}

async function submit() {
    saving.value = true;
    error.value = '';
    fieldErrors.value = null;
    try {
        if (isEdit.value) {
            await http.put(`/api/v1/users/${userId.value}`, payload());
            router.push({ name: 'users.show', params: { id: userId.value } });
        } else {
            const { data } = await http.post('/api/v1/users', payload());
            router.push({ name: 'users.show', params: { id: data.data.id } });
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