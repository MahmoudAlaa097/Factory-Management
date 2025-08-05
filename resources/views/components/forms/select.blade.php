@props([
    'label',
    'name' => '',
    'required' => false,
    'items' => [
        'value' => '',
        'name' => '',
        ],
    'selected' => null,
    ])

<div>
    <x-forms.label :required="$required">{{ $label }}</x-forms.label>

    <select
    name="{{ $name }}"
    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
    :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
    @change="isOptionSelected = true"
    >
        @foreach ($items as $item)
            <option
                value="{{ $item['value'] }}"
                @if ($selected) selected @endif
                class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                {{ $item['name'] }}
            </option>
        @endforeach
    </select>
</div>
