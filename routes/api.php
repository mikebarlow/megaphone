<?php
use Illuminate\Support\Facades\Route;

// Polling only for the current logged in user
Route::get(config('megaphone.pollRouteUrl'), [config('megaphone.pollAction'),'__invoke'])->name('megaphone.poll')->middleware('web');

// TODO: Add a route to allow polling for any model that has the HasMegaphone trait without introducing a security risk.
// e.g /megaphone/poll/{model}/{id} ... or something like that
// would be likely for debugging purposes only
