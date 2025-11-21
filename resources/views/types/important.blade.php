<x-megaphone::notification.notification :body="$announcement['body']">
    <x-slot:icon>
        <x-megaphone::icons.exclaimation />
    </x-slot:icon>

    <x-slot:title>
        <x-megaphone::notification.title :announcement="$announcement" :markAsReadOnClick="$markAsReadOnClick">
            {{ $announcement['title'] }}
        </x-megaphone::notification.title>
    </x-slot:title>

    <x-slot:date>
        <x-megaphone::notification.date :createdAt="$created_at" />
    </x-slot:date>

    <x-slot:link>
        <x-megaphone::notification.link :announcement="$announcement" :markAsReadOnClick="$markAsReadOnClick" />
    </x-slot:link>
</x-megaphone::notification.notification>
