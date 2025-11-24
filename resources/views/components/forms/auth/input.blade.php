@props(['name', 'label' => '', 'type' => 'text', 'placeholder' => '', 'required' => false])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ $label }}
    </label>
    <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
           class="w-full rounded-lg border-none bg-background-light/50 p-4 text-gray-900
                  placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-inset
                  focus:ring-primary dark:bg-background-dark/50 dark:text-white
                  dark:placeholder-gray-500"
           placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}>
</div>
