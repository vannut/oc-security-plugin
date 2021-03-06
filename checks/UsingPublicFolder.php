<?php

namespace Vannut\Security\Checks;

use Vannut\Security\Classes\CheckBase;
use Vannut\Security\Classes\CheckInterface;

/**
 * Did we setup public-folder mirroring?
 * As we don't have means to check whether the webserver is
 * redirecting to the new public folder; we just resort to looking
 * for the existence of the default './public/' directory.
 *
 * @author Richard <support@vannut.nl>
 */
class UsingPublicFolder extends CheckBase implements CheckInterface
{
    public $title       = 'UsingPublicFolder';
    public $description = "Short description about this check";
    public $fixMe       = "some url";
    public $moreInfo    = "/checks/UsingPublicFolder";
    public $severity    = 5;

    public function doesItPass() :bool
    {
        $publicFolder = base_path('public');
        return is_dir($publicFolder);
    }

    public function tags() : array
    {
        return ['fs'];
    }
}
