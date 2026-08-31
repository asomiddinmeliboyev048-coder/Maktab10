@extends('layouts.app')

@section('title', 'Profil')

@section('content')

<div class="pagetitle d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1>Profil</h1>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Bosh sahifa</a></li>
                <li class="breadcrumb-item active">Profil</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('profil.edit') }}" class="btn btn-warning">
            <i class="bi bi-pencil-square me-1"></i> Profilni tahrirlash
        </a>
    </div>
</div>

<section class="section">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show smart-alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ============================================================
        SHAXSIY PROFIL
    ============================================================= --}}
    <div class="row g-4 mb-4">

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <img src="{{ $user->avatar_url }}"
                         class="rounded-circle mb-3"
                         width="110" height="110"
                         style="object-fit:cover;"
                         alt="{{ $user->name }}">

                    <h4 class="fw-bold mb-1">{{ $user->name }}</h4>

                    <span class="badge bg-primary px-3 py-2 mb-2">
                        @if($user->role === 'director') Direktor
                        @elseif($user->role === 'deputy') Direktor o‘rinbosari
                        @elseif($user->role === 'teacher') O‘qituvchi
                        @else {{ $user->role }} @endif
                    </span>

                    @if($user->staff_id)
                        <div>
                            <span class="badge bg-light text-dark border">
                                <i class="bi bi-hash me-1"></i>{{ $user->staff_id }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0"><i class="bi bi-person-lines-fill text-primary me-2"></i>Shaxsiy ma'lumotlar</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Ism</small>
                            <span class="fw-semibold">{{ $user->name }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Login</small>
                            <span class="fw-semibold">{{ $user->login ?: '—' }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Email</small>
                            <span class="fw-semibold">{{ $user->email }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Telefon</small>
                            <span class="fw-semibold">{{ $user->phone ?: 'Ko‘rsatilmagan' }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Manzil</small>
                            <span class="fw-semibold">{{ $user->address ?: 'Ko‘rsatilmagan' }}</span>
                        </div>
                        @if($user->subject)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Fan</small>
                                <span class="fw-semibold">{{ $user->subject }}</span>
                            </div>
                        @endif
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Profil yaratilgan sana</small>
                            <span class="fw-semibold">{{ $user->created_at ? $user->created_at->format('d.m.Y H:i') : '—' }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Oxirgi yangilangan sana</small>
                            <span class="fw-semibold">{{ $user->updated_at ? $user->updated_at->format('d.m.Y H:i') : '—' }}</span>
                        </div>
                    </div>

                    @if($mySinflar->count() > 0)
                        <hr>
                        <small class="text-muted d-block mb-2">Sinf rahbarligi</small>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($mySinflar as $sinf)
                                <span class="badge bg-info text-dark px-3 py-2">
                                    <i class="bi bi-building me-1"></i>{{ $sinf->name }} — {{ $sinf->oquvchilar_count }} ta o‘quvchi
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- ============================================================
        XODIMLAR (faqat director/deputy)
    ============================================================= --}}
    @if($xodimlar !== null)

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0"><i class="bi bi-people text-primary me-2"></i>Xodimlar</h5>
            </div>
            <div class="card-body">

                <form method="GET" action="{{ route('profil') }}" class="row g-2 mb-3">
                    <div class="col-md-5">
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="form-control" placeholder="Ism, Staff ID, email yoki fan bo‘yicha qidirish...">
                    </div>
                    <div class="col-md-3">
                        <select name="role" class="form-select">
                            <option value="">Barchasi</option>
                            <option value="teacher" {{ request('role') === 'teacher' ? 'selected' : '' }}>O‘qituvchilar</option>
                            <option value="deputy" {{ request('role') === 'deputy' ? 'selected' : '' }}>Direktor o‘rinbosarlari</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="per_page" class="form-select">
                            <option value="15" {{ (int) request('per_page', 15) === 15 ? 'selected' : '' }}>15 ta</option>
                            <option value="25" {{ (int) request('per_page') === 25 ? 'selected' : '' }}>25 ta</option>
                            <option value="50" {{ (int) request('per_page') === 50 ? 'selected' : '' }}>50 ta</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-dark w-100"><i class="bi bi-search me-1"></i> Qidirish</button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">#</th>
                                <th></th>
                                <th>Xodim ID</th>
                                <th>Xodim</th>
                                <th>Lavozim</th>
                                <th>Fan</th>
                                <th>Telefon</th>
                                <th>Sinf rahbarligi</th>
                                <th>O‘quvchilar soni</th>
                                <th class="text-center">Amallar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($xodimlar as $i => $xodim)
                                <tr>
                                    <td class="text-center text-muted">{{ $xodimlar->firstItem() + $i }}</td>
                                    <td>
                                        <img src="{{ $xodim->avatar_url }}" class="rounded-circle" width="36" height="36" style="object-fit:cover;">
                                    </td>
                                    <td>
                                        @if($xodim->staff_id)
                                            <span class="badge bg-dark">{{ $xodim->staff_id }}</span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="fw-semibold">{{ $xodim->name }}</td>
                                    <td>
                                        @if($xodim->role === 'teacher')
                                            <span class="badge bg-primary">O‘qituvchi</span>
                                        @elseif($xodim->role === 'deputy')
                                            <span class="badge bg-warning text-dark">Direktor o‘rinbosari</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $xodim->role }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $xodim->subject ?: 'Fan biriktirilmagan' }}</td>
                                    <td>{{ $xodim->phone ?: '—' }}</td>
                                    <td>
                                        @if($xodim->sinflar_count > 0)
                                            <span class="badge bg-info text-dark">{{ $xodim->sinflar_count }} ta sinf</span>
                                        @else
                                            <span class="text-muted">Biriktirilmagan</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php $studentsTotal = $xodim->sinflar()->withCount('oquvchilar')->get()->sum('oquvchilar_count'); @endphp
                                        {{ $studentsTotal }} ta
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('oqituvchilar.show', $xodim->id) }}" class="btn btn-sm btn-outline-info" title="Ko‘rish">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('oqituvchilar.edit', $xodim->id) }}" class="btn btn-sm btn-outline-warning" title="Tahrirlash">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-4">Hech narsa topilmadi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($xodimlar->hasPages())
                    <div class="d-flex justify-content-between align-items-center flex-wrap pt-3 border-top mt-3">
                        <div class="text-muted small">
                            Ko‘rsatilmoqda: {{ $xodimlar->firstItem() }} - {{ $xodimlar->lastItem() }} / Jami: {{ $xodimlar->total() }}
                        </div>
                        <div>{{ $xodimlar->links('pagination::bootstrap-5') }}</div>
                    </div>
                @endif

            </div>
        </div>

    @endif

</section>

@endsection