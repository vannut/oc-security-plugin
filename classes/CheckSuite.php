<?php

namespace Vannut\Security\Classes;

/**
 * This Class holds everything logic related to running
 * the different checks on the OctoberCMS system.
 *
 * @author Richard <support@vannut.nl>
 */
class CheckSuite
{
    /**
     * What are the available checks?
     * TODO: see if possible to just read the /security/checks directory
     * instead of hardcoding the checks here.
     * @return array
     */
    public function availableChecks()
    {
        return [
            Vannut\Security\Checks\AppInDebugMode::class,
            Vannut\Security\Checks\IsAppSecretKeySet::class,
            Vannut\Security\Checks\UsingDefaultCredentials::class,
            Vannut\Security\Checks\UsingPublicFolder::class,
            Vannut\Security\Checks\ComposerWithoutDevDep::class,
        ];
    }
}
