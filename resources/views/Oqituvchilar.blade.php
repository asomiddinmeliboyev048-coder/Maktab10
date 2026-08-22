@extends('layouts.app')

@section('content')

<style>
    body {
        background: #f5f7fb;
    }

    .page-header {
        background: linear-gradient(135deg, #6f42c1 0%, #0d6efd 100%);
        border-radius: 20px;
        color: #fff;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(111, 66, 193, 0.15);
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
        background: #f0e8ff;
        color: #6f42c1;
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
                    <i class="bi bi-person-workspace fs-3"></i>
                    <span class="opacity-75">
                        Maktab boshqaruv tizimi
                    </span>
                </div>

                <h2 class="fw-bold mb-2">
                    O‘qituvchilar
                </h2>

                <p class="mb-0 opacity-75">
                    Maktab o‘qituvchilarini boshqarish
                </p>
            </div>

            <button
                type="button"
                class="btn btn-light btn-lg fw-semibold"
                data-bs-toggle="modal"
                data-bs-target="#createOqituvchiModal"
            >
                <i class="bi bi-person-plus-fill me-2"></i>
                Yangi o‘qituvchi
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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-bold mb-1">
                        O‘qituvchilar ro‘yxati
                    </h5>

                    <small class="text-muted">
                        Jami: {{ $oqituvchilar->count() }} ta
                    </small>
                </div>

                <span class="badge text-bg-primary rounded-pill px-3 py-2">
                    {{ $oqituvchilar->count() }} ta
                </span>
            </div>


            @if($oqituvchilar->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="px-4">#</th>
                                <th>O‘qituvchi</th>
                                <th>Fan</th>
                                <th>Telefon</th>
                                <th>Qo‘shilgan sana</th>
                                <th class="text-end px-4">Amallar</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($oqituvchilar as $index => $oqituvchi)
                                <tr>
                                    <td class="px-4 text-muted">
                                        {{ $index + 1 }}
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-circle">
                                                <i class="bi bi-person-workspace"></i>
                                            </div>

                                            <div>
                                                <div class="fw-bold">
                                                    {{ $oqituvchi->fio }}
                                                </div>

                                                <small class="text-muted">
                                                    ID: {{ $oqituvchi->id }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge bg-primary-subtle text-primary-emphasis">
                                            <i class="bi bi-book me-1"></i>
                                            {{ $oqituvchi->fan }}
                                        </span>
                                    </td>

                                    <td>
                                        @if($oqituvchi->telefon)
                                            <a
                                                href="tel:{{ $oqituvchi->telefon }}"
                                                class="text-decoration-none"
                                            >
                                                <i class="bi bi-telephone me-1"></i>
                                                {{ $oqituvchi->telefon }}
                                            </a>
                                        @else
                                            <span class="text-muted">
                                                Belgilanmagan
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($oqituvchi->created_at)
                                            {{ \Carbon\Carbon::parse($oqituvchi->created_at)->format('d.m.Y') }}
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
                                            data-bs-target="#editOqituvchiModal{{ $oqituvchi->id }}"
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <form
                                            action="{{ route('oqituvchilar.destroy', $oqituvchi->id) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Haqiqatan ham {{ $oqituvchi->fio }} ni o‘chirmoqchimisiz?');"
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
                    <i class="bi bi-person-workspace"></i>

                    <h5 class="fw-bold mt-3">
                        Hozircha o‘qituvchilar mavjud emas
                    </h5>

                    <p class="mb-4">
                        Birinchi o‘qituvchini qo‘shish uchun quyidagi tugmani bosing.
                    </p>

                    <button
                        type="button"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#createOqituvchiModal"
                    >
                        <i class="bi bi-person-plus me-2"></i>
                        O‘qituvchi qo‘shish
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>


{{-- CREATE MODAL --}}
<div
    class="modal fade"
    id="createOqituvchiModal"
    tabindex="-1"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-person-plus-fill me-2 text-primary"></i>
                        Yangi o‘qituvchi
                    </h5>

                    <small class="text-muted">
                        O‘qituvchi ma’lumotlarini kiriting
                    </small>
                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>
            </div>

            <form
                action="{{ route('oqituvchilar.store') }}"
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
                            F.I.O. <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="fio"
                            class="form-control {{ (old('form_type') === 'create' && $errors->has('fio')) ? 'is-invalid' : '' }}"
                            value="{{ old('form_type') === 'create' ? old('fio') : '' }}"
                            placeholder="Masalan: Karimov Anvar Akmalovich"
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

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Fan <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="fan"
                            class="form-control {{ (old('form_type') === 'create' && $errors->has('fan')) ? 'is-invalid' : '' }}"
                            value="{{ old('form_type') === 'create' ? old('fan') : '' }}"
                            placeholder="Masalan: Matematika"
                            required
                        >

                        @if(old('form_type') === 'create')
                            @error('fan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Telefon
                        </label>

                        <input
                            type="text"
                            name="telefon"
                            class="form-control {{ (old('form_type') === 'create' && $errors->has('telefon')) ? 'is-invalid' : '' }}"
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
                        <i class="bi bi-check-lg me-1"></i>
                        Saqlash
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- EDIT MODALS --}}
@foreach($oqituvchilar as $oqituvchi)

    @php
        $isCurrentEdit = old('form_type') === 'edit' && old('edit_id') == $oqituvchi->id;
    @endphp

    <div
        class="modal fade"
        id="editOqituvchiModal{{ $oqituvchi->id }}"
        tabindex="-1"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title fw-bold">
                            <i class="bi bi-pencil-square me-2 text-primary"></i>
                            O‘qituvchini tahrirlash
                        </h5>

                        <small class="text-muted">
                            {{ $oqituvchi->fio }}
                        </small>
                    </div>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>
                </div>

                <form
                    action="{{ route('oqituvchilar.update', $oqituvchi->id) }}"
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
                        value="{{ $oqituvchi->id }}"
                    >

                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                F.I.O. <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="fio"
                                class="form-control {{ ($isCurrentEdit && $errors->has('fio')) ? 'is-invalid' : '' }}"
                                value="{{ $isCurrentEdit ? old('fio') : $oqituvchi->fio }}"
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

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Fan <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="fan"
                                class="form-control {{ ($isCurrentEdit && $errors->has('fan')) ? 'is-invalid' : '' }}"
                                value="{{ $isCurrentEdit ? old('fan') : $oqituvchi->fan }}"
                                required
                            >

                            @if($isCurrentEdit)
                                @error('fan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Telefon
                            </label>

                            <input
                                type="text"
                                name="telefon"
                                class="form-control {{ ($isCurrentEdit && $errors->has('telefon')) ? 'is-invalid' : '' }}"
                                value="{{ $isCurrentEdit ? old('telefon') : $oqituvchi->telefon }}"
                            >

                            @if($isCurrentEdit)
                                @error('telefon')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            @endif
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

    @if($isCurrentEdit)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const editModal = new bootstrap.Modal(
                    document.getElementById('editOqituvchiModal{{ $oqituvchi->id }}')
                );
                editModal.show();
            });
        </script>
    @endif

@endforeach


<script>
document.addEventListener('DOMContentLoaded', function () {
    @if($errors->any() && old('form_type') === 'create')
        const createModal = new bootstrap.Modal(
            document.getElementById('createOqituvchiModal')
        );
        createModal.show();
    @endif
});
</script>

@endsection