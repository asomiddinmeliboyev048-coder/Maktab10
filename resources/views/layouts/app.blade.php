<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Smart School')</title>
    <meta name="description" content="Smart School - Maktab boshqaruv tizimi">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">

    {{-- Bootstrap CSS & Icons --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>

        /* ==========================================================
           SMART SCHOOL — DESIGN TOKENS
           Konsepsiya: "Ilmiy Reestr" — maktab jurnali/reestr ruhida
           ========================================================== */
        :root {
            --ink-900: #0F1B33;
            --ink-800: #16234A;
            --ink-700: #202F5C;
            --ink-600: #2B3B70;

            --indigo-600: #3D4FE0;
            --indigo-500: #5B6BEF;
            --indigo-100: #E9EAFC;

            --gold-500: #E8A33D;
            --gold-400: #F0B85C;
            --gold-100: #FCEFD9;

            --sage-500: #2FAE7D;
            --sage-100: #E3F7EF;

            --brick-500: #E1524F;
            --brick-100: #FBE7E6;

            --sky-500: #2E9BE6;
            --sky-100: #E6F4FD;

            --paper-50: #F5F6FB;
            --paper-0: #FFFFFF;
            --line-200: #E6E8F2;
            --line-100: #F0F1F8;

            --text-900: #1B2138;
            --text-600: #5C6178;
            --text-400: #9096AC;

            --radius-lg: 16px;
            --radius-md: 12px;
            --radius-sm: 8px;

            --shadow-sm: 0 1px 2px rgba(16,24,64,.05), 0 1px 1px rgba(16,24,64,.03);
            --shadow-md: 0 6px 20px rgba(16,24,64,.08), 0 2px 6px rgba(16,24,64,.04);
            --shadow-lg: 0 16px 40px rgba(16,24,64,.12), 0 4px 10px rgba(16,24,64,.05);

            --ease: cubic-bezier(.4,0,.2,1);

            /* ---- Bootstrap 5 variable overrides (global cascade) ---- */
            --bs-primary: #3D4FE0;
            --bs-primary-rgb: 61,79,224;
            --bs-success: #2FAE7D;
            --bs-success-rgb: 47,174,125;
            --bs-warning: #E8A33D;
            --bs-warning-rgb: 232,163,61;
            --bs-danger: #E1524F;
            --bs-danger-rgb: 225,82,79;
            --bs-info: #2E9BE6;
            --bs-info-rgb: 46,155,230;
            --bs-dark: #1B2138;
            --bs-dark-rgb: 27,33,56;
            --bs-secondary: #6B7290;
            --bs-secondary-rgb: 107,114,144;
            --bs-body-font-family: 'Inter', sans-serif;
            --bs-border-radius: .7rem;
            --bs-border-radius-sm: .5rem;
            --bs-border-radius-lg: 1rem;
        }

        *,*::before,*::after { box-sizing: border-box; }

        ::selection { background: var(--gold-400); color: var(--ink-900); }

        ::-webkit-scrollbar { width: 9px; height: 9px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #C6CBE0; border-radius: 20px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--indigo-500); }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--paper-50);
            color: var(--text-900);
            opacity: 0;
            animation: pageIn .45s var(--ease) forwards;
        }
        @keyframes pageIn { to { opacity: 1; } }

        a { color: var(--indigo-600); }
        a:hover { color: var(--indigo-500); }

        :focus-visible {
            outline: 2px solid var(--indigo-500);
            outline-offset: 2px;
            border-radius: 4px;
        }

        /* ---- Top progress bar (perceived performance on navigation) ---- */
        #ss-progress {
            position: fixed; top: 0; left: 0; height: 3px; width: 0%;
            background: linear-gradient(90deg, var(--indigo-600), var(--gold-500));
            z-index: 20000; transition: width .3s var(--ease), opacity .3s var(--ease);
            opacity: 0;
        }
        #ss-progress.active { opacity: 1; }

        /* ==========================================================
           HEADER
           ========================================================== */
        .header {
            background: rgba(255,255,255,.85);
            backdrop-filter: saturate(180%) blur(10px);
            -webkit-backdrop-filter: saturate(180%) blur(10px);
            box-shadow: 0 1px 0 var(--line-200), 0 8px 24px rgba(16,24,64,.04);
            border-bottom: none;
        }

        .logo { text-decoration: none; }
        .logo i {
            background: linear-gradient(135deg, var(--indigo-600), var(--indigo-500));
            color: #fff !important;
            width: 38px; height: 38px;
            display: inline-flex; align-items: center; justify-content: center;
            border-radius: 11px;
            font-size: 19px !important;
            box-shadow: 0 4px 12px rgba(61,79,224,.35);
        }
        .logo span {
            font-family: 'Sora', sans-serif;
            font-weight: 800;
            font-size: 19px;
            color: var(--text-900);
            letter-spacing: -.01em;
        }

        .toggle-sidebar-btn {
            color: var(--text-600);
            transition: color .2s var(--ease), transform .2s var(--ease);
        }
        .toggle-sidebar-btn:hover { color: var(--indigo-600); transform: scale(1.1); }

        .header-nav .nav-profile img {
            width: 38px; height: 38px; object-fit: cover;
            border: 2px solid var(--indigo-100);
            transition: border-color .2s var(--ease);
        }
        .header-nav .nav-profile:hover img { border-color: var(--gold-400); }
        .header-nav .nav-profile span {
            font-weight: 600; color: var(--text-900); font-size: 14.5px;
        }

        .dropdown-menu {
            border: none;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-lg);
            padding: 8px;
            animation: dropIn .18s var(--ease);
        }
        @keyframes dropIn { from { opacity:0; transform: translateY(-6px);} to {opacity:1; transform:translateY(0);} }
        .dropdown-menu.profile { min-width: 230px; }
        .dropdown-header h6 { font-family:'Sora',sans-serif; font-weight:700; margin-bottom:2px; }
        .dropdown-header span {
            display:inline-block; font-size:11.5px; font-weight:600; letter-spacing:.03em;
            text-transform:uppercase; color: var(--indigo-600); background: var(--indigo-100);
            padding: 2px 9px; border-radius: 20px; margin-top:3px;
        }
        .dropdown-item {
            border-radius: var(--radius-sm);
            padding: 9px 12px;
            font-weight: 500;
            font-size: 14px;
            transition: background .15s var(--ease), color .15s var(--ease), padding-left .15s var(--ease);
        }
        .dropdown-item:hover { background: var(--indigo-100); color: var(--indigo-600); padding-left: 16px; }
        .dropdown-item i { margin-right: 8px; font-size: 15px; }
        .dropdown-divider { border-color: var(--line-200); margin: 6px 0; }

        /* ==========================================================
           SIDEBAR — "Ilmiy reestr" signature: xira chiziqli varaq fon
           va faol bo'limda oltin "xatcho'p" lenta
           ========================================================== */
        .sidebar {
            background: linear-gradient(180deg, var(--ink-900) 0%, var(--ink-800) 100%);
            background-image:
                repeating-linear-gradient(180deg, rgba(255,255,255,.025) 0px, rgba(255,255,255,.025) 1px, transparent 1px, transparent 34px),
                linear-gradient(180deg, var(--ink-900) 0%, var(--ink-800) 100%);
            border-right: none;
        }

        .sidebar-nav .nav-heading {
            color: var(--gold-400) !important;
            font-family: 'Sora', sans-serif;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            opacity: .85;
            padding: 18px 20px 8px;
        }

        .sidebar-nav .nav-link {
            margin: 2px 10px;
            border-radius: var(--radius-sm);
            color: rgba(255,255,255,.72);
            font-weight: 500;
            font-size: 14.5px;
            position: relative;
            transition: background .18s var(--ease), color .18s var(--ease), padding-left .18s var(--ease);
        }
        .sidebar-nav .nav-link i { color: rgba(255,255,255,.55); transition: color .18s var(--ease); }

        .sidebar-nav .nav-link::before {
            content: "";
            position: absolute; left: 0; top: 50%; transform: translateY(-50%);
            width: 3px; height: 0; border-radius: 3px;
            background: var(--gold-500);
            transition: height .2s var(--ease);
        }

        .sidebar-nav .nav-link:hover {
            background: rgba(255,255,255,.06);
            color: #fff;
            padding-left: 14px;
        }
        .sidebar-nav .nav-link:hover i { color: var(--gold-400); }

        .sidebar-nav .nav-link.active {
            background: linear-gradient(90deg, rgba(232,163,61,.16), rgba(232,163,61,.02));
            color: #fff;
            font-weight: 600;
        }
        .sidebar-nav .nav-link.active::before { height: 60%; }
        .sidebar-nav .nav-link.active i { color: var(--gold-500); }

        .sidebar-nav .nav-content a {
            color: rgba(255,255,255,.55);
            font-size: 13.5px;
            transition: color .15s var(--ease), padding-left .15s var(--ease);
        }
        .sidebar-nav .nav-content a:hover { color: #fff; padding-left: 4px; }
        .sidebar-nav .nav-content a.active { color: var(--gold-400) !important; font-weight: 700; }
        .sidebar-nav .nav-content i { font-size: 6px !important; }

        .sidebar-nav .nav-link .bi-chevron-down { transition: transform .25s var(--ease); font-size: 13px !important; }
        .sidebar-nav .nav-link[aria-expanded="true"] .bi-chevron-down,
        .sidebar-nav .nav-link:not(.collapsed) .bi-chevron-down { transform: rotate(-180deg); }

        /* ==========================================================
           PAGE HEADER / BREADCRUMB
           ========================================================== */
        .pagetitle h1 {
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 26px;
            color: var(--text-900);
            position: relative;
            display: inline-block;
            padding-bottom: 6px;
        }
        .pagetitle h1::after {
            content: "";
            position: absolute; left: 0; bottom: 0;
            width: 34px; height: 4px; border-radius: 4px;
            background: linear-gradient(90deg, var(--indigo-600), var(--gold-500));
        }
        .breadcrumb { background: transparent; padding: 0; margin-top: 4px; }
        .breadcrumb-item { font-size: 13.5px; color: var(--text-400); }
        .breadcrumb-item a { color: var(--text-600); font-weight: 500; text-decoration: none; }
        .breadcrumb-item a:hover { color: var(--indigo-600); }
        .breadcrumb-item.active { color: var(--indigo-600); font-weight: 600; }
        .breadcrumb-item + .breadcrumb-item::before { color: var(--line-200); }

        /* ==========================================================
           CARDS
           ========================================================== */
        .card {
            border: 1px solid var(--line-200);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            transition: box-shadow .25s var(--ease), transform .25s var(--ease);
        }
        .card:hover { box-shadow: var(--shadow-md); }
        .card.reveal { opacity: 0; transform: translateY(14px); }
        .card.reveal.in-view { opacity: 1; transform: translateY(0); transition: opacity .5s var(--ease), transform .5s var(--ease); }

        .card-header {
            background: var(--paper-0);
            border-bottom: 1px solid var(--line-200);
            border-radius: var(--radius-lg) var(--radius-lg) 0 0 !important;
            font-family: 'Sora', sans-serif;
        }
        .card-footer {
            background: var(--paper-0);
            border-top: 1px solid var(--line-200);
            border-radius: 0 0 var(--radius-lg) var(--radius-lg) !important;
        }
        .card-title { font-family: 'Sora', sans-serif; font-weight: 700; }

        .info-card .card-icon { transition: transform .25s var(--ease); }
        .info-card:hover .card-icon { transform: scale(1.08) rotate(-4deg); }

        /* ==========================================================
           BUTTONS — mikro-interaksiya: bosilganda "pressed" holati
           ========================================================== */
        .btn {
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 14px;
            padding: 8px 16px;
            position: relative;
            overflow: hidden;
            transition: transform .12s var(--ease), box-shadow .2s var(--ease), background .2s var(--ease), color .2s var(--ease), border-color .2s var(--ease);
        }
        .btn:active { transform: scale(.96); }
        .btn-sm { border-radius: var(--radius-sm); }

        .btn-primary { background: var(--indigo-600); border-color: var(--indigo-600); box-shadow: 0 3px 10px rgba(61,79,224,.28); }
        .btn-primary:hover { background: var(--indigo-500); border-color: var(--indigo-500); box-shadow: 0 5px 16px rgba(61,79,224,.36); }

        .btn-success { background: var(--sage-500); border-color: var(--sage-500); }
        .btn-success:hover { filter: brightness(1.08); }

        .btn-warning { background: var(--gold-500); border-color: var(--gold-500); color: #fff; }
        .btn-warning:hover { filter: brightness(1.06); color:#fff; }

        .btn-danger { background: var(--brick-500); border-color: var(--brick-500); }
        .btn-danger:hover { filter: brightness(1.08); }

        .btn-info { background: var(--sky-500); border-color: var(--sky-500); color:#fff; }
        .btn-info:hover { filter: brightness(1.06); color:#fff; }

        .btn-dark { background: var(--ink-900); border-color: var(--ink-900); }
        .btn-dark:hover { background: var(--ink-700); border-color: var(--ink-700); }

        .btn-light { background: var(--paper-50); border-color: var(--line-200); color: var(--text-900); }
        .btn-light:hover { background: var(--line-100); }

        .btn-outline-primary { color: var(--indigo-600); border-color: var(--indigo-600); }
        .btn-outline-primary:hover { background: var(--indigo-600); border-color: var(--indigo-600); }

        .btn-outline-success { color: var(--sage-500); border-color: var(--sage-500); }
        .btn-outline-success:hover { background: var(--sage-500); border-color: var(--sage-500); }

        .btn-outline-warning { color: #B9791F; border-color: var(--gold-500); }
        .btn-outline-warning:hover { background: var(--gold-500); border-color: var(--gold-500); color: #fff; }

        .btn-outline-danger { color: var(--brick-500); border-color: var(--brick-500); }
        .btn-outline-danger:hover { background: var(--brick-500); border-color: var(--brick-500); }

        .btn-outline-info { color: var(--sky-500); border-color: var(--sky-500); }
        .btn-outline-info:hover { background: var(--sky-500); border-color: var(--sky-500); color:#fff; }

        .btn-outline-secondary { color: var(--text-600); border-color: var(--line-200); }
        .btn-outline-secondary:hover { background: var(--text-600); border-color: var(--text-600); }

        .btn-outline-dark { color: var(--ink-900); border-color: var(--ink-900); }
        .btn-outline-dark:hover { background: var(--ink-900); border-color: var(--ink-900); }

        .btn-check:checked + .btn-outline-primary,
        .btn-check:checked + .btn-outline-success,
        .btn-check:checked + .btn-outline-danger,
        .btn-check:checked + .btn-outline-warning,
        .btn-check:checked + .btn-outline-secondary,
        .btn-check:checked + .btn-outline-info {
            box-shadow: 0 3px 10px rgba(16,24,64,.18);
        }

        .ss-ripple {
            position: absolute; border-radius: 50%;
            background: rgba(255,255,255,.55);
            transform: scale(0); animation: rippleAnim .55s var(--ease);
            pointer-events: none;
        }
        @keyframes rippleAnim { to { transform: scale(3); opacity: 0; } }

        /* ==========================================================
           BADGES
           ========================================================== */
        .badge { font-weight: 600; letter-spacing: .01em; border-radius: 20px; padding: 5px 10px; }
        .badge.bg-dark { background: var(--ink-900) !important; font-family: 'JetBrains Mono', monospace; font-size: 12px; letter-spacing: .02em; }
        .badge.bg-light { background: var(--paper-50) !important; }

        /* ==========================================================
           TABLES — "reestr qatori" hover effekti
           ========================================================== */
        .table { --bs-table-hover-bg: transparent; }
        .table thead th {
            background: var(--paper-50);
            color: var(--text-600);
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            border-bottom: 1px solid var(--line-200) !important;
            padding: 13px 14px;
        }
        .table td { padding: 13px 14px; border-color: var(--line-100); vertical-align: middle; font-size: 14.5px; }
        .table-hover tbody tr { transition: box-shadow .15s var(--ease), background .15s var(--ease); }
        .table-hover tbody tr:hover {
            background: var(--indigo-100);
            box-shadow: inset 3px 0 0 var(--indigo-600);
        }

        /* ==========================================================
           FORMS
           ========================================================== */
        .form-control, .form-select {
            border-radius: var(--radius-sm);
            border-color: var(--line-200);
            font-size: 14.5px;
            padding: 9px 13px;
            transition: border-color .18s var(--ease), box-shadow .18s var(--ease);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--indigo-500);
            box-shadow: 0 0 0 4px var(--indigo-100);
        }
        .form-label { font-weight: 600; font-size: 13.5px; color: var(--text-900); }
        .form-check-input:checked { background-color: var(--indigo-600); border-color: var(--indigo-600); }
        .form-check-input:focus { border-color: var(--indigo-500); box-shadow: 0 0 0 4px var(--indigo-100); }
        .input-group-text { background: var(--paper-50); border-color: var(--line-200); }

        /* ==========================================================
           ALERTS
           ========================================================== */
        .smart-alert, .alert {
            border: none;
            border-radius: var(--radius-md);
            border-left: 4px solid transparent;
            font-size: 14.5px;
            font-weight: 500;
            box-shadow: var(--shadow-sm);
            animation: alertIn .3s var(--ease);
        }
        @keyframes alertIn { from { opacity:0; transform: translateY(-8px);} to {opacity:1; transform:translateY(0);} }
        .alert-success { background: var(--sage-100); color: #1F7A57; border-left-color: var(--sage-500); }
        .alert-danger  { background: var(--brick-100); color: #B23431; border-left-color: var(--brick-500); }
        .alert-warning { background: var(--gold-100); color: #8A5C13; border-left-color: var(--gold-500); }
        .alert-info    { background: var(--sky-100); color: #1E6FA8; border-left-color: var(--sky-500); }

        /* ==========================================================
           MODALS
           ========================================================== */
        .modal-content { border: none; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); }
        .modal-header { border-bottom: 1px solid var(--line-200); }
        .modal-footer { border-top: 1px solid var(--line-200); background: var(--paper-50); border-radius: 0 0 var(--radius-lg) var(--radius-lg); }
        .modal-title { font-family: 'Sora', sans-serif; font-weight: 700; }
        .modal.fade .modal-dialog { transform: translateY(20px) scale(.98); }
        .modal.show .modal-dialog { transform: translateY(0) scale(1); }

        /* ==========================================================
           PAGINATION
           ========================================================== */
        .page-link { border-color: var(--line-200); color: var(--text-600); border-radius: var(--radius-sm); margin: 0 2px; font-weight: 500; }
        .page-link:hover { background: var(--indigo-100); color: var(--indigo-600); }
        .page-item.active .page-link { background: var(--indigo-600); border-color: var(--indigo-600); }

        /* ==========================================================
           MAIN / FOOTER
           ========================================================== */
        #main { min-height: calc(100vh - 60px); }
        .page-content { width: 100%; }

        .footer { background: transparent; color: var(--text-400); font-size: 13px; }
        .footer .copyright strong span { color: var(--indigo-600); }

        .back-to-top {
            background: var(--indigo-600);
            box-shadow: 0 6px 18px rgba(61,79,224,.35);
            transition: transform .2s var(--ease), background .2s var(--ease);
        }
        .back-to-top:hover { background: var(--indigo-500); transform: translateY(-3px); }

        /* ---- Reduced motion ---- */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: .001ms !important; transition-duration: .001ms !important; }
            .card.reveal { opacity: 1; transform: none; }
        }
    </style>
    @stack('styles')
</head>

<body>

<div id="ss-progress"></div>

{{-- HEADER --}}
<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
            <i class="bi bi-mortarboard-fill me-2"></i>
            <span class="d-none d-lg-block">Smart School</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    @if(Auth::check() && Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Profile" class="rounded-circle">
                    @else
                        <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
                    @endif
                    <span class="d-none d-md-block dropdown-toggle ps-2">
                        @if(Auth::check()) {{ Auth::user()->name }} @else Mehmon @endif
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    @if(Auth::check())
                        <li class="dropdown-header">
                            <h6>{{ Auth::user()->name }}</h6>
                            <span>
                                @if(Auth::user()->role === 'director') Direktor
                                @elseif(Auth::user()->role === 'deputy') Direktor o‘rinbosari
                                @elseif(Auth::user()->role === 'teacher') O‘qituvchi
                                @else Foydalanuvchi @endif
                            </span>
                        </li>
                    @endif
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('profil') }}">
                            <i class="bi bi-person"></i> <span>Profil</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center">
                                <i class="bi bi-box-arrow-right"></i> <span>Chiqish</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</header>

{{-- SIDEBAR --}}
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : 'collapsed' }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        {{-- DIRECTOR & DEPUTY --}}
        @if(Auth::check() && in_array(Auth::user()->role, ['director', 'deputy']))
            <li class="nav-heading">Boshqaruv</li>

            <li class="nav-item">
                <a href="{{ route('oquvchilar.index') }}"
                   class="nav-link {{ request()->routeIs('oquvchilar.*') ? 'active' : 'collapsed' }}"
                   data-bs-toggle="collapse" data-bs-target="#oquvchilar-menu">
                    <i class="bi bi-people"></i><span>O‘quvchilar</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="oquvchilar-menu" class="nav-content collapse {{ request()->routeIs('oquvchilar.*') ? 'show' : '' }}">
                    <li><a href="{{ route('oquvchilar.index') }}" class="{{ request()->routeIs('oquvchilar.index') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Barcha o‘quvchilar</span></a></li>
                    <li><a href="{{ route('oquvchilar.create') }}" class="{{ request()->routeIs('oquvchilar.create') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>O‘quvchi qo‘shish</span></a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{ route('sinflar.index') }}"
                   class="nav-link {{ request()->routeIs('sinflar.*') ? 'active' : 'collapsed' }}"
                   data-bs-toggle="collapse" data-bs-target="#sinflar-menu">
                    <i class="bi bi-building"></i><span>Sinflar</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="sinflar-menu" class="nav-content collapse {{ request()->routeIs('sinflar.*') ? 'show' : '' }}">
                    <li><a href="{{ route('sinflar.index') }}" class="{{ request()->routeIs('sinflar.index') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Barcha sinflar</span></a></li>
                    <li><a href="{{ route('sinflar.create') }}" class="{{ request()->routeIs('sinflar.create') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Sinf qo‘shish</span></a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{ route('oqituvchilar.index') }}"
                   class="nav-link {{ request()->routeIs('oqituvchilar.*') ? 'active' : 'collapsed' }}"
                   data-bs-toggle="collapse" data-bs-target="#oqituvchilar-menu">
                    <i class="bi bi-person-badge"></i><span>O‘qituvchilar</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="oqituvchilar-menu" class="nav-content collapse {{ request()->routeIs('oqituvchilar.*') ? 'show' : '' }}">
                    <li><a href="{{ route('oqituvchilar.index') }}" class="{{ request()->routeIs('oqituvchilar.index') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Barcha o‘qituvchilar</span></a></li>
                    <li><a href="{{ route('oqituvchilar.create') }}" class="{{ request()->routeIs('oqituvchilar.create') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>O‘qituvchi qo‘shish</span></a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{ route('darsjadvali.index') }}"
                   class="nav-link {{ request()->routeIs('darsjadvali.*') ? 'active' : 'collapsed' }}">
                    <i class="bi bi-calendar-week"></i><span>Dars jadvali</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('kutubxona.index') }}" class="nav-link {{ request()->routeIs('kutubxona.*') ? 'active' : 'collapsed' }}">
                    <i class="bi bi-book"></i><span>Kutubxona</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('davomat.index') }}" class="nav-link {{ request()->routeIs('davomat.*') ? 'active' : 'collapsed' }}">
                    <i class="bi bi-calendar-check"></i><span>Davomat</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('baholar.index') }}" class="nav-link {{ request()->routeIs('baholar.*') ? 'active' : 'collapsed' }}">
                    <i class="bi bi-award"></i><span>Baholar</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('statistika.index') }}" class="nav-link {{ request()->routeIs('statistika.*') ? 'active' : 'collapsed' }}">
                    <i class="bi bi-graph-up"></i><span>Statistika</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('reyting.index') }}" class="nav-link {{ request()->routeIs('reyting.*') ? 'active' : 'collapsed' }}">
                    <i class="bi bi-trophy"></i><span>O‘quvchilar reytingi</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('xabarlar.index') }}" class="nav-link {{ request()->routeIs('xabarlar.*') ? 'active' : 'collapsed' }}">
                    <i class="bi bi-chat-dots"></i><span>Xabarlar</span>
                </a>
            </li>

            <li class="nav-heading">Tizim</li>
            <li class="nav-item">
                <a href="{{ route('profil') }}" class="nav-link {{ request()->routeIs('profil') ? 'active' : 'collapsed' }}">
                    <i class="bi bi-person-circle"></i><span>Profil</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('sozlamalar.index') }}" class="nav-link {{ request()->routeIs('sozlamalar.*') ? 'active' : 'collapsed' }}">
                    <i class="bi bi-gear"></i><span>Sozlamalar</span>
                </a>
            </li>
        @endif

        {{-- TEACHER PANEL --}}
        @if(Auth::check() && Auth::user()->role === 'teacher')
            <li class="nav-heading">O‘qituvchi paneli</li>

            <li class="nav-item">
                <a href="{{ route('darsjadvali.teacher') }}"
                   class="nav-link {{ request()->routeIs('darsjadvali.teacher') ? 'active' : 'collapsed' }}">
                    <i class="bi bi-calendar-week"></i>
                    <span>Dars jadvalim</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('teacher.test') }}" class="nav-link {{ request()->routeIs('teacher.test') ? 'active' : 'collapsed' }}">
                    <i class="bi bi-building"></i>
                    <span>Mening sinfim</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('davomat.index') }}" class="nav-link">
                    <i class="bi bi-calendar-check"></i>
                    <span>Davomat</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('baholar.index') }}" class="nav-link">
                    <i class="bi bi-star"></i>
                    <span>Baholash</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('hisobotlar.index') }}" class="nav-link">
                    <i class="bi bi-clock-history"></i>
                    <span>O‘tilgan darslar</span>
                </a>
            </li>
        @endif

    </ul>
</aside>

{{-- MAIN --}}
<main id="main" class="main">
    @hasSection('page-title')
        <div class="pagetitle">
            <h1>@yield('page-title')</h1>
            @hasSection('breadcrumb')
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">@yield('breadcrumb')</li>
                    </ol>
                </nav>
            @endif
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show smart-alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show smart-alert">
            <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show smart-alert">
            <i class="bi bi-exclamation-circle me-2"></i> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show smart-alert">
            <i class="bi bi-info-circle me-2"></i> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="page-content">
        @yield('content')
    </div>
</main>

{{-- FOOTER --}}
<footer id="footer" class="footer">
    <div class="copyright">
        &copy; {{ date('Y') }} <strong><span>Smart School</span></strong> — Barcha huquqlar himoyalangan.
    </div>
    <div class="credits">Maktab Boshqaruv Tizimi</div>
</footer>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>

<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

<script>
(function () {
    /* ---- 1) Yuqori progress-bar: ichki havola/forma yuborilganda ---- */
    var bar = document.getElementById('ss-progress');
    function startBar() {
        bar.classList.add('active');
        bar.style.width = '0%';
        requestAnimationFrame(function () { bar.style.width = '75%'; });
    }
    document.addEventListener('click', function (e) {
        var a = e.target.closest('a[href]');
        if (!a) return;
        var href = a.getAttribute('href');
        if (!href || href.startsWith('#') || a.target === '_blank' || a.hasAttribute('data-bs-toggle')) return;
        if (href.startsWith('http') && !href.startsWith(window.location.origin)) return;
        startBar();
    });
    document.addEventListener('submit', function () { startBar(); });
    window.addEventListener('beforeunload', function () { bar.style.width = '100%'; });

    /* ---- 2) Kartalarning ekranga kirganda yumshoq paydo bo'lishi ---- */
    var cards = document.querySelectorAll('.card');
    if ('IntersectionObserver' in window && cards.length) {
        cards.forEach(function (c) { c.classList.add('reveal'); });
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry, idx) {
                if (entry.isIntersecting) {
                    setTimeout(function () { entry.target.classList.add('in-view'); }, idx * 40);
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.08 });
        cards.forEach(function (c) { io.observe(c); });
    } else {
        cards.forEach(function (c) { c.classList.add('in-view'); });
    }

    /* ---- 3) Tugmalar uchun "ripple" mikro-effekt ---- */
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.btn');
        if (!btn) return;
        var rect = btn.getBoundingClientRect();
        var ripple = document.createElement('span');
        var size = Math.max(rect.width, rect.height);
        ripple.className = 'ss-ripple';
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
        ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
        btn.style.position = btn.style.position || 'relative';
        btn.appendChild(ripple);
        setTimeout(function () { ripple.remove(); }, 550);
    });

    /* ---- 4) Sonlarni animatsiyalab sanash (kelajakda opt-in: data-counter="420") ---- */
    document.querySelectorAll('[data-counter]').forEach(function (el) {
        var target = parseFloat(el.getAttribute('data-counter'));
        if (isNaN(target)) return;
        var isFloat = el.getAttribute('data-counter').indexOf('.') !== -1;
        var duration = 900, start = null, from = 0;
        function step(ts) {
            if (!start) start = ts;
            var progress = Math.min((ts - start) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3);
            var value = from + (target - from) * eased;
            el.textContent = isFloat ? value.toFixed(2) : Math.round(value);
            if (progress < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    });

    /* ---- 5) Alertlarni bir necha soniyadan keyin avtomatik yopish ---- */
    document.querySelectorAll('.smart-alert').forEach(function (el) {
        setTimeout(function () {
            el.style.transition = 'opacity .4s ease, transform .4s ease';
            el.style.opacity = '0';
            el.style.transform = 'translateY(-8px)';
            setTimeout(function () { el.remove(); }, 400);
        }, 6000);
    });
        /* ---- 6) Bootstrap tooltiplarni avtomatik ishga tushirish ---- */
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
        new bootstrap.Tooltip(el);
    });
})();
</script>

@stack('scripts')

</body>
</html>