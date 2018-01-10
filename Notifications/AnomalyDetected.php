<?php

namespace Vannut\Security\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;

class AnomalyDetected extends Notification //implements ShouldQueue
{
    //use Queueable;
    public $changes;

    public function __construct(array $changes)
    {
        $this->changes = $changes;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->getOutletFor('AnomalyDetected');
    }


    public function toSlack($notifiable)
    {
        $changes = $this->changes;

        return (new SlackMessage)
            ->error()
            ->from('secOps', ':beryl:')
            ->content('['.$notifiable->accountName.'] We detected an anomoly')
            ->attachment(function ($attachment) use ($changes) {
                $attachment->fields([
                    'Files changed' => $changes['changed']->count(),
                    'New files' => $changes['newFiles']->count(),
                    'Deleted files' => $changes['deleted']->count(),
                    // 'No change' => $changes['noChange']->count(),
                    // 'elapsed time' => round($changes['elapsedTime'], 2)."s"
                ]);
            });
    }
}