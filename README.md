# Faisal Car Rentals Perth — Digital Agreement Portal

A mobile-friendly digital car rental agreement system built for Faisal Rasheed, Perth WA. Replaces paper agreements with a fully digital signing workflow: driver fills a public form, signs on-screen, admin reviews in a Filament panel, and a signed PDF is emailed to all parties on approval.

---

## Features

### Driver-Facing (Public — No Login Required)
- Scrollable rental agreement terms before signing
- Agreement form covering vehicle details, driver info, towing contacts, and walkaround comments
- Canvas signature pad (touch + mouse, works on mobile)
- Duplicate submission prevention — blocks resubmit if an active agreement exists
- IP rate limiting — max 3 submissions per IP per 24 hours
- Clean success page with agreement reference number

### Admin Panel (`/admin` — Filament v4)
- **List view** — all agreements with status badges, amber highlight for pending records, sortable by submission date
- **Filters** — by status and date range; search by driver name, license, or plate number
- **Approve** — generates a signed PDF and emails it to owner, admin, and driver in one click
- **Edit before approve** — fix any field on a pending record before approval (typos, wrong plate, etc.)
- **Reject with note** — sends driver a rejection email with your reason; driver can resubmit freely
- **Reset license lock** — unlocks an approved driver to sign a new agreement for a new rental period
- **Resend emails** — resend the signed PDF to all three recipients
- **Download PDF** — download any approved agreement's PDF directly from the panel
- **Plate conflict warning** — banner alert when a pending record's plate already has an active approved agreement
- **Export CSV** — full data export for record-keeping and accounting
- **Agreement Terms editor** — rich-text editor to update the legal clauses; changes apply to future submissions only, previously signed agreements are permanently frozen

### PDF Generation
- A4 PDF via barryvdh/laravel-dompdf — no Chromium required, works on shared hosting
- Embeds driver's signature image
- Contains the exact agreement text the driver read and agreed to at signing time (snapshot — never altered retroactively)
- Stored in `storage/app/agreements/` — never publicly accessible

### Email Delivery
- On approval: signed PDF sent to owner, admin, and driver (3 separate emails)
- On rejection: driver receives rejection reason by email
- Gmail SMTP for production; log driver for local development

---

## Tech Stack

| Layer | Package | Version |
|---|---|---|
| Backend | Laravel | 13 |
| Admin panel | Filament | v4 |
| Frontend | Blade + Tailwind CSS + Alpine.js | v4 / v3 |
| Signature | signature_pad.js (CDN) | v4 |
| PDF | barryvdh/laravel-dompdf | latest |
| Database | MySQL | — |
| Email | Laravel Mail + Gmail SMTP | — |
| Dev tooling | Laravel Boost (dev only) | v2 |

---

## Local Development Setup

### Requirements
- PHP 8.2+
- Composer
- Node.js + npm
- MySQL

### 1. Clone and install dependencies

```bash
git clone <repo-url> car-rental-portal
cd car-rental-portal
composer install
npm install
```

### 2. Environment configuration

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:

```env
APP_NAME="Car Rental Agreement Portal"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_DATABASE=car_rental
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@carrentalperth.com
MAIL_FROM_NAME="Faisal Car Rentals Perth"

QUEUE_CONNECTION=sync
```

### 3. Database setup

```bash
php artisan migrate
php artisan db:seed
```

Seeders create:
- **Admin user** — `admin@carrentalperth.com` / `admin123`
- **Settings** — agreement body, owner email, admin email, owner name, company name
- **5 test agreement records** covering all status scenarios (pending, approved, rejected, reset, plate conflict)

### 4. Build frontend assets

```bash
npm run dev
```

### 5. Start the server

```bash
php artisan serve
```

- Driver form: [http://localhost:8000](http://localhost:8000)
- Admin panel: [http://localhost:8000/admin](http://localhost:8000/admin)

---

## Test Scenarios (Seeded Records)

| Agreement | Driver | Status | Tests |
|---|---|---|---|
| AGR-2026-0001 | Omar Hassan | pending | Normal approve flow, edit-then-approve, reject |
| AGR-2026-0002 | Karim Diallo | approved | Active agreement block, reset flow, PDF download, resend emails |
| AGR-2026-0003 | Sara Malik | rejected | Driver can resubmit freely (not blocked) |
| AGR-2026-0004 | James Whitfield | approved + reset | Driver can submit new agreement (is_reset unlocks) |
| AGR-2026-0005 | Tariq Hussain | pending, same plate as Omar | Triggers plate conflict warning in admin |

---

## Agreement Status Lifecycle

```
Driver submits
      │
  [pending]  ← default
      │
  Admin reviews
      │
  ┌───┴───────────────────────┐
  │                           │
[approved]               [rejected]
  │                           │
PDF generated         Rejection email → driver
3 emails sent         Driver can resubmit (new record)
  │
  [is_reset = true]  ← admin manually resets for new rental period
  │
Driver can resubmit (new record)
```

---

## Admin Workflow Quick Reference

| Situation | Action |
|---|---|
| Driver made a small typo | Edit the pending record → Approve |
| Driver needs to fix something themselves | Reject with note → driver resubmits |
| Driver needs a new agreement (new vehicle/period) | Reset license lock → driver resubmits |
| PDF/email needs to go out again | Resend emails (approved records only) |

---

## Deployment to Hostinger (Shared Hosting)

### 1. Prepare for production

```bash
APP_ENV=production
APP_DEBUG=false

php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. Upload files

- Set document root to `/public_html/your-folder/public`
- Upload all files **except** `/vendor` and `/node_modules`

### 3. On the server

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan db:seed --class=AdminUserSeeder --force
php artisan db:seed --class=SettingsSeeder --force
php artisan storage:link
```

### 4. Gmail SMTP (production email)

In `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_USERNAME=your@gmail.com
MAIL_PASSWORD=your_16_char_app_password
```

Generate App Password: Google Account → Security → 2-Step Verification → App Passwords → Mail.

### 5. Database backup cron (Hostinger hPanel)

```
0 2 * * * mysqldump -u DB_USER -pDB_PASS DB_NAME > /home/username/backups/db-$(date +\%F).sql
```

---

## File Structure

```
app/
├── Http/
│   ├── Controllers/AgreementController.php
│   └── Requests/AgreementRequest.php
├── Jobs/
│   ├── GenerateAgreementPDF.php
│   ├── SendAgreementEmails.php
│   └── SendRejectionEmail.php
├── Mail/
│   ├── AgreementApproved.php
│   └── AgreementRejected.php
├── Models/
│   ├── Agreement.php
│   └── Setting.php
└── Filament/Admin/
    ├── Resources/AgreementResource/
    │   ├── AgreementResource.php
    │   └── Pages/
    │       ├── ListAgreements.php
    │       ├── ViewAgreement.php
    │       └── EditAgreement.php
    └── Pages/AgreementTemplatePage.php

resources/views/
├── agreement/
│   ├── form.blade.php
│   └── success.blade.php
├── pdf/agreement.blade.php
└── emails/
    ├── agreement-approved.blade.php
    └── agreement-rejected.blade.php

database/
├── migrations/
└── seeders/
    ├── AdminUserSeeder.php
    ├── SettingsSeeder.php
    └── AgreementSeeder.php
```

---

## Security Notes

- Driver portal has zero authentication — fully public
- PDF files stored in `storage/app/` — never in `public/` — served only via admin download action
- Agreement snapshot frozen at signing time — admin template edits never alter historical records
- IP rate limiting prevents mass submission abuse
- Admin approval gate — no PDF or email fires until manual admin approval
- Registration disabled in Filament panel — single admin user only

---

## Owner Details (Hardcoded)

These are structural and locked in the Blade template — not editable via the admin panel:

- **Owner:** Faisal Rasheed
- **Address:** 58 Royal Street, Tuart Hill, Perth WA
- **Phone:** 0424022786
- **Insurance:** Commercial Comprehensive — AUD $2,000 excess per incident

The editable portion (legal clauses, terms and conditions) is managed via **Admin → Agreement Terms**.
