<?php
declare(strict_types=1);

namespace Elite\Controllers;

use Elite\Core\Autenticacao;
use Elite\Core\Csrf;
use Elite\Entities\Carro as CarroEntity;
use Elite\Models\Carro;
use Elite\Models\AgendamentoTestDriveRepository;
use Throwable;

final class AdminCarrosController
{
    public function index(): void
    {
        Autenticacao::exigirAdministrador();
        $erros = [];
        $mensagem = $_SESSION['admin_carros_mensagem'] ?? null;
        unset($_SESSION['admin_carros_mensagem']);
        try {
            $repo = new Carro();
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            $repo = null;
            $erros[] = 'Não foi possível conectar ao banco para abrir a administração.';
        }
        $idEdicao = filter_input(INPUT_GET, 'editar', FILTER_VALIDATE_INT);
        $carroEdicao = null;
        $dados = $this->dadosVazios();

        if ($repo !== null && $idEdicao !== false && $idEdicao !== null) {
            $carroEdicao = $idEdicao > 0 ? $repo->buscarPorId($idEdicao) : null;
            if ($carroEdicao === null) {
                $erros[] = 'Veículo não encontrado para edição.';
            } else {
                $dados = $this->dadosDaEntidade($carroEdicao);
            }
        }

        if ($repo !== null && $_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::validar($_POST['csrf_token'] ?? null)) {
                $erros[] = 'A sessão expirou. Atualize a página e tente novamente.';
            } else {
                $acao = is_string($_POST['acao'] ?? null) ? $_POST['acao'] : '';
                $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
                if ($acao === 'excluir') {
                    if ($id === false || $id === null || $id < 1) {
                        $erros[] = 'Veículo inválido para exclusão.';
                    } else {
                        try {
                            if ($repo->buscarPorId($id) === null) {
                                $erros[] = 'Veículo não encontrado.';
                            } elseif (!$repo->excluir($id)) {
                                $erros[] = 'Não foi possível excluir o veículo.';
                            } else {
                                $_SESSION['admin_carros_mensagem'] = 'Veículo excluído.';
                                header('Location: admin_carros.php');
                                exit;
                            }
                        } catch (Throwable $exception) {
                            error_log($exception->getMessage());
                            $erros[] = 'Não foi possível excluir o veículo agora.';
                        }
                    }
                } elseif ($acao === 'salvar') {
                    $dados = $this->lerDados($_POST);
                    if (($_POST['id'] ?? '') !== '' && ($id === false || $id === null || $id < 1)) {
                        $erros[] = 'Identificador de veículo inválido.';
                    }
                    $idForm = $id !== false && $id !== null && $id > 0 ? $id : null;
                    $carroEdicao = $idForm === null ? null : $repo->buscarPorId($idForm);
                    $erros = array_merge($erros, $this->validar($dados));
                    if ($idForm !== null && $carroEdicao === null) {
                        $erros[] = 'O veículo selecionado não existe mais.';
                    }

                    if ($erros === []) {
                        try {
                            $entidade = new CarroEntity(
                                $idForm,
                                $dados['marca'],
                                $dados['modelo'],
                                (int) $dados['ano'],
                                (float) $dados['preco'],
                                $this->nuloSeVazio($dados['imagem']),
                                $this->nuloSeVazio($dados['descricao']),
                                $dados['status'],
                                $dados['quilometragem'] === '' ? null : (int) $dados['quilometragem'],
                                $this->nuloSeVazio($dados['cor']),
                                $this->nuloSeVazio($dados['combustivel']),
                                $this->nuloSeVazio($dados['cambio']),
                                $this->nuloSeVazio($dados['versao']),
                                $this->nuloSeVazio($dados['informacoes_adicionais'])
                            );
                            $entidade->alterarStatus($dados['status']);
                            if ($idForm === null) {
                                $repo->inserir($entidade);
                                $_SESSION['admin_carros_mensagem'] = 'Veículo cadastrado.';
                            } else {
                                $repo->atualizar($entidade);
                                $_SESSION['admin_carros_mensagem'] = 'Veículo atualizado.';
                            }
                            header('Location: admin_carros.php');
                            exit;
                        } catch (Throwable $exception) {
                            error_log($exception->getMessage());
                            $erros[] = 'Não foi possível salvar o veículo. Confira os dados e tente novamente.';
                        }
                    }
                } else {
                    $erros[] = 'Ação administrativa inválida.';
                }
            }
        }

        try {
            $carros = $repo->listarTodos();
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            $carros = [];
            $erros[] = 'Não foi possível consultar os veículos.';
        }
        try {
            $agendamentosTestDrive = (new AgendamentoTestDriveRepository())->listarRecentes();
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            $agendamentosTestDrive = [];
            $erros[] = 'Nao foi possivel consultar as solicitacoes de test drive.';
        }
        $csrfToken = Csrf::token();
        require dirname(__DIR__) . '/Views/admin/carros.php';
    }

    private function dadosVazios(): array
    {
        $dados = array_fill_keys(['marca', 'modelo', 'ano', 'preco', 'imagem', 'descricao', 'status', 'quilometragem', 'cor', 'combustivel', 'cambio', 'versao', 'informacoes_adicionais'], '');
        $dados['status'] = 'disponivel';
        return $dados;
    }

    private function dadosDaEntidade(CarroEntity $carro): array
    {
        return [
            'marca' => $carro->getMarca(), 'modelo' => $carro->getModelo(), 'ano' => (string) $carro->getAno(),
            'preco' => (string) $carro->getPreco(), 'imagem' => $carro->getImagem() ?? '', 'descricao' => $carro->getDescricao() ?? '',
            'status' => $carro->getStatus(), 'quilometragem' => $carro->getQuilometragem() === null ? '' : (string) $carro->getQuilometragem(),
            'cor' => $carro->getCor() ?? '', 'combustivel' => $carro->getCombustivel() ?? '', 'cambio' => $carro->getCambio() ?? '',
            'versao' => $carro->getVersao() ?? '', 'informacoes_adicionais' => $carro->getInformacoesAdicionais() ?? '',
        ];
    }

    private function lerDados(array $entrada): array
    {
        $dados = $this->dadosVazios();
        foreach ($dados as $campo => $_) {
            $valor = $entrada[$campo] ?? '';
            $dados[$campo] = is_scalar($valor) ? trim((string) $valor) : '';
        }
        return $dados;
    }

    private function validar(array $dados): array
    {
        $erros = [];
        foreach (['marca' => 80, 'modelo' => 120] as $campo => $limite) {
            if ($dados[$campo] === '' || strlen($dados[$campo]) > $limite) {
                $erros[] = 'Marca e modelo são obrigatórios e devem respeitar os limites de tamanho.';
                break;
            }
        }
        $ano = filter_var($dados['ano'], FILTER_VALIDATE_INT);
        if ($ano === false || $ano < 1886 || $ano > (int) date('Y') + 1) {
            $erros[] = 'Informe um ano válido para o veículo.';
        }
        if (!is_numeric($dados['preco']) || (float) $dados['preco'] < 0 || (float) $dados['preco'] > 999999999999.99) {
            $erros[] = 'Informe um preço válido.';
        }
        if (!in_array($dados['status'], ['disponivel', 'indisponivel', 'vendido'], true)) {
            $erros[] = 'Selecione uma disponibilidade válida.';
        }
        if ($dados['quilometragem'] !== '' && (!ctype_digit($dados['quilometragem']) || (int) $dados['quilometragem'] < 0)) {
            $erros[] = 'A quilometragem deve ser um número inteiro positivo.';
        }
        foreach (['imagem' => 255, 'cor' => 60, 'combustivel' => 40, 'cambio' => 60, 'versao' => 100] as $campo => $limite) {
            if (strlen($dados[$campo]) > $limite) {
                $erros[] = 'Um dos campos opcionais excede o tamanho permitido.';
                break;
            }
        }
        return $erros;
    }

    private function nuloSeVazio(string $valor): ?string
    {
        return $valor === '' ? null : $valor;
    }
}
