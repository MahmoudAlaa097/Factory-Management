@props([
    'name',
    'label' => '',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'error' => null
])

<div class="space-y-2">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge([
            'class' => 'w-full rounded-lg border-none bg-background-light/50 p-4 text-gray-900
                        placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-inset
                        focus:ring-primary dark:bg-background-dark/50 dark:text-white
                        dark:placeholder-gray-500'
        ]) }}
        {{ $required ? 'required' : '' }}
        @error($name) aria-invalid="true" @enderror
    />

    @error($name)
        <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>
