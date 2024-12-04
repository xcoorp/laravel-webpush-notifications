<?php

namespace NotificationChannels\WebPush;

use ErrorException;
use Generator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Notification;
use Minishlink\WebPush\MessageSentReport;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;
use NotificationChannels\WebPush\Models\UserWebPushSubscription;

class WebPushChannel
{
    public function __construct(protected WebPush $webPush, protected ReportHandlerInterface $reportHandler) {}

    /**
     * Send the given notification.
     *
     * @throws ErrorException
     */
    public function send(mixed $notifiable, Notification $notification): void
    {
        /** @var Collection $subscriptions */
        $subscriptions = $notifiable->routeNotificationFor('WebPush', $notification);

        if ($subscriptions->isEmpty()) {
            return;
        }

        /** @var WebPushMessage $message */
        $message = $notification->toWebPush($notifiable, $notification);
        $payload = json_encode($message->toArray());
        $options = $message->getOptions();

        /** @var UserWebPushSubscription $subscription */
        foreach ($subscriptions as $subscription) {
            $this->webPush->queueNotification(
                new Subscription(
                    $subscription->endpoint,
                    $subscription->public_key,
                    $subscription->auth_token,
                    $subscription->content_encoding
                ),
                $payload,
                $options
            );
        }

        $reports = $this->webPush->flush();

        $this->handleReports($reports, $subscriptions, $message);
    }

    /**
     * Handle the reports.
     */
    protected function handleReports(Generator $reports, Collection $subscriptions, WebPushMessage $message): void
    {
        /** @var MessageSentReport $report */
        foreach ($reports as $report) {
            if ($report && $subscription = $this->findSubscription($subscriptions, $report)) {
                $this->reportHandler->handleReport($report, $subscription, $message);
            }
        }
    }

    protected function findSubscription(Collection $subscriptions, MessageSentReport $report): ?UserWebPushSubscription
    {
        foreach ($subscriptions as $subscription) {
            if ($subscription->endpoint === $report->getEndpoint()) {
                return $subscription;
            }
        }

        return null;
    }
}
