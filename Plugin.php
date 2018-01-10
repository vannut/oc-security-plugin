<?php

namespace Vannut\Security;

use Carbon\Carbon;
use Backend;

class Plugin extends \System\Classes\PluginBase
{

    public function pluginDetails()
    {
        return [
            'name' => 'vannut.security::lang.meta.name',
            'description' =>'vannut.security::lang.meta.description',
            'author' => 'Richard @ Van Nut',
            'icon' => 'icon-shield'
        ];
    }

    public function registerNavigation()
    {
        return [
            'secops' => [
                'label'       => 'vannut.security::lang.backend.menu.main_item',
                'url'         => Backend::url('vannut/security'),
                'icon'        => 'icon-schield',
                'permissions' => ['vannut.security.*'],
                'order'       => 500,
                'sideMenu' => [
                    'filechanges' => [
                        'label'       => 'vannut.booot::lang.backend.menu.filechanges',
                        'icon'        => 'icon-document',
                        'url'         => Backend::url('vannut/security/filechanges'),
                        'permissions' => ['vannut.security.manage']
                    ],
                    'headers' => [
                        'label'       => 'vannut.booot::lang.backend.menu.headers',
                        'icon'        => 'icon-header',
                        'url'         => Backend::url('vannut/security/headers'),
                        'permissions' => ['vannut.security.manage']
                    ],


                ]
            ]
        ];
    }

    public function registerComponents()
    {
        return [
            'Vannut\Security\Components\SecOps' => 'secOps',
        ];
    }



    public function registerPermissions()
    {
        return [
            'vannut.security.manage' => [
                'label' => 'vannut.security::lang.permissions.manage',
                'tab' => 'Security'
            ]
        ];
    }

    public function boot()
    {
        \Cms\Classes\CmsController::extend(function ($controller) {
            $controller->middleware(\Vannut\Security\Middleware\InjectSecurityHeadersMiddleware::class);
        });
    }


}
