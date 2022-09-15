<?php

namespace MBarlow\Megaphone\Tests\Setup;

use Illuminate\Foundation\Auth\User as BaseUser;
use Illuminate\Notifications\Notifiable;
use MBarlow\Megaphone\HasMegaphone;

class User extends BaseUser
{
    use Notifiable;
    use HasMegaphone;
}
