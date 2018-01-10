<?php

namespace Vannut\Security\Classes;

class Timer
{
    private $start;
    private $end;

    public function __construct()
    {
        $this->start = microtime(true);
    }

    public function stop()
    {
        $this->end = microtime(true);
    }

    public function diff()
    {
        return $this->end - $this->start;
    }
}
