@if(! empty($link))
    <p class="text-right focus:outline-none text-xs leading-3 pt-1">
        <a href="{{ $link }}" {{ ! empty($newWindow) ? ' target="_blank"' : '' }} {{ $attributes->merge() }}>
            {{ ! empty(linkText) ? $linkText : 'View' }}
        </a>
    </p>
@endif
