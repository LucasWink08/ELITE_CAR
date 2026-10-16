<?php
declare(strict_types=1);

namespace LuxCars\Controllers;

use LuxCars\Core\Csrf;
use LuxCars\Models\MensagemContatoRepository;
use Throwable;

final class ContatoController
{
    public function index(): void
    {
        $campos = ['nome', 'email', 'assunto', 'mensagem'];
        $dados = array_fill_keys($campos, '');
        $erros = [];
        $sucesso = $_SESSION['contato_sucesso'] ?? null;
        unset($_SESSION['contato_sucesso']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($campos as $campo) {
                $valor = $_POST[$campo] ?? '';
                $dados[$campo] = is_string($valor) ? trim($valor) : '';
            }

            if (!Csrf::validar($_POST['csrf_token'] ?? null)) {
                $erros[] = 'O formulário expirou. Atualize a página e tente novamente.';
            } elseif (!empty($_POST['website'])) {
                // Campo-armadilha antispam: não armazena a mensagem do bot.
                $_SESSION['contato_sucesso'] = 'Sua mensagem foi registrada com sucesso.';
                header('Location: contato.php');
                exit;
            } else {
                if ($this->comprimento($dados['nome']) < 2 || $this->comprimento($dados['nome']) > 150) {
                    $erros[] = 'Informe seu nome (de 2 a 150 caracteres).';
                }
                if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL) || $this->comprimento($dados['email']) > 190) {
                    $erros[] = 'Informe um e-mail válido.';
                }
                if ($this->comprimento($dados['assunto']) < 3 || $this->comprimento($dados['assunto']) > 160) {
                    $erros[] = 'O assunto deve ter de 3 a 160 caracteres.';
                }
                if ($this->comprimento($dados['mensagem']) < 10 || $this->comprimento($dados['mensagem']) > 5000) {
                    $erros[] = 'A mensagem deve ter de 10 a 5000 caracteres.';
                }

                if ($erros === []) {
                    try {
                        (new MensagemContatoRepository())->inserir(
                            $dados['nome'],
                            $dados['email'],
                            $dados['assunto'],
                            $dados['mensagem']
                        );
                        $_SESSION['contato_sucesso'] = 'Sua mensagem foi registrada com sucesso.';
                        header('Location: contato.php');
                        exit;
                    } catch (Throwable $exception) {
                        error_log($exception->getMessage());
                        $erros[] = 'Não foi possível registrar sua mensagem agora. Tente novamente mais tarde.';
                    }
                }
            }
        }

        $csrfToken = Csrf::token();
        require dirname(__DIR__) . '/Views/contato/index.php';
    }

    private function comprimento(string $valor): int
    {
        $quantidade = preg_match_all('/./us', $valor);
        return $quantidade === false ? strlen($valor) : $quantidade;
    }
}
