@extends('layouts.app')

@section('title', 'O‘qituvchini tahrirlash')

@section('content')

<div class="pagetitle">

    <h1>O‘qituvchini tahrirlash</h1>

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

                        Xodim ma’lumotlarini tahrirlash

                    </h5>


                    {{-- XATOLAR --}}

                    @if($errors->any())

                        <div class="alert alert-danger">

                            <strong>
                                Ma’lumotlarda xatolik mavjud:
                            </strong>

                            <ul class="mb-0 mt-2">

                                @foreach($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    <form
                        action="{{ route('oqituvchilar.update', $oqituvchi->id) }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="row g-3"
                    >

                        @csrf

                        @method('PUT')


                        {{-- XODIM ID --}}

                        <div class="col-md-6">

                            <label class="form-label">
                                Xodim ID
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    <i class="bi bi-person-badge"></i>
                                </span>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="{{ $oqituvchi->staff_id ?? '—' }}"
                                    readonly
                                >

                            </div>

                            <div class="form-text">
                                Xodim ID tizim tomonidan avtomatik yaratilgan.
                            </div>

                        </div>


                        {{-- ISM --}}

                        <div class="col-md-6">

                            <label
                                for="name"
                                class="form-label"
                            >
                                To‘liq ism
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    <i class="bi bi-person"></i>
                                </span>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $oqituvchi->name) }}"
                                    required
                                >

                            </div>

                            @error('name')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- EMAIL --}}

                        <div class="col-md-6">

                            <label
                                for="email"
                                class="form-label"
                            >
                                Email
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    <i class="bi bi-envelope"></i>
                                </span>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $oqituvchi->email) }}"
                                    required
                                >

                            </div>

                            @error('email')

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
                                    value="{{ old('phone', $oqituvchi->phone) }}"
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
                                >{{ old('address', $oqituvchi->address) }}</textarea>

                            </div>

                            @error('address')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- FAN --}}

                        <div class="col-md-6">

                            <label
                                for="subject"
                                class="form-label"
                            >
                                Fan
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    <i class="bi bi-book"></i>
                                </span>

                                <input
                                    type="text"
                                    id="subject"
                                    name="subject"
                                    class="form-control @error('subject') is-invalid @enderror"
                                    value="{{ old('subject', $oqituvchi->subject) }}"
                                    placeholder="Masalan: Matematika"
                                >

                            </div>

                            @error('subject')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- ROL --}}

                        <div class="col-md-6">

                            <label
                                for="role"
                                class="form-label"
                            >
                                Rol
                            </label>

                            <select
                                id="role"
                                name="role"
                                class="form-select @error('role') is-invalid @enderror"
                                required
                            >

                                <option
                                    value="teacher"
                                    {{ old('role', $oqituvchi->role) == 'teacher' ? 'selected' : '' }}
                                >
                                    O‘qituvchi
                                </option>

                                <option
                                    value="deputy"
                                    {{ old('role', $oqituvchi->role) == 'deputy' ? 'selected' : '' }}
                                >
                                    Direktor o‘rinbosari
                                </option>

                            </select>

                            <div class="form-text">
                                Rol o‘zgartirilsa, Xodim ID ham yangi rolga mos ravishda qayta yaratiladi.
                            </div>

                            @error('role')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- YANGI PAROL --}}

                        <div class="col-md-6">

                            <label
                                for="password"
                                class="form-label"
                            >
                                Yangi parol
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="O‘zgartirmoqchi bo‘lsangiz kiriting"
                                >

                            </div>

                            <div class="form-text">
                                Bo‘sh qoldirsangiz eski parol saqlanadi.
                            </div>

                            @error('password')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- PAROL TASDIQLASH --}}

                        <div class="col-md-6">

                            <label
                                for="password_confirmation"
                                class="form-label"
                            >
                                Yangi parolni tasdiqlash
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    <i class="bi bi-lock-fill"></i>
                                </span>

                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    class="form-control"
                                    placeholder="Yangi parolni qayta kiriting"
                                >

                            </div>

                        </div>


                        {{-- AVATAR --}}

                        <div class="col-md-12">

                            <label
                                for="avatar"
                                class="form-label"
                            >
                                Profil rasmi
                            </label>


                            @if($oqituvchi->avatar)

                                <div class="mb-3">

                                    <img
                                        src="{{ asset('storage/' . $oqituvchi->avatar) }}"
                                        alt="{{ $oqituvchi->name }}"
                                        class="rounded-circle"
                                        width="100"
                                        height="100"
                                        style="object-fit: cover;"
                                    >

                                </div>

                            @endif


                            <input
                                type="file"
                                id="avatar"
                                name="avatar"
                                class="form-control @error('avatar') is-invalid @enderror"
                                accept="image/jpeg,image/png,image/jpg"
                            >

                            <div class="form-text">
                                Yangi rasm tanlasangiz eski rasm almashtiriladi.
                            </div>

                            @error('avatar')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- MA'LUMOT --}}

                        <div class="col-12">

                            <div class="alert alert-warning">

                                <i class="bi bi-shield-lock me-2"></i>

                                Parolni o‘zgartirmoqchi bo‘lmasangiz,
                                <strong>Yangi parol</strong> maydonini bo‘sh qoldiring.

                            </div>

                        </div>


                        {{-- BUTTONS --}}

                        <div class="col-12">

                            <hr>

                            <div class="d-flex justify-content-end gap-2">

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