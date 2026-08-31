@extends('layouts.app')

@section('title', 'Darsni tahrirlash')

@section('page-title', 'Darsni tahrirlash')

@section('breadcrumb', 'Tahrirlash')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">

                <i class="bi bi-pencil-square text-warning me-2"></i>

                Darsni tahrirlash

            </h4>

            <p class="text-muted mb-0">

                {{ $dars->sinf->name }} sinfi — {{ $dars->kun }}, {{ $dars->dars_raqami }}

            </p>

        </div>

        <a
            href="{{ route('darsjadvali.show', $dars->sinf_id) }}"
            class="btn btn-light"
        >
            <i class="bi bi-arrow-left me-1"></i>
            Orqaga
        </a>

    </div>


    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    <form
                        method="POST"
                        action="{{ route('darsjadvali.update', $dars->id) }}"
                    >

                        @csrf

                        @method('PUT')

                        <div class="mb-3">

                            <label class="form-label">Kun <span class="text-danger">*</span></label>

                            <select name="kun" class="form-select" required>

                                @foreach(['Dushanba','Seshanba','Chorshanba','Payshanba','Juma','Shanba','Yakshanba'] as $kunOption)

                                    <option
                                        value="{{ $kunOption }}"
                                        {{ old('kun', $dars->kun) == $kunOption ? 'selected' : '' }}
                                    >
                                        {{ $kunOption }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">Dars raqami <span class="text-danger">*</span></label>

                            <input
                                type="text"
                                name="dars_raqami"
                                class="form-control"
                                value="{{ old('dars_raqami', $dars->dars_raqami) }}"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label class="form-label">Vaqti</label>

                            <input
                                type="text"
                                name="vaqti"
                                class="form-control"
                                value="{{ old('vaqti', $dars->vaqti) }}"
                                placeholder="Masalan: 08:30 - 09:15"
                            >

                        </div>

                        <div class="mb-3">

                            <label class="form-label">Fan <span class="text-danger">*</span></label>

                            <input
                                type="text"
                                name="fan"
                                class="form-control"
                                value="{{ old('fan', $dars->fan) }}"
                                required
                            >

                        </div>

                        <div class="mb-4">

                            <label class="form-label">O‘qituvchi</label>

                            <select name="oqituvchi_id" class="form-select">

                                <option value="">— Tanlanmagan —</option>

                                @foreach($oqituvchilar as $oq)

                                    <option
                                        value="{{ $oq->id }}"
                                        {{ old('oqituvchi_id', $dars->oqituvchi_id) == $oq->id ? 'selected' : '' }}
                                    >
                                        {{ $oq->name }}
                                    </option>

                                @endforeach

                            </select>

                            @if($dars->oqituvchi_ism && !$dars->oqituvchi_id)

                                <div class="form-text text-warning">

                                    Excel'dan olingan ism: "{{ $dars->oqituvchi_ism }}"
                                    — tizimda mos xodim topilmagan.

                                </div>

                            @endif

                        </div>

                        <div class="d-flex justify-content-between">

                            <a
                                href="{{ route('darsjadvali.show', $dars->sinf_id) }}"
                                class="btn btn-light border"
                            >
                                <i class="bi bi-x-circle me-1"></i>
                                Bekor qilish
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>
                                Saqlash
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection