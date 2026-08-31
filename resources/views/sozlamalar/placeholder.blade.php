@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <h2 class="mb-1">{{ $title ?? 'Bo\'lim' }}</h2>
    <p class="text-muted mb-4">Bosh sahifa / {{ $title ?? 'Bo\'lim' }}</p>

    <div class="card">
        <div class="card-body text-center py-5">
            <div style="font-size:48px;">🚧</div>
            <h4 class="mt-3 mb-2">"{{ $title ?? 'Bu bo\'lim' }}" hali tayyorlanmoqda</h4>
            <p class="text-muted mb-0">Ushbu sahifa hozircha ishlab chiqilmoqda, tez orada faol bo'ladi.</p>
        </div>
    </div>

</div>
@endsection