import { createRouter, createWebHashHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        name: 'dashboard',
        component: () => import('../views/DashboardView.vue'),
        meta: { title: 'Overview' },
    },
    {
        path: '/cases',
        name: 'cases.index',
        component: () => import('../views/cases/CasesListView.vue'),
        meta: { title: 'Cases' },
    },
    {
        path: '/cases/create',
        name: 'cases.create',
        component: () => import('../views/cases/CaseFormView.vue'),
        meta: { title: 'New case' },
    },
    {
        path: '/cases/:id',
        name: 'cases.show',
        component: () => import('../views/cases/CaseShowView.vue'),
        meta: { title: 'Case' },
        props: true,
    },
    {
        path: '/cases/:id/edit',
        name: 'cases.edit',
        component: () => import('../views/cases/CaseFormView.vue'),
        meta: { title: 'Edit case' },
        props: true,
    },
    {
        path: '/clients',
        name: 'clients.index',
        component: () => import('../views/clients/ClientsListView.vue'),
        meta: { title: 'Clients' },
    },
    {
        path: '/clients/create',
        name: 'clients.create',
        component: () => import('../views/clients/ClientFormView.vue'),
        meta: { title: 'New client' },
    },
    {
        path: '/clients/:id',
        name: 'clients.show',
        component: () => import('../views/clients/ClientShowView.vue'),
        meta: { title: 'Client' },
        props: true,
    },
    {
        path: '/clients/:id/edit',
        name: 'clients.edit',
        component: () => import('../views/clients/ClientFormView.vue'),
        meta: { title: 'Edit client' },
        props: true,
    },
    {
        path: '/courts',
        name: 'courts.index',
        component: () => import('../views/courts/CourtsListView.vue'),
        meta: { title: 'Courts' },
    },
    {
        path: '/courts/create',
        name: 'courts.create',
        component: () => import('../views/courts/CourtFormView.vue'),
        meta: { title: 'New court' },
    },
    {
        path: '/courts/:id',
        name: 'courts.show',
        component: () => import('../views/courts/CourtShowView.vue'),
        meta: { title: 'Court' },
        props: true,
    },
    {
        path: '/courts/:id/edit',
        name: 'courts.edit',
        component: () => import('../views/courts/CourtFormView.vue'),
        meta: { title: 'Edit court' },
        props: true,
    },
];

export default createRouter({
    history: createWebHashHistory(),
    routes,
    scrollBehavior() {
        return { top: 0 };
    },
});
