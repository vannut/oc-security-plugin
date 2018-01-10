<?php

namespace Vannut\Security\Components;

use Vannut\Security\Classes\Crawler;

/**
 *
 *          This is just a temporary component to test things :)
 *
 */
class SecOps extends \Cms\Classes\ComponentBase
{

    public function componentDetails()
    {
        return [
            'name' => 'temp',
            'description' => 'just to test.'
        ];
    }

    public function onRun()
    {
        $crawler = new Crawler;
        // dd($crawler->createBaseline());
        dd($crawler->compareFilesystem());
    }


}
