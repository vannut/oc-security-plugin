<?php

namespace Vannut\Security\Checks;

use Vannut\Security\Classes\CheckBase;
use Vannut\Security\Classes\CheckInterface;

/**
 * Did we change the Secret Key to something random?
 *
 * @author Richard <support@vannut.nl>
 */
class IsAppSecretKeySet extends CheckBase implements CheckInterface
{
    public function doesItPass() :bool
    {
        $secret = config('app.key');
        if ($secret === '' || $secret === 'CHANGE_ME!!!!!!!!!!!!!!!!!!!!!!!') {
            return false;
        }
        return true;
    }
    public function tags() : array
    {
        return ['config'];
    }
}
