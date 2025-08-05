@props(['pages' => []])

@php
    $lastPage = end($pages);
    $lastTitle = is_array($lastPage) ? ($lastPage['title'] ?? '') : $lastPage;
@endphp

<div x-data="{ pageName: '{{ $lastTitle }}'}">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h2
            class="text-xl font-semibold text-gray-800 dark:text-white/90"
            x-text="pageName">
        </h2>

        <nav>
            <ol class="flex items-center gap-1.5">
                <li>
                    <a
                    class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                    href="index.html">
                    Home
                        <svg
                        class="stroke-current"
                        width="17"
                        height="16"
                        viewBox="0 0 17 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                            <path
                            d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366"
                            stroke=""
                            stroke-width="1.2"
                            stroke-linecap="round"
                            stroke-linejoin="round"/>
                        </svg>
                    </a>
                </li>

                 @foreach ($pages as $page)
                    @php
                        $title = is_array($page) ? ($page['title'] ?? '') : $page;
                        $href = is_array($page) ? ($page['href'] ?? null) : null;
                        $isLast = $loop->last;
                    @endphp

                    <li class="flex items-center gap-1.5">
                        @if (!$loop->first)
                            <svg class="stroke-current text-gray-500 dark:text-gray-400" width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        @endif

                        @if ($href && !$isLast)
                            <a href="{{ $href }}" class="text-sm text-gray-500 dark:text-gray-400">{{ $title }}</a>
                        @else
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $title }}</span>
                        @endif
                    </li>
                @endforeach
            </ol>
        </nav>
    </div>
</div>

