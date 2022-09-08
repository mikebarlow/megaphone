<div tabindex="0" aria-label="group icon" role="img" class="focus:outline-none w-8 h-8 border rounded-full border-gray-200 flex flex-shrink-0 items-center justify-center">
    {!! $icon ?? '' !!}
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
