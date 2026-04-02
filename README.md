# Ormano

Ormano is a cloud-based **Legal ERP** system designed specifically for Syrian law offices. It helps lawyers replace paper-heavy workflows with a structured digital platform for case management, legal scheduling, document archiving, financial tracking, and AI-assisted legal writing.

The system is built to support the real operating conditions of local legal practice, including **offline-first usage**, strict **role-based access**, and fast access to case files from both desktop and mobile devices.

## System Overview

Ormano is designed to solve the daily operational challenges faced by legal professionals by combining administration, legal workflow, document handling, and reporting into one platform.

Its main goals are to:

- digitize paper-based legal work
- reduce missed legal deadlines
- improve internal office coordination
- simplify drafting of legal documents
- provide secure and traceable access to case data
- support unstable internet environments through offline-first capabilities

## Core Features

### 1. Case Management
A complete digital archive for legal cases, including:

- case number
- court name
- parties involved
- status and history
- event timeline for each case

This allows lawyers and staff to quickly retrieve the full context of any case without depending on paper folders.

### 2. Legal Calendar
A dedicated legal calendar for managing:

- court hearings
- service and notification dates
- appeal deadlines
- critical legal time limits

The calendar includes a notification system to alert users before important deadlines, helping prevent missed sessions or procedural time limits.

### 3. Offline-First Operation
Ormano is built to work in environments where internet access may be unreliable.

Users can:

- browse key data offline
- review schedules
- add hearing notes while at court
- sync data later when connectivity returns

This is an essential capability for field work and daily legal operations.

### 4. Roles and Permissions
The system supports different user roles with controlled access to data and actions, such as:

- senior lawyer
- trainee lawyer
- secretary / administrative staff

This helps protect confidential legal information and ensures that each user only sees or edits what they are authorized to handle.

### 5. Document Scanning and Archiving
Users can upload and link scanned documents directly to a case, including:

- powers of attorney
- court documents
- IDs and supporting evidence
- signed papers and attachments

This makes it possible to access case files instantly from mobile devices or office workstations.

### 6. Clever Templates
Ormano can automatically generate the opening structure of legal documents and pleadings using case data, such as:

- court name
- claimant and defendant names
- case references
- common legal formatting elements

This reduces repetitive manual drafting and improves consistency across documents.

### 7. AI Writing Agent
The platform includes an AI-powered legal writing assistant that can help with tasks such as:

- suggesting legal phrasing
- drafting initial text for memoranda
- summarizing opposing party submissions
- accelerating document preparation

This feature is intended to support lawyers, not replace legal judgment.

### 8. Financial Ledger
A built-in financial module helps track:

- legal fees
- client advances
- case expenses
- stamp costs
- court and filing fees
- simplified invoices

This gives law offices better visibility into revenue, expenses, and case-level financial activity.

### 9. Audit Logs
Every important action can be traced, including:

- who edited a record
- who uploaded a document
- when a change happened

Audit logs are especially important for larger law offices where multiple users collaborate on the same cases.

### 10. Arabic / English Support
The system is primarily designed with an Arabic interface, while also supporting English output for selected reports and communication needs.

### 11. Client Portal
A lightweight client portal allows clients to follow the status of their case without needing to directly contact the lawyer for every update.

This can improve transparency and reduce repetitive follow-up communication.

### 12. Legal Library
The platform can be connected to a searchable legal knowledge base that includes:

- Syrian laws
- legal references
- judicial precedents

This helps lawyers search legal sources more quickly while working on cases and memoranda.

### 13. Online Payment Support
Where available, the system can integrate with local online payment solutions or agent-based balance top-up workflows.

### 14. Analytics and Reporting
Ormano can provide visual and operational reports related to:

- case success rates
- employee productivity
- monthly profits
- office performance metrics

These insights support better business and legal decision-making.

### 15. Physical File Tracking
Even when paper files still exist, the system can track the physical location of each paper dossier inside office shelves or storage locations.

This reduces time wasted searching for physical files.

## Target Users

Ormano is intended for:

- independent lawyers
- small and medium-sized law offices
- larger legal practices with multiple staff roles
- legal teams that need mobile access and auditability
- offices transitioning from paper-based systems to digital operations

## Key Value Proposition

Ormano is more than a simple case tracker. It is a full legal operations platform focused on the practical needs of Syrian legal professionals.

It combines:

- legal case administration
- scheduling and deadline protection
- document management
- AI-assisted drafting
- financial tracking
- client communication
- offline usability

## Technology Stack

This repository is currently structured as a Laravel application with a modern frontend asset pipeline.

Main technologies in the project include:

- Laravel
- PHP
- Vite
- JavaScript
- CSS

## Getting Started

### Requirements

- PHP 8+
- Composer
- Node.js and npm
- a database supported by Laravel

### Installation

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

### Run the application

```bash
php artisan serve
npm run dev
```

## Future Direction

The long-term vision of Ormano is to become a complete legal operating system for law offices, with reliable offline access, Arabic-first usability, intelligent automation, and secure collaboration between lawyers, staff, and clients.

## License

This project is proprietary unless a separate license is provided by the project owner.
