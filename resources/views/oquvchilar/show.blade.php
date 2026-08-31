@extends('layouts.app')

@section('title', 'O‘quvchi maʼlumotlari')
@section('page-title', 'O‘quvchi maʼlumotlari')
@section('breadcrumb', 'O‘quvchi maʼlumotlari')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="bi bi-person-vcard text-primary me-2"></i>
                O‘quvchi maʼlumotlari
            </h4>
            <p class="text-muted mb-0">
                O‘quvchining shaxsiy va maktab maʼlumotlari
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('oquvchilar.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Orqaga
            </a>
            <a href="{{ route('oquvchilar.edit', $oquvchi->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-1"></i> Tahrirlash
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="mx-auto mb-3 rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                        style="width:110px;height:110px;">
                        <i class="bi bi-person-fill text-primary" style="font-size:55px;"></i>
                    </div>

                    <h4 class="fw-bold mb-1">{{ $oquvchi->fio }}</h4>

                    <div class="mb-3">
                        <span class="badge bg-light text-dark border">
                            <i class="bi bi-person-badge me-1"></i>
                            {{ $oquvchi->student_id }}
                        </span>
                    </div>

                    @if($oquvchi->sinf)
                        <div class="mb-3">
                            <span class="badge bg-primary px-3 py-2">
                                <i class="bi bi-building me-1"></i>
                                {{ $oquvchi->sinf->name }}
                            </span>
                        </div>
                    @else
                        <div class="mb-3">
                            <span class="badge bg-warning text-dark px-3 py-2">
                                <i class="bi bi-exclamation-circle me-1"></i>
                                Sinf biriktirilmagan
                            </span>
                        </div>
                    @endif

                    <hr>

                    <div class="text-start">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                                style="width:40px;height:40px;">
                                <i class="bi bi-telephone text-success"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Telefon</small>
                                <span class="fw-semibold">{{ $oquvchi->phone ?: 'Ko‘rsatilmagan' }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                                style="width:40px;height:40px;">
                                <i class="bi bi-geo-alt text-info"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Manzil</small>
                                <span class="fw-semibold">{{ $oquvchi->address ?: 'Ko‘rsatilmagan' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-info-circle text-primary me-2"></i>
                        Batafsil maʼlumot
                    </h5>
                </div>

                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="text-muted small mb-1">O‘quvchining F.I.O si</div>
                            <div class="fw-semibold fs-6">{{ $oquvchi->fio }}</div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="text-muted small mb-1">O‘quvchi ID</div>
                            <div>
                                <span class="badge bg-light text-dark border px-3 py-2">
                                    <i class="bi bi-hash me-1"></i>
                                    {{ $oquvchi->student_id }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="text-muted small mb-1">Sinf</div>
                            <div>
                                @if($oquvchi->sinf)
                                    <span class="badge bg-primary px-3 py-2">
                                        <i class="bi bi-building me-1"></i>
                                        {{ $oquvchi->sinf->name }}
                                    </span>
                                @else
                                    <span class="text-muted">Biriktirilmagan</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="text-muted small mb-1">Sinf rahbari</div>
                            <div class="fw-semibold">
                                @if($oquvchi->sinf && $oquvchi->sinf->teacher)
                                    <i class="bi bi-person-check text-success me-1"></i>
                                    {{ $oquvchi->sinf->teacher->name }}
                                @else
                                    <span class="text-muted">Belgilanmagan</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="text-muted small mb-1">Telefon raqami</div>
                            <div class="fw-semibold">
                                @if($oquvchi->phone)
                                    <i class="bi bi-telephone text-success me-1"></i>
                                    {{ $oquvchi->phone }}
                                @else
                                    <span class="text-muted">Ko‘rsatilmagan</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="text-muted small mb-1">Yashash manzili</div>
                            <div class="fw-semibold">
                                @if($oquvchi->address)
                                    <i class="bi bi-geo-alt text-danger me-1"></i>
                                    {{ $oquvchi->address }}
                                @else
                                    <span class="text-muted">Ko‘rsatilmagan</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- O'QUVCHINING SINF DARS JADVALI (1 HAFTALIK) --}}
            @php
                $sinfDarsJadvali = collect();
                if ($oquvchi->sinf_id) {
                    $sinfDarsJadvali = \App\DarsJadvali::where('sinf_id', $oquvchi->sinf_id)
                        ->orderByRaw("FIELD(kun,'Dushanba','Seshanba','Chorshanba','Payshanba','Juma','Shanba','Yakshanba')")
                        ->orderBy('tartib', 'asc')
                        ->get()
                        ->groupBy('kun');
                }
            @endphp

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-calendar-week text-primary me-2"></i>
                        Sinf dars jadvali @if($oquvchi->sinf) ({{ $oquvchi->sinf->name }}) @endif
                    </h5>
                    @if($oquvchi->sinf_id)
                        <a href="{{ route('darsjadvali.show', $oquvchi->sinf_id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-box-arrow-up-right me-1"></i> To‘liq jadval
                        </a>
                    @endif
                </div>

                <div class="card-body p-3">
                    @if($sinfDarsJadvali->count() > 0)
                        <div class="row g-3">
                            @foreach(['Dushanba', 'Seshanba', 'Chorshanba', 'Payshanba', 'Juma', 'Shanba'] as $kun)
                                @if(isset($sinfDarsJadvali[$kun]))
                                    <div class="col-md-6 col-xl-4">
                                        <div class="card border h-100 shadow-none mb-0 bg-light">
                                            <div class="card-header bg-white py-2 fw-bold text-primary border-bottom">
                                                {{ $kun }}
                                            </div>
                                            <ul class="list-group list-group-flush bg-transparent small">
                                                @foreach($sinfDarsJadvali[$kun] as $d)
                                                    <li class="list-group-item bg-transparent d-flex justify-content-between align-items-start py-2">
                                                        <div>
                                                            <div class="fw-bold text-dark">{{ $d->tartib }}-dars. {{ $d->fan }}</div>
                                                            <div class="text-muted" style="font-size: 11px;">
                                                                <i class="bi bi-person me-1"></i>{{ $d->oqituvchi_ism ?: ($d->oqituvchi->name ?? 'Biriktirilmagan') }}
                                                            </div>
                                                        </div>
                                                        @if($d->vaqti)
                                                            <span class="badge bg-white text-muted border" style="font-size: 10px;">{{ $d->vaqti }}</span>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-calendar-x fs-2"></i>
                            <p class="mt-2 mb-0">Ushbu o‘quvchining sinfi uchun hali dars jadvali yuklanmagan.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

</div>

@endsection