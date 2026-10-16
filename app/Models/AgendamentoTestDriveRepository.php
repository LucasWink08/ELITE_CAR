<?php
declare(strict_types=1);

namespace LuxCars\Models;

use LuxCars\Core\Conexao;
use PDO;

final class AgendamentoTestDriveRepository
{
    private PDO $database;

    public function __construct(?PDO $database = null)
    {
        $this->database = $database ?? Conexao::obterConexao();
    }

    /** @param array{nome:string,email:string,telefone:string,carro_id:int,usuario_id:?int,data:string,horario:string} $dados */
    public function reservar(array $dados): void
    {
        $statement = $this->database->prepare(
            'INSERT INTO agendamentos_test_drive
                (usuario_id, carro_id, nome, email, telefone, data_agendamento, horario)
             VALUES
                (:usuario_id, :carro_id, :nome, :email, :telefone, :data_agendamento, :horario)'
        );
        $statement->execute([
            'usuario_id' => $dados['usuario_id'],
            'carro_id' => $dados['carro_id'],
            'nome' => $dados['nome'],
            'email' => $dados['email'],
            'telefone' => $dados['telefone'],
            'data_agendamento' => $dados['data'],
            'horario' => $dados['horario'],
        ]);
    }

    /** @return array<int, array<string, mixed>> */
    public function listarRecentes(): array
    {
        $statement = $this->database->query(
            'SELECT a.id, a.nome, a.email, a.telefone, a.data_agendamento, a.horario, a.status,
                    c.marca, c.modelo
             FROM agendamentos_test_drive a
             INNER JOIN carros c ON c.id = a.carro_id
             ORDER BY a.data_agendamento DESC, a.horario DESC, a.id DESC
             LIMIT 100'
        );
        return $statement->fetchAll();
    }
}
