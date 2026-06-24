@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="linkssystem" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ? $title . ' · ' . config('app.name') : config('app.name') }}</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite('resources/css/app.css')
</head>
<body class="min-h-full bg-base-200 text-base-content flex flex-col font-sans antialiased">
    <x-navbar />

    <main class="flex-1 w-full">
        <x-alert />
        {{ $slot }}
    </main>

    <x-footer />
</body>
</html>
