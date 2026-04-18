<?php

namespace App\Jobs;

use App\Mail\AgreementRejected;
use App\Models\Agreement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendRejectionEmail implements ShouldQueue
{
    use Queueable;

    public function __construct(public Agreement $agreement) {}

    public function handle(): void
    {
        Mail::to($this->agreement->driver_email)->send(new AgreementRejected($this->agreement));
    }
}
