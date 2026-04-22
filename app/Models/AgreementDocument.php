<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgreementDocument extends Model
{
    protected $fillable = [
        'agreement_id', 'document_type', 'file_path',
        'original_name', 'mime_type', 'file_size',
    ];

    public function agreement(): BelongsTo
    {
        return $this->belongsTo(Agreement::class);
    }

    public function getFileSizeFormattedAttribute(): string
    {
        $kb = $this->file_size / 1024;

        return $kb > 1024
            ? round($kb / 1024, 1).' MB'
            : round($kb).' KB';
    }

    public function getDocumentTypeLabelAttribute(): string
    {
        return match ($this->document_type) {
            'passport' => 'Passport (bio page)',
            'licence_front' => 'Driving licence (front)',
            'licence_back' => 'Driving licence (back)',
            'visa' => 'Visa',
            default => $this->document_type,
        };
    }
}
