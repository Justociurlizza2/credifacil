<?php
namespace App\Exception;
class Exception implements \Throwable
{
    protected $message = 'Unknown exception';   // exception message
    private   $string;                          // __toString cache
    protected $code = 0;                        // user defined exception code
    protected $file;                            // source filename of exception
    protected $line;                            // source line of exception
    private   $trace;                           // backtrace
    private   $previous;                        // previous exception if nested exception

    public function __construct($message = '', $code = 0, \Throwable $previous = null)
    {
        $this->message = $message;
        $this->code = $code;
        $this->previous = $previous;
    }

    public function __clone(){}           // Inhibits cloning of exceptions.

    public  function getMessage(){ return 'no';}        // message of exception
    public  function getCode(){}           // code of exception
    public  function getFile(){}           // source filename
    public  function getLine(){}           // source line
    public  function getTrace(){}          // an array of the backtrace()
    public  function getPrevious(){}       // previous exception
    public  function getTraceAsString(){}  // formatted string of trace

    // Overrideable
    public function __toString(){}               // formatted string for display
}