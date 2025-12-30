<x-layouts.auth title="Login">
    {{-- Custom Header Slot --}}
    <x-slot:header>
        <div class="text-center">
            <h1 class="text-3xl font-bold">
                {{ __('messages.login.welcome_back') }}
            </h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                {{ __('messages.login.login_to_continue') }}
            </p>
        </div>
    </x-slot:header>

    {{-- Main Content (Form) --}}
    <form method="POST" action="/login" class="space-y-6">
        @csrf

        <x-forms.auth.input
            name="username"
            label="{{ __('messages.login.username') }}"
            type="text"
            placeholder="{{ __('messages.login.enter_username') }}"
            required="true"
        />

        <x-forms.auth.input
            name="password"
            label="{{ __('messages.login.password') }}"
            type="password"
            placeholder="{{ __('messages.login.enter_password') }}"
            required="true"
        />

        <x-forms.auth.button>
            {{ __('messages.login.login') }}
        </x-forms.auth.button>
    </form>

    {{-- Footer Slot --}}
    <x-slot:footer>
        <a href="{{ route('switch-language', app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
            class="text-sm font-medium text-primary hover:text-primary/80 transition-colors">
            {{ __('messages.login.switch_language') }}
        </a>
    </x-slot:footer>
</x-layouts>
