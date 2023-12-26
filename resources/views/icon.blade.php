<button type="button"
        aria-label="show notifications"
        class="dark:text-slate-400 sm:mt-0 mt-1 font-sans text-gray-900 border-none"
        @click="open = true"
>
    <span class="sr-only">Show Notifications</span>
    <svg class="fill-none sm:w-8 sm:h-8 w-6 h-6" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
    </svg>

    <div x-show="getUnreadCount() > 0">
        @if($showCount)
            <span
            x-text="getUnreadCount()"
            aria-label="unread count" class="aspect-w-1 aspect-h-1 max-h-fit absolute top-0 left-0 flex items-center justify-center px-1 text-xs font-semibold leading-5 text-white bg-red-500 rounded-full shadow" style="font-size: 0.7rem; width: 1rem; height: 1rem;">
            </span>
        @else
            <span aria-label="has unread notifications" class="aspect-square h-2/5 absolute top-0 left-0 bg-red-500 rounded-full shadow" style="width: 0.4rem; height: 0.4rem;"></span>
        @endif
    </div>
</button>
