<?php

namespace Vannut\Security\Classes;

use Illuminate\Notifications\Notifiable;

/**
 * Handling all the notifications of this plugin.
 *
 * @author Richard <support@vannut.nl>
 * @todo vars to settings object to be controlled in backend.
 */
class Notifier
{
    use Notifiable;

    public function __construct()
    {
        $this->slackHook = ENV('TEMP_SLACK_HOOK');
        $this->accountName = 'account1';
    }


    /**
     * Where should we sent the different events to?
     *
     * @param string $event
     * @return array
     */
    public function getOutletFor($event)
    {
        switch ($event) {
            case 'AnomalyDetected':
                return ['slack'];
                break;
            case 'BaselineCreated':
                return ['slack'];
                break;

            default:
                return ['slack'];
                break;
        }
    }


    public function routeNotificationForSlack()
    {
        return $this->slackHook;
    }
}