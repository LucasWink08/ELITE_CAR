<?php
declare(strict_types=1);

namespace LuxCars\Core;

use PDO;
use PDOException;

final class Conexao
{
    private static ?PDO $conexao = null;

    private function __construct()
    {
    }

    public static function obterConexao(): PDO
    {
        if (self::$conexao instanceof PDO) {
            return self::$conexao;
        }

        $host = getenv('LUXCARS_DB_HOST') ?: '127.0.0.1';
        $port = getenv('LUXCARS_DB_PORT') ?: '3306';
        $nome = getenv('LUXCARS_DB_NAME') ?: 'luxcars';
        $usuario = getenv('LUXCARS_DB_USER') ?: 'root';
        $senha = getenv('LUXCARS_DB_PASSWORD') ?: '';
        $dsn = "mysql:host={$host};port={$port};dbname={$nome};charset=utf8mb4";

        try {
            self::$conexao = new PDO($dsn, $usuario, $senha, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $exception) {
            throw new PDOException('Não foi possível conectar ao MySQL/MariaDB da LuxCars.', 0, $exception);
        }

        return self::$conexao;
    }
}
