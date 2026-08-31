@extends('layouts.app')

@section('title', 'Sinf qo‘shish')
@section('page-title', 'Sinf qo‘shish')
@section('breadcrumb', 'Sinf qo‘shish')

@section('content')

@php
    // Agar Controller'dan $teachers kelmagan yoki bo'sh kelgan bo'lsa, 
    // bazadagi barcha o'qituvchilar va direktor o'rinbosarlarini olib beradi:
    if (!isset($teachers) || $teachers->isEmpty()) {
        $teachers = \App\User::whereIn('role', ['teacher', 'deputy'])->orderBy('name')->get();
    }
@endphp

<div class="container-fluid">

    {{-- =========================================================
         HEADER
    ========================================================== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="bi bi-building-add text-primary me-2"></i>
                Yangi sinf qo‘shish
            </h4>
            <p class="text-muted mb-0">
                Sinf ma’lumotlarini kiriting yoki Excel orqali o‘quvchilarni yuklang.
            </p>
        </div>

        <a href="{{ route('sinflar.index') }}" class="btn btn-light border">
            <i class="bi bi-arrow-left me-1"></i> Orqaga
        </a>
    </div>

    {{-- =========================================================
         VALIDATION ERRORS
    ========================================================== --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <div class="fw-bold mb-2">
                <i class="bi bi-exclamation-triangle me-2"></i>
                Ma’lumotlarni tekshiring
            </div>
            <ul class="mb-0 ps-4">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- =========================================================
         ERROR SESSION
    ========================================================== --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- =========================================================
         SUCCESS SESSION
    ========================================================== --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    <form method="POST" action="{{ route('sinflar.store') }}" enctype="multipart/form-data" id="sinfCreateForm">
        @csrf

        {{-- =====================================================
             1. SINF MA'LUMOTLARI
        ====================================================== --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                        style="width:44px;height:44px;">
                        <i class="bi bi-building text-primary fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Sinf ma’lumotlari</h5>
                        <small class="text-muted">Asosiy sinf ma’lumotlarini kiriting</small>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row g-4">

                    {{-- SINF NOMI --}}
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">
                            Sinf nomi <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                            id="name"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="Masalan: 11-A"
                            maxlength="50"
                            required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- SINF RAHBARI --}}
                    <div class="col-md-6">
                        <label for="teacher_id" class="form-label fw-semibold">
                            Sinf rahbari <span class="text-danger">*</span>
                        </label>
                        <select id="teacher_id"
                            name="teacher_id"
                            class="form-select @error('teacher_id') is-invalid @enderror"
                            required>
                            <option value="">— Sinf rahbarini tanlang —</option>

                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }} 
                                    ({{ $teacher->role === 'deputy' ? 'Direktor o‘rinbosari' : 'O‘qituvchi' }}{{ $teacher->subject ? ' - ' . $teacher->subject : '' }})
                                </option>
                            @endforeach
                        </select>

                        @error('teacher_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if($teachers->isEmpty())
                            <div class="form-text text-danger">
                                <i class="bi bi-exclamation-circle me-1"></i>
                                Hozircha bazada o‘qituvchi yoki direktor o‘rinbosarlari mavjud emas.
                            </div>
                        @else
                            <div class="form-text text-muted">
                                O‘qituvchilar va direktor o‘rinbosarlari ro‘yxati.
                            </div>
                        @endif
                    </div>

                    {{-- FAN --}}
                    <div class="col-md-6">
                        <label for="subject" class="form-label fw-semibold">
                            Asosiy fan <span class="text-muted fw-normal">(ixtiyoriy)</span>
                        </label>
                        <input type="text"
                            id="subject"
                            name="subject"
                            class="form-control @error('subject') is-invalid @enderror"
                            value="{{ old('subject') }}"
                            placeholder="Masalan: Matematika"
                            maxlength="255">
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- XONA --}}
                    <div class="col-md-6">
                        <label for="room" class="form-label fw-semibold">
                            Xona <span class="text-muted fw-normal">(ixtiyoriy)</span>
                        </label>
                        <input type="text"
                            id="room"
                            name="room"
                            class="form-control @error('room') is-invalid @enderror"
                            value="{{ old('room') }}"
                            placeholder="Masalan: 204-xona"
                            maxlength="100">
                        @error('room')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- =====================================================
             2. EXCEL IMPORT
        ====================================================== --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                        style="width:44px;height:44px;">
                        <i class="bi bi-file-earmark-excel text-success fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Excel orqali o‘quvchilarni yuklash</h5>
                        <small class="text-muted">Bir vaqtning o‘zida ko‘plab o‘quvchilarni qo‘shing</small>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="alert alert-info">
                    <div class="d-flex">
                        <i class="bi bi-info-circle fs-5 me-3"></i>
                        <div>
                            <div class="fw-bold mb-1">Excel fayli haqida</div>
                            <div>
                                Excel faylida o‘quvchilarning F.I.O, telefon raqami va manzil ma’lumotlari bo‘lishi mumkin.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 align-items-end">
                    {{-- FILE INPUT --}}
                    <div class="col-md-8">
                        <label for="excel_file" class="form-label fw-semibold">Excel fayl</label>
                        <input type="file"
                            id="excel_file"
                            name="excel_file"
                            class="form-control @error('excel_file') is-invalid @enderror"
                            accept=".xlsx,.xls,.csv">
                        @error('excel_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Ruxsat etilgan formatlar: <strong>.xlsx, .xls, .csv</strong>
                        </div>
                    </div>

                    {{-- TEMPLATE BUTTON --}}
                    <div class="col-md-4">
                        <button type="button" class="btn btn-outline-success w-100" id="downloadExcelTemplate">
                            <i class="bi bi-download me-1"></i> Excel namunani yuklab olish
                        </button>
                    </div>
                </div>

                {{-- FILE PREVIEW --}}
                <div id="excelPreview" class="mt-4 d-none">
                    <div class="border rounded p-3 bg-light">
                        <div class="d-flex align-items-center">
                            <div class="rounded bg-success bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                                style="width:45px;height:45px;">
                                <i class="bi bi-file-earmark-excel text-success fs-4"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold" id="excelFileName"></div>
                                <small class="text-muted" id="excelFileSize"></small>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger" id="removeExcel">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- EXPECTED COLUMNS --}}
                <div class="mt-4">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-table me-2"></i> Excel ustunlari
                    </h6>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Ustun</th>
                                    <th>Nomi</th>
                                    <th>Majburiyligi</th>
                                    <th>Misol</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>fio</code></td>
                                    <td>O‘quvchi F.I.O</td>
                                    <td><span class="badge bg-danger">Majburiy</span></td>
                                    <td>Aliyev Ali Valiyevich</td>
                                </tr>
                                <tr>
                                    <td><code>phone</code></td>
                                    <td>Telefon</td>
                                    <td><span class="badge bg-secondary">Ixtiyoriy</span></td>
                                    <td>+998 90 123 45 67</td>
                                </tr>
                                <tr>
                                    <td><code>address</code></td>
                                    <td>Manzil</td>
                                    <td><span class="badge bg-secondary">Ixtiyoriy</span></td>
                                    <td>Toshkent shahri</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- =====================================================
             3. ACTIONS
        ====================================================== --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        <i class="bi bi-shield-check me-1"></i>
                        Ma’lumotlar saqlashdan oldin tekshiriladi.
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('sinflar.index') }}" class="btn btn-light border">
                            Bekor qilish
                        </a>

                        <button type="submit" class="btn btn-primary" id="saveSinfBtn">
                            <i class="bi bi-check-circle me-1"></i>
                            Sinfni saqlash
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>

@endsection

{{-- STYLES --}}
@push('styles')
<style>
    #excelPreview { transition: all .2s ease; }
    .card { border-radius: 12px; }
    .card-header { border-bottom: 1px solid #eef1f5; }
    .form-control, .form-select { border-radius: 8px; min-height: 44px; }
    .input-group-text { border-radius: 8px 0 0 8px; }
    code {
        color: #198754;
        background: rgba(25, 135, 84, .08);
        padding: 3px 7px;
        border-radius: 5px;
    }
</style>
@endpush

{{-- JAVASCRIPT --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('excel_file');
    const preview = document.getElementById('excelPreview');
    const fileName = document.getElementById('excelFileName');
    const fileSize = document.getElementById('excelFileSize');
    const removeButton = document.getElementById('removeExcel');
    const form = document.getElementById('sinfCreateForm');
    const saveButton = document.getElementById('saveSinfBtn');

    if (fileInput) {
        fileInput.addEventListener('change', function () {
            if (!this.files || !this.files.length) {
                preview.classList.add('d-none');
                return;
            }

            const file = this.files[0];
            const allowedExtensions = ['xlsx', 'xls', 'csv'];
            const extension = file.name.split('.').pop().toLowerCase();

            if (!allowedExtensions.includes(extension)) {
                alert('Faqat .xlsx, .xls yoki .csv formatdagi faylni tanlang.');
                this.value = '';
                preview.classList.add('d-none');
                return;
            }

            const maxSize = 10 * 1024 * 1024;
            if (file.size > maxSize) {
                alert('Excel fayli 10 MB dan katta bo‘lmasligi kerak.');
                this.value = '';
                preview.classList.add('d-none');
                return;
            }

            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            preview.classList.remove('d-none');
        });
    }

    if (removeButton) {
        removeButton.addEventListener('click', function () {
            fileInput.value = '';
            preview.classList.add('d-none');
        });
    }

    if (form) {
        form.addEventListener('submit', function () {
            if (!saveButton) return;
            saveButton.disabled = true;
            saveButton.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Saqlanmoqda...';
        });
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const index = Math.floor(Math.log(bytes) / Math.log(1024));
        return parseFloat((bytes / Math.pow(1024, index)).toFixed(2)) + ' ' + sizes[index];
    }

    const templateButton = document.getElementById('downloadExcelTemplate');
    if (templateButton) {
        templateButton.addEventListener('click', function () {
            const csvContent = 'fio,phone,address\nAliyev Ali Valiyevich,+998901234567,Toshkent shahri\nKarimova Dilnoza Anvar qizi,+998931234567,Samarqand shahri\n';
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = 'oquvchilar_namuna.csv';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
        });
    }
});
</script>
@endpush