<?php

namespace Vannut\Security\Checks;

use Vannut\Security\Classes\CheckBase;
use Vannut\Security\Classes\CheckInterface;

/**
 * Is the App in debug mode?
 *
 * @author Richard <support@vannut.nl>
 */
class AppInProductionMode extends CheckBase implements CheckInterface
{

    public $title       = "AppInProductionMode";
    public $description = "Short description about this check";
    public $fixMe       = "some url";
    public $moreInfo    = "/checks/AppInProductionMode";
    public $severity    = 5;

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
