@extends('layouts.app')

@section('title', 'O‘quvchini tahrirlash')

@section('content')

<div class="pagetitle">

    <h1>O‘quvchini tahrirlash</h1>

    <nav>
        <ol class="breadcrumb">

            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Bosh sahifa
                </a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('oquvchilar.index') }}">
                    O‘quvchilar
                </a>
            </li>

            <li class="breadcrumb-item active">
                Tahrirlash
            </li>

        </ol>
    </nav>

</div>


<section class="section">

    <div class="row justify-content-center">

        <div class="col-lg-9">

            <div class="card">

                <div class="card-body">

                    <h5 class="card-title">

                        <i class="bi bi-pencil-square me-2"></i>

                        O‘quvchi ma’lumotlarini tahrirlash

                    </h5>

                    <p class="text-muted">
                        O‘quvchining ma’lumotlarini yangilang.
                    </p>


                    {{-- VALIDATSIYA XATOLARI --}}

                    @if($errors->any())

                        <div class="alert alert-danger">

                            <div class="d-flex align-items-center mb-2">

                                <i class="bi bi-exclamation-triangle me-2"></i>

                                <strong>
                                    Ma’lumotlarni tekshiring
                                </strong>

                            </div>

                            <ul class="mb-0">

                                @foreach($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    {{-- MUVAFFAQIYAT XABARI --}}

                    @if(session('success'))

                        <div class="alert alert-success">

                            <i class="bi bi-check-circle me-2"></i>

                            {{ session('success') }}

                        </div>

                    @endif


                    <form
                        action="{{ route('oquvchilar.update', $oquvchi->id) }}"
                        method="POST"
                        class="row g-3"
                    >

                        @csrf

                        @method('PUT')


                        {{-- STUDENT ID --}}

                        <div class="col-md-6">

                            <label class="form-label">
                                O‘quvchi ID
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    <i class="bi bi-person-badge"></i>
                                </span>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="{{ $oquvchi->student_id }}"
                                    readonly
                                >

                            </div>

                            <div class="form-text">
                                O‘quvchi ID tizim tomonidan yaratilgan.
                            </div>

                        </div>


                        {{-- SINFLAR --}}

                        <div class="col-md-6">

                            <label
                                for="sinf_id"
                                class="form-label"
                            >
                                Sinf <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    <i class="bi bi-building"></i>
                                </span>

                                <select
                                    id="sinf_id"
                                    name="sinf_id"
                                    class="form-select @error('sinf_id') is-invalid @enderror"
                                    required
                                >

                                    <option value="">
                                        — Sinfni tanlang —
                                    </option>

                                    @foreach($sinflar as $sinf)

                                        <option
                                            value="{{ $sinf->id }}"
                                            {{ old('sinf_id', $oquvchi->sinf_id) == $sinf->id ? 'selected' : '' }}
                                        >

                                            {{ $sinf->name }}

                                            @if($sinf->room)
                                                — Xona {{ $sinf->room }}
                                            @endif

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            @error('sinf_id')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- F.I.O --}}

                        <div class="col-md-12">

                            <label
                                for="fio"
                                class="form-label"
                            >
                                F.I.O <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    <i class="bi bi-person"></i>
                                </span>

                                <input
                                    type="text"
                                    id="fio"
                                    name="fio"
                                    class="form-control @error('fio') is-invalid @enderror"
                                    value="{{ old('fio', $oquvchi->fio) }}"
                                    placeholder="O‘quvchining to‘liq F.I.O.si"
                                    required
                                >

                            </div>

                            @error('fio')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- TELEFON --}}

                        <div class="col-md-6">

                            <label
                                for="phone"
                                class="form-label"
                            >
                                Telefon
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    <i class="bi bi-telephone"></i>
                                </span>

                                <input
                                    type="text"
                                    id="phone"
                                    name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $oquvchi->phone) }}"
                                    placeholder="+998 90 123 45 67"
                                >

                            </div>

                            @error('phone')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- MANZIL --}}

                        <div class="col-md-6">

                            <label
                                for="address"
                                class="form-label"
                            >
                                Manzil
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    <i class="bi bi-geo-alt"></i>
                                </span>

                                <textarea
                                    id="address"
                                    name="address"
                                    rows="1"
                                    class="form-control @error('address') is-invalid @enderror"
                                    placeholder="Yashash manzili"
                                >{{ old('address', $oquvchi->address) }}</textarea>

                            </div>

                            @error('address')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- INFO --}}

                        <div class="col-12">

                            <div class="alert alert-info">

                                <i class="bi bi-info-circle me-2"></i>

                                <strong>{{ $oquvchi->student_id }}</strong>
                                o‘quvchi IDsi o‘zgartirilmaydi.

                            </div>

                        </div>


                        {{-- BUTTONS --}}

                        <div class="col-12">

                            <hr>

                            <div class="d-flex justify-content-end gap-2">

                                <a
                                    href="{{ route('oquvchilar.show', $oquvchi->id) }}"
                                    class="btn btn-info"
                                >

                                    <i class="bi bi-eye me-1"></i>

                                    Ko‘rish

                                </a>


                                <a
                                    href="{{ url()->previous() }}"
                                    class="btn btn-secondary"
                                >

                                    <i class="bi bi-arrow-left me-1"></i>

                                    Bekor qilish

                                </a>


                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >

                                    <i class="bi bi-check-circle me-1"></i>

                                    Saqlash

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection