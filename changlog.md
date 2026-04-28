# Changelog

All notable changes to the Ormano project will be documented in this file.

This changelog follows the principles of [Keep a Changelog](https://keepachangelog.com/en/1.1.0/) and uses a project-oriented versioning structure.

## [Unreleased]

### Added
- Project vision defined for **Ormano**, a cloud-based Legal ERP tailored for Syrian law offices.
- Core product scope documented for the main business domains:
  - case management
  - legal calendar and deadline tracking
  - offline-first workflow
  - roles and permissions
  - document archiving
  - AI-assisted legal writing
  - financial ledger
  - audit logs
  - client portal
  - legal library
  - analytics and reporting
  - physical file tracking
- English `README.md` created to describe the platform, target users, core features, and setup flow.
- Initial Laravel application structure prepared as the technical base for development.
- Frontend asset pipeline configured with Vite.
- Default project folders created for:
  - application logic
  - routes
  - database migrations and seeders
  - frontend assets
  - test suites
- Expanded `system_structure.md` into a full DDD module blueprint with requirement-to-domain mapping.
- Refined `ormano-system-architecture.md` to align with modular domains, feature toggles, and phased roadmap.
- Documented architecture support for:
  - roles and permissions
  - case management workflows
  - user types (trainee, lawyer, client, visitor)
  - document versioning and restoration
  - audit logs and activity timeline
  - AI legal assistant workflows (template generation, proofreading, summarization, gap analysis)
  - AR/EN localization
  - finance lifecycle (orders, invoices, refunds, payments, expenses, tax)
  - multi-currency
  - subscription plans (Trial -> Basic -> Pro)
  - analytics KPIs (success rate, workload, financial health)
  - module enable/disable controls
  - monitoring, error handling, and health checks
  - unified smart search

### Planned
- Domain models for cases, clients, courts, hearings, documents, invoices, and notifications.
- Authentication and role-based authorization for legal office workflows.
- Offline synchronization strategy for hearing notes and mobile usage scenarios.
- AI-assisted drafting and summarization workflows.
- Reporting dashboards and operational analytics.
- Arabic-first user experience with English reporting support.
- Incremental implementation by phases:
  - Foundation (Identity, Legal, Document, Audit)
  - Productivity (Scheduling, Communication, Search)
  - Commerce (Finance, Subscription, Multi-currency)
  - Intelligence (Analytics, AI features)
  - Reliability (Monitoring and hardening)

## [0.1.0] - 2026-04-03

### Added
- Initial project bootstrap using Laravel.
- Base application entry points and configuration files.
- Initial frontend scaffolding with JavaScript and CSS resources.
- Default database migration setup for framework tables and users.
- Base testing structure for unit and feature tests.
- Public asset build output generated for application delivery.
- Initial repository documentation replaced from framework default content to project-specific product documentation.

### Documentation
- Introduced a full English overview of Ormano as a Legal ERP system.
- Documented major functional pillars including legal operations, financial tracking, document handling, and AI support.
- Added setup instructions for local development with Composer, npm, and Laravel.

### Notes
- Version `0.1.0` represents the foundation stage of the project.
- Business modules described in the documentation are part of the planned product roadmap and will be implemented incrementally in future releases.

---

## Release Guidelines

Recommended release sections for future updates:

- `Added` for new features
- `Changed` for updates in existing behavior
- `Deprecated` for soon-to-be removed features
- `Removed` for deleted features
- `Fixed` for bug fixes
- `Security` for vulnerability-related changes
