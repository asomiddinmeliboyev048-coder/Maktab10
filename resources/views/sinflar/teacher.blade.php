@extends('layouts.app')

@section('title', 'Mening sinfim')

@section('page-title', 'Mening sinfim')

@section('breadcrumb', 'Mening sinfim')

@section('content')

<div class="container-fluid">

    {{-- =========================================================
         O'QITUVCHIGA SINF BIRIKTIRILMAGAN
    ========================================================== --}}

    @if(!$sinf)

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center py-5">

                <div class="mb-3">

                    <i
                        class="bi bi-building"
                        style="font-size:70px;color:#adb5bd;"
                    ></i>

                </div>

                <h4 class="fw-bold">
                    Sizga hali sinf biriktirilmagan
                </h4>

                <p class="text-muted mb-0">

                    Direktor sizga sinf rahbarligini biriktirgandan
                    so‘ng shu yerda sinf ma’lumotlari ko‘rinadi.

                </p>

            </div>

        </div>

        @return

    @endif


    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">

                <i class="bi bi-building text-primary me-2"></i>

                {{ $sinf->name }}

            </h4>

            <p class="text-muted mb-0">

                Sizga biriktirilgan sinf

            </p>

        </div>


        <div>

            <span class="badge bg-primary fs-6 px-3 py-2">

                <i class="bi bi-people me-1"></i>

                {{ $sinf->oquvchilar_count }} nafar o‘quvchi

            </span>

        </div>

    </div>


    {{-- =========================================================
         STATISTICS
    ========================================================== --}}

    <div class="row g-3 mb-4">

        {{-- SINFLAR --}}

        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div
                            class="rounded-circle bg-primary bg-opacity-10
                            d-flex align-items-center justify-content-center me-3"
                            style="width:52px;height:52px;"
                        >

                            <i
                                class="bi bi-building text-primary fs-4"
                            ></i>

                        </div>

                        <div>

                            <div class="text-muted small">
                                Sinf
                            </div>

                            <div class="fw-bold fs-5">
                                {{ $sinf->name }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- O'QUVCHILAR --}}

        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div
                            class="rounded-circle bg-success bg-opacity-10
                            d-flex align-items-center justify-content-center me-3"
                            style="width:52px;height:52px;"
                        >

                            <i
                                class="bi bi-people text-success fs-4"
                            ></i>

                        </div>

                        <div>

                            <div class="text-muted small">
                                O‘quvchilar
                            </div>

                            <div class="fw-bold fs-5">
                                {{ $sinf->oquvchilar_count }} ta
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- FAN --}}

        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div
                            class="rounded-circle bg-info bg-opacity-10
                            d-flex align-items-center justify-content-center me-3"
                            style="width:52px;height:52px;"
                        >

                            <i
                                class="bi bi-book text-info fs-4"
                            ></i>

                        </div>

                        <div>

                            <div class="text-muted small">
                                Asosiy fan
                            </div>

                            <div class="fw-bold fs-6">

                                {{ $sinf->subject ?: 'Belgilanmagan' }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- XONA --}}

        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div
                            class="rounded-circle bg-warning bg-opacity-10
                            d-flex align-items-center justify-content-center me-3"
                            style="width:52px;height:52px;"
                        >

                            <i
                                class="bi bi-door-open text-warning fs-4"
                            ></i>

                        </div>

                        <div>

                            <div class="text-muted small">
                                Xona
                            </div>

                            <div class="fw-bold fs-6">

                                {{ $sinf->room ?: 'Belgilanmagan' }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         QUICK ACTIONS
    ========================================================== --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <h5 class="fw-bold mb-3">

                <i class="bi bi-grid me-2 text-primary"></i>

                Tezkor boshqaruv

            </h5>


            <div class="row g-3">

                {{-- DAVOMAT --}}

                <div class="col-lg-3 col-md-6">

                    <a
                        href="{{ route('davomat.index') }}"
                        class="text-decoration-none"
                    >

                        <div
                            class="border rounded p-3 h-100
                            teacher-action-card"
                        >

                            <i
                                class="bi bi-calendar-check
                                text-success fs-3"
                            ></i>

                            <h6 class="fw-bold mt-2 mb-1">
                                Davomat
                            </h6>

                            <small class="text-muted">
                                Bugungi davomatni boshqarish
                            </small>

                        </div>

                    </a>

                </div>


                {{-- BAHOLAR --}}

                <div class="col-lg-3 col-md-6">

                    <a
                        href="{{ route('baholar.index') }}"
                        class="text-decoration-none"
                    >

                        <div
                            class="border rounded p-3 h-100
                            teacher-action-card"
                        >

                            <i
                                class="bi bi-star
                                text-warning fs-3"
                            ></i>

                            <h6 class="fw-bold mt-2 mb-1">
                                Baholar
                            </h6>

                            <small class="text-muted">
                                O‘quvchilarni baholash
                            </small>

                        </div>

                    </a>

                </div>


                {{-- DARS JADVALI --}}

                <div class="col-lg-3 col-md-6">

                    <a
                        href="{{ route('dars-jadvali.index') }}"
                        class="text-decoration-none"
                    >

                        <div
                            class="border rounded p-3 h-100
                            teacher-action-card"
                        >

                            <i
                                class="bi bi-calendar3
                                text-primary fs-3"
                            ></i>

                            <h6 class="fw-bold mt-2 mb-1">
                                Dars jadvali
                            </h6>

                            <small class="text-muted">
                                Bugungi darslarni ko‘rish
                            </small>

                        </div>

                    </a>

                </div>


                {{-- O'QUVCHILAR --}}

                <div class="col-lg-3 col-md-6">

                    <a
                        href="#students"
                        class="text-decoration-none"
                    >

                        <div
                            class="border rounded p-3 h-100
                            teacher-action-card"
                        >

                            <i
                                class="bi bi-people
                                text-info fs-3"
                            ></i>

                            <h6 class="fw-bold mt-2 mb-1">
                                O‘quvchilar
                            </h6>

                            <small class="text-muted">
                                Sinf o‘quvchilarini ko‘rish
                            </small>

                        </div>

                    </a>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         SINF RAHBARI
    ========================================================== --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="d-flex align-items-center">

                <div
                    class="rounded-circle bg-primary bg-opacity-10
                    d-flex align-items-center justify-content-center me-3"
                    style="width:55px;height:55px;"
                >

                    <i
                        class="bi bi-person-badge text-primary fs-4"
                    ></i>

                </div>

                <div>

                    <div class="text-muted small">
                        Sinf rahbari
                    </div>

                    <div class="fw-bold">

                        {{ $sinf->teacher->name ?? auth()->user()->name }}

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         O'QUVCHILAR TABLE
    ========================================================== --}}

    <div
        class="card border-0 shadow-sm"
        id="students"
    >

        <div class="card-header bg-white">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h5 class="fw-bold mb-1">

                        <i class="bi bi-people text-primary me-2"></i>

                        {{ $sinf->name }} — O‘quvchilar

                    </h5>

                    <small class="text-muted">

                        Sizga biriktirilgan sinf o‘quvchilari

                    </small>

                </div>

                <span class="badge bg-primary">

                    {{ $sinf->oquvchilar_count }} ta

                </span>

            </div>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table
                    class="table table-hover align-middle mb-0"
                >

                    <thead class="table-light">

                        <tr>

                            <th class="px-4">
                                #
                            </th>

                            <th>
                                O‘quvchi
                            </th>

                            <th>
                                ST-ID
                            </th>

                            <th>
                                Telefon
                            </th>

                            <th>
                                Manzil
                            </th>

                            <th class="text-center">
                                Amallar
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse($sinf->oquvchilar as $oquvchi)

                        <tr>

                            <td class="px-4">

                                {{ $loop->iteration }}

                            </td>


                            <td>

                                <div class="d-flex align-items-center">

                                    <div
                                        class="rounded-circle
                                        bg-primary bg-opacity-10
                                        d-flex align-items-center
                                        justify-content-center me-3"
                                        style="width:40px;height:40px;"
                                    >

                                        <i
                                            class="bi bi-person text-primary"
                                        ></i>

                                    </div>

                                    <div>

                                        <div class="fw-bold">

                                            {{ $oquvchi->fio }}

                                        </div>

                                        <small class="text-muted">

                                            O‘quvchi

                                        </small>

                                    </div>

                                </div>

                            </td>


                            <td>

                                <span
                                    class="badge bg-light text-dark"
                                >

                                    {{ $oquvchi->student_id }}

                                </span>

                            </td>


                            <td>

                                {{ $oquvchi->phone ?: '—' }}

                            </td>


                            <td>

                                {{ $oquvchi->address ?: '—' }}

                            </td>


                            <td class="text-center">

                                <a
                                    href="{{ route('oquvchilar.show', $oquvchi->id) }}"
                                    class="btn btn-sm btn-outline-primary"
                                    title="O‘quvchini ko‘rish"
                                >

                                    <i class="bi bi-eye"></i>

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="text-center py-5"
                            >

                                <i
                                    class="bi bi-people"
                                    style="
                                        font-size:50px;
                                        color:#adb5bd;
                                    "
                                ></i>

                                <h5 class="text-muted mt-3">

                                    O‘quvchilar mavjud emas

                                </h5>

                                <p class="text-muted mb-0">

                                    Hozircha bu sinfga o‘quvchi
                                    biriktirilmagan.

                                </p>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     STYLE
========================================================== --}}

@push('styles')

<style>

    .teacher-action-card {

        transition:
            transform .2s ease,
            box-shadow .2s ease,
            border-color .2s ease;

        background: #ffffff;

    }


    .teacher-action-card:hover {

        transform: translateY(-3px);

        box-shadow:
            0 8px 25px rgba(0, 0, 0, .08);

        border-color: #4154f1 !important;

    }


    .teacher-action-card h6 {

        color: #212529;

    }


    .teacher-action-card small {

        line-height: 1.4;

    }


    @media (max-width: 768px) {

        .teacher-action-card {

            padding: 15px !important;

        }

    }

</style>

@endpush

@endsection