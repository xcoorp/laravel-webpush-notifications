<p align="center">
<a href="LICENSE"><img alt="Software License" src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square"></a>
<a href="composer.json"><img alt="Laravel Version Requirements" src="https://img.shields.io/badge/laravel-~11.0-gray?logo=laravel&style=flat-square&labelColor=F05340&logoColor=white"></a>
</p>

<h1>WebPush - Laravel Notification Channel</h1>

This package makes it easy to send notifications using [Web Push API](https://developer.mozilla.org/en-US/docs/Web/API/Push_API)
````php
class InvoicePaidNotification extends Notification
{
    // Trigger a specific notification event
    public function toWebPush($notifiable)
    {
        return (new WebPushMessage)
                ->title('Approved!')
                ->body('Your account was approved!')
                ->action('View account', 'view_account')
                ->options(['TTL' => 1000]);
    }
}
````
## Contents

- [Installation](#installation)
    - [Publish Configuration and Migrations](#publishing-configuration-and-migrations)
    - [Configuration](#configuration)
- [Usage](#usage)
- [API Overview](#webpush-message)
    - [WebPush Message](#webpush-message)
- [Testing](#testing)
- [License](#license)


## Installation

The Web Push notification channel can be installed easily via Composer:

````bash
composer require xcoorp/laravel-webpush-notifications
````

### Publishing Configuration and Migrations

After installing the package, you can publish the configuration file and migrations by running the following command:

````bash
php artisan vendor:publish --provider="NotificationChannels\WebPush\WebPushServiceProvider"
````

After publishing the migrations you should migrate your database:

````bash
php artisan migrate
````

After publishing the configuration file, you should configure the `vapid` keys in your `.env` file:

````env
VAPID_PUBLIC_KEY=your-public-key
VAPID_PRIVATE_KEY=your-private-key
VAPID_SUBJECT=your-email or url
````

You can generate the vapid keys using the following command:

````bash
php artisan webpush-notifications:vapid
````

### Configuration

The `config/webpush-notifications.php` configuration file allows you to configure the default Web Push options for your application.

You can define custom Models to use, and the vapid keys to use for the Web Push API.

If you define a custom `UsereWebPushSubscription` model you need to make sure it extends the `UsereWebPushSubscription` model shipped with this package.

## Usage

In order to send a notification via the WebPush channel, you'll need to specify the channel in the `via()` method of your notification:

````php
use NotificationChannels\WebPush\WebPushChannel;

public function via($notifiable)
{
    return [
        WebPushChannel::class
    ]
}
````

## API Overview

### WebPush Message

Namespace: `NotificationChannels\WebPush\WebPushMessage`

The `WebPushMessage` class encompasses an entire message that will be sent to the Web Push API.

- `title(string $title)` Set the `title` of the message
- `action(string $title, string $action, ?string $icon = null))` Set the `action` of the message
- `badge(string $badge)` Set the url to the `badge` image of the message
- `body(string $body)` Set the `body` of the message
- `dir(string $dir)` Set the text-direction `dir` of the message
- `icon(string $icon)` Set the url to the `icon` of the message
- `image(string $image)` Set the url to the `image` of the message
- `lang(string $lang)` Set the Language `lang` of the message
- `renotify(bool $renotify)` specifies whether the user should be notified after a new notification replaces an old one
- `requireInteraction(bool $requireInteraction)` specifies whether the notification requires interaction
- `tag(string $value)` Set the `tag` of the message
- `vibrate(array $vibrate)` Set the vibration pattern `vibrate` of the message
- `data(mixed $value)` Set the `data` of the message
- `options(array $options)` Set the `options` of the message (See [here]( https://github.com/web-push-libs/web-push-php#notifications-and-default-options) for more information)
- `toArray()` Returns the data that will be sent to the WebPush API as an array

## Code of Conduct

In order to ensure that the community is welcoming to all, please review and abide by
the [Code of Conduct](CODE_OF_CONDUCT.md).

## Security Vulnerabilities

Please review the [security policy](SECURITY.md) on how to report security vulnerabilities.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
