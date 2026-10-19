<?php
declare(strict_types=1);

function elitePerfilEscape(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

$nomePerfil = trim((string) ($dados['nome'] ?? ''));
$partesNome = preg_split('/\s+/u', $nomePerfil, -1, PREG_SPLIT_NO_EMPTY) ?: [];
$iniciaisPerfil = strtoupper(substr($partesNome[0] ?? 'U', 0, 1));
if (count($partesNome) > 1) {
    $iniciaisPerfil .= strtoupper(substr($partesNome[count($partesNome) - 1], 0, 1));
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELITE | Meu perfil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/fonte.css">
    <link rel="stylesheet" href="../assets/css/site.css?v=20261019-profile-agenda-panel">
</head>
<body class="min-h-screen bg-gradient-to-t from-black to-gray-900 text-white">
<?php require dirname(__DIR__, 3) . '/includes/navbar.php'; ?>
<main class="elite-profile-page">
    <header class="elite-profile-hero">
        <div class="elite-profile-identity">
            <div class="elite-profile-avatar" aria-hidden="true"><?= elitePerfilEscape($iniciaisPerfil) ?></div>
            <div>
                <p class="elite-profile-eyebrow">Área do cliente</p>
                <h1>Olá, <?= elitePerfilEscape($partesNome[0] ?? 'cliente') ?></h1>
                <p class="elite-profile-subtitle">Gerencie sua conta e continue explorando sua próxima conquista.</p>
            </div>
        </div>
        <span class="elite-profile-member"><span aria-hidden="true"></span> Conta <?= ($_SESSION['usuario_tipo'] ?? 'cliente') === 'admin' ? 'administradora' : 'cliente' ?></span>
    </header>

    <?php if ($mensagem !== null): ?><p class="elite-profile-alert elite-profile-alert--success" role="status"><?= elitePerfilEscape($mensagem) ?></p><?php endif; ?>
    <?php if ($erros !== []): ?><div class="elite-profile-alert elite-profile-alert--error" role="alert"><ul><?php foreach (array_unique($erros) as $erro): ?><li><?= elitePerfilEscape($erro) ?></li><?php endforeach; ?></ul></div><?php endif; ?>

    <nav class="elite-profile-shortcuts" aria-label="Minha conta">
        <a href="favoritos.php"><span class="elite-profile-shortcut-icon" aria-hidden="true">♡</span><span><strong>Favoritos</strong><small>Seus carros salvos</small></span><span class="elite-profile-arrow" aria-hidden="true">→</span></a>
        <a href="comparar.php"><span class="elite-profile-shortcut-icon" aria-hidden="true">⇄</span><span><strong>Comparar</strong><small>Coloque modelos lado a lado</small></span><span class="elite-profile-arrow" aria-hidden="true">→</span></a>
        <a href="historico.php"><span class="elite-profile-shortcut-icon" aria-hidden="true">◷</span><span><strong>Histórico</strong><small>Continue de onde parou</small></span><span class="elite-profile-arrow" aria-hidden="true">→</span></a>
        <a href="carrinho.php"><span class="elite-profile-shortcut-icon" aria-hidden="true">▱</span><span><strong>Carrinho</strong><small>Revise sua seleção</small></span><span class="elite-profile-arrow" aria-hidden="true">→</span></a>
        <a href="#meus-agendamentos"><span class="elite-profile-shortcut-icon" aria-hidden="true">&#9716;</span><span><strong>Agendamentos</strong><small><?= count($agendamentos) ?> test drive<?= count($agendamentos) === 1 ? '' : 's' ?></small></span><span class="elite-profile-arrow" aria-hidden="true">&rarr;</span></a>
    </nav>

    <div class="elite-profile-layout">
        <section class="elite-profile-card elite-profile-edit-card" aria-labelledby="perfil-dados-titulo">
            <div class="elite-profile-card-heading">
                <div>
                    <p class="elite-profile-eyebrow">Sua conta</p>
                    <h2 id="perfil-dados-titulo">Dados pessoais</h2>
                </div>
                <span class="elite-profile-step-label">Etapa <?= $edicaoAutorizada ? '2' : '1' ?> de 2</span>
            </div>
            <div class="elite-profile-progress" aria-label="Etapa <?= $edicaoAutorizada ? '2' : '1' ?> de 2"><span class="<?= $edicaoAutorizada ? 'is-complete' : '' ?>"></span><span class="<?= $edicaoAutorizada ? 'is-active' : '' ?>"></span></div>

            <?php if (!$edicaoAutorizada): ?>
                <div class="elite-profile-security-note"><span aria-hidden="true">⌑</span><p>Para proteger seus dados de acesso, confirme sua senha atual antes de liberar a edição do perfil.</p></div>
                <form method="post" action="perfil.php" class="elite-profile-form elite-profile-password-form">
                    <input type="hidden" name="csrf_token" value="<?= elitePerfilEscape($csrfToken) ?>">
                    <input type="hidden" name="acao" value="confirmar_senha">
                    <label class="elite-profile-field">Senha atual
                        <input type="password" name="senha_atual" autocomplete="current-password" required>
                    </label>
                    <button class="elite-profile-primary-button" type="submit">Confirmar e continuar <span aria-hidden="true">→</span></button>
                </form>
                <p class="elite-profile-footnote">A liberação de edição dura 5 minutos e é encerrada depois que você salva.</p>
            <?php else: ?>
                <form method="post" action="perfil.php" class="elite-profile-form">
                    <input type="hidden" name="csrf_token" value="<?= elitePerfilEscape($csrfToken) ?>">
                    <p class="elite-profile-section-label">Contato e acesso</p>
                    <div class="elite-profile-fields">
                        <label class="elite-profile-field elite-profile-field--wide">Nome completo
                            <input type="text" name="nome" maxlength="150" autocomplete="name" value="<?= elitePerfilEscape($dados['nome'] ?? '') ?>" required>
                        </label>
                        <label class="elite-profile-field">E-mail de acesso
                            <input type="email" name="email" maxlength="190" autocomplete="email" value="<?= elitePerfilEscape($dados['email'] ?? '') ?>" required>
                        </label>
                        <label class="elite-profile-field">Telefone
                            <input type="tel" name="telefone" maxlength="20" autocomplete="tel" value="<?= elitePerfilEscape($dados['telefone'] ?? '') ?>" required>
                        </label>
                    </div>
                    <p class="elite-profile-section-label">Endereço</p>
                    <div class="elite-profile-fields">
                        <label class="elite-profile-field elite-profile-field--wide">Endereço
                            <input type="text" name="endereco" maxlength="180" autocomplete="street-address" value="<?= elitePerfilEscape($dados['endereco'] ?? '') ?>" required>
                        </label>
                        <label class="elite-profile-field">Número
                            <input type="text" name="numero_endereco" maxlength="20" value="<?= elitePerfilEscape($dados['numero_endereco'] ?? '') ?>" required>
                        </label>
                        <label class="elite-profile-field">Cidade
                            <input type="text" name="cidade" maxlength="100" autocomplete="address-level2" value="<?= elitePerfilEscape($dados['cidade'] ?? '') ?>" required>
                        </label>
                        <label class="elite-profile-field">Estado (UF)
                            <input type="text" name="estado" maxlength="2" autocomplete="address-level1" value="<?= elitePerfilEscape($dados['estado'] ?? '') ?>" required>
                        </label>
                    </div>
                    <p class="elite-profile-readonly">CPF <strong><?= elitePerfilEscape($dados['cpf'] ?? '') ?></strong><span>Não editável</span></p>
                    <p class="elite-profile-readonly">Data de nascimento <strong><?= elitePerfilEscape($dados['data_nascimento'] ?? '') ?></strong><span>Não editável</span></p>
                    <div class="elite-profile-form-actions">
                        <button class="elite-profile-secondary-button" type="submit" name="acao" value="cancelar_edicao">Cancelar</button>
                        <button class="elite-profile-primary-button" type="submit" name="acao" value="salvar_perfil">Salvar alterações <span aria-hidden="true">→</span></button>
                    </div>
                </form>
            <?php endif; ?>
        </section>

        <aside class="elite-profile-side-column">
            <section class="elite-profile-card elite-profile-recent-card" aria-labelledby="ultimo-carro-titulo">
                <div class="elite-profile-card-heading elite-profile-card-heading--compact">
                    <div><p class="elite-profile-eyebrow">Sua jornada</p><h2 id="ultimo-carro-titulo">Visto por último</h2></div>
                    <span class="elite-profile-recent-mark" aria-hidden="true">↗</span>
                </div>
                <?php if ($ultimoCarro !== null): ?>
                    <a class="elite-profile-car-link" href="detalhes.php?id=<?= (int) $ultimoCarro['id'] ?>">
                        <div class="elite-profile-car-image">
                            <?php if (!empty($ultimoCarro['imagem'])): ?><img src="../<?= elitePerfilEscape($ultimoCarro['imagem']) ?>" alt="<?= elitePerfilEscape($ultimoCarro['marca'] . ' ' . $ultimoCarro['modelo']) ?>">
                            <?php else: ?><span aria-hidden="true">✦</span><?php endif; ?>
                        </div>
                        <div class="elite-profile-car-copy"><p><?= elitePerfilEscape($ultimoCarro['marca']) ?></p><h3><?= elitePerfilEscape($ultimoCarro['modelo']) ?></h3><span><?= (int) $ultimoCarro['ano'] ?> <b aria-hidden="true">·</b> <?= elitePerfilEscape($ultimoCarro['visualizado_em'] ?? '') ?></span></div>
                    </a>
                    <a class="elite-profile-text-link" href="historico.php">Ver histórico completo <span aria-hidden="true">→</span></a>
                <?php else: ?>
                    <div class="elite-profile-empty-history"><span aria-hidden="true">◷</span><p>Seu próximo carro começa por aqui.</p><a href="homepage.php">Explorar veículos <span aria-hidden="true">→</span></a></div>
                <?php endif; ?>
            </section>

            <section class="elite-profile-card elite-profile-intentions-card" aria-labelledby="intencoes-titulo">
                <div class="elite-profile-card-heading elite-profile-card-heading--compact"><div><p class="elite-profile-eyebrow">Acompanhamento</p><h2 id="intencoes-titulo">Interesses enviados</h2></div></div>
                <?php if ($intencoes === []): ?>
                    <p class="elite-profile-muted">Você ainda não enviou uma intenção de compra.</p>
                <?php else: ?>
                    <div class="elite-profile-intentions-list">
                        <?php foreach (array_slice($intencoes, 0, 3) as $intencao): ?>
                            <article><span class="elite-profile-intention-dot" aria-hidden="true"></span><div><h3><?= elitePerfilEscape($intencao['marca'] . ' ' . $intencao['modelo']) ?></h3><p><?= (int) $intencao['ano'] ?> <b aria-hidden="true">·</b> <?= elitePerfilEscape($intencao['status']) ?></p></div></article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>


        </aside>
    </div>
    <section class="elite-profile-card elite-profile-appointments-panel" id="meus-agendamentos" aria-labelledby="agendamentos-titulo">
        <div class="elite-profile-card-heading">
            <div><p class="elite-profile-eyebrow">Agenda de test drives</p><h2 id="agendamentos-titulo">Meus agendamentos</h2></div>
            <span class="elite-profile-appointments-count"><?= count($agendamentos) ?> <?= count($agendamentos) === 1 ? 'hor&aacute;rio' : 'hor&aacute;rios' ?></span>
        </div>
        <?php if ($agendamentos === []): ?>
            <div class="elite-profile-appointments-empty">
                <span class="elite-profile-appointments-empty__icon" aria-hidden="true">&#9716;</span>
                <div><h3>Nenhum test drive agendado</h3><p>Quando voc&ecirc; solicitar um hor&aacute;rio conectado &agrave; sua conta, ele aparecer&aacute; aqui com data e hora.</p></div>
                <a class="elite-profile-primary-button" href="seguroveic.php">Agendar test drive <span aria-hidden="true">&rarr;</span></a>
            </div>
        <?php else: ?>
            <div class="elite-profile-appointments-list">
                <?php foreach ($agendamentos as $agendamento): ?>
                    <?php
                    $statusAgendamento = match ($agendamento['status']) {
                        'confirmado' => 'Confirmado',
                        'concluido' => 'Concluido',
                        'cancelado' => 'Cancelado',
                        default => 'Aguardando confirmacao',
                    };
                    $dataAgendamento = (new DateTimeImmutable((string) $agendamento['data_agendamento']))->format('d/m/Y');
                    $horaAgendamento = substr((string) $agendamento['horario'], 0, 5);
                    ?>
                    <article class="elite-profile-appointment">
                        <div class="elite-profile-appointment__image">
                            <?php if (!empty($agendamento['imagem'])): ?><img src="../<?= elitePerfilEscape($agendamento['imagem']) ?>" alt="" loading="lazy"><?php else: ?><span aria-hidden="true">&#10022;</span><?php endif; ?>
                        </div>
                        <div class="elite-profile-appointment__body">
                            <h3><?= elitePerfilEscape($agendamento['marca'] . ' ' . $agendamento['modelo']) ?></h3>
                            <p class="elite-profile-appointment__year">Ano <?= (int) $agendamento['ano'] ?></p>
                            <div class="elite-profile-appointment__when">
                                <time datetime="<?= elitePerfilEscape($agendamento['data_agendamento']) ?>"><span>Data</span><strong><?= elitePerfilEscape($dataAgendamento) ?></strong></time>
                                <div><span>Hor&aacute;rio</span><strong><?= elitePerfilEscape($horaAgendamento) ?></strong></div>
                            </div>
                            <span class="elite-profile-appointment__status elite-profile-appointment__status--<?= elitePerfilEscape($agendamento['status']) ?>"><?= elitePerfilEscape($statusAgendamento) ?></span>
                        </div>
                        <a class="elite-profile-appointment__link" href="detalhes.php?id=<?= (int) $agendamento['carro_id'] ?>" aria-label="Ver <?= elitePerfilEscape($agendamento['marca'] . ' ' . $agendamento['modelo']) ?>">&rarr;</a>
                    </article>
                <?php endforeach; ?>
            </div>
            <a class="elite-profile-text-link" href="seguroveic.php">Agendar outro test drive <span aria-hidden="true">&rarr;</span></a>
        <?php endif; ?>
    </section>
</main>
<?php require dirname(__DIR__, 3) . '/includes/footer.php'; ?>
</body>
</html>
