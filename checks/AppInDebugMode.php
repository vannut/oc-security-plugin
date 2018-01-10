<?php

namespace Vannut\Security\Checks;

use Vannut\Security\Classes\CheckBase;
use Vannut\Security\Classes\CheckInterface;

/**
 * Is the App in debug mode?
 *
 * @author Richard <support@vannut.nl>
 */
class AppInDebugMode extends CheckBase implements CheckInterface
{

    public function doesItPass() : bool
    {
        $debugMode = config('app.debug');
        if ($debugMode === false) {
            return true;
        }
        return false;
    }

    public function tags() : array
    {
        return ['config'];
    }
}
