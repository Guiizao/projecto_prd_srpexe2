<?php
declare(strict_types=1);

namespace App\Domain;

use App\Contracts\ProductValidator;

final class SimpleProductValidator implements ProductValidator
{
    public function validate(array $input): array
    {
        $errors = [];
        $data = [];

        if (empty($input['name'])) {
            $errors['name'] = 'Nome é obrigatório';
        } elseif (!is_string($input['name']) || strlen($input['name']) < 2) {
            $errors['name'] = 'Nome deve ter pelo menos 2 caracteres';
        } else {
            $data['name'] = trim($input['name']);
        }

        if (empty($input['price'])) {
            $errors['price'] = 'Preço é obrigatório';
        } else {
            $price = filter_var($input['price'], FILTER_VALIDATE_FLOAT);
            if ($price === false || $price < 0) {
                $errors['price'] = 'Preço deve ser um número positivo';
            } else {
                $data['price'] = $price;
            }
        }

        if (empty($errors)) {
            return ['ok' => true, 'data' => $data];
        }

        return ['ok' => false, 'errors' => $errors];
    }
}
