<?php

namespace Vannut\Security\Checks;

use Vannut\Security\Classes\CheckBase;
use Vannut\Security\Classes\CheckInterface;

/**
 * Did we change the Secret Key to something random?
 *
 * @author Richard <support@vannut.nl>
 */
class DoWeEncryptSessionData extends CheckBase implements CheckInterface
{
    public function doesItPass() :bool
    {
        $encrypt = config('session.encrypt');
        return $encrypt;
    }
    public function tags() : array
    {
        return ['config', 'session'];
    }
}
