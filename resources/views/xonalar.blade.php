@extends('layouts.app')

@section('content')

<style>
    body {
        background: #f5f7fb;
    }

    .page-header {
        background: linear-gradient(135deg, #fd7e14 0%, #dc3545 100%);
        border-radius: 20px;
        color: #fff;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(220, 53, 69, 0.15);
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

    .room-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #fff3cd;
        color: #fd7e14;
        font-size: 20px;
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

    .form-control {
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
                    <i class="bi bi-door-open-fill fs-3"></i>
                    <span class="opacity-75">
                        Maktab boshqaruv tizimi
                    </span>
                </div>

                <h2 class="fw-bold mb-2">
                    Xonalar
                </h2>

                <p class="mb-0 opacity-75">
                    Maktab xonalarini va ularning sig‘imini boshqarish
                </p>

            </div>

            <button
                type="button"
                class="btn btn-light btn-lg fw-semibold"
                data-bs-toggle="modal"
                data-bs-target="#createXonaModal"
            >
                <i class="bi bi-plus-lg me-2"></i>
                Yangi xona
            </button>

        </div>

    </div>


    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show shadow-sm">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show shadow-sm">

            <i class="bi bi-exclamation-triangle-fill me-2"></i>

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

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
                        Xonalar ro‘yxati
                    </h5>

                    <small class="text-muted">
                        Jami: {{ $xonalar->count() }} ta xona
                    </small>

                </div>

                <span class="badge text-bg-warning rounded-pill px-3 py-2">
                    {{ $xonalar->count() }} ta
                </span>

            </div>

        </div>


        @if($xonalar->count() > 0)

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead>

                        <tr>
                            <th class="px-4">#</th>
                            <th>Xona</th>
                            <th>Sig‘imi</th>
                            <th>Holati</th>
                            <th>Qo‘shilgan sana</th>
                            <th class="text-end px-4">Amallar</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($xonalar as $index => $xona)

                            <tr>

                                <td class="px-4 text-muted">
                                    {{ $index + 1 }}
                                </td>

                                <td>

                                    <div class="d-flex align-items-center gap-3">

                                        <div class="room-icon">
                                            <i class="bi bi-door-open-fill"></i>
                                        </div>

                                        <div>

                                            <div class="fw-bold">
                                                {{ $xona->nomi }}
                                            </div>

                                            <small class="text-muted">
                                                ID: {{ $xona->id }}
                                            </small>

                                        </div>

                                    </div>

                                </td>

                                <td>

                                    <span class="badge bg-info-subtle text-info-emphasis rounded-pill">
                                        <i class="bi bi-people me-1"></i>
                                        {{ $xona->sigimi }} o‘rin
                                    </span>

                                </td>

                                <td>

                                    @if($xona->sigimi >= 50)

                                        <span class="badge bg-success-subtle text-success-emphasis">
                                            Katta xona
                                        </span>

                                    @elseif($xona->sigimi >= 20)

                                        <span class="badge bg-primary-subtle text-primary-emphasis">
                                            Standart
                                        </span>

                                    @else

                                        <span class="badge bg-warning-subtle text-warning-emphasis">
                                            Kichik xona
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    @if($xona->created_at)

                                        {{ \Carbon\Carbon::parse($xona->created_at)->format('d.m.Y') }}

                                    @else

                                        <span class="text-muted">
                                            —
                                        </span>

                                    @endif

                                </td>

                                <td class="text-end px-4">

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editXonaModal{{ $xona->id }}"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                    </button>


                                    <form
                                        action="{{ route('xonalar.destroy', $xona->id) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Haqiqatan ham {{ $xona->nomi }} xonasini o‘chirmoqchimisiz?');"
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

                <i class="bi bi-door-open"></i>

                <h5 class="fw-bold mt-3">
                    Hozircha xonalar mavjud emas
                </h5>

                <p class="mb-4">
                    Birinchi xonani qo‘shish uchun quyidagi tugmani bosing.
                </p>

                <button
                    type="button"
                    class="btn btn-warning"
                    data-bs-toggle="modal"
                    data-bs-target="#createXonaModal"
                >
                    <i class="bi bi-plus-lg me-2"></i>
                    Xona qo‘shish
                </button>

            </div>

        @endif

    </div>

</div>


{{-- CREATE MODAL --}}

<div
    class="modal fade"
    id="createXonaModal"
    tabindex="-1"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <div>

                    <h5 class="modal-title fw-bold">

                        <i class="bi bi-plus-circle me-2 text-warning"></i>

                        Yangi xona qo‘shish

                    </h5>

                    <small class="text-muted">
                        Xona ma’lumotlarini kiriting
                    </small>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>


            <form
                action="{{ route('xonalar.store') }}"
                method="POST"
            >

                @csrf

                <input
                    type="hidden"
                    name="form_type"
                    value="create"
                >


                <div class="modal-body p-4">

                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Xona nomi <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="nomi"
                            class="form-control @if(old('form_type') === 'create' && $errors->has('nomi')) is-invalid @endif"
                            value="{{ old('form_type') === 'create' ? old('nomi') : '' }}"
                            placeholder="Masalan: 101-xona"
                            required
                        >

                        @if(old('form_type') === 'create')

                            @error('nomi')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        @endif

                    </div>


                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Sig‘imi <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <input
                                type="number"
                                name="sigimi"
                                class="form-control @if(old('form_type') === 'create' && $errors->has('sigimi')) is-invalid @endif"
                                value="{{ old('form_type') === 'create' ? old('sigimi') : '' }}"
                                min="1"
                                max="10000"
                                placeholder="30"
                                required
                            >

                            <span class="input-group-text">
                                o‘rin
                            </span>

                            @if(old('form_type') === 'create')

                                @error('sigimi')

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
                        class="btn btn-warning"
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

@foreach($xonalar as $xona)

@php
    $isCurrentEdit = old('form_type') === 'edit'
        && old('edit_id') == $xona->id;
@endphp

<div
    class="modal fade"
    id="editXonaModal{{ $xona->id }}"
    tabindex="-1"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <div>

                    <h5 class="modal-title fw-bold">

                        <i class="bi bi-pencil-square me-2 text-primary"></i>

                        Xonani tahrirlash

                    </h5>

                    <small class="text-muted">
                        {{ $xona->nomi }}
                    </small>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>


            <form
                action="{{ route('xonalar.update', $xona->id) }}"
                method="POST"
            >

                @csrf
                @method('PUT')

                <input
                    type="hidden"
                    name="form_type"
                    value="edit"
                >

                <input
                    type="hidden"
                    name="edit_id"
                    value="{{ $xona->id }}"
                >


                <div class="modal-body p-4">

                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Xona nomi <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="nomi"
                            class="form-control @if($isCurrentEdit && $errors->has('nomi')) is-invalid @endif"
                            value="{{ $isCurrentEdit ? old('nomi') : $xona->nomi }}"
                            required
                        >

                        @if($isCurrentEdit)

                            @error('nomi')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        @endif

                    </div>


                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Sig‘imi <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <input
                                type="number"
                                name="sigimi"
                                class="form-control @if($isCurrentEdit && $errors->has('sigimi')) is-invalid @endif"
                                value="{{ $isCurrentEdit ? old('sigimi') : $xona->sigimi }}"
                                min="1"
                                max="10000"
                                required
                            >

                            <span class="input-group-text">
                                o‘rin
                            </span>

                            @if($isCurrentEdit)

                                @error('sigimi')

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
            document.getElementById('createXonaModal')
        );

        createModal.show();

    @endif


    @if($errors->any() && old('form_type') === 'edit' && old('edit_id'))

        const editModalElement = document.getElementById(
            'editXonaModal{{ old('edit_id') }}'
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