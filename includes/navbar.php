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
    <nav class="luxcars-site-nav" aria-label="Navega&ccedil;&atilde;o principal">
        <a class="luxcars-site-nav__brand" href="<?= $luxcarsEscape($luxcarsPagina('homepage.php')) ?>" aria-label="LuxCars, p&aacute;gina inicial">LUXCARS</a>
        <button class="luxcars-site-nav__toggle" type="button" data-luxcars-menu-toggle aria-controls="luxcars-menu" aria-expanded="false" aria-label="Abrir menu">
            <span aria-hidden="true">&#9776;</span>
        </button>
        <div class="luxcars-site-nav__links" id="luxcars-menu" data-luxcars-menu>
            <a href="<?= $luxcarsEscape($luxcarsPagina('homepage.php')) ?>">In&iacute;cio</a>
            <a href="<?= $luxcarsEscape($luxcarsPagina('paginadecompra.php')) ?>">Comprar</a>
            <a href="<?= $luxcarsEscape($luxcarsPagina('anunciar.php')) ?>">Anunciar</a>
            <a href="<?= $luxcarsEscape($luxcarsPagina('tabelafipe.php')) ?>">Tabela FIPE</a>
            <a href="<?= $luxcarsEscape($luxcarsPagina('seguroveic.php')) ?>">Agendar test drive</a>
            <a href="<?= $luxcarsEscape($luxcarsPagina('contato.php')) ?>">Contato</a>
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
                <a href="<?= $luxcarsEscape($luxcarsPagina('entrar.php')) ?>">Entrar</a>
                <a href="<?= $luxcarsEscape($luxcarsPagina('cadastro.php')) ?>">Criar conta</a>
            <?php endif; ?>
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
})();
</script>
