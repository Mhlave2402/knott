<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Couple private channel for vendor match notifications
Broadcast::channel('couple.{coupleId}', function ($user, $coupleId) {
    return $user->couple && $user->couple->id == $coupleId;
});

// Vendor private channel for quote request notifications
Broadcast::channel('vendor.{vendorId}', function ($user, $vendorId) {
    return $user->vendor && $user->vendor->id == $vendorId;
});
