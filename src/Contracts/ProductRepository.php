<?php

declare(strict_types=1);

namespace App\Contracts;

interface ProductRepository
{
    /**
     * @return array<int, array{id:int, name:string, price:float}>
     */
    public function findAll(): array;

    /**
     * @param array{name:string, price:float} $product
     * @return int
     */
    public function save(array $product): int;
}
