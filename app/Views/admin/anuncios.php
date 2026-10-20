<?php
declare(strict_types=1);
$escapeAnuncioAdmin = static fn (mixed $valor): string => htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
$rotulosStatusAnuncio = ['em_analise' => 'Em análise', 'aprovado' => 'Publicado', 'rejeitado' => 'Devolvido'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELITE | Análise de anúncios</title>
    <link rel="stylesheet" href="../assets/css/site.css?v=20261019-forms-ui">
    <link rel="stylesheet" href="../assets/css/anunciar.css?v=20261019-anuncios">
    <style>
        .admin-anuncios-main{width:min(100% - 2rem,1180px);margin:0 auto;padding:3rem 0 5rem}
        .admin-anuncios-title{display:flex;align-items:end;justify-content:space-between;gap:1rem;margin-bottom:1.5rem}
        .admin-anuncios-title h1{margin:0;font-size:clamp(2rem,4vw,3rem);letter-spacing:-.05em}
        .admin-anuncios-title a{color:#e4cf88}
        .admin-anuncio{margin:1rem 0;padding:clamp(1rem,3vw,1.6rem);border:1px solid rgba(224,199,123,.2);border-radius:1rem;background:linear-gradient(145deg,#17191d,#0c0d0f)}
        .admin-anuncio__top{display:flex;justify-content:space-between;align-items:flex-start;gap:1rem}
        .admin-anuncio h2{margin:0;font-size:1.4rem}.admin-anuncio p{color:#b7bac1;line-height:1.6}
        .admin-anuncio__specs{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:.6rem;margin:1rem 0;color:#d7d8dc;font-size:.82rem}
        .admin-anuncio__photos{display:flex;gap:.6rem;overflow:auto;padding:.4rem 0}
        .admin-anuncio__photos img{width:170px;height:115px;object-fit:cover;border-radius:.55rem;border:1px solid rgba(255,255,255,.15)}
        .admin-anuncio__files{display:flex;flex-wrap:wrap;gap:.8rem;margin:1rem 0}.admin-anuncio__files a{color:#e5d18d}
        .admin-anuncio__actions{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:1rem;align-items:end;margin-top:1.2rem}
        .admin-anuncio__actions textarea{width:100%;min-height:4.5rem;padding:.75rem;border:1px solid rgba(255,255,255,.15);border-radius:.6rem;color:white;background:#090a0c}
        .admin-anuncio__buttons{display:flex;gap:.6rem}.admin-anuncio__buttons button{padding:.75rem 1rem;border:1px solid rgba(255,255,255,.2);border-radius:.6rem;color:white;background:#202226;font-weight:700;cursor:pointer}
        .admin-anuncio__buttons button[name=acao][value=aprovar]{border-color:#d9c477;color:#111;background:#dfcc89}
        .admin-anuncio__review{display:grid;gap:.8rem;margin-top:1rem;padding-top:1rem;border-top:1px solid rgba(255,255,255,.1)}
        @media(max-width:650px){.admin-anuncios-title,.admin-anuncio__top{align-items:flex-start;flex-direction:column}.admin-anuncio__actions{grid-template-columns:1fr}.admin-anuncio__buttons{flex-wrap:wrap}}
    </style>
</head>
<body class="elite-anunciar-page">
<?php require dirname(__DIR__, 3) . '/includes/navbar.php'; ?>
<main class="admin-anuncios-main">
    <header class="admin-anuncios-title"><div><p class="anuncio-eyebrow">PAINEL ADMINISTRATIVO</p><h1>Análise de anúncios</h1></div><a href="admin_carros.php">Voltar ao estoque</a></header>
    <?php if ($mensagem !== null): ?><div class="anuncio-notice anuncio-notice--success" role="status"><?= $escapeAnuncioAdmin($mensagem) ?></div><?php endif; ?>
    <?php if ($erros !== []): ?><div class="anuncio-notice anuncio-notice--error" role="alert"><ul><?php foreach (array_unique($erros) as $erro): ?><li><?= $escapeAnuncioAdmin($erro) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
    <?php if ($solicitacoes === []): ?><p class="anuncio-empty">Nenhuma solicitação de anúncio registrada.</p><?php endif; ?>
    <?php foreach ($solicitacoes as $anuncio): ?>
        <?php $fotos = json_decode((string) $anuncio['fotos_json'], true); $fotos = is_array($fotos) ? array_values(array_filter($fotos, 'is_string')) : []; ?>
        <article class="admin-anuncio">
            <div class="admin-anuncio__top">
                <div><p class="anuncio-eyebrow">Solicitação #<?= (int) $anuncio['id'] ?> · <?= $escapeAnuncio(date('d/m/Y H:i', strtotime((string) $anuncio['criado_em']))) ?></p><h2><?= $escapeAnuncio($anuncio['marca'] . ' ' . $anuncio['modelo']) ?></h2></div>
                <span class="anuncio-status anuncio-status--<?= $escapeAnuncio($anuncio['status']) ?>"><?= $escapeAnuncio($rotulosStatusAnuncio[$anuncio['status']] ?? $anuncio['status']) ?></span>
            </div>
            <div class="admin-anuncio__specs">
                <span>Ano: <strong><?= (int) $anuncio['ano'] ?></strong></span><span>Preço: <strong>R$ <?= number_format((float) $anuncio['preco'], 2, ',', '.') ?></strong></span>
                <span>Quilometragem: <strong><?= number_format((int) $anuncio['quilometragem'], 0, ',', '.') ?> km</strong></span><span>Potência: <strong><?= (int) $anuncio['potencia'] ?> cv</strong></span>
                <span>Cor: <strong><?= $escapeAnuncio($anuncio['cor']) ?></strong></span><span>Combustível / câmbio: <strong><?= $escapeAnuncio($anuncio['combustivel'] . ' · ' . $anuncio['cambio']) ?></strong></span>
                <span>Motor: <strong><?= $escapeAnuncio($anuncio['motor']) ?></strong></span><span>Versão: <strong><?= $escapeAnuncio($anuncio['versao'] ?: 'Não informada') ?></strong></span>
            </div>
            <p><strong>Anunciante:</strong> <?= $escapeAnuncio($anuncio['anunciante_nome']) ?> · <a href="mailto:<?= $escapeAnuncio($anuncio['anunciante_email']) ?>"><?= $escapeAnuncio($anuncio['anunciante_email']) ?></a> · <?= $escapeAnuncio($anuncio['anunciante_telefone']) ?></p>
            <p><?= nl2br($escapeAnuncio($anuncio['descricao'])) ?></p>
            <?php if (!empty($anuncio['informacoes_adicionais'])): ?><p><strong>Informações adicionais:</strong><br><?= nl2br($escapeAnuncio($anuncio['informacoes_adicionais'])) ?></p><?php endif; ?>
            <div class="admin-anuncio__photos" aria-label="Fotos do veículo">
                <?php foreach ($fotos as $indice => $_foto): ?><a href="arquivo_anuncio.php?anuncio=<?= (int) $anuncio['id'] ?>&amp;arquivo=foto&amp;indice=<?= (int) $indice ?>" target="_blank" rel="noopener"><img loading="lazy" src="arquivo_anuncio.php?anuncio=<?= (int) $anuncio['id'] ?>&amp;arquivo=foto&amp;indice=<?= (int) $indice ?>" alt="Foto <?= (int) $indice + 1 ?> de <?= $escapeAnuncio($anuncio['marca'] . ' ' . $anuncio['modelo']) ?>"></a><?php endforeach; ?>
            </div>
            <div class="admin-anuncio__files"><a href="arquivo_anuncio.php?anuncio=<?= (int) $anuncio['id'] ?>&amp;arquivo=crlv">Baixar CRLV</a><?php if (!empty($anuncio['documento_extra_path'])): ?><a href="arquivo_anuncio.php?anuncio=<?= (int) $anuncio['id'] ?>&amp;arquivo=complementar">Baixar documento complementar</a><?php endif; ?></div>
            <?php if ($anuncio['status'] === 'em_analise'): ?>
                <form class="admin-anuncio__review" method="post" action="admin_anuncios.php">
                    <input type="hidden" name="csrf_token" value="<?= $escapeAnuncioAdmin($csrfToken) ?>"><input type="hidden" name="anuncio_id" value="<?= (int) $anuncio['id'] ?>">
                    <label>Orientação ao anunciante em caso de ajustes
                        <textarea name="observacao" maxlength="1000" placeholder="Explique o que precisa ser corrigido se devolver o anúncio."></textarea>
                    </label>
                    <div class="admin-anuncio__buttons"><button type="submit" name="acao" value="aprovar">Aprovar e publicar</button><button type="submit" name="acao" value="rejeitar">Devolver para ajustes</button></div>
                </form>
            <?php elseif (!empty($anuncio['admin_observacao'])): ?>
                <p class="anuncio-history__note"><strong>Orientação:</strong> <?= $escapeAnuncio($anuncio['admin_observacao']) ?></p>
            <?php endif; ?>
        </article>
    <?php endforeach; ?>
</main>
<?php require dirname(__DIR__, 3) . '/includes/footer.php'; ?>
</body>
</html>
