<?php
declare(strict_types=1);

$arquivoAmbienteLocal = __DIR__ . '/.env.local';
$apiTubeKey = getenv('APITUBE_API_KEY');
if (($apiTubeKey === false || trim((string) $apiTubeKey) === '') && is_readable($arquivoAmbienteLocal)) {
    $configuracaoLocal = @parse_ini_file($arquivoAmbienteLocal, false, INI_SCANNER_RAW);
    if (is_array($configuracaoLocal) && isset($configuracaoLocal['APITUBE_API_KEY'])) {
        $apiTubeKey = trim((string) $configuracaoLocal['APITUBE_API_KEY']);
        if ($apiTubeKey !== '') {
            putenv('APITUBE_API_KEY=' . $apiTubeKey);
            $_ENV['APITUBE_API_KEY'] = $apiTubeKey;
        }
    }
}

if (session_status() !== PHP_SESSION_ACTIVE) {
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

spl_autoload_register(static function (string $class): void {
    $prefix = 'Elite\\';
    if (!str_starts_with($class, $prefix)) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = __DIR__ . '/app/' . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';
    if (is_file($file)) {
        require $file;
    }
});
