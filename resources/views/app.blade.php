<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>NexUs</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('Icon.ico') }}">

        {{-- FOR THE PROGRESS BAR --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />

        @routes
        @vite('resources/js/app.js')
        @inertiaHead

    </head>
    <body class="overflow-hidden">
        @inertia
    </body>

    
    <script>
        window.currentRouteName = "{{ Route::currentRouteName() }}";
    </script>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</html>
