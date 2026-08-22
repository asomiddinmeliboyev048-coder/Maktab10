@extends('layouts.app')

@section('content')

<style>
    /* ==========================================
       ALOQA DASHBOARD
    ========================================== */

    .aloqa-page {
        background: #f6f8fb;
        min-height: calc(100vh - 80px);
        margin: -1rem;
        padding: 1.25rem;
    }

    .aloqa-header {
        background: linear-gradient(135deg, #4154f1 0%, #6978f5 100%);
        border-radius: 16px;
        padding: 22px 25px;
        color: #fff;
        margin-bottom: 20px;
        box-shadow: 0 8px 25px rgba(65, 84, 241, .14);
    }

    .aloqa-header h1 {
        margin: 0 0 4px;
        font-size: 25px;
        font-weight: 800;
    }

    .aloqa-header p {
        margin: 0;
        font-size: 13px;
        opacity: .85;
    }

    .main-card {
        border: 0;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 6px 22px rgba(0,0,0,.06);
        overflow: hidden;
    }

    .card-top {
        padding: 18px 21px;
        border-bottom: 1px solid #edf0f4;
    }

    .card-top h5 {
        font-size: 17px;
        font-weight: 750;
        margin: 0;
        color: #202938;
    }

    .card-top p {
        margin: 3px 0 0;
        font-size: 12px;
        color: #9299a8;
    }

    /* ==========================================
       TABLE
    ========================================== */

    .aloqa-table {
        margin: 0;
    }

    .aloqa-table thead th {
        background: #f8f9fc;
        border-bottom: 1px solid #e9edf3;
        color: #727b8c;
        font-size: 11px;
        font-weight: 750;
        text-transform: uppercase;
        letter-spacing: .45px;
        padding: 13px 14px;
        white-space: nowrap;
    }

    .aloqa-table tbody td {
        border-color: #f0f2f6;
        padding: 13px 14px;
        font-size: 13px;
        vertical-align: middle;
    }

    .aloqa-table tbody tr {
        transition: all .18s ease;
    }

    .aloqa-table tbody tr:hover {
        background: #fafbff;
    }

    .user-avatar {
        width: 38px;
        height: 38px;
        min-width: 38px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eef1ff;
        color: #4154f1;
        font-size: 17px;
        font-weight: 700;
    }

    .user-name {
        font-weight: 700;
        color: #283142;
        line-height: 1.2;
    }

    .contact-line {
        font-size: 11px;
        color: #7f8898;
        line-height: 1.7;
        white-space: nowrap;
    }

    .subject-text {
        font-weight: 700;
        color: #303847;
        margin-bottom: 2px;
    }

    .message-preview {
        max-width: 260px;
        font-size: 11px;
        color: #929aaa;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .date-badge {
        display: inline-block;
        background: #f5f6f9;
        border-radius: 8px;
        color: #70798a;
        padding: 6px 9px;
        font-size: 10px;
        white-space: nowrap;
    }

    .action-btn {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    /* ==========================================
       MODAL
    ========================================== */

    .modal-content {
        border: 0;
        border-radius: 17px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,.2);
    }

    .modal-header {
        padding: 18px 22px;
        border-bottom: 1px solid #edf0f4;
        background: #fff;
    }

    .modal-title {
        font-size: 17px;
        font-weight: 750;
        color: #202938;
    }

    .modal-header-icon {
        width: 40px;
        height: 40px;
        border-radius: 11px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eef1ff;
        color: #4154f1;
        margin-right: 10px;
    }

    .modal-body {
        padding: 22px;
        background: #fff;
    }

    .modal-footer {
        padding: 14px 22px;
        border-top: 1px solid #edf0f4;
        background: #fafbfc;
    }

    .form-label {
        font-size: 12px;
        font-weight: 700;
        color: #4b5565;
        margin-bottom: 6px;
    }

    .form-control {
        border: 1px solid #dfe3e9;
        border-radius: 9px;
        min-height: 40px;
        font-size: 13px;
        transition: all .2s ease;
    }

    .form-control:focus {
        border-color: #4154f1;
        box-shadow: 0 0 0 3px rgba(65,84,241,.1);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 110px;
    }

    .required-star {
        color: #dc3545;
    }

    /* ==========================================
       VIEW MODAL
    ========================================== */

    .detail-box {
        border: 1px solid #edf0f4;
        background: #fafbfc;
        border-radius: 12px;
        padding: 13px 15px;
        margin-bottom: 12px;
    }

    .detail-label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: .5px;
        font-weight: 750;
        color: #8a93a3;
        margin-bottom: 4px;
    }

    .detail-value {
        font-size: 13px;
        color: #273142;
        font-weight: 600;
        word-break: break-word;
    }

    .message-detail {
        background: #f7f8fc;
        border-radius: 12px;
        padding: 16px;
        font-size: 13px;
        line-height: 1.7;
        color: #454e5e;
        white-space: pre-wrap;
    }

    /* ==========================================
       EMPTY
    ========================================== */

    .empty-state {
        text-align: center;
        padding: 55px 20px;
        color: #9aa2b1;
    }

    .empty-state i {
        font-size: 42px;
        opacity: .55;
        display: block;
        margin-bottom: 10px;
    }

    .empty-state strong {
        display: block;
        color: #727b89;
        margin-bottom: 4px;
    }

    .empty-state span {
        font-size: 12px;
    }

    /* ==========================================
       ALERT
    ========================================== */

    .custom-alert {
        border: 0;
        border-radius: 11px;
        font-size: 13px;
        box-shadow: 0 5px 15px rgba(0,0,0,.05);
    }

    /* ==========================================
       NOTEBOOK / LAPTOP
    ========================================== */

    @media (min-width: 992px) {

        .aloqa-page {
            padding: 1.15rem 1.5rem;
        }

        .modal-dialog.modal-xl {
            max-width: 720px;
        }

        .modal-dialog.modal-view {
            max-width: 650px;
        }

        .aloqa-table {
            table-layout: auto;
        }
    }

    /* ==========================================
       TABLET
    ========================================== */

    @media (max-width: 991px) {

        .aloqa-page {
            margin: -.5rem;
            padding: 1rem;
        }

        .aloqa-header {
            padding: 20px;
        }

        .aloqa-header h1 {
            font-size: 22px;
        }

        .table-responsive {
            border-radius: 0;
        }
    }

    /* ==========================================
       MOBILE
    ========================================== */

    @media (max-width: 575px) {

        .aloqa-page {
            padding: .75rem;
        }

        .aloqa-header {
            padding: 18px;
        }

        .aloqa-header h1 {
            font-size: 20px;
        }

        .aloqa-header p {
            font-size: 11px;
        }

        .card-top {
            padding: 16px;
        }

        .modal-body {
            padding: 17px;
        }

        .modal-footer {
            padding: 12px 17px;
        }
    }
</style>

<div class="aloqa-page">

<!-- ==========================================
     HEADER
=========================================== -->

<div class="aloqa-header">

    <div class="d-flex justify-content-between align-items-center gap-3">

        <div>
            <h1>
                <i class="bi bi-envelope-paper me-2"></i>
                Aloqa va Xabarlar
            </h1>

            <p>
                Kelib tushgan aloqa xabarlarini boshqarish
            </p>
        </div>

        <!-- FAQAT BITTA YANGI XABAR TUGMASI -->
        <button type="button"
                class="btn btn-light fw-bold px-4 py-2 rounded-pill shadow-sm"
                data-bs-toggle="modal"
                data-bs-target="#addMessageModal">

            <i class="bi bi-plus-lg me-1"></i>
            Yangi xabar

        </button>

    </div>

</div>


<!-- SUCCESS -->
@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show custom-alert mb-3"
         role="alert">

        <i class="bi bi-check-circle-fill me-2"></i>

        {{ session('success') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>

    </div>

@endif


<!-- VALIDATION ERRORS -->

@if($errors->any())

    <div class="alert alert-danger custom-alert mb-3">

        <div class="fw-bold mb-1">
            <i class="bi bi-exclamation-triangle me-1"></i>
            Ma'lumotlarni tekshiring
        </div>

        <ul class="mb-0 ps-3 small">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif


<!-- ==========================================
     XABARLAR RO'YXATI
=========================================== -->

<div class="main-card">

    <div class="card-top">

        <div class="d-flex justify-content-between align-items-center">

            <div>
                <h5>
                    <i class="bi bi-chat-left-text text-primary me-2"></i>
                    Xabarlar ro‘yxati
                </h5>

                <p>
                    Tizimga kelib tushgan barcha aloqa xabarlari
                </p>
            </div>

            <span class="badge bg-primary rounded-pill px-3 py-2">
                {{ $aloqalar->count() }} ta
            </span>

        </div>

    </div>


    <div class="table-responsive">

        <table class="table aloqa-table align-middle mb-0">

            <thead>

                <tr>

                    <th>#</th>

                    <th>Foydalanuvchi</th>

                    <th>Aloqa</th>

                    <th>Mavzu / Xabar</th>

                    <th>Sana</th>

                    <th class="text-end">Amal</th>

                </tr>

            </thead>


            <tbody>

                @forelse($aloqalar as $item)

                    <tr>

                        <!-- ID -->
                        <td>
                            <strong class="text-muted">
                                {{ $loop->iteration }}
                            </strong>
                        </td>


                        <!-- USER -->
                        <td>

                            <div class="d-flex align-items-center">

                                <div class="user-avatar me-2">

                                    {{ strtoupper(substr($item->name, 0, 1)) }}

                                </div>

                                <div>

                                    <div class="user-name">
                                        {{ $item->name }}
                                    </div>

                                </div>

                            </div>

                        </td>


                        <!-- CONTACT -->
                        <td>

                            <div class="contact-line">

                                <div>
                                    <i class="bi bi-envelope me-1"></i>
                                    {{ $item->email ?? '-' }}
                                </div>

                                <div>
                                    <i class="bi bi-telephone me-1"></i>
                                    {{ $item->phone ?? '-' }}
                                </div>

                            </div>

                        </td>


                        <!-- SUBJECT -->
                        <td>

                            <div class="subject-text">

                                {{ $item->subject ?? 'Mavzusiz' }}

                            </div>

                            <div class="message-preview">

                                {{ $item->message }}

                            </div>

                        </td>


                        <!-- DATE -->
                        <td>

                            <span class="date-badge">

                                <i class="bi bi-calendar3 me-1"></i>

                                {{ $item->created_at
                                    ? $item->created_at->format('d.m.Y H:i')
                                    : '-' }}

                            </span>

                        </td>


                        <!-- ACTION -->
                        <td class="text-end text-nowrap">

                            <!-- KO'RISH -->

                            <button type="button"
                                    class="btn btn-outline-primary btn-sm action-btn me-1"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewMessageModal{{ $item->id }}"
                                    title="Xabarni ko‘rish">

                                <i class="bi bi-eye"></i>

                            </button>


                            <!-- O'CHIRISH -->

                            <form action="{{ route('aloqa.destroy', $item->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Rostdan ham o‘chirmoqchimisiz?');">

                                @csrf

                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-outline-danger btn-sm action-btn"
                                        title="O‘chirish">

                                    <i class="bi bi-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>


                    <!-- ==========================================
                         VIEW MESSAGE MODAL
                    =========================================== -->

                    <div class="modal fade"
                         id="viewMessageModal{{ $item->id }}"
                         tabindex="-1"
                         aria-hidden="true">

                        <div class="modal-dialog modal-dialog-centered modal-view">

                            <div class="modal-content">

                                <div class="modal-header">

                                    <div class="d-flex align-items-center">

                                        <div class="modal-header-icon">
                                            <i class="bi bi-envelope-open"></i>
                                        </div>

                                        <div>
                                            <div class="modal-title">
                                                Xabar ma'lumotlari
                                            </div>

                                            <small class="text-muted">
                                                To‘liq ma’lumot
                                            </small>
                                        </div>

                                    </div>

                                    <button type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal">
                                    </button>

                                </div>


                                <div class="modal-body">

                                    <div class="row">

                                        <div class="col-md-6">

                                            <div class="detail-box">

                                                <div class="detail-label">
                                                    Ism Familiya
                                                </div>

                                                <div class="detail-value">
                                                    {{ $item->name }}
                                                </div>

                                            </div>

                                        </div>


                                        <div class="col-md-6">

                                            <div class="detail-box">

                                                <div class="detail-label">
                                                    Email
                                                </div>

                                                <div class="detail-value">
                                                    {{ $item->email ?? '-' }}
                                                </div>

                                            </div>

                                        </div>


                                        <div class="col-md-6">

                                            <div class="detail-box">

                                                <div class="detail-label">
                                                    Telefon
                                                </div>

                                                <div class="detail-value">
                                                    {{ $item->phone ?? '-' }}
                                                </div>

                                            </div>

                                        </div>


                                        <div class="col-md-6">

                                            <div class="detail-box">

                                                <div class="detail-label">
                                                    Sana
                                                </div>

                                                <div class="detail-value">

                                                    {{ $item->created_at
                                                        ? $item->created_at->format('d.m.Y H:i')
                                                        : '-' }}

                                                </div>

                                            </div>

                                        </div>


                                        <div class="col-12">

                                            <div class="detail-box">

                                                <div class="detail-label">
                                                    Mavzu
                                                </div>

                                                <div class="detail-value">
                                                    {{ $item->subject ?? 'Mavzusiz' }}
                                                </div>

                                            </div>

                                        </div>


                                        <div class="col-12">

                                            <div class="detail-label mb-2">
                                                Xabar matni
                                            </div>

                                            <div class="message-detail">
                                                {{ $item->message }}
                                            </div>

                                        </div>

                                    </div>

                                </div>


                                <div class="modal-footer">

                                    <button type="button"
                                            class="btn btn-secondary btn-sm px-4"
                                            data-bs-dismiss="modal">

                                        <i class="bi bi-x-lg me-1"></i>
                                        Yopish

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    <tr>

                        <td colspan="6">

                            <div class="empty-state">

                                <i class="bi bi-envelope-open"></i>

                                <strong>
                                    Hozircha xabarlar mavjud emas
                                </strong>

                                <span>
                                    Yangi xabar qo‘shish uchun yuqoridagi
                                    “Yangi xabar” tugmasini bosing.
                                </span>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

</div>

<!-- ==========================================
     ADD NEW MESSAGE MODAL
=========================================== -->

<div class="modal fade"
     id="addMessageModal"
     tabindex="-1"
     aria-labelledby="addMessageModalLabel"
     aria-hidden="true">


<div class="modal-dialog modal-dialog-centered modal-xl">

    <div class="modal-content">

        <div class="modal-header">

            <div class="d-flex align-items-center">

                <div class="modal-header-icon">
                    <i class="bi bi-plus-lg"></i>
                </div>

                <div>

                    <div class="modal-title"
                         id="addMessageModalLabel">

                        Yangi xabar qo‘shish

                    </div>

                    <small class="text-muted">
                        Xabar ma'lumotlarini kiriting
                    </small>

                </div>

            </div>


            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
            </button>

        </div>


        <!-- FORM -->

        <form action="{{ route('aloqa.store') }}"
              method="POST">

            @csrf

            <div class="modal-body">

                <div class="row g-3">

                    <!-- ISM -->

                    <div class="col-md-6">

                        <label for="name"
                               class="form-label">

                            Ism Familiya
                            <span class="required-star">*</span>

                        </label>

                        <input type="text"
                               name="name"
                               id="name"
                               class="form-control"
                               placeholder="Masalan: Ali Valiyev"
                               value="{{ old('name') }}"
                               required>

                    </div>


                    <!-- EMAIL -->

                    <div class="col-md-6">

                        <label for="email"
                               class="form-label">

                            Email

                        </label>

                        <input type="email"
                               name="email"
                               id="email"
                               class="form-control"
                               placeholder="ali@example.com"
                               value="{{ old('email') }}">

                    </div>


                    <!-- TELEFON -->

                    <div class="col-md-6">

                        <label for="phone"
                               class="form-label">

                            Telefon

                        </label>

                        <input type="text"
                               name="phone"
                               id="phone"
                               class="form-control"
                               placeholder="+998 90 123 45 67"
                               value="{{ old('phone') }}">

                    </div>


                    <!-- MAVZU -->

                    <div class="col-md-6">

                        <label for="subject"
                               class="form-label">

                            Mavzu

                        </label>

                        <input type="text"
                               name="subject"
                               id="subject"
                               class="form-control"
                               placeholder="Xabar mavzusi"
                               value="{{ old('subject') }}">

                    </div>


                    <!-- XABAR -->

                    <div class="col-12">

                        <label for="message"
                               class="form-label">

                            Xabar matni
                            <span class="required-star">*</span>

                        </label>

                        <textarea name="message"
                                  id="message"
                                  rows="5"
                                  class="form-control"
                                  placeholder="Xabarni kiriting..."
                                  required>{{ old('message') }}</textarea>

                    </div>

                </div>

            </div>


            <div class="modal-footer">

                <button type="button"
                        class="btn btn-light border px-4"
                        data-bs-dismiss="modal">

                    Bekor qilish

                </button>

                <button type="submit"
                        class="btn btn-primary px-4 fw-bold">

                    <i class="bi bi-check-lg me-1"></i>
                    Saqlash

                </button>

            </div>

        </form>

    </div>

</div>

</div>

<!-- ==========================================
     OPEN ADD MODAL IF VALIDATION ERROR
=========================================== -->

@if($errors->any())

<script>
document.addEventListener('DOMContentLoaded', function () {

    var addModalElement = document.getElementById('addMessageModal');

    if (addModalElement && typeof bootstrap !== 'undefined') {

        var addModal = new bootstrap.Modal(addModalElement);

        addModal.show();

    }

});
</script>

@endif

@endsection
