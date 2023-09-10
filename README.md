<p align="center"><a href="https://github.com/mikebarlow/megaphone" target="_blank"><img src="https://raw.githubusercontent.com/mikebarlow/megaphone/main/social-image.png" width="800"></a></p>

<p align="center">
    <a href="https://twitter.com/mikebarlow" target="_blank"><img src="http://img.shields.io/badge/author-@mikebarlow-red.svg?style=flat-square" alt="Author"></a>
    <a href="https://github.com/mikebarlow/megaphone/releases" target="_blank"><img src="https://img.shields.io/github/release/mikebarlow/megaphone.svg?style=flat-square" alt="Latest Version"></a>
    <a href="https://github.com/mikebarlow/megaphone/blob/main/LICENSE" target="_blank"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Software License"></a>
    <a href="https://github.com/mikebarlow/megaphone/actions" target="_blank"><img src="https://img.shields.io/github/workflow/status/mikebarlow/megaphone/PHP%20Composer?style=flat-square" alt="Build Status"></a>
</p>  

Megaphone is a Laravel Livewire based component that uses the power of Laravels built in Notifications system to allow you to add "Bell Icon Notification System" to your app.

Megaphone also ships with an Admin form component that allows you to send out a notification to all your users at once. Perfect for announcing new features or planned maintenance!

<p align="center"><a href="https://serverauth.com/?utm_campaign=megaphone-sponsor&utm_source=github&utm_medium=readme" target="_blank"><img src="https://serverauth.com/assets/misc/sponsor-img.png" alt="Server Management by ServerAuth.com"></a></p>

## Demo

Before using Megaphone, a demo is available for you to view and try the Bell Icon component and Admin component. Aside from some minor styling changes to the Admin component so it fits the layout better, everything is "out the box" and will be exactly as is when you install Megaphone yourself.

[View the Megaphone Demo](https://megaphone.mikebarlow.co.uk)

## Upgrade from 1.x

Megaphone has been updated to support Livewire 3. This also means PHP requirements have been updated to match the requirements of Livewire 3 which means you need to be running PHP 8.1 or above (PHP 7.4 and 8.0 are no longer supported).
Then make sure you follow the [Livewire upgrade guide](https://livewire.laravel.com/docs/upgrading).

Update your Megaphone requirement to 2.* by running the following command in your terminal.

```bash
    composer require mbarlow/megaphone "^2.0"
```

### AlpineJS

If you previously included AlpineJS specifically for Megaphone then you can now remove that from your JS include because it is now bundled with Livewire.

### Template Changes

If you are using the Admin component and are running with the Megaphone views published to your resources folder, you may wish to make these manual changes.

Changes are all to `create-announcement.blade.php` which, if published, should be found at `resources/views/vendor/megaphone/admin/create-announcement.blade.php`.

Find `wire:model="type"` and replace it with `wire:model.live="type"`.

Find all instances of `wire:model.lazy` and replace it with `wire:model.blur`.

## Installation

Simply require the package via composer into your Laravel app.

    composer require mbarlow/megaphone

If you aren't already using Laravel Livewire in your app, Megaphone should include the package via its dependency. Once composer has finished installing, make sure you run the [Livewire installation steps](https://livewire.laravel.com/docs/installation).

Once Livewire has been installed, if you haven't already, ensure the [Laravel Database Notifications have been installed](https://laravel.com/docs/10.x/notifications#database-prerequisites) into your app.

```bash
php artisan notifications:table
 
php artisan migrate 
```

This should create database table used to house your notifications. Next, make sure your User model (or relevant alternative model) has the notifiable trait added as mentioned in the [Laravel Documentation](https://laravel.com/docs/10.x/notifications#using-the-notifiable-trait) and also add the `HasMegaphone` trait provided by Megaphone.

```php
<?php
 
namespace App\Models;
 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use MBarlow\Megaphone\HasMegaphone;
 
class User extends Authenticatable
{
    use Notifiable;
    use HasMegaphone;
}
```

Lastly, publish the Megaphone assets. This should publish the Config file as well as the templates and stylesheets. You can find the published templates within `resources/views/vendor/megaphone`.

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
<link rel="stylesheet" href="{{ asset('vendor/megaphone/css/megaphone.css') }}">
```

## Sending Notifications

As default, Megaphone will only load notifications that have been registered within the Megaphone config file. Notifications shipped with Megaphone will be within `config('megaphone.types')`. This will be merged with the key values of `config('megaphone.customTypes')` to create the list of supported notifications.

This means, you can see use the Laravel Notification system for other parts of your system without them appearing in the Megaphone notifications list.

To send a Megaphone notification instantiate a new notification that extends `MBarlow\Megaphone\Types\BaseAnnouncement`. Megaphone ships with 3 as default, `MBarlow\Megaphone\Types\General`, `MBarlow\Megaphone\Types\Important` and `MBarlow\Megaphone\Types\NewFeature`.

```php 
$notification = new \MBarlow\Megaphone\Types\Important(
    'Expected Downtime!', // Notification Title
    'We are expecting some downtime today at around 15:00 UTC for some planned maintenance. Read more on a blog post!', // Notification Body
    'https://example.com/link', // Optional: URL. Megaphone will add a link to this URL within the Notification display.
    'Read More...' // Optional: Link Text. The text that will be shown on the link button.
);
```

Now, simply notify the required user of the notification as per the [Laravel Documentation](https://laravel.com/docs/10.x/notifications#using-the-notifiable-trait).

```php 
$user = \App\Models\User::find(1);

$user->notify($notification);
```

Next time User ID 1 visits your app, their Bell Icon will have a red indicator with "1" inside to denote 1 new, unread notification.

## Custom Notifications

As mentioned, you can add your own notification types to Megaphone. In order to do this, first create a new class within your application and make sure it extends `MBarlow\Megaphone\Types\BaseAnnouncement`, for example:

```php 
<?php

namespace App\Megaphone;

use MBarlow\Megaphone\Types\BaseAnnouncement;

class MyCustomNotification extends BaseAnnouncement
{
}
```

Next you will need to create the view file for how Megaphone should render that notification. To get you started you can use the base template the General, Important and New Feature notifications uses. So for example, create a new view within `resources/views/megaphone/my-custom-notification.blade.php`.

```html 
@include('megaphone::types.base', ['icon' => 'ICON SVG HERE'])
```

Simply, add a relevant SVG Icon for your notification within the blade include parameters array, and you're good to go. 

Lastly, you need to tell Megaphone about this notification. Open up the Megaphone config file `config/megaphone.php` and find the `customTypes` attribute. This should be an associative array with the FQDN of the notification class as the key and the path to the view as the value. For example,

```php 
    /*
     * Custom notification types specific to your App
     */
    'customTypes' => [
        /*
            Associative array in the format of
            \Namespace\To\Notification::class => 'path.to.view',
         */
        \App\Megaphone\MyCustomNotification::class => 'megaphone.my-custom-notification', 
    ],
```

Now you can trigger the notification and a user will receive it via their Bell Icon.

```php 
$notification = new \App\Megaphone\MyCustomNotification(
    'Hello World',
    'This is a custom notification, hope you like our app!'
);

$user = \App\Models\User::find(1);

$user->notify($notification);
```

## Admin Panel

The usage shown so far is great for automatic flows, for example, letting a user know an action has completed in the background, "Your file is ready for download", "Your server has finished setting up", etc... but sometimes you may want to send notifications en masse. 

You may want to let users know that some downtime is expected for maintenance or that a cool new feature has launched. To cover these bases, Megaphone ships with an Admin component providing a form to send a notification to all users.

To use the component simply create a new page within your admin area, or create a password-protected page within your application that only you as the application owners can access and drop in this Livewire component.

```html 
<livewire:megaphone-admin></livewire:megaphone-admin>
```

Visit your page and you will be presented with a form, to first select the notification type and then fill out the title, body, link and link text. Once you have filled everything out, hit send to push the notification out to all users.

The form has been styled with TailwindCSS so if it doesn't look styled correctly make sure to include TailwindCSS on the page that is showing the Admin component. Alternatively, the view file will have been published along with the other Megaphone assets so you can customise the form styling within `resources/views/vendor/megaphone/admin/create-announcement.blade.php`.

### Notification Type List

As default, the notification type list is created by merging the array of default notifications within `config('megaphone.types')`, with the key values of the custom types array found within `config('megaphone.customTypes')`.

If you have added a lot of custom types or if you have some system notifications that should not be selectable from this type list, you can build your own type list within the `adminTypeList` attribute of the megaphone config.

Simply create an array of all the notification classes you wish to have available in the drop down list.

```php 
'adminTypeList' => [
    \MBarlow\Megaphone\Types\NewFeature::class,
    \App\Megaphone\MyCustomNotification::class,
],
```

This example would mean only the default New Feature notification and your Custom Notification would be available from the drop down menu.

### Type List - Notification Name

The name shown for each notification in the drop down menu is calculated from the class name within the `BaseAnnouncement` class that all Megaphone notifications extend. If Megaphone is unable to calculate the name of a custom notification correctly, or you wish to label it differently within the Admin Component type list, you can define a `name()` method within your notification. Megaphone will use this to display the label.

```php 
<?php

namespace App\Megaphone;

use MBarlow\Megaphone\Types\BaseAnnouncement;

class MyCustomNotification extends BaseAnnouncement
{
    public static function name(): string
    {
        return 'Awesome Notification';
    }
}
```

## Clearing Old Notifications

To help keep your database and your users notifications tidy, Megaphone also ships with a console command that can be added to your apps schedule to clear old notifications.

Simply add the following to your `Console/Kernal.php` file within the `schedule()` method.

```php 
$schedule->command('megaphone:clear-announcements')->daily();
```

This will clear any "read" Megaphone notifications older than 2 weeks old. This allows any user that may not have logged in for a number of weeks to still view the notification before it would be cleared.

The 2-week time limit for old notifications is controlled via the Megaphone config file, `config('megaphone.clearAfter')`. So should you wish to alter this cut off point, simply change this value to either extend or shorten the cut off.

## Changing Notifiable Model

Because notifications can be attached to any model via the `Notifiable` trait, Megaphone too can be attached to any model providing the model also has the `Notifiable` trait attached.

As default, Megaphone assumes you will be attaching it to the standard Laravel User model and when loading notifications, it will attempt to retrieve the ID of the logged in user from the Request object.

If you are wanting to attach Megaphone to a Team model for example, change the `model` attribute of the published megaphone config file, `megaphone.php`.

When rendering the Megaphone component, you will then need to pass in the ID of the notifiable model into the component so Megaphone can load the correct notifications

```html
<livewire:megaphone :notifiableId="$user->team->id"></livewire:megaphone>
```



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
