<?php
declare(strict_types=1);

namespace Elite\Controllers;

use Elite\Models\Carro;
use Elite\Models\InteracaoRepository;
use Elite\Core\Csrf;
use Throwable;

final class CarroController
{
    public function index(): void
    {
        $carros = [];
        $erroBanco = null;
        $filtros = [
            'termo' => trim((string) ($_GET['termo'] ?? '')),
            'marca' => trim((string) ($_GET['marca'] ?? '')),
            'modelo' => trim((string) ($_GET['modelo'] ?? '')),
            'ano' => trim((string) ($_GET['ano'] ?? '')),
            'preco_min' => trim((string) ($_GET['preco_min'] ?? '')),
            'preco_max' => trim((string) ($_GET['preco_max'] ?? '')),
            'combustivel' => trim((string) ($_GET['combustivel'] ?? '')),
            'cambio' => trim((string) ($_GET['cambio'] ?? '')),
        ];

        try {
            $carros = (new Carro())->buscarDisponiveis($filtros);
        } catch (Throwable $exception) {
            // A mensagem detalhada fica no log do servidor, sem expor credenciais ou SQL.
            error_log($exception->getMessage());
            $erroBanco = 'Não foi possível carregar o catálogo. Confira a configuração do banco de dados.';
        }

        $csrfToken = Csrf::token();
        require dirname(__DIR__) . '/Views/carros/index.php';
    }

    public function detalhes(): void
    {
        $csrfToken = Csrf::token();
        $carro = null;
        $erroBanco = null;
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $imagem = $_GET['imagem'] ?? null;

        $imagemValida = is_string($imagem)
            && preg_match('#^assets/imagens/cars/[a-z0-9 _./()+\-]+$#i', $imagem) === 1
            && !str_contains($imagem, '..');
        if (($id !== false && $id !== null && $id > 0) || $imagemValida) {
            try {
                $repositorio = new Carro();
                $carroEncontrado = $id !== false && $id !== null && $id > 0
                    ? $repositorio->buscarPorId($id)
                    : $repositorio->buscarPorImagem($imagem);
                if ($carroEncontrado !== null && $carroEncontrado->getStatus() === 'disponivel') {
                    $carro = $carroEncontrado;
                    if (isset($_SESSION['usuario_id']) && is_int($_SESSION['usuario_id'])) {
                        try {
                            (new InteracaoRepository())->registrarVisualizacao($_SESSION['usuario_id'], $carro->getId());
                        } catch (Throwable $exception) {
                            error_log($exception->getMessage());
                        }
                    }
                }
            } catch (Throwable $exception) {
                error_log($exception->getMessage());
                $erroBanco = 'Não foi possível carregar os detalhes. Confira a configuração do banco de dados.';
            }
        }

        require dirname(__DIR__) . '/Views/carros/detalhes.php';
    }
}
