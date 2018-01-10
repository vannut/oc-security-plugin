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

    public function doesItPass() : bool
    {
        return config('cms.enableCsrfProtection');
    }
}
