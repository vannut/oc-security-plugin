<?php

namespace Vannut\Security\Checks;

interface CheckInterface
{
    /**
     * This is the function to run the check; it spits out the result.
     *
     * @return bool
     */
    public function run();

    /**
     * which group does this check belong to?
     *
     * @return string
     */
    public function group();

    /**
     * Provide details about this check
     * Shoudl contain: 'description', 'more_info_link'
     *
     * @return array
     */
    public function checkDetails();


}
