<?php

namespace Vannut\Security\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;

class BaselineCreated extends Notification //implements ShouldQueue
{
    //use Queueable;
    public $nofFiles;
    public $elapsedTime;

    public function __construct(int $nofFiles, float $elapsedTime)
    {
        $this->nofFiles = $nofFiles;
        $this->elapsedTime = $elapsedTime;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->getOutletFor('BaselineCreated');
    }


    public function toSlack($notifiable)
    {
        $files = $this->nofFiles;
        $elapsedTime = $this->elapsedTime;

        return (new SlackMessage)
            ->success()
            ->from('secOps', ':beryl:')
            ->content('['.$notifiable->accountName.'] Baseline created')
            ->attachment(function ($attachment) use ($files, $elapsedTime) {
                $attachment->fields([
                    'Number of Files added' => $files,
                    'Elapsed time' => round($elapsedTime, 2)."s"
                ]);
            });
    }
}
