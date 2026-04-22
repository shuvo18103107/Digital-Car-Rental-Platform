<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agreement extends Model
{
    protected $fillable = [
        'agreement_number',
        'car_make_model',
        'plate_number',
        'bond_amount',
        'weekly_rent',
        'pickup_date',
        'pickup_time',
        'driver_name',
        'renter_address',
        'license_number',
        'renter_contact',
        'driver_email',
        'towing_name',
        'towing_phone',
        'walkaround_comments',
        'signature_path',
        'pdf_path',
        'agreement_snapshot',
        'status',
        'rejection_note',
        'approved_at',
        'rejected_at',
        'approved_by',
        'rejected_by',
        'email_sent',
        'email_sent_at',
        'is_reset',
        'reset_at',
        'reset_by',
        'ip_address',
        'user_agent',
        'submitted_at',
    ];

    protected $casts = [
        'pickup_date' => 'date',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'email_sent_at' => 'datetime',
        'reset_at' => 'datetime',
        'submitted_at' => 'datetime',
        'email_sent' => 'boolean',
        'is_reset' => 'boolean',
        'bond_amount' => 'decimal:2',
        'weekly_rent' => 'decimal:2',
    ];

    public function documents(): HasMany
    {
        return $this->hasMany(AgreementDocument::class);
    }
}
