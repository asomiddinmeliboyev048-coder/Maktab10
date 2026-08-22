@extends('layouts.app')

@section('title', 'O‘quvchilar')

@section('content')

<div class="pagetitle">
    <h1>O‘quvchilar</h1>

    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Bosh sahifa</a>
            </li>

            <li class="breadcrumb-item active">
                O‘quvchilar
            </li>
        </ol>
    </nav>
</div>

<section class="section">

    {{-- Muvaffaqiyat xabari --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show" role="alert">

            <i class="bi bi-check-circle me-1"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- Validatsiya xatolari --}}
    @if($errors->any())

        <div class="alert alert-danger alert-dismissible fade show">

            <strong>Xatolik!</strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    <div class="card">

        <div class="card-body">

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h5 class="card-title mb-1">
                        O‘quvchilar ro‘yxati
                    </h5>

                    <small class="text-muted">
                        Maktabdagi barcha o‘quvchilar
                    </small>

                </div>


                <a
                    href="{{ route('oquvchilar.create') }}"
                    class="btn btn-primary">

                    <i class="bi bi-person-plus me-1"></i>

                    O‘quvchi qo‘shish

                </a>

            </div>


            {{-- Qidiruv va filter --}}
            <form
                method="GET"
                action="{{ route('oquvchilar.index') }}"
                class="row g-3 mb-4">

                {{-- Qidiruv --}}
                <div class="col-md-5">

                    <label class="form-label">
                        Qidirish
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            value="{{ request('search') }}"
                            placeholder="F.I.O, ID yoki telefon...">

                    </div>

                </div>


                {{-- Sinf --}}
                <div class="col-md-4">

                    <label class="form-label">
                        Sinf
                    </label>

                    <select
                        name="sinf_id"
                        class="form-select">

                        <option value="">
                            Barcha sinflar
                        </option>

                        @foreach($sinflar as $sinf)

                            <option
                                value="{{ $sinf->id }}"
                                {{ request('sinf_id') == $sinf->id ? 'selected' : '' }}>

                                {{ $sinf->name }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Tugmalar --}}
                <div class="col-md-3 d-flex align-items-end">

                    <button
                        type="submit"
                        class="btn btn-primary me-2">

                        <i class="bi bi-search"></i>

                        Qidirish

                    </button>


                    <a
                        href="{{ route('oquvchilar.index') }}"
                        class="btn btn-outline-secondary">

                        <i class="bi bi-arrow-clockwise"></i>

                    </a>

                </div>

            </form>


            {{-- Jadval --}}
            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>O‘quvchi ID</th>

                            <th>F.I.O</th>

                            <th>Sinf</th>

                            <th>Telefon</th>

                            <th>Manzil</th>

                            <th class="text-center">
                                Amallar
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($oquvchilar as $index => $oquvchi)

                            <tr>

                                {{-- Tartib raqami --}}
                                <td>
                                    {{ $oquvchilar->firstItem() + $index }}
                                </td>


                                {{-- Student ID --}}
                                <td>

                                    <span class="badge bg-primary">

                                        {{ $oquvchi->student_id }}

                                    </span>

                                </td>


                                {{-- FIO --}}
                                <td>

                                    <strong>
                                        {{ $oquvchi->fio }}
                                    </strong>

                                </td>


                                {{-- Sinf --}}
                                <td>

                                    @if($oquvchi->sinf)

                                        <span class="badge bg-info text-dark">

                                            {{ $oquvchi->sinf->name }}

                                        </span>

                                    @else

                                        <span class="text-muted">
                                            Belgilanmagan
                                        </span>

                                    @endif

                                </td>


                                {{-- Telefon --}}
                                <td>

                                    @if($oquvchi->phone)

                                        <i class="bi bi-telephone me-1"></i>

                                        {{ $oquvchi->phone }}

                                    @else

                                        <span class="text-muted">
                                            —
                                        </span>

                                    @endif

                                </td>


                                {{-- Manzil --}}
                                <td>

                                    @if($oquvchi->address)

                                        {{ \Illuminate\Support\Str::limit($oquvchi->address, 35) }}

                                    @else

                                        <span class="text-muted">
                                            —
                                        </span>

                                    @endif

                                </td>


                                {{-- Amallar --}}
                                <td class="text-center">

                                    <div class="btn-group">

                                        {{-- Ko‘rish --}}
                                        <a
                                            href="{{ route('oquvchilar.show', $oquvchi->id) }}"
                                            class="btn btn-sm btn-outline-info"
                                            title="Ko‘rish">

                                            <i class="bi bi-eye"></i>

                                        </a>


                                        {{-- Tahrirlash --}}
                                        <a
                                            href="{{ route('oquvchilar.edit', $oquvchi->id) }}"
                                            class="btn btn-sm btn-outline-warning"
                                            title="Tahrirlash">

                                            <i class="bi bi-pencil"></i>

                                        </a>


                                        {{-- O‘chirish --}}
                                        <form
                                            action="{{ route('oquvchilar.destroy', $oquvchi->id) }}"
                                            method="POST"
                                            style="display:inline-block;">

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="O‘chirish"
                                                onclick="return confirm('Haqiqatan ham ushbu o‘quvchini o‘chirmoqchimisiz?')">

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
                                    class="text-center py-5">

                                    <div class="mb-3">

                                        <i
                                            class="bi bi-people"
                                            style="font-size: 48px; color: #899bbd;">
                                        </i>

                                    </div>

                                    <h5>
                                        O‘quvchilar topilmadi
                                    </h5>

                                    <p class="text-muted">

                                        Hozircha bazada o‘quvchilar mavjud emas.

                                    </p>

                                    <a
                                        href="{{ route('oquvchilar.create') }}"
                                        class="btn btn-primary">

                                        <i class="bi bi-person-plus me-1"></i>

                                        Birinchi o‘quvchini qo‘shish

                                    </a>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            @if($oquvchilar->hasPages())

                <div class="d-flex justify-content-between align-items-center mt-4">

                    <div class="text-muted">

                        Jami:

                        <strong>
                            {{ $oquvchilar->total() }}
                        </strong>

                        ta o‘quvchi

                    </div>

                    <div>

                        {{ $oquvchilar->links() }}

                    </div>

                </div>

            @endif

        </div>

    </div>

</section>

@endsection