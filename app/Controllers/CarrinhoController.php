<?php
declare(strict_types=1);

namespace Elite\Controllers;

use Elite\Core\Autenticacao;
use Elite\Core\Csrf;
use Elite\Models\CarrinhoRepository;
use Throwable;

final class CarrinhoController
{
    public function index(): void
    {
        Autenticacao::exigirLogin();
        $usuarioId = (int) $_SESSION['usuario_id'];
        $erro = null;
        $mensagem = $_SESSION['carrinho_mensagem'] ?? null;
        unset($_SESSION['carrinho_mensagem']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? null;
            if (!Csrf::validar($token)) {
                $erro = 'A solicitação expirou. Atualize a página e tente novamente.';
            } else {
                $acao = is_string($_POST['acao'] ?? null) ? $_POST['acao'] : '';
                $carroId = filter_var($_POST['carro_id'] ?? null, FILTER_VALIDATE_INT);
                try {
                    $repositorio = new CarrinhoRepository();
                    if ($acao === 'adicionar' && $carroId !== false && $carroId !== null && $carroId > 0) {
                        if (!$repositorio->adicionar($usuarioId, $carroId)) {
                            throw new \DomainException('Este veículo não está disponível para adicionar ao carrinho.');
                        }
                        $_SESSION['carrinho_mensagem'] = 'Veículo adicionado ao carrinho.';
                    } elseif ($acao === 'remover' && $carroId !== false && $carroId !== null && $carroId > 0) {
                        if (!$repositorio->remover($usuarioId, $carroId)) {
                            throw new \DomainException('O veículo não foi encontrado no seu carrinho.');
                        }
                        $_SESSION['carrinho_mensagem'] = 'Veículo removido do carrinho.';
                    } elseif ($acao === 'atualizar' && $carroId !== false && $carroId !== null && $carroId > 0) {
                        $quantidade = filter_var($_POST['quantidade'] ?? null, FILTER_VALIDATE_INT);
                        if ($quantidade === false || $quantidade === null || $quantidade < 1 || $quantidade > 99) {
                            throw new \DomainException('Informe uma quantidade entre 1 e 99.');
                        }
                        if (!$repositorio->alterarQuantidade($usuarioId, $carroId, $quantidade)) {
                            throw new \DomainException('O veículo não foi encontrado no seu carrinho.');
                        }
                        $_SESSION['carrinho_mensagem'] = 'Quantidade atualizada.';
                    } elseif ($acao === 'limpar') {
                        $repositorio->limpar($usuarioId);
                        $_SESSION['carrinho_mensagem'] = 'Carrinho limpo.';
                    } else {
                        throw new \DomainException('A ação solicitada não é válida.');
                    }

                    header('Location: carrinho.php');
                    exit;
                } catch (\DomainException $exception) {
                    $erro = $exception->getMessage();
                } catch (Throwable $exception) {
                    error_log($exception->getMessage());
                    $erro = 'Não foi possível atualizar o carrinho agora. Tente novamente.';
                }
            }
        }

        $itens = [];
        $total = 0.0;
        try {
            $itens = (new CarrinhoRepository())->listar($usuarioId);
            foreach ($itens as $item) {
                $total += (float) $item['subtotal'];
            }
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            $erro ??= 'Não foi possível carregar o carrinho agora. Tente novamente.';
        }

        $csrfToken = Csrf::token();
        require dirname(__DIR__) . '/Views/carrinho/index.php';
    }
}
