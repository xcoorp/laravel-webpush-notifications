<?php

namespace NotificationChannels\WebPush\Tests;

use NotificationChannels\WebPush\WebPushServiceProvider;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function getPackageProviders($app): array
    {
        return [
            WebPushServiceProvider::class,
        ];
    }
}
