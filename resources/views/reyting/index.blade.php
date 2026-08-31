@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <h2 class="mb-1">🏆 O'quvchilar reytingi</h2>
    <p class="text-muted mb-4">Barcha sinflar orasida umumiy TOP 20 — baho va davomat asosida hisoblanadi</p>

    {{-- FILTRLAR --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('reyting.index') }}" class="row g-2 align-items-center">
                <div class="col-md-3">
                    <select name="period" class="form-control" onchange="this.form.submit()">
                        <option value="today"  {{ $period === 'today'  ? 'selected' : '' }}>Bugun</option>
                        <option value="week"   {{ $period === 'week'   ? 'selected' : '' }}>Shu hafta</option>
                        <option value="month"  {{ $period === 'month'  ? 'selected' : '' }}>Shu oy</option>
                        <option value="all"    {{ $period === 'all'    ? 'selected' : '' }}>Barcha vaqt</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="text" name="q" value="{{ $qidiruv }}" class="form-control"
                           placeholder="Ism, familiya, ID yoki sinf bo'yicha qidirish...">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        🔍 Qidirish
                    </button>
                </div>
            </form>
            <div class="text-muted small mt-2">
                Davr: {{ $boshlanish->format('d.m.Y') }} — {{ $tugash->format('d.m.Y') }}
            </div>
        </div>
    </div>

    {{-- QIDIRUV NATIJASI (top20'da bo'lmasa ham umumiy o'rni) --}}
    @if($qidiruv !== '')
        <div class="card mb-4 border-primary">
            <div class="card-header bg-primary text-white">
                🔍 "{{ $qidiruv }}" bo'yicha qidiruv natijasi
                ({{ $qidiruvNatija->count() }} ta topildi)
            </div>
            <div class="card-body p-0">
                @if($qidiruvNatija->isEmpty())
                    <div class="p-3 text-muted">Hech narsa topilmadi.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Umumiy o'rin</th>
                                    <th>F.I.Sh</th>
                                    <th>Sinf</th>
                                    <th>O'rtacha baho</th>
                                    <th>Davomat %</th>
                                    <th>Umumiy ball</th>
                                    <th class="text-center">Amallar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($qidiruvNatija as $item)
                                <tr class="{{ $item['orin'] <= 20 ? 'table-success' : '' }}">
                                    <td><strong>#{{ $item['orin'] }}</strong></td>
                                    <td>{{ $item['fio'] }}</td>
                                    <td>{{ $item['sinf_name'] }}</td>
                                    <td>{{ $item['ortacha_baho'] ?? '—' }}</td>
                                    <td>{{ $item['davomat_foizi'] !== null ? $item['davomat_foizi'].'%' : '—' }}</td>
                                    <td><span class="badge bg-primary">{{ $item['umumiy_ball'] }}</span></td>
                                    <td class="text-center">
                                        <a href="{{ route('reyting.davomat', $item['id']) }}"
                                           class="btn btn-sm btn-outline-info" title="Davomat">
                                            📅
                                        </a>
                                        <a href="{{ route('reyting.kunlik', $item['id']) }}"
                                           class="btn btn-sm btn-outline-secondary" title="Ko'rish">
                                            👁️
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- TOP 20 JADVAL --}}
    <div class="card">
        <div class="card-header">
            📋 Umumiy TOP 20 (barcha sinflar)
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width:70px;">O'rin</th>
                            <th>F.I.Sh</th>
                            <th>Sinf</th>
                            <th>O'rtacha baho</th>
                            <th>Davomat</th>
                            <th>Umumiy ball</th>
                            <th class="text-center" style="width:120px;">Amallar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($top20 as $item)
                        <tr>
                            <td>
                                @if($item['orin'] == 1)
                                    <span class="badge bg-warning text-dark">🥇 1</span>
                                @elseif($item['orin'] == 2)
                                    <span class="badge bg-secondary">🥈 2</span>
                                @elseif($item['orin'] == 3)
                                    <span class="badge bg-danger">🥉 3</span>
                                @else
                                    <strong>#{{ $item['orin'] }}</strong>
                                @endif
                            </td>
                            <td>{{ $item['fio'] }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $item['sinf_name'] }}</span></td>
                            <td>{{ $item['ortacha_baho'] ?? '—' }}</td>
                            <td>
                                @if($item['davomat_foizi'] === null)
                                    <span class="text-muted">—</span>
                                @elseif($item['davomat_foizi'] >= 90)
                                    <span class="badge bg-success">{{ $item['davomat_foizi'] }}%</span>
                                @elseif($item['davomat_foizi'] >= 70)
                                    <span class="badge bg-warning text-dark">{{ $item['davomat_foizi'] }}%</span>
                                @else
                                    <span class="badge bg-danger">{{ $item['davomat_foizi'] }}%</span>
                                @endif
                            </td>
                            <td><span class="badge bg-primary fs-6">{{ $item['umumiy_ball'] }}</span></td>
                            <td class="text-center">
                                <a href="{{ route('reyting.davomat', $item['id']) }}"
                                   class="btn btn-sm btn-outline-info" title="Davomat tarixi">
                                    📅
                                </a>
                                <a href="{{ route('reyting.kunlik', $item['id']) }}"
                                   class="btn btn-sm btn-outline-secondary" title="Kunlik ma'lumot">
                                    👁️
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Ma'lumot topilmadi</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection