@extends('layouts.public')

@section('title', 'Agreement Submitted')

@section('content')
<div class="flex min-h-[60vh] flex-col items-center justify-center py-8 text-center">

    {{-- Animated checkmark --}}
    <div class="relative mb-8">
        <div class="flex h-24 w-24 items-center justify-center rounded-full bg-green-100 ring-8 ring-green-50">
            <svg class="h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                style="stroke-dasharray: 100; stroke-dashoffset: 100; animation: draw 0.6s ease forwards 0.2s;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
    </div>

    <style>
        @keyframes draw {
            to { stroke-dashoffset: 0; }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.5s ease forwards; }
        .fade-up-1 { animation-delay: 0.3s; opacity: 0; }
        .fade-up-2 { animation-delay: 0.45s; opacity: 0; }
        .fade-up-3 { animation-delay: 0.6s; opacity: 0; }
    </style>

    <div class="fade-up fade-up-1 max-w-md">
        <h2 class="text-3xl font-bold text-slate-800">Agreement Submitted!</h2>
        <p class="mt-3 text-slate-500">
            Thank you. Your rental agreement has been received and is now <strong class="text-slate-700">pending admin review</strong>.
        </p>
    </div>

    @if ($agreementNumber)
        <div class="fade-up fade-up-2 mt-6">
            <div class="rounded-2xl border border-slate-200 bg-white px-8 py-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">Agreement Reference</p>
                <p class="mt-1 text-2xl font-bold tracking-wide text-blue-600">{{ $agreementNumber }}</p>
                <p class="mt-1 text-xs text-slate-400">Keep this number for your records</p>
            </div>
        </div>
    @endif

    <div class="fade-up fade-up-3 mt-8 max-w-sm space-y-4">

        <div class="flex items-start gap-3 rounded-xl bg-blue-50 p-4 text-left ring-1 ring-blue-100">
            <svg class="mt-0.5 h-5 w-5 shrink-0 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <p class="text-sm text-blue-700">
                Once approved by our team, a <strong>signed PDF copy</strong> of your agreement will be sent to your email address.
            </p>
        </div>

        <div class="flex items-start gap-3 rounded-xl bg-amber-50 p-4 text-left ring-1 ring-amber-100">
            <svg class="mt-0.5 h-5 w-5 shrink-0 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
            </svg>
            <p class="text-sm text-amber-700">
                Do not resubmit your agreement while it's under review. You will be notified by email of any updates.
            </p>
        </div>

        <div class="rounded-xl border border-slate-100 bg-white p-4 text-left shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Need help? Contact us</p>
            <div class="mt-2 space-y-1 text-sm text-slate-600">
                <p class="flex items-center gap-2">
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <strong>0424 022 786</strong>
                </p>
                <p class="flex items-center gap-2">
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    58 Royal Street, Tuart Hill, Perth WA
                </p>
            </div>
        </div>

    </div>
</div>
@endsection
