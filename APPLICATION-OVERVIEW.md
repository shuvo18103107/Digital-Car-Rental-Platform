# Faisal Car Rentals Perth — Digital Agreement Portal
## Application Overview for Client

---

## What This Application Does

This is a **digital car rental agreement system** built specifically for Faisal Car Rentals Perth. It completely replaces paper-based agreements with a secure, professional online system.

**The problem it solves:**
- No more printing, scanning, or physically handing over documents
- Drivers can sign from their phone anywhere, anytime
- All agreements are stored safely and searchable from one admin panel
- Signed PDFs are automatically emailed to everyone the moment you approve

---

## How It Works — The Full Journey

### Step 1 — Driver Opens the Website
The driver visits the rental website on their phone, tablet, or computer. No account or login is needed — the form is fully public.

They see:
- The full rental agreement terms to read (scrollable)
- A form to fill in their details and the vehicle details

---

### Step 2 — Driver Fills the Form

The form captures:

**Vehicle & Agreement Details**
- Car Make & Model (e.g. Toyota Camry)
- Plate Number
- Weekly Rent amount
- Pickup Date and Time

**Driver / Renter Information**
- Full Name
- Residential Address
- WA Driver's License Number
- Contact Phone Number
- Email Address

**Optional Sections**
- Approved Mechanic / Towing Company Name and Phone
- Vehicle Walkaround comments (any pre-existing damage notes)

---

### Step 3 — Driver Signs Digitally
At the bottom of the form, the driver signs using their finger (on phone) or mouse (on computer). The signature is drawn directly on screen — no app, no PDF printer needed.

There is a **Clear** button to redo the signature. The form cannot be submitted without a signature.

---

### Step 4 — Submission & Duplicate Check
When the driver clicks Submit, the system automatically:

- Checks if this license number already has an active or pending agreement
  - If yes → blocks submission and shows a message ("Your agreement is under review" or "You have an active agreement — contact the owner")
  - If no → allows submission
- Saves the agreement with status: **Pending**
- Shows the driver a confirmation page with their Agreement Reference Number
- The driver is told: *"Once approved, a signed PDF will be sent to your email"*

> The driver does not receive any email at this stage. Nothing is sent until you manually approve.

---

### Step 5 — You Review in the Admin Panel

You (the admin) log in to the admin panel at `/admin`. You see a list of all agreements with colour-coded status badges:

| Badge colour | Meaning |
|---|---|
| **Orange (Pending)** | New submission — needs your review |
| **Green (Approved)** | Reviewed and approved, PDF sent |
| **Red (Rejected)** | Rejected, driver notified |

Pending records are highlighted in amber so they stand out immediately.

You can search by driver name, license number, or plate number. You can filter by status or date.

---

### Step 6 — You Take Action

You open any pending agreement and choose one of three actions:

#### Option A — Approve
> Use when everything looks correct.

You click **"Approve & Send"**. The system immediately:
1. Generates a professional signed PDF with the agreement terms + driver details + their signature
2. Emails the signed PDF to:
   - **You (owner)** — your copy
   - **Admin email** — office copy
   - **Driver** — their personal copy
3. Records the approval date, time, and your name

The agreement is now active. The driver will receive their signed PDF in their inbox within seconds.

#### Option B — Edit, Then Approve
> Use when the driver made a small mistake (wrong plate number, wrong rent amount, etc.) that you can fix.

You click **"Edit Details"**, fix the wrong field, save, then click **"Approve & Send"**. The PDF is generated from your corrected data.

#### Option C — Reject with a Reason
> Use when the driver needs to fix something themselves (e.g. wrong license number — a legal detail you should not change for them).

You click **"Reject"**, type a reason (e.g. *"Your license number appears incorrect. Please resubmit with the correct number."*), and confirm.

The system sends the driver an email with your rejection reason. They can then resubmit a new form straight away.

---

### Step 7 — Driver Receives Their Signed PDF

If approved, the driver gets an email with:
- A personalised message confirming their rental agreement
- The fully signed PDF attached — ready to save or print

The PDF contains:
- The full agreement terms they agreed to
- Their filled details (vehicle, dates, contact info)
- Their digital signature
- The approval date and unique Agreement ID
- Owner details (Faisal Rasheed, 58 Royal Street, Tuart Hill Perth WA)

---

## Admin Panel — Full Feature List

### Agreement List
- See all agreements in one table
- Amber row highlighting for pending (action needed) records
- Status badges — Pending / Approved / Rejected
- Email sent indicator (tick icon)
- Sort by submission date (newest first)
- Search: driver name, license number, plate number
- Filter by status and date range

### Agreement Detail View
- All submitted fields displayed cleanly
- Signature image shown inline
- **Plate conflict warning** — if a pending record's plate number already has an active approved agreement, a warning banner appears automatically so you can investigate before approving
- Action buttons shown based on current status (see below)

### Actions Available Per Status

| Status | Available Actions |
|---|---|
| Pending | Edit Details · Approve & Send · Reject |
| Approved | Download PDF · Resend Emails · Reset License Lock |
| Rejected | Reset License Lock |

### Download PDF
Download any approved agreement's PDF directly to your computer from the admin panel. Files are stored securely — never publicly accessible online.

### Resend Emails
If an email was lost or the driver can't find it, resend the signed PDF to all three recipients (owner, admin, driver) with one click.

### Reset License Lock
When a driver with an active approved agreement needs to sign a **new** agreement (new vehicle, new rental period, updated details), you click **Reset License Lock** on their old record. This:
- Keeps the old agreement in the system as permanent history
- Unlocks the driver's license number so they can submit a fresh form
- The new submission goes through the normal pending → approval flow

### CSV Export
Export all agreement records to a spreadsheet file — useful for accounting, record-keeping, or sharing with your accountant. Exports all fields except raw signature images.

---

## Agreement Terms Editor

In the admin panel, go to **"Agreement Terms"** in the sidebar.

Here you can update the legal clauses and terms that drivers read before signing — things like cleaning fees, towing procedures, insurance excess details, termination rules, etc.

**Important rule:** Changes only apply to **future submissions**. Any agreement already signed is permanently locked to the exact wording the driver read at the time of signing. This protects you legally.

The editor supports:
- Bold, italic, underline text
- Bullet lists and numbered lists
- Headings
- Undo/redo

> Note: The owner details block (Faisal Rasheed, 58 Royal Street, insurance details) is hardcoded in the PDF template and cannot be changed from the editor — these are structural and legally stable.

---

## Anti-Fraud & Security Features

### License Number Block
No driver can submit twice with the same license number if they already have a pending or active agreement. They see a clear message explaining why. Once rejected or reset, they can resubmit freely.

### IP Rate Limiting
Maximum 3 submissions from any one IP address per 24 hours. Prevents mass form abuse.

### Admin Approval Gate
**Nothing happens until you manually approve.** No PDF is ever generated, no email is ever sent, for any unapproved submission. You have full control.

### Plate Conflict Warning
If two drivers try to use the same plate number, you are warned automatically when viewing the pending record — before you approve.

### Secure File Storage
All PDFs and signature images are stored in a private server folder — they are **never accessible via a public URL**. Only you can access them through the admin panel.

### Audit Trail
Every record stores: submission date/time, IP address, who approved/rejected, when, and the exact agreement text the driver agreed to. Nothing is ever deleted.

---

## Email Summary

| When | Who gets email | What it contains |
|---|---|---|
| Admin approves | Owner (Faisal) | Signed PDF attached |
| Admin approves | Admin email | Signed PDF attached |
| Admin approves | Driver | Signed PDF + confirmation message |
| Admin rejects | Driver only | Your rejection reason, invitation to resubmit |
| Driver submits | Nobody | No email sent until approval |

All emails are sent from your Gmail account via secure SMTP.

---

## What the Driver Experiences

1. Opens website on phone — clean, professional, mobile-friendly
2. Reads the terms (scrollable box)
3. Fills in details — simple fields, no jargon
4. Signs with finger on the signature pad
5. Submits — sees confirmation page with reference number
6. Receives signed PDF by email once you approve
7. Has a permanent copy of their signed agreement in their inbox

No account needed. No app to install. Works on any phone or browser.

---

## What You (Admin) Can Do

| Task | How |
|---|---|
| See new submissions | Log in to `/admin` — pending shown in amber |
| Fix a driver's typo before approving | Edit Details → change field → Approve |
| Approve and send PDF + emails | Click "Approve & Send" |
| Reject with a reason | Click "Reject" → type reason |
| Let a driver sign a new agreement | Reset License Lock on their old record |
| Download a specific PDF | Open approved record → Download PDF |
| Resend lost emails | Open approved record → Resend Emails |
| Export records to spreadsheet | List page → Export CSV |
| Update legal terms | Admin sidebar → Agreement Terms |

---

## What Cannot Be Changed After Approval

Once an agreement is approved:
- The PDF has been generated and emailed
- That is the **legally binding moment**
- There is no "undo approve" — by design

If data was wrong and slipped through, the correct process is:
1. Reject the record (add an internal note)
2. Reset the license lock
3. Ask the driver to resubmit with correct information
4. The old record stays as evidence — nothing is deleted

---

## Deployment

The application runs on **Hostinger shared hosting** on your existing domain. No monthly subscription software fees — it is self-hosted on infrastructure you already pay for.

---

*Built with Laravel 13, Filament v4, Tailwind CSS, and DomPDF.*
*Designed for Faisal Car Rentals Perth — April 2026.*
