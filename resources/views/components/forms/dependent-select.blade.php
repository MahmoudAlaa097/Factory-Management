<x-forms.group :label="$label">
    <div class="relative">
        <x-forms.select
            wire:model.live="{{ $wireModel }}"
            name="{{ $name }}"
            :disabled="$disabled || $isLoading"
            :required="$required"
        >
            <option value="">
                @if($isLoading)
                    {{ $loadingMessage }}
                @elseif($dependencyMessage)
                    {{ $dependencyMessage }}
                @elseif(empty($options))
                    {{ $emptyMessage }}
                @else
                    {{ $placeholder }}
                @endif
            </option>

            @foreach($options as $option)
                <option value="{{ $option['id'] }}">
                    {{ $option['name'] ?? $option['number'] ?? $option['id'] }}
                </option>
            @endforeach
        </x-forms.select>

        {{-- Inline Spinner --}}
        @if($wireTarget)
            <div wire:loading wire:target="{{ $wireTarget }}" class="absolute inset-y-0 right-10 flex items-center pr-3 pointer-events-none">
                <svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        @endif
    </div>
</x-forms.group>
