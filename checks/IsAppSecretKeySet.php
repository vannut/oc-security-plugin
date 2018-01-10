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
    //
}
