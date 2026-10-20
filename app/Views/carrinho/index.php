<?php
declare(strict_types=1);

function eliteCarrinhoEscape(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELITE | Carrinho</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/fonte.css">
    <link rel="stylesheet" href="../assets/css/site.css">
    <link rel="stylesheet" href="../assets/css/carrinho.css?v=20261020-cart-payment-link">
</head>
<body class="elite-cart-body min-h-screen text-white">
<?php require dirname(__DIR__, 3) . '/includes/navbar.php'; ?>
<main class="elite-cart-page">
    <header class="elite-cart-heading">
        <p class="elite-cart-eyebrow">Sua sele&ccedil;&atilde;o</p>
        <h1>Meu carrinho</h1>
        <p>Revise os ve&iacute;culos selecionados antes de falar com a equipe ELITE.</p>
    </header>
    <?php if ($mensagem !== null): ?>
        <p class="elite-cart-alert elite-cart-alert--success" role="status"><?= eliteCarrinhoEscape($mensagem) ?></p>
    <?php endif; ?>
    <?php if ($erro !== null): ?>
        <p class="elite-cart-alert elite-cart-alert--error" role="alert"><?= eliteCarrinhoEscape($erro) ?></p>
    <?php endif; ?>

    <?php if ($itens === []): ?>
        <p class="rounded bg-gray-800 p-6 text-center">Seu carrinho está vazio.</p>
        <p class="mt-5 text-center"><a class="underline" href="paginadecompra.php">Ver catálogo</a></p>
    <?php else: ?>
        <div class="elite-cart-toolbar">
            <p><strong><?= count($itens) ?></strong> <?= count($itens) === 1 ? 've&iacute;culo selecionado' : 've&iacute;culos selecionados' ?></p>
        <form method="post" action="carrinho.php" onsubmit="return confirm('Tem certeza que deseja limpar todo o carrinho?')">
            <input type="hidden" name="csrf_token" value="<?= eliteCarrinhoEscape($csrfToken) ?>">
            <input type="hidden" name="acao" value="limpar">
            <button type="submit" class="elite-cart-clear">Limpar carrinho</button>
        </form>
        </div>
        <div class="space-y-4">
            <?php foreach ($itens as $item): ?>
                <article class="elite-car-card elite-cart-item">
                    <?php if (!empty($item['imagem'])): ?>
                        <img class="elite-car-card__image elite-cart-item__image" src="<?= eliteCarrinhoEscape('../' . ltrim((string) $item['imagem'], '/')) ?>" alt="<?= eliteCarrinhoEscape($item['marca'] . ' ' . $item['modelo']) ?>" loading="lazy">
                    <?php else: ?>
                        <div class="elite-car-card__placeholder">Imagem indisponível</div>
                    <?php endif; ?>
                    <div class="elite-car-card__content elite-cart-item__content">
                        <h2 class="elite-car-card__title"><?= eliteCarrinhoEscape($item['marca'] . ' ' . $item['modelo']) ?></h2>
                        <a class="elite-cart-payment-link" href="pagamento.php?id=<?= (int) $item['carro_id'] ?>">Ver formas de pagamento <span aria-hidden="true">&rarr;</span></a>
                        <p class="elite-car-card__eyebrow">Ano <?= eliteCarrinhoEscape($item['ano']) ?></p>
                        <p class="elite-car-card__price">Preço unitário: R$ <?= number_format((float) $item['preco'], 2, ',', '.') ?></p>
                        <form method="post" action="carrinho.php" class="mt-2" onsubmit="return confirm('Remover este veículo do carrinho?')">
                            <input type="hidden" name="csrf_token" value="<?= eliteCarrinhoEscape($csrfToken) ?>">
                            <input type="hidden" name="acao" value="remover">
                            <input type="hidden" name="carro_id" value="<?= (int) $item['carro_id'] ?>">
                            <button type="submit" class="text-sm text-red-700 underline">Remover veículo</button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
        <div class="elite-cart-total">
            <p><span>Total da sele&ccedil;&atilde;o</span><strong>R$ <?= number_format($total, 2, ',', '.') ?></strong></p>
            <small>Condi&ccedil;&otilde;es e disponibilidade confirmadas pela equipe ELITE.</small>
        </div>
        <a class="elite-cart-continue" href="paginadecompra.php">Continuar explorando <span aria-hidden="true">&rarr;</span></a>
    <?php endif; ?>
</main>
<?php require dirname(__DIR__, 3) . '/includes/footer.php'; ?>
</body>
</html>
