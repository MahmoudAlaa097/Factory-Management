<div class="relative group">
    <button
        class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-subtle-light dark:hover:bg-subtle-dark focus:outline-none">
        <img class="size-10 rounded-full"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuAr1mgyl3qq6ndFk5o5o34wjp-WC0LVNnaPdZ8xTzWBMBsZb4XEwLCf5ZZ6nTZWUovNMXjg73G530qo67f_fCXyQrr4tyxcaCkY3GK_RJp15bsNQ_YDwAGTjAc6rVRI78IZKDlIOuMLnQSFJjFkggoqfKIZMRWFjpb2us2unUMbqld1M39NIkvsDueZiJW2itaR3773qDKeZmvvZ-HS2bYvTLe9eouClrmBfy7hOywM0G7dXkrb2PVEL8uGTHQb6a0EYu_EdcO78g" />
        <div class="hidden sm:block">
            <p class="text-sm font-semibold">Jane Doe</p>
            <p class="text-xs text-foreground-light/60 dark:text-foreground-dark/60">
                Administrator
            </p>
        </div>
        <svg class="w-5 h-5 ml-1 hidden sm:block text-foreground-light/60 dark:text-foreground-dark/60"
            fill="currentColor" viewBox="0 0 20 20">
            <path clip-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                fill-rule="evenodd"></path>
        </svg>
    </button>

    <div
        class="absolute right-0 mt-2 w-48 bg-card-light dark:bg-card-dark rounded-md shadow-lg py-1 z-10 group-focus:block hidden group-hover:flex flex-col">
        <a class="block px-4 py-2 text-sm text-foreground-light dark:text-foreground-dark hover:bg-subtle-light dark:hover:bg-subtle-dark"
            href="#">Profile</a>
        <a class="block px-4 py-2 text-sm text-foreground-light dark:text-foreground-dark hover:bg-subtle-light dark:hover:bg-subtle-dark"
            href="#">Settings</a>
        <div class="my-1 border-t border-subtle-light dark:border-subtle-dark"></div>
        <a class="flex items-center gap-2 px-4 py-2 text-sm text-danger-light dark:text-danger-dark hover:bg-danger-light/10 dark:hover:bg-danger-dark/10"
            href="#">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" viewBox="0 0 24 24">
                <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                </path>
            </svg>
            <span>Logout</span>
        </a>
    </div>
</div>
