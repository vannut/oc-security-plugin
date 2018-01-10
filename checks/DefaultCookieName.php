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

    public function doesItPass() : bool
    {
        $cookieName = config('session.cookie');
        if ($cookieName === 'october_session') {
            return false;
        }
        return true;
    }
}
