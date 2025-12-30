@props(['title' => 'Page Title'])

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

    <!-- Sync Laravel locale with JavaScript BEFORE loading app.js -->
    <script>
        const serverLocale = '{{ app()->getLocale() }}';
        const serverDir = '{{ app()->getLocale() === "ar" ? "rtl" : "ltr" }}';
        localStorage.setItem('lang', serverLocale);
        document.documentElement.setAttribute('lang', serverLocale);
        document.documentElement.setAttribute('dir', serverDir);
    </script>

    <!-- Additional Head Content -->
    @stack('head')

    <!-- Compiled CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Livewire Styles -->
    @livewireStyles
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-foreground-light dark:text-foreground-dark">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <x-layout.sidebar />

        <!-- Main Content -->
        <main class="flex-1 p-6 lg:p-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold">{{ $pageTitle }}</h1>

                <!-- Right section: theme toggle, language toggle, profile -->
                <div class="flex items-center gap-4">
                    <!-- Dark Mode Toggle -->
                    <x-layout.theme-toggle />

                    <!-- Language Toggle -->
                    <x-layout.lang-toggle />

                    <!-- Profile Dropdown -->
                    <x-layout.profile />
                </div>
            </div>

            <!-- Page Content -->
            {{ $slot }}
        </main>
    </div>

    <!-- Livewire Scripts -->
    @livewireScripts

    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>
