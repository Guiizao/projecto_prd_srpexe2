<?php
declare(strict_types=1);

?>
<!doctype html>
<html lang="pt-br">
<head><meta charset="utf-8"><title>Cadastro de Produto</title></head>
<body>
  <h1>Cadastrar Produto</h1>
  <form method="post" action="/projecto_prd_srpexe2/public/create.php">
    <label>Nome: <input type="text" name="name" required minlength="2" maxlength="100"></label><br>
    <label>Preço: <input type="text" name="price" required></label><br>
    <button type="submit">Cadastrar</button>
  </form>

  <p><a href="/projecto_prd_srpexe2/public/products.php">Ver produtos</a></p>
</body>
</html>
