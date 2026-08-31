@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <h2 class="mb-1">🔔 Xabarlar</h2>
    <p class="text-muted mb-4">O'qituvchilar tomonidan qo'yilgan davomat va baholar haqida bildirishnomalar</p>

    <div class="card">
        <div class="card-header">
            📋 So'nggi harakatlar ({{ $xabarlar->count() }} ta)
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width:60px;"></th>
                            <th>Amal</th>
                            <th>Sinf</th>
                            <th>O'qituvchi</th>
                            <th>Sana</th>
                            <th>Vaqt</th>
                            <th class="text-center" style="width:100px;">Ko'rish</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($xabarlar as $x)
                        @php $lbl = $turiLabels[$x->turi] ?? ['label' => $x->turi, 'icon' => '🔔', 'badge' => 'secondary']; @endphp
                        <tr class="{{ !$x->is_read ? 'table-light fw-bold' : '' }}">
                            <td class="text-center fs-5">
                                {{ $lbl['icon'] }}
                                @if(!$x->is_read)
                                    <span class="badge bg-danger" style="font-size:8px;">yangi</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $lbl['badge'] }}">{{ $lbl['label'] }}</span>
                            </td>
                            <td>{{ $x->sinf->name ?? '—' }}</td>
                            <td>{{ $x->teacher->name ?? '—' }}</td>
                            <td>{{ \Carbon\Carbon::parse($x->sana)->format('d.m.Y') }}</td>
                            <td class="text-muted small">{{ $x->updated_at->format('d.m.Y H:i') }}</td>
                            <td class="text-center">
                                <a href="{{ route('xabarlar.show', ['sinf' => $x->sinf_id, 'sana' => $x->sana->format('Y-m-d')]) }}"
                                   class="btn btn-sm btn-outline-secondary" title="Ko'rish">
                                    👁️
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Hozircha xabarlar yo'q</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection