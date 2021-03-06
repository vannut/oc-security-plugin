<?php

namespace Vannut\Security\Checks;

use Vannut\Security\Classes\CheckBase;
use Vannut\Security\Classes\CheckInterface;

/**
 * Do we have a .env file setup?
 *
 * @author Richard <support@vannut.nl>
 */
class AreWeUseingDotEnv extends CheckBase implements CheckInterface
{
    public $title       = 'AreWeUseingDotEnv';
    public $description = "Short description about this check";
    public $fixMe       = "some url";
    public $moreInfo    = "/checks/AreWeUseingDotEnv";
    public $severity    = 2;


    public function doesItPass() :bool
    {
        return is_file(base_path('.env'));
    }

    public function tags() : array
    {
        return ['config', 'fs'];
    }
}
