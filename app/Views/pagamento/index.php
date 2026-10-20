<?php
declare(strict_types=1);

function elitePagamentoEscape(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#090a0c">
    <title>ELITE | Formas de pagamento</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/fonte.css">
    <link rel="stylesheet" href="../assets/css/site.css">
    <link rel="stylesheet" href="../assets/css/pagamento.css">
    <?php if ($carro !== null): ?>
        <script src="../assets/js/pagamento.js" defer></script>
    <?php endif; ?>
</head>
<body class="elite-payment-page">
<?php require dirname(__DIR__, 3) . '/includes/navbar.php'; ?>
<main class="payment-shell">
    <header class="payment-heading">
        <p class="payment-eyebrow">ELITE · COMPRA SEGURA</p>
        <h1>Formas de pagamento</h1>
        <p>Conheça as opções para este veículo e monte uma estimativa de financiamento.</p>
    </header>

    <?php if ($erroBanco !== null): ?>
        <p class="payment-alert payment-alert--error" role="alert"><?= elitePagamentoEscape($erroBanco) ?></p>
    <?php elseif ($carro === null): ?>
        <section class="payment-empty">
            <span class="payment-empty__icon" aria-hidden="true">!</span>
            <h2>Veículo indisponível</h2>
            <p>Não encontramos este veículo ou ele não está mais disponível no estoque.</p>
            <a class="payment-button payment-button--primary" href="paginadecompra.php">Voltar ao catálogo</a>
        </section>
    <?php else: ?>
        <?php
        $preco = (float) $carro->getPreco();
        $imagem = $carro->getImagem();
        $nomeCarro = trim($carro->getMarca() . ' ' . $carro->getModelo());
        ?>

        <?php if ($mensagemIntencao !== null): ?>
            <p class="payment-alert payment-alert--success" role="status"><?= elitePagamentoEscape($mensagemIntencao) ?></p>
        <?php endif; ?>
        <?php if ($erroIntencao !== null): ?>
            <p class="payment-alert payment-alert--error" role="alert"><?= elitePagamentoEscape($erroIntencao) ?></p>
        <?php endif; ?>

        <section class="payment-vehicle" aria-labelledby="payment-vehicle-title">
            <div class="payment-vehicle__media">
                <?php if ($imagem !== null && $imagem !== ''): ?>
                    <img src="<?= elitePagamentoEscape('../' . ltrim($imagem, '/')) ?>" alt="<?= elitePagamentoEscape($nomeCarro) ?>" fetchpriority="high">
                <?php else: ?>
                    <div class="payment-vehicle__placeholder" aria-label="Imagem indisponível"><span>ELITE</span></div>
                <?php endif; ?>
            </div>
            <div class="payment-vehicle__body">
                <p class="payment-eyebrow">VEÍCULO SELECIONADO</p>
                <h2 id="payment-vehicle-title"><?= elitePagamentoEscape($nomeCarro) ?></h2>
                <span class="payment-year">ANO <?= (int) $carro->getAno() ?></span>
                <div class="payment-vehicle__price">
                    <span>Preço anunciado</span>
                    <strong>R$ <?= number_format($preco, 2, ',', '.') ?></strong>
                </div>
                <p class="payment-vehicle__note">Preço sujeito à confirmação de disponibilidade e condições comerciais.</p>
            </div>
        </section>

        <section class="payment-methods" aria-labelledby="payment-methods-title">
            <div class="payment-section-heading">
                <div>
                    <p class="payment-eyebrow">ESCOLHA COMO PAGAR</p>
                    <h2 id="payment-methods-title">Opções para este veículo</h2>
                </div>
            </div>
            <div class="payment-method-grid">
                <article class="payment-method">
                    <span class="payment-method__icon" aria-hidden="true">R$</span>
                    <div><h3>À vista</h3><p>Pagamento integral do valor anunciado.</p></div>
                    <strong>R$ <?= number_format($preco, 2, ',', '.') ?></strong>
                    <small>Sem desconto presumido. Consulte as condições.</small>
                </article>
                <article class="payment-method">
                    <span class="payment-method__icon" aria-hidden="true">◇</span>
                    <div><h3>PIX</h3><p>Uma opção prática para pagamento integral.</p></div>
                    <strong>Consulte a concessionária</strong>
                    <small>Confirme os dados de pagamento diretamente com a equipe.</small>
                </article>
                <article class="payment-method">
                    <span class="payment-method__icon" aria-hidden="true">▤</span>
                    <div><h3>Cartão</h3><p>Consulte as possibilidades de pagamento.</p></div>
                    <strong>Condições sob consulta</strong>
                    <small>Limite, parcelas e encargos dependem da administradora.</small>
                </article>
                <article class="payment-method payment-method--featured">
                    <span class="payment-method__icon" aria-hidden="true">↗</span>
                    <div><h3>Financiamento</h3><p>Personalize a entrada, a taxa e o prazo.</p></div>
                    <a href="#simulador">Simular parcelas <span aria-hidden="true">↓</span></a>
                    <small>Estimativa informativa; sujeita à análise de crédito.</small>
                </article>
            </div>
        </section>

        <section class="payment-calculator" id="simulador" data-preco="<?= number_format($preco, 2, '.', '') ?>" data-taxa-anual="26.42" aria-labelledby="simulator-title">
            <div class="payment-calculator__header">
                <div>
                    <p class="payment-eyebrow">SIMULAÇÃO PERSONALIZADA</p>
                    <h2 id="simulator-title">Encontre uma parcela que faça sentido</h2>
                    <p>Altere os valores para comparar cenários estimados de financiamento.</p>
                </div>
                <span class="payment-calculator__badge"><span aria-hidden="true">●</span> Sistema Price</span>
            </div>

            <div class="payment-input-grid payment-input-grid--fixed-rate">
                <div class="payment-field payment-field--entry">
                    <label for="entrada">Valor de entrada</label>
                    <div class="payment-input-wrap"><span aria-hidden="true">R$</span><input type="number" id="entrada" min="0" max="<?= number_format($preco, 2, '.', '') ?>" step="1000" value="0" inputmode="decimal" aria-describedby="entrada-ajuda"></div>
                    <input class="payment-range" type="range" id="entrada-range" min="0" max="100" value="0" aria-label="Percentual do preço como entrada">
                    <div class="payment-field__helper" id="entrada-ajuda"><span>Entrada como percentual do veículo</span><strong id="entrada-percentual">0%</strong></div>
                </div>
                <article class="payment-rate-card" aria-label="Taxa fixa de referência do Banco Central">
                    <span class="payment-rate-card__icon" aria-hidden="true">BCB</span>
                    <div>
                        <p class="payment-rate-card__label">Taxa fixa de referência</p>
                        <strong>1,97% <span>ao mês</span></strong>
                        <p>Média nacional para financiamento de veículos por pessoa física · ago/2026</p>
                        <a href="https://dadosabertos.bcb.gov.br/dataset/25471-taxa-media-mensal-de-juros-das-operacoes-de-credito-com-recursos-livres---pessoas-fisicas---a">Fonte: Banco Central do Brasil <span aria-hidden="true">↗</span></a>
                    </div>
                </article>
            </div>

            <div class="payment-summary" aria-live="polite">
                <div><span>Valor do veículo</span><strong id="resumo-preco">R$ <?= number_format($preco, 2, ',', '.') ?></strong></div>
                <div><span>Entrada</span><strong id="resumo-entrada">R$ 0,00</strong></div>
                <div><span>Saldo financiado</span><strong id="saldo-financiado">R$ <?= number_format($preco, 2, ',', '.') ?></strong></div>
                <div><span>Taxa anual equivalente</span><strong id="juros-anual">26,42% a.a.</strong></div>
            </div>

            <div class="payment-results-heading">
                <div><h3>Compare os prazos</h3><p>Parcelas fixas calculadas pelo Sistema Price.</p></div>
                <span>12 a 60 meses</span>
            </div>
            <p id="aviso-simulacao" class="payment-alert payment-alert--error" role="alert" hidden></p>
            <div id="opcoes-parcelamento" class="payment-results" aria-live="polite" aria-atomic="false"></div>

            <div class="payment-disclaimer">
                <span aria-hidden="true">i</span>
                <p>Simulação estimada, sem compromisso de aprovação. O custo efetivo pode variar após análise da instituição financeira e incluir tarifas, seguros, impostos ou outros encargos. Confirme a proposta final com a concessionária.</p>
            </div>
        </section>

        <section class="payment-contact" aria-labelledby="titulo-interesse">
            <div class="payment-contact__intro">
                <p class="payment-eyebrow">ATENDIMENTO ELITE</p>
                <h2 id="titulo-interesse">Quer conversar sobre este veículo?</h2>
                <p>Nossa equipe pode confirmar disponibilidade e apresentar as condições atuais.</p>
            </div>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <form method="post" action="pagamento.php?id=<?= (int) $carro->getId() ?>" class="payment-contact__form">
                    <input type="hidden" name="csrf_token" value="<?= elitePagamentoEscape($csrfToken) ?>">
                    <input type="hidden" name="carro_id" value="<?= (int) $carro->getId() ?>">
                    <label for="mensagem-interesse">Mensagem <span>(opcional)</span></label>
                    <textarea id="mensagem-interesse" name="mensagem" rows="3" maxlength="1000" placeholder="Conte como prefere ser contatado ou tire uma dúvida."></textarea>
                    <button class="payment-button payment-button--primary" type="submit">Solicitar contato <span aria-hidden="true">→</span></button>
                </form>
            <?php else: ?>
                <div class="payment-contact__signin">
                    <p>Entre na sua conta para registrar seu interesse e receber atendimento.</p>
                    <a class="payment-button payment-button--primary" href="entrar.php">Entrar na minha conta <span aria-hidden="true">→</span></a>
                </div>
            <?php endif; ?>
        </section>
        <p class="payment-back"><a href="detalhes.php?id=<?= (int) $carro->getId() ?>"><span aria-hidden="true">←</span> Voltar aos detalhes do veículo</a></p>
    <?php endif; ?>
</main>
<?php require dirname(__DIR__, 3) . '/includes/footer.php'; ?>
</body>
</html>
