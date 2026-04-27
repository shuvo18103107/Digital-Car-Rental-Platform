<?php

namespace App\Jobs;

use App\Models\Agreement;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class GenerateAgreementPDF implements ShouldQueue
{
    use Queueable;

    public function __construct(public Agreement $agreement) {}

    public function handle(): void
    {
        $agreement = $this->agreement;

        $path = 'agreements/'
            .date('Y').'/'
            .date('m').'/'
            .$agreement->agreement_number.'.pdf';

        $signatureBase64 = $this->encodeSignature($agreement->signature_path);

        $ownerSignaturePath = Setting::get(
            'owner_signature_path',
            'private/signatures/owner_signature.png'
        );
        $ownerSignatureBase64 = $this->encodeSignature($ownerSignaturePath);

        $settings = [
            'companyName' => Setting::get('company_name'),
            'companyAddress' => Setting::get('company_address'),
            'companyPhone' => Setting::get('company_phone'),
            'ownerName' => Setting::get('owner_name'),
        ];

        $pdfContent = Pdf::loadView('pdf.agreement', array_merge([
            'agreement' => $agreement,
            'signatureBase64' => $signatureBase64,
            'ownerSignatureBase64' => $ownerSignatureBase64,
        ], $settings))
            ->setPaper('a4', 'portrait')
            ->output();

        Storage::disk('s3')->put($path, $pdfContent);

        $agreement->update(['pdf_path' => $path]);

        SendAgreementEmails::dispatch($agreement);
    }

    private function encodeSignature(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (! Storage::disk('s3')->exists($path)) {
            return null;
        }

        return 'data:image/png;base64,'.base64_encode(Storage::disk('s3')->get($path));
    }
}
