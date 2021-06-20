<?php

namespace App\Exceptions;

use Exception;

class DoorOpenException extends Exception
{
    protected $message = "Dolap kapısı açık!";
}