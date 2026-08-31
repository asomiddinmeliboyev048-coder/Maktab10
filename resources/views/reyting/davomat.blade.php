@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <a href="{{ route('reyting.index') }}" class="btn btn-sm btn-light mb-3">
        ← Reytingga qaytish
    </a>

    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h4 class="mb-1">{{ $oquvchi->fio }}</h4>
                <div class="text-muted">
                    Sinf: <strong>{{ $oquvchi->sinf->name ?? '—' }}</strong>
                    &nbsp;|&nbsp; ID: {{ $oquvchi->student_id }}
                </div>
            </div>

            <form method="GET" action="{{ route('reyting.davomat', $oquvchi->id) }}" class="d-flex gap-2">
                <input type="month" name="oy" value="{{ $oy }}" class="form-control" onchange="this.form.submit()">
            </form>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-muted small">Jami kunlar</div>
                    <div class="h3 mb-0">{{ $jami }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-muted small">Kelgan kunlar</div>
                    <div class="h3 mb-0 text-success">{{ $keldi }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-muted small">Davomat foizi</div>
                    <div class="h3 mb-0 text-primary">{{ $foiz !== null ? $foiz.'%' : '—' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">📅 Kunlik davomat tarixi</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Sana</th>
                            <th>Holati</th>
                            <th>Belgilagan o'qituvchi</th>
                            <th>Izoh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($davomatlar as $d)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($d->sana)->format('d.m.Y (D)') }}</td>
                            <td>
                                @php $lbl = $statusLabels[$d->status] ?? ['label' => $d->status, 'badge' => 'secondary']; @endphp
                                <span class="badge bg-{{ $lbl['badge'] }}">{{ $lbl['label'] }}</span>
                            </td>
                            <td>{{ $d->teacher->name ?? '—' }}</td>
                            <td class="text-muted">{{ $d->izoh ?? '—' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Bu oyda davomat ma'lumoti yo'q</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection