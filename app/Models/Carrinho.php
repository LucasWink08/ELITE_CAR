<?php
declare(strict_types=1);

namespace Elite\Models;

use Elite\Entities\Carro;

final class Carrinho
{
    /** @var array<int, Carro> */
    private array $itens = [];

    public function adicionar(Carro $carro): void
    {
        if ($carro->getId() === null) {
            throw new \InvalidArgumentException('O veículo precisa estar cadastrado para entrar no carrinho.');
        }
        if ($carro->getStatus() !== 'disponivel') {
            throw new \DomainException('Somente veículos disponíveis podem ser adicionados.');
        }
        $this->itens[$carro->getId()] = $carro;
    }

    public function remover(int $carroId): void
    {
        unset($this->itens[$carroId]);
    }

    public function limpar(): void
    {
        $this->itens = [];
    }

    /** @return array<int, Carro> */
    public function getItens(): array
    {
        return array_values($this->itens);
    }

    public function getQuantidade(): int
    {
        return count($this->itens);
    }

    public function getTotal(): float
    {
        return array_reduce($this->itens, static fn (float $total, Carro $carro): float => $total + $carro->getPreco(), 0.0);
    }
}
