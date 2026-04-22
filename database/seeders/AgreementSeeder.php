<?php

namespace Database\Seeders;

use App\Models\Agreement;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class AgreementSeeder extends Seeder
{
    public function run(): void
    {
        $snapshot = Setting::where('key', 'agreement_body')->value('value');

        // Record 1: PENDING — normal approval flow
        Agreement::create([
            'agreement_number' => 'AGR-2026-0001',
            'car_make_model' => 'Toyota Camry',
            'plate_number' => '1ABC 234',
            'weekly_rent' => 350.00,
            'pickup_date' => '2026-04-17',
            'pickup_time' => '09:00:00',
            'driver_name' => 'Omar Hassan',
            'renter_address' => '12 Park Street, Perth WA 6000',
            'license_number' => 'WA-4821033',
            'renter_contact' => '0412 345 678',
            'driver_email' => 'omar.hassan@testmail.com',
            'signature_path' => 'signatures/test-sig-1.png',
            'agreement_snapshot' => $snapshot,
            'status' => 'pending',
            'ip_address' => '101.182.10.55',
            'submitted_at' => now()->subHours(2),
        ]);

        // Record 2: APPROVED — active agreement, test reset flow
        Agreement::create([
            'agreement_number' => 'AGR-2026-0002',
            'car_make_model' => 'Honda CR-V',
            'plate_number' => '2XYZ 567',
            'weekly_rent' => 420.00,
            'pickup_date' => '2026-04-10',
            'pickup_time' => '14:00:00',
            'driver_name' => 'Karim Diallo',
            'renter_address' => '45 Stirling Highway, Nedlands WA 6009',
            'license_number' => 'WA-3310821',
            'renter_contact' => '0423 111 222',
            'driver_email' => 'karim.diallo@testmail.com',
            'signature_path' => 'signatures/test-sig-2.png',
            'agreement_snapshot' => $snapshot,
            'status' => 'approved',
            'approved_at' => now()->subDays(7),
            'approved_by' => 'admin@carrentalperth.com',
            'pdf_path' => 'agreements/2026/04/AGR-2026-0002.pdf',
            'email_sent' => true,
            'email_sent_at' => now()->subDays(7),
            'ip_address' => '101.182.22.11',
            'submitted_at' => now()->subDays(7),
        ]);

        // Record 3: REJECTED — Sara can resubmit freely
        Agreement::create([
            'agreement_number' => 'AGR-2026-0003',
            'car_make_model' => 'Hyundai Tucson',
            'plate_number' => '3DEF 890',
            'weekly_rent' => 380.00,
            'pickup_date' => '2026-04-15',
            'pickup_time' => '10:00:00',
            'driver_name' => 'Sara Malik',
            'renter_address' => '88 Beaufort Street, Inglewood WA 6052',
            'license_number' => 'WA-7791234',
            'renter_contact' => '0455 999 111',
            'driver_email' => 'sara.malik@testmail.com',
            'signature_path' => 'signatures/test-sig-3.png',
            'agreement_snapshot' => $snapshot,
            'status' => 'rejected',
            'rejection_note' => 'License number appears incorrect. Please resubmit with your correct WA license number.',
            'rejected_at' => now()->subDays(2),
            'rejected_by' => 'admin@carrentalperth.com',
            'ip_address' => '101.182.33.44',
            'submitted_at' => now()->subDays(3),
        ]);

        // Record 4: APPROVED + IS_RESET — James can resubmit for new period
        Agreement::create([
            'agreement_number' => 'AGR-2026-0004',
            'car_make_model' => 'Mazda CX-5',
            'plate_number' => '4GHI 123',
            'weekly_rent' => 400.00,
            'pickup_date' => '2026-01-05',
            'pickup_time' => '08:00:00',
            'driver_name' => 'James Whitfield',
            'renter_address' => '22 Karrinyup Road, Karrinyup WA 6018',
            'license_number' => 'WA-5541009',
            'renter_contact' => '0411 888 777',
            'driver_email' => 'james.whitfield@testmail.com',
            'signature_path' => 'signatures/test-sig-4.png',
            'agreement_snapshot' => $snapshot,
            'status' => 'approved',
            'approved_at' => now()->subMonths(3),
            'approved_by' => 'admin@carrentalperth.com',
            'pdf_path' => 'agreements/2026/01/AGR-2026-0004.pdf',
            'email_sent' => true,
            'email_sent_at' => now()->subMonths(3),
            'is_reset' => true,
            'reset_at' => now()->subDays(1),
            'reset_by' => 'admin@carrentalperth.com',
            'ip_address' => '101.182.44.55',
            'submitted_at' => now()->subMonths(3),
        ]);

        // Record 5: PENDING, same plate as Record 1 — triggers plate conflict warning
        Agreement::create([
            'agreement_number' => 'AGR-2026-0005',
            'car_make_model' => 'Toyota Camry',
            'plate_number' => '1ABC 234',
            'weekly_rent' => 350.00,
            'pickup_date' => '2026-04-17',
            'pickup_time' => '11:00:00',
            'driver_name' => 'Tariq Hussain',
            'renter_address' => '5 William Street, Perth WA 6000',
            'license_number' => 'WA-8812345',
            'renter_contact' => '0477 666 555',
            'driver_email' => 'tariq.hussain@testmail.com',
            'signature_path' => 'signatures/test-sig-5.png',
            'agreement_snapshot' => $snapshot,
            'status' => 'pending',
            'ip_address' => '101.182.55.66',
            'submitted_at' => now()->subHours(1),
        ]);

    }
}
