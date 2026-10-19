<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$eliteScriptName = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? ''));
$elitePagesPosition = strpos($eliteScriptName, '/paginas/');
$eliteBasePath = $elitePagesPosition === false
    ? '/'
    : substr($eliteScriptName, 0, $elitePagesPosition + 1);
$eliteEscape = static fn (mixed $value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$eliteUsuario = isset($_SESSION['usuario']) && is_string($_SESSION['usuario'])
    ? $_SESSION['usuario']
    : null;
$eliteAutenticado = $eliteUsuario !== null && isset($_SESSION['usuario_id']);
$elitePagina = static fn (string $pagina): string => $eliteBasePath . 'paginas/' . $pagina;
?>
<header class="elite-site-header">
    <nav class="elite-site-nav" aria-label="Navega&ccedil;&atilde;o principal" style="box-sizing:border-box;width:100%;max-width:none;margin:0">
        <a class="elite-site-nav__brand" href="<?= $eliteEscape($elitePagina('homepage.php')) ?>" aria-label="ELITE, p&aacute;gina inicial">
            <img src="<?= $eliteEscape($eliteBasePath . 'assets/imagens/logos/site.png') ?>" width="180" height="64" style="width:min(180px,40vw);height:min(64px,14.22vw);max-width:none;object-fit:cover;object-position:center 68%" alt="" aria-hidden="true" draggable="false">
        </a>
        <button class="elite-site-nav__toggle" type="button" data-elite-menu-toggle aria-controls="elite-menu" aria-expanded="false" aria-label="Abrir menu">
            <span aria-hidden="true">&#9776;</span>
        </button>
        <div class="elite-site-nav__links" id="elite-menu" data-elite-menu>
            <div class="elite-site-nav__primary">
                <a href="<?= $eliteEscape($elitePagina('homepage.php')) ?>">In&iacute;cio</a>
                <a href="<?= $eliteEscape($elitePagina('paginadecompra.php')) ?>">Comprar</a>
                <a href="<?= $eliteEscape($elitePagina('anunciar.php')) ?>">Anunciar</a>
                <a href="<?= $eliteEscape($elitePagina('seguroveic.php')) ?>">Agendar test drive</a>
                <a href="<?= $eliteEscape($elitePagina('contato.php')) ?>">Contato</a>
            </div>
            <div class="elite-site-nav__account">
                <span class="elite-site-nav__divider" aria-hidden="true"></span>
                <?php if ($eliteAutenticado): ?>
                    <span class="elite-site-nav__greeting">Ol&aacute;, <?= $eliteEscape($eliteUsuario) ?></span>
                    <a href="<?= $eliteEscape($elitePagina('perfil.php')) ?>">Meu perfil</a>
                    <a href="<?= $eliteEscape($elitePagina('carrinho.php')) ?>">Carrinho</a>
                    <?php if (($_SESSION['usuario_tipo'] ?? null) === 'admin'): ?>
                        <a href="<?= $eliteEscape($elitePagina('admin_carros.php')) ?>">Administra&ccedil;&atilde;o</a>
                    <?php endif; ?>
                    <form class="elite-site-nav__logout" action="<?= $eliteEscape($elitePagina('sair.php')) ?>" method="post">
                        <button type="submit">Sair</button>
                    </form>
                <?php else: ?>
                    <div class="elite-auth-menu" data-elite-account-menu>
                        <button class="elite-auth-menu__toggle" type="button" data-elite-account-toggle aria-controls="elite-account-options" aria-expanded="false" aria-label="Abrir op&ccedil;&otilde;es da conta">
                            <svg aria-hidden="true" viewBox="0 0 24 24" width="21" height="21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="8" r="3.5" stroke="currentColor" stroke-width="1.7" />
                                <path d="M4.8 20c.5-3.5 3.4-5.5 7.2-5.5s6.7 2 7.2 5.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />
                            </svg>
                            <span class="elite-auth-menu__label">Conta</span>
                        </button>
                        <div class="elite-auth-menu__dropdown" id="elite-account-options" data-elite-account-options>
                            <a href="<?= $eliteEscape($elitePagina('entrar.php')) ?>">Entrar</a>
                            <a href="<?= $eliteEscape($elitePagina('cadastro.php')) ?>">Criar conta</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>
<script>
(() => {
    const button = document.querySelector('[data-elite-menu-toggle]');
    const menu = document.querySelector('[data-elite-menu]');
    if (!button || !menu) return;
    button.addEventListener('click', () => {
        const open = button.getAttribute('aria-expanded') === 'true';
        button.setAttribute('aria-expanded', String(!open));
        button.setAttribute('aria-label', open ? 'Abrir menu' : 'Fechar menu');
        menu.classList.toggle('is-open', !open);
    });

    const account = document.querySelector('[data-elite-account-menu]');
    const accountButton = document.querySelector('[data-elite-account-toggle]');
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
