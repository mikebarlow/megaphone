@props(['class' => 'text-indigo-700 font-bold', 'link', 'notificationID'])

<span class="{{ $class }}">
    @if(! empty($link))
        <a href="{{ $link }}" @click="$dispatch('notification-link-clicked', { notification: '{{ $notificationID }}' })">
    @endif

    {{ $slot }}

    @if(! empty($link))
        </a>
    @endif
</span>
