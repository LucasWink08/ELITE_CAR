<?php
declare(strict_types=1);
function luxcarsListaEscape(mixed $value): string { return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxCars | <?= luxcarsListaEscape($titulo) ?></title>
    <script src="https://cdn.tailwindcss.com"></script><link rel="stylesheet" href="../assets/css/fonte.css">
    <link rel="stylesheet" href="../assets/css/site.css">
</head>
<body class="min-h-screen bg-gradient-to-t from-black to-gray-900 text-white">
<?php require dirname(__DIR__, 3) . '/includes/navbar.php'; ?>
<main class="mx-auto max-w-7xl space-y-6 p-6 sm:p-8">
    <h1 class="text-center text-4xl font-bold"><?= luxcarsListaEscape($titulo) ?></h1>
    <?php if ($mensagem !== null): ?><p class="rounded bg-green-900 p-4" role="status"><?= luxcarsListaEscape($mensagem) ?></p><?php endif; ?>
    <?php if ($erro !== null): ?><p class="rounded bg-red-900 p-4" role="alert"><?= luxcarsListaEscape($erro) ?></p><?php endif; ?>
    <?php if ($modo === 'favoritos'): ?>
        <?php if ($carros === []): ?>
            <p class="rounded bg-gray-800 p-6 text-center">Você ainda não salvou veículos.</p>
        <?php else: ?>
            <section class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <?php foreach ($carros as $carro): ?>
                    <article class="luxcars-car-card">
                        <?php if (!empty($carro['imagem'])): ?><img class="luxcars-car-card__image" src="<?= luxcarsListaEscape('../' . ltrim((string) $carro['imagem'], '/')) ?>" alt="<?= luxcarsListaEscape($carro['marca'] . ' ' . $carro['modelo']) ?>" loading="lazy"><?php else: ?><div class="luxcars-car-card__placeholder">Imagem indisponível</div><?php endif; ?>
                        <div class="luxcars-car-card__content">
                            <h2 class="luxcars-car-card__title"><?= luxcarsListaEscape($carro['marca'] . ' ' . $carro['modelo']) ?></h2>
                            <p class="luxcars-car-card__eyebrow">Ano <?= (int) $carro['ano'] ?></p>
                            <p class="luxcars-car-card__price">R$ <?= number_format((float) $carro['preco'], 2, ',', '.') ?></p>
                            <a class="luxcars-car-card__button" href="detalhes.php?id=<?= (int) $carro['id'] ?>">Ver detalhes</a>
                            <div class="flex flex-wrap gap-3">
                                <form method="post" action="favoritos.php" onsubmit="return confirm('Remover dos favoritos?')">
                                    <input type="hidden" name="csrf_token" value="<?= luxcarsListaEscape($csrfToken) ?>"><input type="hidden" name="acao" value="remover"><input type="hidden" name="carro_id" value="<?= (int) $carro['id'] ?>">
                                    <button class="text-red-700 underline" type="submit">Remover favorito</button>
                                </form>
                                <form method="post" action="comparar.php">
                                    <input type="hidden" name="csrf_token" value="<?= luxcarsListaEscape($csrfToken) ?>"><input type="hidden" name="acao" value="adicionar"><input type="hidden" name="carro_id" value="<?= (int) $carro['id'] ?>">
                                    <button class="text-blue-800 underline" type="submit">Adicionar à comparação</button>
                                </form>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </section>
        <?php endif; ?>
    <?php else: ?>
        <?php if ($carros === []): ?>
            <p class="rounded bg-gray-800 p-6 text-center">Adicione até três veículos disponíveis para comparar.</p>
        <?php else: ?>
            <form method="post" action="comparar.php" class="text-right" onsubmit="return confirm('Limpar todos os veículos da comparação?')">
                <input type="hidden" name="csrf_token" value="<?= luxcarsListaEscape($csrfToken) ?>"><input type="hidden" name="acao" value="limpar">
                <button type="submit" class="rounded border border-red-300 px-4 py-2 text-red-200">Limpar comparação</button>
            </form>
            <div class="overflow-x-auto rounded-xl bg-white text-black shadow">
                <table class="min-w-full border-collapse text-left">
                    <thead><tr><th class="min-w-36 bg-gray-100 p-3">Característica</th><?php foreach ($carros as $carro): ?><th class="min-w-56 border-l p-3"><?= luxcarsListaEscape($carro['marca'] . ' ' . $carro['modelo']) ?></th><?php endforeach; ?></tr></thead>
                    <tbody>
                    <?php foreach ([
                        'Imagem' => fn ($c) => !empty($c['imagem']) ? '<img class="h-32 w-full rounded object-cover" src="' . luxcarsListaEscape('../' . ltrim((string) $c['imagem'], '/')) . '" alt="' . luxcarsListaEscape($c['marca'] . ' ' . $c['modelo']) . '">' : 'Sem imagem',
                        'Ano' => fn ($c) => (string) $c['ano'],
                        'Preço' => fn ($c) => 'R$ ' . number_format((float) $c['preco'], 2, ',', '.'),
                        'Quilometragem' => fn ($c) => $c['quilometragem'] === null ? 'Não informado' : number_format((int) $c['quilometragem'], 0, ',', '.') . ' km',
                        'Combustível' => fn ($c) => $c['combustivel'] ?: 'Não informado',
                        'Câmbio' => fn ($c) => $c['cambio'] ?: 'Não informado',
                        'Cor' => fn ($c) => $c['cor'] ?: 'Não informada',
                        'Disponibilidade' => fn ($c) => $c['status'],
                    ] as $rotulo => $formatar): ?>
                        <tr class="border-t"><th class="bg-gray-50 p-3"><?= luxcarsListaEscape($rotulo) ?></th><?php foreach ($carros as $carro): ?><td class="border-l p-3"><?php if ($rotulo === 'Imagem'): ?><?= $formatar($carro) ?><?php else: ?><?= luxcarsListaEscape($formatar($carro)) ?><?php endif; ?></td><?php endforeach; ?></tr>
                    <?php endforeach; ?>
                    <tr class="border-t"><th class="bg-gray-50 p-3">Ações</th><?php foreach ($carros as $carro): ?><td class="space-y-2 border-l p-3"><a class="block underline" href="detalhes.php?id=<?= (int) $carro['id'] ?>">Ver detalhes</a><form method="post" action="comparar.php"><input type="hidden" name="csrf_token" value="<?= luxcarsListaEscape($csrfToken) ?>"><input type="hidden" name="acao" value="remover"><input type="hidden" name="carro_id" value="<?= (int) $carro['id'] ?>"><button class="text-red-700 underline" type="submit">Remover</button></form></td><?php endforeach; ?></tr>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <p><a class="underline" href="paginadecompra.php">Voltar ao catálogo</a></p>
</main>
<?php require dirname(__DIR__, 3) . '/includes/footer.php'; ?>
</body>
</html>
