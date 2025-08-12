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
                <x-sidebar.item title="Dashboard" link="/dashboard"/>

                <!-- Menu Item Tasks -->
                <x-sidebar.dropdown title="Tasks" :pages="[
                        ['All Tasks', '/tasks']
                    ]"/>
            </x-sidebar.group>
        </nav>
        <!-- Sidebar Menu -->
    </div>
</aside>
