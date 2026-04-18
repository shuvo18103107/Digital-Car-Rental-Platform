<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgreementRequest;
use App\Models\Agreement;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AgreementController extends Controller
{
    public function show(): View
    {
        $agreementBody = Setting::get('agreement_body');

        return view('agreement.form', compact('agreementBody'));
    }

    public function store(AgreementRequest $request): RedirectResponse
    {

        $nextId = (Agreement::max('id') ?? 0) + 1;
        $agreementNumber = 'AGR-' . date('Y') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $signatureData = $request->input('signature');
        $signatureData = preg_replace('/^data:image\/png;base64,/', '', $signatureData);
        $signatureData = base64_decode($signatureData);
        $signaturePath = 'signatures/' . str()->uuid() . '.png';
        Storage::put($signaturePath, $signatureData);

        $snapshot = Setting::get('agreement_body');

        $agreement = Agreement::create([
            'agreement_number'    => $agreementNumber,
            'car_make_model'      => $request->car_make_model,
            'plate_number'        => $request->plate_number,
            'weekly_rent'         => $request->weekly_rent,
            'pickup_date'         => $request->pickup_date,
            'pickup_time'         => $request->pickup_time,
            'driver_name'         => $request->driver_name,
            'renter_address'      => $request->renter_address,
            'license_number'      => $request->license_number,
            'renter_contact'      => $request->renter_contact,
            'driver_email'        => $request->driver_email,
            'towing_name'         => $request->towing_name,
            'towing_phone'        => $request->towing_phone,
            'walkaround_comments' => $request->walkaround_comments,
            'signature_path'      => $signaturePath,
            'agreement_snapshot'  => $snapshot,
            'status'              => 'pending',
            'ip_address'          => $request->ip(),
            'user_agent'          => $request->userAgent(),
            'submitted_at'        => now(),
        ]);

        return redirect()->route('agreement.success')
            ->with('agreement_number', $agreement->agreement_number);
    }
}
