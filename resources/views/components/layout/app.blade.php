<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    @vite('resources/css/app.css')   
</head>
<body class="bg-base-900 text-slate-50 h-full">
    {{ $slot }}  
</body>
</html>l>

