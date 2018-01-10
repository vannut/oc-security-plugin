<?php

namespace Vannut\Security\Exceptions;

use Exception;

class BaseException extends Exception
{
    protected $message = 'Unknown exception';     // Exception message
    private $string;                            // Unknown
    protected $code = 0;                       // User-defined exception code
    protected $file;                              // Source filename of exception
    protected $line;                              // Source line of exception
    private $trace;                             // Unknown



    public function __toString()
    {
        return get_class($this) . " '{$this->message}' in {$this->file}({$this->line})\n"
                                . "{$this->getTraceAsString()}";
    }
}