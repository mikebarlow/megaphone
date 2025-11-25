@props([
    'id' => null,
    'markAsReadOnClick' => false,
])

<a {{ $attributes }} {!! (! empty($id) && $markAsReadOnClick ? 'wire:click="markAsRead(\'' . $id . '\')"' : '') !!}>
    {{ $slot }}
</a>
