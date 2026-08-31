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

            <form method="GET" action="{{ route('reyting.kunlik', $oquvchi->id) }}" class="d-flex gap-2">
                <input type="date" name="sana" value="{{ $sana }}" class="form-control" onchange="this.form.submit()">
            </form>
        </div>
    </div>

    {{-- SHU KUNGI DAVOMAT --}}
    <div class="card mb-4">
        <div class="card-header">📅 {{ \Carbon\Carbon::parse($sana)->format('d.m.Y') }} kungi davomat</div>
        <div class="card-body">
            @if($davomat)
                @php $lbl = $statusLabels[$davomat->status] ?? ['label' => $davomat->status, 'badge' => 'secondary']; @endphp
                <span class="badge bg-{{ $lbl['badge'] }} fs-6">{{ $lbl['label'] }}</span>
                <span class="text-muted ms-3">Belgilagan: {{ $davomat->teacher->name ?? '—' }}</span>
                @if($davomat->izoh)
                    <div class="text-muted mt-2">Izoh: {{ $davomat->izoh }}</div>
                @endif
            @else
                <span class="text-muted">Bu kun uchun davomat belgilanmagan</span>
            @endif
        </div>
    </div>

    {{-- SHU KUNGI BAHOLAR --}}
    <div class="card">
        <div class="card-header">⭐ {{ \Carbon\Carbon::parse($sana)->format('d.m.Y') }} kungi baholar</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Fan</th>
                            <th>Baho</th>
                            <th>O'qituvchi</th>
                            <th>Izoh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($baholar as $b)
                        <tr>
                            <td>{{ $b->fan ?? '—' }}</td>
                            <td>
                                <span class="badge bg-{{ $b->baho >= 4 ? 'success' : ($b->baho == 3 ? 'warning' : 'danger') }} fs-6">
                                    {{ $b->baho }}
                                </span>
                            </td>
                            <td>{{ $b->teacher->name ?? '—' }}</td>
                            <td class="text-muted">{{ $b->izoh ?? '—' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Bu kunga baho qo'yilmagan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection