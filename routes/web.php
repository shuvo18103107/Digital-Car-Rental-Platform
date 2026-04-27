<?php

use App\Http\Controllers\AgreementController;
use App\Models\Agreement;
use App\Models\AgreementDocument;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', [AgreementController::class, 'show'])->name('agreement.form');

Route::post('/submit', [AgreementController::class, 'store'])
    ->middleware('throttle:20,1440')
    ->name('agreement.store');

Route::get('/admin/signature/{agreement}', function (Agreement $agreement) {
    if (Storage::disk('s3')->exists($agreement->signature_path)) {
        return response(Storage::disk('s3')->get($agreement->signature_path), 200, [
            'Content-Type' => 'image/png',
            'Cache-Control' => 'private, max-age=300',
        ]);
    }

    $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="120" height="48" viewBox="0 0 120 48">'
        .'<rect width="120" height="48" rx="6" fill="#f3f4f6"/>'
        .'<text x="60" y="20" text-anchor="middle" fill="#9ca3af" font-family="sans-serif" font-size="10" font-weight="500">No signature</text>'
        .'<text x="60" y="34" text-anchor="middle" fill="#d1d5db" font-family="sans-serif" font-size="9">pending upload</text>'
        .'</svg>';

    return response($svg, 200, ['Content-Type' => 'image/svg+xml']);
})->middleware(['auth'])->name('admin.signature');

Route::get('/admin/agreements/{agreement}/download-pdf', function (Agreement $agreement) {
    abort_unless(auth()->guard('web')->check(), 403);
    abort_if(! $agreement->pdf_path || $agreement->status !== 'approved', 404);

    $content = Storage::disk('s3')->get($agreement->pdf_path);

    return response()->streamDownload(function () use ($content) {
        echo $content;
    }, $agreement->agreement_number.'.pdf', ['Content-Type' => 'application/pdf']);
})->middleware('auth')->name('admin.agreements.download-pdf');

Route::get('/admin/documents/{document}/download', function (AgreementDocument $document) {
    abort_unless(auth()->guard('web')->check(), 403);

    $filename = $document->document_type_label.'.'.pathinfo($document->file_path, PATHINFO_EXTENSION);
    $content = Storage::disk('s3')->get($document->file_path);

    return response($content)
        ->withHeaders([
            'Content-Type' => $document->mime_type ?? 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
})->middleware('auth')->name('admin.documents.download');

Route::get('/success', fn () => view('agreement.success', [
    'agreementNumber' => session('agreement_number'),
]))->name('agreement.success');
