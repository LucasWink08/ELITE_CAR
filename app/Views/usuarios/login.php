<?php
declare(strict_types=1);

function luxcarsLoginEscape(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxCars | Entrar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/fonte.css">
    <link rel="stylesheet" href="../assets/css/site.css">
</head>
<body class="min-h-screen bg-gradient-to-t from-black to-gray-900 text-white">
<?php require dirname(__DIR__, 3) . '/includes/navbar.php'; ?>
<main class="luxcars-auth-shell" aria-label="Acesso à sua conta LuxCars">
    <aside class="luxcars-auth-aside">
        <div>
            <span class="luxcars-auth-mark">LuxCars · acesso exclusivo</span>
            <h2>Seu próximo carro começa aqui.</h2>
            <p>Acesse sua conta para acompanhar seus favoritos, comparar modelos e continuar sua experiência LuxCars.</p>
        </div>
        <p class="luxcars-auth-aside-foot">Uma seleção especial. Uma experiência feita para você.</p>
    </aside>
    <section class="luxcars-auth-form">
        <h1>Bem-vindo de volta</h1>
        <p class="mb-7">Entre para continuar navegando.</p>
        <?php if ($erro !== null): ?>
            <p class="luxcars-auth-error mb-5 p-4" role="alert"><?= luxcarsLoginEscape($erro) ?></p>
        <?php endif; ?>
        <form action="entrar.php" method="post" class="grid gap-5">
            <label class="grid gap-2">E-mail
                <input class="p-3.5" type="email" name="email" autocomplete="email" maxlength="190" required value="<?= luxcarsLoginEscape($email) ?>" placeholder="voce@exemplo.com">
            </label>
            <label class="grid gap-2">Senha
                <input class="p-3.5" type="password" name="senha" autocomplete="current-password" required placeholder="Sua senha">
            </label>
            <button class="luxcars-auth-submit" type="submit">Entrar na minha conta</button>
        </form>
        <p class="mt-7 text-center">Ainda não tem conta? <a class="luxcars-auth-link" href="cadastro.php">Criar conta</a></p>
    </section>
</main>
<?php require dirname(__DIR__, 3) . '/includes/footer.php'; ?>
</body>
</html>
