<p align="center"><a href="https://github.com/mikebarlow/megaphone" target="_blank"><img src="https://raw.githubusercontent.com/mikebarlow/megaphone/main/social-image.png" width="800"></a></p>

<p align="center">
    <a href="https://twitter.com/mikebarlow" target="_blank"><img src="http://img.shields.io/badge/author-@mikebarlow-red.svg?style=flat-square" alt="Author"></a>
    <a href="https://github.com/mikebarlow/megaphone/releases" target="_blank"><img src="https://img.shields.io/github/release/mikebarlow/megaphone.svg?style=flat-square" alt="Latest Version"></a>
    <a href="https://github.com/mikebarlow/megaphone/blob/main/LICENSE" target="_blank"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Software License"></a>
    <a href="https://github.com/mikebarlow/megaphone/actions" target="_blank"><img src="https://img.shields.io/github/workflow/status/mikebarlow/megaphone/PHP%20Composer?style=flat-square" alt="Build Status"></a>
</p>  

Megaphone is a Laravel Livewire based component that uses the power of Laravels built in Notifications system to allow you to add "Bell Icon Notification System" to your app.

Megaphone also ships with an Admin form component that allows you to send out a notification to all your users at once. Perfect for announcing new features or planned maintenance!

## Installation

Simply require the package via composer into your Laravel app.

    composer require mbarlow/megaphone

If you aren't already using Laravel Livewire in your app, Megaphone should include the package via its dependency. Once composer has finished installing, make sure you run the [Livewire installation steps](https://laravel-livewire.com/docs/2.x/installation).

Once Livewire has been installed, if you haven't already, ensure the [Laravel Database Notifications have been installed](https://laravel.com/docs/9.x/notifications#database-prerequisites) into your app.

```bash
php artisan notifications:table
 
php artisan migrate 
```

This should create database table used to house your notifications. Next, make sure your User model (or relevant alternative model) has the notifiable trait added as mentioned in the [Laravel Documentation](https://laravel.com/docs/9.x/notifications#using-the-notifiable-trait) and also add the `HasMegaphone` trait provided by Megaphone.

```php
<?php
 
namespace App\Models;
 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use MBarlow\Megaphone\HasMegaphone;
 
class User extends Authenticatable
{
    use Notifiable;
    use HasMegaphone
}
```

Lastly, publish the Megaphone assets. This should publish the Config file as well as the templates and stylesheets.

```bash
php artisan vendor:publish --provider="MBarlow\Megaphone\MegaphoneServiceProvider"
```

If you are not using the default user model found at `App\Models\User`, you will need to amend the value of the `model` attribute, defined in the megaphone.php config file. Simply change the value to the path of your User model.

## Using Megaphone

To get started using megaphone, drop in the Megaphone Livewire component into your template.

```html
<livewire:megaphone></livewire:megaphone>
```

This will render a Bell Icon where the component has been placed. When clicked a static sidebar will appear on the right of the screen which will show all the existing and any new notifications to the user.

### Styling

As default, Megaphone uses TailwindCSS to style the Bell Icon and the notification sidebar. If you are not using Tailwind you may want to include the Megaphone CSS into your template.

```html
<link rel="stylesheet" href="{{ asset('vendor/megaphone/css/announcements.css') }}">
```

The last step of the installation process involves running the vendor publish command. This will also publish the template files to your apps resources directory. You can find them in `resources/views/vendor/megaphone`.

## Sending Notifications

As default, Megaphone will only load notifications that have been registered within the Megaphone config file. Notifications shipped with Megaphone will be within `config('megaphone.types')`. This will be merged with the key values of `config('megaphone.customTypes')` to create the list of supported notifications.

This means, you can see use the Laravel Notification system for other parts of your system without them appearing in the Megaphone notifications list.

To send a Megaphone Notification instantiate a new Notification that extends `MBarlow\Megaphone\Types\BaseAnnouncement`. Megaphone ships with 3 as default, `MBarlow\Megaphone\Types\General`, `MBarlow\Megaphone\Types\Important` and `MBarlow\Megaphone\Types\NewFeature`.

```php 
$notification = new \MBarlow\Megaphone\Types\Important(
    'Expected Downtime!', // Notification Title
    'We are expecting some downtime today at around 15:00 UTC for some planned maintenance. Read more on a blog post!', // Notification Body
    'https://example.com/link', // Optional: URL. Megaphone will add a link to this URL within the Notification display.
    'Read More...' // Optional: Link Text. The text that will be shown on the link button.
);
```

Now, simply notify the required user of the notification as per the [Laravel Documentation](https://laravel.com/docs/9.x/notifications#using-the-notifiable-trait).

```php 
$user = \App\Models\User::find(1);

$user->notify($notification);
```

Next time User ID 1 visits your app, their Bell Icon will have a red indicator with "1" inside to denote 1 new, unread notification.


## Testing

If you wish to run the tests, clone out the repository

```bash
    git clone git@github.com:mikebarlow/megaphone.git
```

Change to the root of the repository and run composer install with the dev dependencies

```bash
    cd megaphone
    composer install
```

A script is defined in the `composer.json` to run both the code sniffer and the unit tests

```bash 
    composer run test
```

Or run them individually as required

```bash
    ./vendor/bin/pest
    ./vendor/bin/phpcs --standard=PSR2 src
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
