@extends('layouts.app')

@section('title', 'Dars jadvalini yuklash')
@section('page-title', 'Dars jadvalini yuklash')
@section('breadcrumb', 'Excel yuklash')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="bi bi-file-earmark-excel text-success me-2"></i>
                Dars jadvalini Excel orqali yuklash
            </h4>
            <p class="text-muted mb-0">
                Bitta faylda bir nechta sinfning haftalik jadvalini birga yuklashingiz mumkin.
            </p>
        </div>
        <a href="{{ route('darsjadvali.index') }}" class="btn btn-light border">
            <i class="bi bi-arrow-left me-1"></i>
            Orqaga
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('darsjadvali.import') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="excel_file" class="form-label fw-semibold">
                                Excel fayl <span class="text-danger">*</span>
                            </label>
                            <input type="file" id="excel_file" name="excel_file" class="form-control" accept=".xlsx,.xls" required>
                            <div class="form-text">
                                XLSX yoki XLS format. Maksimal 10 MB.
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-upload me-1"></i>
                            Yuklash
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-info-circle text-primary me-2"></i>
                        Excel fayl qanday tuzilgan bo‘lishi kerak
                    </h6>
                    <ul class="small text-muted mb-0 ps-3">
                        <li class="mb-2">
                            Bitta varaqda barcha sinflar ketma-ket <strong>"📌 11-A-SINF DARS JADVALI"</strong> sarlavhasi bilan joylashishi mumkin.
                        </li>
                        <li class="mb-2">
                            Yoki har bir sinf uchun alohida varaq (sheet) bo‘lishi mumkin: <strong>"Sinf 11-A"</strong>.
                        </li>
                        <li class="mb-2">
                            Har bir jadvalda ustunlar: <strong>Kun, Dars T/R, Vaqti, Fan Nomi, O‘qituvchi (Ismi va Familiyasi)</strong>.
                        </li>
                        <li class="mb-2">
                            O‘qituvchi ismi tizimdagi xodim ismi bilan bir xil yozilsa, avtomatik bog‘lanadi.
                        </li>
                        <li>
                            Fayl qayta yuklansa, mos sinflar uchun eski jadval yangisi bilan to‘liq almashtiriladi.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection