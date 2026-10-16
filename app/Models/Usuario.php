<?php
declare(strict_types=1);

namespace LuxCars\Models;

final class Usuario
{
    private string $senhaHash;

    public function __construct(
        private ?int $id,
        private string $nome,
        private string $email,
        private string $cpf,
        private string $dataNascimento,
        string $senha,
        private string $telefone = '',
        private string $endereco = '',
        private string $numeroEndereco = '',
        private string $cidade = '',
        private string $estado = ''
    ) {
        $this->atualizarSenha($senha);
    }

    public function getId(): ?int { return $this->id; }
    public function getNome(): string { return $this->nome; }
    public function getEmail(): string { return $this->email; }
    public function getCpf(): string { return $this->cpf; }
    public function getDataNascimento(): string { return $this->dataNascimento; }
    public function getTelefone(): string { return $this->telefone; }
    public function getEndereco(): string { return $this->endereco; }
    public function getNumeroEndereco(): string { return $this->numeroEndereco; }
    public function getCidade(): string { return $this->cidade; }
    public function getEstado(): string { return $this->estado; }

    public function atualizarNome(string $nome): void
    {
        $nome = trim($nome);
        if ($nome === '') {
            throw new \InvalidArgumentException('O nome não pode ficar vazio.');
        }
        $this->nome = $nome;
    }

    public function atualizarEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('E-mail inválido.');
        }
        $this->email = $email;
    }

    public function atualizarSenha(string $senha): void
    {
        $caracteres = preg_match_all('/./us', $senha);
        $comprimento = $caracteres === false ? strlen($senha) : $caracteres;
        if ($comprimento < 8) {
            throw new \InvalidArgumentException('A senha deve possuir pelo menos 8 caracteres.');
        }
        $this->senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    }

    public function verificarSenha(string $senha): bool
    {
        return password_verify($senha, $this->senhaHash);
    }

    public function getSenhaHash(): string
    {
        return $this->senhaHash;
    }
}
