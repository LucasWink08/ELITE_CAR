<?php
declare(strict_types=1);

function luxcarsPerfilEscape(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxCars | Meu perfil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/fonte.css">
    <link rel="stylesheet" href="../assets/css/site.css">
</head>
<body class="min-h-screen bg-gradient-to-t from-black to-gray-900 text-white">
<?php require dirname(__DIR__, 3) . '/includes/navbar.php'; ?>
<main class="mx-auto max-w-5xl space-y-8 p-6 sm:p-8">
    <h1 class="text-center text-4xl font-bold">Meu perfil</h1>
    <?php if ($mensagem !== null): ?><p class="rounded bg-green-900 p-4" role="status"><?= luxcarsPerfilEscape($mensagem) ?></p><?php endif; ?>
    <?php if ($erros !== []): ?><div class="rounded bg-red-900 p-4" role="alert"><ul class="list-inside list-disc"><?php foreach (array_unique($erros) as $erro): ?><li><?= luxcarsPerfilEscape($erro) ?></li><?php endforeach; ?></ul></div><?php endif; ?>

    <nav class="grid grid-cols-2 gap-3 sm:grid-cols-4" aria-label="Minha conta">
        <a class="rounded bg-gray-800 p-3 text-center hover:bg-gray-700" href="favoritos.php">Favoritos</a>
        <a class="rounded bg-gray-800 p-3 text-center hover:bg-gray-700" href="comparar.php">Comparar veículos</a>
        <a class="rounded bg-gray-800 p-3 text-center hover:bg-gray-700" href="historico.php">Histórico</a>
        <a class="rounded bg-gray-800 p-3 text-center hover:bg-gray-700" href="carrinho.php">Carrinho</a>
    </nav>

    <section class="rounded-xl bg-white p-6 text-black shadow-xl sm:p-8">
        <h2 class="mb-5 text-2xl font-semibold">Dados pessoais</h2>
        <form method="post" action="perfil.php" class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <input type="hidden" name="csrf_token" value="<?= luxcarsPerfilEscape($csrfToken) ?>">
            <?php foreach ([
                'nome' => ['Nome completo', 'text'], 'email' => ['E-mail', 'email'], 'telefone' => ['Telefone', 'tel'],
                'endereco' => ['Endereço', 'text'], 'numero_endereco' => ['Número', 'text'],
                'cidade' => ['Cidade', 'text'], 'estado' => ['Estado (UF)', 'text'],
            ] as $campo => [$rotulo, $tipo]): ?>
                <label class="grid gap-1 <?= in_array($campo, ['nome', 'endereco'], true) ? 'sm:col-span-2' : '' ?>"><?= $rotulo ?>
                    <input class="rounded border border-gray-300 p-3" type="<?= $tipo ?>" name="<?= $campo ?>" maxlength="<?= $campo === 'nome' ? 150 : ($campo === 'endereco' ? 180 : ($campo === 'email' ? 190 : 100)) ?>" value="<?= luxcarsPerfilEscape($dados[$campo] ?? '') ?>" required>
                </label>
            <?php endforeach; ?>
            <label class="grid gap-1">CPF (não editável)<input class="rounded border border-gray-300 bg-gray-100 p-3" value="<?= luxcarsPerfilEscape($dados['cpf'] ?? '') ?>" readonly></label>
            <label class="grid gap-1">Data de nascimento (não editável)<input class="rounded border border-gray-300 bg-gray-100 p-3" value="<?= luxcarsPerfilEscape($dados['data_nascimento'] ?? '') ?>" readonly></label>
            <button class="rounded bg-black px-5 py-3 font-semibold text-white hover:bg-gray-800 sm:col-span-2" type="submit">Salvar alterações</button>
        </form>
    </section>

    <section class="rounded-xl bg-gray-800 p-6">
        <h2 class="mb-4 text-2xl font-semibold">Minhas intenções de compra</h2>
        <?php if ($intencoes === []): ?>
            <p class="text-gray-300">Você ainda não enviou uma intenção de compra.</p>
        <?php else: ?>
            <div class="space-y-3">
                <?php foreach ($intencoes as $intencao): ?>
                    <article class="rounded bg-gray-900 p-4">
                        <h3 class="font-semibold"><?= luxcarsPerfilEscape($intencao['marca'] . ' ' . $intencao['modelo']) ?> (<?= (int) $intencao['ano'] ?>)</h3>
                        <p class="text-sm text-gray-300">Status: <?= luxcarsPerfilEscape($intencao['status']) ?> · <?= luxcarsPerfilEscape($intencao['criada_em']) ?></p>
                        <?php if (!empty($intencao['mensagem'])): ?><p class="mt-2"><?= luxcarsPerfilEscape($intencao['mensagem']) ?></p><?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</main>
<?php require dirname(__DIR__, 3) . '/includes/footer.php'; ?>
</body>
</html>
