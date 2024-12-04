<?php

namespace NotificationChannels\WebPush;

use Illuminate\Contracts\Events\Dispatcher;
use Minishlink\WebPush\MessageSentReport;
use NotificationChannels\WebPush\Events\NotificationFailed;
use NotificationChannels\WebPush\Events\NotificationSent;
use NotificationChannels\WebPush\Models\UserWebPushSubscription;

class ReportHandler implements ReportHandlerInterface
{
    /**
     * Create a new report handler.
     */
    public function __construct(
        protected Dispatcher $events
    ) {}

    /**
     * Handle a message sent report.
     */
    public function handleReport(
        MessageSentReport $report,
        UserWebPushSubscription $subscription,
        WebPushMessage $message
    ): void {
        if ($report->isSuccess()) {
            $this->events->dispatch(new NotificationSent($report, $subscription, $message));

            return;
        }

        if ($report->isSubscriptionExpired()) {
            $subscription->delete();
        }

        $this->events->dispatch(new NotificationFailed($report, $subscription, $message));
    }
}
