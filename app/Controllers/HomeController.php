<?php
declare(strict_types=1);

namespace LuxCars\Controllers;

use LuxCars\Models\Carro;
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

        require dirname(__DIR__) . '/Views/home/index.php';
    }
}
