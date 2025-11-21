@props([
    'class' => 'text-indigo-700 font-bold',
    'announcement',
    'markAsReadOnClick',
])

<span class="{{ $class }}">
    @if (! empty($announcement['link']))
        <x-megaphone::notification.link-tag
            :href="$announcement['link']"
            :target="(! empty($announcement['linkNewWindow']) ? '_blank' : '_self')"
            :id="$markAsReadOnClick['id'] ?? null"
            :markAsReadOnClick="$markAsReadOnClick['active'] ?? false"
        >
            {{ $slot }}
        </x-megaphone::notification.link-tag>
    @else
        {{ $slot }}
    @endif
</span>
