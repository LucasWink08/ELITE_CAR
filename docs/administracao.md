# Ativar acesso administrativo

O projeto não cria uma conta administrativa padrão. Para banco já existente, importe `database/migrations/20261014_perfil_favoritos_admin.sql`. Em instalação nova, importe `database/schema.sql` atualizado.

Cadastre primeiro uma conta normal pela tela de cadastro. Em seguida, no MySQL/MariaDB, promova apenas a conta escolhida:

```sql
UPDATE usuarios
SET tipo = 'admin'
WHERE email = 'admin@seudominio.com';
```

Faça login novamente com essa conta. O painel em `paginas/admin_carros.php` consulta o papel no banco a cada acesso e permite cadastrar, editar, excluir e alterar o status dos veículos. A exclusão remove em cascata favoritos, comparações, histórico, intenções e itens do carrinho relacionados ao veículo.
