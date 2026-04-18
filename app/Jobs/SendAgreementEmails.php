<?php

namespace App\Jobs;

use App\Mail\AgreementApproved;
use App\Models\Agreement;
use App\Models\Setting;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendAgreementEmails implements ShouldQueue
{
    use Queueable;

    public function __construct(public Agreement $agreement) {}

    public function handle(): void
    {
        $ownerEmail = Setting::get('owner_email');
        $adminEmail = Setting::get('admin_email');

        Mail::to($ownerEmail)->send(new AgreementApproved($this->agreement, 'owner'));
        Mail::to($adminEmail)->send(new AgreementApproved($this->agreement, 'admin'));
        Mail::to($this->agreement->driver_email)->send(new AgreementApproved($this->agreement, 'driver'));

        $this->agreement->update([
            'email_sent' => true,
            'email_sent_at' => now(),
        ]);
    }
}
