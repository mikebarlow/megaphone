<span {{ $attributes->merge() }}>
    @if(! empty($link))
        <a href="{{ $link }}">
    @endif

    {{ $slot }}

    @if(! empty($link))
        </a>
    @endif
</span>
