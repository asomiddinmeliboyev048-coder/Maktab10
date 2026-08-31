@extends('layouts.app')

@section('title', 'Statistika')
@section('page-title', 'Statistika')
@section('breadcrumb', 'Statistika')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h4 class="fw-bold mb-1">
            <i class="bi bi-graph-up text-primary me-2"></i>
            Statistika
        </h4>
        <p class="text-muted mb-0">
            Maktabning umumiy statistik va analitik ko'rsatkichlari — {{ $boshlanish->format('d.m.Y') }} — {{ $tugash->format('d.m.Y') }}
        </p>
    </div>

    {{-- FILTERLAR --}}
    <form method="GET" action="{{ route('statistika.index') }}" class="row g-2 mb-4">
        <div class="col-md-3">
            <select name="period" class="form-select" onchange="this.form.submit()">
                <option value="today" {{ $period === 'today' ? 'selected' : '' }}>Bugun</option>
                <option value="week" {{ $period === 'week' ? 'selected' : '' }}>Shu hafta</option>
                <option value="month" {{ $period === 'month' ? 'selected' : '' }}>Shu oy</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="sinf_id" class="form-select" onchange="this.form.submit()">
                <option value="">Barcha sinflar</option>
                @foreach($sinflarUmumiy as $s)
                    <option value="{{ $s->id }}" {{ (string)$sinfId === (string)$s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="fan" class="form-select" onchange="this.form.submit()">
                <option value="">Barcha fanlar</option>
                @foreach($fanlarUmumiy as $f)
                    <option value="{{ $f }}" {{ $fan === $f ? 'selected' : '' }}>{{ $f }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <a href="{{ route('statistika.index') }}" class="btn btn-light border w-100">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Filtrlarni tozalash
            </a>
        </div>
    </form>

    {{-- 1. UMUMIY KPI --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('oquvchilar.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;">
                                <i class="bi bi-people text-primary fs-5"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Jami o'quvchilar</small>
                                <h4 class="fw-bold mb-0 text-dark">{{ $kpi['jamiOquvchilar'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a href="{{ route('oqituvchilar.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;">
                                <i class="bi bi-person-badge text-info fs-5"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Jami o'qituvchilar</small>
                                <h4 class="fw-bold mb-0 text-dark">{{ $kpi['jamiOqituvchilar'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a href="{{ route('sinflar.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;">
                                <i class="bi bi-building text-warning fs-5"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Jami sinflar</small>
                                <h4 class="fw-bold mb-0 text-dark">{{ $kpi['jamiSinflar'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a href="{{ route('davomat.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;">
                                <i class="bi bi-calendar-check text-success fs-5"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Bugungi davomat</small>
                                <h4 class="fw-bold mb-0 text-dark">
                                    {{ $kpi['bugungiDavomatFoizi'] !== null ? $kpi['bugungiDavomatFoizi'] . '%' : 'Ma\'lumot yo\'q' }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a href="{{ route('baholar.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;">
                                <i class="bi bi-star text-primary fs-5"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">O'rtacha baho</small>
                                <h4 class="fw-bold mb-0 text-dark">{{ $kpi['ortachaBaho'] ?? 'Ma\'lumot yo\'q' }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a href="{{ route('kutubxona.berilgan') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;">
                                <i class="bi bi-check-circle text-success fs-5"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Berilgan kitoblar</small>
                                <h4 class="fw-bold mb-0 text-dark">{{ $kpi['berilganKitoblar'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a href="{{ route('kutubxona.berilmagan') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;">
                                <i class="bi bi-x-circle text-danger fs-5"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Berilmagan kitoblar</small>
                                <h4 class="fw-bold mb-0 text-dark">{{ $kpi['berilmaganKitoblar'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- GRAFIKLAR --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3"><h6 class="fw-bold mb-0"><i class="bi bi-bar-chart me-2"></i>Sinflar bo'yicha o'quvchilar soni</h6></div>
                <div class="card-body"><canvas id="chartSinfOquvchilar" height="220"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3"><h6 class="fw-bold mb-0"><i class="bi bi-pie-chart me-2"></i>Baholar taqsimoti</h6></div>
                <div class="card-body"><canvas id="chartBaholarTaqsimot" height="220"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3"><h6 class="fw-bold mb-0"><i class="bi bi-bar-chart-line me-2"></i>Sinflar bo'yicha o'rtacha baho</h6></div>
                <div class="card-body"><canvas id="chartSinfBaho" height="220"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3"><h6 class="fw-bold mb-0"><i class="bi bi-donut-chart me-2"></i>Kitob ta'minoti</h6></div>
                <div class="card-body"><canvas id="chartKitob" height="220"></canvas></div>
            </div>
        </div>
    </div>

    {{-- SINFLAR BO'YICHA UMUMIY HOLAT --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3"><h6 class="fw-bold mb-0"><i class="bi bi-building me-2"></i>Sinflar bo'yicha umumiy holat</h6></div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4">Sinf</th>
                        <th>Sinf rahbari</th>
                        <th class="text-center">O'quvchilar</th>
                        <th class="text-center">Davomat</th>
                        <th class="text-center">O'rtacha baho</th>
                        <th class="text-center">Holat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sinflarData as $s)
                        <tr>
                            <td class="px-4 fw-semibold">{{ $s['name'] }}</td>
                            <td>{{ $s['teacher']->name ?? '—' }}</td>
                            <td class="text-center">{{ $s['oquvchilar_soni'] }}</td>
                            <td class="text-center">{{ $s['davomat_foizi'] !== null ? $s['davomat_foizi'] . '%' : '—' }}</td>
                            <td class="text-center">{{ $s['ortacha_baho'] ?? '—' }}</td>
                            <td class="text-center">
                                @if($s['davomat_foizi'] === null && $s['ortacha_baho'] === null)
                                    <span class="badge bg-secondary">Ma'lumot yo'q</span>
                                @elseif(($s['davomat_foizi'] !== null && $s['davomat_foizi'] < 80) || ($s['ortacha_baho'] !== null && $s['ortacha_baho'] < 3.0))
                                    <span class="badge bg-danger">E'tibor</span>
                                @else
                                    <span class="badge bg-success">Yaxshi</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Ma'lumot mavjud emas</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="row g-4 mb-4">

        {{-- O'QITUVCHILAR --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3"><h6 class="fw-bold mb-0"><i class="bi bi-person-badge me-2"></i>O'qituvchilar (fan bo'yicha)</h6></div>
                <div class="card-body p-0">
                    <table class="table align-middle mb-0">
                        <tbody>
                            @forelse($oqituvchilarStat['fanBoyicha'] as $f)
                                <tr>
                                    <td class="px-3">{{ $f->subject }}</td>
                                    <td class="text-end px-3"><span class="badge bg-primary">{{ $f->soni }} ta</span></td>
                                </tr>
                            @empty
                                <tr><td class="text-center text-muted py-4">Ma'lumot mavjud emas</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white text-muted small">
                    Jami o'qituvchilar: {{ $oqituvchilarStat['jami'] }} ta, shundan sinf rahbari: {{ $oqituvchilarStat['sinfRahbarlari'] }} ta
                </div>
            </div>
        </div>

        {{-- TOP O'QUVCHILAR --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3"><h6 class="fw-bold mb-0"><i class="bi bi-trophy me-2"></i>TOP 10 o'quvchi</h6></div>
                <div class="card-body p-0">
                    @if($topOquvchilar->count() > 0)
                        <table class="table align-middle mb-0">
                            <tbody>
                                @foreach($topOquvchilar as $i => $o)
                                    <tr>
                                        <td class="px-3">{{ $i + 1 }}</td>
                                        <td>{{ $o->fio }} <small class="text-muted">({{ $o->sinf->name ?? '—' }})</small></td>
                                        <td class="text-end px-3"><span class="badge bg-success">{{ round($o->baholar_avg_baho, 2) }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-center text-muted py-4 mb-0">Yetarli ma'lumot mavjud emas</p>
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- MUAMMOLI KO'RSATKICHLAR --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3"><h6 class="fw-bold mb-0 text-danger"><i class="bi bi-exclamation-triangle me-2"></i>E'tibor talab qiladigan ko'rsatkichlar</h6></div>
        <div class="card-body">
            <div class="row g-3">

                @forelse($muammolar['davomatiPastSinflar'] as $s)
                    <div class="col-md-6">
                        <div class="alert alert-warning d-flex justify-content-between align-items-center mb-2">
                            <span><i class="bi bi-calendar-x me-2"></i>{{ $s['name'] }} — davomat {{ $s['davomat_foizi'] }}%</span>
                            <a href="{{ route('davomat.director.show', $s['id']) }}" class="btn btn-sm btn-outline-dark">Ko'rish</a>
                        </div>
                    </div>
                @empty
                @endforelse

                @forelse($muammolar['bahosiPastSinflar'] as $s)
                    <div class="col-md-6">
                        <div class="alert alert-warning d-flex justify-content-between align-items-center mb-2">
                            <span><i class="bi bi-star-half me-2"></i>{{ $s['name'] }} — o'rtacha baho {{ $s['ortacha_baho'] }}</span>
                            <a href="{{ route('baholar.director.show', $s['id']) }}" class="btn btn-sm btn-outline-dark">Ko'rish</a>
                        </div>
                    </div>
                @empty
                @endforelse

                @if($muammolar['kitobiYetishmaganSoni'] > 0)
                    <div class="col-md-6">
                        <div class="alert alert-warning d-flex justify-content-between align-items-center mb-2">
                            <span><i class="bi bi-book me-2"></i>Kitobi to'liq berilmagan: {{ $muammolar['kitobiYetishmaganSoni'] }} ta o'quvchi</span>
                            <a href="{{ route('kutubxona.berilmagan') }}" class="btn btn-sm btn-outline-dark">Ko'rish</a>
                        </div>
                    </div>
                @endif

                @if($muammolar['baholanmaganOquvchilarSoni'] > 0)
                    <div class="col-md-6">
                        <div class="alert alert-warning d-flex justify-content-between align-items-center mb-2">
                            <span><i class="bi bi-question-circle me-2"></i>Tanlangan davrda baholanmagan: {{ $muammolar['baholanmaganOquvchilarSoni'] }} ta o'quvchi</span>
                        </div>
                    </div>
                @endif

                @if($muammolar['davomatiPastSinflar']->isEmpty() && $muammolar['bahosiPastSinflar']->isEmpty() && $muammolar['kitobiYetishmaganSoni'] === 0 && $muammolar['baholanmaganOquvchilarSoni'] === 0)
                    <div class="col-12 text-center text-muted py-3">
                        <i class="bi bi-check-circle text-success fs-3"></i>
                        <p class="mb-0 mt-2">Hozircha e'tibor talab qiladigan ko'rsatkich yo'q.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    var sinfLabels = @json($sinflarData->pluck('name'));
    var sinfOquvchilar = @json($sinflarData->pluck('oquvchilar_soni'));
    var sinfBaho = @json($sinflarData->pluck('ortacha_baho'));

    new Chart(document.getElementById('chartSinfOquvchilar'), {
        type: 'bar',
        data: {
            labels: sinfLabels,
            datasets: [{ label: 'O\'quvchilar soni', data: sinfOquvchilar, backgroundColor: '#4154f1' }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });

    new Chart(document.getElementById('chartSinfBaho'), {
        type: 'bar',
        data: {
            labels: sinfLabels,
            datasets: [{ label: 'O\'rtacha baho', data: sinfBaho, backgroundColor: '#2eca6a' }]
        },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { max: 5 } } }
    });

    var baholarTaqsimot = @json($baholarStat['taqsimot']);
    var baholarLabels = ['1', '2', '3', '4', '5'];
    var baholarData = baholarLabels.map(function (b) { return baholarTaqsimot[b] || 0; });

    new Chart(document.getElementById('chartBaholarTaqsimot'), {
        type: 'pie',
        data: {
            labels: baholarLabels,
            datasets: [{ data: baholarData, backgroundColor: ['#dc3545', '#fd7e14', '#ffc107', '#0dcaf0', '#2eca6a'] }]
        },
        options: { responsive: true }
    });

    new Chart(document.getElementById('chartKitob'), {
        type: 'doughnut',
        data: {
            labels: ['Berilgan', 'Berilmagan'],
            datasets: [{ data: [{{ $kutubxonaStat['berilgan'] }}, {{ $kutubxonaStat['berilmagan'] }}], backgroundColor: ['#2eca6a', '#dc3545'] }]
        },
        options: { responsive: true }
    });

});
</script>
@endpush