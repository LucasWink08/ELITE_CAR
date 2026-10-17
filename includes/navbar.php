<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$luxcarsScriptName = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? ''));
$luxcarsPagesPosition = strpos($luxcarsScriptName, '/paginas/');
$luxcarsBasePath = $luxcarsPagesPosition === false
    ? '/'
    : substr($luxcarsScriptName, 0, $luxcarsPagesPosition + 1);
$luxcarsEscape = static fn (mixed $value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$luxcarsUsuario = isset($_SESSION['usuario']) && is_string($_SESSION['usuario'])
    ? $_SESSION['usuario']
    : null;
$luxcarsAutenticado = $luxcarsUsuario !== null && isset($_SESSION['usuario_id']);
$luxcarsPagina = static fn (string $pagina): string => $luxcarsBasePath . 'paginas/' . $pagina;
?>
<header class="luxcars-site-header">
    <nav class="luxcars-site-nav" aria-label="Navega&ccedil;&atilde;o principal" style="box-sizing:border-box;width:100%;max-width:none;margin:0">
        <a class="luxcars-site-nav__brand" href="<?= $luxcarsEscape($luxcarsPagina('homepage.php')) ?>" aria-label="LuxCars, p&aacute;gina inicial">
            <img src="<?= $luxcarsEscape($luxcarsBasePath . 'assets/imagens/logos/site.png') ?>" width="180" height="64" style="width:min(180px,40vw);height:min(64px,14.22vw);max-width:none;object-fit:cover;object-position:center 68%" alt="" aria-hidden="true" draggable="false">
        </a>
        <button class="luxcars-site-nav__toggle" type="button" data-luxcars-menu-toggle aria-controls="luxcars-menu" aria-expanded="false" aria-label="Abrir menu">
            <span aria-hidden="true">&#9776;</span>
        </button>
        <div class="luxcars-site-nav__links" id="luxcars-menu" data-luxcars-menu>
            <div class="luxcars-site-nav__primary">
                <a href="<?= $luxcarsEscape($luxcarsPagina('homepage.php')) ?>">In&iacute;cio</a>
                <a href="<?= $luxcarsEscape($luxcarsPagina('paginadecompra.php')) ?>">Comprar</a>
                <a href="<?= $luxcarsEscape($luxcarsPagina('anunciar.php')) ?>">Anunciar</a>
                <a href="<?= $luxcarsEscape($luxcarsPagina('tabelafipe.php')) ?>">Tabela FIPE</a>
                <a href="<?= $luxcarsEscape($luxcarsPagina('seguroveic.php')) ?>">Agendar test drive</a>
                <a href="<?= $luxcarsEscape($luxcarsPagina('contato.php')) ?>">Contato</a>
            </div>
            <div class="luxcars-site-nav__account">
                <span class="luxcars-site-nav__divider" aria-hidden="true"></span>
                <?php if ($luxcarsAutenticado): ?>
                    <span class="luxcars-site-nav__greeting">Ol&aacute;, <?= $luxcarsEscape($luxcarsUsuario) ?></span>
                    <a href="<?= $luxcarsEscape($luxcarsPagina('perfil.php')) ?>">Meu perfil</a>
                    <a href="<?= $luxcarsEscape($luxcarsPagina('carrinho.php')) ?>">Carrinho</a>
                    <?php if (($_SESSION['usuario_tipo'] ?? null) === 'admin'): ?>
                        <a href="<?= $luxcarsEscape($luxcarsPagina('admin_carros.php')) ?>">Administra&ccedil;&atilde;o</a>
                    <?php endif; ?>
                    <form class="luxcars-site-nav__logout" action="<?= $luxcarsEscape($luxcarsPagina('sair.php')) ?>" method="post">
                        <button type="submit">Sair</button>
                    </form>
                <?php else: ?>
                    <div class="luxcars-auth-menu" data-luxcars-account-menu>
                        <button class="luxcars-auth-menu__toggle" type="button" data-luxcars-account-toggle aria-controls="luxcars-account-options" aria-expanded="false" aria-label="Abrir op&ccedil;&otilde;es da conta">
                            <svg aria-hidden="true" viewBox="0 0 24 24" width="21" height="21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="8" r="3.5" stroke="currentColor" stroke-width="1.7" />
                                <path d="M4.8 20c.5-3.5 3.4-5.5 7.2-5.5s6.7 2 7.2 5.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />
                            </svg>
                            <span class="luxcars-auth-menu__label">Conta</span>
                        </button>
                        <div class="luxcars-auth-menu__dropdown" id="luxcars-account-options" data-luxcars-account-options>
                            <a href="<?= $luxcarsEscape($luxcarsPagina('entrar.php')) ?>">Entrar</a>
                            <a href="<?= $luxcarsEscape($luxcarsPagina('cadastro.php')) ?>">Criar conta</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>
<script>
(() => {
    const button = document.querySelector('[data-luxcars-menu-toggle]');
    const menu = document.querySelector('[data-luxcars-menu]');
    if (!button || !menu) return;
    button.addEventListener('click', () => {
        const open = button.getAttribute('aria-expanded') === 'true';
        button.setAttribute('aria-expanded', String(!open));
        button.setAttribute('aria-label', open ? 'Abrir menu' : 'Fechar menu');
        menu.classList.toggle('is-open', !open);
    });

    const account = document.querySelector('[data-luxcars-account-menu]');
    const accountButton = document.querySelector('[data-luxcars-account-toggle]');
    if (!account || !accountButton) return;

    const setAccountOpen = (open) => {
        account.classList.toggle('is-open', open);
        accountButton.setAttribute('aria-expanded', String(open));
    };
    const supportsHover = window.matchMedia('(hover: hover) and (pointer: fine)');

    account.addEventListener('pointerenter', (event) => {
        if (event.pointerType === 'mouse') setAccountOpen(true);
    });
    account.addEventListener('pointerleave', (event) => {
        if (event.pointerType === 'mouse' && !document.activeElement.matches(':focus-visible')) {
            setAccountOpen(false);
        }
    });
    account.addEventListener('focusin', (event) => {
        if (event.target.matches(':focus-visible')) setAccountOpen(true);
    });
    account.addEventListener('focusout', (event) => {
        if (!account.contains(event.relatedTarget) && !account.matches(':hover')) {
            setAccountOpen(false);
        }
    });
    accountButton.addEventListener('click', (event) => {
        if (supportsHover.matches && event.detail > 0) {
            setAccountOpen(true);
            return;
        }
        const open = accountButton.getAttribute('aria-expanded') === 'true';
        setAccountOpen(!open);
        if (open) accountButton.blur();
    });
    document.addEventListener('pointerdown', (event) => {
        if (!account.contains(event.target)) setAccountOpen(false);
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && accountButton.getAttribute('aria-expanded') === 'true') {
            accountButton.focus();
            setAccountOpen(false);
        }
    });
})();
</script>
