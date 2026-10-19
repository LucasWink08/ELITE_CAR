<?php
declare(strict_types=1);

namespace Elite\Controllers;

use Elite\Core\Autenticacao;
use Elite\Models\InteracaoRepository;
use Throwable;

final class HistoricoController
{
    public function index(): void
    {
        Autenticacao::exigirLogin();
        $erro = null;
        try {
            $carros = (new InteracaoRepository())->listarHistorico((int) $_SESSION['usuario_id']);
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            $carros = [];
            $erro = 'Não foi possível carregar seu histórico de veículos.';
        }
        $titulo = 'Veículos vistos recentemente';
        require dirname(__DIR__) . '/Views/usuarios/historico.php';
    }
}
