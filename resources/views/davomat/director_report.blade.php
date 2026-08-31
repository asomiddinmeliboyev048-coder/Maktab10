@extends('layouts.app')

@section('title', $sinf->name . ' hisobot')
@section('page-title', $sinf->name . ' hisobot')
@section('breadcrumb', 'Davomat')

@section('content')
<div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-bar-chart text-primary me-2"></i>
            {{ $sinf->name }} — Davomat hisoboti
        </h4>
        <div class="d-flex gap-2">
            <a href="{{ route('davomat.director.report.export', ['sinf' => $sinf->id, 'davr' => $davr]) }}"
               class="btn btn-success">
                <i class="bi bi-file-earmark-excel me-1"></i> Excel yuklab olish
            </a>
            <a href="{{ route('davomat.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Orqaga
            </a>
        </div>
    </div>

    <div class="d-flex gap-2 mb-4">
        <a href="{{ route('davomat.director.report', ['sinf' => $sinf->id, 'davr' => 'haftalik']) }}"
           class="btn btn-sm {{ $davr === 'haftalik' ? 'btn-primary' : 'btn-outline-primary' }}">
            Haftalik
        </a>
        <a href="{{ route('davomat.director.report', ['sinf' => $sinf->id, 'davr' => 'oylik']) }}"
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
                        @foreach($statusLabels as $code => $meta)
                            <th class="text-center">{{ strtoupper($code) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($oquvchilar as $i => $o)
                        @php $recs = $statuslar->get($o->id, collect()); @endphp
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td class="fw-semibold">{{ $o->fio }}</td>
                            @foreach($statusLabels as $code => $meta)
                                <td class="text-center">
                                    {{ $recs->where('status', $code)->count() ?: '—' }}
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 2 + count($statusLabels) }}" class="text-center text-muted py-4">
                                Bu sinfda o'quvchi yo'q.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection