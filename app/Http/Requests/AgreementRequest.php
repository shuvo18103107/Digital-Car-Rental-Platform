<?php

namespace App\Http\Requests;

use App\Models\Agreement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class AgreementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'car_make_model' => ['required', 'string', 'max:100'],
            'plate_number' => ['required', 'string', 'max:30'],
            'weekly_rent' => ['required', 'numeric', 'min:1', 'max:99999.99'],
            'pickup_date' => ['required', 'date'],
            'pickup_time' => ['required', 'date_format:H:i'],
            'driver_name' => ['required', 'string', 'max:100'],
            'renter_address' => ['required', 'string', 'max:500'],
            'license_number' => ['required', 'string', 'max:50'],
            'renter_contact' => ['required', 'string', 'max:20'],
            'driver_email' => ['required', 'email', 'max:150'],
            'signature' => ['required', 'string'],
            'passport' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'licence_front' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'licence_back' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'visa' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'signature.required' => 'Please sign the agreement before submitting.',
            'pickup_time.date_format' => 'Please select a valid pickup time.',
        ];
    }

    protected function passedValidation(): void
    {
        $blocked = Agreement::where('license_number', $this->license_number)
            ->where('is_reset', false)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if (! $blocked) {
            return;
        }

        $existing = Agreement::where('license_number', $this->license_number)
            ->where('is_reset', false)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existing->status === 'pending') {
            throw ValidationException::withMessages([
                'license_number' => 'Your agreement is currently under review. Please wait for admin approval.',
            ]);
        }

        throw ValidationException::withMessages([
            'license_number' => 'You already have an active rental agreement. Please contact the owner to make changes.',
        ]);
    }
}
