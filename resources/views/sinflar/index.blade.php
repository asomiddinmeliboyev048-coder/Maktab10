@extends('layouts.app')

@section('title', 'Sinflar')

@section('page-title', 'Sinflar')

@section('breadcrumb', 'Sinflar')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">

                <i class="bi bi-building text-primary me-2"></i>

                Sinflar

            </h4>

            <p class="text-muted mb-0">

                Maktabdagi barcha sinflarni boshqarish

            </p>

        </div>


        <a href="{{ route('sinflar.create') }}"
           class="btn btn-primary">

            <i class="bi bi-plus-circle me-1"></i>

            Sinf qo‘shish

        </a>

    </div>


    {{-- SUCCESS --}}

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show"
             role="alert">

            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- ERROR --}}

    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show"
             role="alert">

            <i class="bi bi-exclamation-triangle me-2"></i>

            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- SEARCH --}}

    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('sinflar.index') }}">

                <div class="row g-2">

                    <div class="col-md-10">

                        <div class="input-group">

                            <span class="input-group-text bg-white">

                                <i class="bi bi-search"></i>

                            </span>

                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   placeholder="Sinf nomi, fan yoki xona bo‘yicha qidirish..."
                                   value="{{ request('search') }}">

                        </div>

                    </div>


                    <div class="col-md-2">

                        <button type="submit"
                                class="btn btn-dark w-100">

                            <i class="bi bi-search me-1"></i>

                            Qidirish

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- TABLE --}}

    <div class="card shadow-sm border-0">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="px-4">
                                #
                            </th>

                            <th>
                                Sinf
                            </th>

                            <th>
                                Sinf rahbari
                            </th>

                            <th>
                                Fan
                            </th>

                            <th>
                                Xona
                            </th>

                            <th>
                                O‘quvchilar
                            </th>

                            <th class="text-center">
                                Amallar
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($sinflar as $sinf)

                            <tr>

                                {{-- NUMBER --}}

                                <td class="px-4">

                                    {{ $loop->iteration + (($sinflar->currentPage() - 1) * $sinflar->perPage()) }}

                                </td>


                                {{-- CLASS --}}

                                <td>

                                    <div class="d-flex align-items-center">

                                        <div class="rounded-circle bg-primary bg-opacity-10
                                                    d-flex align-items-center justify-content-center me-3"
                                             style="width:42px;height:42px;">

                                            <i class="bi bi-people text-primary"></i>

                                        </div>


                                        <div>

                                            <div class="fw-bold">

                                                {{ $sinf->name }}

                                            </div>

                                            <small class="text-muted">

                                                ID: {{ $sinf->id }}

                                            </small>

                                        </div>

                                    </div>

                                </td>


                                {{-- TEACHER --}}

                                <td>

                                    @if($sinf->teacher)

                                        <div class="fw-semibold">

                                            {{ $sinf->teacher->name }}

                                        </div>

                                        <small class="text-muted">

                                            <i class="bi bi-person-check me-1"></i>

                                            Sinf rahbari

                                        </small>

                                    @else

                                        <span class="badge bg-warning text-dark">

                                            <i class="bi bi-person-x me-1"></i>

                                            Biriktirilmagan

                                        </span>

                                    @endif

                                </td>


                                {{-- SUBJECT --}}

                                <td>

                                    @if($sinf->subject)

                                        <span class="badge bg-info text-dark">

                                            <i class="bi bi-book me-1"></i>

                                            {{ $sinf->subject }}

                                        </span>

                                    @else

                                        <span class="text-muted">

                                            Belgilanmagan

                                        </span>

                                    @endif

                                </td>


                                {{-- ROOM --}}

                                <td>

                                    @if($sinf->room)

                                        <span>

                                            <i class="bi bi-door-open me-1"></i>

                                            {{ $sinf->room }}

                                        </span>

                                    @else

                                        <span class="text-muted">
                                            —
                                        </span>

                                    @endif

                                </td>


                                {{-- STUDENTS COUNT --}}

                                <td>

                                    <span class="badge bg-success">

                                        <i class="bi bi-people me-1"></i>

                                        {{ $sinf->oquvchilar_count }} ta

                                    </span>

                                </td>


                                {{-- ACTIONS --}}

                                <td class="text-center">

                                    <div class="btn-group"
                                         role="group">

                                        {{-- SHOW --}}

                                        <a href="{{ route('sinflar.show', $sinf->id) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="Ko‘rish">

                                            <i class="bi bi-eye"></i>

                                        </a>


                                        {{-- EDIT --}}

                                        <a href="{{ route('sinflar.edit', $sinf->id) }}"
                                           class="btn btn-sm btn-outline-warning"
                                           title="Tahrirlash">

                                            <i class="bi bi-pencil"></i>

                                        </a>


                                        {{-- DELETE --}}

                                        <form method="POST"
                                              action="{{ route('sinflar.destroy', $sinf->id) }}"
                                              class="d-inline"
                                              onsubmit="return confirm('Ushbu sinfni o‘chirishga ishonchingiz komilmi?');">

                                            @csrf

                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="O‘chirish">

                                                <i class="bi bi-trash"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7"
                                    class="text-center py-5">

                                    <div class="mb-3">

                                        <i class="bi bi-building"
                                           style="font-size:50px;color:#adb5bd;">
                                        </i>

                                    </div>

                                    <h5 class="text-muted">

                                        Sinflar topilmadi

                                    </h5>

                                    <p class="text-muted">

                                        Hozircha hech qanday sinf mavjud emas.

                                    </p>

                                    <a href="{{ route('sinflar.create') }}"
                                       class="btn btn-primary">

                                        <i class="bi bi-plus-circle me-1"></i>

                                        Birinchi sinfni qo‘shish

                                    </a>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- PAGINATION --}}

        @if($sinflar->hasPages())

            <div class="card-footer bg-white">

                {{ $sinflar->links() }}

            </div>

        @endif

    </div>

</div>

@endsection