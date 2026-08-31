@extends('layouts.app')

@section('title', 'Davomat')
@section('page-title', 'Davomat')
@section('breadcrumb', 'Davomat')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h4 class="fw-bold mb-1">
            <i class="bi bi-calendar-check text-primary me-2"></i>
            Davomat
        </h4>
        <p class="text-muted mb-0">Siz dars beradigan sinflar ro'yxati</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Sinf</th>
                        <th>O'quvchilar soni</th>
                        <th class="text-end">Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sinflar as $i => $sinf)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td class="fw-semibold">{{ $sinf->name }}</td>
                            <td><span class="badge bg-primary">{{ $sinf->oquvchilar_count }} ta</span></td>
                            <td class="text-end">
                                <a href="{{ route('davomat.teacher.students', $sinf->id) }}"
                                   class="btn btn-sm btn-outline-primary" title="O'quvchilarni ko'rish">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('davomat.mark', $sinf->id) }}"
                                   class="btn btn-sm btn-outline-success" title="Davomat">
                                    <i class="bi bi-calendar-check"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Sizga hali sinf biriktirilmagan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection