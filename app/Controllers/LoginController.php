<?php
declare(strict_types=1);

namespace LuxCars\Controllers;

use LuxCars\Models\UsuarioRepository;
use Throwable;

final class LoginController
{
    public function index(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (isset($_SESSION['usuario_id'])) {
            header('Location: homepage.php');
            exit;
        }

        $erro = null;
        $email = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $valorEmail = $_POST['email'] ?? '';
            $valorSenha = $_POST['senha'] ?? '';
            $email = is_string($valorEmail) ? trim($valorEmail) : '';
            $senha = is_string($valorSenha) ? $valorSenha : '';

            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $senha === '') {
                $erro = 'Informe um e-mail e uma senha válidos.';
            } else {
                try {
                    $usuario = (new UsuarioRepository())->autenticar($email, $senha);
                    if ($usuario === null) {
                        $erro = 'E-mail ou senha incorretos.';
                    } else {
                        session_regenerate_id(true);
                        unset($_SESSION['csrf_token']);
                        $_SESSION['usuario_id'] = (int) $usuario['id'];
                        $_SESSION['usuario_tipo'] = (string) $usuario['tipo'];
                        // Algumas páginas antigas imprimem esse valor diretamente; guarde-o seguro para HTML.
                        $_SESSION['usuario'] = htmlspecialchars((string) $usuario['nome'], ENT_QUOTES, 'UTF-8');
                        header('Location: homepage.php');
                        exit;
                    }
                } catch (Throwable $exception) {
                    error_log($exception->getMessage());
                    $erro = 'Não foi possível validar o login agora. Tente novamente mais tarde.';
                }
            }
        }

        require dirname(__DIR__) . '/Views/usuarios/login.php';
    }
}
