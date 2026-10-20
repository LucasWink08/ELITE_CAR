<?php
declare(strict_types=1);

namespace Elite\Models;

use Elite\Core\Conexao;
use Elite\Entities\Carro as CarroEntity;
use PDO;

final class AnuncioVeiculoRepository
{
    private PDO $database;

    public function __construct(?PDO $database = null)
    {
        $this->database = $database ?? Conexao::obterConexao();
    }

    /** @param array<string, mixed> $dados @param list<string> $fotos */
    public function criar(int $usuarioId, array $dados, array $fotos, string $documentoCrlv, ?string $documentoExtra): int
    {
        $statement = $this->database->prepare(
            'INSERT INTO solicitacoes_anuncios_veiculos
             (usuario_id, marca, modelo, ano, preco, descricao, quilometragem, cor, combustivel,
              cambio, versao, motor, potencia, informacoes_adicionais, fotos_json,
              documento_crlv_path, documento_extra_path)
             VALUES (:usuario_id, :marca, :modelo, :ano, :preco, :descricao, :quilometragem, :cor,
              :combustivel, :cambio, :versao, :motor, :potencia, :informacoes_adicionais, :fotos_json,
              :documento_crlv_path, :documento_extra_path)'
        );
        $statement->execute([
            'usuario_id' => $usuarioId,
            'marca' => $dados['marca'], 'modelo' => $dados['modelo'], 'ano' => (int) $dados['ano'],
            'preco' => (float) $dados['preco'], 'descricao' => $dados['descricao'],
            'quilometragem' => (int) $dados['quilometragem'], 'cor' => $dados['cor'],
            'combustivel' => $dados['combustivel'], 'cambio' => $dados['cambio'],
            'versao' => $dados['versao'] === '' ? null : $dados['versao'],
            'motor' => $dados['motor'] === '' ? null : $dados['motor'], 'potencia' => (int) $dados['potencia'],
            'informacoes_adicionais' => $dados['informacoes_adicionais'] === '' ? null : $dados['informacoes_adicionais'],
            'fotos_json' => json_encode($fotos, JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR),
            'documento_crlv_path' => $documentoCrlv, 'documento_extra_path' => $documentoExtra,
        ]);
        return (int) $this->database->lastInsertId();
    }

    /** @return list<array<string, mixed>> */
    public function listarPorUsuario(int $usuarioId): array
    {
        $statement = $this->database->prepare(
            'SELECT id, marca, modelo, ano, preco, status, admin_observacao, criado_em
             FROM solicitacoes_anuncios_veiculos WHERE usuario_id = :usuario_id
             ORDER BY criado_em DESC, id DESC LIMIT 20'
        );
        $statement->execute(['usuario_id' => $usuarioId]);
        return $statement->fetchAll();
    }

    /** @return list<array<string, mixed>> */
    public function listarRecentes(): array
    {
        $statement = $this->database->query(
            'SELECT a.*, u.nome AS anunciante_nome, u.email AS anunciante_email, u.telefone AS anunciante_telefone
             FROM solicitacoes_anuncios_veiculos a
             INNER JOIN usuarios u ON u.id = a.usuario_id
             ORDER BY CASE a.status WHEN \'em_analise\' THEN 0 WHEN \'rejeitado\' THEN 1 ELSE 2 END,
                      a.criado_em DESC, a.id DESC LIMIT 100'
        );
        return $statement->fetchAll();
    }

    /** @return array<string, mixed>|null */
    public function buscarPorId(int $id): ?array
    {
        $statement = $this->database->prepare('SELECT * FROM solicitacoes_anuncios_veiculos WHERE id = :id');
        $statement->execute(['id' => $id]);
        $registro = $statement->fetch();
        return $registro === false ? null : $registro;
    }

    /** @return array<string, mixed>|null */
    public function buscarRejeitadoDoUsuario(int $id, int $usuarioId): ?array
    {
        $statement = $this->database->prepare(
            "SELECT marca, modelo, ano, preco, descricao, quilometragem, cor, combustivel,
                    cambio, versao, motor, potencia, informacoes_adicionais, admin_observacao
             FROM solicitacoes_anuncios_veiculos
             WHERE id = :id AND usuario_id = :usuario_id AND status = 'rejeitado' LIMIT 1"
        );
        $statement->execute(['id' => $id, 'usuario_id' => $usuarioId]);
        $registro = $statement->fetch();
        return $registro === false ? null : $registro;
    }

    /** @param list<string> $fotosPublicas */
    public function aprovar(int $id, array $fotosPublicas): int
    {
        $this->database->beginTransaction();
        try {
            $statement = $this->database->prepare(
                "SELECT * FROM solicitacoes_anuncios_veiculos WHERE id = :id AND status = 'em_analise' FOR UPDATE"
            );
            $statement->execute(['id' => $id]);
            $anuncio = $statement->fetch();
            if ($anuncio === false || $fotosPublicas === []) {
                throw new \RuntimeException('Solicitação pendente ou fotos do anúncio não encontradas.');
            }
            $infoTecnica = array_filter([
                $anuncio['motor'] !== null && $anuncio['motor'] !== '' ? 'Motorização: ' . $anuncio['motor'] : null,
                'Potência: ' . (int) $anuncio['potencia'] . ' cv',
                $anuncio['informacoes_adicionais'] !== null && $anuncio['informacoes_adicionais'] !== ''
                    ? (string) $anuncio['informacoes_adicionais'] : null,
            ]);
            $carro = new CarroEntity(
                null, (string) $anuncio['marca'], (string) $anuncio['modelo'], (int) $anuncio['ano'],
                (float) $anuncio['preco'], $fotosPublicas[0], (string) $anuncio['descricao'], 'disponivel',
                (int) $anuncio['quilometragem'], (string) $anuncio['cor'], (string) $anuncio['combustivel'],
                (string) $anuncio['cambio'], $anuncio['versao'] === null ? null : (string) $anuncio['versao'],
                implode(' | ', $infoTecnica)
            );
            $carroId = (new Carro($this->database))->inserir($carro);
            $update = $this->database->prepare(
                "UPDATE solicitacoes_anuncios_veiculos SET status = 'aprovado', carro_id = :carro_id,
                 fotos_json = :fotos_json, revisado_em = CURRENT_TIMESTAMP, admin_observacao = NULL
                 WHERE id = :id AND status = 'em_analise'"
            );
            $update->execute([
                'carro_id' => $carroId,
                'fotos_json' => json_encode($fotosPublicas, JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR),
                'id' => $id,
            ]);
            if ($update->rowCount() !== 1) {
                throw new \RuntimeException('Não foi possível concluir a aprovação.');
            }
            $this->database->commit();
            return $carroId;
        } catch (\Throwable $exception) {
            if ($this->database->inTransaction()) {
                $this->database->rollBack();
            }
            throw $exception;
        }
    }

    public function rejeitar(int $id, string $observacao): bool
    {
        $statement = $this->database->prepare(
            "UPDATE solicitacoes_anuncios_veiculos SET status = 'rejeitado',
             admin_observacao = :observacao, revisado_em = CURRENT_TIMESTAMP
             WHERE id = :id AND status = 'em_analise'"
        );
        $statement->execute(['id' => $id, 'observacao' => $observacao]);
        return $statement->rowCount() === 1;
    }

    /** @return list<string> */
    public function fotosPublicasPorCarro(int $carroId): array
    {
        $statement = $this->database->prepare(
            "SELECT fotos_json FROM solicitacoes_anuncios_veiculos
             WHERE carro_id = :carro_id AND status = 'aprovado' LIMIT 1"
        );
        $statement->execute(['carro_id' => $carroId]);
        $json = $statement->fetchColumn();
        $fotos = is_string($json) ? json_decode($json, true) : null;
        if (!is_array($fotos)) {
            return [];
        }
        return array_values(array_filter($fotos, static fn ($foto): bool => is_string($foto)));
    }
}
