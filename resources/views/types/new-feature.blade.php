<x-megaphone::notification.notification :body="$announcement['body']">
    <x-slot:icon>
        <x-megaphone::icons.bullhorn />
    </x-slot:icon>

    <x-slot:title>
        <x-megaphone::notification.title :link="$announcement['link']">
            {{ $announcement['title'] }}
        </x-megaphone::notification.title>
    </x-slot:title>

    <x-slot:date>
        <x-megaphone::notification.date :createdAt="$created_at" />
    </x-slot:date>

    <x-slot:link>
        <x-megaphone::notification.link
            :link="$announcement['link']"
            :newWindow="$announcement['linkNewWindow']"
            :linkText="$announcement['linkText']"
        />
    </x-slot:link>
</x-megaphone::notification.notification>
