@props(['class' => 'text-indigo-700 font-bold', 'link',])

<span class="{{ $class }}">
    @if(! empty($link))
        <a href="{{ $link }}">
    @endif

    {{ $slot }}

    @if(! empty($link))
        </a>
    @endif
</span>
