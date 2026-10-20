<?php
declare(strict_types=1);

function eliteListaEscape(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

$idsSelecionados = array_map(static fn (array $carro): int => (int) $carro['id'], $carros);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELITE | <?= eliteListaEscape($titulo) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/fonte.css">
    <link rel="stylesheet" href="../assets/css/site.css?v=20261019-compare-specs-top">
    <?php if ($modo === 'favoritos'): ?><link rel="stylesheet" href="../assets/css/favoritos.css?v=20261019-ui"><?php endif; ?>
</head>
<body class="min-h-screen text-white<?= $modo === 'favoritos' ? '' : ' bg-gradient-to-t from-black to-gray-900' ?>">
<?php require dirname(__DIR__, 3) . '/includes/navbar.php'; ?>
<main class="elite-account-list-page<?= $modo === 'favoritos' ? ' elite-account-list-page--favorites' : '' ?>">
    <?php if ($modo === 'favoritos'): ?>
        <header class="elite-account-list-heading elite-favorites-heading">
            <a class="elite-favorites-explore" href="paginadecompra.php"><span aria-hidden="true">+</span> Explorar ve&iacute;culos</a>
            <p class="elite-account-list-eyebrow">Sua garagem</p>
            <h1><?= eliteListaEscape($titulo) ?></h1>
            <p>Os modelos que você guardou para rever depois.</p>
        </header>
        <div class="elite-favorites-count"><span aria-hidden="true">&#9829;</span><strong><?= count($carros) ?></strong> <?= count($carros) === 1 ? 've&iacute;culo salvo' : 've&iacute;culos salvos' ?></div>
        <?php if ($mensagem !== null): ?><p class="elite-account-alert elite-account-alert--success" role="status"><?= eliteListaEscape($mensagem) ?></p><?php endif; ?>
        <?php if ($erro !== null): ?><p class="elite-account-alert elite-account-alert--error" role="alert"><?= eliteListaEscape($erro) ?></p><?php endif; ?>
        <?php if ($carros === []): ?>
            <section class="elite-account-empty"><span aria-hidden="true">♡</span><h2>Sua lista começa aqui</h2><p>Salve os veículos que chamarem sua atenção e encontre todos neste espaço.</p><a href="paginadecompra.php">Explorar veículos <span aria-hidden="true">→</span></a></section>
        <?php else: ?>
            <section class="elite-favorites-grid">
                <?php foreach ($carros as $carro): ?>
                    <article class="elite-favorite-card">
                        <a class="elite-favorite-card__image" href="detalhes.php?id=<?= (int) $carro['id'] ?>">
                            <span class="elite-favorite-card__saved"><span aria-hidden="true">&#9829;</span> Favorito</span>
                            <?php if (!empty($carro['imagem'])): ?><img src="<?= eliteListaEscape('../' . ltrim((string) $carro['imagem'], '/')) ?>" alt="<?= eliteListaEscape($carro['marca'] . ' ' . $carro['modelo']) ?>" loading="lazy"><?php else: ?><span>Imagem indisponível</span><?php endif; ?>
                        </a>
                        <div class="elite-favorite-card__body">
                            <p><?= eliteListaEscape($carro['marca']) ?> <span>·</span> <?= (int) $carro['ano'] ?></p>
                            <h2><?= eliteListaEscape($carro['modelo']) ?></h2>
                            <div class="elite-favorite-card__price"><span>Pre&ccedil;o anunciado</span><strong>R$ <?= number_format((float) $carro['preco'], 2, ',', '.') ?></strong></div>
                            <a class="elite-favorite-card__details" href="detalhes.php?id=<?= (int) $carro['id'] ?>">Ver detalhes <span aria-hidden="true">→</span></a>
                            <div class="elite-favorite-card__actions">
                                <form method="post" action="favoritos.php">
                                    <input type="hidden" name="csrf_token" value="<?= eliteListaEscape($csrfToken) ?>"><input type="hidden" name="acao" value="remover"><input type="hidden" name="carro_id" value="<?= (int) $carro['id'] ?>">
                                    <button type="submit">Remover favorito</button>
                                </form>
                                <form method="post" action="comparar.php">
                                    <input type="hidden" name="csrf_token" value="<?= eliteListaEscape($csrfToken) ?>"><input type="hidden" name="acao" value="adicionar"><input type="hidden" name="carro_id" value="<?= (int) $carro['id'] ?>">
                                    <button type="submit">Comparar</button>
                                </form>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </section>
        <?php endif; ?>
        <a class="elite-account-back-link" href="perfil.php">← Voltar ao perfil</a>
    <?php else: ?>
        <header class="elite-compare-heading">
            <div>
                <p class="elite-account-list-eyebrow">Escolha com confiança</p>
                <h1><?= eliteListaEscape($titulo) ?></h1>
                <p>Compare os detalhes lado a lado e encontre o modelo certo para você.</p>
            </div>
            <div class="elite-compare-count"><strong><?= count($carros) ?></strong><span>de 3 veículos</span><div class="elite-compare-count__bar"><span style="width: <?= min(100, count($carros) / 3 * 100) ?>%"></span></div></div>
        </header>
        <?php if ($mensagem !== null): ?><p class="elite-account-alert elite-account-alert--success" role="status"><?= eliteListaEscape($mensagem) ?></p><?php endif; ?>
        <?php if ($erro !== null): ?><p class="elite-account-alert elite-account-alert--error" role="alert"><?= eliteListaEscape($erro) ?></p><?php endif; ?>

        <section class="elite-compare-add-card" aria-labelledby="adicionar-comparacao-titulo">
            <div class="elite-compare-add-copy"><span class="elite-compare-add-icon" aria-hidden="true">＋</span><div><h2 id="adicionar-comparacao-titulo">Monte sua comparação</h2><p>Adicione até três veículos disponíveis. Você pode trocar os modelos quando quiser.</p></div></div>
            <?php if (count($carros) < 3): ?>
                <?php $opcoesRestantes = array_filter($opcoesCarros, static fn ($opcao): bool => !in_array($opcao->getId(), $idsSelecionados, true)); ?>
                <?php if ($opcoesRestantes !== []): ?>
                    <form class="elite-compare-add-form" method="post" action="comparar.php">
                        <input type="hidden" name="csrf_token" value="<?= eliteListaEscape($csrfToken) ?>"><input type="hidden" name="acao" value="adicionar">
                        <label class="sr-only" for="comparar-carro">Escolha um veículo</label>
                        <select id="comparar-carro" name="carro_id" required>
                            <option value="">Selecione um veículo</option>
                            <?php foreach ($opcoesRestantes as $opcao): ?><option value="<?= (int) $opcao->getId() ?>"><?= eliteListaEscape($opcao->getMarca() . ' ' . $opcao->getModelo() . ' · ' . $opcao->getAno()) ?></option><?php endforeach; ?>
                        </select>
                        <button type="submit">Adicionar veículo <span aria-hidden="true">→</span></button>
                    </form>
                <?php else: ?>
                    <p class="elite-compare-limit-note">Não há outros veículos disponíveis para adicionar.</p>
                <?php endif; ?>
            <?php else: ?>
                <p class="elite-compare-limit-note">Você chegou ao limite. Remova um modelo para adicionar outro.</p>
            <?php endif; ?>
        </section>

        <?php if ($carros === []): ?>
            <section class="elite-account-empty elite-compare-empty"><span aria-hidden="true">⇄</span><h2>Nenhum veículo selecionado</h2><p>Use o seletor acima para começar uma comparação ou escolha um carro no catálogo.</p><a href="paginadecompra.php">Abrir catálogo <span aria-hidden="true">→</span></a></section>
        <?php else: ?>
            <?php $especificacoes = [
                'Ano' => static fn (array $c): string => (string) $c['ano'],
                'Preço' => static fn (array $c): string => 'R$ ' . number_format((float) $c['preco'], 2, ',', '.'),
                'Quilometragem' => static fn (array $c): string => $c['quilometragem'] === null ? 'Não informado' : number_format((int) $c['quilometragem'], 0, ',', '.') . ' km',
                'Combustível' => static fn (array $c): string => trim((string) $c['combustivel']) !== '' ? (string) $c['combustivel'] : 'Não informado',
                'Câmbio' => static fn (array $c): string => trim((string) $c['cambio']) !== '' ? (string) $c['cambio'] : 'Não informado',
                'Cor' => static fn (array $c): string => trim((string) $c['cor']) !== '' ? (string) $c['cor'] : 'Não informada',
                'Versão' => static fn (array $c): string => trim((string) $c['versao']) !== '' ? (string) $c['versao'] : 'Não informada',
                'Disponibilidade' => static fn (array $c): string => match ($c['status']) { 'disponivel' => 'Disponível', 'vendido' => 'Vendido', default => 'Indisponível' },
            ]; ?>
            <div class="elite-compare-toolbar"><span>Os campos diferentes entre os modelos aparecem destacados.</span><form method="post" action="comparar.php" onsubmit="return confirm('Limpar todos os veículos da comparação?')"><input type="hidden" name="csrf_token" value="<?= eliteListaEscape($csrfToken) ?>"><input type="hidden" name="acao" value="limpar"><button type="submit">Limpar comparação</button></form></div>
            <div class="elite-compare-table-scroll">
                <table class="elite-compare-table">
                    <thead><tr><th class="elite-compare-row-label"><span>Especificações</span></th>
                        <?php foreach ($carros as $carro): ?>
                            <th class="elite-compare-vehicle">
                                <div class="elite-compare-vehicle__image"><?php if (!empty($carro['imagem'])): ?><img src="<?= eliteListaEscape('../' . ltrim((string) $carro['imagem'], '/')) ?>" alt="<?= eliteListaEscape($carro['marca'] . ' ' . $carro['modelo']) ?>" loading="lazy"><?php else: ?><span>Imagem indisponível</span><?php endif; ?></div>
                                <p><?= eliteListaEscape($carro['marca']) ?></p><h2><?= eliteListaEscape($carro['modelo']) ?></h2>
                                <div class="elite-compare-vehicle__actions"><a href="detalhes.php?id=<?= (int) $carro['id'] ?>">Ver detalhes</a><form method="post" action="comparar.php"><input type="hidden" name="csrf_token" value="<?= eliteListaEscape($csrfToken) ?>"><input type="hidden" name="acao" value="remover"><input type="hidden" name="carro_id" value="<?= (int) $carro['id'] ?>"><button type="submit" aria-label="Remover <?= eliteListaEscape($carro['marca'] . ' ' . $carro['modelo']) ?> da comparação">Remover</button></form></div>
                            </th>
                        <?php endforeach; ?>
                    </tr></thead>
                    <tbody>
                        <?php foreach ($especificacoes as $rotulo => $formatar): ?>
                            <?php $valores = array_map($formatar, $carros); $diferentes = count(array_unique($valores)) > 1; ?>
                            <tr><th class="elite-compare-row-label"><?= eliteListaEscape($rotulo) ?></th>
                                <?php foreach ($carros as $indice => $carro): ?>
                                    <td class="<?= $diferentes ? 'is-different' : '' ?> <?= $valores[$indice] === 'Não informado' || $valores[$indice] === 'Não informada' ? 'is-unavailable' : '' ?>"><span><?= eliteListaEscape($valores[$indice]) ?></span><?php if ($rotulo === 'Preço' && (float) $carro['preco'] === min(array_map(static fn (array $item): float => (float) $item['preco'], $carros))): ?><small>Menor preço</small><?php endif; ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        <div class="elite-account-bottom-links"><a class="elite-account-back-link" href="paginadecompra.php">← Voltar ao catálogo</a><a class="elite-account-back-link" href="perfil.php">Voltar ao perfil →</a></div>
    <?php endif; ?>
</main>
<?php require dirname(__DIR__, 3) . '/includes/footer.php'; ?>
</body>
</html>
