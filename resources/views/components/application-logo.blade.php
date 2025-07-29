{{-- Custom Logo Implementation --}}
@php
    $logoPath = 'images/logo.png'; // Ganti dengan path logo Anda
    $logoExists = file_exists(public_path($logoPath));
@endphp

@if($logoExists)
    <img src="{{ asset($logoPath) }}" alt="{{ config('app.name', 'Laravel') }} Logo" {{ $attributes->merge(['class' => 'block h-9 w-auto fill-current']) }}>
@else
    {{-- Fallback: Logo text atau SVG sederhana jika file logo tidak ditemukan --}}
    <div {{ $attributes->merge(['class' => 'flex items-center justify-center h-9 px-3 bg-indigo-600 text-white rounded font-bold']) }}>
        {{ config('app.name', 'Laravel') }}
    </div>
@endif
