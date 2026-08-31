@extends('layouts.app')

@section('title', $sinf->name . ' sinfi dars jadvali')
@section('page-title', $sinf->name . ' sinfi dars jadvali')
@section('breadcrumb', 'Dars jadvali')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="bi bi-calendar3 text-primary me-2"></i>
                {{ $sinf->name }} sinfi dars jadvali
            </h4>
            <p class="text-muted mb-0">
                Haftalik to‘liq dars jadvali va darslarni boshqarish
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('darsjadvali.index') }}" class="btn btn-light border">
                <i class="bi bi-arrow-left me-1"></i> Orqaga
            </a>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLessonModal">
                <i class="bi bi-plus-lg me-1"></i> Yangi dars qo‘shish
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        @foreach(['Dushanba', 'Seshanba', 'Chorshanba', 'Payshanba', 'Juma', 'Shanba'] as $kun)
            <div class="col-lg-6 col-xl-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h6 class="m-0 fw-bold text-primary">
                            <i class="bi bi-calendar-event me-1"></i> {{ $kun }}
                        </h6>
                        <span class="badge bg-light text-muted border">
                            {{ isset($darslar[$kun]) ? count($darslar[$kun]) : 0 }} ta dars
                        </span>
                    </div>
                    <div class="card-body p-0">
                        @if(isset($darslar[$kun]) && count($darslar[$kun]) > 0)
                            <ul class="list-group list-group-flush">
                                @foreach($darslar[$kun] as $dars)
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                        <div>
                                            <div class="fw-bold text-dark">
                                                {{ $dars->tartib }}-dars. {{ $dars->fan }}
                                            </div>
                                            <small class="text-muted d-block">
                                                <i class="bi bi-clock me-1"></i> {{ $dars->vaqti ?: 'Vaqt belgilanmagan' }}
                                            </small>
                                            <small class="text-muted d-block">
                                                <i class="bi bi-person me-1"></i> {{ $dars->oqituvchi_ism ?: ($dars->oqituvchi->name ?? 'Biriktirilmagan') }}
                                            </small>
                                        </div>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('darsjadvali.edit', $dars->id) }}" class="btn btn-sm btn-outline-warning" title="Tahrirlash">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('darsjadvali.destroy', $dars->id) }}" method="POST" onsubmit="return confirm('Ushbu darsni o‘chirmoqchimisiz?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="O‘chirish">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center py-4 text-muted">
                                <small>Bu kunga darslar qo‘yilmagan</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>

{{-- YANGI DARS QO'SHISH MODALI --}}
<div class="modal fade" id="addLessonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('darsjadvali.store', $sinf->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Yangi dars qo‘shish</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kun</label>
                        <select name="kun" class="form-select" required>
                            @foreach(['Dushanba', 'Seshanba', 'Chorshanba', 'Payshanba', 'Juma', 'Shanba'] as $k)
                                <option value="{{ $k }}">{{ $k }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Dars T/R</label>
                        <input type="text" name="dars_raqami" class="form-control" placeholder="Masalan: 1-dars" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Vaqti</label>
                        <input type="text" name="vaqti" class="form-control" placeholder="Masalan: 08:30 - 09:15">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Fan nomi</label>
                        <input type="text" name="fan" class="form-control" placeholder="Masalan: Matematika" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">O‘qituvchi</label>
                        <select name="oqituvchi_id" class="form-select">
                            <option value="">— O‘qituvchini tanlang —</option>
                            @foreach($oqituvchilar as $oqituvchi)
                                <option value="{{ $oqituvchi->id }}">{{ $oqituvchi->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Bekor qilish</button>
                    <button type="submit" class="btn btn-primary">Saqlash</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection