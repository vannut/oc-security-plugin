<?php

namespace Vannut\Security\Classes;

use Vannut\Security\Exceptions\CheckDoesNotExistException;
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
        return collect([
            \Vannut\Security\Checks\AppInProductionMode::class,
            \Vannut\Security\Checks\IsAppSecretKeySet::class,
            \Vannut\Security\Checks\NotUsingDefaultAdminCredentials::class,
            \Vannut\Security\Checks\UsingPublicFolder::class,
            \Vannut\Security\Checks\ComposerWithoutDevDep::class,
            \Vannut\Security\Checks\IsTheInstallerDeleted::class,
            \Vannut\Security\Checks\IsCSRFProtectionEnabled::class,
            \Vannut\Security\Checks\AreWeUseingDotEnv::class,
            \Vannut\Security\Checks\DoWeEncryptSessionData::class,
            \Vannut\Security\Checks\DefaultCookieName::class,
            \Vannut\Security\Checks\HttpsOnlyCookies::class,
        ]);
    }

    public function run($check)
    {
        $classname = '\\Vannut\\Security\\Checks\\'.$check;
        if (!class_exists($classname)) {
            throw new CheckDoesNotExistException("We cannot find the check named {$check}", 404);
        }

        $check = new $classname;
        return $check->run();
    }

    public function runAll()
    {
        $result = $this->availableChecks()
        ->transform(function ($item) {
            $check = new $item;
            return [
                'identifier' => (new \ReflectionClass($check))->getShortName(),
                'result' => $check->doesItPass()
            ];
        })
        ->keyBy('identifier')
        ->transform(function ($item) {
            return $item['result'];
        });
        return $result->toArray();
    }

    public function checksWithResult()
    {
        $checks = $this->availableChecks()
        ->transform(function ($item) {
            return new $item;
        });

        return $checks;
    }


    //
}
