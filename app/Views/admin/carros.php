<?php
declare(strict_types=1);
function luxcarsAdminEscape(mixed $value): string { return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>LuxCars | Administração de veículos</title><script src="https://cdn.tailwindcss.com"></script><link rel="stylesheet" href="../assets/css/fonte.css">
    <link rel="stylesheet" href="../assets/css/site.css"></head>
<body class="min-h-screen bg-gradient-to-t from-black to-gray-900 text-white">
<?php require dirname(__DIR__, 3) . '/includes/navbar.php'; ?>
<main class="mx-auto max-w-7xl space-y-8 p-6 sm:p-8">
    <div class="flex flex-wrap items-center justify-between gap-4"><h1 class="text-3xl font-bold sm:text-4xl">Administração de veículos</h1><a href="perfil.php" class="underline">Meu perfil</a></div>
    <?php if ($mensagem !== null): ?><p class="rounded bg-green-900 p-4" role="status"><?= luxcarsAdminEscape($mensagem) ?></p><?php endif; ?>
    <?php if ($erros !== []): ?><div class="rounded bg-red-900 p-4" role="alert"><ul class="list-inside list-disc"><?php foreach (array_unique($erros) as $erro): ?><li><?= luxcarsAdminEscape($erro) ?></li><?php endforeach; ?></ul></div><?php endif; ?>

    <section class="rounded-xl bg-white p-6 text-black shadow-xl">
        <h2 class="mb-5 text-2xl font-semibold"><?= $carroEdicao === null ? 'Cadastrar veículo' : 'Editar veículo' ?></h2>
        <form method="post" action="admin_carros.php<?= $carroEdicao !== null ? '?editar=' . (int) $carroEdicao->getId() : '' ?>" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <input type="hidden" name="csrf_token" value="<?= luxcarsAdminEscape($csrfToken) ?>">
            <input type="hidden" name="acao" value="salvar">
            <input type="hidden" name="id" value="<?= $carroEdicao === null ? '' : (int) $carroEdicao->getId() ?>">
            <?php foreach ([
                'marca' => ['Marca', 'text'], 'modelo' => ['Modelo', 'text'], 'ano' => ['Ano', 'number'],
                'preco' => ['Preço (R$)', 'number'], 'imagem' => ['Caminho da imagem', 'text'],
                'quilometragem' => ['Quilometragem (km)', 'number'], 'cor' => ['Cor', 'text'],
                'combustivel' => ['Combustível', 'text'], 'cambio' => ['Câmbio', 'text'], 'versao' => ['Versão', 'text'],
            ] as $campo => [$rotulo, $tipo]): ?>
                <label class="grid gap-1"><?= $rotulo ?>
                    <input class="rounded border border-gray-300 p-3" type="<?= $tipo ?>" name="<?= $campo ?>" value="<?= luxcarsAdminEscape($dados[$campo]) ?>" <?= $campo === 'ano' ? 'min="1886" max="' . ((int) date('Y') + 1) . '"' : '' ?> <?= $campo === 'preco' ? 'min="0" step="0.01"' : '' ?> <?= $campo === 'quilometragem' ? 'min="0" step="1"' : '' ?> maxlength="<?= $campo === 'marca' ? 80 : ($campo === 'modelo' ? 120 : ($campo === 'imagem' ? 255 : 100)) ?>" <?= in_array($campo, ['marca', 'modelo', 'ano', 'preco'], true) ? 'required' : '' ?>>
                </label>
            <?php endforeach; ?>
            <label class="grid gap-1">Disponibilidade
                <select class="rounded border border-gray-300 p-3" name="status" required>
                    <?php foreach (['disponivel' => 'Disponível', 'indisponivel' => 'Indisponível', 'vendido' => 'Vendido'] as $valor => $rotulo): ?>
                        <option value="<?= $valor ?>" <?= $dados['status'] === $valor ? 'selected' : '' ?>><?= $rotulo ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label class="grid gap-1 sm:col-span-2">Descrição
                <textarea class="rounded border border-gray-300 p-3" name="descricao" rows="3"><?= luxcarsAdminEscape($dados['descricao']) ?></textarea>
            </label>
            <label class="grid gap-1 sm:col-span-2 lg:col-span-3">Informações adicionais
                <textarea class="rounded border border-gray-300 p-3" name="informacoes_adicionais" rows="3"><?= luxcarsAdminEscape($dados['informacoes_adicionais']) ?></textarea>
            </label>
            <div class="flex flex-wrap gap-3 sm:col-span-2 lg:col-span-3">
                <button class="rounded bg-black px-5 py-3 font-semibold text-white hover:bg-gray-800" type="submit"><?= $carroEdicao === null ? 'Cadastrar veículo' : 'Salvar alterações' ?></button>
                <?php if ($carroEdicao !== null): ?><a class="rounded bg-gray-200 px-5 py-3" href="admin_carros.php">Cancelar edição</a><?php endif; ?>
            </div>
        </form>
    </section>

    <section>
        <h2 class="mb-4 text-2xl font-semibold">Estoque (<?= count($carros) ?>)</h2>
        <?php if ($carros === []): ?><p class="rounded bg-gray-800 p-5">Nenhum veículo cadastrado.</p><?php else: ?>
            <div class="overflow-x-auto rounded-xl bg-white text-black">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-gray-100"><tr><th class="p-3">Veículo</th><th class="p-3">Ano</th><th class="p-3">Preço</th><th class="p-3">Disponibilidade</th><th class="p-3">Ações</th></tr></thead>
                    <tbody><?php foreach ($carros as $carro): ?>
                        <tr class="border-t"><td class="p-3 font-semibold"><?= luxcarsAdminEscape($carro->getMarca() . ' ' . $carro->getModelo()) ?></td><td class="p-3"><?= $carro->getAno() ?></td><td class="p-3">R$ <?= number_format($carro->getPreco(), 2, ',', '.') ?></td><td class="p-3"><?= luxcarsAdminEscape($carro->getStatus()) ?></td>
                        <td class="flex flex-wrap gap-3 p-3"><a class="text-blue-800 underline" href="admin_carros.php?editar=<?= (int) $carro->getId() ?>">Editar</a>
                            <form method="post" action="admin_carros.php" onsubmit="return confirm('Excluir este veículo? Os registros relacionados também serão removidos.')">
                                <input type="hidden" name="csrf_token" value="<?= luxcarsAdminEscape($csrfToken) ?>"><input type="hidden" name="acao" value="excluir"><input type="hidden" name="id" value="<?= (int) $carro->getId() ?>">
                                <button class="text-red-700 underline" type="submit">Excluir</button>
                            </form>
                        </td></tr>
                    <?php endforeach; ?></tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>
    <section>
        <h2 class="mb-4 text-2xl font-semibold">Solicita&ccedil;&otilde;es de test drive (<?= count($agendamentosTestDrive) ?>)</h2>
        <?php if ($agendamentosTestDrive === []): ?><p class="rounded bg-gray-800 p-5">Nenhuma solicita&ccedil;&atilde;o registrada.</p><?php else: ?>
            <div class="overflow-x-auto rounded-xl bg-white text-black">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-gray-100"><tr><th class="p-3">Cliente</th><th class="p-3">Contato</th><th class="p-3">Ve&iacute;culo</th><th class="p-3">Data e hor&aacute;rio</th><th class="p-3">Status</th></tr></thead>
                    <tbody><?php foreach ($agendamentosTestDrive as $agendamento): ?>
                        <tr class="border-t">
                            <td class="p-3 font-semibold"><?= luxcarsAdminEscape($agendamento['nome']) ?></td>
                            <td class="p-3"><a class="underline" href="mailto:<?= luxcarsAdminEscape($agendamento['email']) ?>"><?= luxcarsAdminEscape($agendamento['email']) ?></a><br><?= luxcarsAdminEscape($agendamento['telefone']) ?></td>
                            <td class="p-3"><?= luxcarsAdminEscape($agendamento['marca'] . ' ' . $agendamento['modelo']) ?></td>
                            <td class="p-3"><?= luxcarsAdminEscape(date('d/m/Y', strtotime($agendamento['data_agendamento']))) ?> &agrave;s <?= luxcarsAdminEscape(substr((string) $agendamento['horario'], 0, 5)) ?></td>
                            <td class="p-3"><?= luxcarsAdminEscape($agendamento['status']) ?></td>
                        </tr>
                    <?php endforeach; ?></tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>
</main>
<?php require dirname(__DIR__, 3) . '/includes/footer.php'; ?>
</body>
</html>
