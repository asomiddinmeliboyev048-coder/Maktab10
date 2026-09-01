<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Smart School') - Maktab Boshqaruv Tizimi</title>
    <meta name="description" content="Smart School - Zamonaviy va aqlli maktab boshqaruv platformasi">

    {{-- Zamonaviy Premium Font: Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Bootstrap CSS & Icons --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    {{-- MODERN SAAS UI STYLES --}}
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --primary-light: #eef2ff;
            --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            --secondary: #64748b;
            --bg-main: #f8fafc;
            --sidebar-bg: #ffffff;
            --sidebar-width: 270px;
            --header-height: 70px;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --card-border: rgba(226, 232, 240, 0.8);
            --shadow-soft: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
            --shadow-card: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
            --shadow-primary: 0 10px 20px -5px rgba(79, 70, 229, 0.3);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-main);
            color: var(--text-dark);
            overflow-x: hidden;
            letter-spacing: -0.01em;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* HEADER / NAVBAR */
        .modern-header {
            height: var(--header-height);
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--card-border);
            z-index: 1020;
            transition: var(--transition);
        }

        .brand-logo-box {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-primary);
            color: #fff;
            transition: var(--transition);
        }
        .brand-logo-box:hover {
            transform: rotate(-5deg) scale(1.05);
        }

        .brand-text {
            font-size: 1.25rem;
            font-weight: 800;
            background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .toggle-btn-modern {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f1f5f9;
            color: var(--secondary);
            cursor: pointer;
            border: 1px solid #e2e8f0;
            transition: var(--transition);
        }
        .toggle-btn-modern:hover {
            background: var(--primary-light);
            color: var(--primary);
            border-color: #c7d2fe;
        }

        /* User Profile Pill */
        .profile-chip {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 5px 12px 5px 6px;
            border-radius: 9999px;
            transition: var(--transition);
        }
        .profile-chip:hover {
            background: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            border-color: #cbd5e1;
        }
        .profile-avatar-img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        /* SIDEBAR */
        .modern-sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            border-right: 1px solid var(--card-border);
            position: fixed;
            top: var(--header-height);
            bottom: 0;
            left: 0;
            padding: 1.25rem 0.85rem;
            overflow-y: auto;
            z-index: 1010;
            transition: var(--transition);
            box-shadow: var(--shadow-soft);
        }

        .nav-section-title {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94a3b8;
            padding: 1rem 0.75rem 0.4rem;
        }

        .modern-sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            font-size: 0.92rem;
            font-weight: 600;
            color: #475569;
            border-radius: 12px;
            margin-bottom: 3px;
            transition: var(--transition);
            position: relative;
        }

        .modern-sidebar .nav-link i {
            font-size: 1.15rem;
            color: #64748b;
            transition: var(--transition);
        }

        .modern-sidebar .nav-link:hover {
            color: var(--primary);
            background: var(--primary-light);
            transform: translateX(4px);
        }
        .modern-sidebar .nav-link:hover i {
            color: var(--primary);
        }

        /* Active Navigation Item */
        .modern-sidebar .nav-link.active {
            background: var(--primary-gradient);
            color: #ffffff !important;
            box-shadow: var(--shadow-primary);
        }
        .modern-sidebar .nav-link.active i {
            color: #ffffff !important;
        }
        .modern-sidebar .nav-link.active::after {
            content: '';
            position: absolute;
            right: 8px;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #ffffff;
        }

        /* Submenu Style */
        .modern-sidebar .nav-content {
            padding-left: 1rem;
            margin: 4px 0 6px;
            list-style: none;
            border-left: 2px dashed #e2e8f0;
            margin-left: 1.5rem;
        }
        .modern-sidebar .nav-content a {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 7px 12px;
            font-size: 0.85rem;
            font-weight: 500;
            color: #64748b;
            text-decoration: none;
            border-radius: 8px;
            transition: var(--transition);
        }
        .modern-sidebar .nav-content a:hover {
            color: var(--primary);
            background: var(--primary-light);
            transform: translateX(3px);
        }
        .modern-sidebar .nav-content a.active {
            color: var(--primary);
            font-weight: 700;
            background: var(--primary-light);
        }
        .modern-sidebar .nav-content a i {
            font-size: 6px;
        }

        /* MAIN CONTENT LAYOUT */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            padding-top: var(--header-height);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: var(--transition);
        }

        .content-container {
            flex: 1;
            padding: 2rem 2.2rem;
            animation: fadeInContent 0.4s ease-in-out;
        }

        @keyframes fadeInContent {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Page Headers & Breadcrumbs */
        .pagetitle h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
            margin-bottom: 4px;
        }
        .breadcrumb {
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
            font-weight: 500;
        }
        .breadcrumb a {
            color: #64748b;
            text-decoration: none;
            transition: var(--transition);
        }
        .breadcrumb a:hover {
            color: var(--primary);
        }
        .breadcrumb-item.active {
            color: var(--primary);
            font-weight: 600;
        }

        /* Modern Alert Banners */
        .modern-alert {
            border: none;
            border-radius: 16px;
            padding: 1rem 1.25rem;
            box-shadow: var(--shadow-soft);
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(8px);
        }
        .alert-success { background: #ecfdf5; color: #065f46; border-left: 4px solid #10b981; }
        .alert-danger { background: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444; }
        .alert-warning { background: #fffbeb; color: #92400e; border-left: 4px solid #f59e0b; }
        .alert-info { background: #eff6ff; color: #1e40af; border-left: 4px solid #3b82f6; }

        /* Modern Dropdown Menus */
        .dropdown-menu-modern {
            border: 1px solid var(--card-border);
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
            padding: 8px;
            background: #ffffff;
            animation: dropdownFade 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes dropdownFade {
            from { opacity: 0; transform: translateY(-8px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        .dropdown-menu-modern .dropdown-item {
            border-radius: 10px;
            padding: 9px 14px;
            font-size: 0.9rem;
            font-weight: 500;
            color: #334155;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .dropdown-menu-modern .dropdown-item:hover {
            background: var(--primary-light);
            color: var(--primary);
            transform: translateX(3px);
        }
        .dropdown-menu-modern .dropdown-item i {
            font-size: 1.1rem;
        }

        /* Role Badges */
        .role-badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            font-size: 0.72rem;
            font-weight: 700;
            border-radius: 9999px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .role-badge.director { background: #fee2e2; color: #dc2626; }
        .role-badge.deputy { background: #fef3c7; color: #d97706; }
        .role-badge.teacher { background: #e0e7ff; color: #4338ca; }
        .role-badge.user { background: #f1f5f9; color: #475569; }

        /* FOOTER */
        .modern-footer {
            background: #ffffff;
            border-top: 1px solid var(--card-border);
            padding: 1.25rem 2rem;
            font-size: 0.85rem;
            color: var(--secondary);
        }

        /* Back to top button */
        .back-to-top-modern {
            position: fixed;
            visibility: hidden;
            opacity: 0;
            right: 20px;
            bottom: 20px;
            z-index: 999;
            background: var(--primary-gradient);
            width: 44px;
            height: 44px;
            border-radius: 12px;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-primary);
            transition: var(--transition);
            text-decoration: none;
        }
        .back-to-top-modern.active {
            visibility: visible;
            opacity: 1;
            transform: translateY(0);
        }
        .back-to-top-modern:hover {
            color: #fff;
            transform: translateY(-4px);
            box-shadow: 0 15px 25px -5px rgba(79, 70, 229, 0.4);
        }

        /* SIDEBAR OVERLAY FOR MOBILE */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
            z-index: 1005;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        /* RESPONSIVE TOGGLE STYLES */
        @media (max-width: 1199.98px) {
            .modern-sidebar {
                left: calc(-1 * var(--sidebar-width));
            }
            .main-wrapper {
                margin-left: 0 !important;
            }
            body.sidebar-open .modern-sidebar {
                left: 0;
            }
            body.sidebar-open .sidebar-overlay {
                opacity: 1;
                visibility: visible;
            }
        }

        @media (min-width: 1200px) {
            body.sidebar-collapsed .modern-sidebar {
                left: calc(-1 * var(--sidebar-width));
            }
            body.sidebar-collapsed .main-wrapper {
                margin-left: 0 !important;
            }
        }

        @media (max-width: 576px) {
            .content-container {
                padding: 1.25rem 1rem;
            }
        }
    </style>
    @stack('styles')
</head>

<body>

{{-- MOBILE BACKDROP OVERLAY --}}
<div class="sidebar-overlay" id="sidebar-overlay"></div>

{{-- MODERN HEADER --}}
<header id="header" class="modern-header fixed-top d-flex align-items-center px-3 px-lg-4">
    <div class="d-flex align-items-center justify-content-between gap-3">
        <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none">
            <div class="brand-logo-box">
                <i class="bi bi-mortarboard-fill" style="font-size: 22px;"></i>
            </div>
            <span class="brand-text d-none d-sm-block">Smart School</span>
        </a>
        <div class="toggle-btn-modern" id="toggle-sidebar-btn" title="Menyuni ochish/yopish">
            <i class="bi bi-text-indent-left fs-5"></i>
        </div>
    </div>

    <nav class="ms-auto d-flex align-items-center gap-2">
        {{-- USER PROFILE DROPDOWN --}}
        <div class="dropdown">
            <a class="profile-chip d-flex align-items-center text-decoration-none dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                @if(Auth::check() && Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="profile-avatar-img">
                @else
                    <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Avatar" class="profile-avatar-img">
                @endif
                <div class="d-none d-md-flex flex-column text-start ps-2 pe-1">
                    <span class="fw-bold text-dark" style="font-size: 0.88rem; line-height: 1.2;">
                        @if(Auth::check()) {{ Auth::user()->name }} @else Mehmon @endif
                    </span>
                    <span class="text-muted" style="font-size: 0.72rem;">
                        @if(Auth::check())
                            @if(Auth::user()->role === 'director') Direktor
                            @elseif(Auth::user()->role === 'deputy') O‘rinbosar
                            @elseif(Auth::user()->role === 'teacher') O‘qituvchi
                            @else Foydalanuvchi @endif
                        @else Mehmon @endif
                    </span>
                </div>
            </a>

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-modern mt-2" style="min-width: 240px;">
                @if(Auth::check())
                    <li class="px-3 py-2 border-bottom mb-2 bg-light rounded-3">
                        <div class="fw-bold text-dark" style="font-size: 0.95rem;">{{ Auth::user()->name }}</div>
                        <div class="mt-1">
                            <span class="role-badge @if(Auth::user()->role === 'director') director @elseif(Auth::user()->role === 'deputy') deputy @elseif(Auth::user()->role === 'teacher') teacher @else user @endif">
                                @if(Auth::user()->role === 'director') Direktor
                                @elseif(Auth::user()->role === 'deputy') Direktor o‘rinbosari
                                @elseif(Auth::user()->role === 'teacher') O‘qituvchi
                                @else Foydalanuvchi @endif
                            </span>
                        </div>
                    </li>
                @endif
                <li>
                    <a class="dropdown-item" href="{{ route('profil') }}">
                        <i class="bi bi-person text-primary"></i> <span>Mening profilim</span>
                    </a>
                </li>
                <li><hr class="dropdown-divider my-1"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right"></i> <span>Tizimdan chiqish</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
</header>

{{-- MODERN SIDEBAR --}}
<aside id="sidebar" class="modern-sidebar">
    <ul class="nav flex-column" id="sidebar-nav">

        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>

        {{-- DIRECTOR & DEPUTY SECTION --}}
        @if(Auth::check() && in_array(Auth::user()->role, ['director', 'deputy']))
            <div class="nav-section-title">Boshqaruv Paneli</div>

            {{-- O'quvchilar --}}
            <li class="nav-item">
                <a href="#oquvchilar-menu"
                   class="nav-link {{ request()->routeIs('oquvchilar.*') ? 'active' : '' }}"
                   data-bs-toggle="collapse"
                   aria-expanded="{{ request()->routeIs('oquvchilar.*') ? 'true' : 'false' }}">
                    <i class="bi bi-people-fill"></i>
                    <span>O‘quvchilar</span>
                    <i class="bi bi-chevron-down ms-auto" style="font-size: 0.8rem;"></i>
                </a>
                <ul id="oquvchilar-menu" class="nav-content collapse {{ request()->routeIs('oquvchilar.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('oquvchilar.index') }}" class="{{ request()->routeIs('oquvchilar.index') ? 'active' : '' }}">
                            <i class="bi bi-circle-fill"></i><span>Barcha o‘quvchilar</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('oquvchilar.create') }}" class="{{ request()->routeIs('oquvchilar.create') ? 'active' : '' }}">
                            <i class="bi bi-circle-fill"></i><span>O‘quvchi qo‘shish</span>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Sinflar --}}
            <li class="nav-item">
                <a href="#sinflar-menu"
                   class="nav-link {{ request()->routeIs('sinflar.*') ? 'active' : '' }}"
                   data-bs-toggle="collapse"
                   aria-expanded="{{ request()->routeIs('sinflar.*') ? 'true' : 'false' }}">
                    <i class="bi bi-building-fill"></i>
                    <span>Sinflar</span>
                    <i class="bi bi-chevron-down ms-auto" style="font-size: 0.8rem;"></i>
                </a>
                <ul id="sinflar-menu" class="nav-content collapse {{ request()->routeIs('sinflar.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('sinflar.index') }}" class="{{ request()->routeIs('sinflar.index') ? 'active' : '' }}">
                            <i class="bi bi-circle-fill"></i><span>Barcha sinflar</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('sinflar.create') }}" class="{{ request()->routeIs('sinflar.create') ? 'active' : '' }}">
                            <i class="bi bi-circle-fill"></i><span>Sinf qo‘shish</span>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- O'qituvchilar --}}
            <li class="nav-item">
                <a href="#oqituvchilar-menu"
                   class="nav-link {{ request()->routeIs('oqituvchilar.*') ? 'active' : '' }}"
                   data-bs-toggle="collapse"
                   aria-expanded="{{ request()->routeIs('oqituvchilar.*') ? 'true' : 'false' }}">
                    <i class="bi bi-person-badge-fill"></i>
                    <span>O‘qituvchilar</span>
                    <i class="bi bi-chevron-down ms-auto" style="font-size: 0.8rem;"></i>
                </a>
                <ul id="oqituvchilar-menu" class="nav-content collapse {{ request()->routeIs('oqituvchilar.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('oqituvchilar.index') }}" class="{{ request()->routeIs('oqituvchilar.index') ? 'active' : '' }}">
                            <i class="bi bi-circle-fill"></i><span>Barcha o‘qituvchilar</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('oqituvchilar.create') }}" class="{{ request()->routeIs('oqituvchilar.create') ? 'active' : '' }}">
                            <i class="bi bi-circle-fill"></i><span>O‘qituvchi qo‘shish</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{ route('darsjadvali.index') }}" class="nav-link {{ request()->routeIs('darsjadvali.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar3"></i>
                    <span>Dars jadvali</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('kutubxona.index') }}" class="nav-link {{ request()->routeIs('kutubxona.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-bookmark-fill"></i>
                    <span>Kutubxona</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('davomat.index') }}" class="nav-link {{ request()->routeIs('davomat.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check-fill"></i>
                    <span>Davomat</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('baholar.index') }}" class="nav-link {{ request()->routeIs('baholar.*') ? 'active' : '' }}">
                    <i class="bi bi-award-fill"></i>
                    <span>Baholar</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('statistika.index') }}" class="nav-link {{ request()->routeIs('statistika.*') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-fill"></i>
                    <span>Statistika</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('reyting.index') }}" class="nav-link {{ request()->routeIs('reyting.*') ? 'active' : '' }}">
                    <i class="bi bi-trophy-fill"></i>
                    <span>O‘quvchilar reytingi</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('xabarlar.index') }}" class="nav-link {{ request()->routeIs('xabarlar.*') ? 'active' : '' }}">
                    <i class="bi bi-chat-dots-fill"></i>
                    <span>Xabarlar</span>
                </a>
            </li>

            <div class="nav-section-title">Tizim & Sozlamalar</div>

            <li class="nav-item">
                <a href="{{ route('profil') }}" class="nav-link {{ request()->routeIs('profil') ? 'active' : '' }}">
                    <i class="bi bi-person-circle"></i>
                    <span>Profil</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('sozlamalar.index') }}" class="nav-link {{ request()->routeIs('sozlamalar.*') ? 'active' : '' }}">
                    <i class="bi bi-gear-fill"></i>
                    <span>Sozlamalar</span>
                </a>
            </li>
        @endif

        {{-- TEACHER PANEL --}}
        @if(Auth::check() && Auth::user()->role === 'teacher')
            <div class="nav-section-title">O‘qituvchi Kabineti</div>

            <li class="nav-item">
                <a href="{{ route('darsjadvali.teacher') }}" class="nav-link {{ request()->routeIs('darsjadvali.teacher') ? 'active' : '' }}">
                    <i class="bi bi-calendar-range-fill"></i>
                    <span>Dars jadvalim</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('teacher.test') }}" class="nav-link {{ request()->routeIs('teacher.test') ? 'active' : '' }}">
                    <i class="bi bi-easel-fill"></i>
                    <span>Mening sinfim</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('davomat.index') }}" class="nav-link {{ request()->routeIs('davomat.*') ? 'active' : '' }}">
                    <i class="bi bi-check2-square"></i>
                    <span>Davomat olish</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('baholar.index') }}" class="nav-link {{ request()->routeIs('baholar.*') ? 'active' : '' }}">
                    <i class="bi bi-star-fill"></i>
                    <span>Baholash</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('hisobotlar.index') }}" class="nav-link {{ request()->routeIs('hisobotlar.*') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i>
                    <span>O‘tilgan darslar</span>
                </a>
            </li>
        @endif

    </ul>
</aside>

{{-- MAIN WRAPPER --}}
<div class="main-wrapper">
    <main class="content-container">

        {{-- PAGE TITLE & BREADCRUMB --}}
        @hasSection('page-title')
            <div class="pagetitle mb-4">
                <h1>@yield('page-title')</h1>
                @hasSection('breadcrumb')
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house me-1"></i> Bosh sahifa</a></li>
                            <li class="breadcrumb-item active">@yield('breadcrumb')</li>
                        </ol>
                    </nav>
                @endif
            </div>
        @endif

        {{-- NOTIFICATIONS & FLASH MESSAGES --}}
        @if(session('success'))
            <div class="alert alert-success modern-alert alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div class="flex-grow-1 fw-semibold">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger modern-alert alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-octagon-fill me-2 fs-5"></i>
                <div class="flex-grow-1 fw-semibold">{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning modern-alert alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div class="flex-grow-1 fw-semibold">{{ session('warning') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info modern-alert alert-dismissible fade show" role="alert">
                <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                <div class="flex-grow-1 fw-semibold">{{ session('info') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- PAGE CONTENT INJECTION --}}
        <div class="page-content">
            @yield('content')
        </div>

    </main>

    {{-- FOOTER --}}
    <footer class="modern-footer d-flex flex-column flex-sm-row align-items-center justify-content-between gap-2">
        <div class="fw-medium">
            &copy; {{ date('Y') }} <span class="text-primary fw-bold">Smart School</span>. Barcha huquqlar himoyalangan.
        </div>
        <div class="text-muted fw-semibold" style="font-size: 0.8rem;">
            Maktab Boshqaruv Platformasi v2.0
        </div>
    </footer>
</div>

{{-- BACK TO TOP --}}
<a href="#" class="back-to-top-modern" id="back-to-top">
    <i class="bi bi-arrow-up-short fs-4"></i>
</a>

{{-- SCRIPTS --}}
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

{{-- MODERN INTERACTIVE JS --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('toggle-sidebar-btn');
        const overlay = document.getElementById('sidebar-overlay');
        const backToTop = document.getElementById('back-to-top');

        // Sidebar Toggle logic (Desktop & Mobile)
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function (e) {
                e.preventDefault();
                if (window.innerWidth < 1200) {
                    document.body.classList.toggle('sidebar-open');
                } else {
                    document.body.classList.toggle('sidebar-collapsed');
                }
            });
        }

        // Close sidebar when clicking backdrop on mobile
        if (overlay) {
            overlay.addEventListener('click', function () {
                document.body.classList.remove('sidebar-open');
            });
        }

        // Back to top scroll observer
        window.addEventListener('scroll', function () {
            if (window.scrollY > 280) {
                backToTop.classList.add('active');
            } else {
                backToTop.classList.remove('active');
            }
        });

        if (backToTop) {
            backToTop.addEventListener('click', function (e) {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    });
</script>

@stack('scripts')

</body>
</html>
