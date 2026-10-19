<?php
declare(strict_types=1);

namespace Elite\Models;

use Elite\Core\Conexao;
use PDO;

final class InteracaoRepository
{
    private PDO $database;

    public function __construct(?PDO $database = null)
    {
        $this->database = $database ?? Conexao::obterConexao();
    }

    public function favoritar(int $usuarioId, int $carroId): bool
    {
        $statement = $this->database->prepare(
            "INSERT IGNORE INTO favoritos (usuario_id, carro_id)
             SELECT :usuario_id, id FROM carros WHERE id = :carro_id AND status = 'disponivel'"
        );
        $statement->execute(['usuario_id' => $usuarioId, 'carro_id' => $carroId]);
        $check = $this->database->prepare(
            "SELECT 1 FROM favoritos f INNER JOIN carros c ON c.id = f.carro_id
             WHERE f.usuario_id = :usuario_id AND f.carro_id = :carro_id AND c.status = 'disponivel'"
        );
        $check->execute(['usuario_id' => $usuarioId, 'carro_id' => $carroId]);
        return $check->fetchColumn() !== false;
    }

    public function desfavoritar(int $usuarioId, int $carroId): bool
    {
        $statement = $this->database->prepare('DELETE FROM favoritos WHERE usuario_id = :usuario_id AND carro_id = :carro_id');
        $statement->execute(['usuario_id' => $usuarioId, 'carro_id' => $carroId]);
        return $statement->rowCount() > 0;
    }

    public function listarFavoritos(int $usuarioId): array
    {
        return $this->listarPorInteracao('favoritos', $usuarioId);
    }

    public function adicionarComparacao(int $usuarioId, int $carroId): string
    {
        $existing = $this->database->prepare('SELECT 1 FROM comparacao_carros WHERE usuario_id = :usuario_id AND carro_id = :carro_id');
        $existing->execute(['usuario_id' => $usuarioId, 'carro_id' => $carroId]);
        if ($existing->fetchColumn() !== false) {
            return 'ok';
        }

        $count = $this->database->prepare('SELECT COUNT(*) FROM comparacao_carros WHERE usuario_id = :usuario_id');
        $count->execute(['usuario_id' => $usuarioId]);
        if ((int) $count->fetchColumn() >= 3) {
            return 'limite';
        }

        $insert = $this->database->prepare(
            "INSERT INTO comparacao_carros (usuario_id, carro_id)
             SELECT :usuario_id, id FROM carros WHERE id = :carro_id AND status = 'disponivel'"
        );
        $insert->execute(['usuario_id' => $usuarioId, 'carro_id' => $carroId]);
        return $insert->rowCount() > 0 ? 'ok' : 'indisponivel';
    }

    public function removerComparacao(int $usuarioId, int $carroId): bool
    {
        $statement = $this->database->prepare('DELETE FROM comparacao_carros WHERE usuario_id = :usuario_id AND carro_id = :carro_id');
        $statement->execute(['usuario_id' => $usuarioId, 'carro_id' => $carroId]);
        return $statement->rowCount() > 0;
    }

    public function limparComparacao(int $usuarioId): bool
    {
        $statement = $this->database->prepare('DELETE FROM comparacao_carros WHERE usuario_id = :usuario_id');
        return $statement->execute(['usuario_id' => $usuarioId]);
    }

    public function listarComparacao(int $usuarioId): array
    {
        return $this->listarPorInteracao('comparacao_carros', $usuarioId);
    }

    public function registrarVisualizacao(int $usuarioId, int $carroId): void
    {
        $statement = $this->database->prepare(
            'INSERT INTO historico_visualizacoes (usuario_id, carro_id) VALUES (:usuario_id, :carro_id)'
        );
        $statement->execute(['usuario_id' => $usuarioId, 'carro_id' => $carroId]);
        $prune = $this->database->prepare(
            'DELETE FROM historico_visualizacoes WHERE usuario_id = :usuario_id
             AND id NOT IN (SELECT id FROM (SELECT id FROM historico_visualizacoes WHERE usuario_id = :usuario_id_2
             ORDER BY visualizado_em DESC, id DESC LIMIT 100) recentes)'
        );
        $prune->execute(['usuario_id' => $usuarioId, 'usuario_id_2' => $usuarioId]);
    }

    public function listarHistorico(int $usuarioId): array
    {
        $statement = $this->database->prepare(
            'SELECT c.id, c.marca, c.modelo, c.ano, c.preco, c.imagem, c.status, MAX(h.visualizado_em) AS visualizado_em
             FROM historico_visualizacoes h INNER JOIN carros c ON c.id = h.carro_id
             WHERE h.usuario_id = :usuario_id GROUP BY c.id, c.marca, c.modelo, c.ano, c.preco, c.imagem, c.status
             ORDER BY visualizado_em DESC LIMIT 100'
        );
        $statement->execute(['usuario_id' => $usuarioId]);
        return $statement->fetchAll();
    }

    public function registrarIntencao(int $usuarioId, int $carroId, string $mensagem): bool
    {
        $statement = $this->database->prepare(
            "INSERT INTO intencoes_compra (usuario_id, carro_id, mensagem)
             SELECT :usuario_id, id, :mensagem FROM carros WHERE id = :carro_id AND status = 'disponivel'"
        );
        $statement->execute([
            'usuario_id' => $usuarioId,
            'carro_id' => $carroId,
            'mensagem' => $mensagem === '' ? null : $mensagem,
        ]);
        return $statement->rowCount() > 0;
    }

    public function listarIntencoes(int $usuarioId): array
    {
        $statement = $this->database->prepare(
            'SELECT i.id, i.mensagem, i.status, i.criada_em, c.id AS carro_id, c.marca, c.modelo, c.ano, c.preco
             FROM intencoes_compra i INNER JOIN carros c ON c.id = i.carro_id
             WHERE i.usuario_id = :usuario_id ORDER BY i.criada_em DESC'
        );
        $statement->execute(['usuario_id' => $usuarioId]);
        return $statement->fetchAll();
    }

    /** @return array<int, array<string, mixed>> */
    private function listarPorInteracao(string $tabela, int $usuarioId): array
    {
        if (!in_array($tabela, ['favoritos', 'comparacao_carros'], true)) {
            throw new \InvalidArgumentException('Tabela de interação inválida.');
        }
        $colunaData = $tabela === 'favoritos' ? 'criado_em' : 'adicionado_em';
        $statement = $this->database->prepare(
            "SELECT c.id, c.marca, c.modelo, c.ano, c.preco, c.imagem, c.descricao, c.status,
                    c.quilometragem, c.cor, c.combustivel, c.cambio, c.versao, c.informacoes_adicionais
             FROM {$tabela} i INNER JOIN carros c ON c.id = i.carro_id
             WHERE i.usuario_id = :usuario_id ORDER BY i.{$colunaData} DESC"
        );
        $statement->execute(['usuario_id' => $usuarioId]);
        return $statement->fetchAll();
    }
}
