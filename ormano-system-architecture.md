Ormano System Architecture
1. Overview
The Ormano system is a modular application designed to manage legal workflows, financial operations, analytics, and AI-powered features. The architecture is structured around Domain-Driven Design (DDD) principles and modular microservices. Each module is independent and can be enabled or disabled using Feature Flags.

2. High-Level Architecture
The system is divided into the following domains:

Core: Handles users, roles, permissions, and system settings.
Legal: Manages cases, clients, courts, and documents.
Work Management: Tracks tasks, meetings, and calendars.
Finance: Manages orders, invoices, expenses, and financial reports.
Analytics & Logs: Provides reports, audit logs, and error tracking.
Communication: Handles notifications and templates.
AI Module: Provides AI-powered features like document generation, proofreading, and case analysis.
3. Modular Structure
The system is organized into modules. Each module has its own controllers, services, repositories, and database tables. Below is the proposed structure:
Ormano
├── Core
│   ├── Users
│   ├── Roles & Permissions
│   ├── Settings
│   ├── Feature Flags
├── Legal
│   ├── Cases
│   ├── Clients
│   ├── Courts (Mahakem)
│   ├── Documents
│   ├── Document Versions
├── Work Management
│   ├── Tasks
│   ├── Meetings
│   ├── Calendar
├── Finance
│   ├── Orders
│   ├── Billing Documents
│   ├── Invoices
│   ├── Credit Notes
│   ├── Refunds
│   ├── Expenses
│   ├── Plans
│   ├── Referrals
├── Analytics & Logs
│   ├── Reports
│   ├── Audit Logs
│   ├── Error Logs
│   ├── AI Logs
├── Communication
│   ├── Notifications
│   ├── Templates
├── AI Module
    ├── AI Agent
    ├── AI Agent Logs

    4. Core Module
4.1 Users
Responsibilities:
Manage user accounts, profiles, and authentication.
Support multiple user types: Trainee, Lawyer, Client, Visitor.
Endpoints:
POST /users: Create a new user.
GET /users: List all users.
GET /users/{id}: Get user details.
PUT /users/{id}: Update user details.
DELETE /users/{id}: Delete a user.
4.2 Roles & Permissions
Responsibilities:
Manage roles and permissions for users.
Assign roles to users and permissions to roles.
Endpoints:
GET /roles: List all roles.
POST /roles: Create a new role.
PUT /roles/{id}: Update a role.
DELETE /roles/{id}: Delete a role.
GET /permissions: List all permissions.
4.3 Settings
Responsibilities:
Manage system-wide settings (e.g., languages, currencies).
Enable/disable modules using Feature Flags.
4.4 Feature Flags
Responsibilities:
Dynamically enable or disable features.
Example: Enable AI Agent, disable Notifications.
5. Legal Module
5.1 Cases
Responsibilities:
Manage legal cases, including case details, statuses, and associated clients.
Endpoints:
POST /cases: Create a new case.
GET /cases: List all cases.
GET /cases/{id}: Get case details.
PUT /cases/{id}: Update case details.
DELETE /cases/{id}: Delete a case.
5.2 Clients
Responsibilities:
Manage client data, including personal details and contact information.
Endpoints:
POST /clients: Create a new client.
GET /clients: List all clients.
GET /clients/{id}: Get client details.
5.3 Courts (Mahakem)
Responsibilities:
Manage court-related data (e.g., court names, locations, jurisdictions).
5.4 Documents
Responsibilities:
Manage legal documents and their versions.
Track changes to documents.
6. Work Management Module
6.1 Tasks
Responsibilities:
Manage tasks assigned to users.
Track task statuses and deadlines.
6.2 Meetings
Responsibilities:
Schedule and manage meetings.
Integrate with the calendar.
6.3 Calendar
Responsibilities:
Provide a unified calendar for tasks, meetings, and deadlines.
7. Finance Module
7.1 Orders & Invoices
Responsibilities:
Manage orders, invoices, and refunds.
Support online payments (Visa, MasterCard, Cash).
7.2 Expenses
Responsibilities:
Track office expenses (e.g., rent, electricity, transportation).
7.3 Tax Reports
Responsibilities:
Generate tax reports based on financial data.
7.4 Subscription Management
Responsibilities:
8. Analytics & Logs Module
8.1 Reports
Responsibilities:
Generate reports for success rates, workload, and financial health.
8.2 Audit Logs
Responsibilities:
Track user activities (e.g., "Trainee uploaded a document at 10:00 AM").
8.3 Error Logs
Responsibilities:
Track system errors and exceptions.
8.4 AI Logs
Responsibilities:
Track AI-related activities (e.g., document generation, proofreading).