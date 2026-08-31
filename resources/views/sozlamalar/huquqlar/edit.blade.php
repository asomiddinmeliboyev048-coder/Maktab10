@extends('layouts.app')

@section('title', $user->name . ' — huquqlar')

@section('content')

<div class="pagetitle d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1>{{ $user->name }} — huquqlarni boshqarish</h1>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Bosh sahifa</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sozlamalar.index') }}">Sozlamalar</a></li>
                <li class="breadcrumb-item"><a href="{{ route('settings.permissions.index') }}">Huquqlar</a></li>
                <li class="breadcrumb-item active">{{ $user->name }}</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('settings.permissions.index') }}" class="btn btn-light border">
        <i class="bi bi-arrow-left me-1"></i> Orqaga
    </a>
</div>

<section class="section">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show smart-alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center">
                <img src="{{ $user->avatar_url }}" class="rounded-circle me-3" width="55" height="55" style="object-fit:cover;">
                <div>
                    <h5 class="fw-bold mb-0">{{ $user->name }}</h5>
                    <small class="text-muted">{{ $user->subject ?: 'Fan biriktirilmagan' }} @if($user->staff_id) &middot; {{ $user->staff_id }} @endif</small>
                </div>
            </div>

            <div class="d-flex gap-2">
                <form method="POST" action="{{ route('settings.permissions.grantAll', $user->id) }}"
                      onsubmit="return confirm('Haqiqatan ham {{ $user->name }} uchun BARCHA huquqlarni bermoqchimisiz? Bu VIEW, CREATE, EDIT va DELETE amallarining barchasini o\'z ichiga oladi.');">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="bi bi-exclamation-triangle me-1"></i> Barcha huquqlarni berish
                    </button>
                </form>

                <form method="POST" action="{{ route('settings.permissions.revokeAll', $user->id) }}"
                      onsubmit="return confirm('Haqiqatan ham {{ $user->name }} uchun barcha huquqlarni bekor qilmoqchimisiz?');">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i> Barchasini bekor qilish
                    </button>
                </form>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('settings.permissions.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0"><i class="bi bi-shield-lock text-primary me-2"></i>Modul bo'yicha huquqlar</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Modul</th>
                                <th class="text-center">
                                    Ko'rish<br>
                                    <a href="#" class="small select-column" data-action="view">Barchasi</a>
                                </th>
                                <th class="text-center">
                                    Qo'shish<br>
                                    <a href="#" class="small select-column" data-action="create">Barchasi</a>
                                </th>
                                <th class="text-center">
                                    Tahrirlash<br>
                                    <a href="#" class="small select-column" data-action="edit">Barchasi</a>
                                </th>
                                <th class="text-center">
                                    O'chirish<br>
                                    <a href="#" class="small select-column" data-action="delete">Barchasi</a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grouped as $module => $modulePermissions)
                                <tr>
                                    <td class="fw-semibold">{{ $modulePermissions->first()->module_name }}</td>
                                    @foreach(['view', 'create', 'edit', 'delete'] as $action)
                                        @php $perm = $modulePermissions->firstWhere('action', $action); @endphp
                                        <td class="text-center">
                                            @if($perm)
                                                <input type="checkbox"
                                                       class="form-check-input perm-checkbox"
                                                       data-action="{{ $action }}"
                                                       name="permissions[]"
                                                       value="{{ $perm->slug }}"
                                                       {{ in_array($perm->slug, $userSlugs) ? 'checked' : '' }}>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white p-3 text-end">
                <a href="{{ route('settings.permissions.index') }}" class="btn btn-light border">Bekor qilish</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i> Saqlash
                </button>
            </div>
        </div>
    </form>

</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.select-column').forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            var action = link.getAttribute('data-action');
            var checkboxes = document.querySelectorAll('.perm-checkbox[data-action="' + action + '"]');
            var allChecked = Array.from(checkboxes).every(function (cb) { return cb.checked; });
            checkboxes.forEach(function (cb) { cb.checked = !allChecked; });
        });
    });
});
</script>
@endpush