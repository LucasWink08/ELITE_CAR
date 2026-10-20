<?php
declare(strict_types=1);

$escaparAnuncio = static fn (mixed $valor): string => htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
$statusAnuncio = static fn (string $status): string => match ($status) {
    'em_analise' => 'Em análise',
    'aprovado' => 'Aprovado',
    'rejeitado' => 'Precisa de ajustes',
    default => $status,
};
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Anuncie seu veículo premium na ELITE.">
    <title>ELITE | Anunciar veículo</title>
    <link rel="stylesheet" href="../assets/css/fonte.css">
    <link rel="stylesheet" href="../assets/css/site.css?v=20261019-anuncios">
    <link rel="stylesheet" href="../assets/css/anunciar.css?v=20261019-anuncios">
</head>
<body class="elite-anunciar-page">
<?php require dirname(__DIR__, 3) . '/includes/navbar.php'; ?>
<main class="anuncio-main">
    <header class="anuncio-intro">
        <p class="anuncio-eyebrow">ELITE · ESTOQUE SELECIONADO</p>
        <h1>Anuncie seu veículo</h1>
        <p>Conte a história do seu carro. Nossa equipe confere os dados e a documentação antes de publicar.</p>
        <div class="anuncio-promise"><span aria-hidden="true">✦</span> Veículos a partir de <strong>R$ 400.000</strong></div>
    </header>

    <?php if ($enviado): ?>
        <div class="anuncio-notice anuncio-notice--success" role="status">
            <?= $escaparAnuncio(is_string($mensagemSucesso) ? $mensagemSucesso : 'Anúncio enviado para análise.') ?>
        </div>
    <?php endif; ?>
    <?php if ($erros !== []): ?>
        <div class="anuncio-notice anuncio-notice--error" role="alert">
            <strong>Não foi possível enviar seu anúncio:</strong>
            <ul><?php foreach (array_unique($erros) as $erro): ?><li><?= $escaparAnuncio($erro) ?></li><?php endforeach; ?></ul>
        </div>
    <?php endif; ?>

    <section class="anuncio-card" aria-labelledby="form-title">
        <div class="anuncio-card__heading">
            <div><p class="anuncio-eyebrow">NOVO ANÚNCIO</p><h2 id="form-title">Apresente seu carro</h2></div>
            <span class="anuncio-required-note">* Campos obrigatórios</span>
        </div>

        <ol class="anuncio-steps" data-anuncio-steps aria-label="Etapas do anúncio">
            <li class="is-active" data-step-indicator="0"><span>01</span><span>Veículo</span></li>
            <li data-step-indicator="1"><span>02</span><span>Especificações</span></li>
            <li data-step-indicator="2"><span>03</span><span>Fotos</span></li>
            <li data-step-indicator="3"><span>04</span><span>Documentos</span></li>
        </ol>
        <div class="anuncio-progress" aria-hidden="true"><span data-anuncio-progress></span></div>

        <form action="anunciar.php" method="post" enctype="multipart/form-data" data-anuncio-form novalidate>
            <input type="hidden" name="csrf_token" value="<?= $escaparAnuncio($csrfToken) ?>">

            <fieldset class="anuncio-step-panel is-active" data-anuncio-panel="0">
                <legend>Identificação do veículo</legend>
                <p class="anuncio-step-lead">Comece com os dados que identificam o veículo.</p>
                <div class="anuncio-fields anuncio-fields--two">
                    <label>Marca <span>*</span>
                        <input name="marca" type="text" maxlength="80" autocomplete="organization" placeholder="Ex.: Porsche" required value="<?= $escaparAnuncio($dados['marca']) ?>">
                    </label>
                    <label>Modelo <span>*</span>
                        <input name="modelo" type="text" maxlength="120" placeholder="Ex.: 911 GT3 RS" required value="<?= $escaparAnuncio($dados['modelo']) ?>">
                    </label>
                    <label>Ano <span>*</span>
                        <input name="ano" type="number" min="1886" max="<?= (int) date('Y') + 1 ?>" placeholder="2024" required value="<?= $escaparAnuncio($dados['ano']) ?>">
                    </label>
                    <label>Quilometragem <span>*</span>
                        <div class="anuncio-input-suffix"><input name="quilometragem" type="number" min="0" max="5000000" step="1" placeholder="12.500" required value="<?= $escaparAnuncio($dados['quilometragem']) ?>"><span>km</span></div>
                    </label>
                    <label class="anuncio-field-full">Descrição do veículo <span>*</span>
                        <textarea name="descricao" rows="5" minlength="30" maxlength="3000" placeholder="Conte sobre o histórico, conservação, opcionais e diferenciais do veículo." required><?= $escaparAnuncio($dados['descricao']) ?></textarea>
                        <small>De 30 a 3.000 caracteres. Uma descrição clara ajuda a apresentar melhor o carro.</small>
                    </label>
                </div>
            </fieldset>

            <fieldset class="anuncio-step-panel" data-anuncio-panel="1" hidden>
                <legend>Especificações e preço</legend>
                <p class="anuncio-step-lead">Informe os detalhes técnicos e o valor pretendido.</p>
                <div class="anuncio-fields anuncio-fields--two">
                    <label>Cor <span>*</span>
                        <input name="cor" type="text" maxlength="60" placeholder="Ex.: Cinza Nardo" required value="<?= $escaparAnuncio($dados['cor']) ?>">
                    </label>
                    <label>Versão
                        <input name="versao" type="text" maxlength="100" placeholder="Ex.: Competition, Pista, AMG" value="<?= $escaparAnuncio($dados['versao']) ?>">
                    </label>
                    <label>Combustível <span>*</span>
                        <select name="combustivel" required>
                            <option value="">Selecione</option>
                            <?php foreach (['Gasolina', 'Etanol', 'Diesel', 'Híbrido', 'Elétrico'] as $combustivel): ?>
                                <option value="<?= $escaparAnuncio($combustivel) ?>" <?= $dados['combustivel'] === $combustivel ? 'selected' : '' ?>><?= $escaparAnuncio($combustivel) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label>Câmbio <span>*</span>
                        <select name="cambio" required>
                            <option value="">Selecione</option>
                            <?php foreach (['Automático', 'Automatizado', 'Manual', 'CVT'] as $cambio): ?>
                                <option value="<?= $escaparAnuncio($cambio) ?>" <?= $dados['cambio'] === $cambio ? 'selected' : '' ?>><?= $escaparAnuncio($cambio) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label>Motorização <span>*</span>
                        <input name="motor" type="text" maxlength="120" placeholder="Ex.: 4.0L V8 biturbo" required value="<?= $escaparAnuncio($dados['motor']) ?>">
                    </label>
                    <label>Potência <span>*</span>
                        <div class="anuncio-input-suffix"><input name="potencia" type="number" min="1" max="5000" step="1" placeholder="620" required value="<?= $escaparAnuncio($dados['potencia']) ?>"><span>cv</span></div>
                    </label>
                    <label>Preço anunciado <span>*</span>
                        <div class="anuncio-input-prefix"><span>R$</span><input name="preco" type="number" min="400000" max="999999999999.99" step="1000" placeholder="400.000" required value="<?= $escaparAnuncio($dados['preco']) ?>"></div>
                        <small>O valor mínimo permitido na ELITE é R$ 400.000,00.</small>
                    </label>
                    <label class="anuncio-field-full">Outras especificações
                        <textarea name="informacoes_adicionais" rows="4" maxlength="3000" placeholder="Tração, pacote opcional, histórico de revisões, quantidade de proprietários... "><?= $escaparAnuncio($dados['informacoes_adicionais']) ?></textarea>
                    </label>
                </div>
            </fieldset>

            <fieldset class="anuncio-step-panel" data-anuncio-panel="2" hidden>
                <legend>Fotos do veículo</legend>
                <p class="anuncio-step-lead">Envie fotos atuais e nítidas. A primeira selecionada será usada como capa.</p>
                <label class="anuncio-upload" for="fotos">
                    <span class="anuncio-upload__icon" aria-hidden="true">＋</span>
                    <strong>Escolher fotos do veículo <span>*</span></strong>
                    <span>JPG, PNG ou WebP · até 8 fotos · máximo 8 MB por foto</span>
                    <span>Mínimo de 960 × 540 pixels. Inclua exterior, interior e painel.</span>
                    <input id="fotos" name="fotos[]" type="file" accept="image/jpeg,image/png,image/webp" multiple required data-anuncio-photos>
                </label>
                <div class="anuncio-photo-preview" data-anuncio-preview aria-live="polite"></div>
                <p class="anuncio-privacy-note">Use somente imagens do veículo que você tem autorização para divulgar.</p>
            </fieldset>

            <fieldset class="anuncio-step-panel" data-anuncio-panel="3" hidden>
                <legend>Documentação</legend>
                <p class="anuncio-step-lead">Os documentos ficam em armazenamento privado e são vistos apenas pela equipe de análise.</p>
                <label class="anuncio-upload anuncio-upload--document" for="documento_crlv">
                    <span class="anuncio-upload__icon" aria-hidden="true">▤</span>
                    <strong>CRLV do veículo <span>*</span></strong>
                    <span>PDF, JPG, PNG ou WebP · máximo 12 MB</span>
                    <span>O documento será usado para conferir os dados do veículo. Não envie documentos pessoais.</span>
                    <input id="documento_crlv" name="documento_crlv" type="file" accept="application/pdf,image/jpeg,image/png,image/webp" required data-anuncio-document>
                </label>
                <p class="anuncio-file-name" data-document-name>Nenhum arquivo selecionado</p>
                <label class="anuncio-upload anuncio-upload--document" for="documento_extra">
                    <span class="anuncio-upload__icon" aria-hidden="true">＋</span>
                    <strong>Histórico de revisões ou laudo <small>(opcional)</small></strong>
                    <span>PDF, JPG, PNG ou WebP · máximo 12 MB</span>
                    <input id="documento_extra" name="documento_extra" type="file" accept="application/pdf,image/jpeg,image/png,image/webp" data-anuncio-extra-document>
                </label>
                <p class="anuncio-file-name" data-extra-document-name>Nenhum arquivo selecionado</p>
                <label class="anuncio-consent">
                    <input type="checkbox" name="confirmacao" value="1" required>
                    <span>Confirmo que sou responsável pelo anúncio, que os dados são verdadeiros e que posso disponibilizar o CRLV para conferência.</span>
                </label>
            </fieldset>

            <div class="anuncio-form-footer">
                <button type="button" class="anuncio-button anuncio-button--secondary" data-anuncio-back hidden>Voltar</button>
                <span class="anuncio-form-footer__spacer"></span>
                <button type="button" class="anuncio-button anuncio-button--primary" data-anuncio-next>Continuar <span aria-hidden="true">→</span></button>
                <button type="submit" class="anuncio-button anuncio-button--primary" data-anuncio-submit hidden>Enviar para análise <span aria-hidden="true">→</span></button>
            </div>
        </form>
    </section>

    <section class="anuncio-history" aria-labelledby="anuncios-title">
        <div class="anuncio-history__heading"><div><p class="anuncio-eyebrow">ACOMPANHAMENTO</p><h2 id="anuncios-title">Meus anúncios</h2></div><span><?= count($solicitacoes) ?> de 20 recentes</span></div>
        <?php if ($solicitacoes === []): ?>
            <p class="anuncio-empty">Seus anúncios enviados aparecerão aqui com o andamento da análise.</p>
        <?php else: ?>
            <div class="anuncio-history__list">
                <?php foreach ($solicitacoes as $solicitacao): ?>
                    <article class="anuncio-history__item">
                        <div><h3><?= $escaparAnuncio($solicitacao['marca'] . ' ' . $solicitacao['modelo']) ?></h3><p><?= (int) $solicitacao['ano'] ?> · R$ <?= number_format((float) $solicitacao['preco'], 2, ',', '.') ?></p>
                            <?php if (!empty($solicitacao['admin_observacao'])): ?><p class="anuncio-history__note"><?= $escaparAnuncio($solicitacao['admin_observacao']) ?></p><?php endif; ?>
                        </div>
                        <div class="anuncio-history__status"><span class="anuncio-status anuncio-status--<?= $escaparAnuncio($solicitacao['status']) ?>"><?= $escaparAnuncio($statusAnuncio((string) $solicitacao['status'])) ?></span>
                            <?php if ($solicitacao['status'] === 'rejeitado'): ?><a href="anunciar.php?revisar=<?= (int) $solicitacao['id'] ?>">Corrigir e reenviar</a><?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</main>
<?php require dirname(__DIR__, 3) . '/includes/footer.php'; ?>
<script src="../assets/js/anunciar.js?v=20261019-anuncios" defer></script>
</body>
</html>
