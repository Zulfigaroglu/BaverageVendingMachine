<?php

namespace App\Models;

use App\Enumerations\CabinetStatus;
use App\Enumerations\DoorStatus;
use App\Exceptions\CabinetShelfLimitExceededException;
use App\Exceptions\CanNotExistException;
use App\Exceptions\DoorClosedException;
use App\Exceptions\ShelfNotExistException;
use App\Interfaces\IStackable;

/**
 * Class Cabinet
 * @package App\Models
 * @implements IStackable<Shelf>
 */
class Cabinet extends BaseModel implements IStackable
{

    const SHELF_LIMIT = 3;

    /**
     * @var Shelf[]
     */
    private array $shelves;

    /**
     * @var Door $door
     */
    public Door $door;

    /**
     * Cabinet constructor.
     */
    public function __construct()
    {
        $this->shelves = [];
        $this->door = new Door();
    }

    /**
     * @return Shelf[]
     */
    public function all(): array
    {
        return $this->shelves;
    }

    /**
     * @param int $index
     * @return Shelf
     * @throws ShelfNotExistException
     */
    public function get(int $index): Shelf
    {
        if(!array_key_exists($index, $this->shelves)){
            throw new ShelfNotExistException();
        }

        return $this->shelves[$index];
    }

    /**
     * @param Shelf $item
     * @throws CabinetShelfLimitExceededException
     */
    public function push($item): void
    {
        if($this->count() >= static::SHELF_LIMIT) {
            throw new CabinetShelfLimitExceededException();
        }

        $this->shelves[] = $item;
    }

    /**
     * @return Shelf
     * @throws ShelfNotExistException
     */
    public function pop(): Shelf
    {
        if($this->count() === 0){
            throw new ShelfNotExistException();
        }

        return array_pop($this->shelves);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->shelves);
    }

    /**
     * @return Shelf
     * @throws CanNotExistException
     * @throws ShelfNotExistException
     */
    public function getFullestShelf(): Shelf
    {
        if($this->count() === 0){
            throw new ShelfNotExistException();
        } else {
            $isEmpty = true;
            foreach ($this->shelves as $shelf){
                $isEmpty &= $shelf->count() === 0;
            }

            if($isEmpty){
                throw new CanNotExistException();
            }
        }

        $fullestShell = null;
        $maxCount = 0;
        foreach ($this->shelves as $shelf){
            if($shelf->count() > $maxCount){
                $maxCount = $shelf->count();
                $fullestShell = $shelf;
            }
        }

        return $fullestShell;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        $totalCanCount = array_reduce($this->shelves, fn($acc, $item) => $acc += $item->count());
        $cabinetCapacity = $this->count() * Shelf::CAN_LIMIT;

        if($totalCanCount === 0) {
            return CabinetStatus::Empty;
        } else if($totalCanCount === $cabinetCapacity) {
            return CabinetStatus::Full;
        }
        return CabinetStatus::Half;
    }
}