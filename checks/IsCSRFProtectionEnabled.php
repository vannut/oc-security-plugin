<?php

namespace Vannut\Security\Checks;

use Vannut\Security\Classes\CheckBase;
use Vannut\Security\Classes\CheckInterface;

/**
 * Is the App in debug mode?
 *
 * @author Richard <support@vannut.nl>
 */
class IsCSRFProtectionEnabled extends CheckBase implements CheckInterface
{
    public $title       = 'IsCSRFProtectionEnabled';
    public $description = "Short description about this check";
    public $fixMe       = "some url";
    public $moreInfo    = "/checks/IsCSRFProtectionEnabled";
    public $severity    = 4;

    public function doesItPass() : bool
    {
        return config('cms.enableCsrfProtection');
    }
    public function tags() : array
    {
        return ['config'];
    }
}
