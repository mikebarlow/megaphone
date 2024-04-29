@props(['class' => 'focus:outline-none text-xs leading-3 pt-1 text-gray-500', 'createdAt',])

<p class="{{ $class }}" title="{{ $createdAt->format('jS M Y H:i') }}">
    {{ $createdAt->diffForHumans() }}
</p>
