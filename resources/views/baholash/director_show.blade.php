@extends('layouts.app')

@section('title', $sinf->name . ' baholari')
@section('page-title', $sinf->name . ' baholari')
@section('breadcrumb', 'Baholar')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-star text-primary me-2"></i>
            {{ $sinf->name }} — {{ $sana->translatedFormat('d.m.Y') }}
        </h4>
        <div class="d-flex gap-2">
            <a href="{{ route('baholar.director.report', $sinf->id) }}" class="btn btn-outline-dark">
                <i class="bi bi-bar-chart me-1"></i> Hisobot
            </a>
            <a href="{{ route('baholar.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Orqaga
            </a>
        </div>
    </div>

    <div class="alert alert-info d-flex align-items-center">
        <i class="bi bi-shield-lock me-2"></i>
        Bu ma'lumot faqat ko'rish uchun — baholarni faqat sinfga dars beruvchi o'qituvchi o'zgartira oladi.
    </div>

    {{-- Sana tanlash --}}
    <form method="GET" action="{{ route('baholar.director.show', $sinf->id) }}" class="d-flex gap-2 mb-4">
        <input type="date" name="sana" value="{{ $sana->format('Y-m-d') }}"
               class="form-control" style="max-width:220px;" onchange="this.form.submit()">
    </form>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>F.I.O</th>
                        <th>Baho</th>
                        <th>Fan</th>
                        <th>Qo'ygan o'qituvchi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($oquvchilar as $i => $o)
                        @php $recs = $baholar->get($o->id, collect()); @endphp
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td class="fw-semibold">{{ $o->fio }}</td>
                            <td>
                                @forelse($recs as $b)
                                    <span class="badge bg-primary me-1">{{ $b->baho }}</span>
                                @empty
                                    <span class="badge bg-light text-dark border">Baholanmagan</span>
                                @endforelse
                            </td>
                            <td class="text-muted small">
                                {{ $recs->pluck('fan')->filter()->unique()->implode(', ') ?: '—' }}
                            </td>
                            <td class="text-muted small">
                                {{ $recs->first() && $recs->first()->teacher ? $recs->first()->teacher->name : '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Bu sinfda o'quvchi yo'q.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection