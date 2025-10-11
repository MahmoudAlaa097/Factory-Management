@props(['title' => 'Page Title', 'bodyClass' => ''])

@php
    use App\Helpers\TranslationHelper;
    $pageTitle = TranslationHelper::pageTitle($title);
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
    class="transition-all duration-700 ease-in-out">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ $pageTitle }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Prevent FOUC (Flash of Unstyled Content) -->
    <script>
        if (localStorage.getItem('color-theme') === 'dark' ||
            (!localStorage.getItem('color-theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>

    <!-- Additional Head Content -->
    @stack('head')

    <!-- Compiled CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-foreground-light dark:text-foreground-dark {{ $bodyClass }}">
    {{ $slot }}

    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>
