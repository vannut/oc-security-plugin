<?php

namespace Vannut\Security\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Vannut\Security\Classes\CheckSuite;

class Checklist extends Controller {

    protected $checkSuite;

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Vannut.Security', 'security', 'checklist');
        $this->checkSuite = new CheckSuite;

        $this->addCss('/plugins/vannut/security/assets/checks.css');
        $this->addCss('/plugins/vannut/security/assets/alerts.css');
    }
    public function index()    // <=== Action method
    {
        $this->pageTitle = 'Security Checklist';
        $checks = $this->checkSuite->checksWithResult()
            ->groupBy(function ($item) {
                return collect($item->tags())->first();
            })
            ->sortby(function ($item, $key) {
                return $key;
            });

        // calculate passes + fails
        $this->vars['pass'] = $checks->flatten()
            ->reduce(function ($carry, $item) {
                return ($item->passes === true)
                    ? $carry + $item->severity
                    : $carry;
            });

        $this->vars['fails'] = $checks->flatten()
            ->reduce(function ($carry, $item) {
                return ($item->passes === false)
                    ? $carry + $item->severity
                    : $carry;
            });
        $this->vars['total'] = $this->vars['pass'] + $this->vars['fails'];
        $this->vars['ratio'] = round(($this->vars['pass'] /$this->vars['total']) *100) ;
        $this->vars['rating'] = $this->getRating();
        $this->vars['checks'] = $checks;
    }

    private function getRating()
    {
        $r = $this->vars['ratio'];
        if ($r < 30) {
            return 'We should work on this';
        } elseif ($r < 40) {
                return 'Keep going! You can do it!';
        } elseif ($r < 65) {
            return 'Thats the right direction!!';
        } elseif ($r < 80) {
            return 'We still need some work to do!';
        } elseif ($r < 95) {
            return 'Almost there!';
        } elseif ($r < 65) {
            return 'We still need some work to do!';
        }
        return 'SecOps Master';
    }


}