@extends('layouts.app')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <div class="d-flex align-items-center">

                <div
                    class="rounded-circle bg-primary bg-opacity-10
                    d-flex align-items-center justify-content-center me-3"
                    style="width:55px;height:55px;"
                >

                    <i
                        class="bi bi-people text-primary"
                        style="font-size:25px;"
                    ></i>

                </div>

                <div>

                    <h4 class="fw-bold mb-1">
                        O‘quvchilar
                    </h4>

                    <p class="text-muted mb-0">
                        Barcha o‘quvchilar ro‘yxati
                    </p>

                </div>

            </div>

        </div>


        <div>

            <a
                href="{{ route('oquvchilar.create') }}"
                class="btn btn-primary"
            >
                <i class="bi bi-person-plus me-1"></i>
                O‘quvchi qo‘shish
            </a>

        </div>

    </div>


    {{-- FLASH XABARLAR --}}

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show" role="alert">

            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

        </div>

    @endif

    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show" role="alert">

            <i class="bi bi-exclamation-triangle me-2"></i>

            {{ session('error') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

        </div>

    @endif


    {{-- QIDIRUV --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET" action="{{ route('oquvchilar.index') }}" class="row g-3">

                <div class="col-md-10">

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="F.I.O, Student ID yoki telefon bo‘yicha qidirish..."
                        value="{{ request('search') }}"
                    >

                </div>

                <div class="col-md-2">

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i>
                        Qidirish
                    </button>

                </div>

            </form>

        </div>

    </div>


    {{-- O'QUVCHILAR JADVALI --}}

    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="px-4">#</th>
                            <th>F.I.O</th>
                            <th>Student ID</th>
                            <th>Sinf</th>
                            <th>Telefon</th>
                            <th>Manzil</th>
                            <th class="text-center">Amallar</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($oquvchilar as $oquvchi)

                            <tr>

                                <td class="px-4">
                                    {{ $loop->iteration }}
                                </td>

                                <td>

                                    <div class="fw-semibold">
                                        {{ $oquvchi->fio }}
                                    </div>

                                </td>

                                <td>

                                    <span class="badge bg-light text-dark border">
                                        {{ $oquvchi->student_id }}
                                    </span>

                                </td>

                                <td>

                                    @if($oquvchi->sinf)

                                        <span class="badge bg-primary">
                                            {{ $oquvchi->sinf->name }}
                                        </span>

                                    @else

                                        <span class="text-muted">—</span>

                                    @endif

                                </td>

                                <td>

                                    @if($oquvchi->phone)

                                        <a href="tel:{{ $oquvchi->phone }}" class="text-decoration-none">

                                            <i class="bi bi-telephone me-1"></i>

                                            {{ $oquvchi->phone }}

                                        </a>

                                    @else

                                        <span class="text-muted">—</span>

                                    @endif

                                </td>

                                <td>

                                    {{ $oquvchi->address ?: '—' }}

                                </td>

                                <td class="text-center">

                                    <div class="d-flex gap-1 justify-content-center">

                                        <a
                                            href="{{ route('oquvchilar.show', $oquvchi->id) }}"
                                            class="btn btn-sm btn-outline-info"
                                            title="Ko‘rish"
                                        >
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a
                                            href="{{ route('oquvchilar.edit', $oquvchi->id) }}"
                                            class="btn btn-sm btn-outline-warning"
                                            title="Tahrirlash"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('oquvchilar.destroy', $oquvchi->id) }}"
                                            onsubmit="return confirm('Ushbu o‘quvchini o‘chirishga ishonchingiz komilmi?');"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="O‘chirish"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="text-center py-5">

                                    <i
                                        class="bi bi-people"
                                        style="font-size:45px;color:#adb5bd;"
                                    ></i>

                                    <h6 class="text-muted mt-3">
                                        O‘quvchilar topilmadi.
                                    </h6>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    @if(method_exists($oquvchilar, 'links'))

        <div class="mt-3">
            {{ $oquvchilar->appends(request()->all())->links() }}
        </div>

    @endif

</div>

@endsection