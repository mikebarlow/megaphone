@props([
    'id' => null,
    'markAsReadOnClick' => false,
])

<a {{ $attributes }} {{ (! empty($id) && $markAsReadOnClick ? '@click="foobar(\'' . $id . '\')"' : '') }}>
    {{ $slot }}
</a>
