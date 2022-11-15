<div x-cloak x-show="open" @click.outside="open = false" class="w-full fixed z-50 top-0 right-0 h-full overflow-x-hidden transform translate-x-0 transition ease-in-out duration-700" id="notification">
    <div class="fixed w-full h-full top-0 left-0 z-0" @click="open = false"></div>

    <div class="2xl:w-4/12 bg-gray-50 shadow-md h-screen overflow-y-auto p-8 pt-3 absolute right-0 z-30">
        <div class="flex items-center justify-between">
            <p tabindex="0" class="focus:outline-none text-2xl font-semibold leading-6 text-gray-800">Notifications</p>
            <button role="button" aria-label="close modal" class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 rounded-md cursor-pointer" @click="open = false">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 6L6 18" stroke="#4B5563" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M6 6L18 18" stroke="#4B5563" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>

        @if ($unread->count() > 0)
            <h2 tabindex="0" class="focus:outline-none text-sm leading-normal pt-8 border-b pb-2 border-gray-300 text-gray-600">
                Unread Notifications
            </h2>

            @foreach ($unread as $announcement)
                <div class="w-full p-3 mt-4 bg-white rounded flex flex-shrink-0 {{ $announcement->read_at === null ? "drop-shadow shadow border" : ""  }}">
                    <x-megaphone::display :notification="$announcement"></x-megaphone::display>

                    @if($announcement->read_at === null)
                        <button role="button" aria-label="Mark as Read" class="w-6 h-6 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 rounded-md cursor-pointer"
                                x-on:click="$wire.markAsRead('{{ $announcement->id }}')"
                        >
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 6L6 18" stroke="#4B5563" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M6 6L18 18" stroke="#4B5563" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
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
            <div class="w-full p-3 mt-4 bg-white rounded flex flex-shrink-0 {{ $announcement->read_at === null ? "drop-shadow shadow border" : ""  }}">
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

