@extends('layouts.app')

@section('title', 'Dars jadvali')

@section('page-title', 'Dars jadvali')

@section('breadcrumb', 'Dars jadvali')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">

                <i class="bi bi-calendar-week text-primary me-2"></i>

                Dars jadvali

            </h4>

            <p class="text-muted mb-0">

                Sinflar bo‘yicha haftalik dars jadvali

            </p>

        </div>

        <a
            href="{{ route('darsjadvali.import.form') }}"
            class="btn btn-primary"
        >

            <i class="bi bi-file-earmark-excel me-1"></i>

            Excel orqali yuklash

        </a>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">

            @if($sinflar->count())

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th class="px-4">#</th>
                                <th>Sinf</th>
                                <th>Sinf rahbari</th>
                                <th class="text-center">Darslar soni</th>
                                <th class="text-center">Amallar</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($sinflar as $sinf)

                                <tr>

                                    <td class="px-4">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>

                                        <div class="fw-semibold">
                                            {{ $sinf->name }}
                                        </div>

                                    </td>

                                    <td>

                                        @if($sinf->teacher)

                                            {{ $sinf->teacher->name }}

                                        @else

                                            <span class="text-muted">—</span>

                                        @endif

                                    </td>

                                    <td class="text-center">

                                        <span class="badge bg-primary">
                                            {{ $sinf->dars_jadvali_count }} ta
                                        </span>

                                    </td>

                                    <td class="text-center">

                                        <div class="d-flex gap-1 justify-content-center">

                                            <a
                                                href="{{ route('darsjadvali.show', $sinf->id) }}"
                                                class="btn btn-sm btn-outline-primary"
                                                title="Ko‘rish"
                                            >
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <a
                                                href="{{ route('darsjadvali.show', $sinf->id) }}"
                                                class="btn btn-sm btn-outline-warning"
                                                title="Tahrirlash"
                                            >
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('darsjadvali.destroySinf', $sinf->id) }}"
                                                onsubmit="return confirm('{{ $sinf->name }} sinfi uchun butun dars jadvalini o‘chirishga ishonchingiz komilmi?');"
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

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-5">

                    <i
                        class="bi bi-calendar-x"
                        style="font-size:45px;color:#adb5bd;"
                    ></i>

                    <h6 class="text-muted mt-3">
                        Hozircha hech qanday sinf uchun dars jadvali yuklanmagan.
                    </h6>

                    <a
                        href="{{ route('darsjadvali.import.form') }}"
                        class="btn btn-primary mt-2"
                    >
                        <i class="bi bi-file-earmark-excel me-1"></i>
                        Excel orqali yuklash
                    </a>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection