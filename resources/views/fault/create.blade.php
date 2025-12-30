{{-- resources/views/fault/create.blade.php --}}

<x-layouts.app title="Faults">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="mb-6">
            <h1 class="text-2xl font-bold">{{ __('messages.faults.create')}}</h1>
            <p class="mt-1 text-sm text-gray-600">{{ __('messages.faults.report')}}</p>
        </div>

        {{-- Livewire Component - handles everything --}}
        @livewire('fault-request-form')
    </div>
</x-layouts.app>
