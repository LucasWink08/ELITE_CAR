<?php
declare(strict_types=1);

function luxcarsCarrinhoEscape(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxCars | Carrinho</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/fonte.css">
    <link rel="stylesheet" href="../assets/css/site.css">
</head>
<body class="min-h-screen bg-gradient-to-t from-black to-gray-900 text-white">
<?php require dirname(__DIR__, 3) . '/includes/navbar.php'; ?>
<main class="mx-auto max-w-5xl p-6 sm:p-8">
    <h1 class="mb-8 text-center text-4xl">Meu carrinho</h1>
    <?php if ($mensagem !== null): ?>
        <p class="mb-5 rounded bg-green-900 p-4" role="status"><?= luxcarsCarrinhoEscape($mensagem) ?></p>
    <?php endif; ?>
    <?php if ($erro !== null): ?>
        <p class="mb-5 rounded bg-red-900 p-4" role="alert"><?= luxcarsCarrinhoEscape($erro) ?></p>
    <?php endif; ?>

    <?php if ($itens === []): ?>
        <p class="rounded bg-gray-800 p-6 text-center">Seu carrinho está vazio.</p>
        <p class="mt-5 text-center"><a class="underline" href="paginadecompra.php">Ver catálogo</a></p>
    <?php else: ?>
        <form method="post" action="carrinho.php" class="mb-4 text-right" onsubmit="return confirm('Tem certeza que deseja limpar todo o carrinho?')">
            <input type="hidden" name="csrf_token" value="<?= luxcarsCarrinhoEscape($csrfToken) ?>">
            <input type="hidden" name="acao" value="limpar">
            <button type="submit" class="rounded border border-red-400 px-4 py-2 text-red-200 hover:bg-red-900">Limpar carrinho</button>
        </form>
        <div class="space-y-4">
            <?php foreach ($itens as $item): ?>
                <article class="luxcars-car-card">
                    <?php if (!empty($item['imagem'])): ?>
                        <img class="luxcars-car-card__image" src="<?= luxcarsCarrinhoEscape('../' . ltrim((string) $item['imagem'], '/')) ?>" alt="<?= luxcarsCarrinhoEscape($item['marca'] . ' ' . $item['modelo']) ?>" loading="lazy">
                    <?php else: ?>
                        <div class="luxcars-car-card__placeholder">Imagem indisponível</div>
                    <?php endif; ?>
                    <div class="luxcars-car-card__content">
                        <h2 class="luxcars-car-card__title"><?= luxcarsCarrinhoEscape($item['marca'] . ' ' . $item['modelo']) ?></h2>
                        <p class="luxcars-car-card__eyebrow">Ano <?= luxcarsCarrinhoEscape($item['ano']) ?></p>
                        <p class="luxcars-car-card__price">Preço unitário: R$ <?= number_format((float) $item['preco'], 2, ',', '.') ?></p>
                        <form method="post" action="carrinho.php" class="mt-3 flex flex-wrap items-end gap-2">
                            <input type="hidden" name="csrf_token" value="<?= luxcarsCarrinhoEscape($csrfToken) ?>">
                            <input type="hidden" name="acao" value="atualizar">
                            <input type="hidden" name="carro_id" value="<?= (int) $item['carro_id'] ?>">
                            <label class="text-sm" for="quantidade-<?= (int) $item['carro_id'] ?>">Quantidade</label>
                            <input class="w-20 rounded border border-gray-400 px-2 py-1" type="number" id="quantidade-<?= (int) $item['carro_id'] ?>" name="quantidade" min="1" max="99" value="<?= (int) $item['quantidade'] ?>" required>
                            <button type="submit" class="luxcars-car-card__button">Atualizar quantidade</button>
                        </form>
                        <form method="post" action="carrinho.php" class="mt-2" onsubmit="return confirm('Remover este veículo do carrinho?')">
                            <input type="hidden" name="csrf_token" value="<?= luxcarsCarrinhoEscape($csrfToken) ?>">
                            <input type="hidden" name="acao" value="remover">
                            <input type="hidden" name="carro_id" value="<?= (int) $item['carro_id'] ?>">
                            <button type="submit" class="text-sm text-red-700 underline">Remover veículo</button>
                        </form>
                        <p class="luxcars-car-card__price">Subtotal: R$ <?= number_format((float) $item['subtotal'], 2, ',', '.') ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
        <div class="mt-6 rounded-xl bg-gray-800 p-5 text-right">
            <p class="text-2xl font-bold">Total: R$ <?= number_format($total, 2, ',', '.') ?></p>
        </div>
    <?php endif; ?>
</main>
<?php require dirname(__DIR__, 3) . '/includes/footer.php'; ?>
</body>
</html>
