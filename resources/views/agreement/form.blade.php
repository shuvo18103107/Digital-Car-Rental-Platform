@extends('layouts.public')

@section('title', 'Rental Agreement')

@section('content')
<div x-data="{
    termsOpen: false,
    signaturePad: null,
    signatureData: '',
    hasSigned: false,
    submitting: false,
    showErrorModal: false,
    errors: [],

    init() {
        document.addEventListener('keydown', e => { if (e.key === 'Escape') this.showErrorModal = false; });
        this.$watch('termsOpen', v => { document.body.style.overflow = v ? 'hidden' : ''; });

        const canvas = this.$refs.signatureCanvas;
        this.signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgb(255,255,255)',
            penColor: '#1e3a5f',
            minWidth: 1.5,
            maxWidth: 3,
        });
        this.resizeCanvas();
        window.addEventListener('resize', () => this.resizeCanvas());

        canvas.addEventListener('pointerdown', () => { this.hasSigned = true; });
    },

    resizeCanvas() {
        const canvas = this.$refs.signatureCanvas;
        const ratio  = Math.max(window.devicePixelRatio || 1, 1);
        const data   = this.signaturePad.toData();
        canvas.width  = canvas.offsetWidth  * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext('2d').scale(ratio, ratio);
        this.signaturePad.fromData(data);
    },

    clearSignature() {
        this.signaturePad.clear();
        this.signatureData = '';
        this.hasSigned = false;
    },

    submit(event) {
        const f = this.$refs.agreementForm;
        const v = (id) => (f.querySelector('#' + id)?.value ?? '').trim();

        const padEmpty = !this.signaturePad || this.signaturePad.isEmpty();

        const missing = [];
        if (!v('car_make_model')) missing.push('Car Make & Model');
        if (!v('plate_number'))   missing.push('Plate Number');
        if (!v('weekly_rent'))    missing.push('Weekly Rent');
        if (!v('pickup_date'))    missing.push('Pickup Date');
        if (!v('pickup_time'))    missing.push('Pickup Time');
        if (!v('driver_name'))    missing.push('Full Name');
        if (!v('renter_address')) missing.push('Residential Address');
        if (!v('license_number')) missing.push('Driver\'s Licence Number');
        if (!v('renter_contact')) missing.push('Contact Number');
        if (!v('driver_email'))   missing.push('Email Address');
        if (padEmpty)             missing.push('Signature — please sign in the box above');

        if (missing.length > 0) {
            event.preventDefault();
            this.errors = missing;
            this.showErrorModal = true;
            return;
        }

        this.signatureData = this.signaturePad.toDataURL('image/png');
        this.submitting = true;
    }
}">

    {{-- Page title --}}
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-slate-800 sm:text-3xl">Car Rental Agreement</h2>
        <p class="mt-2 text-sm text-slate-500">Complete all required fields and sign to submit your application.</p>
    </div>

    {{-- Two-column grid: right col first in DOM → shows above form on mobile --}}
    <div class="lg:grid lg:grid-cols-[1fr_280px] lg:items-start lg:gap-8">

        {{-- ══════════════════════════════════════════
             RIGHT PANEL  (first in DOM)
             Mobile: stacks above form
             Desktop: sticky sidebar on right
        ══════════════════════════════════════════ --}}
        <div class="order-1 mb-6 space-y-4 lg:order-2 lg:sticky lg:top-6 lg:mb-0">

            {{-- Agreement document preview card --}}
            <div @click="termsOpen = true"
                 class="group cursor-pointer overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-md">

                {{-- Document letterhead --}}
                <div class="border-b border-slate-100 bg-gradient-to-br from-slate-50 to-blue-50/40 px-5 py-4">
                    <div class="mb-2 flex items-center gap-2">
                        <svg class="h-4 w-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Car Rental Agreement</span>
                    </div>
                    <p class="text-sm font-bold text-slate-800">Faisal Car Rentals Perth</p>
                    <p class="text-xs text-slate-500">58 Royal Street, Tuart Hill, Perth WA</p>
                    <p class="text-xs text-slate-400">0424 022 786</p>
                </div>

                {{-- Faded text preview --}}
                <div class="relative px-5 pb-0 pt-4">
                    <div class="relative overflow-hidden" style="max-height:170px">
                        <div class="pointer-events-none select-none text-[11px] leading-relaxed text-slate-400
                                    [&_h2]:mb-1 [&_h2]:text-xs [&_h2]:font-bold [&_h2]:text-slate-500
                                    [&_h3]:mb-0.5 [&_h3]:mt-2 [&_h3]:text-[9px] [&_h3]:font-bold [&_h3]:uppercase [&_h3]:tracking-wider [&_h3]:text-slate-400
                                    [&_p]:mb-1
                                    [&_ul]:mb-1 [&_ul]:list-none [&_ul]:pl-0
                                    [&_ol]:mb-1 [&_ol]:list-none [&_ol]:pl-0
                                    [&_strong]:font-semibold">
                            {!! $agreementBody !!}
                        </div>
                        <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-white to-transparent"></div>
                    </div>
                </div>

                {{-- CTA footer --}}
                <div class="flex items-center justify-between px-5 py-3.5">
                    <span class="text-sm font-semibold text-blue-600 transition group-hover:text-blue-700">Read full agreement</span>
                    <div class="flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 transition group-hover:bg-blue-100">
                        <svg class="h-4 w-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════
             LEFT COLUMN  (form)
        ══════════════════════════════════════════ --}}
        <div class="order-2 space-y-6 lg:order-1">

            @if ($errors->any())
                <div class="flex gap-3 rounded-xl border border-red-200 bg-red-50 p-4">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="font-semibold text-red-700">Please fix the following:</p>
                        <ul class="mt-1 list-disc pl-4 text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form id="agreement-form"
                  x-ref="agreementForm"
                  action="{{ route('agreement.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  @submit="submit($event)"
                  class="space-y-6"
                  novalidate>
                @csrf
                <input type="hidden" name="signature" x-model="signatureData">

                {{-- Section 1 --}}
                <div class="section-card">
                    <div class="section-header">
                        <span class="section-number">1</span>
                        <h3 class="section-title">Vehicle & Agreement Details</h3>
                    </div>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label class="form-label" for="car_make_model">Car Make & Model <span class="input-required">*</span></label>
                            <input id="car_make_model" type="text" name="car_make_model"
                                value="{{ old('car_make_model') }}"
                                placeholder="e.g. Toyota Camry"
                                class="form-input @error('car_make_model') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror">
                            @error('car_make_model')
                                <p class="form-error"><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="form-label" for="plate_number">Plate Number <span class="input-required">*</span></label>
                            <input id="plate_number" type="text" name="plate_number"
                                value="{{ old('plate_number') }}"
                                placeholder="e.g. 1ABC 234"
                                class="form-input @error('plate_number') border-red-400 @enderror">
                            @error('plate_number')
                                <p class="form-error"><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="form-label" for="weekly_rent">Weekly Rent (AUD) <span class="input-required">*</span></label>
                            <div class="flex overflow-hidden rounded-xl border border-slate-200 shadow-sm transition duration-150
                                        focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500/20
                                        @error('weekly_rent') border-red-400 focus-within:border-red-500 focus-within:ring-red-500/20 @enderror">
                                <span class="flex items-center border-r border-slate-200 bg-slate-50 px-3.5 text-sm font-semibold text-slate-500">$</span>
                                <input id="weekly_rent" type="number" name="weekly_rent" min="1" step="0.01"
                                    value="{{ old('weekly_rent') }}"
                                    placeholder="0.00"
                                    class="w-full bg-white px-4 py-3 text-slate-800 placeholder-slate-400 outline-none">
                            </div>
                            @error('weekly_rent')
                                <p class="form-error"><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="form-label" for="pickup_date">Pickup Date <span class="input-required">*</span></label>
                            <input id="pickup_date" type="date" name="pickup_date"
                                value="{{ old('pickup_date') }}"
                                class="form-input @error('pickup_date') border-red-400 @enderror">
                            @error('pickup_date')
                                <p class="form-error"><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="form-label" for="pickup_time">Pickup Time <span class="input-required">*</span></label>
                            <input id="pickup_time" type="time" name="pickup_time"
                                value="{{ old('pickup_time') }}"
                                class="form-input @error('pickup_time') border-red-400 @enderror">
                            @error('pickup_time')
                                <p class="form-error"><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label class="form-label">Bond Amount</label>
                            <div class="flex items-center gap-3 rounded-xl border border-slate-100 bg-slate-50 px-4 py-3">
                                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <span class="font-semibold text-slate-700">AUD $500.00</span>
                                <span class="text-sm text-slate-400">(fixed — non-negotiable)</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 2 --}}
                <div class="section-card">
                    <div class="section-header">
                        <span class="section-number">2</span>
                        <h3 class="section-title">Driver / Renter Information</h3>
                    </div>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label class="form-label" for="driver_name">Full Name <span class="input-required">*</span></label>
                            <input id="driver_name" type="text" name="driver_name"
                                value="{{ old('driver_name') }}"
                                placeholder="Driver / Renter full name"
                                class="form-input @error('driver_name') border-red-400 @enderror">
                            @error('driver_name')
                                <p class="form-error"><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label class="form-label" for="renter_address">Residential Address <span class="input-required">*</span></label>
                            <textarea id="renter_address" name="renter_address" rows="2"
                                placeholder="Street address, suburb, state, postcode"
                                class="form-input resize-none @error('renter_address') border-red-400 @enderror">{{ old('renter_address') }}</textarea>
                            @error('renter_address')
                                <p class="form-error"><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="form-label" for="license_number">Driver's Licence Number <span class="input-required">*</span></label>
                            <input id="license_number" type="text" name="license_number"
                                value="{{ old('license_number') }}"
                                placeholder="e.g. WA-1234567"
                                class="form-input @error('license_number') border-red-400 @enderror">
                            @error('license_number')
                                <p class="form-error"><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="form-label" for="renter_contact">Contact Number <span class="input-required">*</span></label>
                            <input id="renter_contact" type="tel" name="renter_contact"
                                value="{{ old('renter_contact') }}"
                                placeholder="04XX XXX XXX"
                                class="form-input @error('renter_contact') border-red-400 @enderror">
                            @error('renter_contact')
                                <p class="form-error"><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label class="form-label" for="driver_email">Email Address <span class="input-required">*</span></label>
                            <input id="driver_email" type="email" name="driver_email"
                                value="{{ old('driver_email') }}"
                                placeholder="Your email — signed PDF will be sent here"
                                class="form-input @error('driver_email') border-red-400 @enderror">
                            @error('driver_email')
                                <p class="form-error"><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                            @enderror
                            <p class="mt-1.5 text-xs text-slate-400">Your signed agreement PDF will be emailed here once approved.</p>
                        </div>
                    </div>
                </div>

                {{-- Signature --}}
                <div class="section-card" x-ref="signatureSection">
                    <div class="section-header">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-100">
                            <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                        </div>
                        <h3 class="section-title">Signature <span class="input-required">*</span></h3>
                    </div>
                    <p class="mb-4 text-sm text-slate-500">By signing below you confirm you have read and agree to all terms in this agreement.</p>
                    <div class="relative rounded-xl border-2 border-slate-200 bg-slate-50 transition duration-150 hover:border-blue-300">
                        <canvas x-ref="signatureCanvas"
                            class="block h-40 w-full cursor-crosshair touch-none rounded-xl sm:h-48"></canvas>
                        <div class="pointer-events-none absolute inset-0 flex items-center justify-center"
                             x-show="!hasSigned">
                            <span class="select-none text-sm font-medium text-slate-300">Sign here with your finger or mouse</span>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        <p class="text-xs text-slate-400">Signed on: {{ now()->format('d M Y') }}</p>
                        <button type="button" @click="clearSignature()"
                            class="flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-1.5 text-sm text-slate-500 transition hover:border-red-300 hover:bg-red-50 hover:text-red-600">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Clear
                        </button>
                    </div>
                </div>

                {{-- Document Upload --}}
                <div class="section-card" x-data="{
                    docs: {
                        passport:      { file: null, preview: null, label: 'Passport bio page',       sub: 'Photo/data page',          required: true  },
                        licence_front: { file: null, preview: null, label: 'Licence front',            sub: 'Front side',               required: true  },
                        licence_back:  { file: null, preview: null, label: 'Licence back',             sub: 'Back side',                required: true  },
                        visa:          { file: null, preview: null, label: 'Visa page',                sub: 'If applicable — optional', required: false },
                    },
                    get uploadedCount() {
                        return Object.values(this.docs).filter(d => d.file !== null).length;
                    },
                    get requiredComplete() {
                        return ['passport','licence_front','licence_back'].every(k => this.docs[k].file !== null);
                    },
                    handleFile(type, event) {
                        const file = event.target.files[0];
                        if (!file) return;
                        if (file.size > 5 * 1024 * 1024) {
                            alert('File must be under 5MB. Please choose a smaller image.');
                            event.target.value = '';
                            return;
                        }
                        this.docs[type].file = file;
                        const reader = new FileReader();
                        reader.onload = (e) => { this.docs[type].preview = e.target.result; };
                        reader.readAsDataURL(file);
                    }
                }" x-init="$watch('requiredComplete', v => { $dispatch('docs-ready', { ready: v }) })">

                    <div class="section-header mb-4">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-100">
                            <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/>
                            </svg>
                        </div>
                        <h3 class="section-title">Identity verification</h3>
                    </div>

                    <p class="mb-3 text-sm text-slate-500">Upload clear photos of your documents. You can photograph them directly with your camera.</p>

                    <div class="mb-3 flex gap-2 rounded-xl border border-blue-100 bg-blue-50 p-3">
                        <svg width="16" height="16" viewBox="0 0 20 20" fill="#3B82F6" class="mt-0.5 shrink-0">
                            <path d="M10 2a8 8 0 1 0 0 16A8 8 0 0 0 10 2zm.75 11.5h-1.5v-5h1.5v5zm0-6.5h-1.5V5.5h1.5V7z"/>
                        </svg>
                        <span class="text-xs text-blue-700">Ensure all text is clearly readable and the full document is visible. Max 5MB per file (JPG, PNG or PDF).</span>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <template x-for="(doc, type) in docs" :key="type">
                            <div>
                                <input
                                    :id="'doc-' + type"
                                    :name="type"
                                    type="file"
                                    accept="image/*,application/pdf"
                                    class="hidden"
                                    @change="handleFile(type, $event)">

                                <label
                                    :for="'doc-' + type"
                                    class="relative flex min-h-[110px] cursor-pointer flex-col items-center justify-center gap-2 rounded-2xl p-4 text-center transition-all duration-200"
                                    :style="doc.file !== null
                                        ? 'border:2px solid #1D9E75;background:#F0FDF4;'
                                        : doc.required
                                            ? 'border:1.5px dashed #D1D5DB;background:#FFFFFF;'
                                            : 'border:1.5px dashed #E5E7EB;background:#F9FAFB;'">

                                    <span
                                        class="absolute right-2 top-2 rounded-md px-1.5 py-0.5 text-[9px] font-semibold"
                                        :style="doc.file !== null
                                            ? 'background:#DCFCE7;color:#15803D;'
                                            : doc.required
                                                ? 'background:#FEE2E2;color:#B91C1C;'
                                                : 'background:#F3F4F6;color:#6B7280;'"
                                        x-text="doc.file !== null ? 'Done' : (doc.required ? 'Required' : 'Optional')">
                                    </span>

                                    <template x-if="doc.preview">
                                        <img :src="doc.preview" class="h-8 w-12 rounded object-cover border border-slate-200">
                                    </template>
                                    <template x-if="!doc.preview">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-xl"
                                             :style="doc.required ? 'background:#EFF6FF;' : 'background:#F3F4F6;'">
                                            <svg width="18" height="18" viewBox="0 0 20 20"
                                                 :fill="doc.required ? '#3B82F6' : '#9CA3AF'">
                                                <path d="M3 5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5zm5 2a2 2 0 1 0 4 0 2 2 0 0 0-4 0zm-2 6c0-1.5 1.5-2.5 4-2.5s4 1 4 2.5v.5H6v-.5z"/>
                                            </svg>
                                        </div>
                                    </template>

                                    <span class="text-[11px] font-medium leading-tight"
                                          :style="doc.file !== null ? 'color:#15803D;' : 'color:#111827;'"
                                          x-text="doc.label">
                                    </span>
                                    <span class="text-[10px]"
                                          :style="doc.file !== null ? 'color:#22C55E;' : 'color:#9CA3AF;'"
                                          x-text="doc.file !== null ? 'Tap to change' : doc.sub">
                                    </span>
                                </label>
                            </div>
                        </template>
                    </div>

                    <p class="text-center text-xs text-slate-400"
                       x-text="uploadedCount + ' of 3 required documents uploaded'"></p>
                </div>

                {{-- Submit --}}
                <div class="section-card" x-data="{ docsReady: false }" @docs-ready.window="docsReady = $event.detail.ready">
                    <div class="flex items-start gap-3 mb-4 rounded-xl border border-blue-100 bg-blue-50 p-4">
                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-blue-700">
                            Your agreement will be reviewed by our team. Once approved, a signed PDF will be emailed to you.
                            <strong>No emails are sent until admin approval.</strong>
                        </p>
                    </div>

                    <button type="submit" :disabled="submitting || !docsReady"
                        class="flex w-full items-center justify-center gap-2 rounded-xl px-6 py-4 text-base font-semibold text-white shadow-lg transition active:scale-[0.98] disabled:cursor-not-allowed"
                        :class="(docsReady && !submitting) ? 'bg-blue-600 hover:bg-blue-700' : 'bg-slate-300 cursor-not-allowed'">
                        <template x-if="!submitting">
                            <span class="flex items-center gap-2">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Submit Agreement
                            </span>
                        </template>
                        <template x-if="submitting">
                            <span class="flex items-center gap-2">
                                <svg class="h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                                </svg>
                                Submitting…
                            </span>
                        </template>
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         ERROR MODAL
    ══════════════════════════════════════════ --}}
    <div x-show="showErrorModal" style="display:none"
         class="fixed inset-0 z-50 flex items-center justify-center p-4">

        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"
             @click="showErrorModal = false"></div>

        {{-- Panel --}}
        <div class="relative w-full max-w-md rounded-2xl bg-white shadow-2xl"
             @click.stop>

            {{-- Red top bar --}}
            <div class="flex items-center gap-4 rounded-t-2xl bg-red-50 px-6 py-5 border-b border-red-100">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-red-800">Missing required fields</h3>
                    <p class="text-sm text-red-600">Please complete everything before submitting.</p>
                </div>
            </div>

            {{-- Missing fields list --}}
            <div class="px-6 py-5">
                <ul class="space-y-2">
                    <template x-for="(item, i) in errors" :key="i">
                        <li class="flex items-center gap-3 rounded-lg bg-slate-50 px-4 py-2.5">
                            <svg class="h-4 w-4 shrink-0 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm font-medium text-slate-700" x-text="item"></span>
                        </li>
                    </template>
                </ul>
            </div>

            {{-- Close button --}}
            <div class="px-6 pb-6">
                <button @click="showErrorModal = false" type="button"
                    class="w-full rounded-xl bg-slate-800 py-3 text-sm font-semibold text-white transition hover:bg-slate-700 active:scale-[0.99]">
                    Go back and complete the form
                </button>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         TERMS DRAWER
    ══════════════════════════════════════════ --}}
    <div x-show="termsOpen" style="display:none" class="fixed inset-0 z-50 flex">

        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"
             x-show="termsOpen"
             x-transition:enter="drawer-bg-enter"
             x-transition:leave="drawer-bg-leave"
             @click="termsOpen = false"></div>

        {{-- Sliding panel --}}
        <div class="relative ml-auto flex h-full w-full max-w-lg flex-col bg-white shadow-2xl"
             x-show="termsOpen"
             x-transition:enter="drawer-panel-enter"
             x-transition:leave="drawer-panel-leave">

            {{-- Header --}}
            <div class="flex shrink-0 items-center justify-between border-b border-slate-100 px-6 py-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Rental Agreement</h3>
                    <p class="text-xs text-slate-400">Faisal Car Rentals Perth — Full terms & conditions</p>
                </div>
                <button @click="termsOpen = false" type="button"
                    class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 text-slate-400 transition hover:border-slate-300 hover:text-slate-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Scrollable agreement text --}}
            <div class="agreement-doc flex-1 overflow-y-auto px-7 py-6">
                {!! $agreementBody !!}
            </div>

            {{-- Footer --}}
            <div class="shrink-0 border-t border-slate-100 px-6 py-4">
                <button @click="termsOpen = false" type="button"
                    class="w-full rounded-xl bg-blue-600 py-3 text-sm font-semibold text-white transition hover:bg-blue-700 active:scale-[0.99]">
                    Close
                </button>
            </div>
        </div>
    </div>

</div>
@endsection
