@props([
    'parentClass' => 'mt-2 text-right focus:outline-none text-xs leading-3 pt-1 pb-2 right-0',
    'class' => 'cursor-pointer no-underline bg-gray-100 text-gray-800 rounded-md border border-gray-300 p-2 hover:bg-gray-300',
    'announcement',
    'markAsReadOnClick'
])

@if(! empty($announcement['link']))
    <p class="{{ $parentClass }}">
        <x-megaphone::notification.link-tag
            :href="$announcement['link']"
            :class="$class"
            :target="(! empty($announcement['linkNewWindow']) ? '_blank' : '_self')"
            :id="$markAsReadOnClick['id'] ?? null"
            :markAsReadOnClick="$markAsReadOnClick['active'] ?? false"
        >
            {{ ! empty($announcement['linkText']) ? $announcement['linkText'] : 'View' }}
        </x-megaphone::notification.link-tag>
    </p>
@endif
