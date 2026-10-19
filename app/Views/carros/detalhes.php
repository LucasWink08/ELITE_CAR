<?php
declare(strict_types=1);

function eliteDetalhesEscape(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function eliteDetalhesSlug(string $value): string
{
    $ascii = function_exists('iconv') ? iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value) : $value;
    return strtolower((string) preg_replace('/[^a-z0-9]+/i', '', $ascii === false ? $value : $ascii));
}

/** Fotos diretas encontradas no Google Imagens, usadas somente quando a pasta local não tem aquele tipo de foto. */
function eliteDetalhesFotosComplementares(string $marcaSlug, string $modeloSlug): array
{
    $fotos = [
        'bmw:m5cs' => [['src' => 'https://hips.hearstapps.com/hmg-prod/images/2022-bmw-m5-cs-164-1611684148.jpg?crop=1xw%3A0.9167590632664718xh%3Bcenter%2Ctop&resize=980%3A%2A', 'legenda' => 'Interior']],
        'bmw:x6competition' => [['src' => 'https://mediapool.bmwgroup.com/download/edown/pressclub/publicq?actEvent=image&attachment=1&dokNo=P90495591', 'legenda' => 'Interior']],
        'bmw:m5' => [['src' => 'https://hips.hearstapps.com/hmg-prod/images/2021-bmw-m5-110-1591638968.jpg', 'legenda' => 'Interior']],
        'bmw:i8' => [['src' => 'https://www.autocar.co.uk/sites/default/files/styles/gallery_slide/public/bmw-i8-uk-road-test-2014-015.jpg', 'legenda' => 'Interior']],
        'bmw:i7m70' => [['src' => 'https://images.carexpert.com.au/resize/3000/-/app/uploads/2023/09/2024_BMW_i7_M70_xDrive_Two_Tone_Liquid_Copper-Sapphire_Black-059.jpg', 'legenda' => 'Interior']],
        'bmw:x4m40i' => [['src' => 'https://images.dealersync.com/3051/Photos/1328786/20250627233700341_IMG_3455.png', 'legenda' => 'Interior']],
        'bmw:m4' => [['src' => 'https://garasikami.com/Mobil/BMW/BMW%208/BMW%20M4%20Competition%20G82%20Idrive%208%202023/S__14032921_0.jpg', 'legenda' => 'Interior']],
        'bmw:m8grancoupe' => [['src' => 'https://mediapool.bmwgroup.com/cache/P9/202206/P90466605/P90466605-the-bmw-m8-competition-gran-coupe-06-2022-2249px.jpg', 'legenda' => 'Interior']],
        'porsche:718spiderrs' => [['src' => 'https://images-porsche.imgix.net/-/media/BE2D7B0BAB834CFB91A7693BBBF7BD4B_4F3846E68BF54327B43B2E65B1DF8D0B_718-spyder-rs-cockpit-desktop?auto=format&q=85&w=1299', 'legenda' => 'Interior']],
        'porsche:911gt1s' => [['src' => 'https://content-hub.imgix.net/7tYX6SsY07yeMeHI2sxsyx/4945dac9bce09c703033c91262de7a8c/911_gt1_strassenversion_4.jpg?w=1308', 'legenda' => 'Interior']],
        'porsche:taycan' => [['src' => 'https://greencarscompare.com/upload/resize_cache/iblock/33d/1100_618_2/dkpqn2sbjopxqssu2frzl0l239edmme9.jpg', 'legenda' => 'Interior']],
        'porsche:gt3rs' => [['src' => 'https://hips.hearstapps.com/mtg-prod/65cd8566bb63b500089200a3/2019-porsche-911-gt3-rs-weissach-package-front-interior-02.jpg?format=webp&q=100&resize=1920%3A%2A&w=768', 'legenda' => 'Interior']],
        'porsche:cayenne' => [['src' => 'https://ymimg1.b8cdn.com/uploads/car_version/21701/pictures/6197511/14196_st1280_163.jpg', 'legenda' => 'Interior']],
        'porsche:macan' => [['src' => 'https://platform.cstatic-images.com/xlarge/in/v2/stock_photos/7648106b-9867-4ec0-ba15-0ac4d897b2db/78c8705d-ac30-44d3-84b0-21f5e7b7f5cd.png', 'legenda' => 'Interior']],
        'porsche:panamera' => [['src' => 'https://s1.cdn.autoevolution.com/images/gallery/PORSCHE-Panamera--971--6934_1.jpg', 'legenda' => 'Interior']],
        'porsche:cayman' => [['src' => 'https://images.dealersync.com/3/Photos/1193851/20240928042705855_IMG_2706.jpg?_=182e1ce422969af8b3765c6e4beeb00cf27779e0', 'legenda' => 'Interior']],
        'porsche:918spider' => [['src' => 'https://car-images.bauersecure.com/wp-images/13775/00091a00cf5f-532f-475c-a.jpg', 'legenda' => 'Interior']],
        'porsche:911gt2' => [['src' => 'https://duttongarage.com/image/GXiCBux0k83WN84AGsABAA/2002-Porsche-911-996-GT2-Coupe-2dr-Man-6sp-3-6TT-MY03-19.webp', 'legenda' => 'Interior']],
        'audi:r8' => [['src' => 'https://static.cargurus.com/images/site/2017/08/26/19/10/2018_audi_r8_5_2_quattro__v10_-pic-8948038221470639801-1600x1200.jpeg', 'legenda' => 'Interior']],
        'audi:rs6avant' => [['src' => 'https://platform.cstatic-images.com/xlarge/in/v2/stock_photos/947d41eb-9271-4b2b-98a0-6df47b768bb1/07ae6c84-f20e-4e1b-a7a4-37f35b1e57a3.png', 'legenda' => 'Interior']],
        'audi:ttrs' => [['src' => 'https://images.cdn.autocar.co.uk/sites/autocar.co.uk/files/images/car-reviews/first-drives/legacy/96-audi-tt-rs-2019-facelift-press-cabin.jpg', 'legenda' => 'Interior']],
        'audi:rs3' => [['src' => 'https://cdn.motor1.com/images/mgl/33lK1/s1/audi-rs-3-sportback-2021-im-test.jpg', 'legenda' => 'Interior']],
        'audi:rs4avant' => [['src' => 'https://images.carexpert.com.au/resize/3000/-/app/uploads/2020/10/Audi-RS4-Avant-24.jpeg', 'legenda' => 'Interior']],
    ];

    return $fotos[$marcaSlug . ':' . $modeloSlug] ?? [];
}
/** @return array<int, array{tipo:string,src?:string,href?:string,alt:string,legenda:string,origem?:string}> */
function eliteDetalhesGaleria(\Elite\Entities\Carro $carro): array
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
    $marcaSlug = eliteDetalhesSlug($marca);
    $modeloSlug = eliteDetalhesSlug($modelo);
    $marcaDir = null;

    if (is_dir($raizGalerias)) {
        foreach (scandir($raizGalerias) ?: [] as $nomeDir) {
            $caminho = $raizGalerias . DIRECTORY_SEPARATOR . $nomeDir;
            if (is_dir($caminho) && $nomeDir !== '.' && $nomeDir !== '..' && eliteDetalhesSlug($nomeDir) === $marcaSlug) {
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
            $slugPasta = eliteDetalhesSlug($nomeDir);
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

    if ($interiores === [] && !$principalEhInterior) {
        foreach (eliteDetalhesFotosComplementares($marcaSlug, $modeloSlug) as $complemento) {
            $srcComplementar = (string) ($complemento['src'] ?? '');
            if (preg_match('#^https://#i', $srcComplementar) !== 1 || isset($caminhosAdicionados[strtolower($srcComplementar)])) {
                continue;
            }
            $galeria[] = [
                'tipo' => 'imagem',
                'src' => $srcComplementar,
                'alt' => 'Foto do ' . $nome . ' encontrada no Google Imagens',
                'legenda' => (string) ($complemento['legenda'] ?? 'Foto complementar') . ' · foto complementar',
            ];
            $caminhosAdicionados[strtolower($srcComplementar)] = true;
        }
    }
    return array_slice($galeria, 0, 12);
}

$nomeVeiculo = $carro === null ? '' : trim($carro->getMarca() . ' ' . $carro->getModelo());
$galeriaVeiculo = $carro === null ? [] : eliteDetalhesGaleria($carro);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= eliteDetalhesEscape($carro === null ? 'Detalhes dos veículos ELITE.' : 'Confira fotos, informações e condições do ' . $nomeVeiculo . '.') ?>">
    <title><?= eliteDetalhesEscape($carro === null ? 'ELITE | Veículo' : 'ELITE | ' . $nomeVeiculo) ?></title>
    <link rel="stylesheet" href="../assets/css/fonte.css">
    <link rel="stylesheet" href="../assets/css/site.css">
</head>
<body class="elite-vehicle-page min-h-screen bg-gradient-to-t from-black to-gray-900 text-white">
<?php require dirname(__DIR__, 3) . '/includes/navbar.php'; ?>
<main class="elite-vehicle-detail">
    <?php if ($erroBanco !== null): ?>
        <p class="elite-vehicle-detail__notice" role="alert"><?= eliteDetalhesEscape($erroBanco) ?></p>
    <?php elseif ($carro === null): ?>
        <p class="elite-vehicle-detail__notice" role="status">Veículo não encontrado ou indisponível.</p>
    <?php else: ?>
        <section class="elite-vehicle-gallery" aria-label="Galeria de fotos do <?= eliteDetalhesEscape($nomeVeiculo) ?>" data-vehicle-gallery>
            <div class="elite-vehicle-gallery__viewport" id="galeria-veiculo-<?= (int) $carro->getId() ?>">
                <div class="elite-vehicle-gallery__track">
                    <?php foreach ($galeriaVeiculo as $indiceFoto => $foto): ?>
                        <?php if ($foto['tipo'] === 'imagem'): ?>
                            <?php $fotosFallback = eliteDetalhesFotosComplementares(eliteDetalhesSlug($carro->getMarca()), eliteDetalhesSlug($carro->getModelo())); ?>
                            <figure class="elite-vehicle-gallery__item" data-fallback-src="<?= eliteDetalhesEscape((string) ($fotosFallback[0]['src'] ?? '')) ?>">
                                <?php if (!empty($foto['origem'])): ?><a href="<?= eliteDetalhesEscape($foto['origem']) ?>" target="_blank" rel="noopener noreferrer" aria-label="Abrir fonte da foto do interior"><?php endif; ?>
                                <img src="<?= eliteDetalhesEscape($foto['src']) ?>" alt="<?= eliteDetalhesEscape($foto['alt']) ?>"<?= $indiceFoto === 0 ? '' : ' loading="lazy"' ?>>
                                <?php if (!empty($foto['origem'])): ?></a><?php endif; ?>
                                <figcaption><?= eliteDetalhesEscape($foto['legenda']) ?></figcaption>
                            </figure>
                        <?php else: ?>
                            <a class="elite-vehicle-gallery__item elite-vehicle-gallery__search" href="<?= eliteDetalhesEscape($foto['href']) ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= eliteDetalhesEscape($foto['alt']) ?>">
                                <span class="elite-vehicle-gallery__search-icon" aria-hidden="true">↗</span>
                                <span><?= eliteDetalhesEscape($foto['legenda']) ?></span>
                                <small><?= eliteDetalhesEscape($nomeVeiculo . ' · ' . $carro->getAno()) ?></small>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <button class="elite-vehicle-gallery__arrow elite-vehicle-gallery__arrow--previous" type="button" data-gallery-previous aria-label="Foto anterior" aria-controls="galeria-veiculo-<?= (int) $carro->getId() ?>">&#8592;</button>
            <button class="elite-vehicle-gallery__arrow elite-vehicle-gallery__arrow--next" type="button" data-gallery-next aria-label="Próxima foto" aria-controls="galeria-veiculo-<?= (int) $carro->getId() ?>">&#8594;</button>
            <p class="elite-vehicle-gallery__count" aria-live="polite"><span data-gallery-current>01</span> / <?= str_pad((string) count($galeriaVeiculo), 2, '0', STR_PAD_LEFT) ?></p>
        </section>

        <div class="elite-vehicle-detail__layout">
            <article class="elite-vehicle-info">
                <p class="elite-vehicle-info__eyebrow">ELITE · estoque selecionado</p>
                <h1><?= eliteDetalhesEscape($nomeVeiculo) ?></h1>
                <?php if ($carro->getVersao() !== null && trim($carro->getVersao()) !== ''): ?>
                    <p class="elite-vehicle-info__version"><?= eliteDetalhesEscape($carro->getVersao()) ?></p>
                <?php endif; ?>
                <?php if ($carro->getDescricao() !== null && trim($carro->getDescricao()) !== ''): ?>
                    <p class="elite-vehicle-info__description"><?= eliteDetalhesEscape($carro->getDescricao()) ?></p>
                <?php endif; ?>

                <h2>Detalhes do veículo</h2>
                <dl class="elite-vehicle-specs">
                    <div><dt>Ano</dt><dd><?= eliteDetalhesEscape($carro->getAno()) ?></dd></div>
                    <div><dt>Quilometragem</dt><dd><?= $carro->getQuilometragem() === null ? 'Sob consulta' : number_format($carro->getQuilometragem(), 0, ',', '.') . ' km' ?></dd></div>
                    <div><dt>Combustível</dt><dd><?= eliteDetalhesEscape($carro->getCombustivel() ?: 'Sob consulta') ?></dd></div>
                    <div><dt>Câmbio</dt><dd><?= eliteDetalhesEscape($carro->getCambio() ?: 'Sob consulta') ?></dd></div>
                    <div><dt>Cor</dt><dd><?= eliteDetalhesEscape($carro->getCor() ?: 'Sob consulta') ?></dd></div>
                    <div><dt>Versão</dt><dd><?= eliteDetalhesEscape($carro->getVersao() ?: 'Sob consulta') ?></dd></div>
                </dl>
                <?php if ($carro->getInformacoesAdicionais() !== null && trim($carro->getInformacoesAdicionais()) !== ''): ?>
                    <div class="elite-vehicle-info__extra">
                        <h2>Sobre este modelo</h2>
                        <p><?= eliteDetalhesEscape($carro->getInformacoesAdicionais()) ?></p>
                    </div>
                <?php endif; ?>
                <p class="elite-vehicle-info__availability"><span aria-hidden="true"></span> Disponível para consulta</p>
            </article>

            <aside class="elite-vehicle-contact" aria-labelledby="interesse-titulo">
                <p class="elite-vehicle-contact__eyebrow">Atendimento exclusivo</p>
                <p class="elite-vehicle-contact__price">R$ <?= number_format($carro->getPreco(), 2, ',', '.') ?></p>
                <h2 id="interesse-titulo">Tenho interesse</h2>
                <p class="elite-vehicle-contact__intro">Envie seus dados e nossa equipe retorna para conversar sobre este veículo.</p>
                <form action="contato.php" method="post" class="elite-vehicle-contact__form">
                    <input type="hidden" name="csrf_token" value="<?= eliteDetalhesEscape($csrfToken) ?>">
                    <input type="hidden" name="assunto" value="<?= eliteDetalhesEscape('Interesse em ' . $nomeVeiculo) ?>">
                    <div class="elite-vehicle-contact__honeypot" aria-hidden="true">
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
                        <textarea id="interesse-mensagem" name="mensagem" minlength="10" maxlength="5000" required>Olá, tenho interesse no <?= eliteDetalhesEscape($nomeVeiculo) ?>. Gostaria de receber mais informações.</textarea>
                    </label>
                    <button type="submit">Solicitar contato</button>
                </form>
                <div class="elite-vehicle-contact__actions">
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <form action="carrinho.php" method="post">
                            <input type="hidden" name="csrf_token" value="<?= eliteDetalhesEscape($csrfToken) ?>">
                            <input type="hidden" name="acao" value="adicionar">
                            <input type="hidden" name="carro_id" value="<?= eliteDetalhesEscape($carro->getId()) ?>">
                            <button class="elite-vehicle-contact__secondary" type="submit">Adicionar ao carrinho</button>
                        </form>
                    <?php endif; ?>
                    <a href="pagamento.php?id=<?= rawurlencode((string) $carro->getId()) ?>">Ver formas de pagamento</a>
                </div>
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <div class="elite-vehicle-contact__account-actions">
                        <form method="post" action="favoritos.php">
                            <input type="hidden" name="csrf_token" value="<?= eliteDetalhesEscape($csrfToken) ?>">
                            <input type="hidden" name="acao" value="adicionar">
                            <input type="hidden" name="carro_id" value="<?= (int) $carro->getId() ?>">
                            <button type="submit">Salvar nos favoritos</button>
                        </form>
                        <form method="post" action="comparar.php">
                            <input type="hidden" name="csrf_token" value="<?= eliteDetalhesEscape($csrfToken) ?>">
                            <input type="hidden" name="acao" value="adicionar">
                            <input type="hidden" name="carro_id" value="<?= (int) $carro->getId() ?>">
                            <button type="submit">Comparar</button>
                        </form>
                    </div>
                <?php endif; ?>
            </aside>
        </div>
        <p class="elite-vehicle-detail__back"><a href="paginadecompra.php">← Voltar ao catálogo</a></p>
    <?php endif; ?>
</main>
<script>
(() => {
    const gallery = document.querySelector('[data-vehicle-gallery]');
    const viewport = gallery?.querySelector('.elite-vehicle-gallery__viewport');
    const track = gallery?.querySelector('.elite-vehicle-gallery__track');
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
        const item = image.closest('.elite-vehicle-gallery__item');
        if (!item) return;
        const fallbackSrc = item.dataset.fallbackSrc || '';
        if (fallbackSrc && !item.dataset.fallbackAttempted && image.src !== fallbackSrc) {
            item.dataset.fallbackAttempted = 'true';
            image.src = fallbackSrc;
            return;
        }
        item.remove();
        update();
    }, true);
    update();
})();
</script>
<?php require dirname(__DIR__, 3) . '/includes/footer.php'; ?>
</body>
</html>
