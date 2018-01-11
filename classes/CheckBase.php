<?php

namespace Vannut\Security\Classes;

/**
 * This BaseCheck class is the basis for all the
 * checks and contains helper methods which should be
 * available for all checks.
 *
 * @author Richard <support@vannut.nl>
 */
class CheckBase
{
    public $passes;
    public $severity;

    public function __construct()
    {
        $this->passes = $this->doesItPass();
    }
}
