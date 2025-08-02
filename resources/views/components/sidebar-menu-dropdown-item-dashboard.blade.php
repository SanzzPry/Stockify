@props(['icon' => null, 'routeName' => null, 'title' => null])

<li>
    <a href="{{ route($routeName) }}" class="text-base text-gray-900 rounded-lg flex items-center p-2 group hover:bg-gray-100 transition duration-75 pl-8 dark:text-gray-200 dark:hover:bg-gray-700
        {{ request()->routeIs($routeName) ? 'bg-gray-200 dark:bg-gray-700' : '' }}">

        @if($icon)
            <x-dynamic-component :component="$icon" class="w-5 h-5 mr-3 text-gray-400" />
        @endif

        <span class="">{{ $title }}</span>
    </a>
</li>