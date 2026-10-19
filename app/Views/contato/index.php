<?php
declare(strict_types=1);

function eliteContatoEscape(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Entre em contato com a equipe ELITE para tirar dúvidas sobre veículos e atendimento.">
    <title>ELITE | Contato</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/fonte.css">
    <link rel="stylesheet" href="../assets/css/site.css">
</head>
<body class="min-h-screen bg-gradient-to-t from-black to-gray-900 text-white">
<?php require dirname(__DIR__, 3) . '/includes/navbar.php'; ?>
<main class="mx-auto grid max-w-6xl gap-8 p-6 py-10 md:grid-cols-[.8fr_1.2fr] sm:p-10">
    <section class="space-y-4 self-center">
        <p class="text-sm font-semibold uppercase tracking-[.25em] text-amber-300">Atendimento ELITE</p>
        <h1 class="text-4xl font-bold sm:text-5xl">Como podemos ajudar?</h1>
        <p class="max-w-xl leading-7 text-gray-300">Envie sua dúvida sobre um veículo, condições de compra ou atendimento. Os campos marcados como obrigatórios precisam ser preenchidos.</p>
        <a class="inline-block text-amber-300 underline hover:text-amber-200" href="paginadecompra.php">Explorar veículos disponíveis</a>
    </section>

    <section class="rounded-2xl bg-white p-6 text-gray-950 shadow-2xl sm:p-8" aria-labelledby="formulario-contato-titulo">
        <h2 id="formulario-contato-titulo" class="mb-5 text-2xl font-bold">Envie uma mensagem</h2>
        <?php if ($sucesso !== null): ?>
            <p class="mb-5 rounded-lg border border-green-300 bg-green-50 p-4 text-green-900" role="status" aria-live="polite"><?= eliteContatoEscape($sucesso) ?></p>
        <?php endif; ?>
        <?php if ($erros !== []): ?>
            <div class="mb-5 rounded-lg border border-red-300 bg-red-50 p-4 text-red-900" role="alert">
                <p class="font-semibold">Revise os campos:</p>
                <ul class="mt-2 list-inside list-disc"><?php foreach (array_unique($erros) as $erro): ?><li><?= eliteContatoEscape($erro) ?></li><?php endforeach; ?></ul>
            </div>
        <?php endif; ?>

        <form id="form-contato" method="post" action="contato.php" class="space-y-4" novalidate>
            <input type="hidden" name="csrf_token" value="<?= eliteContatoEscape($csrfToken) ?>">
            <div class="absolute -left-[10000px] top-auto h-px w-px overflow-hidden" aria-hidden="true">
                <label for="website">Não preencha este campo</label>
                <input id="website" type="text" name="website" tabindex="-1" autocomplete="off">
            </div>
            <label class="grid gap-1 font-medium" for="nome">Nome
                <input class="rounded-lg border border-gray-300 p-3 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200" type="text" id="nome" name="nome" autocomplete="name" minlength="2" maxlength="150" required value="<?= eliteContatoEscape($dados['nome']) ?>">
            </label>
            <label class="grid gap-1 font-medium" for="email">E-mail
                <input class="rounded-lg border border-gray-300 p-3 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200" type="email" id="email" name="email" autocomplete="email" maxlength="190" required value="<?= eliteContatoEscape($dados['email']) ?>">
            </label>
            <label class="grid gap-1 font-medium" for="assunto">Assunto
                <input class="rounded-lg border border-gray-300 p-3 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200" type="text" id="assunto" name="assunto" minlength="3" maxlength="160" required value="<?= eliteContatoEscape($dados['assunto']) ?>">
            </label>
            <label class="grid gap-1 font-medium" for="mensagem">Mensagem
                <textarea class="rounded-lg border border-gray-300 p-3 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200" id="mensagem" name="mensagem" rows="6" minlength="10" maxlength="5000" required aria-describedby="contador-mensagem"><?= eliteContatoEscape($dados['mensagem']) ?></textarea>
            </label>
            <p id="contador-mensagem" class="text-right text-sm text-gray-600" aria-live="polite">0 / 5000 caracteres</p>
            <button class="w-full rounded-lg bg-gray-950 px-5 py-3 font-semibold text-white transition hover:bg-amber-500 hover:text-black focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-2" type="submit">Enviar mensagem</button>
            <p class="text-xs leading-5 text-gray-600">Ao enviar, sua mensagem será registrada pela ELITE para que a equipe possa tratar sua solicitação.</p>
        </form>
    </section>
</main>
<script>
(() => {
    const form = document.getElementById('form-contato');
    const campoMensagem = document.getElementById('mensagem');
    const contador = document.getElementById('contador-mensagem');
    const atualizarContador = () => { contador.textContent = `${campoMensagem.value.length} / 5000 caracteres`; };
    campoMensagem.addEventListener('input', atualizarContador);
    atualizarContador();
    form.addEventListener('submit', event => {
        if (!form.reportValidity()) {
            event.preventDefault();
            return;
        }
        const botao = form.querySelector('button[type="submit"]');
        botao.disabled = true;
        botao.textContent = 'Enviando…';
    });
})();
</script>
<?php require dirname(__DIR__, 3) . '/includes/footer.php'; ?>
</body>
</html>
