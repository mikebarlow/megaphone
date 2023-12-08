<div class="megaphone">
    <div class="relative w-12 h-12" x-data="{ open: false }">
        @include('megaphone::icon')
        @teleport('body')
            @include('megaphone::popout')
        @endteleport
    </div>
</div>
