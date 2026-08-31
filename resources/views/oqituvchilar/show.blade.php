@extends('layouts.app')

@section('title', 'O‘qituvchi maʼlumotlari')

@section('content')

<div class="pagetitle">

    <h1>O‘qituvchi maʼlumotlari</h1>

    <nav>
        <ol class="breadcrumb">

            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Bosh sahifa
                </a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('oqituvchilar.index') }}">
                    O‘qituvchilar
                </a>
            </li>

            <li class="breadcrumb-item active">
                Maʼlumotlari
            </li>

        </ol>
    </nav>

</div>


<section class="section">

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show" role="alert">

            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

        </div>

    @endif


    <div class="row">


        {{-- =====================================================
             LEFT CARD
        ====================================================== --}}

        <div class="col-lg-4 mb-4">

            <div class="card">

                <div class="card-body text-center p-4">

                    @if($oqituvchi->avatar)

                        <img
                            src="{{ asset('storage/' . $oqituvchi->avatar) }}"
                            alt="{{ $oqituvchi->name }}"
                            class="rounded-circle mb-3"
                            width="110"
                            height="110"
                            style="object-fit:cover;"
                        >

                    @else

                        <div
                            class="mx-auto mb-3 rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                            style="width:110px;height:110px;"
                        >

                            <i
                                class="bi bi-person-fill text-primary"
                                style="font-size:55px;"
                            ></i>

                        </div>

                    @endif


                    <h4 class="fw-bold mb-1">
                        {{ $oqituvchi->name }}
                    </h4>


                    <div class="mb-3">

                        <span class="badge bg-light text-dark border">

                            <i class="bi bi-person-badge me-1"></i>

                            {{ $oqituvchi->staff_id ?? '—' }}

                        </span>

                    </div>


                    <div class="mb-3">

                        @if($oqituvchi->role === 'deputy')

                            <span class="badge bg-primary px-3 py-2">
                                Direktor o‘rinbosari
                            </span>

                        @else

                            <span class="badge bg-info text-white px-3 py-2">
                                O‘qituvchi
                            </span>

                        @endif

                    </div>


                    <hr>


                    <div class="text-start">

                        <div class="d-flex align-items-center mb-3">

                            <div
                                class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3"
                                style="width:40px;height:40px;"
                            >
                                <i class="bi bi-envelope text-primary"></i>
                            </div>

                            <div>
                                <small class="text-muted d-block">Email</small>
                                <span class="fw-semibold">{{ $oqituvchi->email }}</span>
                            </div>

                        </div>


                        <div class="d-flex align-items-center mb-3">

                            <div
                                class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3"
                                style="width:40px;height:40px;"
                            >
                                <i class="bi bi-telephone text-success"></i>
                            </div>

                            <div>
                                <small class="text-muted d-block">Telefon</small>
                                <span class="fw-semibold">{{ $oqituvchi->phone ?: 'Ko‘rsatilmagan' }}</span>
                            </div>

                        </div>


                        <div class="d-flex align-items-center">

                            <div
                                class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3"
                                style="width:40px;height:40px;"
                            >
                                <i class="bi bi-geo-alt text-info"></i>
                            </div>

                            <div>
                                <small class="text-muted d-block">Manzil</small>
                                <span class="fw-semibold">{{ $oqituvchi->address ?: 'Ko‘rsatilmagan' }}</span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
             RIGHT CARD
        ====================================================== --}}

        <div class="col-lg-8 mb-4">

            <div class="card">

                <div class="card-body p-4">

                    <h5 class="card-title mb-4">

                        <i class="bi bi-info-circle text-primary me-2"></i>

                        Batafsil maʼlumot

                    </h5>


                    <div class="row">

                        <div class="col-md-6 mb-4">

                            <div class="text-muted small mb-1">Fan</div>

                            <div class="fw-semibold fs-6">
                                {{ $oqituvchi->subject ?: 'Belgilanmagan' }}
                            </div>

                        </div>


                        <div class="col-md-6 mb-4">

                            <div class="text-muted small mb-1">Ro‘yxatga olingan sana</div>

                            <div class="fw-semibold">
                                {{ $oqituvchi->created_at ? $oqituvchi->created_at->format('d.m.Y H:i') : '—' }}
                            </div>

                        </div>

                    </div>


                    {{-- DARS JADVALI --}}

                    @if(class_exists(\App\DarsJadvali::class))

                        @php

                            $darsJadvali = \App\DarsJadvali::where('oqituvchi_id', $oqituvchi->id)
                                ->with('sinf')
                                ->orderByRaw("FIELD(kun,'Dushanba','Seshanba','Chorshanba','Payshanba','Juma','Shanba','Yakshanba')")
                                ->orderBy('tartib', 'asc')
                                ->get()
                                ->groupBy('kun');

                        @endphp

                        <hr class="my-3">

                        <h6 class="fw-bold mb-3">

                            <i class="bi bi-calendar-week text-primary me-2"></i>

                            Dars jadvali

                        </h6>


                        @if($darsJadvali->count())

                            @foreach($darsJadvali as $kun => $darslar)

                                <div class="mb-3">

                                    <div class="fw-semibold text-primary mb-2">
                                        {{ $kun }}
                                    </div>

                                    <div class="table-responsive">

                                        <table class="table table-sm table-bordered mb-0">

                                            <thead class="table-light">

                                                <tr>
                                                    <th>Dars</th>
                                                    <th>Vaqti</th>
                                                    <th>Fan</th>
                                                    <th>Sinf</th>
                                                </tr>

                                            </thead>

                                            <tbody>

                                                @foreach($darslar->sortBy('tartib') as $dars)

                                                    <tr>
                                                        <td>{{ $dars->dars_raqami }}</td>
                                                        <td>{{ $dars->vaqti ?: '—' }}</td>
                                                        <td>{{ $dars->fan }}</td>
                                                        <td>
                                                            {{ $dars->sinf ? $dars->sinf->name : '—' }}
                                                        </td>
                                                    </tr>

                                                @endforeach

                                            </tbody>

                                        </table>

                                    </div>

                                </div>

                            @endforeach

                        @else

                            <p class="text-muted small mb-0">
                                Ushbu xodim uchun hozircha dars jadvali biriktirilmagan.
                            </p>

                        @endif

                    @endif

                </div>


                <div class="card-footer bg-white p-3">

                    <div class="d-flex justify-content-between align-items-center">

                        <a href="{{ route('oqituvchilar.index') }}" class="btn btn-light">
                            <i class="bi bi-arrow-left me-1"></i>
                            O‘qituvchilar ro‘yxati
                        </a>

                        <a href="{{ route('oqituvchilar.edit', $oqituvchi->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-1"></i>
                            Tahrirlash
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection