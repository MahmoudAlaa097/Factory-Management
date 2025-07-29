<!-- ===== Sidebar Start ===== -->
<aside
  :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
  class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"
>
  <!-- SIDEBAR HEADER -->
    <div
      :class="sidebarToggle ? 'justify-center' : 'justify-between'"
      class="flex items-center gap-2 pt-8 sidebar-header pb-7">

        <a href="index.html">
            <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
                <img class="dark:hidden" src="{{ asset('tailadmin/build/src/images/logo/logo.svg') }}" alt="Logo" />
                <img
                class="hidden dark:block"
                src="{{ asset('tailadmin/build/src/images/logo/logo-dark.svg') }}"
                alt="Logo"
                />
            </span>

            <img
                class="logo-icon"
                :class="sidebarToggle ? 'lg:block' : 'hidden'"
                src="{{ asset('tailadmin/build/src/images/logo/logo-icon.svg') }}"
                alt="Logo"
            />
        </a>
    </div>

  <!-- Sidebar Menu -->
    <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
        <nav x-data="{selected: $persist('Dashboard')}">
            <!-- Menu Group -->
            <x-sidebar.group title="MENU">
                <!-- Menu Item Dashboard -->
                <x-sidebar.dropdown title="Dashboard" :pages="[['eCommerce', '#']]"/>

                <!-- Menu Item Calendar -->
                <x-sidebar.item title="Calendar" link="/calendar.html"/>

                <!-- Menu Item Profile -->
                <x-sidebar.item title="Profile" link="/profile.html"/>

                <!-- Menu Item Forms -->
                <x-sidebar.dropdown title="Forms" :pages="[['Form Elements', '/form-elements.html']]"/>

                <!-- Menu Item Tables -->
                <x-sidebar.dropdown title="Tables" :pages="[['Basic Tables', '/basic-tables.html']]"/>

                <!-- Menu Item Pages -->
                <x-sidebar.dropdown title="Pages" :pages="[['Blank Page', '/blank.html'], ['404 Error', '/404.html']]"/>
            </x-sidebar.group>

            <!-- Others Group -->
            <x-sidebar.group title="OTHERS">
                <!-- Menu Item Charts -->
                <x-sidebar.dropdown title="Charts" :pages="[['Line Chart', '/line-chart.html'], ['Bar Chart', '/bar-chart.html']]"/>

                <!-- Menu Item UI Elements -->
                <x-sidebar.dropdown title="UI Elements" :pages="[['Alerts', '/alerts.html'], ['Avatars', '/avatars.html'], ['Badge', '/badge.html'], ['Buttons', '/buttons.html'], ['Images', '/images.html'], ['Videos', '/videos.html']]"/>

                <!-- Menu Item Authentication -->
                <x-sidebar.dropdown title="Authentication" :pages="[['Sign In', '/signin.html'], ['Sign Up', '/signup.html']]"/>
            </x-sidebar.group>
        </nav>
        <!-- Sidebar Menu -->

        <!-- Promo Box -->
        <div
        :class="sidebarToggle ? 'lg:hidden' : ''"
        class="mx-auto mb-10 w-full max-w-60 rounded-2xl bg-gray-50 px-4 py-5 text-center dark:bg-white/[0.03]"
        >
        <h3 class="mb-2 font-semibold text-gray-900 dark:text-white">
            #1 Tailwind CSS Dashboard
        </h3>
        <p class="mb-4 text-gray-500 text-theme-sm dark:text-gray-400">
            Leading Tailwind CSS Admin Template with 400+ UI Component and Pages.
        </p>
        <a
            href="https://tailadmin.com/pricing"
            target="_blank"
            rel="nofollow"
            class="flex items-center justify-center p-3 font-medium text-white rounded-lg bg-brand-500 text-theme-sm hover:bg-brand-600"
        >
            Purchase Plan
        </a>
        </div>
        <!-- Promo Box -->
    </div>
</aside>
