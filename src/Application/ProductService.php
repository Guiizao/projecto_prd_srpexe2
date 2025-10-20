<?php
declare(strict_types=1);

namespace App\Application;

use App\Contracts\ProductRepository;
use App\Contracts\ProductValidator;

final class ProductService
{
    public function __construct(
        private ProductRepository $repository,
        private ProductValidator $validator
    ) {
    }

    /** @return array<int, array{id:int, name:string, price:float}> */
    public function listProducts(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @param array{name?:string, price?:string|float} $input
     * @return array{ok:bool, errors?:array<string, string>, id?:int}
     */
    /** @return array{ok:bool, errors?:array<string, string>, id?:int} */
public function createProduct(array $input): array
{
    $result = $this->validator->validate($input);

    if (!is_array($result)) {
        return ['ok' => false, 'errors' => ['internal' => 'Formato inválido do Validador!']];
    }

    if (!($result['ok'] ?? false)) {
        return ['ok' => false, 'errors' => ($result['errors'] ?? ['internal' => 'Erro de Validação!'])];
    }

    $data = $result['data'] ?? null;
    if (!is_array($data) || !isset($data['name'], $data['price'])) {
        return ['ok' => false, 'errors' => ['internal' => 'Falta de Dados']];
    }

    $id = $this->repository->save($data);

    return ['ok' => true, 'id' => $id];
}

}
