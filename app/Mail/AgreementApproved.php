<?php

namespace App\Mail;

use App\Models\Agreement;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class AgreementApproved extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Agreement $agreement,
        public string $recipientType,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Car Rental Agreement — '.$this->agreement->agreement_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.agreement-approved',
        );
    }

    /** @return array<int, Attachment> */
    public function attachments(): array
    {
        return [
            Attachment::fromPath(Storage::disk('local')->path($this->agreement->pdf_path))
                ->as($this->agreement->agreement_number.'.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
