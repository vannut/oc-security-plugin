<?php

namespace Vannut\Security\Controllers;

use BackendMenu;

class Dashboard extends \Backend\Classes\Controller {

    public function index()    // <=== Action method
    {
        $this->pageTitle = 'Security Dashboard';
        BackendMenu::setContext('Vannut.Security', 'security', 'dashboard');
    }
}