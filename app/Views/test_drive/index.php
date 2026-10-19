<?php
declare(strict_types=1);

function eliteTestDriveEscape(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Agende uma experi&ecirc;ncia ao volante com os ve&iacute;culos premium da ELITE.">
    <title>ELITE | Agende um test drive</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/fonte.css">
    <link rel="stylesheet" href="../assets/css/site.css">
</head>
<body class="min-h-screen text-white">
<?php require dirname(__DIR__, 3) . '/includes/navbar.php'; ?>
<main class="mx-auto grid max-w-6xl gap-10 px-5 py-12 sm:px-8 lg:grid-cols-[.9fr_1.1fr] lg:py-20">
    <section class="flex flex-col justify-center" aria-labelledby="test-drive-titulo">
        <p class="text-sm font-semibold uppercase tracking-[.25em] text-gray-300">Experi&ecirc;ncia ELITE</p>
        <h1 id="test-drive-titulo" class="mt-3 text-4xl font-bold leading-tight sm:text-5xl">Conhe&ccedil;a seu pr&oacute;ximo carro ao volante.</h1>
        <p class="mt-5 max-w-xl leading-7 text-gray-300">Escolha um modelo e o melhor hor&aacute;rio. Nossa equipe confirma a disponibilidade e combina os detalhes com voc&ecirc;.</p>
        <div class="mt-8 grid gap-4 sm:grid-cols-3 lg:grid-cols-1">
            <div class="elite-surface p-4"><p class="font-semibold">Escolha o modelo</p><p class="mt-1 text-sm text-gray-400">Selecione entre os ve&iacute;culos dispon&iacute;veis.</p></div>
            <div class="elite-surface p-4"><p class="font-semibold">Agende seu hor&aacute;rio</p><p class="mt-1 text-sm text-gray-400">Atendimento de segunda a s&aacute;bado.</p></div>
            <div class="elite-surface p-4"><p class="font-semibold">Aguarde a confirma&ccedil;&atilde;o</p><p class="mt-1 text-sm text-gray-400">A equipe retorna pelos contatos informados.</p></div>
        </div>
    </section>

    <section class="rounded-2xl bg-white p-6 text-gray-950 shadow-2xl sm:p-8" aria-labelledby="form-test-drive-titulo">
        <h2 id="form-test-drive-titulo" class="text-2xl font-bold">Solicitar test drive</h2>
        <p class="mt-2 mb-6 text-sm text-gray-600">O envio registra uma solicita&ccedil;&atilde;o. O hor&aacute;rio depende da confirma&ccedil;&atilde;o da equipe.</p>

        <?php if ($sucesso !== null): ?>
            <p class="mb-5 rounded-lg border border-green-300 bg-green-50 p-4 text-green-900" role="status" aria-live="polite"><?= eliteTestDriveEscape(html_entity_decode((string) $sucesso, ENT_QUOTES, 'UTF-8')) ?></p>
        <?php endif; ?>
        <?php if ($erroBanco !== null): ?>
            <p class="mb-5 rounded-lg border border-red-300 bg-red-50 p-4 text-red-900" role="alert"><?= $erroBanco ?></p>
        <?php endif; ?>
        <?php if ($erros !== []): ?>
            <div class="mb-5 rounded-lg border border-red-300 bg-red-50 p-4 text-red-900" role="alert">
                <p class="font-semibold">Revise os dados:</p>
                <ul class="mt-2 list-inside list-disc"><?php foreach (array_unique($erros) as $erro): ?><li><?= eliteTestDriveEscape(html_entity_decode($erro, ENT_QUOTES, 'UTF-8')) ?></li><?php endforeach; ?></ul>
            </div>
        <?php endif; ?>

        <?php if ($erroBanco === null): ?>
            <form id="form-test-drive" method="post" action="seguroveic.php" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?= eliteTestDriveEscape($csrfToken) ?>">
                <label class="grid gap-1 font-medium" for="nome">Nome completo
                    <input id="nome" name="nome" type="text" autocomplete="name" minlength="2" maxlength="150" required value="<?= eliteTestDriveEscape($dados['nome']) ?>" class="rounded-lg border border-gray-300 p-3">
                </label>
                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="grid gap-1 font-medium" for="email">E-mail
                        <input id="email" name="email" type="email" autocomplete="email" maxlength="190" required value="<?= eliteTestDriveEscape($dados['email']) ?>" class="rounded-lg border border-gray-300 p-3">
                    </label>
                    <label class="grid gap-1 font-medium" for="telefone">Telefone com DDD
                        <input id="telefone" name="telefone" type="tel" autocomplete="tel" inputmode="tel" minlength="10" maxlength="20" placeholder="(00) 00000-0000" required value="<?= eliteTestDriveEscape($dados['telefone']) ?>" class="rounded-lg border border-gray-300 p-3">
                    </label>
                </div>
                <label class="grid gap-1 font-medium" for="carro_id">Ve&iacute;culo
                    <select id="carro_id" name="carro_id" required class="rounded-lg border border-gray-300 p-3">
                        <option value="">Selecione um modelo</option>
                        <?php foreach ($carros as $carro): ?>
                            <option value="<?= (int) $carro->getId() ?>" <?= $dados['carro_id'] === (string) $carro->getId() ? 'selected' : '' ?>><?= eliteTestDriveEscape($carro->getMarca() . ' ' . $carro->getModelo()) ?> &middot; <?= (int) $carro->getAno() ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if ($carros === []): ?><span class="text-sm text-gray-600">N&atilde;o h&aacute; ve&iacute;culos dispon&iacute;veis no momento.</span><?php endif; ?>
                </label>
                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="grid gap-1 font-medium" for="data">Data
                        <input id="data" name="data" type="date" min="<?= eliteTestDriveEscape($dataMinima) ?>" required value="<?= eliteTestDriveEscape($dados['data']) ?>" class="rounded-lg border border-gray-300 p-3">
                    </label>
                    <label class="grid gap-1 font-medium" for="horario">Hor&aacute;rio
                        <select id="horario" name="horario" required class="rounded-lg border border-gray-300 p-3">
                            <option value="">Selecione</option>
                            <?php foreach ($horarios as $horario): ?>
                                <option value="<?= eliteTestDriveEscape($horario) ?>" <?= $dados['horario'] === $horario ? 'selected' : '' ?>><?= eliteTestDriveEscape($horario) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <button class="w-full rounded-lg bg-gray-950 px-5 py-3 font-semibold text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2" type="submit" <?= $carros === [] ? 'disabled' : '' ?>>Solicitar agendamento</button>
                <p class="text-xs leading-5 text-gray-600">Seus dados ser&atilde;o usados pela equipe ELITE para retornar sobre este agendamento.</p>
            </form>
        <?php endif; ?>
    </section>
</main>
<script>
(() => {
    const form = document.getElementById('form-test-drive');
    if (!form) return;
    const data = document.getElementById('data');
    const telefone = document.getElementById('telefone');
    telefone.addEventListener('input', () => {
        const numeros = telefone.value.replace(/\D/g, '').slice(0, 11);
        if (numeros.length <= 2) telefone.value = numeros ? `(${numeros}` : '';
        else if (numeros.length <= 6) telefone.value = `(${numeros.slice(0, 2)}) ${numeros.slice(2)}`;
        else if (numeros.length <= 10) telefone.value = `(${numeros.slice(0, 2)}) ${numeros.slice(2, 6)}-${numeros.slice(6)}`;
        else telefone.value = `(${numeros.slice(0, 2)}) ${numeros.slice(2, 7)}-${numeros.slice(7)}`;
    });
    data.addEventListener('input', () => {
        if (!data.value) return;
        const selecionada = new Date(`${data.value}T12:00:00`).getDay();
        data.setCustomValidity(selecionada === 0 ? 'Escolha um dia de segunda a sábado.' : '');
    });
    form.addEventListener('submit', event => {
        if (!form.reportValidity()) { event.preventDefault(); return; }
        const button = form.querySelector('button[type="submit"]');
        button.disabled = true;
        button.textContent = 'Enviando solicitação…';
    });
})();
</script>
<?php require dirname(__DIR__, 3) . '/includes/footer.php'; ?>
</body>
</html>
