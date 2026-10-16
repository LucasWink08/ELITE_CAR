<?php
declare(strict_types=1);

namespace LuxCars\Controllers;

use LuxCars\Core\Autenticacao;
use LuxCars\Core\Csrf;
use LuxCars\Models\InteracaoRepository;
use Throwable;

final class FavoritosController
{
    public function index(): void
    {
        Autenticacao::exigirLogin();
        $usuarioId = (int) $_SESSION['usuario_id'];
        $erro = null;
        $mensagem = $_SESSION['interacao_mensagem'] ?? null;
        unset($_SESSION['interacao_mensagem']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_var($_POST['carro_id'] ?? null, FILTER_VALIDATE_INT);
            if (!Csrf::validar($_POST['csrf_token'] ?? null)) {
                $erro = 'A sessão expirou. Atualize a página e tente novamente.';
            } elseif ($id === false || $id === null || $id < 1) {
                $erro = 'Veículo inválido.';
            } else {
                try {
                    $repo = new InteracaoRepository();
                    $acao = $_POST['acao'] ?? '';
                    $ok = $acao === 'adicionar'
                        ? $repo->favoritar($usuarioId, $id)
                        : ($acao === 'remover' ? $repo->desfavoritar($usuarioId, $id) : false);
                    if (!$ok && $acao !== 'remover') {
                        $erro = 'Não foi possível adicionar este veículo aos favoritos.';
                    } else {
                        $_SESSION['interacao_mensagem'] = $acao === 'adicionar' ? 'Veículo salvo nos favoritos.' : 'Veículo removido dos favoritos.';
                        header('Location: favoritos.php');
                        exit;
                    }
                } catch (Throwable $exception) {
                    error_log($exception->getMessage());
                    $erro = 'Não foi possível atualizar os favoritos agora.';
                }
            }
        }

        try {
            $carros = (new InteracaoRepository())->listarFavoritos($usuarioId);
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            $carros = [];
            $erro ??= 'Não foi possível carregar seus favoritos.';
        }
        $csrfToken = Csrf::token();
        $titulo = 'Meus favoritos';
        $modo = 'favoritos';
        require dirname(__DIR__) . '/Views/usuarios/lista_carros.php';
    }
}
