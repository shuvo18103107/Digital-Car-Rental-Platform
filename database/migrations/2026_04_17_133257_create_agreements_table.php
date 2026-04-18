<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
            $table->string('agreement_number', 20)->unique();

            // Section 1: Vehicle & Agreement Details
            $table->string('car_make_model', 100);
            $table->string('plate_number', 30);
            $table->decimal('bond_amount', 10, 2)->default(500.00);
            $table->decimal('weekly_rent', 10, 2);
            $table->date('pickup_date');
            $table->time('pickup_time');

            // Section 2: Driver / Renter Information
            $table->string('driver_name', 100);
            $table->text('renter_address');
            $table->string('license_number', 50);
            $table->string('renter_contact', 20);
            $table->string('driver_email', 150);

            // Section 9: Towing / Breakdown (optional)
            $table->string('towing_name', 100)->nullable();
            $table->string('towing_phone', 20)->nullable();

            // Section 16: Vehicle Walkaround (optional)
            $table->text('walkaround_comments')->nullable();

            // Signature & generated files
            $table->string('signature_path', 255);
            $table->string('pdf_path', 255)->nullable();
            $table->longText('agreement_snapshot');

            // Status lifecycle
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_note')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->string('approved_by', 100)->nullable();
            $table->string('rejected_by', 100)->nullable();

            // Email tracking
            $table->boolean('email_sent')->default(false);
            $table->timestamp('email_sent_at')->nullable();

            // Admin reset
            $table->boolean('is_reset')->default(false);
            $table->timestamp('reset_at')->nullable();
            $table->string('reset_by', 100)->nullable();

            // Audit / anti-fraud
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('submitted_at')->useCurrent();

            $table->timestamps();

            $table->index('license_number', 'idx_license');
            $table->index('status', 'idx_status');
            $table->index('plate_number', 'idx_plate');
            $table->index('submitted_at', 'idx_submitted');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agreements');
    }
};
