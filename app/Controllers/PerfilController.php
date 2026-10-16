<?php
declare(strict_types=1);

namespace LuxCars\Controllers;

use LuxCars\Core\Autenticacao;
use LuxCars\Core\Csrf;
use LuxCars\Models\InteracaoRepository;
use LuxCars\Models\UsuarioRepository;
use PDOException;
use Throwable;

final class PerfilController
{
    public function index(): void
    {
        Autenticacao::exigirLogin();
        $usuarioId = (int) $_SESSION['usuario_id'];
        $erros = [];
        $mensagem = $_SESSION['perfil_mensagem'] ?? null;
        unset($_SESSION['perfil_mensagem']);
        try {
            $repositorio = new UsuarioRepository();
            $dados = $repositorio->buscarPorId($usuarioId);
            if ($dados === null) {
                $repositorio = null;
                $dados = [];
                $erros[] = 'A conta não foi encontrada. Saia e entre novamente.';
            }
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            $repositorio = null;
            $dados = [];
            $erros[] = 'Não foi possível carregar os dados do perfil.';
        }

        if ($repositorio !== null && $_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::validar($_POST['csrf_token'] ?? null)) {
                $erros[] = 'A sessão do formulário expirou. Atualize a página e tente novamente.';
            } else {
                foreach (['nome', 'email', 'telefone', 'endereco', 'numero_endereco', 'cidade', 'estado'] as $campo) {
                    $valor = $_POST[$campo] ?? '';
                    $dados[$campo] = is_scalar($valor) ? trim((string) $valor) : '';
                }
                $telefone = preg_replace('/\D+/', '', $dados['telefone']) ?? '';
                if ($dados['nome'] === '' || strlen($dados['nome']) > 150) {
                    $erros[] = 'Informe um nome com até 150 caracteres.';
                }
                if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL) || strlen($dados['email']) > 190) {
                    $erros[] = 'Informe um e-mail válido.';
                }
                if (!preg_match('/^\d{10,11}$/', $telefone)) {
                    $erros[] = 'Informe um telefone com DDD.';
                }
                foreach (['endereco' => 180, 'numero_endereco' => 20, 'cidade' => 100] as $campo => $limite) {
                    if ($dados[$campo] === '' || strlen($dados[$campo]) > $limite) {
                        $erros[] = 'Revise o endereço, número e cidade.';
                        break;
                    }
                }
                if (!preg_match('/^[A-Za-z]{2}$/', $dados['estado'])) {
                    $erros[] = 'Informe a sigla do estado com duas letras.';
                }

                if ($erros === []) {
                    try {
                        $dados['telefone'] = $telefone;
                        $repositorio->atualizarPerfil($usuarioId, $dados);
                        $_SESSION['perfil_mensagem'] = 'Dados do perfil atualizados.';
                        $_SESSION['usuario'] = htmlspecialchars($dados['nome'], ENT_QUOTES, 'UTF-8');
                        header('Location: perfil.php');
                        exit;
                    } catch (PDOException $exception) {
                        if ((string) $exception->getCode() === '23000') {
                            $erros[] = 'Este e-mail já está cadastrado em outra conta.';
                        } else {
                            error_log($exception->getMessage());
                            $erros[] = 'Não foi possível salvar as alterações agora.';
                        }
                    } catch (Throwable $exception) {
                        error_log($exception->getMessage());
                        $erros[] = 'Não foi possível salvar as alterações agora.';
                    }
                }
            }
        }

        $intencoes = [];
        try {
            $intencoes = (new InteracaoRepository())->listarIntencoes($usuarioId);
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            $erros[] = 'Não foi possível carregar as intenções de compra.';
        }
        $csrfToken = Csrf::token();
        require dirname(__DIR__) . '/Views/usuarios/perfil.php';
    }
}
