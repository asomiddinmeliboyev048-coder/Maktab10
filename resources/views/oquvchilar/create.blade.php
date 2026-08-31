@extends('layouts.app')

@section('title', 'O‘quvchi qo‘shish')

@section('page-title', 'O‘quvchi qo‘shish')

@section('breadcrumb', 'O‘quvchi qo‘shish')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">

                <i class="bi bi-person-plus text-primary me-2"></i>

                Yangi o‘quvchi qo‘shish

            </h4>

            <p class="text-muted mb-0">

                O‘quvchi ma'lumotlarini kiriting

            </p>

        </div>

        <a href="{{ route('oquvchilar.index') }}"
           class="btn btn-outline-secondary">

            <i class="bi bi-arrow-left me-1"></i>

            Orqaga

        </a>

    </div>


    @if($errors->any())

        <div class="alert alert-danger alert-dismissible fade show"
             role="alert">

            <div class="fw-bold mb-2">

                <i class="bi bi-exclamation-triangle me-1"></i>

                Quyidagi xatolarni to‘g‘rilang:

            </div>

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show"
             role="alert">

            <i class="bi bi-exclamation-triangle me-2"></i>

            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    <div class="row justify-content-center">

        <div class="col-lg-9">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">

                    <h5 class="card-title mb-0">

                        <i class="bi bi-person-vcard me-2 text-primary"></i>

                        O‘quvchi ma'lumotlari

                    </h5>

                </div>


                <form method="POST"
                      action="{{ route('oquvchilar.store') }}">

                    @csrf


                    <div class="card-body p-4">


                        {{-- F.I.O --}}

                        <div class="mb-4">

                            <label for="fio"
                                   class="form-label fw-semibold">

                                O‘quvchining F.I.O si

                                <span class="text-danger">*</span>

                            </label>

                            <input type="text"
                                   id="fio"
                                   name="fio"
                                   class="form-control @error('fio') is-invalid @enderror"
                                   value="{{ old('fio') }}"
                                   placeholder="Masalan: Aliyev Alisher Anvar o‘g‘li"
                                   required
                                   autofocus>

                            @error('fio')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>


                        {{-- SINF --}}

                        <div class="mb-4">

                            <label for="sinf_id"
                                   class="form-label fw-semibold">

                                Sinfni tanlang

                                <span class="text-danger">*</span>

                            </label>

                            <select id="sinf_id"
                                    name="sinf_id"
                                    class="form-select @error('sinf_id') is-invalid @enderror"
                                    required>

                                <option value="">

                                    -- Sinfni tanlang --

                                </option>

                                @forelse($sinflar as $sinf)

                                    <option value="{{ $sinf->id }}"
                                        {{ old('sinf_id') == $sinf->id ? 'selected' : '' }}>

                                        {{ $sinf->name }}

                                    </option>

                                @empty

                                    <option value=""
                                            disabled>

                                        Hozircha sinflar mavjud emas

                                    </option>

                                @endforelse

                            </select>

                            @error('sinf_id')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                            @if($sinflar->count() == 0)

                                <div class="form-text text-danger mt-2">

                                    <i class="bi bi-info-circle me-1"></i>

                                    Avval kamida bitta sinf qo‘shishingiz kerak.

                                </div>

                            @else

                                <div class="form-text">

                                    O‘quvchi qaysi sinfda o‘qishini tanlang.

                                </div>

                            @endif

                        </div>


                        <div class="row">


                            {{-- TELEFON --}}

                            <div class="col-md-6">

                                <div class="mb-4">

                                    <label for="phone"
                                           class="form-label fw-semibold">

                                        Telefon raqami

                                    </label>

                                    <input type="text"
                                           id="phone"
                                           name="phone"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           value="{{ old('phone') }}"
                                           placeholder="+998 90 123 45 67">

                                    @error('phone')

                                        <div class="invalid-feedback">

                                            {{ $message }}

                                        </div>

                                    @enderror

                                </div>

                            </div>


                            {{-- STUDENT ID --}}

                            <div class="col-md-6">

                                <div class="mb-4">

                                    <label class="form-label fw-semibold">

                                        O‘quvchi ID

                                    </label>

                                    <input type="text"
                                           class="form-control"
                                           value="ST-XXXXX"
                                           readonly>

                                    <div class="form-text">

                                        O‘quvchi ID avtomatik yaratiladi.

                                    </div>

                                </div>

                            </div>


                        </div>


                        {{-- MANZIL --}}

                        <div class="mb-0">

                            <label for="address"
                                   class="form-label fw-semibold">

                                Yashash manzili

                            </label>

                            <textarea id="address"
                                      name="address"
                                      rows="4"
                                      class="form-control @error('address') is-invalid @enderror"
                                      placeholder="O‘quvchining yashash manzilini kiriting">{{ old('address') }}</textarea>

                            @error('address')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>


                    </div>


                    <div class="card-footer bg-white p-4">

                        <div class="d-flex justify-content-between align-items-center">

                            <a href="{{ route('oquvchilar.index') }}"
                               class="btn btn-light">

                                <i class="bi bi-x-circle me-1"></i>

                                Bekor qilish

                            </a>

                            <button type="submit"
                                    class="btn btn-primary"
                                    {{ $sinflar->count() == 0 ? 'disabled' : '' }}>

                                <i class="bi bi-check-circle me-1"></i>

                                O‘quvchini saqlash

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection