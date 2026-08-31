@extends('layouts.app')

@section('title', 'Foydalanuvchilar va huquqlar')

@section('content')

<div class="pagetitle d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1>Foydalanuvchilar va huquqlar</h1>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Bosh sahifa</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sozlamalar.index') }}">Sozlamalar</a></li>
                <li class="breadcrumb-item active">Huquqlar</li>
            </ol>
        </nav>
    </div>
</div>

<section class="section">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show smart-alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="card-title mb-0"><i class="bi bi-shield-lock text-primary me-2"></i>O'qituvchilar huquqlari</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Xodim</th>
                            <th>Staff ID</th>
                            <th>Fan</th>
                            <th class="text-center">Ruxsatlar</th>
                            <th class="text-center">Amal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($xodimlar as $i => $xodim)
                            <tr>
                                <td class="text-center text-muted">{{ $i + 1 }}</td>
                                <td class="fw-semibold">{{ $xodim->name }}</td>
                                <td>
                                    @if($xodim->staff_id)
                                        <span class="badge bg-dark">{{ $xodim->staff_id }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>{{ $xodim->subject ?: 'Fan biriktirilmagan' }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $xodim->permissions_count > 0 ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $xodim->permissions_count }}/{{ $totalPermissions }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('settings.permissions.edit', $xodim->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-gear me-1"></i> Boshqarish
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Hozircha o'qituvchilar mavjud emas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>

@endsection