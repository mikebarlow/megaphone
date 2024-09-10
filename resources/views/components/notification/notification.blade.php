<div tabindex="0" aria-label="group icon" role="img" class="focus:outline-none w-8 h-8 border rounded-full border-gray-200 flex flex-shrink-0 items-center justify-center">
    {{ ! $icon->isEmpty() ? $icon : '' }}
</div>
<div class="pl-3 w-full">
    <div class="items-center justify-between w-full pr-2 mb-1">
        <p class="block w-full focus:outline-none text-sm leading-none my-0">
            {{ $title }}
        </p>
        <p class="block w-full focus:outline-none text-sm leading-none mt-1">
            {{ $body }}
        </p>
    </div>
    <div class="flex justify-between">
        {{ $date }}

        {{ $link }}
    </div>
</div>
