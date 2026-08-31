@extends('layouts.app')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="bi bi-book text-primary me-2"></i>
                Kutubxona
            </h4>
            <p class="text-muted mb-0">
                O‘quvchilarga darsliklar berilishi holati
            </p>
        </div>
    </div>

    {{-- UMUMIY KO'RSATKICHLAR --}}
    <div class="row g-4 mb-4">

        <div class="col-md-6">
            <a href="{{ route('kutubxona.berilgan') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                                 style="width:55px;height:55px;">
                                <i class="bi bi-check-circle text-success" style="font-size:25px;"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Berilgan kitoblar</small>
                                <h4 class="fw-bold mb-0 text-dark">{{ $totalBerilgan }} ta</h4>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right text-muted"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6">
            <a href="{{ route('kutubxona.berilmagan') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                                 style="width:55px;height:55px;">
                                <i class="bi bi-x-circle text-danger" style="font-size:25px;"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Berilmagan kitoblar</small>
                                <h4 class="fw-bold mb-0 text-dark">{{ $totalBerilmagan }} ta</h4>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right text-muted"></i>
                    </div>
                </div>
            </a>
        </div>

    </div>

    {{-- QIDIRUV --}}
    <form method="GET" action="{{ route('kutubxona.index') }}" class="d-flex gap-2 mb-4">
        <div class="input-group">
            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-control" placeholder="Sinf nomi, o‘quvchi F.I.O yoki Student ID bo‘yicha qidirish...">
        </div>
        <button type="submit" class="btn btn-dark">
            <i class="bi bi-search me-1"></i> Qidirish
        </button>
        @if(request('search'))
            <a href="{{ route('kutubxona.index') }}" class="btn btn-light border">Tozalash</a>
        @endif
    </form>

    {{-- SINFLAR --}}
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4">#</th>
                        <th>Sinf</th>
                        <th>O‘quvchilar</th>
                        <th class="text-center">Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sinflar as $i => $sinf)
                        <tr>
                            <td class="px-4">{{ $i + 1 }}</td>
                            <td class="fw-semibold">{{ $sinf->name }}</td>
                            <td><span class="badge bg-primary">{{ $sinf->oquvchilar_count }} ta</span></td>
                            <td class="text-center">
                                <a href="{{ route('sinflar.show', $sinf->id) }}"
                                   class="btn btn-sm btn-outline-primary" title="Ko‘rish">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('sinflar.show', $sinf->id) }}"
                                   class="btn btn-sm btn-outline-success" title="Kitoblar">
                                    <i class="bi bi-book"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Hech narsa topilmadi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection