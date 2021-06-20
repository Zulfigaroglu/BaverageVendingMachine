<?php

namespace App;

use App\Enumerations\Actions;
use App\Enumerations\DoorStatus;
use App\Exceptions\CabinetShelfLimitExceededException;
use App\Exceptions\DoorClosedException;
use App\Exceptions\DoorOpenException;
use App\Exceptions\OperationNotExistsException;
use App\Exceptions\ShelfCanLimitExceededException;
use App\Exceptions\ShelfNotExistException;
use App\Models\Cabinet;
use App\Models\Can;
use App\Models\Shelf;
use Exception;

/**
 * Class Program
 * @package App
 */
class Program
{
    /**
     * @var Cabinet
     */
    protected Cabinet $cabinet;


    /**
     * Program constructor.
     */
    public function __construct()
    {
        $this->cabinet = new Cabinet();
    }

    public function run(): void{
        while (true) {
            try {
                echo "\n";
                $this->printStatus();
                echo "\n";
                $action = $this->chooseAction();
                echo "\n";

                if ($action < 0 || $action > count(Actions::$list)) {
                    throw new OperationNotExistsException();
                }
                $this->doAction($action);
            } catch (Exception $exception) {
                echo "\e[97m\e[41mHata: ".$exception->getMessage()."\e[0m\e[39m\n";
            }
        }
    }

    /**
     * @return int
     */
    function chooseAction(): int {
        echo "Lütfen yapmak istediğiniz işlemi seçiniz\n";
        foreach(Actions::$list as $actionIndex => $action) {
            echo ($actionIndex + 1).". ".$action."\n";
        }
        echo "Seçim: ";
        return intval(fgets(STDIN));
    }

    /**
     * @return Shelf
     * @throws Exceptions\ShelfNotExistException
     */
    public function chooseShelf(): Shelf
    {
        echo "İşlemi yapmak istediğiniz rafı seçiniz\n";
        foreach($this->cabinet->all() as $shelfIndex => $shelf) {
            echo ($shelfIndex + 1).". Raf\n";
        }
        echo "Seçim: ";
        $choosenIndex = intval(fgets(STDIN)) - 1;
        return $this->cabinet->get($choosenIndex);
    }

    /**
     * @param $action
     * @throws CabinetShelfLimitExceededException
     * @throws DoorClosedException
     * @throws Exceptions\CanNotExistException
     * @throws ShelfNotExistException
     */
    function doAction($action): void {
        switch ($action){
            case Actions::OpenDoor: {
                $this->cabinet->door->open();
                break;
            }
            case Actions::CloseDoor: {
                $this->cabinet->door->close();
                break;
            }
            case Actions::PushShelf: {
                $this->pushShelf();
                break;
            }
            case Actions::PopShelf: {
                $this->popShelf();
                break;
            }
            case Actions::PushCan: {
                $this->pushCan();
                break;
            }
            case Actions::PopCan: {
                $this->popCan();
                break;
            }
        }
    }

    /**
     * @throws Exceptions\ShelfNotExistException
     */
    function printStatus(): void {
        echo "Dolap Durumu: " . $this->cabinet->getStatus() . "\n";
        echo "Kapak: " . $this->cabinet->door->getStatus() . "\n";
        for ($shelfCounter = 0; $shelfCounter < $this->cabinet->count() ; $shelfCounter++) {
            $shelf = $this->cabinet->get($shelfCounter);
            $shelfUsage = " (".$shelf->count() . "/" . Shelf::CAN_LIMIT . ")";
            echo "Raf " . ($shelfCounter + 1) . ": ". $shelfUsage . "\n";
        }
    }

    /**
     * @throws DoorClosedException
     * @throws CabinetShelfLimitExceededException
     */
    function pushShelf(): void {
        if($this->cabinet->door->getStatus() == DoorStatus::Closed){
            throw new DoorClosedException();
        }

        $this->cabinet->push(new Shelf());
    }

    /**
     * @throws DoorClosedException
     * @throws Exceptions\ShelfNotExistException
     */
    function popShelf(): void {
        if($this->cabinet->door->getStatus() == DoorStatus::Closed){
            throw new DoorClosedException();
        }

        $this->cabinet->pop();
    }

    /**
     * @throws DoorClosedException
     * @throws ShelfCanLimitExceededException
     * @throws ShelfNotExistException
     */
    function pushCan(): void {
        $shelf = $this->chooseShelf();
        if($this->cabinet->door->getStatus() == DoorStatus::Closed){
            throw new DoorClosedException();
        }

        $shelf->push(new Can());
    }


    /**
     * @throws DoorOpenException
     * @throws Exceptions\CanNotExistException
     * @throws ShelfNotExistException
     */
    function popCan(): void {
        if($this->cabinet->door->getStatus() == DoorStatus::Open){
            throw new DoorOpenException();
        }

        $this->cabinet->getFullestShelf()->pop();
    }
}