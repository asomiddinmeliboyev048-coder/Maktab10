@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Stat Kartochkalar -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-primary text-white rounded p-3 me-3">
                        <i class="bi bi-journal-bookmark fs-3"></i>
                    </div>
                    <div>
                        <small class="text-muted text-uppercase fw-bold">Sinflar</small>
                        <h3 class="mb-0 fw-bold">{{ $sinflar_soni }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-success text-white rounded p-3 me-3">
                        <i class="bi bi-people fs-3"></i>
                    </div>
                    <div>
                        <small class="text-muted text-uppercase fw-bold">O‘quvchilar</small>
                        <h3 class="mb-0 fw-bold">{{ $oquvchilar_soni }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-warning text-white rounded p-3 me-3">
                        <i class="bi bi-person-badge fs-3"></i>
                    </div>
                    <div>
                        <small class="text-muted text-uppercase fw-bold">O‘qituvchilar</small>
                        <h3 class="mb-0 fw-bold">{{ $oqituvchilar_soni }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-info text-white rounded p-3 me-3">
                        <i class="bi bi-door-open fs-3"></i>
                    </div>
                    <div>
                        <small class="text-muted text-uppercase fw-bold">Xonalar</small>
                        <h3 class="mb-0 fw-bold">{{ $xonalar_soni }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- So'nggi qo'shilgan o'quvchilar jadvali -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3">So‘nggi qo‘shilgan o‘quvchilar</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>F.I.O</th>
                            <th>Sinfi</th>
                            <th>Telefon</th>
                            <th>Sana</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($songgi_oquvchilar as $oquvchi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="fw-bold">{{ $oquvchi->fio }}</td>
                                <td><span class="badge bg-primary">{{ $oquvchi->sinf_nomi }}</span></td>
                                <td>{{ $oquvchi->telefon ?? '-' }}</td>
                                <td><small class="text-muted">{{ date('d.m.Y', strtotime($oquvchi->created_at)) }}</small></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Hali o‘quvchilar kiritilmagan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection