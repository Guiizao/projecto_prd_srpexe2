<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Application\ProductService;
use App\Domain\SimpleProductValidator;
use App\Infra\FileProductRepository;

$file = __DIR__ . '/../storage/products.txt';

$service = new ProductService(
    new FileProductRepository($file),
    new SimpleProductValidator()
);

$items = $service->listProducts();
?>
<!doctype html>
<html lang="pt-br">
<head><meta charset="utf-8"><title>Produtos</title></head>
<body>
  <h1>Produtos</h1>

  <?php if (count($items) === 0) : ?>
    <p>Nenhum produto cadastrado</p>
  <?php else : ?>
    <table border="1" cellpadding="6" cellspacing="0">
      <thead><tr><th>ID</th><th>Nome</th><th>Preço</th></tr></thead>
      <tbody>
        <?php foreach ($items as $p) : ?>
          <tr>
            <td><?= (int)$p['id'] ?></td>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td><?= number_format((float)$p['price'], 2, ', ', '.') ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <p><a href="/projecto_prd_srpexe2/public/index.php">Cadastrar novo</a></p>
</body>
</html>
