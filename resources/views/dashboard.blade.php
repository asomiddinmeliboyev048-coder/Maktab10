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