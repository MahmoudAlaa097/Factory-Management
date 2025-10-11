<aside
    class="w-72 flex-col bg-background-light dark:bg-background-dark p-4 hidden lg:flex border-r border-subtle-light dark:border-subtle-dark">
    <!-- Logo -->
    <x-layout.sidebar.logo />

    <!-- Navigation -->
    <nav class="flex flex-col gap-2 flex-1">
        <x-layout.sidebar.link name="{{ __('messages.dashboard') }}" icon="dashboard" route="dashboard" />

    </nav>

    <!-- Actions -->
    <div class="mt-auto flex flex-col gap-4">
        <button
            class="w-full rounded-lg bg-primary py-2.5 px-4 text-sm font-semibold text-white shadow-sm hover:bg-primary/90">
            New Report
        </button>
    </div>
</aside>
