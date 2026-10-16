<?php
declare(strict_types=1);

namespace LuxCars\Controllers;

use LuxCars\Core\Autenticacao;
use LuxCars\Core\Csrf;
use LuxCars\Models\InteracaoRepository;
use Throwable;

final class ComparacaoController
{
    public function index(): void
    {
        Autenticacao::exigirLogin();
        $usuarioId = (int) $_SESSION['usuario_id'];
        $erro = null;
        $mensagem = $_SESSION['comparacao_mensagem'] ?? null;
        unset($_SESSION['comparacao_mensagem']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $acao = is_string($_POST['acao'] ?? null) ? $_POST['acao'] : '';
            $id = filter_var($_POST['carro_id'] ?? null, FILTER_VALIDATE_INT);
            if (!Csrf::validar($_POST['csrf_token'] ?? null)) {
                $erro = 'A sessão expirou. Atualize a página e tente novamente.';
            } elseif ($acao !== 'limpar' && ($id === false || $id === null || $id < 1)) {
                $erro = 'Veículo inválido.';
            } else {
                try {
                    $repo = new InteracaoRepository();
                    if ($acao === 'adicionar') {
                        $resultado = $repo->adicionarComparacao($usuarioId, $id);
                        $mensagemAcao = match ($resultado) {
                            'ok' => 'Veículo incluído na comparação.',
                            'limite' => 'A comparação permite no máximo três veículos.',
                            default => 'O veículo não está disponível para comparação.',
                        };
                        if ($resultado === 'ok') {
                            $_SESSION['comparacao_mensagem'] = $mensagemAcao;
                            header('Location: comparar.php');
                            exit;
                        }
                        $erro = $mensagemAcao;
                    } elseif ($acao === 'remover') {
                        $repo->removerComparacao($usuarioId, $id);
                        $_SESSION['comparacao_mensagem'] = 'Veículo removido da comparação.';
                        header('Location: comparar.php');
                        exit;
                    } elseif ($acao === 'limpar') {
                        $repo->limparComparacao($usuarioId);
                        $_SESSION['comparacao_mensagem'] = 'Lista de comparação limpa.';
                        header('Location: comparar.php');
                        exit;
                    } else {
                        $erro = 'Ação inválida.';
                    }
                } catch (Throwable $exception) {
                    error_log($exception->getMessage());
                    $erro = 'Não foi possível atualizar a comparação agora.';
                }
            }
        }

        try {
            $carros = (new InteracaoRepository())->listarComparacao($usuarioId);
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            $carros = [];
            $erro ??= 'Não foi possível carregar a comparação.';
        }
        $csrfToken = Csrf::token();
        $titulo = 'Comparar veículos';
        $modo = 'comparacao';
        require dirname(__DIR__) . '/Views/usuarios/lista_carros.php';
    }
}
