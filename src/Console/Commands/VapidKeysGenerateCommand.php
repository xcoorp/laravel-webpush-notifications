<?php

namespace NotificationChannels\WebPush\Console\Commands;

use ErrorException;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Support\Str;
use Minishlink\WebPush\VAPID;
use Symfony\Component\Console\Command\Command as CommandAlias;

class VapidKeysGenerateCommand extends Command
{
    use ConfirmableTrait;

    /**
     * @var string
     */
    protected $signature = 'webpush-notifications:vapid
                        {--show : Display the keys instead of modifying files}
                        {--force : Force the operation to run when in production}';

    /**
     * @var string
     */
    protected $description = 'Generate VAPID keys.';

    /**
     * Execute the console command.
     *
     * @throws ErrorException
     */
    public function handle(): int
    {
        $keys = VAPID::createVapidKeys();

        if ($this->option('show')) {
            $this->line('<comment>VAPID_PUBLIC_KEY='.$keys['publicKey'].'</comment>');
            $this->line('<comment>VAPID_PRIVATE_KEY='.$keys['privateKey'].'</comment>');

            return CommandAlias::SUCCESS;
        }

        if (! $this->setKeysInEnvironmentFile($keys)) {
            return CommandAlias::SUCCESS;
        }

        $this->info('VAPID keys set successfully.');

        return CommandAlias::SUCCESS;
    }

    /**
     * Set the keys in the environment file.
     */
    protected function setKeysInEnvironmentFile(array $keys): bool
    {
        $currentKeys = $this->laravel['config']['webpush-notifications.vapid'];

        if (strlen($currentKeys['public_key']) !== 0 && (! $this->confirmToProceed())) {
            return false;
        }

        $this->writeNewEnvironmentFileWith($keys);

        return true;
    }

    /**
     * Write a new environment file with the given keys.
     */
    protected function writeNewEnvironmentFileWith(array $keys): void
    {
        $contents = file_get_contents($this->laravel->environmentFilePath());

        if (! Str::contains($contents, 'VAPID_PUBLIC_KEY')) {
            $contents .= PHP_EOL.'VAPID_PUBLIC_KEY=';
        }

        if (! Str::contains($contents, 'VAPID_PRIVATE_KEY')) {
            $contents .= PHP_EOL.'VAPID_PRIVATE_KEY=';
        }

        $contents = preg_replace(
            [
                $this->keyReplacementPattern('VAPID_PUBLIC_KEY'),
                $this->keyReplacementPattern('VAPID_PRIVATE_KEY'),
            ],
            [
                'VAPID_PUBLIC_KEY='.$keys['publicKey'],
                'VAPID_PRIVATE_KEY='.$keys['privateKey'],
            ],
            $contents
        );

        file_put_contents($this->laravel->environmentFilePath(), $contents);
    }

    /**
     * Get a regex pattern that will match env $keyName with any key.
     */
    protected function keyReplacementPattern(string $keyName): string
    {
        $key = $this->laravel['config']['webpush-notifications.vapid'];

        if ($keyName === 'VAPID_PUBLIC_KEY') {
            $key = $key['public_key'];
        } else {
            $key = $key['private_key'];
        }

        $escaped = preg_quote('='.$key, '/');

        return "/^{$keyName}{$escaped}/m";
    }
}
