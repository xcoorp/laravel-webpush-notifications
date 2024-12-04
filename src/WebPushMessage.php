<?php

namespace NotificationChannels\WebPush;

use Illuminate\Support\Arr;

/**
 * @link https://developer.mozilla.org/en-US/docs/Web/API/ServiceWorkerRegistration/showNotification#Parameters
 */
class WebPushMessage
{
    public function __construct(
        protected ?string $title = null,
        protected ?array $actions = [],
        protected ?string $badge = null,
        protected ?string $body = null,
        protected ?string $dir = null,
        protected ?string $icon = null,
        protected ?string $image = null,
        protected ?string $lang = null,
        protected ?bool $renotify = null,
        protected ?bool $requireInteraction = null,
        protected ?string $tag = null,
        protected array $vibrate = [],
        protected mixed $data = null,
        protected array $options = [],
    ) {}

    /**
     * Set the notification title.
     */
    public function title(string $value): static
    {
        $this->title = $value;

        return $this;
    }

    /**
     * Add a notification action.
     */
    public function action(string $title, string $action, ?string $icon = null): static
    {
        $this->actions[] = array_filter(compact('title', 'action', 'icon'));

        return $this;
    }

    /**
     * Set the notification badge.
     */
    public function badge(string $value): static
    {
        $this->badge = $value;

        return $this;
    }

    /**
     * Set the notification body.
     */
    public function body(string $value): static
    {
        $this->body = $value;

        return $this;
    }

    /**
     * Set the notification direction.
     */
    public function dir(string $value): static
    {
        $this->dir = $value;

        return $this;
    }

    /**
     * Set the notification icon url.
     */
    public function icon(string $value): static
    {
        $this->icon = $value;

        return $this;
    }

    /**
     * Set the notification image url.
     */
    public function image(string $value): static
    {
        $this->image = $value;

        return $this;
    }

    /**
     * Set the notification language.
     */
    public function lang(string $value): static
    {
        $this->lang = $value;

        return $this;
    }

    /**
     * Set the notification renotify flag.
     */
    public function renotify(bool $value = true): static
    {
        $this->renotify = $value;

        return $this;
    }

    /**
     * Set the notification require interaction flag.
     */
    public function requireInteraction(bool $value = true): static
    {
        $this->requireInteraction = $value;

        return $this;
    }

    /**
     * Set the notification tag.
     */
    public function tag(string $value): static
    {
        $this->tag = $value;

        return $this;
    }

    /**
     * Set the notification vibration pattern.
     */
    public function vibrate(array $value): static
    {
        $this->vibrate = $value;

        return $this;
    }

    /**
     * Set the notification arbitrary data.
     */
    public function data(mixed $value): static
    {
        $this->data = $value;

        return $this;
    }

    /**
     * Set the notification options.
     *
     * @link https://github.com/web-push-libs/web-push-php#notifications-and-default-options
     */
    public function options(array $value): static
    {
        $this->options = $value;

        return $this;
    }

    /**
     * Get the notification options.
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Get an array representation of the message.
     */
    public function toArray(): array
    {
        return Arr::except(array_filter(get_object_vars($this)), ['options']);
    }
}
