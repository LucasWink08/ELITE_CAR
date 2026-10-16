<?php
declare(strict_types=1);

namespace LuxCars\Models;

use LuxCars\Core\Conexao;
use LuxCars\Entities\Carro as CarroEntity;
use PDO;

/** Repositório de persistência e consultas de veículos. */
final class Carro
{
    private PDO $database;

    public function __construct(?PDO $database = null)
    {
        $this->database = $database ?? Conexao::obterConexao();
    }

    /** @return array<int, CarroEntity> */
    public function listarDisponiveis(): array
    {
        return $this->buscarDisponiveis([]);
    }

    /** @return array<int, CarroEntity> */
    public function listarTodos(): array
    {
        $statement = $this->database->query(
            'SELECT id, marca, modelo, ano, preco, imagem, descricao, status,
             quilometragem, cor, combustivel, cambio, versao, informacoes_adicionais
             FROM carros ORDER BY atualizado_em DESC, id DESC'
        );
        return array_map(fn (array $dados): CarroEntity => $this->hidratar($dados), $statement->fetchAll());
    }

    /** @param array<string, mixed> $filtros
     *  @return array<int, CarroEntity>
     */
    public function buscarDisponiveis(array $filtros): array
    {
        $where = ['status = :status'];
        $parametros = ['status' => 'disponivel'];

        foreach (['marca', 'modelo'] as $campo) {
            $termo = trim((string) ($filtros[$campo] ?? ''));
            if ($termo !== '') {
                $where[] = "{$campo} LIKE :{$campo}";
                $parametros[$campo] = '%' . $termo . '%';
            }
        }

        $ano = filter_var($filtros['ano'] ?? null, FILTER_VALIDATE_INT);
        if ($ano !== false && $ano !== null && $ano >= 1886) {
            $where[] = 'ano = :ano';
            $parametros['ano'] = $ano;
        }

        foreach (['preco_min' => '>=', 'preco_max' => '<='] as $campo => $operador) {
            $valor = $filtros[$campo] ?? null;
            if ($valor !== null && $valor !== '' && is_numeric($valor) && (float) $valor >= 0) {
                $where[] = "preco {$operador} :{$campo}";
                $parametros[$campo] = (float) $valor;
            }
        }

        foreach (['combustivel', 'cambio'] as $campo) {
            $valor = trim((string) ($filtros[$campo] ?? ''));
            if ($valor !== '') {
                $where[] = "{$campo} = :{$campo}";
                $parametros[$campo] = $valor;
            }
        }

        $sql = 'SELECT id, marca, modelo, ano, preco, imagem, descricao, status,
                       quilometragem, cor, combustivel, cambio, versao, informacoes_adicionais
                FROM carros WHERE ' . implode(' AND ', $where) . ' ORDER BY marca, modelo';
        $statement = $this->database->prepare($sql);
        $statement->execute($parametros);

        return array_map(fn (array $dados): CarroEntity => $this->hidratar($dados), $statement->fetchAll());
    }

    public function buscarPorId(int $id): ?CarroEntity
    {
        $statement = $this->database->prepare(
            'SELECT id, marca, modelo, ano, preco, imagem, descricao, status,
             quilometragem, cor, combustivel, cambio, versao, informacoes_adicionais
             FROM carros WHERE id = :id'
        );
        $statement->execute(['id' => $id]);
        $dados = $statement->fetch();

        return $dados === false ? null : $this->hidratar($dados);
    }

    public function buscarPorImagem(string $imagem): ?CarroEntity
    {
        $statement = $this->database->prepare(
            'SELECT id, marca, modelo, ano, preco, imagem, descricao, status,
             quilometragem, cor, combustivel, cambio, versao, informacoes_adicionais
             FROM carros
             WHERE imagem = :imagem AND status = :status
             ORDER BY id DESC
             LIMIT 1'
        );
        $statement->execute(['imagem' => $imagem, 'status' => 'disponivel']);
        $dados = $statement->fetch();

        return $dados === false ? null : $this->hidratar($dados);
    }

    public function inserir(CarroEntity $carro): int
    {
        $statement = $this->database->prepare(
            'INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, status,
             quilometragem, cor, combustivel, cambio, versao, informacoes_adicionais)
             VALUES (:marca, :modelo, :ano, :preco, :imagem, :descricao, :status,
             :quilometragem, :cor, :combustivel, :cambio, :versao, :informacoes_adicionais)'
        );
        $statement->execute($this->valores($carro));

        return (int) $this->database->lastInsertId();
    }

    public function atualizar(CarroEntity $carro): bool
    {
        if ($carro->getId() === null) {
            throw new \InvalidArgumentException('O veículo precisa ter um ID para ser atualizado.');
        }

        $statement = $this->database->prepare(
            'UPDATE carros SET marca = :marca, modelo = :modelo, ano = :ano, preco = :preco,
             imagem = :imagem, descricao = :descricao, status = :status,
             quilometragem = :quilometragem, cor = :cor, combustivel = :combustivel,
             cambio = :cambio, versao = :versao, informacoes_adicionais = :informacoes_adicionais
             WHERE id = :id'
        );
        return $statement->execute($this->valores($carro) + ['id' => $carro->getId()]);
    }

    public function excluir(int $id): bool
    {
        $statement = $this->database->prepare('DELETE FROM carros WHERE id = :id');
        return $statement->execute(['id' => $id]);
    }

    /** @return array<string, mixed> */
    private function valores(CarroEntity $carro): array
    {
        return [
            'marca' => $carro->getMarca(),
            'modelo' => $carro->getModelo(),
            'ano' => $carro->getAno(),
            'preco' => $carro->getPreco(),
            'imagem' => $carro->getImagem(),
            'descricao' => $carro->getDescricao(),
            'status' => $carro->getStatus(),
            'quilometragem' => $carro->getQuilometragem(),
            'cor' => $carro->getCor(),
            'combustivel' => $carro->getCombustivel(),
            'cambio' => $carro->getCambio(),
            'versao' => $carro->getVersao(),
            'informacoes_adicionais' => $carro->getInformacoesAdicionais(),
        ];
    }

    /** @param array<string, mixed> $dados */
    private function hidratar(array $dados): CarroEntity
    {
        return new CarroEntity(
            (int) $dados['id'],
            $dados['marca'],
            $dados['modelo'],
            (int) $dados['ano'],
            (float) $dados['preco'],
            $dados['imagem'],
            $dados['descricao'],
            $dados['status'],
            $dados['quilometragem'] === null ? null : (int) $dados['quilometragem'],
            $dados['cor'],
            $dados['combustivel'],
            $dados['cambio'],
            $dados['versao'],
            $dados['informacoes_adicionais']
        );
    }
}
