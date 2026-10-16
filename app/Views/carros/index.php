<?php
declare(strict_types=1);

function luxcarsEscape(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxCars | Catálogo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/fonte.css">
    <link rel="stylesheet" href="../assets/css/site.css">
</head>
<body class="min-h-screen bg-gradient-to-t from-black to-gray-900 text-white">
<?php require dirname(__DIR__, 3) . '/includes/navbar.php'; ?>
<main class="mx-auto max-w-7xl p-8">
    <h1 class="mb-8 text-center text-4xl">Catálogo de veículos</h1>
    <form method="get" class="mb-8 grid grid-cols-1 gap-4 rounded-xl bg-gray-800 p-5 sm:grid-cols-2 lg:grid-cols-4">
        <label class="grid gap-1">Marca
            <input class="rounded p-2 text-black" type="search" name="marca" value="<?= luxcarsEscape($filtros['marca']) ?>" placeholder="Ex.: BMW">
        </label>
        <label class="grid gap-1">Modelo
            <input class="rounded p-2 text-black" type="search" name="modelo" value="<?= luxcarsEscape($filtros['modelo']) ?>" placeholder="Ex.: 911">
        </label>
        <label class="grid gap-1">Ano
            <input class="rounded p-2 text-black" type="number" name="ano" min="1886" value="<?= luxcarsEscape($filtros['ano']) ?>">
        </label>
        <label class="grid gap-1">Combustível
            <select class="rounded p-2 text-black" name="combustivel">
                <option value="">Todos</option>
                <?php foreach (['Gasolina', 'Diesel', 'Flex', 'Híbrido', 'Elétrico'] as $opcao): ?>
                    <option value="<?= luxcarsEscape($opcao) ?>" <?= $filtros['combustivel'] === $opcao ? 'selected' : '' ?>><?= luxcarsEscape($opcao) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label class="grid gap-1">Preço mínimo (R$)
            <input class="rounded p-2 text-black" type="number" name="preco_min" min="0" step="0.01" value="<?= luxcarsEscape($filtros['preco_min']) ?>">
        </label>
        <label class="grid gap-1">Preço máximo (R$)
            <input class="rounded p-2 text-black" type="number" name="preco_max" min="0" step="0.01" value="<?= luxcarsEscape($filtros['preco_max']) ?>">
        </label>
        <label class="grid gap-1">Câmbio
            <select class="rounded p-2 text-black" name="cambio">
                <option value="">Todos</option>
                <?php foreach (['Automático', 'Manual', 'Automatizado'] as $opcao): ?>
                    <option value="<?= luxcarsEscape($opcao) ?>" <?= $filtros['cambio'] === $opcao ? 'selected' : '' ?>><?= luxcarsEscape($opcao) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <div class="flex items-end gap-3">
            <button class="rounded bg-red-700 px-5 py-2 text-white" type="submit">Filtrar</button>
            <a class="rounded bg-gray-600 px-5 py-2 text-white" href="paginadecompra.php">Limpar</a>
        </div>
    </form>
    <?php if ($erroBanco !== null): ?>
        <p class="rounded bg-red-900 p-4 text-center" role="alert"><?= luxcarsEscape($erroBanco) ?></p>
    <?php elseif ($carros === []): ?>
        <p class="rounded bg-gray-800 p-4 text-center">Nenhum veículo disponível corresponde aos filtros.</p>
    <?php else: ?>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">
            <?php foreach ($carros as $carro): ?>
                <article class="luxcars-car-card">
                    <?php if ($carro->getImagem() !== null && $carro->getImagem() !== ''): ?>
                        <img class="luxcars-car-card__image" src="<?= luxcarsEscape('../' . ltrim($carro->getImagem(), '/')) ?>" alt="<?= luxcarsEscape($carro->getMarca() . ' ' . $carro->getModelo()) ?>">
                    <?php else: ?>
                        <div class="luxcars-car-card__placeholder">Imagem indisponível</div>
                    <?php endif; ?>
                    <div class="luxcars-car-card__content">
                        <h2 class="luxcars-car-card__title"><?= luxcarsEscape($carro->getMarca() . ' ' . $carro->getModelo()) ?></h2>
                        <p class="luxcars-car-card__eyebrow">Ano <?= luxcarsEscape($carro->getAno()) ?></p>
                        <p class="luxcars-car-card__price">R$ <?= number_format($carro->getPreco(), 2, ',', '.') ?></p>
                        <?php if ($carro->getDescricao() !== null && $carro->getDescricao() !== ''): ?><p><?= luxcarsEscape($carro->getDescricao()) ?></p><?php endif; ?>
                        <a class="luxcars-car-card__button" href="detalhes.php?id=<?= rawurlencode((string) $carro->getId()) ?>">Ver detalhes</a>
                        <?php if (isset($_SESSION['usuario_id'])): ?>
                            <div class="mt-3 flex flex-wrap gap-3 text-sm">
                                <form method="post" action="favoritos.php">
                                    <input type="hidden" name="csrf_token" value="<?= luxcarsEscape($csrfToken) ?>"><input type="hidden" name="acao" value="adicionar"><input type="hidden" name="carro_id" value="<?= (int) $carro->getId() ?>">
                                    <button class="underline" type="submit">Salvar favorito</button>
                                </form>
                                <form method="post" action="comparar.php">
                                    <input type="hidden" name="csrf_token" value="<?= luxcarsEscape($csrfToken) ?>"><input type="hidden" name="acao" value="adicionar"><input type="hidden" name="carro_id" value="<?= (int) $carro->getId() ?>">
                                    <button class="underline" type="submit">Comparar</button>
                                </form>
                            </div>
                        <?php else: ?>
                            <p class="mt-2 text-sm"><a class="underline" href="entrar.php">Entre para salvar ou comparar</a></p>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>
<?php require dirname(__DIR__, 3) . '/includes/footer.php'; ?>
</body>
</html>
