import { createRouter, createWebHashHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        name: 'dashboard',
        component: () => import('../views/DashboardView.vue'),
        meta: { title: 'Overview' },
    },

    // ***** Work **** //

    // tasks
    {
        path: '/tasks/index',
        name: 'tasks.index',
        component: () => import('../views/tasks/TasksListView.vue'),
        meta: { title: 'New Task' },
    },

    // calender
    {
        path: '/calender/index',
        name: 'calender.index',
        component: () => import('../views/calender/CalenderListView.vue'),
        meta: { title: 'New Task' },
    },

    // Meetings
    {
        path: '/meetings/index',
        name: 'meetings.index',
        component: () => import('../views/meetings/MeetingsListView.vue'),
        meta: { title: 'New Notification' },
    },

    // notifications
    {
        path: '/notifications/index',
        name: 'notifications.index',
        component: () => import('../views/calender/CalenderListView.vue'),
        meta: { title: 'New Notification' },
    },

    // ***** Legal **** //
    // cases
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

    // courts
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

    // clients
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



    // ***** AI Assistant **** //

    // ***** Finance **** //

    // ***** Reports **** //

    // ***** Users **** //
    // Users
    {
        path: '/users/index',
        name: 'users.index',
        component: () => import('../views/users/UsersListView.vue'),
        meta: { title: 'Users' },
    },
    {
        path: '/users/create',
        name: 'users.create',
        component: () => import('../views/users/UsersFormView.vue'),
        meta: { title: 'New User' },
    },
    {
        path: '/users/:id/show',
        name: 'users.show',
        component: () => import('../views/users/UsersShowView.vue'),
        meta: { title: 'User' },
        props: true,
    },
    {
        path: '/users/:id/edit',
        name: 'users.edit',
        component: () => import('../views/users/UsersFormView.vue'),
        meta: { title: 'Edit User' },
        props: true,
    },

    // ***** Logs **** //

   // ***** Settings **** //





];

export default createRouter({
    history: createWebHashHistory(),
    routes,
    scrollBehavior() {
        return { top: 0 };
    },
});
