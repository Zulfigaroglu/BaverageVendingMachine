<?php

namespace App\Exceptions;

use Exception;

class ShelfNotExistException extends Exception
{
    protected $message = "Raf dolapta mevcut değil!";
}