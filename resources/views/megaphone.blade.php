<div class="megaphone" x-data="notifications(
    @js([
        'polling' => $polling,
        'pollInterval' => $pollInterval,
        'pollRouteUrl' => $pollRouteUrl,
    ])
)">
    <div class="relative w-12 h-12 mt-4">
        @include('megaphone::icon')
        @teleport('body')
            @include('megaphone::popout')
        @endteleport
    </div>
</div>
