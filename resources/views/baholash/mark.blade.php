@extends('layouts.app')

@section('title', $sinf->name . ' baholash')
@section('page-title', $sinf->name . ' baholash')
@section('breadcrumb', 'Baholash')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-star text-primary me-2"></i>
            {{ $sinf->name }} — {{ $sana->translatedFormat('d.m.Y') }}
        </h4>
        <a href="{{ route('baholar.index') }}" class="btn btn-outline-secondary">
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
    <form method="GET" action="{{ route('baholar.mark', $sinf->id) }}" class="d-flex gap-2 mb-4">
        <input type="date" name="sana" value="{{ $sana->format('Y-m-d') }}"
               class="form-control" style="max-width:220px;" onchange="this.form.submit()">
    </form>

    <form method="POST" action="{{ route('baholar.store', $sinf->id) }}">
        @csrf
        <input type="hidden" name="sana" value="{{ $sana->format('Y-m-d') }}">

        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>F.I.O</th>
                            <th style="min-width:280px;">Baho (1-5)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($oquvchilar as $i => $o)
                            @php $current = optional($existing->get($o->id))->baho; @endphp
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td class="fw-semibold">{{ $o->fio }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @for($b = 1; $b <= 5; $b++)
                                            <input type="radio"
                                                   class="btn-check"
                                                   name="baholar[{{ $o->id }}]"
                                                   id="baho_{{ $o->id }}_{{ $b }}"
                                                   value="{{ $b }}"
                                                   {{ (int)$current === $b ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary btn-sm" for="baho_{{ $o->id }}_{{ $b }}">
                                                {{ $b }}
                                            </label>
                                        @endfor
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