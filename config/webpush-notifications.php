<?php

use App\Models\User;
use NotificationChannels\WebPush\Models\UserWebPushSubscription;

return [
    /*
    |--------------------------------------------------------------------------
    | VAPID Configuration
    |--------------------------------------------------------------------------
    |
    | These are the keys for authentication (VAPID).
    | These keys must be safely stored and should not change.
    */
    'vapid' => [
        'subject' => env('VAPID_SUBJECT'),
        'public_key' => env('VAPID_PUBLIC_KEY'),
        'private_key' => env('VAPID_PRIVATE_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | User Configuration
    |--------------------------------------------------------------------------
    |
    | This is the User model used by WebPushNotifications for the subscriptions.
    */
    'user_model' => User::class,
    'user_web_push_model' => UserWebPushSubscription::class,
];
