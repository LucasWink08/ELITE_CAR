<?php
declare(strict_types=1);

namespace Elite\Controllers;

use Elite\Models\Carro;
use Elite\Models\NoticiaAutomotivaRepository;
use Elite\Services\NoticiasAutomotivasApi;
use Throwable;

final class HomeController
{
    public function index(): void
    {
        $carros = [];
        $erroBanco = null;

        try {
            $carros = (new Carro())->listarDisponiveis();
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            $erroBanco = 'Não foi possível carregar os veículos. Confira a configuração do banco de dados.';
        }

        $noticias = [];
        try {
            $repositorioNoticias = new NoticiaAutomotivaRepository();
            $apiKey = trim((string) (getenv('APITUBE_API_KEY') ?: ''));
            if ($apiKey !== '' && $repositorioNoticias->precisaAtualizar()) {
                try {
                    $artigos = (new NoticiasAutomotivasApi())->buscar();
                    if ($artigos !== []) {
                        $repositorioNoticias->salvarArtigos($artigos);
                    }
                    $repositorioNoticias->marcarTentativa();
                } catch (Throwable $exception) {
                    error_log('Falha ao sincronizar noticias APITube: ' . $exception->getMessage());
                }
            }
            $noticias = $repositorioNoticias->listarRecentes(10);
        } catch (Throwable $exception) {
            error_log('Falha ao carregar noticias automotivas: ' . $exception->getMessage());
        }

        require dirname(__DIR__) . '/Views/home/index.php';
    }
}
