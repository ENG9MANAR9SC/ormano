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
        path: '/tasks',
        name: 'tasks.index',
        component: () => import('../views/tasks/TasksListView.vue'),
        meta: { title: 'Tasks' },
    },
    {
        path: '/tasks/create',
        name: 'tasks.create',
        component: () => import('../views/tasks/TaskFormView.vue'),
        meta: { title: 'New task' },
    },
    {
        path: '/tasks/:id',
        name: 'tasks.show',
        component: () => import('../views/tasks/TaskShowView.vue'),
        meta: { title: 'Task' },
        props: true,
    },
    {
        path: '/tasks/:id/edit',
        name: 'tasks.edit',
        component: () => import('../views/tasks/TaskFormView.vue'),
        meta: { title: 'Edit task' },
        props: true,
    },
    {
        path: '/tasks/calendar',
        name: 'tasks.calendar',
        component: () => import('../views/tasks/TaskCalendarView.vue'),
        meta: { title: 'Task calendar' },
    },
    {
        path: '/documents',
        name: 'documents.index',
        component: () => import('../views/documents/DocumentsListView.vue'),
        meta: { title: 'Documents' },
    },
    {
        path: '/documents/create',
        name: 'documents.create',
        component: () => import('../views/documents/DocumentFormView.vue'),
        meta: { title: 'New document' },
    },
    {
        path: '/documents/:id',
        name: 'documents.show',
        component: () => import('../views/documents/DocumentShowView.vue'),
        meta: { title: 'Document' },
        props: true,
    },
    {
        path: '/documents/:id/edit',
        name: 'documents.edit',
        component: () => import('../views/documents/DocumentFormView.vue'),
        meta: { title: 'Edit document' },
        props: true,
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
    {
        path: '/roles',
        name: 'roles.index',
        component: () => import('../views/users/RolesListView.vue'),
        meta: { title: 'Roles', requiresAuth: true },
    },
    {
        path: '/permissions',
        name: 'permissions.index',
        component: () => import('../views/users/PermissionsListView.vue'),
        meta: { title: 'Permissions', requiresAuth: true },
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
