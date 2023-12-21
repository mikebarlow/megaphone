
<!--------------------------------- Notification Popout ------------------------------------->
<div>
    <div x-cloak x-show="open" x-transition   class="fixed top-0 right-0 z-50 w-full h-full overflow-x-hidden transition duration-700 ease-in-out transform translate-x-0" id="notification">
        <div class="fixed top-0 left-0 z-0 w-full h-full" @click="open = false"></div>
        <div class="2xl:w-4/12 sm:w-2/5 bg-gray-50 dark:bg-slate-800 absolute right-0 z-30 w-full h-screen p-4 pt-8 overflow-y-auto shadow-md">

            <button class="right-0" role="button" aria-label="close modal" @click="open = false"><x-icon name="x-mark" class="w-6 h-6 text-gray-500" /></button>


            <div class="flex items-center justify-between">
                <p tabindex="0" class="focus:outline-none dark:text-gray-400 text-2xl font-semibold leading-6 text-gray-800">Notifications</p>
            </div>

            <!----------------- Error Message ----------------->
            <div x-show="error" class="flex items-center justify-between">
                <hr class="w-full">
                <p tabindex="0" x-text="error" class="focus:outline-none flex flex-shrink-0 px-3 py-16 text-sm leading-normal text-red-500"></p>
                <hr class="w-full">
            </div>

            <div x-show="unreadCount > 0" >
                <div class="dark:border-slate-600 flex justify-between pt-8 pb-2 border-b border-gray-300">
                    <h2 tabindex="0" class="focus:outline-none dark:text-slate-300 text-sm leading-normal text-gray-600">
                        Unread Notifications
                    </h2>

                    <!----- Mark all as read button ----->
                    <h2 x-on:click="markAllAsRead" wire-id="{{ $this->getId() }}" tabindex="0" class="focus:outline-none dark:text-slate-400 float-right text-xs text-sm leading-normal text-gray-500">
                        Mark all as read
                    </h2>
                </div>

                <!----- Unread Notifications ----->
                @foreach ($unread as $announcement)
                    @php $id = $announcement->id; @endphp
                    <div id="unread-notification-{{ $id }}">
                        <div class="w-full p-3 mt-4 bg-white  dark:bg-slate-900 border-none  rounded flex flex-shrink-0 {{ $announcement->read_at === null ? "drop-shadow shadow border" : ""  }}">
                            <x-megaphone::display :notification="$announcement"></x-megaphone::display>

                            @if($announcement->read_at === null)
                                <button role="button" aria-label="Mark as Read" class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 w-6 h-6 rounded-md cursor-pointer"
                                        x-on:click="markAsRead('{{ $id }}')"

                                >
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M18 6L6 18" stroke="#4B5563" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M6 6L18 18" stroke="#4B5563" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!--------------- Previous Notifications ----------------->
            @if ($announcements->count() > 0)
                <h2 tabindex="0" class="focus:outline-none dark:border-slate-600 dark:text-slate-300 pt-8 pb-2 text-sm leading-normal text-gray-600 border-b border-gray-300">
                    Previous Notifications
                </h2>
            @endif
            @foreach ($announcements as $announcement)
                <div class="w-full p-3   dark:bg-slate-800 dark:border-slate-700 border-b border-gray-300 rounded flex flex-shrink-0 {{ $announcement->read_at === null ? "drop-shadow shadow border" : ""  }}">
                    <x-megaphone::display :notification="$announcement"></x-megaphone::display>
                </div>
            @endforeach

            @if ($unread->count() === 0 && $announcements->count() === 0)
                <div class="flex items-center justify-between">
                    <hr class="w-full">
                    <p tabindex="0" class="focus:outline-none flex flex-shrink-0 px-3 py-16 text-sm leading-normal text-gray-500">
                        No new announcements
                    </p>
                    <hr class="w-full">
                </div>
            @endif

        </div>


    </div>

    <!-- Background Overlay, when the sidebar is open -->
    <div x-show="open" x-cloak  class="fixed inset-0 z-30 block bg-gray-800 opacity-75">..</div>
</div>
