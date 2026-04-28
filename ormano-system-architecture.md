# Ormano System Architecture

## 1. Overview
Ormano is a modular legal platform for law offices, built with DDD boundaries so each capability can evolve independently.  
Modules can be enabled or disabled with feature flags and module toggles.

Core principles:
- API-first backend (Laravel)
- Arabic/English localization
- Security and traceability by design (RBAC + audit)
- AI-assisted legal productivity with human approval

---

## 2. High-Level Domains
- Identity: users, roles, permissions, authentication.
- Legal: case lifecycle, parties, hearings, outcomes.
- Document: templates, document versions, legal artifacts.
- Scheduling: tasks, calendar, reminders, deadlines.
- Communication: notifications and delivery channels.
- Finance: orders, invoices, payments, refunds, expenses, tax.
- Subscription: Trial -> Basic -> Pro lifecycle.
- Analytics: success rate, workload, financial health.
- Audit: immutable activity log and timeline.
- Platform: feature flags, module toggles, localization, health checks.
- AI: legal template generation, proofreading, summarization, gap analysis.
- Search: unified intelligent search across modules.

---

## 3. Module Structure
```text
Ormano
├── Identity
│   ├── Users
│   ├── Roles
│   ├── Permissions
├── Legal
│   ├── Cases
│   ├── Parties
│   ├── Hearings
│   ├── Courts
├── Document
│   ├── Templates
│   ├── Documents
│   ├── Document Versions
├── Scheduling
│   ├── Tasks
│   ├── Meetings
│   ├── Calendar
│   ├── Reminders
├── Communication
│   ├── Notifications
│   ├── Notification Templates
│   ├── Delivery Logs
├── Finance
│   ├── Orders
│   ├── Invoices
│   ├── Refunds
│   ├── Payments
│   ├── Expenses
│   ├── Tax Reports
│   ├── Currencies
├── Subscription
│   ├── Plans
│   ├── Subscriptions
│   ├── Quotas
├── Analytics
│   ├── KPI Reports
│   ├── Success Rate
│   ├── Workload
│   ├── Financial Health
├── Audit
│   ├── Activity Logs
├── Platform
│   ├── Feature Flags
│   ├── Module Toggles
│   ├── Settings
│   ├── Localization
│   ├── Health Checks
├── AI
│   ├── AI Agent
│   ├── Prompt Templates
│   ├── AI Logs
├── Search
    ├── Indexing
    ├── Ranking
```

---

## 4. Requirement Coverage

### Identity
- Supports Trainee, Lawyer, Client, Visitor user types.
- Role and permission management for all modules.

### Legal + Document
- Full case management and workflow tracking.
- Document handling with template-based drafting.
- Version control for legal files and restore capability.

### Scheduling + Communication
- Unified calendar and hearing/task reminders.
- Notification engine (in-app, email, optional SMS/WhatsApp).

### AI (Killer Feature)
- AI legal template writing.
- Arabic legal/language proofreading.
- Case summarization.
- Gap analysis for missing arguments/evidence.

### Finance + Subscription
- Orders, invoices, refunds.
- Payment channels: Visa/MasterCard and cash.
- Multi-currency support.
- Expense tracking for office costs.
- Tax report generation.
- Subscription plans and upgrade/downgrade flow.

### Analytics + Audit + Platform + Search
- Success rate, workload, and monthly profit/loss reporting.
- Immutable audit log for legal traceability.
- Module enable/disable.
- Monitoring, error handling, and health check endpoints.
- Unified smart search across key entities.

---

## 5. Example API Surface (Initial)

Identity:
- `POST /users`
- `GET /users`
- `POST /roles`
- `POST /roles/{roleId}/permissions`

Legal:
- `POST /cases`
- `GET /cases/{id}`
- `POST /cases/{id}/assignments`
- `POST /cases/{id}/close`

Document:
- `POST /documents/from-template`
- `POST /documents/{id}/versions`
- `POST /documents/{id}/restore/{versionId}`

Scheduling:
- `POST /calendar/events`
- `POST /deadlines`

Finance:
- `POST /orders`
- `POST /invoices`
- `POST /payments/card`
- `POST /payments/cash`
- `POST /refunds`
- `POST /expenses`

Analytics:
- `GET /reports/success-rate`
- `GET /reports/workload`
- `GET /reports/financial-health`

Platform:
- `PUT /modules/{module}/toggle`
- `GET /health`

---

## 6. DDD Implementation Notes
- Keep domain logic in aggregates/value objects, not controllers.
- Emit domain events for side effects (notifications, indexing, analytics).
- Keep repository interfaces in domain and implementations in infrastructure.
- Use module toggles to avoid coupling optional capabilities.
- Enforce audit logging for sensitive operations by policy.

---

## 7. Delivery Roadmap
1. Foundation: Identity, Legal, Document, Audit, AR/EN.
2. Productivity: Scheduling, Communication, Search.
3. Commerce: Finance + Subscription + Multi-currency.
4. Intelligence: Analytics + AI legal assistant.
5. Reliability: Monitoring, error handling, health checks, hardening.