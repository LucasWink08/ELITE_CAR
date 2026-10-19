<?php
declare(strict_types=1);

namespace Elite\Controllers;

use Elite\Core\Autenticacao;
use Elite\Core\Csrf;
use Elite\Models\Carro;
use Elite\Models\InteracaoRepository;
use Throwable;

final class PagamentoController
{
    public function index(): void
    {
        $carro = null;
        $erroBanco = null;
        $erroIntencao = null;
        $mensagemIntencao = $_SESSION['intencao_mensagem'] ?? null;
        unset($_SESSION['intencao_mensagem']);
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Autenticacao::exigirLogin();
            $idPost = filter_var($_POST['carro_id'] ?? null, FILTER_VALIDATE_INT);
            $mensagem = $_POST['mensagem'] ?? '';
            if (!Csrf::validar($_POST['csrf_token'] ?? null)) {
                $erroIntencao = 'A sessão expirou. Atualize a página e tente novamente.';
            } elseif ($idPost === false || $idPost === null || $idPost < 1 || $idPost !== $id) {
                $erroIntencao = 'Veículo inválido para registrar interesse.';
            } elseif (!is_string($mensagem) || strlen(trim($mensagem)) > 1000) {
                $erroIntencao = 'A mensagem deve ter até 1000 caracteres.';
            } else {
                try {
                    if (!(new InteracaoRepository())->registrarIntencao((int) $_SESSION['usuario_id'], $idPost, trim($mensagem))) {
                        $erroIntencao = 'O veículo não está disponível para registrar interesse.';
                    } else {
                        $_SESSION['intencao_mensagem'] = 'Interesse enviado. A equipe poderá entrar em contato pelos dados do seu perfil.';
                        header('Location: pagamento.php?id=' . $idPost);
                        exit;
                    }
                } catch (Throwable $exception) {
                    error_log($exception->getMessage());
                    $erroIntencao = 'Não foi possível enviar sua intenção agora.';
                }
            }
        }

        $csrfToken = Csrf::token();

        if ($id !== false && $id !== null && $id > 0) {
            try {
                $encontrado = (new Carro())->buscarPorId($id);
                if ($encontrado !== null && $encontrado->getStatus() === 'disponivel') {
                    $carro = $encontrado;
                }
            } catch (Throwable $exception) {
                error_log($exception->getMessage());
                $erroBanco = 'Não foi possível carregar as condições deste veículo agora.';
            }
        }

        require dirname(__DIR__) . '/Views/pagamento/index.php';
    }
}
