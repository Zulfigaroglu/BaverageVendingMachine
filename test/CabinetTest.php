<?php


namespace Test;


use App\Enumerations\CabinetStatus;
use App\Exceptions\CabinetShelfLimitExceededException;
use App\Exceptions\ShelfNotExistException;
use App\Models\Cabinet;
use App\Models\Can;
use App\Models\Shelf;

class CabinetTest extends BaseTest
{
    public function __construct()
    {
        $this->testShelfCount();
        $this->testAddShelf();
        $this->testAddMoreShelfThanLimit();
        $this->testGetShelfWhenNoShelfExists();
        $this->testRemoveShelfWhenNoShelfExists();
        $this->testGetFullestShelf();
        $this->testGetCabinetStatus();
    }

    /**
     * @throws CabinetShelfLimitExceededException
     */
    private function testShelfCount(): void {
        $cabinet = new Cabinet();

        $this->assert($cabinet->count(), 0);

        $cabinet->push(new Shelf());
        $cabinet->push(new Shelf());

        $this->assert($cabinet->count(), 2);

    }

    /**
     * @throws CabinetShelfLimitExceededException
     */
    private function testAddShelf(): void {
        $cabinet = new Cabinet();

        $this->assert($cabinet->all(), []);

        $shelf1 = new Shelf();

        $cabinet->push($shelf1);

        $this->assert($cabinet->all(), [$shelf1]);
    }

    private function testAddMoreShelfThanLimit(): void {
        $cabinet = new Cabinet();

        try{
            $cabinet->push(new Shelf());
            $cabinet->push(new Shelf());
            $cabinet->push(new Shelf());
            $cabinet->push(new Shelf());
            $this->assert(false);
        } catch (CabinetShelfLimitExceededException $exception) {
            $this->assert(true);
        }
    }

    private function testGetShelfWhenNoShelfExists(): void {
        $cabinet = new Cabinet();

        try{
            $cabinet->get(1);
            $this->assert(false);
        } catch (ShelfNotExistException $exception) {
            $this->assert(true);
        }
    }

    private function testRemoveShelfWhenNoShelfExists(): void {
        $cabinet = new Cabinet();

        try{
            $cabinet->pop();
            $this->assert(false);
        } catch (ShelfNotExistException $exception) {
            $this->assert(true);
        }
    }

    /**
     * @throws CabinetShelfLimitExceededException
     * @throws ShelfNotExistException
     * @throws \App\Exceptions\CanNotExistException
     * @throws \App\Exceptions\ShelfCanLimitExceededException
     */
    private function testGetFullestShelf(): void {
        $cabinet = new Cabinet();

        $shelf1 = new Shelf();
        $shelf2 = new Shelf();
        $shelf3 = new Shelf();

        for($counter = 0; $counter < 15; $counter++){
            $shelf3->push(new Can());
            if($counter % 2 == 0){
                $shelf1->push(new Can());
            }
            if($counter % 3 == 0){
                $shelf2->push(new Can());
            }
        }

        $cabinet->push($shelf1);
        $cabinet->push($shelf2);
        $cabinet->push($shelf3);

        $this->assert($cabinet->getFullestShelf(), $shelf3);
    }

    /**
     * @throws CabinetShelfLimitExceededException
     * @throws \App\Exceptions\ShelfCanLimitExceededException
     */
    private function testGetCabinetStatus(): void {
        $cabinet = new Cabinet();

        $shelf1 = new Shelf();
        $cabinet->push($shelf1);

        $this->assert($cabinet->getStatus(), CabinetStatus::Empty);

        for($counter = 0; $counter < 10; $counter++){
            $shelf1->push(new Can());
        }

        $this->assert($cabinet->getStatus(), CabinetStatus::Half);

        for($counter = 0; $counter < 10; $counter++){
            $shelf1->push(new Can());
        }

        $this->assert($cabinet->getStatus(), CabinetStatus::Full);
    }
}