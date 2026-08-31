@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <a href="{{ route('xabarlar.index') }}" class="btn btn-sm btn-light mb-3">← Xabarlarga qaytish</a>

    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h4 class="mb-1">{{ $sinf->name }} sinfi</h4>
                <div class="text-muted">
                    @forelse($bugungiXabarlar as $x)
                        @php $turiLbl = \App\Xabar::turiLabels()[$x->turi] ?? ['label' => $x->turi]; @endphp
                        <span class="badge bg-light text-dark border me-1">
                            {{ $turiLbl['label'] }} — {{ $x->teacher->name ?? '—' }}
                        </span>
                    @empty
                        <span>Shu kunga hali hech kim ma'lumot kiritmagan</span>
                    @endforelse
                </div>
            </div>

            <form method="GET" action="{{ route('xabarlar.show', $sinf->id) }}" class="d-flex gap-2">
                <input type="date" name="sana" value="{{ $sana->format('Y-m-d') }}" class="form-control" onchange="this.form.submit()">
            </form>
        </div>
    </div>

    {{-- STATISTIKA --}}
    <div class="row mb-4 g-3">
        <div class="col-6 col-md-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="text-muted small">Jami o'quvchi</div>
                    <div class="h3 mb-0">{{ $jami }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="text-muted small">Kelganlar</div>
                    <div class="h3 mb-0 text-success">{{ $keldiSoni }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="text-muted small">Kelmaganlar</div>
                    <div class="h3 mb-0 text-danger">{{ $kelmadiSoni }}</div>
                    @if($belgilanmaganSoni > 0)
                        <div class="text-muted small">(+{{ $belgilanmaganSoni }} belgilanmagan)</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="text-muted small">Baho qo'yilgan / qo'yilmagan</div>
                    <div class="h3 mb-0">
                        <span class="text-primary">{{ $bahoQoyilganSoni }}</span>
                        <span class="text-muted fs-6">/</span>
                        <span class="text-secondary">{{ $bahoQoyilmaganSoni }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- JADVAL: HAR BIR O'QUVCHI — DAVOMAT + BAHOLAR --}}
    <div class="card">
        <div class="card-header">
            📋 {{ $sana->format('d.m.Y') }} kungi to'liq ma'lumot
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>F.I.Sh</th>
                            <th>Davomat</th>
                            <th>Davomatni belgilagan</th>
                            <th>Baholar</th>
                            <th>Bahoni qo'ygan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($oquvchilar as $o)
                        @php
                            $d = $davomatlar->get($o->id);
                            $bList = $baholar->get($o->id);
                            $dLbl = $d ? ($statusLabels[$d->status] ?? ['label' => $d->status, 'badge' => 'secondary']) : null;
                        @endphp
                        <tr>
                            <td>{{ $o->fio }}</td>
                            <td>
                                @if($d)
                                    <span class="badge bg-{{ $dLbl['badge'] }}">{{ $dLbl['label'] }}</span>
                                @else
                                    <span class="text-muted">Belgilanmagan</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $d->teacher->name ?? '—' }}</td>
                            <td>
                                @if($bList && $bList->count())
                                    @foreach($bList as $b)
                                        <span class="badge bg-{{ $b->baho >= 4 ? 'success' : ($b->baho == 3 ? 'warning' : 'danger') }}">
                                            {{ $b->fan ?? 'Fan' }}: {{ $b->baho }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-muted">Qo'yilmagan</span>
                                @endif
                            </td>
                            <td class="text-muted small">
                                {{ $bList && $bList->count() ? ($bList->first()->teacher->name ?? '—') : '—' }}
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Bu sinfda o'quvchi yo'q</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection