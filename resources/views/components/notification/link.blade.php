@props([
    'parentClass' => 'mt-2 text-right focus:outline-none text-xs leading-3 pt-1 pb-2 right-0',
    'class' => 'cursor-pointer no-underline bg-gray-100 text-gray-800 rounded-md border border-gray-300 p-2 hover:bg-gray-300',
    'link', 'newWindow', 'linkText',
])

@if(! empty($link))
    <p class="{{ $parentClass }}">
        <a href="{{ $link }}" {{ ! empty($newWindow) ? ' target="_blank"' : '' }} class="{{ $class }}">
            {{ ! empty($linkText) ? $linkText : 'View' }}
        </a>
    </p>
@endif
