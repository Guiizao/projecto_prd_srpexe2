<?php
declare(strict_types=1);

namespace App\Contracts;

interface ProductValidator
{
    /**
     * Deve retornar:
     * [
     *   'ok' => bool,
     *   'errors' => array<string, string>,
     *   'data' => ['name' => string, 'price' => float] (quando ok=true)
     * ]
     */
    public function validate(array $input): array;
}
