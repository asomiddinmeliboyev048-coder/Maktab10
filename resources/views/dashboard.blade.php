@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('breadcrumb', 'Dashboard')

@section('content')

    {{-- ===================================================== --}}
    {{-- STATISTICS --}}
    {{-- ===================================================== --}}

    <section class="section dashboard">

        <div class="row">


            {{-- O'quvchilar --}}
@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- =========================================================
         SAHIFA HEADER
    ========================================================== -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                Boshqaruv paneli
            </h4>

            <p class="text-muted mb-0">
                10Maktab tizimining umumiy holati
            </p>
        </div>

        <div class="text-muted small mt-2 mt-md-0">
            <i class="bi bi-calendar3 me-1"></i>
            {{ date('d.m.Y') }}
        </div>

    </div>


    <!-- =========================================================
         STAT KARTOCHKALAR
    ========================================================== -->
    <div class="row g-3 mb-4">

        <!-- Sinflar -->
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-3 p-3 h-100">

                <div class="d-flex align-items-center">

                    <div class="bg-primary text-white rounded p-3 me-3">
                        <i class="bi bi-journal-bookmark fs-3"></i>
                    </div>

                    <div>

                        <small class="text-muted text-uppercase fw-bold">
                            Sinflar
                        </small>

                        <h3 class="mb-0 fw-bold">
                            {{ $sinflar_soni }}
                        </h3>

                        <small class="text-muted">
                            Jami sinflar
                        </small>

                    </div>

                </div>

            </div>

        </div>


        <!-- O'quvchilar -->
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-3 p-3 h-100">

                <div class="d-flex align-items-center">

                    <div class="bg-success text-white rounded p-3 me-3">
                        <i class="bi bi-people fs-3"></i>
                    </div>

                    <div>

                        <small class="text-muted text-uppercase fw-bold">
                            O‘quvchilar
                        </small>

                        <h3 class="mb-0 fw-bold">
                            {{ $oquvchilar_soni }}
                        </h3>

                        <small class="text-muted">
                            Jami o‘quvchilar
                        </small>

                    </div>

                </div>

            </div>

        </div>


        <!-- O'qituvchilar -->
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-3 p-3 h-100">

                <div class="d-flex align-items-center">

                    <div class="bg-warning text-white rounded p-3 me-3">
                        <i class="bi bi-person-badge fs-3"></i>
                    </div>

                    <div>

                        <small class="text-muted text-uppercase fw-bold">
                            O‘qituvchilar
                        </small>

                        <h3 class="mb-0 fw-bold">
                            {{ $oqituvchilar_soni }}
                        </h3>

                        <small class="text-muted">
                            Jami o‘qituvchilar
                        </small>

                    </div>

                </div>

            </div>

        </div>


        <!-- Xonalar -->
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-3 p-3 h-100">

                <div class="d-flex align-items-center">

                    <div class="bg-info text-white rounded p-3 me-3">
                        <i class="bi bi-door-open fs-3"></i>
                    </div>

                    <div>

                        <small class="text-muted text-uppercase fw-bold">
                            Xonalar
                        </small>

                        <h3 class="mb-0 fw-bold">
                            {{ $xonalar_soni }}
                        </h3>

                        <small class="text-muted">
                            Jami xonalar
                        </small>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- =========================================================
         TEZKOR AMALLAR
    ========================================================== -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <div>
                    <h5 class="fw-bold mb-1">
                        Tezkor amallar
                    </h5>

                    <small class="text-muted">
                        Kerakli bo‘limlarga tezda o'ting
                    </small>
                </div>

            </div>


            <div class="row g-3">

                <div class="col-xl-3 col-md-6">

                    <a href="{{ route('oquvchilar.index') }}"
                       class="text-decoration-none">

                        <div class="border rounded-3 p-3 h-100">

                            <div class="d-flex align-items-center">

                                <div class="bg-success text-white rounded p-2 me-3">
                                    <i class="bi bi-person-plus fs-5"></i>
                                </div>

                                <div>
                                    <div class="fw-bold text-dark">
                                        O‘quvchilar
                                    </div>

                                    <small class="text-muted">
                                        O‘quvchilarni boshqarish
                                    </small>
                                </div>

                            </div>

                        </div>

                    </a>

                </div>


                <div class="col-xl-3 col-md-6">

                    <a href="{{ route('sinflar.index') }}"
                       class="text-decoration-none">

                        <div class="border rounded-3 p-3 h-100">

                            <div class="d-flex align-items-center">

                                <div class="bg-primary text-white rounded p-2 me-3">
                                    <i class="bi bi-building fs-5"></i>
                                </div>

                                <div>
                                    <div class="fw-bold text-dark">
                                        Sinflar
                                    </div>

                                    <small class="text-muted">
                                        Sinflarni boshqarish
                                    </small>
                                </div>

                            </div>

                        </div>

                    </a>

                </div>


                <div class="col-xl-3 col-md-6">

                    <a href="{{ route('oqituvchilar.index') }}"
                       class="text-decoration-none">

                        <div class="border rounded-3 p-3 h-100">

                            <div class="d-flex align-items-center">

                                <div class="bg-warning text-white rounded p-2 me-3">
                                    <i class="bi bi-person-badge fs-5"></i>
                                </div>

                                <div>
                                    <div class="fw-bold text-dark">
                                        O‘qituvchilar
                                    </div>

                                    <small class="text-muted">
                                        Xodimlarni boshqarish
                                    </small>
                                </div>

                            </div>

                        </div>

                    </a>

                </div>


                <div class="col-xl-3 col-md-6">

                    <a href="{{ route('darsjadvali.index') }}"
                       class="text-decoration-none">

                        <div class="border rounded-3 p-3 h-100">

                            <div class="d-flex align-items-center">

                                <div class="bg-info text-white rounded p-2 me-3">
                                    <i class="bi bi-calendar3 fs-5"></i>
                                </div>

                                <div>
                                    <div class="fw-bold text-dark">
                                        Dars jadvali
                                    </div>

                                    <small class="text-muted">
                                        Darslarni ko‘rish
                                    </small>
                                </div>

                            </div>

                        </div>

                    </a>

                </div>

            </div>

        </div>

    </div>


    <!-- =========================================================
         SO'NGGI O'QUVCHILAR
    ========================================================== -->
    <div class="card border-0 shadow-sm rounded-3">

        <div class="card-body p-4">

            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">

                <div>

                    <h5 class="fw-bold mb-1">
                        So‘nggi qo‘shilgan o‘quvchilar
                    </h5>

                    <small class="text-muted">
                        Tizimga eng so‘nggi kiritilgan o‘quvchilar
                    </small>

                </div>

                <a href="{{ route('oquvchilar.index') }}"
                   class="btn btn-sm btn-outline-primary mt-2 mt-md-0">

                    Barchasini ko‘rish
                    <i class="bi bi-arrow-right ms-1"></i>

                </a>

            </div>


            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>F.I.O</th>

                            <th>Sinfi</th>

                            <th>Telefon</th>

                            <th>Sana</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($songgi_oquvchilar as $oquvchi)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <td>

                                    <div class="d-flex align-items-center">

                                        <div class="bg-light rounded-circle p-2 me-2">
                                            <i class="bi bi-person text-primary"></i>
                                        </div>

                                        <span class="fw-bold">
                                            {{ $oquvchi->fio }}
                                        </span>

                                    </div>

                                </td>


                                <td>

                                    <span class="badge bg-primary">
                                        {{ $oquvchi->sinf_nomi }}
                                    </span>

                                </td>


                                <td>

                                    @if($oquvchi->telefon)

                                        <span>
                                            {{ $oquvchi->telefon }}
                                        </span>

                                    @else

                                        <span class="text-muted">
                                            -
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    <small class="text-muted">

                                        <i class="bi bi-calendar3 me-1"></i>

                                        {{ date('d.m.Y', strtotime($oquvchi->created_at)) }}

                                    </small>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5"
                                    class="text-center text-muted py-5">

                                    <div class="mb-2">

                                        <i class="bi bi-people fs-2"></i>

                                    </div>

                                    Hali o‘quvchilar kiritilmagan.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection
            <div class="col-xxl-3 col-md-6">

                <div class="card info-card customers-card">

                    <div class="card-body">

                        <h5 class="card-title">
                            O‘quvchilar
                        </h5>

                        <div class="d-flex align-items-center">

                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">

                                <i class="bi bi-people"></i>

                            </div>

                            <div class="ps-3">

                                <h6>{{ $oquvchilarCount ?? 0 }}</h6>

                                <span class="text-muted small pt-2 ps-1">
                                    jami o‘quvchi
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- O'qituvchilar --}}

            <div class="col-xxl-3 col-md-6">

                <div class="card info-card revenue-card">

                    <div class="card-body">

                        <h5 class="card-title">
                            O‘qituvchilar
                        </h5>

                        <div class="d-flex align-items-center">

                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">

                                <i class="bi bi-person-badge"></i>

                            </div>

                            <div class="ps-3">

                                <h6>{{ $oqituvchilarCount ?? 0 }}</h6>

                                <span class="text-muted small pt-2 ps-1">
                                    jami o‘qituvchi
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Sinflar --}}

            <div class="col-xxl-3 col-md-6">

                <div class="card info-card sales-card">

                    <div class="card-body">

                        <h5 class="card-title">
                            Sinflar
                        </h5>

                        <div class="d-flex align-items-center">

                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">

                                <i class="bi bi-building"></i>

                            </div>

                            <div class="ps-3">

                                <h6>{{ $sinflarCount ?? 0 }}</h6>

                                <span class="text-muted small pt-2 ps-1">
                                    jami sinf
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Kitoblar --}}

            <div class="col-xxl-3 col-md-6">

                <div class="card info-card">

                    <div class="card-body">

                        <h5 class="card-title">
                            Kitoblar
                        </h5>

                        <div class="d-flex align-items-center">

                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">

                                <i class="bi bi-book"></i>

                            </div>

                            <div class="ps-3">

                                <h6>{{ $kitoblarCount ?? 0 }}</h6>

                                <span class="text-muted small pt-2 ps-1">
                                    kutubxona
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- WELCOME --}}
            {{-- ================================================= --}}

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

                                @if(Auth::user()->role === 'director')

                                    Direktor

                                @elseif(Auth::user()->role === 'deputy')

                                    Direktor o‘rinbosari

                                @else

                                    O‘qituvchi

                                @endif

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


            {{-- ================================================= --}}
            {{-- QUICK ACTIONS --}}
            {{-- ================================================= --}}

            @if(in_array(Auth::user()->role, ['director', 'deputy']))

            <div class="col-lg-6">

                <div class="card">

                    <div class="card-body">

                        <h5 class="card-title">
                            Tezkor boshqaruv
                        </h5>


                        <div class="row g-3">


                            <div class="col-md-6">

                                <a href="{{ route('oquvchilar.create') }}"
                                   class="btn btn-primary w-100">

                                    <i class="bi bi-person-plus me-1"></i>

                                    O‘quvchi qo‘shish

                                </a>

                            </div>


                            <div class="col-md-6">

                                <a href="{{ route('oqituvchilar.create') }}"
                                   class="btn btn-success w-100">

                                    <i class="bi bi-person-badge me-1"></i>

                                    O‘qituvchi qo‘shish

                                </a>

                            </div>


                            <div class="col-md-6">

                                <a href="{{ route('sinflar.create') }}"
                                   class="btn btn-warning w-100">

                                    <i class="bi bi-building me-1"></i>

                                    Sinf qo‘shish

                                </a>

                            </div>


                            <div class="col-md-6">

                                <a href="{{ route('kutubxona.index') }}"
                                   class="btn btn-info w-100 text-white">

                                    <i class="bi bi-book me-1"></i>

                                    Kitob qo‘shish

                                </a>

                            </div>


                        </div>

                    </div>

                </div>

            </div>


            {{-- System --}}

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

                                <i class="bi bi-circle-fill activity-badge text-success align-self-start"></i>

                                <div class="activity-content">

                                    Tizimga muvaffaqiyatli kirildi.

                                </div>

                            </div>


                            <div class="activity-item d-flex">

                                <div class="activite-label">
                                    Hozir
                                </div>

                                <i class="bi bi-circle-fill activity-badge text-primary align-self-start"></i>

                                <div class="activity-content">

                                    Direktor paneli faol.

                                </div>

                            </div>


                            <div class="activity-item d-flex">

                                <div class="activite-label">
                                    Tayyor
                                </div>

                                <i class="bi bi-circle-fill activity-badge text-warning align-self-start"></i>

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

@endsection
