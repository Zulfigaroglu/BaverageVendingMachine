<?php

namespace App\Interfaces;

use App\Models\BaseModel;

/**
 * Interface IStackable
 * @package App\Interfaces
 * @template T
 */
interface IStackable
{
    /**
     * @return T[]
     */
    public function all(): array;

    /**
     * @param int $index
     * @return T
     */
    public function get(int $index);

    /**
     * @param $item
     */
    public function push($item): void;

    /**
     * @return T
     */
    public function pop();

    /**
     * @return int
     */
    public function count(): int;
}