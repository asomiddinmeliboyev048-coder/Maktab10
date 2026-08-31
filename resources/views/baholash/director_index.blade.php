@extends('layouts.app')

@section('title', 'Baholar')
@section('page-title', 'Baholar')
@section('breadcrumb', 'Baholar')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h4 class="fw-bold mb-1">
            <i class="bi bi-star text-primary me-2"></i>
            Baholar
        </h4>
        <p class="text-muted mb-0">
            Barcha sinflar bo'yicha baholash holati — {{ $bugun->translatedFormat('d.m.Y, l') }}
        </p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Sinf</th>
                        <th>Sinf rahbari</th>
                        <th>O'quvchilar soni</th>
                        <th>Bugungi holat</th>
                        <th class="text-end">Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sinflar as $i => $sinf)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td class="fw-semibold">{{ $sinf->name }}</td>
                            <td>{{ $sinf->teacher->name ?? '—' }}</td>
                            <td><span class="badge bg-primary">{{ $sinf->oquvchilar_count }} ta</span></td>
                            <td>
                                @if($sinf->bugungi_holat === 'toliq')
                                    <span class="badge bg-success">Baholangan</span>
                                @elseif($sinf->bugungi_holat === 'qisman')
                                    <span class="badge bg-warning text-dark">Qisman baholangan</span>
                                @else
                                    <span class="badge bg-secondary">Baholanmagan</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('baholar.director.show', $sinf->id) }}"
                                   class="btn btn-sm btn-outline-primary" title="Baholarni ko'rish">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('baholar.director.report', $sinf->id) }}"
                                   class="btn btn-sm btn-outline-dark" title="Hisobot">
                                    <i class="bi bi-bar-chart"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Hozircha sinf mavjud emas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection