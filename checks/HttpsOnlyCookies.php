<?php

namespace Vannut\Security\Checks;

use Vannut\Security\Classes\CheckBase;
use Vannut\Security\Classes\CheckInterface;

/**
 * Is the App in debug mode?
 *
 * @author Richard <support@vannut.nl>
 */
class HttpsOnlyCookies extends CheckBase implements CheckInterface
{
    public $title       = 'HttpsOnlyCookies';
    public $description = "Short description about this check";
    public $fixMe       = "some url";
    public $moreInfo    = "/checks/HttpsOnlyCookies";
    public $severity    = 2;

    public function doesItPass() : bool
    {
        return config('session.secure');
    }
    public function tags() : array
    {
        return ['config', 'session'];
    }
}
