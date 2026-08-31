@extends('layouts.app')

@section('title', 'O‘qituvchi qo‘shish')

@section('content')

<div class="pagetitle">

    <h1>O‘qituvchi qo‘shish</h1>

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
                O‘qituvchi qo‘shish
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
                        <i class="bi bi-person-plus me-2"></i>
                        Yangi xodim
                    </h5>

                    <p class="text-muted">
                        Xodimning shaxsiy va ish ma’lumotlarini kiriting.
                    </p>


                    {{-- VALIDATSIYA XATOLARI --}}

                    @if($errors->any())

                        <div class="alert alert-danger">

                            <div class="d-flex align-items-center mb-2">

                                <i class="bi bi-exclamation-triangle me-2"></i>

                                <strong>
                                    Ma’lumotlarda xatolik mavjud
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


                    <form
                        action="{{ route('oqituvchilar.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="row g-3"
                    >

                        @csrf


                        {{-- ISM --}}

                        <div class="col-md-6">

                            <label
                                for="name"
                                class="form-label"
                            >
                                To‘liq ism <span class="text-danger">*</span>
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
                                    value="{{ old('name') }}"
                                    placeholder="Masalan: Aliyev Anvar"
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
                                Email <span class="text-danger">*</span>
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
                                    value="{{ old('email') }}"
                                    placeholder="teacher@example.com"
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
                                    value="{{ old('phone') }}"
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
                                >{{ old('address') }}</textarea>

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
                                    value="{{ old('subject') }}"
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
                                Rol <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    <i class="bi bi-shield-check"></i>
                                </span>

                                <select
                                    id="role"
                                    name="role"
                                    class="form-select @error('role') is-invalid @enderror"
                                    required
                                >

                                    <option
                                        value="teacher"
                                        {{ old('role', 'teacher') == 'teacher' ? 'selected' : '' }}
                                    >
                                        O‘qituvchi
                                    </option>

                                    <option
                                        value="deputy"
                                        {{ old('role') == 'deputy' ? 'selected' : '' }}
                                    >
                                        Direktor o‘rinbosari
                                    </option>

                                </select>

                            </div>

                            <div class="form-text">
                                Xodim IDsi tanlangan rolga qarab avtomatik yaratiladi (T- yoki D- prefiksi bilan).
                            </div>

                            @error('role')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- PAROL --}}

                        <div class="col-md-6">

                            <label
                                for="password"
                                class="form-label"
                            >
                                Parol <span class="text-danger">*</span>
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
                                    placeholder="Kamida 6 ta belgi"
                                    required
                                >

                            </div>

                            @error('password')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- PAROLNI TASDIQLASH --}}

                        <div class="col-md-6">

                            <label
                                for="password_confirmation"
                                class="form-label"
                            >
                                Parolni tasdiqlash
                                <span class="text-danger">*</span>
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
                                    placeholder="Parolni qayta kiriting"
                                    required
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

                            <input
                                type="file"
                                id="avatar"
                                name="avatar"
                                class="form-control @error('avatar') is-invalid @enderror"
                                accept="image/jpeg,image/png,image/jpg"
                            >

                            <div class="form-text">
                                JPG, JPEG yoki PNG format. Maksimal 2 MB.
                            </div>

                            @error('avatar')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- INFO --}}

                        <div class="col-12">

                            <div class="alert alert-info">

                                <i class="bi bi-info-circle me-2"></i>

                                Xodim tizimga ushbu
                                <strong>email va parol</strong>
                                orqali kiradi.

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

                                    <i class="bi bi-person-plus me-1"></i>

                                    Xodimni saqlash

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