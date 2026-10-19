<?php
declare(strict_types=1);

namespace Elite\Controllers;

use Elite\Core\Autenticacao;
use Elite\Core\Csrf;
use Elite\Models\AgendamentoTestDriveRepository;
use Elite\Models\InteracaoRepository;
use Elite\Models\UsuarioRepository;
use PDOException;
use Throwable;

final class PerfilController
{
    private const TEMPO_EDICAO_SEGUNDOS = 300;

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

        $autorizacaoEdicao = $_SESSION['perfil_edicao_autorizada_em'] ?? null;
        $edicaoAutorizada = is_int($autorizacaoEdicao)
            && time() - $autorizacaoEdicao <= self::TEMPO_EDICAO_SEGUNDOS;
        if (!$edicaoAutorizada) {
            unset($_SESSION['perfil_edicao_autorizada_em']);
        }

        if ($repositorio !== null && $_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::validar($_POST['csrf_token'] ?? null)) {
                $erros[] = 'A sessão do formulário expirou. Atualize a página e tente novamente.';
            } else {
                $acao = is_string($_POST['acao'] ?? null) ? $_POST['acao'] : '';

                if ($acao === 'confirmar_senha') {
                    $senhaAtual = is_string($_POST['senha_atual'] ?? null) ? $_POST['senha_atual'] : '';
                    try {
                        if ($senhaAtual !== '' && $repositorio->senhaConfere($usuarioId, $senhaAtual)) {
                            session_regenerate_id(true);
                            $_SESSION['perfil_edicao_autorizada_em'] = time();
                            $_SESSION['perfil_mensagem'] = 'Senha confirmada. Você pode editar seus dados.';
                            header('Location: perfil.php');
                            exit;
                        }
                        $erros[] = 'A senha informada não confere.';
                    } catch (Throwable $exception) {
                        error_log($exception->getMessage());
                        $erros[] = 'Não foi possível confirmar sua senha agora.';
                    }
                } elseif ($acao === 'cancelar_edicao') {
                    unset($_SESSION['perfil_edicao_autorizada_em']);
                    header('Location: perfil.php');
                    exit;
                } elseif ($acao === 'salvar_perfil') {
                    if (!$edicaoAutorizada) {
                        $erros[] = 'Confirme sua senha atual antes de alterar os dados.';
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
                                unset($_SESSION['perfil_edicao_autorizada_em']);
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
                } else {
                    $erros[] = 'Ação de perfil inválida.';
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

        $ultimoCarro = null;
        try {
            $historico = (new InteracaoRepository())->listarHistorico($usuarioId);
            $ultimoCarro = $historico[0] ?? null;
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
        }

        $agendamentos = [];
        try {
            $agendamentos = (new AgendamentoTestDriveRepository())->listarPorUsuario($usuarioId);
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            $erros[] = 'Não foi possível carregar seus agendamentos.';
        }

        $csrfToken = Csrf::token();
        require dirname(__DIR__) . '/Views/usuarios/perfil.php';
    }
}
