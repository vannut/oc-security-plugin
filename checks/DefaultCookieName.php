<?php

namespace Vannut\Security\Checks;

use Vannut\Security\Classes\CheckBase;
use Vannut\Security\Classes\CheckInterface;

/**
 * Is the App in debug mode?
 *
 * @author Richard <support@vannut.nl>
 */
class DefaultCookieName extends CheckBase implements CheckInterface
{
    public $title       = 'DefaultCookieName';
    public $description = "Short description about this check";
    public $fixMe       = "some url";
    public $moreInfo    = "/checks/DefaultCookieName";
    public $severity    = 3;

    public function doesItPass() : bool
    {
        $cookieName = config('session.cookie');
        if ($cookieName === 'october_session') {
            return false;
        }
        return true;
    }

    public function tags() : array
    {
        return ['config', 'session'];
    }
}
