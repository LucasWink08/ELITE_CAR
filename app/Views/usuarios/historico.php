<?php
declare(strict_types=1);
function luxcarsHistoricoEscape(mixed $value): string { return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>LuxCars | Histórico</title><script src="https://cdn.tailwindcss.com"></script><link rel="stylesheet" href="../assets/css/fonte.css">
    <link rel="stylesheet" href="../assets/css/site.css"></head>
<body class="min-h-screen bg-gradient-to-t from-black to-gray-900 text-white">
<?php require dirname(__DIR__, 3) . '/includes/navbar.php'; ?>
<main class="mx-auto max-w-6xl space-y-6 p-6 sm:p-8">
    <h1 class="text-center text-4xl font-bold">Veículos vistos recentemente</h1>
    <?php if ($erro !== null): ?><p class="rounded bg-red-900 p-4" role="alert"><?= luxcarsHistoricoEscape($erro) ?></p><?php endif; ?>
    <?php if ($carros === []): ?>
        <p class="rounded bg-gray-800 p-6 text-center">Seu histórico ainda está vazio. Explore o catálogo para registrar veículos vistos.</p>
    <?php else: ?>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($carros as $carro): ?>
                <article class="luxcars-car-card">
                    <?php if (!empty($carro['imagem'])): ?><img class="luxcars-car-card__image" src="<?= luxcarsHistoricoEscape('../' . ltrim((string) $carro['imagem'], '/')) ?>" alt="<?= luxcarsHistoricoEscape($carro['marca'] . ' ' . $carro['modelo']) ?>" loading="lazy"><?php else: ?><div class="luxcars-car-card__placeholder">Imagem indisponível</div><?php endif; ?>
                    <div class="luxcars-car-card__content">
                        <h2 class="luxcars-car-card__title"><?= luxcarsHistoricoEscape($carro['marca'] . ' ' . $carro['modelo']) ?></h2>
                        <p class="luxcars-car-card__eyebrow"><?= (int) $carro['ano'] ?></p>
                        <p class="luxcars-car-card__price">R$ <?= number_format((float) $carro['preco'], 2, ',', '.') ?></p>
                        <p>Visto em <?= luxcarsHistoricoEscape($carro['visualizado_em']) ?></p>
                        <a class="luxcars-car-card__button" href="detalhes.php?id=<?= (int) $carro['id'] ?>">Ver detalhes</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <p><a class="underline" href="perfil.php">Voltar ao perfil</a></p>
</main>
<?php require dirname(__DIR__, 3) . '/includes/footer.php'; ?>
</body>
</html>
