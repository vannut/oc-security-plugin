<?php

namespace Vannut\Security\Classes;

use Carbon\Carbon;

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

    public function startedAt()
    {
        return $this->start;
    }

    public function startedAtCarbon()
    {
        return Carbon::createFromFormat('U', round($this->start));
    }

    public function diff()
    {
        return $this->end - $this->start;
    }
    public function diffMs()
    {
        $seconds = $this->end - $this->start;

        return round($seconds*100);
    }
}
