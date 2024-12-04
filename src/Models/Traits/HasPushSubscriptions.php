<?php

namespace NotificationChannels\WebPush\Models\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use NotificationChannels\WebPush\Models\UserWebPushSubscription;

/**
 * @property Collection $pushSubscriptions
 *
 * @method hasMany(string $class)
 */
trait HasPushSubscriptions
{
    /**
     *  Get all subscriptions.
     */
    public function pushSubscriptions(): HasMany
    {
        return $this->hasMany(config('webpush-notifications.user_web_push_model'));
    }

    /**
     * Update (or create) subscription.
     */
    public function updatePushSubscription(string $endpoint, ?string $key = null, ?string $token = null, ?string $contentEncoding = null): UserWebPushSubscription
    {
        $model = config('webpush-notifications.user_web_push_model');
        $subscription = $model::findByEndpoint($endpoint);

        if ($subscription && $subscription->user->is($this)) {
            $subscription->public_key = $key;
            $subscription->auth_token = $token;
            $subscription->content_encoding = $contentEncoding;
            $subscription->save();

            return $subscription;
        }

        if ($subscription && ! $subscription->user->is($this)) {
            $subscription->delete();
        }

        return $this->pushSubscriptions()->create([
            'endpoint' => $endpoint,
            'public_key' => $key,
            'auth_token' => $token,
            'content_encoding' => $contentEncoding,
        ]);
    }

    /**
     * Delete subscription by endpoint.
     */
    public function deletePushSubscription(string $endpoint): void
    {
        $this->pushSubscriptions()
            ->where('endpoint', $endpoint)
            ->delete();
    }

    /**
     * Get all subscriptions.
     */
    public function routeNotificationForWebPush(): Collection
    {
        return $this->pushSubscriptions;
    }
}
