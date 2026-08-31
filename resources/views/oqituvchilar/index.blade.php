@extends('layouts.app')

@section('content')

{{-- ============================================================
    SAHIFA SARLAVHASI VA BREADCRUMB (NiceAdmin uslubida)
============================================================= --}}
<div class="pagetitle d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1>O‘qituvchilar</h1>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">O‘qituvchilar</li>
            </ol>
        </nav>
    </div>

    <div>
        <a href="{{ route('oqituvchilar.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> O‘qituvchi qo‘shish
        </a>
    </div>
</div>

<section class="section">

    {{-- ============================================================
        SUCCESS XABAR
    ============================================================= --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show smart-alert" role="alert">
            <i class="bi bi-check-circle me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- ============================================================
        ERROR XABAR
    ============================================================= --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show smart-alert" role="alert">
            <i class="bi bi-exclamation-octagon me-1"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- ============================================================
        VALIDATION XATOLARI
    ============================================================= --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show smart-alert" role="alert">
            <div class="d-flex align-items-center mb-1">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Xatolik yuz berdi:</strong>
            </div>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    {{-- ============================================================
        STATISTIKA KARTALARI (NiceAdmin info-card uslubi)
    ============================================================= --}}
    @php
        $teacherCount = $oqituvchilar->getCollection()->where('role', 'teacher')->count();
        $deputyCount  = $oqituvchilar->getCollection()->where('role', 'deputy')->count();
    @endphp

    <div class="row mb-4">
        {{-- O'QITUVCHILAR --}}
        <div class="col-xxl-4 col-md-4 mb-3 mb-md-0">
            <div class="card info-card sales-card h-100 mb-0">
                <div class="card-body">
                    <h5 class="card-title text-muted text-uppercase pb-1" style="font-size: 13px; letter-spacing: 0.5px;">O‘qituvchilar</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary" style="width: 50px; height: 50px;">
                            <i class="bi bi-person-video3 fs-4"></i>
                        </div>
                        <div class="ps-3">
                            <h4 class="fw-bold mb-0 text-dark" data-counter="{{ $teacherCount }}">0</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- DIREKTOR O'RINBOSARLARI --}}
        <div class="col-xxl-4 col-md-4 mb-3 mb-md-0">
            <div class="card info-card revenue-card h-100 mb-0">
                <div class="card-body">
                    <h5 class="card-title text-muted text-uppercase pb-1" style="font-size: 13px; letter-spacing: 0.5px;">Direktor o‘rinbosarlari</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning" style="width: 50px; height: 50px;">
                            <i class="bi bi-person-badge fs-4"></i>
                        </div>
                        <div class="ps-3">
                            <h4 class="fw-bold mb-0 text-dark" data-counter="{{ $deputyCount }}">0</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- JAMI XODIMLAR --}}
        <div class="col-xxl-4 col-md-4">
            <div class="card info-card customers-card h-100 mb-0">
                <div class="card-body">
                    <h5 class="card-title text-muted text-uppercase pb-1" style="font-size: 13px; letter-spacing: 0.5px;">Jami xodimlar</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success" style="width: 50px; height: 50px;">
                            <i class="bi bi-people fs-4"></i>
                        </div>
                        <div class="ps-3">
                            <h4 class="fw-bold mb-0 text-dark" data-counter="{{ $oqituvchilar->total() }}">0</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- ============================================================
        ASOSIY JADVAL
    ============================================================= --}}
    <div class="card">
        <div class="card-body pt-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title p-0 m-0">Xodimlar ro‘yxati</h5>
                <span class="badge bg-light text-secondary border">
                    Jami: <strong class="text-dark">{{ $oqituvchilar->total() }}</strong> ta
                </span>
            </div>

            @if($oqituvchilar->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th class="text-nowrap">Xodim ID</th>
                                <th>Xodim</th>
                                <th>Lavozim</th>
                                <th>Fan</th>
                                <th>Telefon</th>
                                <th>Login (Email)</th>
                                <th class="text-center text-nowrap" style="width: 140px;">Amallar</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($oqituvchilar as $index => $oqituvchi)
                                <tr>
                                    {{-- RAQAM --}}
                                    <td class="text-center text-muted fw-bold">
                                        {{ $oqituvchilar->firstItem() + $index }}
                                    </td>

                                    {{-- STAFF ID --}}
                                    <td class="text-nowrap">
                                        @if($oqituvchi->staff_id)
                                            <span class="badge bg-dark">
                                                {{ $oqituvchi->staff_id }}
                                            </span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                    {{-- XODIM (FIO + RASM) --}}
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-3 flex-shrink-0">
                                                @if($oqituvchi->avatar)
                                                    <img src="{{ asset('storage/' . $oqituvchi->avatar) }}"
                                                         alt="{{ $oqituvchi->name }}"
                                                         class="rounded-circle shadow-sm"
                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle bg-light text-secondary d-flex align-items-center justify-content-center border"
                                                         style="width: 40px; height: 40px;">
                                                        <i class="bi bi-person fs-5"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $oqituvchi->name }}</div>
                                                <small class="text-muted">ID: {{ $oqituvchi->id }}</small>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- LAVOZIM --}}
                                    <td class="text-nowrap">
                                        @if($oqituvchi->role === 'teacher')
                                            <span class="badge bg-primary">
                                                <i class="bi bi-person-video3 me-1"></i> O‘qituvchi
                                            </span>
                                        @elseif($oqituvchi->role === 'deputy')
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-person-badge me-1"></i> Direktor o‘rinbosari
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                {{ $oqituvchi->role }}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- FAN --}}
                                    <td>
                                        @if($oqituvchi->subject)
                                            <div class="d-flex align-items-center text-dark">
                                                <i class="bi bi-journal-bookmark text-primary me-2"></i>
                                                <span>{{ $oqituvchi->subject }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted small">Fan yo‘q</span>
                                        @endif
                                    </td>

                                    {{-- TELEFON --}}
                                    <td class="text-nowrap">
                                        @if($oqituvchi->phone)
                                            <a href="tel:{{ $oqituvchi->phone }}" class="text-decoration-none text-dark">
                                                <i class="bi bi-telephone text-success me-1"></i>
                                                {{ $oqituvchi->phone }}
                                            </a>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                    {{-- LOGIN (EMAIL) --}}
                                    <td>
                                        @if($oqituvchi->email)
                                            <span class="text-muted small">
                                                <i class="bi bi-envelope text-primary me-1"></i>
                                                {{ $oqituvchi->email }}
                                            </span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                    {{-- AMALLAR (TUGMALAR) --}}
                                    <td class="text-center text-nowrap">
                                        <div class="d-inline-flex gap-1">
                                            {{-- KO'RISH --}}
                                            <a href="{{ route('oqituvchilar.show', $oqituvchi->id) }}"
                                               class="btn btn-sm btn-outline-info"
                                               data-bs-toggle="tooltip"
                                               data-bs-placement="top"
                                               title="Ko‘rish">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            {{-- TAHRIRLASH --}}
                                            <a href="{{ route('oqituvchilar.edit', $oqituvchi->id) }}"
                                               class="btn btn-sm btn-outline-warning"
                                               data-bs-toggle="tooltip"
                                               data-bs-placement="top"
                                               title="Tahrirlash">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            {{-- O'CHIRISH --}}
                                            <form action="{{ route('oqituvchilar.destroy', $oqituvchi->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Haqiqatan ham {{ $oqituvchi->name }} ni o‘chirmoqchimisiz?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        title="O‘chirish">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                {{-- BO'SH HOLAT --}}
                <div class="text-center py-5">
                    <div class="mb-3 text-muted">
                        <i class="bi bi-person-x fs-1"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Hozircha xodimlar mavjud emas</h5>
                    <p class="text-muted mb-4 small">
                        Tizimga o‘qituvchi yoki direktor o‘rinbosari qo‘shish uchun quyidagi tugmani bosing.
                    </p>
                    <a href="{{ route('oqituvchilar.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i> Birinchi xodimni qo‘shish
                    </a>
                </div>
            @endif

            {{-- PAGINATION --}}
            @if($oqituvchilar->hasPages())
                <div class="d-flex justify-content-between align-items-center flex-wrap pt-3 border-top mt-3">
                    <div class="text-muted small">
                        Ko‘rsatilmoqda: <strong>{{ $oqituvchilar->firstItem() }}</strong> - <strong>{{ $oqituvchilar->lastItem() }}</strong> / Jami: <strong>{{ $oqituvchilar->total() }}</strong>
                    </div>
                    <div>
                        {{ $oqituvchilar->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif

        </div>
    </div>

</section>

@endsection