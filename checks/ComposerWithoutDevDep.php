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
class ComposerWithoutDevDep extends CheckBase implements CheckInterface
{
    public function doesItPass() :bool
    {
        // check for the existence of the vendor/phpunit/phpunit, vendor/fzaninotto/faker
        $devFolders = collect([
            base_path('/vendor/phpunit/phpunit'),
            base_path('/vendor/fzaninotto/faker')
        ])
        ->transform(function ($item) {
            return is_dir($item);
        });

        if ($devFolders->contains(true)) {
            return false;
        };
        return true;
    }
    public function tags() : array
    {
        return ['fs'];
    }
}
