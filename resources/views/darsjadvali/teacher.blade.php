@extends('layouts.app')

@section('title', 'Mening dars jadvalim')
@section('page-title', 'Mening dars jadvalim')
@section('breadcrumb', 'Dars jadvali')

@section('content')

<div class="container-fluid">

    {{-- BUGUNGI DARSLAR --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="card-title text-white p-0 m-0 fs-6">
                <i class="bi bi-calendar-check me-2"></i> Bugungi darslarim ({{ $bugungiKun }})
            </h5>
        </div>
        <div class="card-body pt-3">
            @if($bugungiDarslar->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 100px;">Dars T/R</th>
                                <th style="width: 160px;">Vaqti</th>
                                <th style="width: 120px;">Sinf</th>
                                <th>Fan nomi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bugungiDarslar as $dars)
                                <tr>
                                    <td><span class="badge bg-secondary px-2 py-1">{{ $dars->tartib }}-dars</span></td>
                                    <td><i class="bi bi-clock me-1 text-muted"></i> {{ $dars->vaqti ?: '—' }}</td>
                                    <td>
                                        <span class="badge bg-primary fs-6">
                                            {{ $dars->sinf->name ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="fw-bold text-dark">{{ $dars->fan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-cup-hot fs-1 text-primary"></i>
                    <p class="mt-2 mb-0 fw-semibold">Bugun sizda darslar mavjud emas.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- 1 HAFTALIK TO'LIQ DARS JADVALI --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="card-title p-0 m-0 text-dark fs-6">
                <i class="bi bi-calendar-week me-2 text-primary"></i> 1 haftalik to‘liq dars jadvalim
            </h5>
        </div>
        <div class="card-body pt-3">
            @if($haftalikJadval->count() > 0)
                <div class="row g-4">
                    @foreach(['Dushanba', 'Seshanba', 'Chorshanba', 'Payshanba', 'Juma', 'Shanba'] as $kun)
                        @if(isset($haftalikJadval[$kun]))
                            <div class="col-md-6 col-xl-4">
                                <div class="card h-100 border bg-light shadow-none mb-0">
                                    <div class="card-header bg-white fw-bold text-primary border-bottom d-flex justify-content-between align-items-center">
                                        <span>{{ $kun }}</span>
                                        <span class="badge bg-light text-muted border">{{ count($haftalikJadval[$kun]) }} ta dars</span>
                                    </div>
                                    <ul class="list-group list-group-flush bg-transparent">
                                        @foreach($haftalikJadval[$kun] as $dars)
                                            <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center py-2">
                                                <div>
                                                    <small class="text-muted d-block">{{ $dars->tartib }}-dars ({{ $dars->vaqti }})</small>
                                                    <div class="fw-bold text-dark">{{ $dars->fan }}</div>
                                                </div>
                                                <span class="badge bg-primary rounded-pill px-2 py-1">
                                                    {{ $dars->sinf->name ?? '' }}
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-calendar-x fs-1"></i>
                    <p class="mt-2 mb-0">Hozircha sizga biriktirilgan darslar jadvali mavjud emas.</p>
                </div>
            @endif
        </div>
    </div>

</div>

@endsection