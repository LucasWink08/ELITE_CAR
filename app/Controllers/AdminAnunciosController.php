<?php
declare(strict_types=1);

namespace Elite\Controllers;

use Elite\Core\Autenticacao;
use Elite\Core\Csrf;
use Elite\Models\AnuncioVeiculoRepository;
use Elite\Services\ArquivosAnuncio;
use Throwable;

final class AdminAnunciosController
{
    public function index(): void
    {
        Autenticacao::exigirAdministrador();
        $erros = [];
        $mensagem = $_SESSION['admin_anuncios_mensagem'] ?? null;
        unset($_SESSION['admin_anuncios_mensagem']);

        try {
            $repositorio = new AnuncioVeiculoRepository();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (!Csrf::validar($_POST['csrf_token'] ?? null)) {
                    $erros[] = 'Sua sessão expirou. Atualize a página e tente novamente.';
                } else {
                    $acao = is_string($_POST['acao'] ?? null) ? $_POST['acao'] : '';
                    $id = filter_var($_POST['anuncio_id'] ?? null, FILTER_VALIDATE_INT);
                    if ($id === false || $id === null || $id < 1) {
                        $erros[] = 'Solicitação de anúncio inválida.';
                    } elseif ($acao === 'aprovar') {
                        $registro = $repositorio->buscarPorId($id);
                        if ($registro === null || $registro['status'] !== 'em_analise') {
                            $erros[] = 'Esta solicitação não está mais aguardando análise.';
                        } else {
                            $fotosOriginais = json_decode((string) $registro['fotos_json'], true);
                            if (!is_array($fotosOriginais) || $fotosOriginais === []) {
                                $erros[] = 'A solicitação não contém fotos válidas.';
                            } else {
                                $fotosPublicas = [];
                                try {
                                    foreach (array_values($fotosOriginais) as $indice => $foto) {
                                        if (!is_string($foto)) {
                                            throw new \RuntimeException('Uma das fotos cadastradas não é válida.');
                                        }
                                        $fotosPublicas[] = ArquivosAnuncio::copiarFotoParaCatalogo($foto, $id, $indice);
                                    }
                                    $repositorio->aprovar($id, $fotosPublicas);
                                    $_SESSION['admin_anuncios_mensagem'] = 'Anúncio aprovado e publicado no catálogo.';
                                    header('Location: admin_anuncios.php');
                                    exit;
                                } catch (Throwable $exception) {
                                    ArquivosAnuncio::apagar($fotosPublicas);
                                    throw $exception;
                                }
                            }
                        }
                    } elseif ($acao === 'rejeitar') {
                        $observacao = is_string($_POST['observacao'] ?? null) ? trim($_POST['observacao']) : '';
                        if (mb_strlen($observacao, 'UTF-8') < 8 || mb_strlen($observacao, 'UTF-8') > 1000) {
                            $erros[] = 'Explique os ajustes necessários em uma mensagem de 8 a 1.000 caracteres.';
                        } elseif (!$repositorio->rejeitar($id, $observacao)) {
                            $erros[] = 'Esta solicitação não está mais aguardando análise.';
                        } else {
                            $_SESSION['admin_anuncios_mensagem'] = 'Solicitação devolvida ao anunciante com a orientação informada.';
                            header('Location: admin_anuncios.php');
                            exit;
                        }
                    } else {
                        $erros[] = 'Ação de análise inválida.';
                    }
                }
            }
            $solicitacoes = $repositorio->listarRecentes();
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            $solicitacoes = [];
            $erros[] = 'Não foi possível carregar as solicitações. Confira se a migração de anúncios foi aplicada.';
        }

        $csrfToken = Csrf::token();
        require dirname(__DIR__) . '/Views/admin/anuncios.php';
    }

    public function arquivo(): never
    {
        Autenticacao::exigirAdministrador();
        $id = filter_input(INPUT_GET, 'anuncio', FILTER_VALIDATE_INT);
        $tipo = is_string($_GET['arquivo'] ?? null) ? $_GET['arquivo'] : '';
        if ($id === false || $id === null || $id < 1) {
            http_response_code(404);
            exit('Arquivo não encontrado.');
        }

        try {
            $registro = (new AnuncioVeiculoRepository())->buscarPorId($id);
            if ($registro === null) {
                http_response_code(404);
                exit('Arquivo não encontrado.');
            }
            if ($tipo === 'crlv' || $tipo === 'complementar') {
                $relativo = $tipo === 'crlv' ? (string) $registro['documento_crlv_path'] : (string) ($registro['documento_extra_path'] ?? '');
                $anexo = true;
            } elseif ($tipo === 'foto') {
                $indice = filter_input(INPUT_GET, 'indice', FILTER_VALIDATE_INT);
                $fotos = json_decode((string) $registro['fotos_json'], true);
                $relativo = is_array($fotos) && $indice !== false && $indice !== null && $indice >= 0 && is_string($fotos[$indice] ?? null)
                    ? $fotos[$indice] : '';
                $anexo = false;
            } else {
                $relativo = '';
                $anexo = true;
            }

            $caminho = ArquivosAnuncio::caminhoSeguro($relativo);
            if ($caminho === null) {
                http_response_code(404);
                exit('Arquivo não encontrado.');
            }
            $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($caminho);
            $permitidos = ['image/jpeg', 'image/png', 'image/webp', 'application/pdf'];
            if (!is_string($mime) || !in_array($mime, $permitidos, true)) {
                http_response_code(415);
                exit('Formato de arquivo não permitido.');
            }
            $nome = basename($caminho);
            header('Content-Type: ' . $mime);
            header('Content-Length: ' . (string) filesize($caminho));
            header('Content-Disposition: ' . ($anexo ? 'attachment' : 'inline') . '; filename="' . $nome . '"');
            header('X-Content-Type-Options: nosniff');
            header('Cache-Control: private, no-store, max-age=0');
            readfile($caminho);
            exit;
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            http_response_code(404);
            exit('Arquivo não encontrado.');
        }
    }
}
