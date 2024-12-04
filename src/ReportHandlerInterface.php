<?php

namespace NotificationChannels\WebPush;

use Minishlink\WebPush\MessageSentReport;
use NotificationChannels\WebPush\Models\UserWebPushSubscription;

interface ReportHandlerInterface
{
    /**
     * Handle a message sent report.
     */
    public function handleReport(MessageSentReport $report, UserWebPushSubscription $subscription, WebPushMessage $message): void;
}
