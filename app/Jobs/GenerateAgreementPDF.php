<?php

namespace App\Jobs;

use App\Models\Agreement;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\File;
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

        $fullPath = Storage::disk('local')->path($path);

        File::ensureDirectoryExists(dirname($fullPath));

        $signatureBase64 = $this->encodeSignature($agreement->signature_path);

        $pdf = Pdf::loadView('pdf.agreement', compact('agreement', 'signatureBase64'))
            ->setPaper('a4', 'portrait');

        $pdf->save($fullPath);

        $agreement->update(['pdf_path' => $path]);

        SendAgreementEmails::dispatch($agreement);
    }

    private function encodeSignature(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        $fullPath = Storage::disk('local')->path($path);

        if (! file_exists($fullPath)) {
            return null;
        }

        return 'data:image/png;base64,'.base64_encode(file_get_contents($fullPath));
    }
}
