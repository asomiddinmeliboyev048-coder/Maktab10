@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="bi bi-check-circle text-success me-2"></i>
                Kitobi berilgan o‘quvchilar
            </h4>
            <p class="text-muted mb-0">Jami: {{ $oquvchilar->count() }} ta o‘quvchi</p>
        </div>
        <a href="{{ route('kutubxona.index') }}" class="btn btn-light border">
            <i class="bi bi-arrow-left me-1"></i> Orqaga
        </a>
    </div>

    {{-- FILTER --}}
    <form method="GET" action="{{ route('kutubxona.berilgan') }}" class="row g-2 mb-4">
        <div class="col-md-6">
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-control" placeholder="F.I.O yoki Student ID bo‘yicha qidirish...">
        </div>
        <div class="col-md-4">
            <select name="sinf_id" class="form-select" onchange="this.form.submit()">
                <option value="">Barcha sinflar</option>
                @foreach($sinflar as $sinf)
                    <option value="{{ $sinf->id }}" {{ request('sinf_id') == $sinf->id ? 'selected' : '' }}>
                        {{ $sinf->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-dark w-100">
                <i class="bi bi-search me-1"></i> Qidirish
            </button>
        </div>
    </form>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4">#</th>
                        <th>O‘quvchi</th>
                        <th>Student ID</th>
                        <th>Sinf</th>
                        <th class="text-center">Kitoblar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($oquvchilar as $i => $oquvchi)
                        @php
                            $berilgan = $oquvchi->kitoblar['berilgan'] ?? [];
                            $berilmagan = $oquvchi->kitoblar['berilmagan'] ?? [];
                        @endphp
                        <tr>
                            <td class="px-4">{{ $i + 1 }}</td>
                            <td class="fw-semibold">{{ $oquvchi->fio }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $oquvchi->student_id }}</span></td>
                            <td>{{ $oquvchi->sinf->name ?? '—' }}</td>
                            <td class="text-center">
                                <button type="button"
                                        class="btn btn-sm btn-outline-success btn-kitoblar"
                                        title="Kitoblar"
                                        data-bs-toggle="modal"
                                        data-bs-target="#kitoblarModal"
                                        data-fio="{{ $oquvchi->fio }}"
                                        data-berilgan="{{ implode('||', $berilgan) }}"
                                        data-berilmagan="{{ implode('||', $berilmagan) }}">
                                    <i class="bi bi-book"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Hech narsa topilmadi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@include('kutubxona.partials.modal')

@endsection

@push('scripts')
    @include('kutubxona.partials.modal-script')
@endpush