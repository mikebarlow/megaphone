@props([
    'class' => 'cursor-pointer no-underline bg-gray-100 text-gray-800 rounded-md border border-gray-300 p-2 hover:bg-gray-300',
    'link', 'newWindow', 'linkText',
])

@if(! empty($link))
    <p class="text-right focus:outline-none text-xs leading-3 pt-1">
        <a href="{{ $link }}" {{ ! empty($newWindow) ? ' target="_blank"' : '' }} class="{{ $class }}">
            {{ ! empty($linkText) ? $linkText : 'View' }}
        </a>
    </p>
@endif
