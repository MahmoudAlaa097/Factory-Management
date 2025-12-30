<x-layouts.app title="Dashboard">
    <!-- Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-ui.card title="Total Users" value="12,345" change="+10%" />
        <x-ui.card title="Active Users" value="8,765" change="+5%" />
        <x-ui.card title="New Users" value="2,345" change="+20%" />
        <x-ui.card title="Churn Rate" value="5%" change="-2%" />
    </div>
    <!-- Charts -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mt-8">
        <x-ui.chart title="User Growth Over Time" value="+15%" />
        <x-ui.chart title="User Activity by Region" value="+8%" />
    </div>
</x-layouts.app>
