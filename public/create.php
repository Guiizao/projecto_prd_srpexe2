<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Infra\FileProductRepository;
use App\Application\ProductService;
use App\Domain\SimpleProductValidator;

$file = __DIR__ . '/../storage/products.txt';

$service = new ProductService(
  new FileProductRepository($file),
  new SimpleProductValidator()
);

$result = $service->createProduct($_POST);

if ($result['ok']) {
    http_response_code(201);
    ?>
    <!doctype html>
    <html lang="pt-br">
    <head><meta charset="utf-8"><title>Produto criado com sucesso</title></head>
    <body>
      <h1>Produto criado com sucesso!</h1>
      <p>O produto foi cadastrado com o ID: <?php echo htmlspecialchars((string)$result['id']); ?></p>
      <p><a href="/projecto_prd_srpexe2/public/products.php">Ver produtos</a></p>
      <p><a href="/projecto_prd_srpexe2/public/index.php">Cadastrar novo produto</a></p>
    </body>
    </html>
    <?php
    exit;
}

http_response_code(422);
$errors = $result['errors'] ?? [];
?>
<!doctype html>
<html lang="pt-br">
<head><meta charset="utf-8"><title>Erros no cadastro</title></head>
<body>
  <h1>Cadastro inválido</h1>
  <ul>
    <?php foreach ($errors as $field => $msg): ?>
      <li><strong><?=htmlspecialchars($field)?></strong>: <?=htmlspecialchars($msg)?></li>
    <?php endforeach; ?>
  </ul>
  <p><a href="/projecto_prd_srpexe2/public/index.php">Voltar</a></p>
</body>
</html>
