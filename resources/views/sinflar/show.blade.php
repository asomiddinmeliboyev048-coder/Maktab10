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
                        {{ $sinf->name }} sinfi
                    </h4>

                    <p class="text-muted mb-0">
                        Sinf ma’lumotlari va o‘quvchilar
                    </p>

                </div>

            </div>

        </div>


        <div>

            <a
                href="{{ route('sinflar.edit', $sinf->id) }}"
                class="btn btn-warning me-1"
            >
                <i class="bi bi-pencil me-1"></i>
                Tahrirlash
            </a>

            <a
                href="{{ route('sinflar.index') }}"
                class="btn btn-light"
            >
                <i class="bi bi-arrow-left me-1"></i>
                Orqaga
            </a>

        </div>

    </div>


    {{-- CLASS INFO --}}
    <div class="row g-4 mb-4">


        {{-- TEACHER --}}
        <div class="col-xl-4 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        @if($sinf->teacher && $sinf->teacher->avatar)

                            <img
                                src="{{ asset('storage/' . $sinf->teacher->avatar) }}"
                                class="rounded-circle me-3"
                                width="60"
                                height="60"
                                style="object-fit:cover;"
                                alt="Avatar"
                            >

                        @else

                            <div
                                class="rounded-circle bg-primary bg-opacity-10
                                d-flex align-items-center justify-content-center me-3"
                                style="width:60px;height:60px;"
                            >

                                <i
                                    class="bi bi-person text-primary"
                                    style="font-size:27px;"
                                ></i>

                            </div>

                        @endif


                        <div>

                            <small class="text-muted">
                                Sinf rahbari
                            </small>

                            <h6 class="fw-bold mb-0">

                                @if($sinf->teacher)

                                    {{ $sinf->teacher->name }}

                                @else

                                    Biriktirilmagan

                                @endif

                            </h6>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- SUBJECT --}}
        <div class="col-xl-4 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div
                            class="rounded-circle bg-info bg-opacity-10
                            d-flex align-items-center justify-content-center me-3"
                            style="width:50px;height:50px;"
                        >

                            <i class="bi bi-book text-info"></i>

                        </div>

                        <div>

                            <small class="text-muted">
                                Fan
                            </small>

                            <h6 class="fw-bold mb-0">

                                {{ $sinf->subject ?: 'Belgilanmagan' }}

                            </h6>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- STUDENTS COUNT --}}
        <div class="col-xl-4 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div
                            class="rounded-circle bg-success bg-opacity-10
                            d-flex align-items-center justify-content-center me-3"
                            style="width:50px;height:50px;"
                        >

                            <i class="bi bi-people text-success"></i>

                        </div>

                        <div>

                            <small class="text-muted">
                                O‘quvchilar
                            </small>

                            <h6 class="fw-bold mb-0">

                                {{ $sinf->oquvchilar->count() }} ta

                            </h6>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- STUDENTS --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">

            <div class="d-flex justify-content-between align-items-center">

                <h5 class="fw-bold mb-0">

                    <i class="bi bi-people me-2"></i>

                    O‘quvchilar

                </h5>

                <span class="badge bg-primary">

                    {{ $sinf->oquvchilar->count() }} ta

                </span>

            </div>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="px-4">
                                #
                            </th>

                            <th>
                                O‘quvchi
                            </th>

                            <th>
                                Student ID
                            </th>

                            <th>
                                Telefon
                            </th>

                            <th>
                                Manzil
                            </th>

                            <th class="text-center">
                                Kitoblar
                            </th>

                            <th class="text-center">
                                Amallar
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse($sinf->oquvchilar as $oquvchi)

                        @php
                            $berilgan = $oquvchi->kitoblar['berilgan'] ?? [];
                            $berilmagan = $oquvchi->kitoblar['berilmagan'] ?? [];
                        @endphp

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

                                <span
                                    class="badge bg-light text-dark border"
                                >
                                    {{ $oquvchi->student_id }}
                                </span>

                            </td>


                            <td>

                                @if($oquvchi->phone)

                                    <a
                                        href="tel:{{ $oquvchi->phone }}"
                                        class="text-decoration-none"
                                    >

                                        <i class="bi bi-telephone me-1"></i>

                                        {{ $oquvchi->phone }}

                                    </a>

                                @else

                                    <span class="text-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            <td>

                                @if($oquvchi->address)

                                    {{ $oquvchi->address }}

                                @else

                                    <span class="text-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            <td class="text-center">

                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-primary btn-kitoblar"
                                    title="Kitoblar"
                                    data-bs-toggle="modal"
                                    data-bs-target="#kitoblarModal"
                                    data-fio="{{ $oquvchi->fio }}"
                                    data-berilgan="{{ implode('||', $berilgan) }}"
                                    data-berilmagan="{{ implode('||', $berilmagan) }}"
                                >

                                    <i class="bi bi-book"></i>

                                </button>

                            </td>


                            <td class="text-center">

                                <div class="d-flex gap-1 justify-content-center">

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

                            <td
                                colspan="7"
                                class="text-center py-5"
                            >

                                <i
                                    class="bi bi-people"
                                    style="font-size:45px;color:#adb5bd;"
                                ></i>

                                <h6 class="text-muted mt-3">
                                    Bu sinfda o‘quvchilar mavjud emas.
                                </h6>

                                <p class="text-muted small">
                                    Excel import funksiyasi keyingi bosqichda
                                    shu yerga ulanadi.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     KITOBLAR MODAL
========================================================== --}}

<div
    class="modal fade"
    id="kitoblarModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    <i class="bi bi-book text-primary me-2"></i>

                    <span id="kitoblarModalFio">Kitoblar</span>

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>

            <div class="modal-body">

                <div id="kitoblarModalBerilgan" class="mb-3"></div>

                <div id="kitoblarModalBerilmagan"></div>

                <div
                    id="kitoblarModalEmpty"
                    class="text-muted text-center py-4"
                    style="display:none;"
                >

                    <i
                        class="bi bi-inbox"
                        style="font-size:32px;"
                    ></i>

                    <p class="mb-0 mt-2">
                        Kitoblar maʼlumoti mavjud emas.
                    </p>

                </div>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal"
                >
                    Yopish
                </button>

            </div>

        </div>

    </div>

</div>


@endsection


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    function escapeHtml(str) {
        var div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    document.querySelectorAll('.btn-kitoblar').forEach(function (btn) {

        btn.addEventListener('click', function () {

            var fio = btn.getAttribute('data-fio') || '';

            var berilganRaw = btn.getAttribute('data-berilgan') || '';
            var berilmaganRaw = btn.getAttribute('data-berilmagan') || '';

            var berilgan = berilganRaw
                ? berilganRaw.split('||').filter(Boolean)
                : [];

            var berilmagan = berilmaganRaw
                ? berilmaganRaw.split('||').filter(Boolean)
                : [];

            document.getElementById('kitoblarModalFio').textContent = fio;

            var berilganHtml = '';
            var berilmaganHtml = '';

            if (berilgan.length > 0) {

                berilganHtml += '<h6 class="text-success fw-bold mb-2">' +
                    '<i class="bi bi-check-circle me-1"></i> Berilgan darsliklar</h6>';

                berilganHtml += '<div class="d-flex flex-wrap gap-2">';

                berilgan.forEach(function (item) {
                    berilganHtml += '<span class="badge bg-success bg-opacity-10 ' +
                        'text-success border border-success px-3 py-2">' +
                        escapeHtml(item) + '</span>';
                });

                berilganHtml += '</div>';
            }

            if (berilmagan.length > 0) {

                berilmaganHtml += '<h6 class="text-danger fw-bold mb-2 mt-3">' +
                    '<i class="bi bi-x-circle me-1"></i> Berilmagan darsliklar</h6>';

                berilmaganHtml += '<div class="d-flex flex-wrap gap-2">';

                berilmagan.forEach(function (item) {
                    berilmaganHtml += '<span class="badge bg-danger bg-opacity-10 ' +
                        'text-danger border border-danger px-3 py-2">' +
                        escapeHtml(item) + '</span>';
                });

                berilmaganHtml += '</div>';
            }

            document.getElementById('kitoblarModalBerilgan').innerHTML = berilganHtml;
            document.getElementById('kitoblarModalBerilmagan').innerHTML = berilmaganHtml;

            var emptyEl = document.getElementById('kitoblarModalEmpty');

            emptyEl.style.display =
                (berilgan.length === 0 && berilmagan.length === 0)
                    ? 'block'
                    : 'none';

        });

    });

});

</script>

@endpush