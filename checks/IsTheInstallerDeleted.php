<?php

namespace Vannut\Security\Checks;

use Vannut\Security\Classes\CheckBase;
use Vannut\Security\Classes\CheckInterface;

/**
 * Check whether composer was installed w/ or wo/
 * dev dependencies...
 *
 * @author Richard <support@vannut.nl>
 */
class IsTheInstallerDeleted extends CheckBase implements CheckInterface
{
    public $title       = 'IsTheInstallerDeleted';
    public $description = "Short description about this check";
    public $fixMe       = "some url";
    public $moreInfo    = "/checks/IsTheInstallerDeleted";
    public $severity    = 4 ;

    public function doesItPass() :bool
    {
        // check for the existence of 'install_files'
        if (is_dir(base_path('install_files')) || is_file(base_path('install.php'))) {
            return false;
        }
        return true;
    }
    public function tags() : array
    {
        return ['fs'];
    }
}
