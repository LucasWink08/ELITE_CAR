<?php
declare(strict_types=1);

function eliteEscape(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELITE | Catálogo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/fonte.css">
    <link rel="stylesheet" href="../assets/css/site.css?v=20261019-forms-ui">
</head>
<body class="elite-catalog-page min-h-screen bg-gradient-to-t from-black to-gray-900 text-white">
<?php require dirname(__DIR__, 3) . '/includes/navbar.php'; ?>
<main class="mx-auto max-w-7xl p-8">
    <h1 class="mb-8 text-center text-4xl">Catálogo de veículos</h1>
    <form method="get" class="elite-catalog-filters mb-8 grid grid-cols-1 gap-4 rounded-xl bg-gray-800 p-5 sm:grid-cols-2 lg:grid-cols-4">
        <label class="grid gap-1 sm:col-span-2 lg:col-span-4">Busca por palavra-chave
            <input class="rounded p-2 text-black" type="search" name="termo" value="<?= eliteEscape($filtros['termo']) ?>" placeholder="Marca, modelo, cor ou ano">
        </label>
        <label class="grid gap-1">Marca
            <input class="rounded p-2 text-black" type="search" name="marca" value="<?= eliteEscape($filtros['marca']) ?>" placeholder="Ex.: BMW">
        </label>
        <label class="grid gap-1">Modelo
            <input class="rounded p-2 text-black" type="search" name="modelo" value="<?= eliteEscape($filtros['modelo']) ?>" placeholder="Ex.: 911">
        </label>
        <label class="grid gap-1">Ano
            <input class="rounded p-2 text-black" type="number" name="ano" min="1886" value="<?= eliteEscape($filtros['ano']) ?>">
        </label>
        <label class="grid gap-1">Combustível
            <select class="rounded p-2 text-black" name="combustivel" data-auto-submit-filter>
                <option value="">Todos</option>
                <?php foreach ($opcoesCombustivel as $opcao): ?>
                    <option value="<?= eliteEscape($opcao) ?>" <?= $filtros['combustivel'] === $opcao ? 'selected' : '' ?>><?= eliteEscape($opcao) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label class="grid gap-1">Preço mínimo (R$)
            <input class="rounded p-2 text-black" type="number" name="preco_min" min="0" step="0.01" value="<?= eliteEscape($filtros['preco_min']) ?>">
        </label>
        <label class="grid gap-1">Preço máximo (R$)
            <input class="rounded p-2 text-black" type="number" name="preco_max" min="0" step="0.01" value="<?= eliteEscape($filtros['preco_max']) ?>">
        </label>
        <label class="grid gap-1">Câmbio
            <select class="rounded p-2 text-black" name="cambio" data-auto-submit-filter>
                <option value="">Todos</option>
                <?php foreach ($opcoesCambio as $opcao): ?>
                    <option value="<?= eliteEscape($opcao) ?>" <?= $filtros['cambio'] === $opcao ? 'selected' : '' ?>><?= eliteEscape($opcao) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <div class="flex items-end gap-3">
            <button class="rounded bg-red-700 px-5 py-2 text-white" type="submit">Filtrar</button>
            <a class="rounded bg-gray-600 px-5 py-2 text-white" href="paginadecompra.php">Limpar</a>
        </div>
    </form>
    <?php if ($erroBanco !== null): ?>
        <p class="rounded bg-red-900 p-4 text-center" role="alert"><?= eliteEscape($erroBanco) ?></p>
    <?php elseif ($carros === []): ?>
        <p class="rounded bg-gray-800 p-4 text-center">Nenhum veículo disponível corresponde aos filtros.</p>
    <?php else: ?>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">
            <?php foreach ($carros as $carro): ?>
                <article class="elite-car-card">
                    <?php if ($carro->getImagem() !== null && $carro->getImagem() !== ''): ?>
                        <img class="elite-car-card__image" src="<?= eliteEscape('../' . ltrim($carro->getImagem(), '/')) ?>" alt="<?= eliteEscape($carro->getMarca() . ' ' . $carro->getModelo()) ?>">
                    <?php else: ?>
                        <div class="elite-car-card__placeholder">Imagem indisponível</div>
                    <?php endif; ?>
                    <div class="elite-car-card__content">
                        <h2 class="elite-car-card__title"><?= eliteEscape($carro->getMarca() . ' ' . $carro->getModelo()) ?></h2>
                        <p class="elite-car-card__eyebrow">Ano <?= eliteEscape($carro->getAno()) ?></p>
                        <p class="elite-car-card__price">R$ <?= number_format($carro->getPreco(), 2, ',', '.') ?></p>
                        <dl class="elite-car-card__specs">
                            <div><dt>Versão</dt><dd><?= eliteEscape($carro->getVersao() ?: 'Sob consulta') ?></dd></div>
                            <div><dt>Cor</dt><dd><?= eliteEscape($carro->getCor() ?: 'Sob consulta') ?></dd></div>
                            <div><dt>Câmbio</dt><dd><?= eliteEscape($carro->getCambio() ?: 'Sob consulta') ?></dd></div>
                            <div><dt>Combustível</dt><dd><?= eliteEscape($carro->getCombustivel() ?: 'Sob consulta') ?></dd></div>
                        </dl>
                        <?php if ($carro->getDescricao() !== null && $carro->getDescricao() !== ''): ?><p><?= eliteEscape($carro->getDescricao()) ?></p><?php endif; ?>
                        <a class="elite-car-card__button" href="detalhes.php?id=<?= rawurlencode((string) $carro->getId()) ?>">Ver detalhes</a>
                        <?php if (isset($_SESSION['usuario_id'])): ?>
                            <div class="mt-3 flex flex-wrap gap-3 text-sm">
                                <form method="post" action="favoritos.php">
                                    <input type="hidden" name="csrf_token" value="<?= eliteEscape($csrfToken) ?>"><input type="hidden" name="acao" value="adicionar"><input type="hidden" name="carro_id" value="<?= (int) $carro->getId() ?>">
                                    <button class="underline" type="submit">Salvar favorito</button>
                                </form>
                                <form method="post" action="comparar.php">
                                    <input type="hidden" name="csrf_token" value="<?= eliteEscape($csrfToken) ?>"><input type="hidden" name="acao" value="adicionar"><input type="hidden" name="carro_id" value="<?= (int) $carro->getId() ?>">
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
<script>
    document.querySelectorAll('[data-auto-submit-filter]').forEach((filtro) => {
        filtro.addEventListener('change', () => filtro.form?.requestSubmit());
    });
</script>
</body>
</html>
