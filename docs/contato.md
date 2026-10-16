# Formulário de contato

O formulário em `paginas/contato.php` valida nome, e-mail, assunto e mensagem no navegador e novamente no servidor. O envio usa token CSRF, registra a solicitação na tabela `mensagens_contato` via PDO e redireciona para uma confirmação, evitando reenviar ao atualizar a página.

Em um banco já criado, importe `database/migrations/20261014_mensagens_contato.sql`. Em uma instalação nova, a tabela está incluída em `database/schema.sql`.

O projeto confirma o registro no banco. Não envia e-mail automaticamente porque não há um serviço SMTP configurado.
