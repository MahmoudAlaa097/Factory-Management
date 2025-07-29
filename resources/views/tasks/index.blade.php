<x-layout>
    <x-header/>
        <!-- ===== Main Content Start ===== -->
        <main>
        <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
            <!-- Breadcrumb Start -->
            <div x-data="{ pageName: `Tasks`}">
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

                            <li
                                class="text-sm text-gray-800 dark:text-white/90"
                                x-text="pageName">
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Breadcrumb End -->

            <div class="space-y-5 sm:space-y-6">
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <x-tables.title>Tasks</x-tables.title>

                    <div class="p-5 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                    <!-- ====== Table Six Start -->
                    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="max-w-full overflow-x-auto">
                            <table class="min-w-full">
                                <!-- table header -->
                                <x-tables.header :headings="['Title', 'Type', 'Priority', 'Status', 'Division', 'Creator', 'Assignee']"/>

                                <!-- table body start -->
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                    <x-tables.row
                                        user='Lindsey Curtis'
                                        project='Agency Website'
                                        team='Team Members'
                                        status='active'
                                        budget='3.9K'/>

                                     <x-tables.row
                                        user='Kaiya George'
                                        project='Technology'
                                        team='Team Members'
                                        status='pending'
                                        budget='24.9K'/>

                                     <x-tables.row
                                        user='Zain Geidt'
                                        project='Blog Writing'
                                        team='Team Members'
                                        status='cancel'
                                        budget='12.7K'/>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- ====== Table Six End -->
                </div>
              </div>
            </div>
          </div>
        </main>
        <!-- ===== Main Content End ===== -->
      </div>
</x-layout>
