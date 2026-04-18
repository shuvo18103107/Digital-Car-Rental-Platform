<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1e3a5f">
    <title>@yield('title', 'Car Rental Agreement') — Faisal Car Rentals Perth</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.2.0/dist/signature_pad.umd.min.js"></script>

    <style type="text/tailwindcss">
        @theme {
            --color-brand-900: #0f2444;
            --color-brand-800: #1e3a5f;
        }

        .form-input {
            @apply w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-800
                   placeholder-slate-400 shadow-sm transition duration-150
                   focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20;
        }
        .form-label      { @apply mb-1.5 block text-sm font-semibold text-slate-700; }
        .form-error      { @apply mt-1.5 flex items-center gap-1.5 text-sm text-red-600; }
        .section-card    { @apply rounded-2xl border border-slate-100 bg-white p-6 shadow-sm; }
        .section-header  { @apply mb-5 flex items-center gap-3 border-b border-slate-100 pb-4; }
        .section-number  { @apply flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-600 text-sm font-bold text-white; }
        .section-title   { @apply text-lg font-bold text-slate-800; }
        .input-required  { @apply ml-0.5 text-red-500; }

        /* Drawer animations */
        @keyframes drawer-slide-in  { from { transform: translateX(100%); } to { transform: translateX(0); } }
        @keyframes drawer-slide-out { from { transform: translateX(0); }   to { transform: translateX(100%); } }
        @keyframes bg-fade-in       { from { opacity: 0; } to { opacity: 1; } }
        @keyframes bg-fade-out      { from { opacity: 1; } to { opacity: 0; } }

        .drawer-panel-enter { animation: drawer-slide-in  0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .drawer-panel-leave { animation: drawer-slide-out 0.22s ease-in forwards; }
        .drawer-bg-enter    { animation: bg-fade-in  0.25s ease forwards; }
        .drawer-bg-leave    { animation: bg-fade-out 0.22s ease forwards; }

        /* Drawer agreement typography */
        .agreement-doc {
            font-family: 'Lora', Georgia, serif;
            font-size: 0.9375rem;
            line-height: 1.85;
            color: #374151;
        }
        .agreement-doc h2 { font-size: 1.1rem; font-weight: 700; color: #111827; margin: 1.5rem 0 0.6rem; font-family: system-ui, sans-serif; }
        .agreement-doc h3 { font-size: 0.7rem; font-weight: 700; color: #1e3a5f; margin: 1.25rem 0 0.5rem; font-family: system-ui, sans-serif; text-transform: uppercase; letter-spacing: 0.06em; }
        .agreement-doc p  { margin-bottom: 0.7rem; }
        .agreement-doc ul,
        .agreement-doc ol { padding-left: 1.25rem; margin-bottom: 0.7rem; }
        .agreement-doc ul { list-style: disc; }
        .agreement-doc ol { list-style: decimal; }
        .agreement-doc li { margin-bottom: 0.3rem; }
        .agreement-doc strong { font-weight: 600; color: #111827; }
    </style>

    @stack('styles')
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-100 antialiased">

    <header class="bg-gradient-to-r from-slate-900 via-blue-950 to-slate-900 shadow-xl">
        <div class="mx-auto max-w-5xl px-4 py-5">
            <div class="flex flex-col items-center justify-center gap-2 text-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-500/20 ring-1 ring-blue-400/30">
                    <svg class="h-7 w-7 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold tracking-tight text-white">Faisal Car Rentals Perth</h1>
                    <p class="text-sm text-blue-300">Digital Rental Agreement Portal</p>
                </div>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-4 py-8 pb-16">
        @yield('content')
    </main>

    <footer class="border-t border-slate-200 bg-white/70 py-6 text-center">
        <p class="text-sm text-slate-400">
            © {{ date('Y') }} Faisal Car Rentals Perth · 58 Royal Street, Tuart Hill, Perth WA · 0424 022 786
        </p>
    </footer>

    @stack('scripts')
</body>
</html>
