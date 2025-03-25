<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $shop->name ?? 'My Shop' }}</title>
    <meta name="description" content="{{ $shop->description ?? 'My Description Shop' }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="{{ $shop->name ?? 'My Shop' }}">
    <meta property="og:description" content="{{ $shop->description ?? 'My Description Shop' }}">
    <meta property="og:image" content="{{ Storage::url($shop->url_logo) ?? null }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url('/') }}">
    <meta property="twitter:title" content="{{ $shop->name ?? 'My Shop' }}">
    <meta property="twitter:description" content="{{ $shop->description ?? 'My Description Shop' }}">
    <meta property="twitter:image" content="{{ Storage::url($shop->url_logo) ?? null }}">

    <link rel="canonical" href="{{ url('/') }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ $shop && $shop->url_logo ? Storage::url($shop->url_logo) : asset('icon-sosmed67e2d8e047dba.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <main>
        <!-- Add your main content here -->
        <livewire:home-page />
    </main>

    <footer>
        {{-- Add your footer content here --}}
        <livewire:footer />
    </footer>
</body>
</html>