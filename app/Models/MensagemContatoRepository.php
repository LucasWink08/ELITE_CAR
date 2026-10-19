<?php
declare(strict_types=1);

namespace Elite\Models;

use Elite\Core\Conexao;
use PDO;

final class MensagemContatoRepository
{
    private PDO $database;

    public function __construct(?PDO $database = null)
    {
        $this->database = $database ?? Conexao::obterConexao();
    }

    public function inserir(string $nome, string $email, string $assunto, string $mensagem): int
    {
        $statement = $this->database->prepare(
            'INSERT INTO mensagens_contato (nome, email, assunto, mensagem)
             VALUES (:nome, :email, :assunto, :mensagem)'
        );
        $statement->execute([
            'nome' => $nome,
            'email' => $email,
            'assunto' => $assunto,
            'mensagem' => $mensagem,
        ]);
        return (int) $this->database->lastInsertId();
    }
}
