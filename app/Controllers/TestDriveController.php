<?php
declare(strict_types=1);

namespace LuxCars\Controllers;

use DateTimeImmutable;
use DateTimeZone;
use LuxCars\Core\Csrf;
use LuxCars\Models\AgendamentoTestDriveRepository;
use LuxCars\Models\Carro;
use PDOException;
use Throwable;

final class TestDriveController
{
    private const HORARIOS = ['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00', '17:00'];

    public function index(): void
    {
        $dados = ['nome' => '', 'email' => '', 'telefone' => '', 'carro_id' => '', 'data' => '', 'horario' => ''];
        $erros = [];
        $sucesso = $_SESSION['test_drive_sucesso'] ?? null;
        unset($_SESSION['test_drive_sucesso']);
        $carros = [];
        $erroBanco = null;

        try {
            $carros = (new Carro())->listarDisponiveis();
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            $erroBanco = 'N&atilde;o foi poss&iacute;vel carregar os ve&iacute;culos. Tente novamente mais tarde.';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach (['nome', 'email', 'telefone', 'carro_id', 'data', 'horario'] as $campo) {
                $valor = $_POST[$campo] ?? '';
                $dados[$campo] = is_string($valor) ? trim($valor) : '';
            }

            if (!Csrf::validar($_POST['csrf_token'] ?? null)) {
                $erros[] = 'O formul&aacute;rio expirou. Atualize a p&aacute;gina e tente novamente.';
            } elseif (!empty($_POST['website'])) {
                $_SESSION['test_drive_sucesso'] = 'Solicita&ccedil;&atilde;o recebida. Nossa equipe entrar&aacute; em contato para confirmar o test drive.';
                header('Location: seguroveic.php');
                exit;
            } else {
                if ($this->comprimento($dados['nome']) < 2 || $this->comprimento($dados['nome']) > 150) {
                    $erros[] = 'Informe seu nome (de 2 a 150 caracteres).';
                }
                if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL) || strlen($dados['email']) > 190) {
                    $erros[] = 'Informe um e-mail v&aacute;lido.';
                }
                $telefone = preg_replace('/\D+/', '', $dados['telefone']) ?? '';
                if (strlen($telefone) < 10 || strlen($telefone) > 13) {
                    $erros[] = 'Informe um telefone com DDD.';
                }

                $carroId = filter_var($dados['carro_id'], FILTER_VALIDATE_INT);
                $carroSelecionado = $carroId !== false && $carroId !== null && $carroId > 0
                    ? $this->carroDisponivel($carros, $carroId)
                    : null;
                if ($carroSelecionado === null) {
                    $erros[] = 'Selecione um ve&iacute;culo dispon&iacute;vel no cat&aacute;logo.';
                }

                $data = DateTimeImmutable::createFromFormat('!Y-m-d', $dados['data'], new DateTimeZone('America/Sao_Paulo'));
                $hoje = new DateTimeImmutable('today', new DateTimeZone('America/Sao_Paulo'));
                $dataValida = $data !== false && $data->format('Y-m-d') === $dados['data'];
                if (!$dataValida || $data < $hoje || (int) $data->format('N') === 7) {
                    $erros[] = 'Escolha uma data futura ou hoje, de segunda a s&aacute;bado.';
                }
                if (!in_array($dados['horario'], self::HORARIOS, true)) {
                    $erros[] = 'Escolha um hor&aacute;rio dispon&iacute;vel entre 9h e 17h.';
                }
                if ($dataValida && $data->format('Y-m-d') === $hoje->format('Y-m-d') && $dados['horario'] <= (new DateTimeImmutable('now', new DateTimeZone('America/Sao_Paulo')))->format('H:i')) {
                    $erros[] = 'Para hoje, escolha um hor&aacute;rio que ainda n&atilde;o passou.';
                }

                if ($erros === [] && $carroSelecionado !== null && $carroId !== false && $dataValida) {
                    try {
                        (new AgendamentoTestDriveRepository())->reservar([
                            'nome' => $dados['nome'],
                            'email' => $dados['email'],
                            'telefone' => $telefone,
                            'carro_id' => $carroId,
                            'usuario_id' => isset($_SESSION['usuario_id']) && is_numeric($_SESSION['usuario_id']) ? (int) $_SESSION['usuario_id'] : null,
                            'data' => $dados['data'],
                            'horario' => $dados['horario'] . ':00',
                        ]);
                        $_SESSION['test_drive_sucesso'] = 'Solicita&ccedil;&atilde;o recebida. Nossa equipe entrar&aacute; em contato para confirmar o test drive.';
                        header('Location: seguroveic.php');
                        exit;
                    } catch (PDOException $exception) {
                        if ($exception->getCode() === '23000') {
                            $erros[] = 'Esse hor&aacute;rio para o ve&iacute;culo j&aacute; foi solicitado. Escolha outro hor&aacute;rio.';
                        } else {
                            error_log($exception->getMessage());
                            $erros[] = 'N&atilde;o foi poss&iacute;vel registrar o agendamento agora. Tente mais tarde.';
                        }
                    } catch (Throwable $exception) {
                        error_log($exception->getMessage());
                        $erros[] = 'N&atilde;o foi poss&iacute;vel registrar o agendamento agora. Tente mais tarde.';
                    }
                }
            }
        }

        $csrfToken = Csrf::token();
        $horarios = self::HORARIOS;
        $dataMinima = (new DateTimeImmutable('today', new DateTimeZone('America/Sao_Paulo')))->format('Y-m-d');
        require dirname(__DIR__) . '/Views/test_drive/index.php';
    }

    /** @param array<int, \LuxCars\Entities\Carro> $carros */
    private function carroDisponivel(array $carros, int $id): ?\LuxCars\Entities\Carro
    {
        foreach ($carros as $carro) {
            if ($carro->getId() === $id) {
                return $carro;
            }
        }
        return null;
    }

    private function comprimento(string $valor): int
    {
        $quantidade = preg_match_all('/./us', $valor);
        return $quantidade === false ? strlen($valor) : $quantidade;
    }
}
