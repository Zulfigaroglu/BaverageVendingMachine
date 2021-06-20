<?php

namespace App\Exceptions;

use Exception;

class OperationNotExistsException extends Exception
{
    protected $message = "Böyle bir işlem mevcut değil!";
}