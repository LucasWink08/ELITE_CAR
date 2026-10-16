<?php
declare(strict_types=1);

function luxcarsDetalhesEscape(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function luxcarsDetalhesSlug(string $value): string
{
    $ascii = function_exists('iconv') ? iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value) : $value;
    return strtolower((string) preg_replace('/[^a-z0-9]+/i', '', $ascii === false ? $value : $ascii));
}

function luxcarsDetalhesGoogleImages(string $marca, string $modelo, int $ano, string $termo): string
{
    $consulta = trim($marca . ' ' . $modelo . ' ' . $ano . ' ' . $termo);
    return 'https://www.google.com/search?tbm=isch&q=' . rawurlencode($consulta);
}

/** @return array<int, array{tipo:string,src?:string,href?:string,alt:string,legenda:string,origem?:string}> */
function luxcarsDetalhesGaleria(\LuxCars\Entities\Carro $carro): array
{
    $galeria = [];
    $marca = $carro->getMarca();
    $modelo = $carro->getModelo();
    $ano = $carro->getAno();
    $nome = trim($marca . ' ' . $modelo);
    $imagemPrincipal = trim((string) $carro->getImagem());

    if ($imagemPrincipal !== '') {
        if (preg_match('#^https://#i', $imagemPrincipal) === 1) {
            $galeria[] = ['tipo' => 'imagem', 'src' => $imagemPrincipal, 'alt' => $nome, 'legenda' => 'Exterior'];
        } elseif (
            str_starts_with(ltrim($imagemPrincipal, '/'), 'assets/')
            && !str_contains($imagemPrincipal, '..')
            && is_file(dirname(__DIR__, 3) . '/' . ltrim($imagemPrincipal, '/'))
        ) {
            $partes = explode('/', ltrim($imagemPrincipal, '/'));
            $urlLocal = '../' . implode('/', array_map('rawurlencode', $partes));
            $galeria[] = ['tipo' => 'imagem', 'src' => $urlLocal, 'alt' => $nome, 'legenda' => 'Exterior'];
        }
    }

    $raizGalerias = dirname(__DIR__, 3) . '/assets/imagens/cars/imgsanuncios';
    $marcaSlug = luxcarsDetalhesSlug($marca);
    $modeloSlug = luxcarsDetalhesSlug($modelo);
    $marcaDir = null;

    if (is_dir($raizGalerias)) {
        foreach (scandir($raizGalerias) ?: [] as $nomeDir) {
            $caminho = $raizGalerias . DIRECTORY_SEPARATOR . $nomeDir;
            if (is_dir($caminho) && $nomeDir !== '.' && $nomeDir !== '..' && luxcarsDetalhesSlug($nomeDir) === $marcaSlug) {
                $marcaDir = $caminho;
                break;
            }
        }
    }

    $pastaVeiculo = null;
    $melhorPontuacao = 0;
    if ($marcaDir !== null) {
        foreach (scandir($marcaDir) ?: [] as $nomeDir) {
            $caminho = $marcaDir . DIRECTORY_SEPARATOR . $nomeDir;
            if (!is_dir($caminho) || $nomeDir === '.' || $nomeDir === '..') {
                continue;
            }
            $slugPasta = luxcarsDetalhesSlug($nomeDir);
            if (!str_starts_with($slugPasta, $marcaSlug)) {
                continue;
            }
            $slugModeloPasta = substr($slugPasta, strlen($marcaSlug));
            if ($slugModeloPasta === '' || (!str_starts_with($slugModeloPasta, $modeloSlug) && !str_starts_with($modeloSlug, $slugModeloPasta))) {
                continue;
            }
            $pontuacao = $slugModeloPasta === $modeloSlug ? 1000 : strlen($slugModeloPasta);
            if ($pontuacao > $melhorPontuacao) {
                $pastaVeiculo = $caminho;
                $melhorPontuacao = $pontuacao;
            }
        }
    }

    $alternativas = [];
    $interiores = [];
    $motores = [];
    if ($pastaVeiculo !== null) {
        $arquivos = glob($pastaVeiculo . DIRECTORY_SEPARATOR . '*') ?: [];
        sort($arquivos, SORT_NATURAL | SORT_FLAG_CASE);
        foreach ($arquivos as $arquivo) {
            if (!is_file($arquivo) || !preg_match('/\.(avif|gif|jpe?g|png|webp)$/i', $arquivo)) {
                continue;
            }
            $nomeArquivo = basename($arquivo);
            $raizProjetoUrl = str_replace('\\', '/', dirname(__DIR__, 3));
            $caminhoArquivoUrl = str_replace('\\', '/', $arquivo);
            $relativo = ltrim(substr($caminhoArquivoUrl, strlen($raizProjetoUrl)), '/');
            $partes = explode('/', $relativo);
            $src = '../' . implode('/', array_map('rawurlencode', $partes));
            $item = ['tipo' => 'imagem', 'src' => $src, 'alt' => $nome . ' — ' . $nomeArquivo, 'legenda' => 'Foto do veículo'];
            if (preg_match('/interior|cockpit|dashboard|painel|innenraum|cabin|interieur|salon/i', $nomeArquivo)) {
                $interiores[] = $item;
            } elseif (preg_match('/motor|engine/i', $nomeArquivo)) {
                $item['legenda'] = 'Motor';
                $motores[] = $item;
            } else {
                $alternativas[] = $item;
            }
        }
    }

    $principalEhInterior = false;
    if ($galeria === [] && $alternativas !== []) {
        $galeria[] = ['legenda' => 'Exterior'] + array_shift($alternativas);
    } elseif ($galeria === [] && $interiores !== []) {
        $primeiroInterior = array_shift($interiores);
        $primeiroInterior['legenda'] = 'Interior';
        $galeria[] = $primeiroInterior;
        $principalEhInterior = true;
    }

    $normalizarCaminho = static fn (string $src): string => strtolower(str_replace('\\', '/', rawurldecode(parse_url($src, PHP_URL_PATH) ?: $src)));
    $caminhosAdicionados = array_fill_keys(array_map(
        static fn (array $foto): string => $normalizarCaminho((string) ($foto['src'] ?? '')),
        $galeria
    ), true);
    foreach ($alternativas as $alternativa) {
        $caminho = $normalizarCaminho((string) ($alternativa['src'] ?? ''));
        if ($caminho === '' || isset($caminhosAdicionados[$caminho])) {
            continue;
        }
        $alternativa['legenda'] = 'Outro ângulo';
        $galeria[] = $alternativa;
        $caminhosAdicionados[$caminho] = true;
    }

    foreach ($interiores as $interior) {
        $interior['legenda'] = 'Interior';
        $galeria[] = $interior;
    }

    foreach ($motores as $motor) {
        $galeria[] = $motor;
    }

    if ($interiores === [] && !$principalEhInterior && $marcaSlug === 'bmw' && str_contains($modeloSlug, 'x6')) {
        $galeria[] = [
            'tipo' => 'imagem',
            'src' => 'https://mediapool.bmwgroup.com/download/edown/pressclub/publicq?actEvent=image&attachment=1&dokNo=P90495591',
            'alt' => 'Interior do BMW X6 M Competition',
            'legenda' => 'Interior · BMW PressClub',
            'origem' => 'https://www.press.bmwgroup.com/latin-america-caribbean/photo/detail/P90495591/The-new-BMW-X6-M-Competition-Interior-02-2023',
        ];
    } elseif ($interiores === [] && !$principalEhInterior) {
        $galeria[] = [
            'tipo' => 'busca',
            'href' => luxcarsDetalhesGoogleImages($marca, $modelo, $ano, 'interior'),
            'alt' => 'Buscar fotos do interior de ' . $nome,
            'legenda' => 'Buscar interior no Google',
        ];
    }

    $termosAdicionais = ['fotos externas', 'motor'];
    $indiceTermo = 0;
    while (count($galeria) < 3) {
        $galeria[] = [
            'tipo' => 'busca',
            'href' => luxcarsDetalhesGoogleImages($marca, $modelo, $ano, $termosAdicionais[$indiceTermo] ?? 'fotos'),
            'alt' => 'Buscar mais fotos de ' . $nome,
            'legenda' => ($termosAdicionais[$indiceTermo] ?? 'fotos') === 'motor' ? 'Buscar fotos do motor' : 'Ver mais fotos no Google',
        ];
        $indiceTermo++;
    }

    return array_slice($galeria, 0, 12);
}

$nomeVeiculo = $carro === null ? '' : trim($carro->getMarca() . ' ' . $carro->getModelo());
$galeriaVeiculo = $carro === null ? [] : luxcarsDetalhesGaleria($carro);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= luxcarsDetalhesEscape($carro === null ? 'Detalhes dos veículos LuxCars.' : 'Confira fotos, informações e condições do ' . $nomeVeiculo . '.') ?>">
    <title><?= luxcarsDetalhesEscape($carro === null ? 'LuxCars | Veículo' : 'LuxCars | ' . $nomeVeiculo) ?></title>
    <link rel="stylesheet" href="../assets/css/fonte.css">
    <link rel="stylesheet" href="../assets/css/site.css">
</head>
<body class="luxcars-vehicle-page min-h-screen bg-gradient-to-t from-black to-gray-900 text-white">
<?php require dirname(__DIR__, 3) . '/includes/navbar.php'; ?>
<main class="luxcars-vehicle-detail">
    <?php if ($erroBanco !== null): ?>
        <p class="luxcars-vehicle-detail__notice" role="alert"><?= luxcarsDetalhesEscape($erroBanco) ?></p>
    <?php elseif ($carro === null): ?>
        <p class="luxcars-vehicle-detail__notice" role="status">Veículo não encontrado ou indisponível.</p>
    <?php else: ?>
        <section class="luxcars-vehicle-gallery" aria-label="Galeria de fotos do <?= luxcarsDetalhesEscape($nomeVeiculo) ?>" data-vehicle-gallery>
            <div class="luxcars-vehicle-gallery__viewport" id="galeria-veiculo-<?= (int) $carro->getId() ?>">
                <div class="luxcars-vehicle-gallery__track">
                    <?php foreach ($galeriaVeiculo as $indiceFoto => $foto): ?>
                        <?php if ($foto['tipo'] === 'imagem'): ?>
                            <figure class="luxcars-vehicle-gallery__item" data-fallback-url="<?= luxcarsDetalhesEscape(luxcarsDetalhesGoogleImages($carro->getMarca(), $carro->getModelo(), $carro->getAno(), 'fotos')) ?>" data-fallback-title="<?= luxcarsDetalhesEscape($nomeVeiculo . ' ' . $carro->getAno()) ?>">
                                <?php if (!empty($foto['origem'])): ?><a href="<?= luxcarsDetalhesEscape($foto['origem']) ?>" target="_blank" rel="noopener noreferrer" aria-label="Abrir fonte da foto do interior"><?php endif; ?>
                                <img src="<?= luxcarsDetalhesEscape($foto['src']) ?>" alt="<?= luxcarsDetalhesEscape($foto['alt']) ?>"<?= $indiceFoto === 0 ? '' : ' loading="lazy"' ?>>
                                <?php if (!empty($foto['origem'])): ?></a><?php endif; ?>
                                <figcaption><?= luxcarsDetalhesEscape($foto['legenda']) ?></figcaption>
                            </figure>
                        <?php else: ?>
                            <a class="luxcars-vehicle-gallery__item luxcars-vehicle-gallery__search" href="<?= luxcarsDetalhesEscape($foto['href']) ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= luxcarsDetalhesEscape($foto['alt']) ?>">
                                <span class="luxcars-vehicle-gallery__search-icon" aria-hidden="true">↗</span>
                                <span><?= luxcarsDetalhesEscape($foto['legenda']) ?></span>
                                <small><?= luxcarsDetalhesEscape($nomeVeiculo . ' · ' . $carro->getAno()) ?></small>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <button class="luxcars-vehicle-gallery__arrow luxcars-vehicle-gallery__arrow--previous" type="button" data-gallery-previous aria-label="Foto anterior" aria-controls="galeria-veiculo-<?= (int) $carro->getId() ?>">&#8592;</button>
            <button class="luxcars-vehicle-gallery__arrow luxcars-vehicle-gallery__arrow--next" type="button" data-gallery-next aria-label="Próxima foto" aria-controls="galeria-veiculo-<?= (int) $carro->getId() ?>">&#8594;</button>
            <p class="luxcars-vehicle-gallery__count" aria-live="polite"><span data-gallery-current>01</span> / <?= str_pad((string) count($galeriaVeiculo), 2, '0', STR_PAD_LEFT) ?></p>
        </section>

        <div class="luxcars-vehicle-detail__layout">
            <article class="luxcars-vehicle-info">
                <p class="luxcars-vehicle-info__eyebrow">LuxCars · estoque selecionado</p>
                <h1><?= luxcarsDetalhesEscape($nomeVeiculo) ?></h1>
                <?php if ($carro->getVersao() !== null && trim($carro->getVersao()) !== ''): ?>
                    <p class="luxcars-vehicle-info__version"><?= luxcarsDetalhesEscape($carro->getVersao()) ?></p>
                <?php endif; ?>
                <?php if ($carro->getDescricao() !== null && trim($carro->getDescricao()) !== ''): ?>
                    <p class="luxcars-vehicle-info__description"><?= luxcarsDetalhesEscape($carro->getDescricao()) ?></p>
                <?php endif; ?>

                <h2>Detalhes do veículo</h2>
                <dl class="luxcars-vehicle-specs">
                    <div><dt>Ano</dt><dd><?= luxcarsDetalhesEscape($carro->getAno()) ?></dd></div>
                    <div><dt>Quilometragem</dt><dd><?= $carro->getQuilometragem() === null ? 'Sob consulta' : number_format($carro->getQuilometragem(), 0, ',', '.') . ' km' ?></dd></div>
                    <div><dt>Combustível</dt><dd><?= luxcarsDetalhesEscape($carro->getCombustivel() ?: 'Sob consulta') ?></dd></div>
                    <div><dt>Câmbio</dt><dd><?= luxcarsDetalhesEscape($carro->getCambio() ?: 'Sob consulta') ?></dd></div>
                    <div><dt>Cor</dt><dd><?= luxcarsDetalhesEscape($carro->getCor() ?: 'Sob consulta') ?></dd></div>
                    <div><dt>Versão</dt><dd><?= luxcarsDetalhesEscape($carro->getVersao() ?: 'Sob consulta') ?></dd></div>
                </dl>
                <?php if ($carro->getInformacoesAdicionais() !== null && trim($carro->getInformacoesAdicionais()) !== ''): ?>
                    <div class="luxcars-vehicle-info__extra">
                        <h2>Sobre este modelo</h2>
                        <p><?= luxcarsDetalhesEscape($carro->getInformacoesAdicionais()) ?></p>
                    </div>
                <?php endif; ?>
                <p class="luxcars-vehicle-info__availability"><span aria-hidden="true"></span> Disponível para consulta</p>
            </article>

            <aside class="luxcars-vehicle-contact" aria-labelledby="interesse-titulo">
                <p class="luxcars-vehicle-contact__eyebrow">Atendimento exclusivo</p>
                <p class="luxcars-vehicle-contact__price">R$ <?= number_format($carro->getPreco(), 2, ',', '.') ?></p>
                <h2 id="interesse-titulo">Tenho interesse</h2>
                <p class="luxcars-vehicle-contact__intro">Envie seus dados e nossa equipe retorna para conversar sobre este veículo.</p>
                <form action="contato.php" method="post" class="luxcars-vehicle-contact__form">
                    <input type="hidden" name="csrf_token" value="<?= luxcarsDetalhesEscape($csrfToken) ?>">
                    <input type="hidden" name="assunto" value="<?= luxcarsDetalhesEscape('Interesse em ' . $nomeVeiculo) ?>">
                    <div class="luxcars-vehicle-contact__honeypot" aria-hidden="true">
                        <label for="website">Deixe este campo vazio</label>
                        <input id="website" type="text" name="website" tabindex="-1" autocomplete="off">
                    </div>
                    <label for="interesse-nome">Nome completo
                        <input id="interesse-nome" name="nome" type="text" autocomplete="name" minlength="2" maxlength="150" placeholder="Como podemos chamar você?" required>
                    </label>
                    <label for="interesse-email">E-mail
                        <input id="interesse-email" name="email" type="email" autocomplete="email" maxlength="190" placeholder="voce@exemplo.com" required>
                    </label>
                    <label for="interesse-mensagem">Mensagem
                        <textarea id="interesse-mensagem" name="mensagem" minlength="10" maxlength="5000" required>Olá, tenho interesse no <?= luxcarsDetalhesEscape($nomeVeiculo) ?>. Gostaria de receber mais informações.</textarea>
                    </label>
                    <button type="submit">Solicitar contato</button>
                </form>
                <div class="luxcars-vehicle-contact__actions">
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <form action="carrinho.php" method="post">
                            <input type="hidden" name="csrf_token" value="<?= luxcarsDetalhesEscape($csrfToken) ?>">
                            <input type="hidden" name="acao" value="adicionar">
                            <input type="hidden" name="carro_id" value="<?= luxcarsDetalhesEscape($carro->getId()) ?>">
                            <button class="luxcars-vehicle-contact__secondary" type="submit">Adicionar ao carrinho</button>
                        </form>
                    <?php endif; ?>
                    <a href="pagamento.php?id=<?= rawurlencode((string) $carro->getId()) ?>">Ver formas de pagamento</a>
                </div>
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <div class="luxcars-vehicle-contact__account-actions">
                        <form method="post" action="favoritos.php">
                            <input type="hidden" name="csrf_token" value="<?= luxcarsDetalhesEscape($csrfToken) ?>">
                            <input type="hidden" name="acao" value="adicionar">
                            <input type="hidden" name="carro_id" value="<?= (int) $carro->getId() ?>">
                            <button type="submit">Salvar nos favoritos</button>
                        </form>
                        <form method="post" action="comparar.php">
                            <input type="hidden" name="csrf_token" value="<?= luxcarsDetalhesEscape($csrfToken) ?>">
                            <input type="hidden" name="acao" value="adicionar">
                            <input type="hidden" name="carro_id" value="<?= (int) $carro->getId() ?>">
                            <button type="submit">Comparar</button>
                        </form>
                    </div>
                <?php endif; ?>
            </aside>
        </div>
        <p class="luxcars-vehicle-detail__back"><a href="paginadecompra.php">← Voltar ao catálogo</a></p>
    <?php endif; ?>
</main>
<script>
(() => {
    const gallery = document.querySelector('[data-vehicle-gallery]');
    const viewport = gallery?.querySelector('.luxcars-vehicle-gallery__viewport');
    const track = gallery?.querySelector('.luxcars-vehicle-gallery__track');
    const previous = gallery?.querySelector('[data-gallery-previous]');
    const next = gallery?.querySelector('[data-gallery-next]');
    const current = gallery?.querySelector('[data-gallery-current]');
    if (!gallery || !viewport || !track || !previous || !next || !current) return;

    const items = () => Array.from(track.children);
    const scrollStep = () => {
        const first = items()[0];
        if (!first) return viewport.clientWidth;
        const gap = parseFloat(getComputedStyle(track).gap || '0') || 0;
        return first.getBoundingClientRect().width + gap;
    };
    const update = () => {
        const maxScroll = Math.max(0, viewport.scrollWidth - viewport.clientWidth);
        const step = scrollStep();
        const position = step > 0 ? Math.round(viewport.scrollLeft / step) : 0;
        previous.disabled = viewport.scrollLeft <= 2;
        next.disabled = viewport.scrollLeft >= maxScroll - 2;
        current.textContent = String(Math.min(position + 1, items().length)).padStart(2, '0');
    };

    previous.addEventListener('click', () => viewport.scrollBy({ left: -scrollStep(), behavior: 'smooth' }));
    next.addEventListener('click', () => viewport.scrollBy({ left: scrollStep(), behavior: 'smooth' }));
    viewport.addEventListener('scroll', update, { passive: true });
    window.addEventListener('resize', update);
    track.addEventListener('error', event => {
        const image = event.target;
        if (!(image instanceof HTMLImageElement)) return;
        const item = image.closest('.luxcars-vehicle-gallery__item');
        if (!item) return;
        const search = document.createElement('a');
        search.className = 'luxcars-vehicle-gallery__item luxcars-vehicle-gallery__search';
        search.href = item.dataset.fallbackUrl;
        search.target = '_blank';
        search.rel = 'noopener noreferrer';
        const icon = document.createElement('span');
        icon.className = 'luxcars-vehicle-gallery__search-icon';
        icon.setAttribute('aria-hidden', 'true');
        icon.textContent = '↗';
        const label = document.createElement('span');
        label.textContent = 'Foto indisponível · buscar no Google';
        const title = document.createElement('small');
        title.textContent = item.dataset.fallbackTitle || '';
        search.append(icon, label, title);
        item.replaceWith(search);
        update();
    }, true);
    update();
})();
</script>
<?php require dirname(__DIR__, 3) . '/includes/footer.php'; ?>
</body>
</html>
