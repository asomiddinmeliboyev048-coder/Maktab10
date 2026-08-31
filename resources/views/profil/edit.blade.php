@extends('layouts.app')

@section('title', 'Profilni tahrirlash')

@section('content')

<div class="pagetitle d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1>Profilni tahrirlash</h1>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Bosh sahifa</a></li>
                <li class="breadcrumb-item"><a href="{{ route('profil') }}">Profil</a></li>
                <li class="breadcrumb-item active">Tahrirlash</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('profil') }}" class="btn btn-light border">
        <i class="bi bi-arrow-left me-1"></i> Orqaga
    </a>
</div>

<section class="section">

    @if($errors->any() && !$errors->password->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">

        {{-- SHAXSIY MA'LUMOTLARNI TAHRIRLASH --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0"><i class="bi bi-person-lines-fill text-primary me-2"></i>Shaxsiy ma'lumotlar</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="text-center mb-4">
                            <img src="{{ $user->avatar_url }}" class="rounded-circle mb-2" width="90" height="90" style="object-fit:cover;">
                            <div>
                                <input type="file" name="avatar" class="form-control mt-2" accept="image/png,image/jpeg,image/jpg">
                                <small class="text-muted">JPG, JPEG yoki PNG. Maksimal 2 MB.</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ism</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Login</label>
                                <input type="text" name="login" value="{{ old('login', $user->login) }}" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Telefon</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Manzil</label>
                                <input type="text" name="address" value="{{ old('address', $user->address) }}" class="form-control">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Saqlash
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- PAROLNI O'ZGARTIRISH --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0"><i class="bi bi-shield-lock text-danger me-2"></i>Parolni o'zgartirish</h5>
                </div>
                <div class="card-body">

                    @if($errors->password->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->password->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profil.password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Joriy parol</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Yangi parol</label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Yangi parolni tasdiqlash</label>
                            <input type="password" name="new_password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-key me-1"></i> Parolni yangilash
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</section>

@endsection