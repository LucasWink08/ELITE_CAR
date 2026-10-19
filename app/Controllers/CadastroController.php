<?php
declare(strict_types=1);

namespace Elite\Controllers;

use Elite\Models\Usuario;
use Elite\Models\UsuarioRepository;
use PDOException;
use Throwable;

final class CadastroController
{
    public function index(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $erros = [];
        $sucesso = $_SESSION['cadastro_sucesso'] ?? null;
        unset($_SESSION['cadastro_sucesso']);

        $campos = ['nome', 'cpf', 'data_nascimento', 'email', 'telefone', 'endereco', 'numero_endereco', 'cidade', 'estado'];
        $dados = array_fill_keys($campos, '');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($campos as $campo) {
                $valor = $_POST[$campo] ?? '';
                $dados[$campo] = is_scalar($valor) ? trim((string) $valor) : '';
            }
            $senha = is_string($_POST['senha'] ?? null) ? $_POST['senha'] : '';
            $confirmacaoSenha = is_string($_POST['confirmacao_senha'] ?? null) ? $_POST['confirmacao_senha'] : '';

            foreach ($campos as $campo) {
                if ($dados[$campo] === '') {
                    $erros[] = 'Preencha todos os campos obrigatórios.';
                    break;
                }
            }

            if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
                $erros[] = 'Informe um endereço de e-mail válido.';
            }

            $cpf = preg_replace('/\D+/', '', $dados['cpf']) ?? '';
            if (!$this->cpfValido($cpf)) {
                $erros[] = 'Informe um CPF válido.';
            }

            $telefone = preg_replace('/\D+/', '', $dados['telefone']) ?? '';
            if (!preg_match('/^\d{10,11}$/', $telefone)) {
                $erros[] = 'Informe um telefone com DDD, contendo 10 ou 11 dígitos.';
            }

            if (!$this->dataValida($dados['data_nascimento'])) {
                $erros[] = 'Informe uma data de nascimento válida.';
            } elseif (!$this->maiorDeIdade($dados['data_nascimento'])) {
                $erros[] = 'O cadastro está disponível somente para pessoas com 18 anos ou mais.';
            }

            if ($this->comprimento($senha) < 8) {
                $erros[] = 'A senha deve ter pelo menos 8 caracteres.';
            }
            if ($senha !== $confirmacaoSenha) {
                $erros[] = 'A confirmação precisa ser igual à senha.';
            }

            if ($dados['estado'] !== '' && !preg_match('/^[A-Za-z]{2}$/', $dados['estado'])) {
                $erros[] = 'Informe a sigla do estado com duas letras.';
            }

            if ($erros === []) {
                try {
                    $usuario = new Usuario(
                        null,
                        $dados['nome'],
                        $dados['email'],
                        $cpf,
                        $dados['data_nascimento'],
                        $senha,
                        $telefone,
                        $dados['endereco'],
                        $dados['numero_endereco'],
                        $dados['cidade'],
                        strtoupper($dados['estado'])
                    );
                    $usuarioId = (new UsuarioRepository())->inserir($usuario);
                    session_regenerate_id(true);
                    unset($_SESSION['csrf_token']);
                    $_SESSION['usuario_id'] = $usuarioId;
                    $_SESSION['usuario_tipo'] = 'cliente';
                    $_SESSION['usuario'] = htmlspecialchars($dados['nome'], ENT_QUOTES, 'UTF-8');
                    header('Location: homepage.php');
                    exit;
                } catch (PDOException $exception) {
                    if ((string) $exception->getCode() === '23000') {
                        $erros[] = 'Já existe uma conta cadastrada com esse CPF ou e-mail.';
                    } else {
                        error_log($exception->getMessage());
                        $erros[] = 'Não foi possível concluir o cadastro agora. Tente novamente mais tarde.';
                    }
                } catch (Throwable $exception) {
                    error_log($exception->getMessage());
                    $erros[] = 'Não foi possível concluir o cadastro agora. Tente novamente mais tarde.';
                }
            }
        }

        require dirname(__DIR__) . '/Views/usuarios/cadastro.php';
    }

    private function cpfValido(string $cpf): bool
    {
        if (strlen($cpf) !== 11 || preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false;
        }

        for ($posicao = 9; $posicao <= 10; $posicao++) {
            $soma = 0;
            for ($i = 0; $i < $posicao; $i++) {
                $soma += (int) $cpf[$i] * (($posicao + 1) - $i);
            }
            $resto = ($soma * 10) % 11;
            $digito = $resto === 10 ? 0 : $resto;
            if ((int) $cpf[$posicao] !== $digito) {
                return false;
            }
        }

        return true;
    }

    private function dataValida(string $data): bool
    {
        $dataObjeto = \DateTimeImmutable::createFromFormat('!Y-m-d', $data);
        $errosData = \DateTimeImmutable::getLastErrors();
        if ($dataObjeto === false || $dataObjeto->format('Y-m-d') !== $data) {
            return false;
        }
        if ($errosData !== false && ($errosData['warning_count'] > 0 || $errosData['error_count'] > 0)) {
            return false;
        }

        return $dataObjeto <= new \DateTimeImmutable('today');
    }

    private function maiorDeIdade(string $dataNascimento): bool
    {
        $limite = (new \DateTimeImmutable('today'))->modify('-18 years');
        return $dataNascimento <= $limite->format('Y-m-d');
    }

    private function comprimento(string $texto): int
    {
        $quantidade = preg_match_all('/./us', $texto);
        return $quantidade === false ? strlen($texto) : $quantidade;
    }
}
