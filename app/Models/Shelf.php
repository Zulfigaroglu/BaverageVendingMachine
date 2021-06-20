<?php

namespace App\Models;

use App\Exceptions\CanNotExistException;
use App\Exceptions\ShelfCanLimitExceededException;
use App\Interfaces\IStackable;

/**
 * Class Shelf
 * @package App\Models
 * @implements IStackable<Can>
 */
class Shelf extends BaseModel implements IStackable
{

    const CAN_LIMIT = 20;

    /**
     * @var Can[]
     */
    private array $cans;

    /**
     * Shelf constructor.
     */
    public function __construct()
    {
        $this->cans = [];
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->cans;
    }

    /**
     * @param int $index
     * @return Can
     * @throws CanNotExistException
     */
    public function get(int $index): Can
    {
        if(!array_key_exists($index, $this->cans)){
            throw new CanNotExistException();
        }

        return $this->cans[$index];
    }

    /**
     * @param Can $item
     * @throws ShelfCanLimitExceededException
     */
    public function push($item): void
    {
        if($this->count() >= static::CAN_LIMIT) {
            throw new ShelfCanLimitExceededException();
        }

        $this->cans[] = $item;
    }

    /**
     * @return Can
     * @throws CanNotExistException
     */
    public function pop(): Can
    {
        if($this->count() === 0){
            throw new CanNotExistException();
        }

        return array_pop($this->cans);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->cans);
    }
}