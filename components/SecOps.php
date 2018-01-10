<?php

namespace Vannut\Security\Components;

use Vannut\Security\Classes\Crawler;
use Vannut\Security\Classes\CheckSuite;

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
        // Crawler
        // $crawler = new Crawler;
        // // dd($crawler->createBaseline());
        // dd($crawler->compareFilesystem());

        // check
        $cs = new CheckSuite;

        // dd($cs->run('ComposerWithoutDevDep'));
        dd($cs->runAll());
    }


}
