<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>10Maktab — Zamonaviy Maktab Boshqaruv ERP & SaaS Tizimi</title>

    <meta name="description"
          content="10Maktab — o‘quvchilar, o‘qituvchilar, dars jadvali, real-vaqt davomat, elektron jurnal, kutubxona va tahliliy hisobotlarni yagona bulutli platformada boshqarish tizimi.">

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                        }
                    },
                    boxShadow: {
                        'glow': '0 0 50px -12px rgba(79, 70, 229, 0.25)',
                        'card-hover': '0 20px 40px -15px rgba(15, 23, 42, 0.08)',
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        .gradient-text {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #0284c7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-pattern {
            background-color: #fafbfc;
            background-image: radial-gradient(rgba(79, 70, 229, 0.08) 1px, transparent 1px), radial-gradient(rgba(79, 70, 229, 0.08) 1px, #fafbfc 1px);
            background-size: 28px 28px;
            background-position: 0 0, 14px 14px;
        }
    </style>
</head>

<body class="bg-[#fafbfc] text-slate-800 font-sans antialiased selection:bg-brand-500 selection:text-white" x-data="{ mobileMenuOpen: false }">

<!-- =========================================================
     1. NAVIGATION BAR (Glassmorphism & Interactive)
========================================================= -->
<header class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-slate-200/70 transition-all duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">

            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 group focus:outline-none">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-brand-600 via-brand-500 to-indigo-400 flex items-center justify-center text-white shadow-lg shadow-brand-500/25 group-hover:scale-105 transition-transform duration-300">
                    <!-- Academic Cap SVG -->
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                    </svg>
                </div>
                <div>
                    <span class="text-xl font-extrabold tracking-tight text-slate-900 flex items-center gap-1.5">
                        10Maktab
                        <span class="text-[10px] font-bold uppercase tracking-wider px-1.5 py-0.5 rounded-md bg-brand-50 text-brand-600 border border-brand-200">ERP</span>
                    </span>
                    <span class="text-[11px] font-medium text-slate-400 block -mt-0.5 tracking-wider uppercase">School Management</span>
                </div>
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="hidden md:flex items-center gap-8">
                <a href="#modullar" class="text-sm font-semibold text-slate-600 hover:text-brand-600 transition-colors">Modullar</a>
                <a href="#rollar" class="text-sm font-semibold text-slate-600 hover:text-brand-600 transition-colors">Rollar</a>
                <a href="#afzalliklar" class="text-sm font-semibold text-slate-600 hover:text-brand-600 transition-colors">Afzalliklar</a>
                <a href="#xavfsizlik" class="text-sm font-semibold text-slate-600 hover:text-brand-600 transition-colors">Xavfsizlik</a>
                <a href="#faq" class="text-sm font-semibold text-slate-600 hover:text-brand-600 transition-colors">FAQ</a>
            </nav>

            <!-- Authentication CTA -->
            <div class="hidden md:flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/home') }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold shadow-md shadow-slate-900/10 hover:shadow-lg transition-all duration-200 active:scale-[0.98]">
                            <svg class="w-4 h-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                            </svg>
                            <span>Boshqaruv Paneli</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold shadow-md shadow-brand-500/25 hover:shadow-lg hover:shadow-brand-500/35 transition-all duration-200 active:scale-[0.98]">
                            <span>Tizimga kirish</span>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    @endauth
                @endif
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="flex items-center md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="p-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile Slide Menu -->
    <div x-show="mobileMenuOpen" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-3"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-3"
         class="md:hidden bg-white/95 backdrop-blur-2xl border-b border-slate-200 px-6 py-5 space-y-4">
        <div class="flex flex-col space-y-3 font-semibold text-slate-700">
            <a @click="mobileMenuOpen = false" href="#modullar" class="hover:text-brand-600 py-1">Modullar</a>
            <a @click="mobileMenuOpen = false" href="#rollar" class="hover:text-brand-600 py-1">Rollar</a>
            <a @click="mobileMenuOpen = false" href="#afzalliklar" class="hover:text-brand-600 py-1">Afzalliklar</a>
            <a @click="mobileMenuOpen = false" href="#xavfsizlik" class="hover:text-brand-600 py-1">Xavfsizlik</a>
            <a @click="mobileMenuOpen = false" href="#faq" class="hover:text-brand-600 py-1">FAQ</a>
        </div>
        <div class="pt-4 border-t border-slate-100">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/home') }}" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-slate-900 text-white font-semibold text-sm">
                        Boshqaruv Paneli
                    </a>
                @else
                    <a href="{{ route('login') }}" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-brand-600 text-white font-semibold text-sm">
                        Tizimga kirish
                    </a>
                @endauth
            @endif
        </div>
    </div>
</header>


<!-- =========================================================
     2. HERO SECTION (High Converting & SaaS Dashboard Preview)
========================================================= -->
<section class="relative hero-pattern pt-12 pb-20 lg:pt-20 lg:pb-32 overflow-hidden">
    <!-- Glow Blur Orbs -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[350px] bg-gradient-to-tr from-brand-400/20 to-purple-400/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-8 items-center">

            <!-- Hero Left: Content -->
            <div class="lg:col-span-6 text-center lg:text-left">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-brand-200/80 shadow-sm shadow-brand-500/5 mb-6 text-xs sm:text-sm font-semibold text-brand-700">
                    <span class="flex h-2 w-2 rounded-full bg-brand-600 animate-ping"></span>
                    <span class="inline-block">Yangi avlod maktab boshqaruv tizimi</span>
                    <svg class="w-4 h-4 text-brand-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                    </svg>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 leading-[1.12] mb-6">
                    Maktab jarayonlarini <br>
                    <span class="gradient-text">raqamli va oson</span> boshqaring.
                </h1>

                <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-xl mx-auto lg:mx-0 mb-8">
                    Direktor, o‘qituvchi, o‘quvchi va ota-onalar uchun yagona avtomatlashgan ekotizim: real-vaqt davomat, elektron baholash, Excel dars jadvali va chuqur tahliliy hisobotlar.
                </p>

                <!-- Actions Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/home') }}"
                               class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-7 py-4 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-base shadow-xl shadow-brand-500/30 hover:shadow-brand-500/40 hover:-translate-y-0.5 transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                                </svg>
                                <span>Boshqaruv Paneliga O‘tish</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-7 py-4 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-base shadow-xl shadow-brand-500/30 hover:shadow-brand-500/40 hover:-translate-y-0.5 transition-all duration-200">
                                <span>Tizimga Kirish</span>
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>
                            </a>
                        @endauth
                    @endif

                    <a href="#modullar"
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-4 rounded-xl bg-white hover:bg-slate-50 text-slate-700 font-bold text-base border border-slate-200 shadow-sm hover:border-slate-300 transition-all duration-200">
                        <svg class="w-5 h-5 text-brand-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <span>Imkoniyatlar bilan tanishish</span>
                    </a>
                </div>

                <!-- Trust Points -->
                <div class="mt-10 pt-8 border-t border-slate-200/80 grid grid-cols-3 gap-4 text-left">
                    <div>
                        <div class="text-2xl font-extrabold text-slate-900 tracking-tight">99.8%</div>
                        <div class="text-xs text-slate-500 font-medium">Davomat aniqligi</div>
                    </div>
                    <div>
                        <div class="text-2xl font-extrabold text-slate-900 tracking-tight">100%</div>
                        <div class="text-xs text-slate-500 font-medium">Xavfsiz bulut</div>
                    </div>
                    <div>
                        <div class="text-2xl font-extrabold text-slate-900 tracking-tight">Real-vaqt</div>
                        <div class="text-xs text-slate-500 font-medium">SMS & Xabarnomalar</div>
                    </div>
                </div>
            </div>

            <!-- Hero Right: Live Interactive Dashboard Mockup -->
            <div class="lg:col-span-6">
                <div class="relative mx-auto max-w-lg lg:max-w-none">
                    <!-- Ambient Glow -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-brand-600 to-indigo-400 rounded-3xl blur-2xl opacity-20 group-hover:opacity-30 transition duration-1000"></div>

                    <!-- Glass Card Frame -->
                    <div class="relative rounded-3xl bg-white/95 backdrop-blur-2xl border border-slate-200/80 shadow-2xl p-6 sm:p-7">

                        <!-- Dashboard Header -->
                        <div class="flex items-center justify-between pb-5 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full bg-emerald-500 ring-4 ring-emerald-50"></div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-900">10-A Sinf — Bugungi Dashboard</h3>
                                    <p class="text-[11px] text-slate-400 font-medium">{{ date('d.m.Y') }} | 3-chorak darslari</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200/50">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Jonli monitoring
                            </span>
                        </div>

                        <!-- 4 Mini Metrics -->
                        <div class="grid grid-cols-2 gap-3.5 my-5">
                            <div class="p-3.5 rounded-2xl bg-slate-50/90 border border-slate-100 hover:border-brand-200 transition-colors">
                                <div class="flex items-center justify-between text-slate-500 mb-2">
                                    <span class="text-xs font-semibold">Davomat</span>
                                    <span class="p-1 rounded-md bg-emerald-100 text-emerald-700 text-[10px] font-bold">96.4%</span>
                                </div>
                                <div class="text-xl font-extrabold text-slate-900">32 / 34</div>
                                <div class="text-[11px] text-slate-400 font-medium mt-0.5">2 nafar sababli qoldirdi</div>
                            </div>

                            <div class="p-3.5 rounded-2xl bg-slate-50/90 border border-slate-100 hover:border-brand-200 transition-colors">
                                <div class="flex items-center justify-between text-slate-500 mb-2">
                                    <span class="text-xs font-semibold">O‘rtacha Baho</span>
                                    <span class="p-1 rounded-md bg-brand-100 text-brand-700 text-[10px] font-bold">4.7</span>
                                </div>
                                <div class="text-xl font-extrabold text-slate-900">A'lo daraja</div>
                                <div class="text-[11px] text-slate-400 font-medium mt-0.5">Oxirgi fan: Matematika</div>
                            </div>

                            <div class="p-3.5 rounded-2xl bg-slate-50/90 border border-slate-100 hover:border-brand-200 transition-colors">
                                <div class="flex items-center justify-between text-slate-500 mb-2">
                                    <span class="text-xs font-semibold">Dars Jadvali</span>
                                    <span class="p-1 rounded-md bg-amber-100 text-amber-700 text-[10px] font-bold">6/6</span>
                                </div>
                                <div class="text-xl font-extrabold text-slate-900">Kimyo (4-soat)</div>
                                <div class="text-[11px] text-slate-400 font-medium mt-0.5">Laboratoriya xonasi #12</div>
                            </div>

                            <div class="p-3.5 rounded-2xl bg-slate-50/90 border border-slate-100 hover:border-brand-200 transition-colors">
                                <div class="flex items-center justify-between text-slate-500 mb-2">
                                    <span class="text-xs font-semibold">Kutubxona</span>
                                    <span class="p-1 rounded-md bg-indigo-100 text-indigo-700 text-[10px] font-bold">100%</span>
                                </div>
                                <div class="text-xl font-extrabold text-slate-900">Darsliklar to‘liq</div>
                                <div class="text-[11px] text-slate-400 font-medium mt-0.5">Elektron kitoblar ochiq</div>
                            </div>
                        </div>

                        <!-- Live Feed Item Preview -->
                        <div class="p-4 rounded-2xl bg-brand-50/60 border border-brand-100/80">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-brand-600 text-white text-xs flex items-center justify-center font-bold">✓</div>
                                    <span class="text-xs font-bold text-brand-900">Ota-onalarga bildirishnoma</span>
                                </div>
                                <span class="text-[10px] font-semibold text-brand-600">2 daqiqa oldin</span>
                            </div>
                            <p class="text-xs text-brand-800 leading-relaxed">
                                Bugungi barcha sinflar davomati to'liq yakunlandi va ota-onalar shaxsiy kabinetiga sinxronlashtirildi.
                            </p>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- =========================================================
     3. KEY STATS / SOCIAL PROOF
========================================================= -->
<section class="py-14 bg-white border-y border-slate-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center divide-y lg:divide-y-0 lg:divide-x divide-slate-100">
            <div class="pt-4 lg:pt-0">
                <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">120+</div>
                <div class="text-sm font-semibold text-slate-500 mt-1">Uланган Maktablar</div>
            </div>
            <div class="pt-4 lg:pt-0">
                <div class="text-3xl sm:text-4xl font-extrabold text-brand-600 tracking-tight">65,000+</div>
                <div class="text-sm font-semibold text-slate-500 mt-1">Faol O‘quvchilar</div>
            </div>
            <div class="pt-4 lg:pt-0">
                <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">4,800+</div>
                <div class="text-sm font-semibold text-slate-500 mt-1">Malakali O‘qituvchilar</div>
            </div>
            <div class="pt-4 lg:pt-0">
                <div class="text-3xl sm:text-4xl font-extrabold text-emerald-600 tracking-tight">99.9%</div>
                <div class="text-sm font-semibold text-slate-500 mt-1">Tizim Uptime Ko‘rsatkichi</div>
            </div>
        </div>
    </div>
</section>


<!-- =========================================================
     4. CORE ERP MODULES (Features Grid)
========================================================= -->
<section class="py-24 bg-[#fafbfc]" id="modullar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="max-w-3xl mx-auto text-center mb-16">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-brand-50 text-brand-600 font-bold text-xs uppercase tracking-wider mb-3">
                ERP Xususiyatlari
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Maktab boshqaruvi uchun kerakli barcha vositalar
            </h2>
            <p class="text-slate-600 mt-4 text-base sm:text-lg">
                Qog‘ozbozlik va noaniqliklarga chek qo‘ying. Barcha ma'lumotlar real-vaqt rejimida avtomatlashtirilgan.
            </p>
        </div>

        <!-- Grid Cards -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

            <!-- 1. Real-time Attendance -->
            <div class="group p-8 rounded-3xl bg-white border border-slate-200/70 hover:border-brand-300 shadow-sm hover:shadow-card-hover transition-all duration-300">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Real-vaqt Davomat Nazorati</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Sinf rahbarlari va o‘qituvchilar dars boshlanishida davomatni bir necha soniyada belgilaydi. Sababsiz dars qoldirishlar darhol aniqlanadi.
                </p>
            </div>

            <!-- 2. Electronic Gradebook -->
            <div class="group p-8 rounded-3xl bg-white border border-slate-200/70 hover:border-brand-300 shadow-sm hover:shadow-card-hover transition-all duration-300">
                <div class="w-14 h-14 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Elektron Jurnal va Baholash</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Choraklik va yillik baholar, oraliq nazoratlar va monitoring avtomatik hisoblab boriladi. Shaffoflik 100% kafolatlanadi.
                </p>
            </div>

            <!-- 3. Smart Timetable & Excel -->
            <div class="group p-8 rounded-3xl bg-white border border-slate-200/70 hover:border-brand-300 shadow-sm hover:shadow-card-hover transition-all duration-300">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.253M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Aqlli Dars Jadvali & Excel</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    O‘qituvchilar va xonalar to‘qnashuvini oldini oluvchi algoritm. Dars jadvallarini bir klikda Excel orqali yuklash va eksport qilish.
                </p>
            </div>

            <!-- 4. Library & Book Fund -->
            <div class="group p-8 rounded-3xl bg-white border border-slate-200/70 hover:border-brand-300 shadow-sm hover:shadow-card-hover transition-all duration-300">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Kutubxona Fondi Hisobi</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Darsliklar va badiiy adabiyotlarning sinflar bo‘yicha taqsimoti, inventarizatsiya va berilgan kitoblar holatini to‘liq monitoring qilish.
                </p>
            </div>

            <!-- 5. Analytics & Export -->
            <div class="group p-8 rounded-3xl bg-white border border-slate-200/70 hover:border-brand-300 shadow-sm hover:shadow-card-hover transition-all duration-300">
                <div class="w-14 h-14 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Tahliliy Statistika va Reyting</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Sinflar o‘zlashtirishi, fanlar samaradorligi va o‘qituvchilar KPI ko‘rsatkichlarini grafik va jadvallarda bir lahzada tahlil qiling.
                </p>
            </div>

            <!-- 6. Notifications & Parent Connect -->
            <div class="group p-8 rounded-3xl bg-white border border-slate-200/70 hover:border-brand-300 shadow-sm hover:shadow-card-hover transition-all duration-300">
                <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Ota-onalar Bilan Aloqa</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    O‘quvchining maktabga kelgan-kelmaganligi, olgan baholari va xulq-atvori haqidagi xabarlar to‘g‘ridan-to‘g‘ri ota-onaga yetkaziladi.
                </p>
            </div>

        </div>
    </div>
</section>


<!-- =========================================================
     5. ROLE-BASED FEATURES (Interactive Alpine.js Tabs)
========================================================= -->
<section class="py-24 bg-white border-t border-slate-200/60" id="rollar" x-data="{ activeRole: 'director' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="max-w-3xl mx-auto text-center mb-14">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-indigo-50 text-indigo-700 font-bold text-xs uppercase tracking-wider mb-3">
                Har Bir Rol Uchun Maxsus
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Kim uchun qanday afzallik beradi?
            </h2>
            <p class="text-slate-600 mt-3 text-base">
                Tizim barcha ishtirokchilarning kundalik vazifalarini yengillashtirish uchun moslashtirilgan.
            </p>

            <!-- Role Selector Tabs -->
            <div class="inline-flex flex-wrap items-center justify-center p-1.5 rounded-2xl bg-slate-100/90 border border-slate-200 mt-8 gap-1">
                <button @click="activeRole = 'director'"
                        :class="activeRole === 'director' ? 'bg-white text-slate-900 shadow-md font-bold' : 'text-slate-600 hover:text-slate-900 font-semibold'"
                        class="px-5 py-2.5 rounded-xl text-sm transition-all duration-200">
                    Direktor va Rahbariyat
                </button>
                <button @click="activeRole = 'teacher'"
                        :class="activeRole === 'teacher' ? 'bg-white text-slate-900 shadow-md font-bold' : 'text-slate-600 hover:text-slate-900 font-semibold'"
                        class="px-5 py-2.5 rounded-xl text-sm transition-all duration-200">
                    O‘qituvchilar
                </button>
                <button @click="activeRole = 'parent'"
                        :class="activeRole === 'parent' ? 'bg-white text-slate-900 shadow-md font-bold' : 'text-slate-600 hover:text-slate-900 font-semibold'"
                        class="px-5 py-2.5 rounded-xl text-sm transition-all duration-200">
                    Ota-onalar va O‘quvchilar
                </button>
            </div>
        </div>

        <!-- Tab 1: Director -->
        <div x-show="activeRole === 'director'" x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="grid lg:grid-cols-2 gap-10 items-center bg-slate-50/80 p-8 sm:p-12 rounded-3xl border border-slate-200/70">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-brand-600">Maktab Rivoji & Nazorat</span>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2 mb-4">Butun maktab faoliyati kaftingizda</h3>
                <ul class="space-y-3.5 text-slate-600 text-sm sm:text-base">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        <span>Kunlik davomat va o'qituvchilarning darsga kirish ko'rsatkichlari real-vaqtda.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        <span>Vazirlik va tuman bo'limi uchun rasmiy hisobotlarni 1 tugma bilan Excel shaklida yuklab olish.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        <span>Pedagog xodimlarning KPI ko'rsatkichlari va dars yuklamalari hisobi.</span>
                    </li>
                </ul>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Rahbariyat Ko'rsatkichi</div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center text-sm font-semibold"><span>Umumiy davomat</span><span class="text-emerald-600">97.8%</span></div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5"><div class="bg-emerald-500 h-2.5 rounded-full" style="width: 97.8%"></div></div>
                    <div class="flex justify-between items-center text-sm font-semibold pt-2"><span>Sinflar o'zlashtirishi</span><span class="text-brand-600">89.2%</span></div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5"><div class="bg-brand-600 h-2.5 rounded-full" style="width: 89.2%"></div></div>
                </div>
            </div>
        </div>

        <!-- Tab 2: Teacher -->
        <div x-show="activeRole === 'teacher'" x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="grid lg:grid-cols-2 gap-10 items-center bg-slate-50/80 p-8 sm:p-12 rounded-3xl border border-slate-200/70">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-brand-600">O‘qituvchi Uchun Qulaylik</span>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2 mb-4">Qog'oz jurnallardan butunlay voz keching</h3>
                <ul class="space-y-3.5 text-slate-600 text-sm sm:text-base">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        <span>Telefon yoki kompyuter orqali bir necha soniyada baholash va davomat qilish.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        <span>Mavzular rejasini kiritish va dars jadvalini tezkor ko'rish.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        <span>Choraklik baholar va oraliq nazoratlarni avtomatik kalkulyatsiya qilish.</span>
                    </li>
                </ul>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Elektron Jurnal holati</div>
                <div class="p-3 bg-brand-50/70 border border-brand-100 rounded-xl text-xs text-brand-900 mb-3">
                    Bugun 4 ta dars o'tildi • Barcha baholar saqlandi
                </div>
                <div class="flex items-center justify-between text-xs text-slate-500 font-semibold">
                    <span>Vaqt tejalishi:</span>
                    <span class="text-emerald-600 font-bold">Kuniga ~45 daqiqa</span>
                </div>
            </div>
        </div>

        <!-- Tab 3: Parent & Student -->
        <div x-show="activeRole === 'parent'" x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="grid lg:grid-cols-2 gap-10 items-center bg-slate-50/80 p-8 sm:p-12 rounded-3xl border border-slate-200/70">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-brand-600">Ota-ona Xotirjamligi</span>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2 mb-4">Farzandingiz ta'limi to'liq nazorat ostida</h3>
                <ul class="space-y-3.5 text-slate-600 text-sm sm:text-base">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        <span>Farzandingiz darsga kelganligi haqida darhol xabardor bo'ling.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        <span>Kundalik olingan baholar va o'qituvchilarning izohlarini kuzatish.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                        <span>Ertangi dars jadvali va uyga berilgan vazifalarni telefon orqali bilish.</span>
                    </li>
                </ul>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Farzand Profil Ko'rinishi</div>
                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl mb-3">
                    <div class="w-10 h-10 rounded-full bg-brand-600 text-white font-bold flex items-center justify-center">A</div>
                    <div>
                        <div class="text-sm font-bold text-slate-900">Anvarov Jasur (8-B sinf)</div>
                        <div class="text-xs text-emerald-600 font-semibold">✓ Bugun darsda qatnashdi</div>
                    </div>
                </div>
                <div class="text-xs text-slate-500 font-medium">Bugungi baholar: Ona tili — 5, Fizika — 5, Tarix — 4</div>
            </div>
        </div>

    </div>
</section>


<!-- =========================================================
     6. SECURITY & TRUST
========================================================= -->
<section class="py-20 bg-slate-900 text-white relative overflow-hidden" id="xavfsizlik">
    <div class="absolute top-0 right-0 -mt-12 -mr-12 w-96 h-96 bg-brand-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-3xl mx-auto text-center mb-16">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-slate-800 text-brand-400 font-bold text-xs uppercase tracking-wider mb-3">
                Kiberxavfsizlik va Ishonch
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">
                Maktab ma'lumotlari to‘liq xavfsiz va shifrlangan
            </h2>
            <p class="text-slate-400 mt-4 text-base">
                O‘quvchilar va pedagoglarning shaxsiy ma'lumotlari milliy qonunchilik va xalqaro xavfsizlik standartlari asosida himoyalanadi.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="p-7 rounded-2xl bg-slate-800/80 border border-slate-700/80">
                <div class="w-12 h-12 rounded-xl bg-brand-500/20 text-brand-400 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" /></svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">SSL & Shifrlangan Aloqa</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Barcha tarmoq ma'lumotlari 256-bitli SSL protokoli orqali uzatiladi va tashqi hujumlardan himoyalangan.</p>
            </div>

            <div class="p-7 rounded-2xl bg-slate-800/80 border border-slate-700/80">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 5.625c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" /></svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Kunlik Avtomatik Zaxira (Backup)</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Ma'lumotlar bazasi har kuni avtomatik zaxiralanadi, hech bir baho yoki jurnal yo‘qolib ketmaydi.</p>
            </div>

            <div class="p-7 rounded-2xl bg-slate-800/80 border border-slate-700/80">
                <div class="w-12 h-12 rounded-xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" /></svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Rol Asosidagi Huquqlar (RBAC)</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Faqat ruxsat etilgan xodimlar tegishli sinf va ma'lumotlarga kirish huquqiga ega bo‘ladi.</p>
            </div>
        </div>
    </div>
</section>


<!-- =========================================================
     7. FREQUENTLY ASKED QUESTIONS (FAQ Accordion with Alpine)
========================================================= -->
<section class="py-24 bg-[#fafbfc]" id="faq" x-data="{ activeFaq: null }">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-brand-50 text-brand-600 font-bold text-xs uppercase tracking-wider mb-3">
                Savol-Javoblar
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Ko‘p beriladigan savollar
            </h2>
            <p class="text-slate-600 mt-3 text-base">
                10Maktab tizimi bo‘yicha eng muhim savollarga javoblar.
            </p>
        </div>

        <div class="space-y-4">

            <!-- FAQ Item 1 -->
            <div class="rounded-2xl bg-white border border-slate-200/80 overflow-hidden transition-colors">
                <button @click="activeFaq = (activeFaq === 1 ? null : 1)"
                        class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                    <span class="text-base sm:text-lg font-bold text-slate-900">Maktabimizni tizimga qanday ulashimiz mumkin?</span>
                    <span class="ml-4 p-1 rounded-full bg-slate-100 text-slate-500">
                        <svg class="w-5 h-5 transform transition-transform duration-200" :class="activeFaq === 1 ? 'rotate-180 text-brand-600' : ''" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </span>
                </button>
                <div x-show="activeFaq === 1" x-cloak x-collapse>
                    <div class="px-6 pb-6 text-sm sm:text-base text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                        Maktab ma'muriyati tizim administratori bilan bog‘lanib ro‘yxatdan o‘tadi. O‘qituvchilar va o‘quvchilar ro‘yxati Excel fayl orqali bir necha daqiqada bazaga avtomatik yuklanadi.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="rounded-2xl bg-white border border-slate-200/80 overflow-hidden transition-colors">
                <button @click="activeFaq = (activeFaq === 2 ? null : 2)"
                        class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                    <span class="text-base sm:text-lg font-bold text-slate-900">Dars jadvalini qanday kiritamiz?</span>
                    <span class="ml-4 p-1 rounded-full bg-slate-100 text-slate-500">
                        <svg class="w-5 h-5 transform transition-transform duration-200" :class="activeFaq === 2 ? 'rotate-180 text-brand-600' : ''" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </span>
                </button>
                <div x-show="activeFaq === 2" x-cloak x-collapse>
                    <div class="px-6 pb-6 text-sm sm:text-base text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                        Dars jadvalini maxsus interaktiv konstruktor orqali qo‘lda kiritish yoki oldindan tayyorlangan namunaviy Excel fayli orqali bir zumda import qilish mumkin.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="rounded-2xl bg-white border border-slate-200/80 overflow-hidden transition-colors">
                <button @click="activeFaq = (activeFaq === 3 ? null : 3)"
                        class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                    <span class="text-base sm:text-lg font-bold text-slate-900">Ota-onalar mobil telefon orqali foydalana oladimi?</span>
                    <span class="ml-4 p-1 rounded-full bg-slate-100 text-slate-500">
                        <svg class="w-5 h-5 transform transition-transform duration-200" :class="activeFaq === 3 ? 'rotate-180 text-brand-600' : ''" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </span>
                </button>
                <div x-show="activeFaq === 3" x-cloak x-collapse>
                    <div class="px-6 pb-6 text-sm sm:text-base text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                        Ha, 10Maktab veb-interfeysi barcha smartfonlar, planshetlar va brauzerlar uchun 100% moslashgan (Fully Responsive). Har qanday qurilmadan qulay foydalanish mumkin.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="rounded-2xl bg-white border border-slate-200/80 overflow-hidden transition-colors">
                <button @click="activeFaq = (activeFaq === 4 ? null : 4)"
                        class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                    <span class="text-base sm:text-lg font-bold text-slate-900">Baholar va hisobotlarni chop etish (export) mumkinmi?</span>
                    <span class="ml-4 p-1 rounded-full bg-slate-100 text-slate-500">
                        <svg class="w-5 h-5 transform transition-transform duration-200" :class="activeFaq === 4 ? 'rotate-180 text-brand-600' : ''" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </span>
                </button>
                <div x-show="activeFaq === 4" x-cloak x-collapse>
                    <div class="px-6 pb-6 text-sm sm:text-base text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                        Albatta. Choraklik jurnallar, davomat vedomostlari va umumiy maktab tahlili standart Excel va PDF formatlarida chop etishga tayyor holda yuklab olinadi.
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>


<!-- =========================================================
     8. CALL TO ACTION (CTA)
========================================================= -->
<section class="py-20 relative overflow-hidden bg-brand-600">
    <div class="absolute inset-0 bg-gradient-to-r from-brand-700 via-brand-600 to-indigo-600 opacity-95"></div>
    <!-- Decorative circles -->
    <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
    <div class="absolute -top-24 -right-24 w-80 h-80 bg-purple-500/20 rounded-full blur-2xl pointer-events-none"></div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight mb-5">
            Maktabingiz boshqaruvini bugunoq yangi bosqichga olib chiqing
        </h2>
        <p class="text-base sm:text-lg text-brand-100 max-w-2xl mx-auto mb-10 leading-relaxed">
            10Maktab bilan qog‘ozbozlikni kamaytiring, shaffoflikni ta'minlang va ta'lim sifatini oshiring.
        </p>

        @if (Route::has('login'))
            @auth
                <a href="{{ url('/home') }}"
                   class="inline-flex items-center gap-2.5 px-8 py-4 rounded-xl bg-white hover:bg-slate-50 text-slate-900 font-extrabold text-base shadow-2xl hover:shadow-white/20 hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-5 h-5 text-brand-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                    <span>Boshqaruv Paneliga Kirish</span>
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="inline-flex items-center gap-2.5 px-8 py-4 rounded-xl bg-white hover:bg-slate-50 text-slate-900 font-extrabold text-base shadow-2xl hover:shadow-white/20 hover:-translate-y-0.5 transition-all duration-200">
                    <span>Tizimga Kirish</span>
                    <svg class="w-5 h-5 text-brand-600" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            @endauth
        @endif
    </div>
</section>


<!-- =========================================================
     9. FOOTER
========================================================= -->
<footer class="bg-slate-950 text-slate-400 py-16 border-t border-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">

            <!-- Col 1: Brand Info -->
            <div class="md:col-span-2">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-brand-600 flex items-center justify-center text-white font-bold">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-white tracking-tight">10Maktab</span>
                </div>
                <p class="text-sm text-slate-400 leading-relaxed max-w-sm">
                    Umumta'lim maktablari va o‘quv markazlari faoliyatini to‘liq avtomatlashtirish, tahlil qilish va samaradorligini oshirish uchun mo‘ljallangan zamonaviy ERP platformasi.
                </p>
            </div>

            <!-- Col 2: Navigation -->
            <div>
                <h4 class="text-white text-sm font-bold uppercase tracking-wider mb-4">Tezkor Havolalar</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="#modullar" class="hover:text-white transition-colors">Tizim Modullari</a></li>
                    <li><a href="#rollar" class="hover:text-white transition-colors">Foydalanuvchi Rollari</a></li>
                    <li><a href="#afzalliklar" class="hover:text-white transition-colors">Afzalliklar</a></li>
                    <li><a href="#xavfsizlik" class="hover:text-white transition-colors">Xavfsizlik</a></li>
                    <li><a href="#faq" class="hover:text-white transition-colors">Savol-Javoblar</a></li>
                </ul>
            </div>

            <!-- Col 3: Status & Auth -->
            <div>
                <h4 class="text-white text-sm font-bold uppercase tracking-wider mb-4">Tizim Holati</h4>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-800 text-xs font-semibold text-emerald-400 mb-4">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Barcha serverlar faol (99.9%)
                </div>
                <div class="text-xs text-slate-500">
                    Tezkor texnik yordam va savollar uchun maktab ma'muriyatiga murojaat qiling.
                </div>
            </div>

        </div>

        <!-- Bottom Bar -->
        <div class="pt-8 border-t border-slate-900 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <div>
                © {{ date('Y') }} 10Maktab ERP. Barcha huquqlar himoyalangan.
            </div>
            <div class="flex items-center gap-6">
                <span>Maxfiylik siyosati</span>
                <span>Foydalanish shartlari</span>
                <span>Xavfsizlik standarti</span>
            </div>
        </div>

    </div>
</footer>

</body>
</html>