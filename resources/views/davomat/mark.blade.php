@extends('layouts.app')

@section('title', $sinf->name . ' davomati')
@section('page-title', $sinf->name . ' davomati')
@section('breadcrumb', 'Davomat')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-calendar-check text-primary me-2"></i>
            {{ $sinf->name }} — {{ $sana->translatedFormat('d.m.Y') }}
        </h4>
        <a href="{{ route('davomat.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Orqaga
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Sana tanlash --}}
    <form method="GET" action="{{ route('davomat.mark', $sinf->id) }}" class="d-flex gap-2 mb-4">
        <input type="date" name="sana" value="{{ $sana->format('Y-m-d') }}"
               class="form-control" style="max-width:220px;" onchange="this.form.submit()">
    </form>

    {{-- Belgilar izohi --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row g-3">
                <div class="col-md-6 col-lg-4 col-xl-2p4 d-flex align-items-start">
                    <span class="badge bg-success me-2 mt-1">KELDI</span>
                    <small class="text-muted">O'quvchi darsga keldi va qatnashdi</small>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-2p4 d-flex align-items-start">
                    <span class="badge bg-danger me-2 mt-1">SZ</span>
                    <small class="text-muted">Sababsiz kelmadi</small>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-2p4 d-flex align-items-start">
                    <span class="badge bg-warning text-dark me-2 mt-1">SB</span>
                    <small class="text-muted">Sababli kelmadi (oldindan ogohlantirilgan)</small>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-2p4 d-flex align-items-start">
                    <span class="badge bg-secondary me-2 mt-1">KQ</span>
                    <small class="text-muted">Maktabga keldi, lekin darsda qatnashmadi</small>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-2p4 d-flex align-items-start">
                    <span class="badge bg-info text-dark me-2 mt-1">KC</span>
                    <small class="text-muted">Darsga kechikib kirdi</small>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('davomat.store', $sinf->id) }}">
        @csrf
        <input type="hidden" name="sana" value="{{ $sana->format('Y-m-d') }}">

        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>F.I.O</th>
                            <th style="min-width:420px;">Holati</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($oquvchilar as $i => $o)
                            @php $current = $existing[$o->id] ?? 'keldi'; @endphp
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td class="fw-semibold">{{ $o->fio }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @foreach($statusLabels as $code => $meta)
                                            <input type="radio"
                                                   class="btn-check"
                                                   name="statuses[{{ $o->id }}]"
                                                   id="st_{{ $o->id }}_{{ $code }}"
                                                   value="{{ $code }}"
                                                   {{ $current === $code ? 'checked' : '' }}>
                                            <label class="btn btn-outline-{{ $meta['badge'] }} btn-sm"
                                                   for="st_{{ $o->id }}_{{ $code }}">
                                                {{ strtoupper($code) }}
                                            </label>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white p-3 text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i> Saqlash
                </button>
            </div>
        </div>
    </form>

</div>
@endsection