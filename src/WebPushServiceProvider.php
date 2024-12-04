<?php

namespace NotificationChannels\WebPush;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;
use Minishlink\WebPush\WebPush;
use NotificationChannels\WebPush\Console\Commands\VapidKeysGenerateCommand;

class WebPushServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->commands([VapidKeysGenerateCommand::class]);

        $this->mergeConfigFrom(__DIR__.'/../config/webpush-notifications.php', 'webpush-notifications');
    }

    /**
     * Bootstrap the application services.
     *
     * @throws BindingResolutionException
     * @throws InvalidArgumentException
     */
    public function boot(): void
    {
        $this->app->when(WebPushChannel::class)
            ->needs(WebPush::class)
            ->give(function () {
                return (new WebPush($this->webPushAuth(), [], 30))->setReuseVAPIDHeaders(true);
            });

        $this->app->when(WebPushChannel::class)
            ->needs(ReportHandlerInterface::class)
            ->give(ReportHandler::class);

        if ($this->app->runningInConsole()) {
            $this->definePublishing();
        }
    }

    /**
     * Get the authentication details.
     *
     * @return array<string, mixed>
     *
     * @throws BindingResolutionException
     * @throws InvalidArgumentException
     */
    protected function webPushAuth(): array
    {
        $config = $this->app->make(Config::class)::get('webpush-notifications.vapid', []) ?? [];

        $publicKey = $config['public_key'] ?? null;
        $privateKey = $config['private_key'] ?? null;

        if ($publicKey === null || $privateKey === null) {
            throw new InvalidArgumentException('VAPID public and private keys must be set.');
        }

        $subject = $config['subject'] ?? $this->app->make(UrlGenerator::class)->to('/');

        $webPushConfig['VAPID'] = compact('publicKey', 'privateKey', 'subject');

        return $webPushConfig;
    }

    /**
     * Define the publishable migrations and resources.
     *
     * @throws BindingResolutionException
     */
    protected function definePublishing(): void
    {
        $this->publishes([
            __DIR__.'/../config/webpush-notifications.php' => $this->app->configPath('webpush-notifications.php'),
        ], ['webpush-notifications', 'webpush-notifications-config']);

        $this->publishes([
            __DIR__.'/../database/migrations/create_user_web_push_subscriptions_table.php.stub' => $this->getMigrationFileName(
                'create_user_web_push_subscriptions_table.php'
            ),
        ], ['webpush-notifications', 'webpush-notifications-migrations']);
    }

    /**
     * Returns existing migration file if found, else uses the current timestamp.
     *
     * @throws BindingResolutionException
     */
    protected function getMigrationFileName(string $migrationFileName): string
    {
        $timestamp = date('Y_m_d_His');

        $filesystem = $this->app->make(Filesystem::class);

        return Collection::make([$this->app->databasePath().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR])
            ->flatMap(fn ($path) => $filesystem->glob($path.'*_'.$migrationFileName))
            ->push($this->app->databasePath()."/migrations/{$timestamp}_{$migrationFileName}")
            ->first();
    }
}
