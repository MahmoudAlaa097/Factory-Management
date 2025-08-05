@props([
    'action',
    'method',
    ])

<div class="p-5 border-t border-gray-100 dark:border-gray-800 sm:p-6">
    <form action="{{ $action }}" method="{{  $method  }}" class="space-y-6">
        @csrf

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <strong class="font-bold">Whoops!</strong> There were some problems with your input.
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{ $slot }}
    </form>
</div>
