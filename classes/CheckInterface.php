<?php

namespace Vannut\Security\Classes;

interface CheckInterface
{
    /**
     * This is the function to run the check; it spits out the result.
     *
     * @return bool
     */
    public function doesItPass() : bool;


    /**
     * which group does this check belong to?
     *
     * @return array
     */
    public function tags() :array;

}
