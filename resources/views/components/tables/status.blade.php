@props(['status' => 'pending'])

<td class="px-5 py-4 sm:px-6">
    <div class="flex items-center">
        @if ($status === 'active')
            <p class="rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-500">
                Active
            </p>
        @elseif ($status === 'pending')
            <p class="rounded-full bg-warning-50 px-2 py-0.5 text-theme-xs font-medium text-warning-700 dark:bg-warning-500/15 dark:text-warning-400">
                Pending
            </p>
        @else
            <p class="rounded-full bg-error-50 px-2 py-0.5 text-theme-xs font-medium text-error-700 dark:bg-error-500/15 dark:text-error-500">
                Cancel
            </p>
        @endif
    </div>
</td>

