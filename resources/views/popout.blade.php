<div
    x-cloak
    x-show="open"
    class="fixed w-full h-full top-0 left-0 z-40 bg-black bg-opacity-20"
    @click="open = false"
    x-transition.opacity.duration.600ms
></div>

<div
    x-cloak
    x-show="open"
    x-transition:enter="transform transition ease-in-out duration-300 sm:duration-300"
    x-transition:enter-start="translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transform transition ease-in-out duration-300 sm:duration-300"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="translate-x-full"
    @click.outside="open = false"
    class="w-full lg:w-7/12 xl:w-5/12 2xl:w-3/12 fixed z-50 top-0 right-0 h-full overflow-x-hidden transform translate-x-0 transition ease-in-out duration-300"
    id="notification"
>
    <div class="w-full bg-white shadow h-screen overflow-y-auto absolute right-0 z-30">
        <div class="flex items-center justify-between border-b border-gray-200 p-4">
            <p tabindex="0" class="text-base font-semibold leading-6 text-gray-900 py-1">Notifications</p>
            <button @click="open = false" class="absolute top-0 right-0 z-30 flex items-center justify-center px-2 py-1 mt-4 mr-5 space-x-1 text-xs font-medium uppercase border rounded-md border-neutral-200 text-neutral-600 hover:bg-neutral-100">
                <x-megaphone::icons.close />
            </button>
        </div>

        <div class="p-4 pt-2">
            @if ($unread->count() > 0)
                <div class="border-b pb-2 border-gray-300 text-gray-600 flex justify-between">
                    <h2 class="focus:outline-none text-sm leading-normal pt-8">
                        Unread Notifications
                    </h2>

                    @if ($unread->count() > 1)
                        <button class="focus:outline-none text-sm leading-normal pt-8 hover:text-indigo-700" wire:click="markAllRead()">Mark all as read</button>
                    @endif
                </div>

                @foreach ($unread as $announcement)
                    <div class="w-full p-3 mt-4 bg-white rounded-xl flex flex-shrink-0 {{ $announcement->read_at === null ? "drop-shadow shadow border" : ""  }}">
                        <x-megaphone::display :notification="$announcement"></x-megaphone::display>

                        @if($announcement->read_at === null)
                            <button role="button" aria-label="Mark as Read" class="absolute top-0 right-0 outline-none px-1 py-1 mt-2 mr-2 space-x-1 cursor-pointer border rounded-md border-neutral-200 text-neutral-600 hover:bg-neutral-100"
                                    x-on:click="$wire.markAsRead('{{ $announcement->id }}')"
                            >
                                <x-megaphone::icons.close class="w-4 h-4" />
                            </button>
                        @endif
                    </div>
                @endforeach

                @if ($announcements->count() > 0)
                    <h2 tabindex="0" class="focus:outline-none text-sm leading-normal pt-8 border-b pb-2 border-gray-300 text-gray-600">
                        Previous Notifications
                    </h2>
                @endif
            @endif

            @foreach ($announcements as $announcement)
                <div class="w-full p-3 mt-4 bg-gray-50 rounded flex flex-shrink-0">
                    <x-megaphone::display :notification="$announcement"></x-megaphone::display>
                </div>
            @endforeach

            @if ($unread->count() === 0 && $announcements->count() === 0)
                <div class="flex items-center justify-between">
                    <hr class="w-full">
                    <p tabindex="0" class="focus:outline-none text-sm flex flex-shrink-0 leading-normal px-3 py-16 text-gray-500">
                        No new announcements
                    </p>
                    <hr class="w-full">
                </div>
            @endif
        </div>
    </div>
</div>

