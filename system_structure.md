# Lawyer Management System - DDD System Structure

## Purpose
Ormano is designed as a modular legal ERP for law offices, with Arabic-first support and scalable architecture.  
The target stack is:

- Backend: Laravel (API-first)
- Frontend: Vue.js
- Architecture: Domain-Driven Design (DDD) + modular domains

---

## Architecture Overview
The system follows clear layers:

1. Presentation Layer: HTTP/API controllers, requests, resources.
2. Application Layer: use cases, orchestration, DTOs, policies.
3. Domain Layer: entities, value objects, aggregates, repository contracts, domain services.
4. Infrastructure Layer: Eloquent, cache, queues, payment gateways, AI providers, notifications.

---

## Proposed Project Structure
```text
app/
 ├── Domains/
 │   ├── Identity/            # Users, roles, permissions, auth
 │   ├── Legal/               # Cases, parties, hearings, legal workflow
 │   ├── Document/            # Documents, templates, versions, legal review
 │   ├── Scheduling/          # Calendar, deadlines, tasks, reminders
 │   ├── Communication/       # Notifications, channels, templates
 │   ├── Finance/             # Orders, invoices, refunds, expenses, tax
 │   ├── Subscription/        # Trial, Basic, Pro, quotas, billing cycle
 │   ├── Analytics/           # KPIs, success rate, workload, P/L
 │   ├── Audit/               # Audit log, activity timeline
 │   ├── Search/              # Clever search, indexing, ranking
 │   ├── Platform/            # Feature flags, module toggles, settings, localization
 │   └── AI/                  # AI template writer, legal proofreading, summarization, gap analysis
 │
 ├── Application/
 │   ├── UseCases/
 │   ├── DTOs/
 │   ├── Policies/
 │   └── Jobs/
 │
 ├── Infrastructure/
 │   ├── Persistence/
 │   ├── ExternalServices/
 │   ├── Queues/
 │   ├── Monitoring/
 │   └── Search/
 │
 └── Http/
     ├── Controllers/
     ├── Requests/
     └── Resources/
```

---

## Requirement Mapping by Domain

### 1) Identity Domain
Requirements covered:
- Roles & Permissions
- User types: Trainee, Lawyer, Client, Visitor
- Access policies by module and action

Key entities:
- User, Role, Permission, UserProfile, UserStatus

Key use cases:
- AssignRoleToUser
- GrantPermissionToRole
- ActivateOrSuspendUser
- InviteClientPortalUser

---

### 2) Legal Domain (Core Case Management)
Requirements covered:
- Case Management
- Workflow and tracking
- Trainee/lawyer assignment by case
- Success Rate KPI source data
- Workload KPI source data

Key entities:
- CaseFile, CaseParty, Hearing, CourtReference, CaseStage, CaseAssignment

Key use cases:
- CreateCaseFile
- AssignCaseToLawyerOrTrainee
- UpdateCaseStage
- CloseCaseWithOutcome (won/lost/settled)

---

### 3) Document Domain
Requirements covered:
- Documents
- Clever templates
- Version Control for legal drafts
- Documentation records

Key entities:
- Document, DocumentTemplate, DocumentVersion, TemplateVariable, Attachment

Key use cases:
- CreateDocumentFromTemplate
- SaveDocumentVersion
- RestoreDocumentVersion
- CompareDocumentVersions

Versioning rule:
- Every save creates immutable `DocumentVersion`.
- User can restore any historical version (for example, memo from two days ago).

---

### 4) Scheduling Domain
Requirements covered:
- Calendar
- Notifications & Calendar integration
- Court hearing reminders and deadlines

Key entities:
- CalendarEvent, Deadline, Reminder, TaskItem, TaskAssignment

Key use cases:
- ScheduleHearing
- CreateDeadlineReminder
- SyncCaseEventsToCalendar
- EscalateOverdueTask

---

### 5) Communication Domain
Requirements covered:
- Notifications (in-app, email, SMS/WhatsApp optional)
- Notification templates in AR/EN

Key entities:
- Notification, NotificationChannel, NotificationTemplate, DeliveryLog

Key use cases:
- SendCaseUpdateNotification
- SendPaymentReminder
- BroadcastSystemAlert

---

### 6) AI Domain (Killer Feature)
Requirements covered:
- AI template writing
- AI agent support
- Arabic legal proofreading and summarization
- Legal gap analysis (analysis of missing arguments/evidence)

Key entities:
- AIRequest, AIResult, AIPromptTemplate, AIModelConfig, AIUsageLog

Key use cases:
- GenerateLegalTemplate
- ProofreadArabicLegalText
- SummarizeCaseFile
- AnalyzeLegalGaps

Governance:
- Human-in-the-loop approval before final document publish.
- Full audit trail for AI-generated outputs.

---

### 7) Finance Domain
Requirements covered:
- Orders, invoices, refunds
- Online payment (Visa/MasterCard) + cash
- Multi-currency
- Expenses tracking (rent, electricity, stamps, transportation)
- Tax reports
- Financial health reporting source data

Key entities:
- Order, Invoice, Refund, Payment, Currency, ExchangeRate, Expense, TaxReport

Key use cases:
- CreateInvoiceFromOrder
- RecordCashPayment
- ProcessCardPayment
- RegisterExpense
- GenerateTaxReport

---

### 8) Subscription Domain
Requirements covered:
- Subscription management (Trial -> Basic -> Pro)

Key entities:
- Plan, Subscription, SubscriptionFeature, BillingCycle, UsageQuota

Key use cases:
- StartTrial
- UpgradePlan
- DowngradePlan
- EnforcePlanLimits

---

### 9) Analytics Domain
Requirements covered:
- Success Rate (won vs lost)
- Workload (active cases per trainee/lawyer)
- Financial Health (monthly P/L)

Key entities:
- MetricSnapshot, KPIReport, DashboardWidget

Key use cases:
- ComputeSuccessRate
- ComputeWorkloadByLawyer
- BuildMonthlyProfitAndLoss

---

### 10) Audit Domain
Requirements covered:
- Full Audit Log for activity timeline
- Change log readiness
- Traceability for legal and office protection

Key entities:
- AuditLogEntry, Actor, ActionType, EntityReference, ChangeSet

Key use cases:
- RecordUserAction
- ViewEntityTimeline
- ExportAuditReport

Example log:
- "Trainee Ahmed uploaded power-of-attorney image at 10:00 AM."

---

### 11) Platform Domain
Requirements covered:
- Independent modules (enable/disable)
- Languages AR/EN
- Versions & change log support
- Monitoring, error handling, health checks

Key entities:
- FeatureFlag, ModuleToggle, SystemSetting, LocaleSetting, HealthCheckResult

Key use cases:
- EnableModule
- DisableModule
- SwitchLanguage
- RunHealthChecks

---

### 12) Search Domain
Requirements covered:
- Clever Search across cases, clients, documents, invoices, activities

Key entities:
- SearchIndex, SearchQuery, SearchFilter, SearchResult

Key use cases:
- IndexCaseData
- IndexDocumentContent
- SearchAcrossModules
- RankResultsByRelevance

---

## Cross-Cutting Technical Requirements
- Versioning: optimistic locking for critical aggregates + immutable document versions.
- Logging: structured logs for API/application/domain events.
- Monitoring: centralized error tracking + service health checks.
- Localization: AR/EN labels, templates, date/number formatting.
- Security: RBAC + policy checks + audit logs on sensitive actions.
- Integration: payment gateways, email/SMS providers, AI provider abstraction.

---

## DDD Best Practices for Refactor
1. Keep each domain isolated and communicate through application use cases.
2. Keep domain layer framework-agnostic (pure PHP).
3. Use repository interfaces in domain, concrete implementations in infrastructure.
4. Model legal invariants inside aggregates (not in controllers).
5. Use domain events for side effects (notifications, indexing, analytics updates).
6. Use module toggles to avoid hard dependencies between optional features.
7. Write unit tests per domain rule and integration tests per use case.

---

## Delivery Phases (Suggested)
1. Foundation: Identity, Legal core, Document, Audit, AR/EN basics.
2. Office Operations: Scheduling, Communication, Search, module toggles.
3. Finance: invoicing, payments, refunds, multi-currency, expenses, tax.
4. Intelligence: Analytics dashboards + AI legal assistant features.
5. Hardening: monitoring, health checks, performance tuning, compliance exports.

---

This structure aligns your listed requirements with a scalable DDD blueprint and supports incremental delivery without large rewrites.