@extends('layouts.app')

@section('title', $sinf->name . ' baho hisobot')
@section('page-title', $sinf->name . ' baho hisobot')
@section('breadcrumb', 'Baholar')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-bar-chart text-primary me-2"></i>
            {{ $sinf->name }} — Baholar hisoboti
        </h4>
        <div class="d-flex gap-2">
            <a href="{{ route('baholar.director.report.export', ['sinf' => $sinf->id, 'davr' => $davr]) }}"
               class="btn btn-success">
                <i class="bi bi-file-earmark-excel me-1"></i> Excel yuklab olish
            </a>
            <a href="{{ route('baholar.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Orqaga
            </a>
        </div>
    </div>

    <div class="d-flex gap-2 mb-4">
        <a href="{{ route('baholar.director.report', ['sinf' => $sinf->id, 'davr' => 'haftalik']) }}"
           class="btn btn-sm {{ $davr === 'haftalik' ? 'btn-primary' : 'btn-outline-primary' }}">
            Haftalik
        </a>
        <a href="{{ route('baholar.director.report', ['sinf' => $sinf->id, 'davr' => 'oylik']) }}"
           class="btn btn-sm {{ $davr === 'oylik' ? 'btn-primary' : 'btn-outline-primary' }}">
            Oylik
        </a>
        <span class="text-muted align-self-center ms-2">
            {{ $boshlanish->format('d.m.Y') }} — {{ $tugash->format('d.m.Y') }}
        </span>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>F.I.O</th>
                        <th class="text-center">Baholar soni</th>
                        <th class="text-center">O'rtacha baho</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($oquvchilar as $i => $o)
                        @php $recs = $baholar->get($o->id, collect()); @endphp
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td class="fw-semibold">{{ $o->fio }}</td>
                            <td class="text-center">{{ $recs->count() ?: '—' }}</td>
                            <td class="text-center">
                                @if($recs->count() > 0)
                                    <span class="badge bg-primary">{{ round($recs->avg('baho'), 2) }}</span>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Bu sinfda o'quvchi yo'q.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection