<button type="button"
        aria-label="show notifications"
        class="font-sans text-gray-900"
        @click="open = true"
>
    <span class="sr-only">Show Notifications</span>
    <x-megaphone::icons.bell />
    @if ($unread->count() > 0)
        @if($showCount)
            <sub class="absolute top-1 left-1" aria-label="unread count">
                <span class="relative flex h-5 w-5 -mt-1">
                    <span class="motion-safe:animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-5 w-5 bg-red-500 text-white text-xs aspect-square text-center">
                        <span class="w-full leading-5">
                            {{ $unread->count() > 9 ? '9+' : $unread->count() }}
                        </span>
                    </span>
                </span>
            </sub>
        @else
            <sub class="absolute top-2 left-2" aria-label="has unread notifications">
                <span class="relative flex h-3 w-3 -mt-1">
                  <span class="motion-safe:animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                </span>
            </sub>
        @endif
    @endif
</button>
