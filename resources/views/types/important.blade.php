<div aria-label="group icon" role="img" class="focus:outline-none w-8 h-8 border rounded-full border-gray-200 flex flex-shrink-0 items-center justify-center">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512" class="w-4/5 h-4/5 fill-red-600">
        <path d="M139.315 32c6.889 0 12.364 5.787 11.982 12.666l-14.667 264c-.353 6.359-5.613 11.334-11.982 11.334H67.352c-6.369 0-11.628-4.975-11.982-11.334l-14.667-264C40.321 37.787 45.796 32 52.685 32h86.63M96 352c35.29 0 64 28.71 64 64s-28.71 64-64 64-64-28.71-64-64 28.71-64 64-64M139.315 0h-86.63C27.457 0 7.353 21.246 8.753 46.441l14.667 264c.652 11.728 5.864 22.178 13.854 29.665C14.613 357.682 0 385.168 0 416c0 52.935 43.065 96 96 96s96-43.065 96-96c0-30.832-14.613-58.318-37.274-75.894 7.991-7.487 13.203-17.937 13.854-29.665l14.667-264C184.647 21.251 164.548 0 139.315 0z"/>
    </svg>
</div>
<div class="pl-3 w-full">
    <div class="items-center justify-between w-full pr-2">
        <p class="block w-full focus:outline-none text-sm leading-none my-0">
            <span class="text-indigo-700 font-bold">
                @if(! empty($announcement['link']))
                    <a href="{{ $announcement['link'] }}">
                @endif
                        {{ $announcement['title'] }}
                        @if(! empty($announcement['link']))
                    </a>
                @endif
            </span>
        </p>
        <p class="block w-full focus:outline-none text-sm leading-none">
            {{ $announcement['body'] }}
        </p>
    </div>
    <div class="flex justify-between">
        <p class="focus:outline-none text-xs leading-3 pt-1 text-gray-500" title="{{ $created_at->format('jS M Y H:i') }}">
            {{ $created_at->diffForHumans() }}
        </p>

        @if(! empty($announcement['link']))
            <p class="text-right focus:outline-none text-xs leading-3 pt-1">
                <a href="{{ $announcement['link'] }}"
                   {{ ! empty($announcement['linkNewWindow']) ? ' target="_blank"' : '' }}
                   class="cursor-pointer no-underline bg-gray-100 text-gray-800 rounded-md border border-gray-300 p-2 hover:bg-gray-300">
                    {{ ! empty($announcement['linkText']) ? $announcement['linkText'] : 'View' }}
                </a>
            </p>
        @endif
    </div>
</div>
