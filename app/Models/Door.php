<?php

namespace App\Models;

use App\Enumerations\DoorStatus;
use App\Exceptions\DoorClosedException;
use App\Exceptions\DoorOpenException;

class Door
{
    /**
     * @var string
     */
    protected string $status = DoorStatus::Closed;

    /**
     * @throws DoorOpenException
     */
    public function open(): void
    {
        if($this->status === DoorStatus::Open){
            throw new DoorOpenException();
        }

        $this->status = DoorStatus::Open;
    }

    /**
     * @throws DoorClosedException
     */
    public function close(): void
    {
        if($this->status === DoorStatus::Closed){
            throw new DoorClosedException();
        }

        $this->status = DoorStatus::Closed;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}