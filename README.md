# ELITE

Projeto de interface para uma loja de carros de luxo.

## Estrutura

```text
app/Controllers/   # recebe requisicoes e coordena o fluxo
app/Models/        # regras de modelos e acesso aos dados
app/Entities/      # entidades de dominio com atributos encapsulados
app/Views/         # apresentacao
app/Core/          # infraestrutura compartilhada, como conexao PDO
assets/            # estilos, fontes e imagens
database/          # schema inicial do banco
docs/              # rascunhos e arquivos legados
includes/          # componentes visuais reutilizaveis
paginas/           # pontos de entrada e paginas antigas
bootstrap.php      # autoload das classes ELITE
```

Os arquivos em `docs/` nao sao carregados pela aplicacao. Os pontos de entrada `paginas/homepage.php` e `paginas/paginadecompra.php` passam pelos controladores MVC. A home reutiliza os componentes visuais existentes; o catalogo consulta os carros disponiveis por meio do model `Carro`.

## Configuracao do banco (MySQL/MariaDB)

1. Instale/inicie MySQL ou MariaDB e habilite a extensão PHP `pdo_mysql` no XAMPP.
2. Importe `database/schema.sql` no servidor MySQL/MariaDB. O arquivo cria as tabelas e inclui os veiculos de todas as nove paginas de marcas, alem dos veiculos iniciais.
3. Para atualizar um banco que ja existe, execute `database/catalogo_completo.sql` uma vez. A migracao inclui os 90 anuncios das paginas de marcas no catalogo completo e evita reinserir o mesmo anuncio.
4. Configure `ELITE_DB_HOST`, `ELITE_DB_PORT`, `ELITE_DB_NAME`, `ELITE_DB_USER` e `ELITE_DB_PASSWORD` no ambiente do PHP. Os padroes locais sao `127.0.0.1`, `3306`, `elite`, `root` e senha vazia.
5. Cadastre veiculos na tabela `carros`. O campo `imagem` deve ser relativo a pasta `ELITE`, por exemplo `assets/imagens/cars/bmw/2020-bmw-x6-m-competition-1.webp`.

Sem banco configurado, o catalogo apresenta uma mensagem de erro amigavel e grava detalhes tecnicos no log do servidor.

Para atualizar um banco que já foi criado com o schema anterior, execute uma vez `database/migrations/20261014_detalhes_filtros_carros.sql`. Em uma instalação nova, basta importar o `database/schema.sql` atualizado.

O catálogo permite buscar por marca e modelo e filtrar por ano, faixa de preço, combustível e câmbio. Os detalhes de cada veículo incluem versão, quilometragem, cor, combustível, câmbio, descrição e informações adicionais, todos carregados da tabela `carros`.

## Noticias automotivas

A home consulta a APITube News API e exibe noticias automotivas em portugues. Os artigos sao atualizados no maximo a cada 15 minutos e salvos na tabela `noticias_automotivas`, incluindo os campos exibidos e o JSON retornado pela API. Em bancos existentes, execute `database/migrations/20261018_noticias_automotivas.sql`; instalacoes novas recebem a tabela pelo `database/schema.sql`.

A chave APITube fica em `.env.local` (arquivo ignorado pelo Git), na variavel `APITUBE_API_KEY`. O `bootstrap.php` carrega essa configuracao local sem sobrescrever uma variavel de ambiente ja definida no servidor.

## Classes do dominio

- `Elite\Entities\Carro`: entidade de veiculo, com propriedades privadas, getters e alteracoes validadas de preco e status.
- `Elite\Models\Usuario`: dados encapsulados do usuario e metodos de atualizacao; a senha e mantida como hash.
- `Elite\Models\Carrinho`: adiciona e remove veiculos, lista itens e calcula quantidade e total em memoria.
- `Elite\Core\Conexao`: classe unica que cria e reutiliza a conexao PDO para MySQL/MariaDB.
- `Elite\Models\Carro`: repositorio que consulta o banco e hidrata entidades `Carro`.
- `Elite\Models\UsuarioRepository`: CRUD de usuários e autenticação por hash com consultas preparadas.
- `Elite\Models\CarrinhoRepository`: consulta e operações de inclusão, atualização e remoção de itens.

Os repositórios de usuários, veículos e carrinho executam leitura, inclusão, atualização e exclusão com PDO e consultas preparadas. A página inicial e o catálogo obtêm nome, ano, preço, imagem e descrição dos veículos da tabela `carros`; se o banco estiver indisponível, exibem uma mensagem em vez de listar veículos fixos.

O cadastro de cliente está disponível em `paginas/cadastro.php`. Ele valida os campos no servidor, confere os dígitos verificadores do CPF, valida a data, exige idade mínima de 18 anos no navegador e no servidor, valida o telefone, exige senha com oito caracteres e grava o usuário por meio de `UsuarioRepository` com `password_hash()`.

O login em `paginas/entrar.php` autentica pelo e-mail cadastrado com `password_verify()`, regenera o ID da sessão e guarda o ID e o nome do usuário autenticado.

O menu compartilhado mostra o nome do usuário e oferece logout por POST em `paginas/sair.php`. A classe `Elite\Core\Autenticacao` protege rotas que exigem login; a página de anúncios já a utiliza e redireciona visitantes para o login.

O carrinho está disponível em `paginas/carrinho.php` e exige sessão autenticada. O botão nos detalhes adiciona o veículo disponível do banco ao carrinho do usuário; a tela lista imagem, modelo, ano, preço unitário e quantidade e calcula subtotal e total a partir dos dados atuais do banco.


## Agendamento de test drive

A opcao "Agendar test drive" substitui o simulador de seguro e registra pedidos para um veiculo e horario. Novos bancos recebem a tabela `agendamentos_test_drive` ao importar `database/schema.sql`; bancos existentes devem executar `database/migrations/20261014_agendamentos_test_drive.sql`. O formulario valida nome, e-mail, telefone, veiculo disponivel, data de segunda a sabado e horario entre 9h e 17h. A equipe deve confirmar o pedido com o cliente.
