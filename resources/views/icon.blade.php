<button type="button"
        aria-label="show notifications"
        class="font-sans text-gray-900"
        @click="open = true"
>
    <span class="sr-only">Show Notifications</span>
    <x-megaphone::icons.bell />
    @if ($unread->count() > 0)
        @if($showCount)
            <span aria-label="unread count" class="absolute top-0 left-0 aspect-square max-h-fit rounded-full border-2 bg-red-500 px-1.5 shadow leading-5 text-white font-semibold text-xs">
                {{ $unread->count() }}
            </span>
        @else
            <span aria-label="has unread notifications" class="absolute top-0 left-0 aspect-square h-2/5 rounded-full bg-red-500 shadow">
        @endif
    @endif
</button>
