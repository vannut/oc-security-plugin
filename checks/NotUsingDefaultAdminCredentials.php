<?php

namespace Vannut\Security\Checks;

use Vannut\Security\Classes\CheckBase;
use Vannut\Security\Classes\CheckInterface;
use Backend\Models\User;

/**
 * Is this OctoberCMS instance using the default admin:admin
 * credentials?
 *
 * @author Richard <support@vannut.nl>
 */
class NotUsingDefaultAdminCredentials extends CheckBase implements CheckInterface
{
    public $title       = 'NotUsingDefaultAdminCredentials';
    public $description = "Short description about this check";
    public $fixMe       = "some url";
    public $moreInfo    = "/checks/NotUsingDefaultAdminCredentials";
    public $severity    = 5;

    private $defaultPassword    = 'admin';
    private $defaultLogin       = 'admin';

    public function doesItPass() :bool
    {
        $user = User::where('login', $this->defaultLogin)->first();

        // there isn't a user named 'admin'
        if (!$user) {
            return true;
        }

        // is the password admin?
        if ($user->checkHashValue('password', $this->defaultPassword) === true) {
            return false;
        }
        return true;
    }
    public function tags() : array
    {
        return ['credentials'];
    }
}
