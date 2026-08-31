@extends('layouts.app')

@section('title', 'Sinfni tahrirlash')

@section('page-title', 'Sinfni tahrirlash')

@section('breadcrumb', 'Sinfni tahrirlash')

@section('content')

<div class="container-fluid">

    {{-- =========================================================
         PAGE HEADER
    ========================================================== --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">

                <i class="bi bi-pencil-square text-warning me-2"></i>

                Sinfni tahrirlash

            </h4>

            <p class="text-muted mb-0">

                {{ $sinf->name }} sinfi ma’lumotlarini o‘zgartirish

            </p>

        </div>


        <div class="d-flex gap-2">

            <a
                href="{{ route('sinflar.show', $sinf->id) }}"
                class="btn btn-outline-primary"
            >

                <i class="bi bi-eye me-1"></i>

                Ko‘rish

            </a>


            <a
                href="{{ route('sinflar.index') }}"
                class="btn btn-outline-secondary"
            >

                <i class="bi bi-arrow-left me-1"></i>

                Sinflarga qaytish

            </a>

        </div>

    </div>



    {{-- =========================================================
         VALIDATION ERRORS
    ========================================================== --}}

    @if($errors->any())

        <div
            class="alert alert-danger alert-dismissible fade show"
            role="alert"
        >

            <div class="d-flex">

                <div class="me-3">

                    <i
                        class="bi bi-exclamation-triangle-fill"
                        style="font-size:22px;"
                    ></i>

                </div>


                <div>

                    <strong>
                        Ma’lumotlarni tekshiring!
                    </strong>


                    <ul class="mb-0 mt-2">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>


            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif



    {{-- =========================================================
         SESSION ERROR
    ========================================================== --}}

    @if(session('error'))

        <div
            class="alert alert-danger alert-dismissible fade show"
            role="alert"
        >

            <i class="bi bi-exclamation-triangle me-2"></i>

            {{ session('error') }}


            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif



    {{-- =========================================================
         MAIN ROW
    ========================================================== --}}

    <div class="row">

        {{-- =====================================================
             EDIT FORM
        ====================================================== --}}

        <div class="col-xl-8 col-lg-10">

            <div class="card border-0 shadow-sm">

                {{-- CARD HEADER --}}

                <div class="card-header bg-white py-3">

                    <div class="d-flex align-items-center">

                        <div
                            class="rounded-circle bg-warning bg-opacity-10
                                   d-flex align-items-center justify-content-center me-3"
                            style="width:45px;height:45px;"
                        >

                            <i
                                class="bi bi-pencil-square text-warning"
                                style="font-size:22px;"
                            ></i>

                        </div>


                        <div>

                            <h5 class="card-title mb-0 fw-bold">

                                {{ $sinf->name }}

                            </h5>


                            <small class="text-muted">

                                Sinf ma’lumotlarini tahrirlash

                            </small>

                        </div>

                    </div>

                </div>



                {{-- CARD BODY --}}

                <div class="card-body p-4">

                    <form
                        method="POST"
                        action="{{ route('sinflar.update', $sinf->id) }}"
                    >

                        @csrf

                        @method('PUT')



                        {{-- =================================================
                             SINF NOMI
                        ================================================== --}}

                        <div class="mb-4">

                            <label
                                for="name"
                                class="form-label fw-semibold"
                            >

                                Sinf nomi

                                <span class="text-danger">
                                    *
                                </span>

                            </label>


                            <div class="input-group">

                                <span class="input-group-text bg-light">

                                    <i class="bi bi-building"></i>

                                </span>


                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $sinf->name) }}"
                                    placeholder="Masalan: 5-A"
                                    maxlength="50"
                                    autocomplete="off"
                                    required
                                >

                            </div>


                            @error('name')

                                <div class="text-danger small mt-1">

                                    <i class="bi bi-exclamation-circle me-1"></i>

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- =================================================
                             SINF RAHBARI
                        ================================================== --}}

                        <div class="mb-4">

                            <label
                                for="teacher_id"
                                class="form-label fw-semibold"
                            >

                                Sinf rahbari

                                <span class="text-danger">
                                    *
                                </span>

                            </label>


                            <div class="input-group">

                                <span class="input-group-text bg-light">

                                    <i class="bi bi-person-badge"></i>

                                </span>


                                <select
                                    id="teacher_id"
                                    name="teacher_id"
                                    class="form-select @error('teacher_id') is-invalid @enderror"
                                    required
                                >

                                    <option value="">

                                        — Sinf rahbarini tanlang —

                                    </option>


                                    @forelse($teachers as $teacher)

                                        <option
                                            value="{{ $teacher->id }}"
                                            {{ old('teacher_id', $sinf->teacher_id) == $teacher->id ? 'selected' : '' }}
                                        >

                                            {{ $teacher->name }}

                                            @if(!empty($teacher->email))

                                                — {{ $teacher->email }}

                                            @endif

                                        </option>

                                    @empty

                                        <option
                                            value=""
                                            disabled
                                        >

                                            Hozircha o‘qituvchilar mavjud emas

                                        </option>

                                    @endforelse

                                </select>

                            </div>


                            @error('teacher_id')

                                <div class="text-danger small mt-1">

                                    <i class="bi bi-exclamation-circle me-1"></i>

                                    {{ $message }}

                                </div>

                            @enderror


                            <div class="form-text">

                                Ushbu sinfga mas’ul bo‘lgan o‘qituvchini tanlang.

                            </div>

                        </div>



                        {{-- =================================================
                             FAN
                        ================================================== --}}

                        <div class="mb-4">

                            <label
                                for="subject"
                                class="form-label fw-semibold"
                            >

                                Asosiy fan

                                <span class="text-muted">
                                    (ixtiyoriy)
                                </span>

                            </label>


                            <div class="input-group">

                                <span class="input-group-text bg-light">

                                    <i class="bi bi-book"></i>

                                </span>


                                <input
                                    type="text"
                                    id="subject"
                                    name="subject"
                                    class="form-control @error('subject') is-invalid @enderror"
                                    value="{{ old('subject', $sinf->subject) }}"
                                    placeholder="Masalan: Matematika"
                                    maxlength="255"
                                >

                            </div>


                            @error('subject')

                                <div class="text-danger small mt-1">

                                    <i class="bi bi-exclamation-circle me-1"></i>

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- =================================================
                             XONA
                        ================================================== --}}

                        <div class="mb-4">

                            <label
                                for="room"
                                class="form-label fw-semibold"
                            >

                                Xona

                                <span class="text-muted">
                                    (ixtiyoriy)
                                </span>

                            </label>


                            <div class="input-group">

                                <span class="input-group-text bg-light">

                                    <i class="bi bi-door-open"></i>

                                </span>


                                <input
                                    type="text"
                                    id="room"
                                    name="room"
                                    class="form-control @error('room') is-invalid @enderror"
                                    value="{{ old('room', $sinf->room) }}"
                                    placeholder="Masalan: 203-xona"
                                    maxlength="100"
                                >

                            </div>


                            @error('room')

                                <div class="text-danger small mt-1">

                                    <i class="bi bi-exclamation-circle me-1"></i>

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- =================================================
                             CURRENT INFORMATION
                        ================================================== --}}

                        <div class="alert alert-light border mb-4">

                            <div class="d-flex align-items-start">

                                <i
                                    class="bi bi-info-circle text-primary me-3"
                                    style="font-size:21px;"
                                ></i>


                                <div>

                                    <strong>
                                        Joriy ma’lumot
                                    </strong>


                                    <div class="small text-muted mt-1">

                                        Ushbu sinfda hozirda

                                        <strong class="text-dark">

                                            {{ $sinf->oquvchilar_count ?? $sinf->oquvchilar()->count() }}

                                        </strong>

                                        ta o‘quvchi mavjud.

                                    </div>

                                </div>

                            </div>

                        </div>



                        {{-- =================================================
                             BUTTONS
                        ================================================== --}}

                        <div class="d-flex justify-content-between align-items-center">

                            <a
                                href="{{ route('sinflar.index') }}"
                                class="btn btn-light border"
                            >

                                <i class="bi bi-x-circle me-1"></i>

                                Bekor qilish

                            </a>


                            <button
                                type="submit"
                                class="btn btn-primary"
                            >

                                <i class="bi bi-check-circle me-1"></i>

                                O‘zgarishlarni saqlash

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>



        {{-- =====================================================
             INFORMATION SIDEBAR
        ====================================================== --}}

        <div class="col-xl-4 col-lg-10 mt-4 mt-xl-0">

            {{-- CURRENT CLASS CARD --}}

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-body p-4">

                    <div class="text-center mb-3">

                        <div
                            class="rounded-circle bg-primary bg-opacity-10
                                   d-inline-flex align-items-center justify-content-center"
                            style="width:80px;height:80px;"
                        >

                            <i
                                class="bi bi-building text-primary"
                                style="font-size:38px;"
                            ></i>

                        </div>

                    </div>


                    <h5 class="fw-bold text-center mb-1">

                        {{ $sinf->name }}

                    </h5>


                    <p class="text-muted text-center small mb-4">

                        Sinf ID: #{{ $sinf->id }}

                    </p>


                    <hr>


                    {{-- TEACHER --}}

                    <div class="d-flex align-items-center mb-3">

                        <div
                            class="rounded-circle bg-light
                                   d-flex align-items-center justify-content-center me-3"
                            style="width:40px;height:40px;"
                        >

                            <i class="bi bi-person-badge text-primary"></i>

                        </div>


                        <div>

                            <small class="text-muted d-block">

                                Sinf rahbari

                            </small>


                            <span class="fw-semibold">

                                @if($sinf->teacher)

                                    {{ $sinf->teacher->name }}

                                @else

                                    Biriktirilmagan

                                @endif

                            </span>

                        </div>

                    </div>



                    {{-- SUBJECT --}}

                    <div class="d-flex align-items-center mb-3">

                        <div
                            class="rounded-circle bg-light
                                   d-flex align-items-center justify-content-center me-3"
                            style="width:40px;height:40px;"
                        >

                            <i class="bi bi-book text-primary"></i>

                        </div>


                        <div>

                            <small class="text-muted d-block">

                                Fan

                            </small>


                            <span class="fw-semibold">

                                {{ $sinf->subject ?: 'Belgilanmagan' }}

                            </span>

                        </div>

                    </div>



                    {{-- ROOM --}}

                    <div class="d-flex align-items-center mb-3">

                        <div
                            class="rounded-circle bg-light
                                   d-flex align-items-center justify-content-center me-3"
                            style="width:40px;height:40px;"
                        >

                            <i class="bi bi-door-open text-primary"></i>

                        </div>


                        <div>

                            <small class="text-muted d-block">

                                Xona

                            </small>


                            <span class="fw-semibold">

                                {{ $sinf->room ?: 'Belgilanmagan' }}

                            </span>

                        </div>

                    </div>



                    {{-- STUDENTS --}}

                    <div class="d-flex align-items-center">

                        <div
                            class="rounded-circle bg-light
                                   d-flex align-items-center justify-content-center me-3"
                            style="width:40px;height:40px;"
                        >

                            <i class="bi bi-people text-primary"></i>

                        </div>


                        <div>

                            <small class="text-muted d-block">

                                O‘quvchilar

                            </small>


                            <span class="fw-semibold">

                                {{ $sinf->oquvchilar_count ?? $sinf->oquvchilar()->count() }}
                                ta

                            </span>

                        </div>

                    </div>

                </div>

            </div>



            {{-- WARNING CARD --}}

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    <div class="d-flex align-items-start">

                        <i
                            class="bi bi-shield-check text-success me-3"
                            style="font-size:25px;"
                        ></i>


                        <div>

                            <h6 class="fw-bold mb-2">

                                Sinf ma’lumotlari

                            </h6>


                            <p class="small text-muted mb-0">

                                O‘zgarishlarni saqlashdan oldin
                                ma’lumotlarni tekshirib chiqing.
                                Sinf rahbari o‘zgartirilsa,
                                ushbu sinfga kiruvchi o‘qituvchi
                                ham o‘zgaradi.

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection