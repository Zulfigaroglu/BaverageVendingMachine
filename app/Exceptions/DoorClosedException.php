<?php

namespace App\Exceptions;

use Exception;

class DoorClosedException extends Exception
{
    protected $message = "Dolap kapısı kapalı!";
}