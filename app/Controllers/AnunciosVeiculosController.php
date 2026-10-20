<?php
declare(strict_types=1);

namespace Elite\Controllers;

use Elite\Core\Autenticacao;
use Elite\Core\Csrf;
use Elite\Models\AnuncioVeiculoRepository;
use Elite\Services\ArquivosAnuncio;
use Throwable;

final class AnunciosVeiculosController
{
    private const COMBUSTIVEIS = ['Gasolina', 'Etanol', 'Diesel', 'Híbrido', 'Elétrico'];
    private const CAMBIOS = ['Automático', 'Automatizado', 'Manual', 'CVT'];

    public function criar(): void
    {
        Autenticacao::exigirLogin('entrar.php');
        $usuarioId = (int) $_SESSION['usuario_id'];
        $erros = [];
        $dados = $this->dadosVazios();
        $enviado = isset($_GET['enviado']) && $_GET['enviado'] === '1';
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' && isset($_GET['revisar'])) {
            $idRevisao = filter_input(INPUT_GET, 'revisar', FILTER_VALIDATE_INT);
            try {
                $anuncioRevisar = $idRevisao !== false && $idRevisao !== null && $idRevisao > 0
                    ? (new AnuncioVeiculoRepository())->buscarRejeitadoDoUsuario($idRevisao, $usuarioId)
                    : null;
                if ($anuncioRevisar === null) {
                    $erros[] = 'Não foi possível abrir essa solicitação para correção.';
                } else {
                    foreach ($dados as $campo => $_) {
                        $dados[$campo] = isset($anuncioRevisar[$campo]) ? (string) $anuncioRevisar[$campo] : '';
                    }
                    $erros[] = 'Revise os dados abaixo, envie as fotos e o CRLV atualizados e reenvie o anúncio. Observação da equipe: ' . (string) ($anuncioRevisar['admin_observacao'] ?? '');
                }
            } catch (Throwable $exception) {
                error_log($exception->getMessage());
                $erros[] = 'Não foi possível carregar os dados para correção.';
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = $this->lerDados($_POST);
            if (!Csrf::validar($_POST['csrf_token'] ?? null)) {
                $erros[] = 'Sua sessão expirou. Atualize a página e envie o anúncio novamente.';
            }
            $erros = array_merge($erros, $this->validarDados($dados));

            $arquivos = $_FILES['fotos'] ?? null;
            $quantidadeFotos = is_array($arquivos)
                && is_array($arquivos['name'] ?? null)
                && is_array($arquivos['error'] ?? null)
                ? count(array_filter($arquivos['error'], static fn ($erro): bool => (int) $erro !== UPLOAD_ERR_NO_FILE))
                : 0;
            if ($quantidadeFotos < 1 || $quantidadeFotos > 8) {
                $erros[] = 'Envie de 1 a 8 fotos do veículo. A primeira foto será a capa do anúncio.';
            }
            if (!isset($_FILES['documento_crlv']) || (int) ($_FILES['documento_crlv']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
                $erros[] = 'O CRLV do veículo é obrigatório para análise do anúncio.';
            }

            $arquivosSalvos = [];
            $diretorioRelativo = null;
            if ($erros === []) {
                try {
                    $diretorioRelativo = ArquivosAnuncio::novoDiretorio($usuarioId);
                    $fotos = $this->normalizarArquivosMultiplos($arquivos);
                    if (count($fotos) !== $quantidadeFotos) {
                        throw new \RuntimeException('Não foi possível ler todas as fotos. Selecione os arquivos novamente.');
                    }
                    foreach ($fotos as $foto) {
                        $caminho = ArquivosAnuncio::guardar($foto, $diretorioRelativo, true, 8 * 1024 * 1024);
                        $arquivosSalvos[] = $caminho;
                    }
                    $documentoCrlv = ArquivosAnuncio::guardar($_FILES['documento_crlv'], $diretorioRelativo, false, 12 * 1024 * 1024);
                    $arquivosSalvos[] = $documentoCrlv;

                    $documentoExtra = null;
                    if (isset($_FILES['documento_extra']) && (int) ($_FILES['documento_extra']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
                        $documentoExtra = ArquivosAnuncio::guardar($_FILES['documento_extra'], $diretorioRelativo, false, 12 * 1024 * 1024);
                        $arquivosSalvos[] = $documentoExtra;
                    }

                    $fotosSalvas = array_slice($arquivosSalvos, 0, count($fotos));
                    (new AnuncioVeiculoRepository())->criar($usuarioId, $dados, $fotosSalvas, $documentoCrlv, $documentoExtra);
                    $_SESSION['anuncio_veiculo_sucesso'] = 'Anúncio enviado. Nossa equipe vai analisar as informações e a documentação antes da publicação.';
                    header('Location: anunciar.php?enviado=1');
                    exit;
                } catch (Throwable $exception) {
                    ArquivosAnuncio::apagar($arquivosSalvos);
                    if ($diretorioRelativo !== null) {
                        $pasta = dirname(__DIR__, 2) . '/' . $diretorioRelativo;
                        if (is_dir($pasta)) {
                            @rmdir($pasta);
                        }
                    }
                    error_log($exception->getMessage());
                    $erros[] = $exception instanceof \Elite\Services\ErroUploadAnuncio
                        ? $exception->getMessage()
                        : 'Não foi possível registrar seu anúncio agora. Confira a configuração do banco e tente novamente.';
                }
            }
        }

        $mensagemSucesso = $_SESSION['anuncio_veiculo_sucesso'] ?? null;
        unset($_SESSION['anuncio_veiculo_sucesso']);
        $solicitacoes = [];
        try {
            $solicitacoes = (new AnuncioVeiculoRepository())->listarPorUsuario($usuarioId);
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            if ($erros === [] && !$enviado) {
                $erros[] = 'A área de anúncios ainda não está configurada no banco. Execute a migração SQL incluída no projeto.';
            }
        }

        $csrfToken = Csrf::token();
        require dirname(__DIR__) . '/Views/carros/anunciar.php';
    }

    /** @return array<string, string> */
    private function dadosVazios(): array
    {
        return array_fill_keys([
            'marca', 'modelo', 'ano', 'quilometragem', 'cor', 'combustivel', 'cambio', 'versao',
            'motor', 'potencia', 'descricao', 'informacoes_adicionais', 'preco',
        ], '');
    }

    /** @param array<string, mixed> $entrada @return array<string, string> */
    private function lerDados(array $entrada): array
    {
        $dados = $this->dadosVazios();
        foreach ($dados as $campo => $_) {
            $valor = $entrada[$campo] ?? '';
            $dados[$campo] = is_scalar($valor) ? trim((string) $valor) : '';
        }
        return $dados;
    }

    /** @param array<string, string> $dados @return list<string> */
    private function validarDados(array $dados): array
    {
        $erros = [];
        foreach (['marca' => 80, 'modelo' => 120, 'cor' => 60, 'motor' => 120] as $campo => $limite) {
            if ($dados[$campo] === '' || mb_strlen($dados[$campo], 'UTF-8') > $limite) {
                $erros[] = 'Preencha marca, modelo, cor e motorização dentro dos limites indicados.';
                break;
            }
        }
        $ano = filter_var($dados['ano'], FILTER_VALIDATE_INT);
        if ($ano === false || $ano < 1886 || $ano > (int) date('Y') + 1) {
            $erros[] = 'Informe um ano válido para o veículo.';
        }
        if (!ctype_digit($dados['quilometragem']) || (int) $dados['quilometragem'] > 5000000) {
            $erros[] = 'Informe a quilometragem em quilômetros.';
        }
        if (!in_array($dados['combustivel'], self::COMBUSTIVEIS, true) || !in_array($dados['cambio'], self::CAMBIOS, true)) {
            $erros[] = 'Selecione o combustível e o câmbio do veículo.';
        }
        if (($_POST['confirmacao'] ?? null) !== '1') {
            $erros[] = 'Confirme que as informações são verdadeiras e que você pode disponibilizar o CRLV.';
        }
        if (!ctype_digit($dados['potencia']) || (int) $dados['potencia'] < 1 || (int) $dados['potencia'] > 5000) {
            $erros[] = 'Informe uma potência entre 1 e 5.000 cv.';
        }
        if (mb_strlen($dados['versao'], 'UTF-8') > 100) {
            $erros[] = 'A versão deve ter até 100 caracteres.';
        }
        if (mb_strlen($dados['descricao'], 'UTF-8') < 30 || mb_strlen($dados['descricao'], 'UTF-8') > 3000) {
            $erros[] = 'A descrição precisa ter entre 30 e 3.000 caracteres.';
        }
        if (mb_strlen($dados['informacoes_adicionais'], 'UTF-8') > 3000) {
            $erros[] = 'As informações adicionais devem ter até 3.000 caracteres.';
        }
        $preco = filter_var($dados['preco'], FILTER_VALIDATE_FLOAT);
        if ($preco === false || $preco < 400000 || $preco > 999999999999.99) {
            $erros[] = 'O preço anunciado deve ser de no mínimo R$ 400.000,00.';
        }
        return $erros;
    }

    /** @param array<string, mixed>|null $arquivos @return list<array<string, mixed>> */
    private function normalizarArquivosMultiplos(?array $arquivos): array
    {
        if (!is_array($arquivos) || !is_array($arquivos['name'] ?? null)) {
            return [];
        }
        $normalizados = [];
        foreach ($arquivos['name'] as $indice => $nome) {
            $normalizados[] = [
                'name' => $nome,
                'type' => $arquivos['type'][$indice] ?? '',
                'tmp_name' => $arquivos['tmp_name'][$indice] ?? '',
                'error' => $arquivos['error'][$indice] ?? UPLOAD_ERR_NO_FILE,
                'size' => $arquivos['size'][$indice] ?? 0,
            ];
        }
        return $normalizados;
    }
}
