# Projeto: Cadastro e Listagem de Produtos — SRP em PHP

## Descrição Geral
Este projeto implementa um sistema simples de cadastro e listagem de produtos em PHP puro, aplicando o princípio da responsabilidade única (SRP).  
O foco é demonstrar uma arquitetura em camadas bem definidas (Domain, Application, Infra e Public), usando apenas arquivos de texto (JSON por linha) como persistência — sem uso de banco de dados.

## Objetivo
Desenvolver uma aplicação modular que:
- Permita cadastrar produtos (nome e preço);
- Exiba uma listagem dos produtos cadastrados;
- Valide corretamente os dados antes de salvar;
- Respeite as boas práticas de separação de responsabilidades (SRP).

## Tecnologias Utilizadas
- PHP 8.1+
- Composer (autoload PSR-4)
- XAMPP / Apache
- HTML + CSS (para visualização básica)
- JSON como persistência (armazenado em arquivo texto)

## Estrutura de Pastas
```
projecto_prd_srpexe2-main/
├─ docs/
│  ├─ README.txt
├─ src/
│  ├─ Application/
│  │  └─ ProductService.php
│  ├─ Domain/
│  │  └─ SimpleProductValidator.php
│  ├─ Infra/
│  │  └─ FileProductRepository.php
│  └─ Contracts/
│     ├─ ProductRepository.php
│     └─ ProductValidator.php
├─ public/
│  ├─ index.php
│  ├─ create.php
│  └─ products.php
├─ storage/
│  └─ products.txt
├─ composer.json
└─ vendor/
```

## Fluxo de Funcionamento
1. O usuário acessa `index.php` e preenche os campos Nome e Preço.  
2. O formulário envia os dados via POST para `create.php`.  
3. `create.php` cria uma instância de `ProductService`, que:
   - Valida os dados com `SimpleProductValidator`;
   - Gera um novo ID;
   - Salva o produto via `FileProductRepository`.
4. A listagem em `products.php` lê o arquivo `storage/products.txt` e exibe os produtos cadastrados em uma tabela.

## Persistência dos Dados
Os produtos são armazenados no arquivo:
```
storage/products.txt
```
Cada linha contém um objeto JSON, por exemplo:
```json
{"id":1,"name":"Teclado","price":120.50}
```

## Execução do Projeto
1. Coloque o projeto dentro da pasta htdocs do XAMPP.  
2. No terminal, rode:
   ```bash
   composer install
   composer dump-autoload -o
   ```
3. Crie a pasta `storage` e o arquivo vazio `products.txt`.  
4. Inicie o servidor Apache e acesse:
   ```
   http://localhost/projecto_prd_srpexe2-main/public/index.php
   ```

## Casos de Uso
| Caso | Entrada | Resultado Esperado |
|------|----------|--------------------|
| 1 | name="Teclado", price=120.50 | Produto criado e aparece na listagem |
| 2 | name="T", price=50 | Rejeitado (nome < 2 caracteres) |
| 3 | name="Mouse", price=-10 | Rejeitado (preço negativo) |
| 4 | Nenhum produto cadastrado | Exibe mensagem “Nenhum produto cadastrado” |
| 5 | 3 produtos cadastrados | Tabela mostra os 3 itens em ordem de ID |

## Autores
- Guilherme Dalanora Santos - 1991839
- Leonardo Lopes Martins Silva - 2010503

## Imagens
<img width="301" height="221" alt="image" src="https://github.com/user-attachments/assets/e1bd2ea9-84a2-4115-a4da-86beca49782e" /><br>
<img width="313" height="342" alt="image" src="https://github.com/user-attachments/assets/8195263e-3dc0-4fb4-a87e-4e948cbb8e9f" /><br>
<img width="434" height="237" alt="image" src="https://github.com/user-attachments/assets/05bff418-018f-4e60-842a-e5fc4bb9e419" />

## Observações Finais
- O projeto não utiliza banco de dados, apenas um arquivo texto.
- O código segue as boas práticas SRP e PSR-12.
- Todo o fluxo é desacoplado:  
  Validação → Serviço → Repositório → Camada pública.
- É um exemplo prático de como construir sistemas modulares e manuteníveis usando apenas PHP puro.
