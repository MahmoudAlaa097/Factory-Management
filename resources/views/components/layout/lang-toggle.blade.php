<form action="{{ route('switch-language', app()->getLocale() === 'en' ? 'ar' : 'en') }}" method="get">
    @csrf
    <button type="submit"
        class="flex items-center gap-1 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                   bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700">
        @if (app()->getLocale() === 'en')
            🇪🇬 <span>AR</span>
        @else
            🇬🇧 <span>EN</span>
        @endif
    </button>
</form>
