<?php
declare(strict_types=1);

function luxcarsHomeEscape(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Encontre veículos premium na LuxCars. Explore o catálogo e consulte os detalhes de cada modelo.">
    <title>LuxCars | Veículos premium</title>
    <link rel="stylesheet" href="../assets/css/fonte.css">
    <link rel="stylesheet" href="../assets/css/site.css?v=20261017-brands-2">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-950 text-white">
<?php require dirname(__DIR__, 3) . '/includes/navbar.php'; ?>
<main>
    <section class="luxcars-hero luxcars-home-carousel flex min-h-[68vh] items-center bg-cover bg-center px-6 py-20 sm:px-10 lg:px-16" aria-roledescription="carrossel" aria-label="Destaques LuxCars" data-luxcars-carousel>
        <div class="luxcars-home-carousel__slides" aria-live="off">
            <div class="luxcars-home-carousel__slide is-active" aria-hidden="false"><img src="../assets/imagens/carrosel/ferrari.jpg" alt="Ferrari em destaque" fetchpriority="high"></div>
            <div class="luxcars-home-carousel__slide" aria-hidden="true"><img src="../assets/imagens/carrosel/koenisseg.jpg" alt="Koenigsegg em destaque" loading="lazy"></div>
            <div class="luxcars-home-carousel__slide" aria-hidden="true"><img src="../assets/imagens/carrosel/mclarne%20sena.jpg" alt="McLaren Senna em destaque" loading="lazy"></div>
            <div class="luxcars-home-carousel__slide" aria-hidden="true"><img src="../assets/imagens/carrosel/mercedes.jpg" alt="Mercedes-Benz em destaque" loading="lazy"></div>
        </div>
        <div class="luxcars-home-carousel__content mx-auto w-full max-w-7xl">
            <p class="mb-4 font-semibold uppercase tracking-[.3em] text-amber-300">LuxCars Ltda.</p>
            <h1 id="titulo-principal" class="max-w-3xl text-4xl font-black leading-tight sm:text-6xl">Escolha o pr&oacute;ximo cap&iacute;tulo da sua jornada.</h1>
            <p class="mt-5 max-w-2xl text-lg text-gray-200">Explore uma sele&ccedil;&atilde;o de ve&iacute;culos premium e encontre o modelo que combina com voc&ecirc;.</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a class="rounded bg-amber-400 px-6 py-3 font-bold text-black transition hover:bg-amber-300" href="paginadecompra.php">Explorar ve&iacute;culos</a>
                <a class="rounded border border-white/70 px-6 py-3 font-semibold transition hover:bg-white hover:text-black" href="contato.php">Falar com a equipe</a>
            </div>
        </div>
        <div class="luxcars-home-carousel__controls" aria-label="Controles do carrossel">
            <button class="luxcars-home-carousel__arrow" type="button" data-carousel-prev aria-label="Imagem anterior">&lsaquo;</button>
            <div class="luxcars-home-carousel__dots" role="group" aria-label="Escolher destaque">
                <button class="is-active" type="button" data-carousel-to="0" aria-label="Mostrar Ferrari" aria-current="true"></button>
                <button type="button" data-carousel-to="1" aria-label="Mostrar Koenigsegg" aria-current="false"></button>
                <button type="button" data-carousel-to="2" aria-label="Mostrar McLaren Senna" aria-current="false"></button>
                <button type="button" data-carousel-to="3" aria-label="Mostrar Mercedes-Benz" aria-current="false"></button>
            </div>
            <button class="luxcars-home-carousel__arrow" type="button" data-carousel-next aria-label="Proxima imagem">&rsaquo;</button>
        </div>
    </section>
    <script>
        (() => {
            const carousel = document.querySelector('[data-luxcars-carousel]');
            if (!carousel) return;
            const slides = [...carousel.querySelectorAll('.luxcars-home-carousel__slide')];
            const dots = [...carousel.querySelectorAll('[data-carousel-to]')];
            let activeIndex = 0;
            let timer;
            const showSlide = (index) => {
                activeIndex = (index + slides.length) % slides.length;
                slides.forEach((slide, i) => {
                    const active = i === activeIndex;
                    slide.classList.toggle('is-active', active);
                    slide.setAttribute('aria-hidden', String(!active));
                });
                dots.forEach((dot, i) => {
                    const active = i === activeIndex;
                    dot.classList.toggle('is-active', active);
                    dot.setAttribute('aria-current', String(active));
                });
            };
            const restart = () => {
                window.clearInterval(timer);
                if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) timer = window.setInterval(() => showSlide(activeIndex + 1), 6000);
            };
            carousel.querySelector('[data-carousel-prev]').addEventListener('click', () => { showSlide(activeIndex - 1); restart(); });
            carousel.querySelector('[data-carousel-next]').addEventListener('click', () => { showSlide(activeIndex + 1); restart(); });
            dots.forEach((dot) => dot.addEventListener('click', () => { showSlide(Number(dot.dataset.carouselTo)); restart(); }));
            carousel.addEventListener('mouseenter', () => window.clearInterval(timer));
            carousel.addEventListener('mouseleave', restart);
            carousel.addEventListener('focusin', () => window.clearInterval(timer));
            carousel.addEventListener('focusout', restart);
            restart();
        })();
    </script>

    <section class="luxcars-brands-section mx-auto max-w-[1800px] px-6 py-10" aria-labelledby="marcas-titulo">
        <div class="mb-7 flex flex-wrap items-end justify-between gap-4">
            <div><p class="text-sm font-semibold uppercase tracking-widest text-gray-500">LuxCars</p><h2 id="marcas-titulo" class="mt-1 text-3xl font-bold">Explore por marca</h2></div>
            <a class="text-sm font-semibold text-gray-700 underline underline-offset-4 hover:text-black" href="paginadecompra.php">Ver catálogo completo</a>
        </div>
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-8">
            <?php
            $marcas = [
                ['BMW', 'bmw', 'bmww (1).png'], ['Ferrari', 'ferrari', 'ferrarir (3).png'],
                ['McLaren', 'mclaren', 'mclaren (1).png'], ['Lamborghini', 'lamborghini', 'logo-lamborghini-1024 (1).png'],
                ['Mercedes-Benz', 'mercedes', 'mercedess (1).png'], ['Audi', 'audi', 'audi.png'],
                ['Porsche', 'porsche', 'porsche (1).png'], ['Koenigsegg', 'koenigsegg', 'koenisssge.png'],
            ];
            foreach ($marcas as [$nome, $slug, $arquivo]):
            ?>
                <a class="luxcars-brand-tile flex min-h-28 flex-col items-center justify-center gap-2 p-2 text-center text-sm font-semibold text-gray-900" href="paginasdasmarcas/<?= luxcarsHomeEscape($slug) ?>.php">
                    <img class="h-14 w-16 object-contain" src="../assets/imagens/logos/<?= rawurlencode($arquivo) ?>" alt="<?= luxcarsHomeEscape($nome) ?>" loading="lazy">
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="luxcars-featured-vehicles mx-auto py-10" aria-labelledby="estoque-titulo" data-featured-vehicles>
        <div class="mb-7 flex flex-wrap items-end justify-between gap-4">
            <div><p class="text-sm uppercase tracking-widest text-amber-300">Estoque atualizado</p><h2 id="estoque-titulo" class="mt-1 text-3xl font-bold">Ve&iacute;culos em destaque</h2></div>
            <div class="luxcars-featured-vehicles__toolbar">
                <a class="rounded border border-white/40 px-4 py-2 hover:border-amber-300 hover:text-amber-300" href="paginadecompra.php">Buscar no cat&aacute;logo</a>
            </div>
        </div>
        <?php if ($erroBanco !== null): ?>
            <p class="rounded-lg border border-red-400/40 bg-red-950 p-4 text-center" role="alert"><?= luxcarsHomeEscape($erroBanco) ?></p>
        <?php elseif ($carros === []): ?>
            <p class="rounded-lg bg-gray-800 p-5 text-center">Nenhum veículo disponível no momento.</p>
        <?php else: ?>
            <div class="luxcars-featured-vehicles__stage">
            <div class="luxcars-featured-vehicles__viewport" id="veiculos-destaque-lista" tabindex="0" aria-label="Ve&iacute;culos em destaque" aria-roledescription="carrossel">
                <div class="luxcars-featured-vehicles__track">
                <?php foreach (array_slice($carros, 0, 8) as $carro): ?>
                    <article class="luxcars-car-card luxcars-featured-vehicles__card">
                        <?php if ($carro->getImagem() !== null && $carro->getImagem() !== ''): ?>
                            <img class="luxcars-car-card__image" src="<?= luxcarsHomeEscape('../' . ltrim($carro->getImagem(), '/')) ?>" alt="<?= luxcarsHomeEscape($carro->getMarca() . ' ' . $carro->getModelo()) ?>" loading="lazy">
                        <?php else: ?>
                            <div class="luxcars-car-card__placeholder">Imagem indisponível</div>
                        <?php endif; ?>
                        <div class="luxcars-car-card__content">
                            <p class="luxcars-car-card__eyebrow"><?= luxcarsHomeEscape($carro->getMarca()) ?> · <?= $carro->getAno() ?></p>
                            <h3 class="luxcars-car-card__title"><?= luxcarsHomeEscape($carro->getModelo()) ?></h3>
                            <p class="luxcars-car-card__price">R$ <?= number_format($carro->getPreco(), 2, ',', '.') ?></p>
                            <a class="luxcars-car-card__button" href="detalhes.php?id=<?= rawurlencode((string) $carro->getId()) ?>">Ver detalhes</a>
                        </div>
                    </article>
                <?php endforeach; ?>
                </div>
            </div>
                <div class="luxcars-featured-vehicles__controls" aria-label="Navegar pelos ve&iacute;culos">
                    <button class="luxcars-featured-vehicles__arrow" type="button" data-vehicles-prev aria-label="Ve&iacute;culo anterior" aria-controls="veiculos-destaque-lista" disabled>&larr;</button>
                    <button class="luxcars-featured-vehicles__arrow" type="button" data-vehicles-next aria-label="Pr&oacute;ximo ve&iacute;culo" aria-controls="veiculos-destaque-lista">&rarr;</button>
                </div>
            </div>
        <?php endif; ?>
    </section>
    <script>
        (() => {
            const section = document.querySelector('[data-featured-vehicles]');
            const viewport = section?.querySelector('.luxcars-featured-vehicles__viewport');
            const previous = section?.querySelector('[data-vehicles-prev]');
            const next = section?.querySelector('[data-vehicles-next]');
            const track = section?.querySelector('.luxcars-featured-vehicles__track');
            const card = track?.querySelector('.luxcars-featured-vehicles__card');
            if (!viewport || !previous || !next || !track || !card) return;

            const updateArrows = () => {
                const maxScroll = viewport.scrollWidth - viewport.clientWidth;
                previous.disabled = viewport.scrollLeft <= 1;
                next.disabled = maxScroll <= 1 || viewport.scrollLeft >= maxScroll - 1;
            };
            const moveByCard = (direction) => {
                const gap = Number.parseFloat(getComputedStyle(track).columnGap) || 0;
                viewport.scrollBy({ left: direction * (card.getBoundingClientRect().width + gap), behavior: 'smooth' });
            };

            previous.addEventListener('click', () => moveByCard(-1));
            next.addEventListener('click', () => moveByCard(1));
            viewport.addEventListener('scroll', () => window.requestAnimationFrame(updateArrows), { passive: true });
            window.addEventListener('resize', updateArrows);
            updateArrows();
        })();
    </script>
</main>
<?php require dirname(__DIR__, 3) . '/includes/footer.php'; ?>
</body>
</html>
