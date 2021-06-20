<?php

namespace App\Exceptions;

use Exception;

class  CabinetShelfLimitExceededException extends Exception
{
    protected $message = "Dolaba daha fazla raf eklenemez!";
}