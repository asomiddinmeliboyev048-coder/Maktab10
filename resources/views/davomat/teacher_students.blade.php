@extends('layouts.app')

@section('title', $sinf->name . ' o\'quvchilari')
@section('page-title', $sinf->name . ' o\'quvchilari')
@section('breadcrumb', 'Davomat')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-people text-primary me-2"></i>
            {{ $sinf->name }} sinfi o'quvchilari
        </h4>
        <div class="d-flex gap-2">
            <a href="{{ route('davomat.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Orqaga
            </a>
            <a href="{{ route('davomat.mark', $sinf->id) }}" class="btn btn-success">
                <i class="bi bi-calendar-check me-1"></i> Davomat qilish
            </a>
        </div>
    </div>

    <div class="row g-3">
        @forelse($oquvchilar as $o)
            <div class="col-md-6 col-xl-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                             style="width:50px;height:50px;flex-shrink:0;">
                            <i class="bi bi-person-fill text-primary fs-4"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">{{ $o->fio }}</div>
                            <small class="text-muted">{{ $o->student_id }}</small>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-4">
                Ushbu sinfda hozircha o'quvchi yo'q.
            </div>
        @endforelse
    </div>

</div>
@endsection