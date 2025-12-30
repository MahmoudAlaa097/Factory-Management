@props(['title' => 'Login'])

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
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-foreground-light dark:text-foreground-dark transition-colors duration-300">
    <!-- Theme Toggle (Floating) -->
    <div class="fixed top-4 z-50 ltr:right-4 rtl:left-4">
        <x-layout.theme-toggle />
    </div>

    <!-- Centered Content -->
    <div class="flex min-h-screen flex-col items-center justify-center p-4">
        <div class="w-full max-w-md space-y-8">
            <!-- Header -->
            @isset($header)
                {{ $header }}
            @else
                <div class="text-center">
                    <h1 class="text-3xl font-bold">
                        {{ __('messages.' . strtolower($title)) }}
                    </h1>
                    @isset($subtitle)
                        <p class="mt-2 text-gray-600 dark:text-gray-400">
                            {{ $subtitle }}
                        </p>
                    @endisset
                </div>
            @endisset

            <!-- Main Content Card -->
            <div class="rounded-lg bg-white/5 p-8 shadow-lg backdrop-blur-sm dark:bg-black/10 border border-subtle-light dark:border-subtle-dark">
                {{ $slot }}
            </div>

            <!-- Footer Links -->
            @isset($footer)
                <div class="text-center">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>

    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>
