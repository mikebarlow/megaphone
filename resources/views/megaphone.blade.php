<div class="megaphone" x-data="notifications(
    @js([
        'polling' => $polling,
        'pollInterval' => $pollInterval,
        'pollRouteUrl' => $pollRouteUrl,
        'notifiable' => base64_encode(json_encode([
            'id' => $notifiable->getKey(),
            'model' => $notifiable->getMorphClass(),
        ])), // base 64 encoded to ensure that it can be safely passed as a url parameter
        'csrfToken' => csrf_token(),
    ])
)">
    <div class="relative w-12 h-12 mt-4">
        @include('megaphone::icon')
        @teleport('body')
            @include('megaphone::popout')
        @endteleport
    </div>
</div>
