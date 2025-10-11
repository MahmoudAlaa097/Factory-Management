@props(['title' => 'Card Title', 'value' => '0'])

<div class="bg-card-light dark:bg-card-dark p-6 rounded-lg shadow">
    <h2 class="text-lg font-semibold mb-2">
        {{ $title }}
    </h2>
    <div class="flex items-baseline gap-2">
        <p class="text-3xl font-bold">{{ $value }}</p>
        <p class="text-sm font-medium text-success-light dark:text-success-dark">
            vs last 30 days
        </p>
    </div>
    <div class="h-64 mt-4">
        <svg fill="none" height="100%" preserveAspectRatio="none" viewBox="0 0 472 150" width="100%"
            xmlns="http://www.w3.org/2000/svg">
            <path
                d="M0 109C18.1538 109 18.1538 21 36.3077 21C54.4615 21 54.4615 41 72.6154 41C90.7692 41 90.7692 93 108.923 93C127.077 93 127.077 33 145.231 33C163.385 33 163.385 101 181.538 101C199.692 101 199.692 61 217.846 61C236 61 236 45 254.154 45C272.308 45 272.308 121 290.462 121C308.615 121 308.615 149 326.769 149C344.923 149 344.923 1 363.077 1C381.231 1 381.231 81 399.385 81C417.538 81 417.538 129 435.692 129C453.846 129 453.846 25 472 25"
                stroke="#1773cf" stroke-linecap="round" stroke-width="3"></path>
            <path
                d="M0 109C18.1538 109 18.1538 21 36.3077 21C54.4615 21 54.4615 41 72.6154 41C90.7692 41 90.7692 93 108.923 93C127.077 93 127.077 33 145.231 33C163.385 33 163.385 101 181.538 101C199.692 101 199.692 61 217.846 61C236 61 236 45 254.154 45C272.308 45 272.308 121 290.462 121C308.615 121 308.615 149 326.769 149C344.923 149 344.923 1 363.077 1C381.231 1 381.231 81 399.385 81C417.538 81 417.538 129 435.692 129C453.846 129 453.846 25 472 25V150H0V109Z"
                fill="url(#paint0_linear_growth)"></path>
            <defs>
                <linearGradient gradientUnits="userSpaceOnUse" id="paint0_linear_growth" x1="236" x2="236"
                    y1="1" y2="150">
                    <stop stop-color="#1773cf" stop-opacity="0.2"></stop>
                    <stop offset="1" stop-color="#1773cf" stop-opacity="0"></stop>
                </linearGradient>
            </defs>
        </svg>
    </div>
    <div class="flex justify-between text-xs font-medium text-foreground-light/60 dark:text-foreground-dark/60 mt-2">
        <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span><span>Jul</span>
    </div>
</div>
