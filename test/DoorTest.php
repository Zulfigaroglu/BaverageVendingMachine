<?php

namespace Test;

use App\Enumerations\DoorStatus;
use App\Exceptions\CabinetShelfLimitExceededException;
use App\Exceptions\CanNotExistException;
use App\Exceptions\DoorClosedException;
use App\Exceptions\DoorOpenException;
use App\Exceptions\ShelfCanLimitExceededException;
use App\Models\Can;
use App\Models\Door;
use App\Models\Shelf;

class DoorTest extends BaseTest
{
    public function __construct()
    {
        $this->testOpenandCloseDoor();
        $this->testOpenTheOpenedDoor();
        $this->testCloseTheClosedDoor();
    }

    private function testOpenandCloseDoor(): void {
        $door = new Door();

        $this->assert($door->getStatus(), DoorStatus::Closed);

        $door->open();

        $this->assert($door->getStatus(), DoorStatus::Open);

        $door->close();

        $this->assert($door->getStatus(), DoorStatus::Closed);
    }

    private function testOpenTheOpenedDoor(): void {
        $door = new Door();
        $door->open();

        try{
            $door->open();
            $this->assert(false);
        } catch (DoorOpenException $exception) {
            $this->assert(true);
        }
    }

    private function testCloseTheClosedDoor(): void {
        $door = new Door();

        try{
            $door->close();
            $this->assert(false);
        } catch (DoorClosedException $exception) {
            $this->assert(true);
        }
    }
}