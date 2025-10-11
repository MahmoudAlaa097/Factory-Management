@props(['title' => 'Login'])

<x-base-layout :title="$title" body-class="transition-colors duration-300">
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
</x-base-layout>
