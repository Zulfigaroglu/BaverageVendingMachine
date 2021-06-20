<?php

namespace Test;

use App\Exceptions\CabinetShelfLimitExceededException;
use App\Exceptions\CanNotExistException;
use App\Exceptions\ShelfCanLimitExceededException;
use App\Models\Can;
use App\Models\Shelf;

class ShelfTest extends BaseTest
{
    public function __construct()
    {
        $this->testCanCount();
        $this->testAddCan();
        $this->testAddMoreCanThanLimit();
        $this->testGetCanWhenNoCanExists();
        $this->testRemoveCanWhenNoCanExists();
    }

    private function testCanCount(): void {
        $shelf = new Shelf();

        $this->assert($shelf->count(), 0);

        $shelf->push(new Can());
        $shelf->push(new Can());

        $this->assert($shelf->count(), 2);

    }

    private function testAddCan(): void {
        $shelf = new Shelf();

        $this->assert($shelf->all(), []);

        $can1 = new Can();

        $shelf->push($can1);

        $this->assert($shelf->all(), [$can1]);

    }

    private function testAddMoreCanThanLimit(): void {
        $shelf = new Shelf();

        try{
            for($counter = 0; $counter <=20; $counter++){
                $shelf->push(new Can());
            }
            $this->assert(false);
        } catch (ShelfCanLimitExceededException $exception) {
            $this->assert(true);
        }
    }

    public function testGetCanWhenNoCanExists(): void {
        $shelf = new Shelf();

        try{
            $shelf->get(1);
            $this->assert(false);
        } catch (CanNotExistException $exception) {
            $this->assert(true);
        }
    }

    public function testRemoveCanWhenNoCanExists(): void {
        $shelf = new Shelf();

        try{
            $shelf->pop();
            $this->assert(false);
        } catch (CanNotExistException $exception) {
            $this->assert(true);
        }
    }
}