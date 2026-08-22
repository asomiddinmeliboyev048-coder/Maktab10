<!DOCTYPE html>
<html lang="uz">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Smart School | Dashboard</title>


    <!-- Bootstrap CSS -->
    <link
        href="{{ asset('admin/assets/vendor/bootstrap/css/bootstrap.min.css') }}"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        href="{{ asset('admin/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}"
        rel="stylesheet"
    >

    <!-- NiceAdmin CSS -->
    <link
        href="{{ asset('admin/assets/css/style.css') }}"
        rel="stylesheet"
    >

</head>


<body>


<!-- ========================================================= -->
<!-- HEADER -->
<!-- ========================================================= -->

<header
    id="header"
    class="header fixed-top d-flex align-items-center"
>

    <!-- Logo -->

    <div class="d-flex align-items-center justify-content-between">

        <a
            href="{{ route('dashboard') }}"
            class="logo d-flex align-items-center"
        >

            <img
                src="{{ asset('admin/assets/img/logo.png') }}"
                alt="Smart School"
            >

            <span class="d-none d-lg-block">
                Smart School
            </span>

        </a>


        <i class="bi bi-list toggle-sidebar-btn"></i>

    </div>


    <!-- Search -->

    <div class="search-bar">

        <form
            class="search-form d-flex align-items-center"
            method="GET"
            action="#"
        >

            <input
                type="text"
                name="query"
                placeholder="Qidirish..."
                title="Qidirish"
            >

            <button
                type="submit"
                title="Qidirish"
            >

                <i class="bi bi-search"></i>

            </button>

        </form>

    </div>


    <!-- Right navigation -->

    <nav class="header-nav ms-auto">

        <ul class="d-flex align-items-center">


            <!-- Notification -->

            <li class="nav-item dropdown">

                <a
                    class="nav-link nav-icon"
                    href="#"
                    data-bs-toggle="dropdown"
                >

                    <i class="bi bi-bell"></i>

                    <span class="badge bg-primary badge-number">
                        0
                    </span>

                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">

                    <li class="dropdown-header">

                        Sizda yangi bildirishnomalar mavjud

                    </li>

                    <li>

                        <hr class="dropdown-divider">

                    </li>

                    <li class="notification-item">

                        <i class="bi bi-info-circle text-primary"></i>

                        <div>

                            <h4>Tizim</h4>

                            <p>Hozircha yangi xabar yo‘q</p>

                        </div>

                    </li>

                </ul>

            </li>


            <!-- User -->

            <li class="nav-item dropdown pe-3">

                <a
                    class="nav-link nav-profile d-flex align-items-center pe-0"
                    href="#"
                    data-bs-toggle="dropdown"
                >

                    @if(Auth::user()->avatar)

                        <img
                            src="{{ asset('storage/' . Auth::user()->avatar) }}"
                            alt="Profile"
                            class="rounded-circle"
                        >

                    @else

                        <i
                            class="bi bi-person-circle"
                            style="font-size: 36px;"
                        ></i>

                    @endif


                    <span class="d-none d-md-block dropdown-toggle ps-2">

                        {{ Auth::user()->name }}

                    </span>

                </a>


                <ul
                    class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile"
                >

                    <li class="dropdown-header">

                        <h6>
                            {{ Auth::user()->name }}
                        </h6>

                        <span>

                            {{ ucfirst(Auth::user()->role) }}

                        </span>

                    </li>


                    <li>

                        <hr class="dropdown-divider">

                    </li>


                    <li>

                        <a
                            class="dropdown-item d-flex align-items-center"
                            href="#"
                        >

                            <i class="bi bi-person"></i>

                            <span>
                                Profil
                            </span>

                        </a>

                    </li>


                    <li>

                        <hr class="dropdown-divider">

                    </li>


                    <li>

                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="dropdown-item d-flex align-items-center"
                            >

                                <i class="bi bi-box-arrow-right"></i>

                                <span>
                                    Chiqish
                                </span>

                            </button>

                        </form>

                    </li>

                </ul>

            </li>

        </ul>

    </nav>

</header>


<!-- ========================================================= -->
<!-- SIDEBAR -->
<!-- ========================================================= -->

<aside
    id="sidebar"
    class="sidebar"
>

    <ul class="sidebar-nav" id="sidebar-nav">


        <!-- Dashboard -->

        <li class="nav-item">

            <a
                class="nav-link"
                href="{{ route('dashboard') }}"
            >

                <i class="bi bi-grid"></i>

                <span>
                    Dashboard
                </span>

            </a>

        </li>


        @if(Auth::user()->role === 'director')


        <!-- ================================================= -->
        <!-- DIREKTOR MENYUSI -->
        <!-- ================================================= -->


        <li class="nav-heading">
            Boshqaruv
        </li>


        <!-- O'quvchilar -->

        <li class="nav-item">

            <a
                class="nav-link collapsed"
                data-bs-target="#students-nav"
                data-bs-toggle="collapse"
                <a href="#">
            >

                <i class="bi bi-people"></i>

                <span>
                    O‘quvchilar
                </span>

                <i class="bi bi-chevron-down ms-auto"></i>

            </a>


            <ul
                id="students-nav"
                class="nav-content collapse"
                data-bs-parent="#sidebar-nav"
            >

                <li>

                    <a href="{{ route('oquvchilar.index') }}">

                        <i class="bi bi-circle"></i>

                        <span>
                            Barcha o‘quvchilar
                        </span>

                    </a>

                </li>


                <li>

                    <a href="{{ route('oquvchilar.create') }}">

                        <i class="bi bi-circle"></i>

                        <span>
                            O‘quvchi qo‘shish
                        </span>

                    </a>

                </li>

            </ul>

        </li>


        <!-- Sinflar -->

        <li class="nav-item">

            <a
                class="nav-link collapsed"
                data-bs-target="#classes-nav"
                data-bs-toggle="collapse"
                href="#"
            >

                <i class="bi bi-building"></i>

                <span>
                    Sinflar
                </span>

                <i class="bi bi-chevron-down ms-auto"></i>

            </a>


            <ul
                id="classes-nav"
                class="nav-content collapse"
                data-bs-parent="#sidebar-nav"
            >

                <li>

                    <a href="#">

                        <i class="bi bi-circle"></i>

                        <span>
                            Barcha sinflar
                        </span>

                    </a>

                </li>


                <li>

                    <a href="#">

                        <i class="bi bi-circle"></i>

                        <span>
                            Sinf qo‘shish
                        </span>

                    </a>

                </li>

            </ul>

        </li>


        <!-- O'qituvchilar -->

        <li class="nav-item">

            <a
                class="nav-link collapsed"
                data-bs-target="#teachers-nav"
                data-bs-toggle="collapse"
                href="#"
            >

                <i class="bi bi-person-badge"></i>

                <span>
                    O‘qituvchilar
                </span>

                <i class="bi bi-chevron-down ms-auto"></i>

            </a>


            <ul
                id="teachers-nav"
                class="nav-content collapse"
                data-bs-parent="#sidebar-nav"
            >

                <li>

                    <a href="#">

                        <i class="bi bi-circle"></i>

                        <span>
                            Barcha o‘qituvchilar
                        </span>

                    </a>

                </li>


                <li>

                    <a href="#">

                        <i class="bi bi-circle"></i>

                        <span>
                            O‘qituvchi qo‘shish
                        </span>

                    </a>

                </li>

            </ul>

        </li>


        <!-- Kitoblar -->

        <li class="nav-item">

            <a
                class="nav-link collapsed"
                data-bs-target="#books-nav"
                data-bs-toggle="collapse"
                href="#"
            >

                <i class="bi bi-book"></i>

                <span>
                    E-Kutubxona
                </span>

                <i class="bi bi-chevron-down ms-auto"></i>

            </a>


            <ul
                id="books-nav"
                class="nav-content collapse"
                data-bs-parent="#sidebar-nav"
            >

                <li>

                    <a href="#">

                        <i class="bi bi-circle"></i>

                        <span>
                            Kitoblar
                        </span>

                    </a>

                </li>


                <li>

                    <a href="#">

                        <i class="bi bi-circle"></i>

                        <span>
                            Berilgan kitoblar
                        </span>

                    </a>

                </li>

            </ul>

        </li>


        <!-- Hisobotlar -->

        <li class="nav-item">

            <a
                class="nav-link collapsed"
                data-bs-target="#reports-nav"
                data-bs-toggle="collapse"
                href="#"
            >

                <i class="bi bi-bar-chart"></i>

                <span>
                    Hisobotlar
                </span>

                <i class="bi bi-chevron-down ms-auto"></i>

            </a>


            <ul
                id="reports-nav"
                class="nav-content collapse"
                data-bs-parent="#sidebar-nav"
            >

                <li>

                    <a href="#">

                        <i class="bi bi-circle"></i>

                        <span>
                            Davomat statistikasi
                        </span>

                    </a>

                </li>


                <li>

                    <a href="#">

                        <i class="bi bi-circle"></i>

                        <span>
                            Baholar statistikasi
                        </span>

                    </a>

                </li>


                <li>

                    <a href="#">

                        <i class="bi bi-circle"></i>

                        <span>
                            Top o‘quvchilar
                        </span>

                    </a>

                </li>

            </ul>

        </li>


        @endif


        @if(Auth::user()->role === 'teacher')


        <!-- ================================================= -->
        <!-- O'QITUVCHI MENYUSI -->
        <!-- ================================================= -->


        <li class="nav-heading">
            O‘qituvchi
        </li>


        <li class="nav-item">

            <a
                class="nav-link"
                href="#"
            >

                <i class="bi bi-calendar-check"></i>

                <span>
                    Davomat
                </span>

            </a>

        </li>


        <li class="nav-item">

            <a
                class="nav-link"
                href="#"
            >

                <i class="bi bi-journal-check"></i>

                <span>
                    Baholar
                </span>

            </a>

        </li>


        <li class="nav-item">

            <a
                class="nav-link"
                href="#"
            >

                <i class="bi bi-chat-left-text"></i>

                <span>
                    Xabarlar
                </span>

            </a>

        </li>


        @endif


        <!-- General -->

        <li class="nav-heading">
            Tizim
        </li>


        <li class="nav-item">

            <a
                class="nav-link collapsed"
                href="#"
            >

                <i class="bi bi-person-circle"></i>

                <span>
                    Profil
                </span>

            </a>

        </li>


        <li class="nav-item">

            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="nav-link border-0 bg-transparent w-100 text-start"
                >

                    <i class="bi bi-box-arrow-right"></i>

                    <span>
                        Chiqish
                    </span>

                </button>

            </form>

        </li>


    </ul>

</aside>


<!-- ========================================================= -->
<!-- MAIN -->
<!-- ========================================================= -->

<main id="main" class="main">


    <!-- Page title -->

    <div class="pagetitle">

        <h1>
            Dashboard
        </h1>

        <nav>

            <ol class="breadcrumb">

                <li class="breadcrumb-item">
                    Bosh sahifa
                </li>

                <li class="breadcrumb-item active">
                    Dashboard
                </li>

            </ol>

        </nav>

    </div>


    <!-- Success -->

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    <!-- ===================================================== -->
    <!-- STATISTICS -->
    <!-- ===================================================== -->

    <section class="section dashboard">

        <div class="row">


            <!-- O'quvchilar -->

            <div class="col-xxl-3 col-md-6">

                <div class="card info-card customers-card">

                    <div class="card-body">

                        <h5 class="card-title">
                            O‘quvchilar
                        </h5>

                        <div class="d-flex align-items-center">

                            <div
                                class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                            >

                                <i class="bi bi-people"></i>

                            </div>

                            <div class="ps-3">

                                <h6>0</h6>

                                <span class="text-muted small pt-2 ps-1">
                                    jami o‘quvchi
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- O'qituvchilar -->

            <div class="col-xxl-3 col-md-6">

                <div class="card info-card revenue-card">

                    <div class="card-body">

                        <h5 class="card-title">
                            O‘qituvchilar
                        </h5>

                        <div class="d-flex align-items-center">

                            <div
                                class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                            >

                                <i class="bi bi-person-badge"></i>

                            </div>

                            <div class="ps-3">

                                <h6>0</h6>

                                <span class="text-muted small pt-2 ps-1">
                                    jami o‘qituvchi
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Sinflar -->

            <div class="col-xxl-3 col-md-6">

                <div class="card info-card sales-card">

                    <div class="card-body">

                        <h5 class="card-title">
                            Sinflar
                        </h5>

                        <div class="d-flex align-items-center">

                            <div
                                class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                            >

                                <i class="bi bi-building"></i>

                            </div>

                            <div class="ps-3">

                                <h6>0</h6>

                                <span class="text-muted small pt-2 ps-1">
                                    jami sinf
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Kitoblar -->

            <div class="col-xxl-3 col-md-6">

                <div class="card info-card">

                    <div class="card-body">

                        <h5 class="card-title">
                            Kitoblar
                        </h5>

                        <div class="d-flex align-items-center">

                            <div
                                class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                            >

                                <i class="bi bi-book"></i>

                            </div>

                            <div class="ps-3">

                                <h6>0</h6>

                                <span class="text-muted small pt-2 ps-1">
                                    kutubxona
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- ================================================= -->
            <!-- WELCOME -->
            <!-- ================================================= -->

            <div class="col-12">

                <div class="card">

                    <div class="card-body">

                        <h5 class="card-title">

                            Xush kelibsiz,
                            <strong>
                                {{ Auth::user()->name }}
                            </strong>

                        </h5>


                        <p>

                            Siz tizimga

                            <strong>
                                {{ Auth::user()->role === 'director' ? 'Direktor' : 'O‘qituvchi' }}
                            </strong>

                            sifatida kirdingiz.

                        </p>


                        <div class="alert alert-primary">

                            <i class="bi bi-shield-check me-2"></i>

                            Sizning hisobingiz uchun tegishli boshqaruv
                            huquqlari faollashtirilgan.

                        </div>

                    </div>

                </div>

            </div>


            <!-- ================================================= -->
            <!-- QUICK ACTIONS -->
            <!-- ================================================= -->

            @if(Auth::user()->role === 'director')

            <div class="col-lg-6">

                <div class="card">

                    <div class="card-body">

                        <h5 class="card-title">
                            Tezkor boshqaruv
                        </h5>


                        <div class="row g-3">


                            <div class="col-md-6">

                                <a
                                    href="#"
                                    class="btn btn-primary w-100"
                                >

                                    <i class="bi bi-person-plus me-1"></i>

                                    O‘quvchi qo‘shish

                                </a>

                            </div>


                            <div class="col-md-6">

                                <a
                                    href="#"
                                    class="btn btn-success w-100"
                                >

                                    <i class="bi bi-person-badge me-1"></i>

                                    O‘qituvchi qo‘shish

                                </a>

                            </div>


                            <div class="col-md-6">

                                <a
                                    href="#"
                                    class="btn btn-warning w-100"
                                >

                                    <i class="bi bi-building me-1"></i>

                                    Sinf qo‘shish

                                </a>

                            </div>


                            <div class="col-md-6">

                                <a
                                    href="#"
                                    class="btn btn-info w-100 text-white"
                                >

                                    <i class="bi bi-book me-1"></i>

                                    Kitob qo‘shish

                                </a>

                            </div>


                        </div>

                    </div>

                </div>

            </div>


            <!-- System -->

            <div class="col-lg-6">

                <div class="card">

                    <div class="card-body">

                        <h5 class="card-title">
                            Tizim holati
                        </h5>


                        <div class="activity">


                            <div class="activity-item d-flex">

                                <div class="activite-label">
                                    Hozir
                                </div>

                                <i
                                    class="bi bi-circle-fill activity-badge text-success align-self-start"
                                ></i>

                                <div class="activity-content">

                                    Tizimga muvaffaqiyatli kirildi.

                                </div>

                            </div>


                            <div class="activity-item d-flex">

                                <div class="activite-label">
                                    Hozir
                                </div>

                                <i
                                    class="bi bi-circle-fill activity-badge text-primary align-self-start"
                                ></i>

                                <div class="activity-content">

                                    Direktor paneli faol.

                                </div>

                            </div>


                            <div class="activity-item d-flex">

                                <div class="activite-label">
                                    Tayyor
                                </div>

                                <i
                                    class="bi bi-circle-fill activity-badge text-warning align-self-start"
                                ></i>

                                <div class="activity-content">

                                    O‘quvchilar moduli tayyorlanmoqda.

                                </div>

                            </div>


                        </div>

                    </div>

                </div>

            </div>

            @endif


        </div>

    </section>

</main>


<!-- ========================================================= -->
<!-- FOOTER -->
<!-- ========================================================= -->

<footer id="footer" class="footer">

    <div class="copyright">

        &copy; {{ date('Y') }}

        <strong>
            Smart School
        </strong>.

        Barcha huquqlar himoyalangan.

    </div>

</footer>


<!-- ========================================================= -->
<!-- BACK TO TOP -->
<!-- ========================================================= -->

<a
    href="#"
    class="back-to-top d-flex align-items-center justify-content-center"
>

    <i class="bi bi-arrow-up-short"></i>

</a>


<!-- Bootstrap JS -->

<script
    src="{{ asset('admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"
></script>


<!-- NiceAdmin JS -->

<script
    src="{{ asset('admin/assets/js/main.js') }}"
></script>


</body>

</html>