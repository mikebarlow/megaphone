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

Once Livewire has been installed, if you haven't already, make sure the [Laravel Database Notifications have been installed](https://laravel.com/docs/9.x/notifications#database-prerequisites).

```bash
php artisan notifications:table
 
php artisan migrate 
```

This should create database table used to house your notifications. Next, make sure your User model (or relevant alternative model) has the notifable trait added as mentioned in the [Laravel Documentation](https://laravel.com/docs/9.x/notifications#using-the-notifiable-trait) and also add the `HasMegaphone` trait provided by Megaphone.

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

If you are not using the default user model found at `App\Models\User`, you will need to amend the value of the user class, defined in the megaphone.php config file. Simply change the value to the path of your User model. The config file should be fairly well labeled so the changes are obvious.

## Using Megaphone

## Customising Megaphone

## Testing

If you wish to run the tests, clone out the repository

    git clone git@github.com:mikebarlow/megaphone.git

Change to the root of the repository and run composer install with the dev dependencies

    cd megaphone
    composer install

A script is defined in the `composer.json` to run both the code sniffer and the unit tests

    composer run test

Or run them individually as required

    ./vendor/bin/pest
    
    ./vendor/bin/phpcs --standard=PSR2 src

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
