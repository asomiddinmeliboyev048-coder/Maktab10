@extends('layouts.app')

@section('content')

<style>
    body {
        background: #f5f7fb;
    }

    .page-header {
        background: linear-gradient(135deg, #198754 0%, #0d6efd 100%);
        border-radius: 20px;
        color: #fff;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(25, 135, 84, 0.15);
    }

    .content-card {
        border: 0;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .table thead th {
        background: #f8f9fc;
        color: #495057;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: .4px;
        white-space: nowrap;
    }

    .table tbody td {
        vertical-align: middle;
    }

    .avatar-circle {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #e8f5e9;
        color: #198754;
        font-weight: 700;
    }

    .empty-state {
        padding: 70px 20px;
        text-align: center;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 55px;
        color: #adb5bd;
    }

    .modal-content {
        border: 0;
        border-radius: 20px;
        overflow: hidden;
    }

    .modal-header {
        background: #f8f9fc;
        border-bottom: 1px solid #e9ecef;
    }

    .form-control,
    .form-select {
        border-radius: 10px;
        padding: 11px 14px;
    }

    .btn {
        border-radius: 10px;
    }
</style>

<div class="container-fluid py-4">

    <div class="page-header mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

            <div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-people-fill fs-3"></i>
                    <span class="opacity-75">Maktab boshqaruv tizimi</span>
                </div>

                <h2 class="fw-bold mb-2">O‘quvchilar</h2>

                <p class="mb-0 opacity-75">
                    O‘quvchilar ma’lumotlarini boshqarish
                </p>
            </div>

            <button
                type="button"
                class="btn btn-light btn-lg fw-semibold"
                data-bs-toggle="modal"
                data-bs-target="#createOquvchiModal"
            >
                <i class="bi bi-person-plus-fill me-2"></i>
                Yangi o‘quvchi
            </button>

        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger shadow-sm">
            <div class="fw-bold mb-2">
                <i class="bi bi-exclamation-circle me-2"></i>
                Ma’lumotlarni tekshiring:
            </div>

            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card content-card">

        <div class="card-header bg-white border-0 p-4">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h5 class="fw-bold mb-1">
                        O‘quvchilar ro‘yxati
                    </h5>

                    <small class="text-muted">
                        Jami: {{ $oquvchilar->count() }} ta o‘quvchi
                    </small>
                </div>

                <span class="badge text-bg-success rounded-pill px-3 py-2">
                    {{ $oquvchilar->count() }} ta
                </span>

            </div>

        </div>

        @if($oquvchilar->count() > 0)

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead>
                        <tr>
                            <th class="px-4">#</th>
                            <th>O‘quvchi</th>
                            <th>Sinf</th>
                            <th>Tug‘ilgan sana</th>
                            <th>Telefon</th>
                            <th>Manzil</th>
                            <th class="text-end px-4">Amallar</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($oquvchilar as $index => $oquvchi)

                            <tr>

                                <td class="px-4 text-muted">
                                    {{ $index + 1 }}
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-3">

                                        <div class="avatar-circle">
                                            <i class="bi bi-person-fill"></i>
                                        </div>

                                        <div>
                                            <div class="fw-bold">
                                                {{ $oquvchi->fio }}
                                            </div>

                                            <small class="text-muted">
                                                ID: {{ $oquvchi->id }}
                                            </small>
                                        </div>

                                    </div>
                                </td>

                                <td>
                                    <span class="badge bg-primary-subtle text-primary-emphasis">
                                        {{ $oquvchi->sinf_nomi }}
                                    </span>
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($oquvchi->tugilgan_sana)->format('d.m.Y') }}
                                </td>

                                <td>
                                    @if($oquvchi->telefon)
                                        <a
                                            href="tel:{{ $oquvchi->telefon }}"
                                            class="text-decoration-none"
                                        >
                                            <i class="bi bi-telephone me-1"></i>
                                            {{ $oquvchi->telefon }}
                                        </a>
                                    @else
                                        <span class="text-muted">
                                            Belgilanmagan
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if($oquvchi->manzil)
                                        <span
                                            title="{{ $oquvchi->manzil }}"
                                            class="d-inline-block text-truncate"
                                            style="max-width: 180px;"
                                        >
                                            <i class="bi bi-geo-alt me-1"></i>
                                            {{ $oquvchi->manzil }}
                                        </span>
                                    @else
                                        <span class="text-muted">
                                            Belgilanmagan
                                        </span>
                                    @endif
                                </td>

                                <td class="text-end px-4">

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editOquvchiModal{{ $oquvchi->id }}"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <form
                                        action="{{ route('oquvchilar.destroy', $oquvchi->id) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Haqiqatan ham {{ $oquvchi->fio }} ni o‘chirmoqchimisiz?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                        >
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty-state">

                <i class="bi bi-people"></i>

                <h5 class="fw-bold mt-3">
                    Hozircha o‘quvchilar mavjud emas
                </h5>

                <p class="mb-4">
                    Birinchi o‘quvchini qo‘shish uchun quyidagi tugmani bosing.
                </p>

                <button
                    type="button"
                    class="btn btn-success"
                    data-bs-toggle="modal"
                    data-bs-target="#createOquvchiModal"
                >
                    <i class="bi bi-person-plus me-2"></i>
                    O‘quvchi qo‘shish
                </button>

            </div>

        @endif

    </div>

</div>


{{-- CREATE MODAL --}}

<div class="modal fade" id="createOquvchiModal" tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <div>
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-person-plus-fill me-2 text-success"></i>
                        Yangi o‘quvchi qo‘shish
                    </h5>

                    <small class="text-muted">
                        O‘quvchi ma’lumotlarini kiriting
                    </small>
                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>

            <form action="{{ route('oquvchilar.store') }}" method="POST">

                @csrf

                <input type="hidden" name="form_type" value="create">

                <div class="modal-body p-4">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label fw-semibold">
                                F.I.O. <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="fio"
                                class="form-control @if(old('form_type') === 'create' && $errors->has('fio')) is-invalid @endif"
                                value="{{ old('form_type') === 'create' ? old('fio') : '' }}"
                                placeholder="Masalan: Aliyev Ali Valiyevich"
                                required
                            >

                            @if(old('form_type') === 'create')
                                @error('fio')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            @endif

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label fw-semibold">
                                Sinf <span class="text-danger">*</span>
                            </label>

                            <select
                                name="sinf_id"
                                class="form-select @if(old('form_type') === 'create' && $errors->has('sinf_id')) is-invalid @endif"
                                required
                            >

                                <option value="">
                                    Sinfni tanlang
                                </option>

                                @foreach($sinflar as $sinf)

                                    <option
                                        value="{{ $sinf->id }}"
                                        {{ old('form_type') === 'create' && old('sinf_id') == $sinf->id ? 'selected' : '' }}
                                    >
                                        {{ $sinf->nomi }}
                                    </option>

                                @endforeach

                            </select>

                            @if(old('form_type') === 'create')
                                @error('sinf_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            @endif

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label fw-semibold">
                                Tug‘ilgan sana <span class="text-danger">*</span>
                            </label>

                            <input
                                type="date"
                                name="tugilgan_sana"
                                class="form-control @if(old('form_type') === 'create' && $errors->has('tugilgan_sana')) is-invalid @endif"
                                value="{{ old('form_type') === 'create' ? old('tugilgan_sana') : '' }}"
                                max="{{ date('Y-m-d') }}"
                                required
                            >

                            @if(old('form_type') === 'create')
                                @error('tugilgan_sana')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            @endif

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label fw-semibold">
                                Telefon
                            </label>

                            <input
                                type="text"
                                name="telefon"
                                class="form-control @if(old('form_type') === 'create' && $errors->has('telefon')) is-invalid @endif"
                                value="{{ old('form_type') === 'create' ? old('telefon') : '' }}"
                                placeholder="+998 90 123 45 67"
                            >

                            @if(old('form_type') === 'create')
                                @error('telefon')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            @endif

                        </div>

                        <div class="col-12 mb-3">

                            <label class="form-label fw-semibold">
                                Manzil
                            </label>

                            <textarea
                                name="manzil"
                                rows="3"
                                class="form-control @if(old('form_type') === 'create' && $errors->has('manzil')) is-invalid @endif"
                                placeholder="Yashash manzilini kiriting"
                            >{{ old('form_type') === 'create' ? old('manzil') : '' }}</textarea>

                            @if(old('form_type') === 'create')
                                @error('manzil')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            @endif

                        </div>

                    </div>

                </div>

                <div class="modal-footer bg-light">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        Bekor qilish
                    </button>

                    <button
                        type="submit"
                        class="btn btn-success"
                    >
                        <i class="bi bi-check-lg me-1"></i>
                        Saqlash
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- EDIT MODALS --}}

@foreach($oquvchilar as $oquvchi)

<div
    class="modal fade"
    id="editOquvchiModal{{ $oquvchi->id }}"
    tabindex="-1"
>

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <div>
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-pencil-square me-2 text-primary"></i>
                        O‘quvchini tahrirlash
                    </h5>

                    <small class="text-muted">
                        {{ $oquvchi->fio }}
                    </small>
                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>

            <form
                action="{{ route('oquvchilar.update', $oquvchi->id) }}"
                method="POST"
            >

                @csrf
                @method('PUT')

                <input type="hidden" name="form_type" value="edit">
                <input type="hidden" name="edit_id" value="{{ $oquvchi->id }}">

                @php
                    $isCurrentEdit = old('form_type') === 'edit'
                        && old('edit_id') == $oquvchi->id;
                @endphp

                <div class="modal-body p-4">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label fw-semibold">
                                F.I.O. <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="fio"
                                class="form-control @if($isCurrentEdit && $errors->has('fio')) is-invalid @endif"
                                value="{{ $isCurrentEdit ? old('fio') : $oquvchi->fio }}"
                                required
                            >

                            @if($isCurrentEdit)
                                @error('fio')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            @endif

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label fw-semibold">
                                Sinf <span class="text-danger">*</span>
                            </label>

                            @php
                                $selectedSinf = $isCurrentEdit
                                    ? old('sinf_id')
                                    : $oquvchi->sinf_id;
                            @endphp

                            <select
                                name="sinf_id"
                                class="form-select @if($isCurrentEdit && $errors->has('sinf_id')) is-invalid @endif"
                                required
                            >

                                <option value="">
                                    Sinfni tanlang
                                </option>

                                @foreach($sinflar as $sinf)

                                    <option
                                        value="{{ $sinf->id }}"
                                        {{ $selectedSinf == $sinf->id ? 'selected' : '' }}
                                    >
                                        {{ $sinf->nomi }}
                                    </option>

                                @endforeach

                            </select>

                            @if($isCurrentEdit)
                                @error('sinf_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            @endif

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label fw-semibold">
                                Tug‘ilgan sana <span class="text-danger">*</span>
                            </label>

                            <input
                                type="date"
                                name="tugilgan_sana"
                                class="form-control @if($isCurrentEdit && $errors->has('tugilgan_sana')) is-invalid @endif"
                                value="{{ $isCurrentEdit ? old('tugilgan_sana') : $oquvchi->tugilgan_sana }}"
                                max="{{ date('Y-m-d') }}"
                                required
                            >

                            @if($isCurrentEdit)
                                @error('tugilgan_sana')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            @endif

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label fw-semibold">
                                Telefon
                            </label>

                            <input
                                type="text"
                                name="telefon"
                                class="form-control @if($isCurrentEdit && $errors->has('telefon')) is-invalid @endif"
                                value="{{ $isCurrentEdit ? old('telefon') : $oquvchi->telefon }}"
                            >

                            @if($isCurrentEdit)
                                @error('telefon')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            @endif

                        </div>

                        <div class="col-12 mb-3">

                            <label class="form-label fw-semibold">
                                Manzil
                            </label>

                            <textarea
                                name="manzil"
                                rows="3"
                                class="form-control @if($isCurrentEdit && $errors->has('manzil')) is-invalid @endif"
                            >{{ $isCurrentEdit ? old('manzil') : $oquvchi->manzil }}</textarea>

                            @if($isCurrentEdit)
                                @error('manzil')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            @endif

                        </div>

                    </div>

                </div>

                <div class="modal-footer bg-light">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        Bekor qilish
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="bi bi-save me-1"></i>
                        Yangilash
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endforeach


<script>
document.addEventListener('DOMContentLoaded', function () {

    @if($errors->any() && old('form_type') === 'create')

        const createModal = new bootstrap.Modal(
            document.getElementById('createOquvchiModal')
        );

        createModal.show();

    @endif


    @if($errors->any() && old('form_type') === 'edit' && old('edit_id'))

        const editModalElement = document.getElementById(
            'editOquvchiModal{{ old('edit_id') }}'
        );

        if (editModalElement) {

            const editModal = new bootstrap.Modal(
                editModalElement
            );

            editModal.show();
        }

    @endif

});
</script>

@endsection