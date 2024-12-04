<?php

namespace NotificationChannels\WebPush\Events;

use Illuminate\Queue\SerializesModels;
use Minishlink\WebPush\MessageSentReport;
use NotificationChannels\WebPush\Models\UserWebPushSubscription;
use NotificationChannels\WebPush\WebPushMessage;

class NotificationSent
{
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public MessageSentReport $report,
        public UserWebPushSubscription $subscription,
        public WebPushMessage $message
    ) {}
}
