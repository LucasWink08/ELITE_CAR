<?php
declare(strict_types=1);

function luxcarsPagamentoEscape(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxCars | Formas de pagamento</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/fonte.css">
    <link rel="stylesheet" href="../assets/css/site.css">
</head>
<body class="min-h-screen bg-gradient-to-t from-black to-gray-900 text-white">
<?php require dirname(__DIR__, 3) . '/includes/navbar.php'; ?>
<main class="mx-auto max-w-5xl space-y-8 p-6 sm:p-8">
    <h1 class="text-center text-4xl">Formas de pagamento</h1>

    <?php if ($erroBanco !== null): ?>
        <p class="rounded bg-red-900 p-4 text-center" role="alert"><?= luxcarsPagamentoEscape($erroBanco) ?></p>
    <?php elseif ($carro === null): ?>
        <p class="rounded bg-gray-800 p-5 text-center">Veículo não encontrado ou indisponível.</p>
        <p class="text-center"><a class="underline" href="paginadecompra.php">Voltar ao catálogo</a></p>
    <?php else: ?>
        <?php if ($mensagemIntencao !== null): ?><p class="rounded bg-green-900 p-4" role="status"><?= luxcarsPagamentoEscape($mensagemIntencao) ?></p><?php endif; ?>
        <?php if ($erroIntencao !== null): ?><p class="rounded bg-red-900 p-4" role="alert"><?= luxcarsPagamentoEscape($erroIntencao) ?></p><?php endif; ?>
        <?php $preco = $carro->getPreco(); ?>
        <section class="luxcars-car-card">
            <?php if ($carro->getImagem() !== null && $carro->getImagem() !== ''): ?>
                <img class="luxcars-car-card__image" src="<?= luxcarsPagamentoEscape('../' . ltrim($carro->getImagem(), '/')) ?>" alt="<?= luxcarsPagamentoEscape($carro->getMarca() . ' ' . $carro->getModelo()) ?>" loading="lazy">
            <?php else: ?>
                <div class="luxcars-car-card__placeholder">Imagem indisponível</div>
            <?php endif; ?>
            <div class="luxcars-car-card__content">
                <h2 class="luxcars-car-card__title"><?= luxcarsPagamentoEscape($carro->getMarca() . ' ' . $carro->getModelo()) ?></h2>
                <p class="luxcars-car-card__eyebrow">Ano <?= $carro->getAno() ?></p>
                <p class="luxcars-car-card__price">Preço integral: <span id="preco-integral">R$ <?= number_format($preco, 2, ',', '.') ?></span></p>
                <p class="luxcars-car-card__meta">As condições e a disponibilidade devem ser confirmadas com a concessionária.</p>
            </div>
        </section>

        <section>
            <h2 class="mb-4 text-2xl font-semibold">Opções para este veículo</h2>
            <div class="grid gap-4 sm:grid-cols-2">
                <article class="rounded-xl bg-gray-800 p-5">
                    <h3 class="text-xl font-semibold">À vista</h3>
                    <p class="mt-2">Pagamento integral de <strong>R$ <?= number_format($preco, 2, ',', '.') ?></strong>. Nenhum desconto à vista foi presumido.</p>
                </article>
                <article class="rounded-xl bg-gray-800 p-5">
                    <h3 class="text-xl font-semibold">PIX</h3>
                    <p class="mt-2">Referência de <strong>R$ <?= number_format($preco, 2, ',', '.') ?></strong>, sujeita à confirmação dos dados e da disponibilidade pela concessionária.</p>
                </article>
                <article class="rounded-xl bg-gray-800 p-5">
                    <h3 class="text-xl font-semibold">Cartão</h3>
                    <p class="mt-2">Consulte a administradora e a concessionária sobre limite, número de parcelas e eventuais encargos.</p>
                </article>
                <article class="rounded-xl bg-gray-800 p-5">
                    <h3 class="text-xl font-semibold">Financiamento</h3>
                    <p class="mt-2">Simule abaixo com entrada, taxa mensal e prazos. A aprovação e a taxa efetiva dependem da instituição financeira.</p>
                </article>
            </div>
        </section>

        <section class="rounded-xl bg-white p-6 text-black shadow-lg" data-preco="<?= number_format($preco, 2, '.', '') ?>" id="simulador">
            <h2 class="text-2xl font-semibold">Simular parcelas</h2>
            <p class="mt-1 text-gray-700">Estimativa informativa calculada sobre o preço deste veículo.</p>
            <div class="mt-5 grid gap-4 sm:grid-cols-2">
                <label class="grid gap-1" for="entrada">Entrada (R$)
                    <input class="rounded border border-gray-400 p-2" type="number" id="entrada" min="0" max="<?= number_format($preco, 2, '.', '') ?>" step="0.01" value="0">
                </label>
                <label class="grid gap-1" for="juros">Juros mensais estimados (%)
                    <input class="rounded border border-gray-400 p-2" type="number" id="juros" min="0" max="10" step="0.01" value="1.50">
                </label>
            </div>
            <p id="aviso-simulacao" class="mt-3 hidden rounded bg-red-100 p-3 text-red-800" role="alert"></p>
            <div id="opcoes-parcelamento" class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-3" aria-live="polite"></div>
            <p class="mt-5 text-sm text-gray-600">O valor final pode variar conforme análise de crédito, tarifas, seguros e condições oferecidas pela instituição. Esta página não realiza pagamento nem solicita dados de cartão.</p>
        </section>
        <section class="rounded-xl bg-gray-800 p-6" aria-labelledby="titulo-interesse">
            <h2 id="titulo-interesse" class="text-2xl font-semibold">Tenho interesse neste veículo</h2>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <form method="post" action="pagamento.php?id=<?= (int) $carro->getId() ?>" class="mt-4 space-y-3">
                    <input type="hidden" name="csrf_token" value="<?= luxcarsPagamentoEscape($csrfToken) ?>">
                    <input type="hidden" name="carro_id" value="<?= (int) $carro->getId() ?>">
                    <label class="grid gap-1" for="mensagem-interesse">Mensagem (opcional)
                        <textarea class="rounded border border-gray-300 p-3 text-black" id="mensagem-interesse" name="mensagem" rows="3" maxlength="1000" placeholder="Conte como prefere ser contatado ou tire uma dúvida."></textarea>
                    </label>
                    <button class="rounded bg-amber-400 px-5 py-3 font-semibold text-black hover:bg-amber-300" type="submit">Enviar intenção de compra</button>
                </form>
            <?php else: ?>
                <p class="mt-2">Entre na sua conta para enviar uma intenção de compra.</p>
                <a class="mt-3 inline-block underline" href="entrar.php">Entrar</a>
            <?php endif; ?>
        </section>
        <p class="text-center"><a class="underline" href="detalhes.php?id=<?= (int) $carro->getId() ?>">Voltar aos detalhes do veículo</a></p>
    <?php endif; ?>
</main>
<?php require dirname(__DIR__, 3) . '/includes/footer.php'; ?>
<?php if ($carro !== null): ?>
<script>
(() => {
    const painel = document.getElementById('simulador');
    const entradaInput = document.getElementById('entrada');
    const jurosInput = document.getElementById('juros');
    const opcoes = document.getElementById('opcoes-parcelamento');
    const aviso = document.getElementById('aviso-simulacao');
    const preco = Number(painel.dataset.preco);
    const prazos = [12, 24, 36, 48, 60];
    const moeda = valor => new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valor);

    function atualizar() {
        const entrada = Number(entradaInput.value);
        const taxaPercentual = Number(jurosInput.value);
        if (!Number.isFinite(entrada) || entrada < 0 || entrada > preco || !Number.isFinite(taxaPercentual) || taxaPercentual < 0 || taxaPercentual > 10) {
            aviso.textContent = 'Informe uma entrada entre R$ 0,00 e o preço do veículo e juros entre 0% e 10% ao mês.';
            aviso.classList.remove('hidden');
            opcoes.replaceChildren();
            return;
        }
        aviso.classList.add('hidden');
        const saldo = preco - entrada;
        const taxa = taxaPercentual / 100;
        opcoes.replaceChildren();

        const aVista = document.createElement('article');
        aVista.className = 'rounded-lg border border-gray-300 p-4';
        aVista.innerHTML = `<h3 class="font-semibold">À vista</h3><p class="mt-2">${moeda(preco)}</p>`;
        opcoes.append(aVista);

        prazos.forEach(prazo => {
            const parcela = taxa === 0
                ? saldo / prazo
                : saldo * taxa / (1 - Math.pow(1 + taxa, -prazo));
            const totalFinanciado = parcela * prazo;
            const totalComEntrada = totalFinanciado + entrada;
            const card = document.createElement('article');
            card.className = 'rounded-lg border border-gray-300 p-4';
            const titulo = document.createElement('h3');
            titulo.className = 'font-semibold';
            titulo.textContent = `${prazo} parcelas de ${moeda(parcela)}`;
            const detalhes = document.createElement('p');
            detalhes.className = 'mt-2 text-sm text-gray-700';
            detalhes.textContent = `Saldo financiado: ${moeda(saldo)}. Total das parcelas com juros: ${moeda(totalFinanciado)}. Total com entrada: ${moeda(totalComEntrada)}.`;
            card.append(titulo, detalhes);
            opcoes.append(card);
        });
    }

    entradaInput.addEventListener('input', atualizar);
    jurosInput.addEventListener('input', atualizar);
    atualizar();
})();
</script>
<?php endif; ?>
</body>
</html>
