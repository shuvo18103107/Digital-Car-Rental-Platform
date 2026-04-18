<?php

use App\Http\Controllers\AgreementController;
use App\Models\Agreement;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', [AgreementController::class, 'show'])->name('agreement.form');

Route::post('/submit', [AgreementController::class, 'store'])
    ->middleware('throttle:3,1440')
    ->name('agreement.store');

Route::get('/admin/signature/{agreement}', function (Agreement $agreement) {
    $path = Storage::disk('local')->path($agreement->signature_path);

    if (file_exists($path) && filesize($path) > 0) {
        return response()->file($path);
    }

    $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="120" height="48" viewBox="0 0 120 48">'
        . '<rect width="120" height="48" rx="6" fill="#f3f4f6"/>'
        . '<text x="60" y="20" text-anchor="middle" fill="#9ca3af" font-family="sans-serif" font-size="10" font-weight="500">No signature</text>'
        . '<text x="60" y="34" text-anchor="middle" fill="#d1d5db" font-family="sans-serif" font-size="9">pending upload</text>'
        . '</svg>';

    return response($svg, 200, ['Content-Type' => 'image/svg+xml']);
})->middleware(['auth'])->name('admin.signature');

Route::get('/success', fn () => view('agreement.success', [
    'agreementNumber' => session('agreement_number'),
]))->name('agreement.success');
