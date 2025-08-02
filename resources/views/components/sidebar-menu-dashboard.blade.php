@props(['href', 'icon', 'title'])
<li>
    <a href="{{ $href ? route($href) : '#'  }}" class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700
        {{ $href && request()->routeIs($href) ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
        @if($icon)
            <x-dynamic-component :component="$icon" class="w-5 h-5 text-gray-400 mr-3" />
        @endif
        <span class="ml-3" sidebar-toggle-item> {{ $title }} </span>
    </a>
</li>