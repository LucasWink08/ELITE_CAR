<?php
declare(strict_types=1);

namespace LuxCars\Models;

use LuxCars\Core\Conexao;
use PDO;

final class UsuarioRepository
{
    private PDO $database;

    public function __construct(?PDO $database = null)
    {
        $this->database = $database ?? Conexao::obterConexao();
    }

    public function inserir(Usuario $usuario): int
    {
        $statement = $this->database->prepare(
            'INSERT INTO usuarios (nome, cpf, data_nascimento, email, telefone, endereco,
             numero_endereco, cidade, estado, senha_hash)
             VALUES (:nome, :cpf, :data_nascimento, :email, :telefone, :endereco,
             :numero_endereco, :cidade, :estado, :senha_hash)'
        );
        $statement->execute($this->valores($usuario));

        return (int) $this->database->lastInsertId();
    }

    /** Retorna somente dados públicos, sem o hash da senha. */
    public function buscarPorId(int $id): ?array
    {
        $statement = $this->database->prepare(
            'SELECT id, nome, cpf, data_nascimento, email, telefone, endereco,
             numero_endereco, cidade, estado FROM usuarios WHERE id = :id'
        );
        $statement->execute(['id' => $id]);
        $usuario = $statement->fetch();

        return $usuario === false ? null : $usuario;
    }

    /** Atualiza somente dados de contato e endereço; senha, CPF e nascimento são preservados. */
    public function atualizarPerfil(int $id, array $dados): bool
    {
        $statement = $this->database->prepare(
            'UPDATE usuarios SET nome = :nome, email = :email, telefone = :telefone,
             endereco = :endereco, numero_endereco = :numero_endereco, cidade = :cidade,
             estado = :estado WHERE id = :id'
        );
        return $statement->execute([
            'id' => $id,
            'nome' => $dados['nome'],
            'email' => $dados['email'],
            'telefone' => preg_replace('/\D+/', '', (string) $dados['telefone']),
            'endereco' => $dados['endereco'],
            'numero_endereco' => $dados['numero_endereco'],
            'cidade' => $dados['cidade'],
            'estado' => strtoupper((string) $dados['estado']),
        ]);
    }

    public function ehAdministrador(int $id): bool
    {
        $statement = $this->database->prepare("SELECT 1 FROM usuarios WHERE id = :id AND tipo = 'admin'");
        $statement->execute(['id' => $id]);
        return $statement->fetchColumn() !== false;
    }

    /** Retorna dados públicos apenas se e-mail e senha corresponderem. */
    public function autenticar(string $email, string $senha): ?array
    {
        $statement = $this->database->prepare(
            'SELECT id, nome, cpf, data_nascimento, email, telefone, endereco,
             numero_endereco, cidade, estado, tipo, senha_hash FROM usuarios WHERE email = :email'
        );
        $statement->execute(['email' => $email]);
        $usuario = $statement->fetch();

        if ($usuario === false || !password_verify($senha, $usuario['senha_hash'])) {
            return null;
        }

        unset($usuario['senha_hash']);
        return $usuario;
    }

    public function atualizar(Usuario $usuario): bool
    {
        if ($usuario->getId() === null) {
            throw new \InvalidArgumentException('O usuário precisa ter um ID para ser atualizado.');
        }

        $statement = $this->database->prepare(
            'UPDATE usuarios SET nome = :nome, cpf = :cpf, data_nascimento = :data_nascimento,
             email = :email, telefone = :telefone, endereco = :endereco,
             numero_endereco = :numero_endereco, cidade = :cidade, estado = :estado,
             senha_hash = :senha_hash WHERE id = :id'
        );
        return $statement->execute($this->valores($usuario) + ['id' => $usuario->getId()]);
    }

    public function excluir(int $id): bool
    {
        $statement = $this->database->prepare('DELETE FROM usuarios WHERE id = :id');
        return $statement->execute(['id' => $id]);
    }

    /** @return array<string, mixed> */
    private function valores(Usuario $usuario): array
    {
        return [
            'nome' => $usuario->getNome(),
            'cpf' => preg_replace('/\D+/', '', $usuario->getCpf()),
            'data_nascimento' => $usuario->getDataNascimento(),
            'email' => $usuario->getEmail(),
            'telefone' => $usuario->getTelefone(),
            'endereco' => $usuario->getEndereco(),
            'numero_endereco' => $usuario->getNumeroEndereco(),
            'cidade' => $usuario->getCidade(),
            'estado' => strtoupper($usuario->getEstado()),
            'senha_hash' => $usuario->getSenhaHash(),
        ];
    }
}
