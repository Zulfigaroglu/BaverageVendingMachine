<?php

namespace App\Exceptions;

use Exception;

class  ShelfCanLimitExceededException extends Exception
{
    protected $message = "Rafa fazla içecek eklenemez!";
}