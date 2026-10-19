<?php
declare(strict_types=1);

namespace Elite\Core;

final class Autenticacao
{
    private function __construct()
    {
    }

    public static function exigirLogin(string $destinoLogin = 'entrar.php'): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['usuario_id']) || !is_int($_SESSION['usuario_id'])) {
            header('Location: ' . $destinoLogin);
            exit;
        }
    }

    public static function exigirAdministrador(): void
    {
        self::exigirLogin();

        try {
            $administrador = (new \Elite\Models\UsuarioRepository())
                ->ehAdministrador((int) $_SESSION['usuario_id']);
        } catch (\Throwable $exception) {
            error_log($exception->getMessage());
            http_response_code(503);
            exit('NÃ£o foi possÃ­vel validar o acesso administrativo. Tente novamente.');
        }

        if (!$administrador) {
            http_response_code(403);
            exit('Acesso restrito a administradores.');
        }
    }
}
