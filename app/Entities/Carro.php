<?php
declare(strict_types=1);

namespace Elite\Entities;

final class Carro
{
    public function __construct(
        private ?int $id,
        private string $marca,
        private string $modelo,
        private int $ano,
        private float $preco,
        private ?string $imagem = null,
        private ?string $descricao = null,
        private string $status = 'disponivel',
        private ?int $quilometragem = null,
        private ?string $cor = null,
        private ?string $combustivel = null,
        private ?string $cambio = null,
        private ?string $versao = null,
        private ?string $informacoesAdicionais = null
    ) {
        if ($ano < 1886 || $preco < 0) {
            throw new \InvalidArgumentException('Ano ou preço do veículo inválido.');
        }
    }

    public function getId(): ?int { return $this->id; }
    public function getMarca(): string { return $this->marca; }
    public function getModelo(): string { return $this->modelo; }
    public function getAno(): int { return $this->ano; }
    public function getPreco(): float { return $this->preco; }
    public function getImagem(): ?string { return $this->imagem; }
    public function getDescricao(): ?string { return $this->descricao; }
    public function getStatus(): string { return $this->status; }
    public function getQuilometragem(): ?int { return $this->quilometragem; }
    public function getCor(): ?string { return $this->cor; }
    public function getCombustivel(): ?string { return $this->combustivel; }
    public function getCambio(): ?string { return $this->cambio; }
    public function getVersao(): ?string { return $this->versao; }
    public function getInformacoesAdicionais(): ?string { return $this->informacoesAdicionais; }

    public function atualizarPreco(float $preco): void
    {
        if ($preco < 0) {
            throw new \InvalidArgumentException('O preço não pode ser negativo.');
        }
        $this->preco = $preco;
    }

    public function alterarStatus(string $status): void
    {
        if (!in_array($status, ['disponivel', 'indisponivel', 'vendido'], true)) {
            throw new \InvalidArgumentException('Status de veículo inválido.');
        }
        $this->status = $status;
    }
}
