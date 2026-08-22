@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('sinflar.index') }}" class="btn btn-outline-secondary btn-sm me-2"><i class="bi bi-arrow-left"></i> Orqaga</a>
            <h4 class="fw-bold d-inline align-middle">{{ $sinf->nomi }} sinfi o‘quvchilari</h4>
        </div>
        <span class="badge bg-info text-dark fs-6">Jami: {{ count($oquvchilar) }} ta o‘quvchi</span>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-3">
                <small class="text-muted">Sinf rahbari:</small>
                <h6 class="fw-bold m-0">{{ $sinf->sinf_rahbari ?? 'Biriktirilmagan' }}</h6>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-3">
                <small class="text-muted">Xona:</small>
                <h6 class="fw-bold m-0">{{ $sinf->xona ?? 'Biriktirilmagan' }}</h6>
            </div>
        </div>
    </div>

    <!-- O'QUVCHILAR JADVALI -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle m-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>F.I.O</th>
                            <th>Telefon</th>
                            <th>Manzil</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($oquvchilar as $o)
                            <tr>
                                <td class="ps-3">{{ $loop->iteration }}</td>
                                <td class="fw-bold">{{ $o->fio }}</td>
                                <td>{{ $o->telefon ?? '-' }}</td>
                                <td>{{ $o->manzil ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Bu sinfda hali o‘quvchilar yo‘q.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection