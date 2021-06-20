<?php

namespace App\Exceptions;

use Exception;

class CanNotExistException extends Exception
{
    protected $message = "Rafta içecek mevcut değil!";
}