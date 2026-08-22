@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold m-0"><i class="bi bi-journal-bookmark me-2"></i>Sinflar ro‘yxati</h4>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addClassModal">
            <i class="bi bi-plus-lg me-1"></i>Sinf va Excel yuklash
        </button>
    </div>

    <!-- JADVAL -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle m-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Sinf nomi</th>
                            <th>Sinf rahbari</th>
                            <th>Xona</th>
                            <th class="text-end pe-3">Amallar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sinflar as $s)
                            <tr>
                                <td class="ps-3">{{ $loop->iteration }}</td>
                                <td class="fw-bold"><span class="badge bg-primary fs-6">{{ $s->nomi }}</span></td>
                                <td>{{ $s->sinf_rahbari ?? '-' }}</td>
                                <td>{{ $s->xona ?? '-' }}</td>
                                <td class="text-end pe-3">
                                    <!-- Ko'rish tugmasi -->
                                    <a href="{{ route('sinflar.show', $s->id) }}" class="btn btn-sm btn-outline-info me-1" title="O'quvchilarni ko'rish">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <!-- Tahrirlash tugmasi -->
                                    <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $s->id }}" title="Tahrirlash">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <!-- O'chirish -->
                                    <form action="{{ route('sinflar.destroy', $s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Sinfni va undagi o\'quvchilarni o\'chirmoqchimisiz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="O'chirish"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>

                            <!-- TAHRIRLASH MODAL OYNASI -->
                            <div class="modal fade" id="editModal{{ $s->id }}" tabindex="-1" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content text-start">
                                  <form action="{{ route('sinflar.update', $s->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                      <h5 class="modal-title fw-bold">Sinfni tahrirlash: {{ $s->nomi }}</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-2 mb-3">
                                            <div class="col-6">
                                                <label class="form-label fw-bold">Sinf soni</label>
                                                <input type="number" name="raqam" class="form-control" value="{{ $s->raqam }}" required min="1" max="11">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label fw-bold">Sinf harfi</label>
                                                <input type="text" name="harf" class="form-control" value="{{ $s->harf }}" required maxlength="5">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Sinf rahbari</label>
                                            <input type="text" name="sinf_rahbari" class="form-control" value="{{ $s->sinf_rahbari }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Xona</label>
                                            <input type="text" name="xona" class="form-control" value="{{ $s->xona }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yopish</button>
                                      <button type="submit" class="btn btn-success">Yangilash</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Sinflar hali kiritilmagan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- SINF QO'SHISH MODAL OYNASI -->
<div class="modal fade" id="addClassModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('sinflar.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title fw-bold">Yangi sinf va Excel biriktirish</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="row g-2 mb-3">
                <div class="col-6">
                    <label class="form-label fw-bold">Sinf soni</label>
                    <input type="number" name="raqam" class="form-control" placeholder=" Masalan: 5" required min="1" max="11">
                </div>
                <div class="col-6">
                    <label class="form-label fw-bold">Sinf harfi</label>
                    <input type="text" name="harf" class="form-control" placeholder="Masalan: A" required maxlength="5">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Sinf rahbari (ixtiyoriy)</label>
                <input type="text" name="sinf_rahbari" class="form-control" placeholder="F.I.O">
            </div>

            <div class="mb-3">
                <label class="form-label">Xona (ixtiyoriy)</label>
                <input type="text" name="xona" class="form-control" placeholder="Masalan: 204">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold text-success"><i class="bi bi-file-earmark-excel me-1"></i>O‘quvchilar Excel fayli (.xlsx)</label>
                <input type="file" name="excel_file" class="form-control" accept=".xlsx, .xls, .csv">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yopish</button>
          <button type="submit" class="btn btn-primary">Saqlash</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection