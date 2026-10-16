<?php
declare(strict_types=1);

namespace LuxCars\Models;

use LuxCars\Core\Conexao;
use PDO;

final class CarrinhoRepository
{
    private PDO $database;

    public function __construct(?PDO $database = null)
    {
        $this->database = $database ?? Conexao::obterConexao();
    }

    /** Lista os itens e os dados atuais dos veículos a partir do banco. */
    public function listar(int $usuarioId): array
    {
        $statement = $this->database->prepare(
            'SELECT c.id AS carro_id, c.marca, c.modelo, c.ano, c.preco, c.imagem,
             ci.quantidade, c.preco * ci.quantidade AS subtotal
             FROM carrinho ci INNER JOIN carros c ON c.id = ci.carro_id
             WHERE ci.usuario_id = :usuario_id ORDER BY ci.adicionado_em DESC'
        );
        $statement->execute(['usuario_id' => $usuarioId]);
        return $statement->fetchAll();
    }

    public function adicionar(int $usuarioId, int $carroId, int $quantidade = 1): bool
    {
        $this->validarQuantidade($quantidade);
        $statement = $this->database->prepare(
            "INSERT INTO carrinho (usuario_id, carro_id, quantidade)
             SELECT :usuario_id, id, :quantidade FROM carros
             WHERE id = :carro_id AND status = 'disponivel'
             ON DUPLICATE KEY UPDATE quantidade = VALUES(quantidade)"
        );
        $statement->execute([
            'usuario_id' => $usuarioId,
            'carro_id' => $carroId,
            'quantidade' => $quantidade,
        ]);
        if ($statement->rowCount() > 0) {
            return true;
        }

        // INSERT ... SELECT afeta zero linhas se o veículo não estiver disponível;
        // rowCount também pode ser zero se o item já estava no carrinho sem alterações.
        $confirmacao = $this->database->prepare(
            "SELECT 1 FROM carrinho ci INNER JOIN carros c ON c.id = ci.carro_id
             WHERE ci.usuario_id = :usuario_id AND ci.carro_id = :carro_id
             AND c.status = 'disponivel'"
        );
        $confirmacao->execute(['usuario_id' => $usuarioId, 'carro_id' => $carroId]);
        return $confirmacao->fetchColumn() !== false;
    }

    public function alterarQuantidade(int $usuarioId, int $carroId, int $quantidade): bool
    {
        $this->validarQuantidade($quantidade);
        $statement = $this->database->prepare(
            'UPDATE carrinho SET quantidade = :quantidade WHERE usuario_id = :usuario_id AND carro_id = :carro_id'
        );
        $statement->execute([
            'quantidade' => $quantidade,
            'usuario_id' => $usuarioId,
            'carro_id' => $carroId,
        ]);
        if ($statement->rowCount() > 0) {
            return true;
        }

        $confirmacao = $this->database->prepare(
            'SELECT 1 FROM carrinho WHERE usuario_id = :usuario_id AND carro_id = :carro_id'
        );
        $confirmacao->execute(['usuario_id' => $usuarioId, 'carro_id' => $carroId]);
        return $confirmacao->fetchColumn() !== false;
    }

    public function remover(int $usuarioId, int $carroId): bool
    {
        $statement = $this->database->prepare(
            'DELETE FROM carrinho WHERE usuario_id = :usuario_id AND carro_id = :carro_id'
        );
        $statement->execute(['usuario_id' => $usuarioId, 'carro_id' => $carroId]);
        return $statement->rowCount() > 0;
    }

    public function limpar(int $usuarioId): bool
    {
        $statement = $this->database->prepare('DELETE FROM carrinho WHERE usuario_id = :usuario_id');
        return $statement->execute(['usuario_id' => $usuarioId]);
    }

    private function validarQuantidade(int $quantidade): void
    {
        if ($quantidade < 1 || $quantidade > 99) {
            throw new \InvalidArgumentException('A quantidade precisa estar entre 1 e 99.');
        }
    }
}
