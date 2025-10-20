<?php

declare(strict_types=1);

namespace App\Infra;

use App\Contracts\ProductRepository;

final class FileProductRepository implements ProductRepository
{
    private string $filePath;

    public function __construct(string $filePath)
{
        $this->filePath = $filePath;

        $dir = dirname($this->filePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        if (!file_exists($this->filePath)) {
            touch($this->filePath);
        }
    }

    public function findAll(): array
    {
        $items = [];
        $fh = fopen($this->filePath, 'rb');
        if ($fh === false) {
            return $items;
        }
        while (($line = fgets($fh)) !== false) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }
            $row = json_decode($line, true);
            if (is_array($row) && isset($row['id'], $row['name'], $row['price'])) {
                $items[] = [
                    'id' => (int)$row['id'],
                    'name' => (string)$row['name'],
                    'price' => (float)$row['price'],
                ];
            }
        }
        fclose($fh);
        return $items;
    }

    public function save(array $product): int
    {
        $id = $this->nextId();
        $record = [
        'id'    => $id,
        'name'  => (string)$product['name'],
        'price' => (float)$product['price'],
        ];

        $line = json_encode($record, JSON_UNESCAPED_UNICODE);

        $fh = fopen($this->filePath, 'ab');
        if ($fh === false) {
            throw new \RuntimeException('Não foi possível abrir o arquivo de Produtos!');
        }

        if (flock($fh, LOCK_EX)) {
            fwrite($fh, $line . PHP_EOL);
            fflush($fh);
            flock($fh, LOCK_UN);
        }

        fclose($fh);
        return $id;
    }

    private function nextId(): int
    {
        $lastId = 0;
        $fh = fopen($this->filePath, 'rb');
        if ($fh !== false) {
            while (($line = fgets($fh)) !== false) {
                $row = json_decode($line, true);
                if (is_array($row) && isset($row['id'])) {
                    $lastId = max($lastId, (int)$row['id']);
                }
            }
            fclose($fh);
        }
        return $lastId + 1;
    }
}
