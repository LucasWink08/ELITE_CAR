<?php
$veiculos = [
    [
        'nome' => 'BMW i8',
        'imagem' => 'assets/imagens/cars/bmw/bmw i8.webp',
        'motor' => '1.5 L, 3 cilindros turbo + motor elétrico (híbrido plug-in)',
        'potencia' => '362 cv',
        'aceleracao' => '4,4 s',
        'velocidade' => '250 km/h',
        'preco' => 1100000,
    ],
    [
        'nome' => 'BMW X6 M Competition',
        'imagem' => 'assets/imagens/cars/bmw/2020-bmw-x6-m-competition-1.webp',
        'motor' => 'V8 4.4 L biturbo',
        'potencia' => '625 cv',
        'aceleracao' => '3,8 s',
        'velocidade' => '250 km/h (limitada)',
        'preco' => 630000,
    ],
    [
        'nome' => 'BMW M5 CS',
        'imagem' => 'assets/imagens/cars/bmw/BMW M5 CS.webp',
        'motor' => 'V8 4.4 L biturbo',
        'potencia' => '635 cv',
        'aceleracao' => '3,0 s',
        'velocidade' => '305 km/h',
        'preco' => 900000,
    ],
    [
        'nome' => 'BMW i7 M70 xDrive',
        'imagem' => 'assets/imagens/cars/bmw/bmw-i7-m70.jpg',
        'motor' => 'Dois motores elétricos, tração integral',
        'potencia' => '660 cv',
        'aceleracao' => '3,7 s',
        'velocidade' => '250 km/h (limitada)',
        'preco' => 1350000,
    ],
    [
        'nome' => 'BMW X4 M40i',
        'imagem' => 'assets/imagens/cars/bmw/BMW-X4-M40i-Individual_1.jpg',
        'motor' => '6 cilindros em linha, 3.0 L turbo',
        'potencia' => '387 cv',
        'aceleracao' => '4,5 s',
        'velocidade' => '250 km/h (limitada)',
        'preco' => 500000,
    ],
    [
        'nome' => 'BMW M3 CS (G80)',
        'imagem' => 'assets/imagens/cars/bmw/BMWM3G80CS.png',
        'motor' => '6 cilindros em linha, 3.0 L biturbo',
        'potencia' => '550 cv',
        'aceleracao' => '3,4 s',
        'velocidade' => '302 km/h',
        'preco' => 950000,
    ],
    [
        'nome' => 'BMW M8 Competition Gran Coupé',
        'imagem' => 'assets/imagens/cars/bmw/bmwm8grancoupe.webp',
        'motor' => 'V8 4.4 L biturbo',
        'potencia' => '625 cv',
        'aceleracao' => '3,1 s',
        'velocidade' => '250 km/h (limitada)',
        'preco' => 1150000,
    ],
    [
        'nome' => 'BMW M4 Coupé',
        'imagem' => 'assets/imagens/cars/bmw/m4competition.jpg',
        'motor' => '6 cilindros em linha, 3.0 L biturbo',
        'potencia' => '480 cv',
        'aceleracao' => '4,2 s',
        'velocidade' => '250 km/h (limitada)',
        'preco' => 630000,
    ],
    [
        'nome' => 'BMW M4 GTS',
        'imagem' => 'assets/imagens/cars/bmw/M4gts.jpg',
        'motor' => '6 cilindros em linha, 3.0 L biturbo com injeção de água',
        'potencia' => '500 cv',
        'aceleracao' => '3,8 s',
        'velocidade' => '305 km/h (limitada)',
        'preco' => 1100000,
    ],
    [
        'nome' => 'BMW M5',
        'imagem' => 'assets/imagens/cars/bmw/G90 BMW M5 saloon-13.webp',
        'motor' => 'V8 4.4 L biturbo',
        'potencia' => '600 cv',
        'aceleracao' => '3,4 s',
        'velocidade' => '250 km/h (limitada)',
        'preco' => 920990,
    ],
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMW | Elite Automóveis</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/site.css">
    <style>
        .elite-bmw-page .elite-car-card__title { text-transform: none; }
        .elite-bmw-page .elite-car-card__content { gap: .8rem; }
        .elite-bmw-page .elite-car-card__specs--performance { margin-top: .15rem; }
        .elite-bmw-page .elite-car-card__price { color: #f0d990; white-space: nowrap; }
        .elite-bmw-page .elite-car-card__button { gap: .5rem; }
        .elite-bmw-page .elite-car-card__button span { font-size: 1.1em; transition: transform .18s ease; }
        .elite-bmw-page .elite-car-card__button:hover span { transform: translateX(3px); }
    </style>
</head>
<body class="min-h-screen bg-[#090a0c] text-white">
<?php require_once __DIR__ . '/../../includes/navbar.php'; ?>
<main class="elite-bmw-page mx-auto max-w-[1800px] px-5 py-8 sm:px-8">
    <header class="mb-7 flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="mb-2 text-xs font-bold uppercase tracking-[.24em] text-[#d9c27c]">Estoque selecionado</p>
            <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">BMW</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-400">Especificações e valores organizados para comparar cada modelo com facilidade.</p>
        </div>
        <span class="rounded-full border border-[#d9c27c]/25 bg-[#d9c27c]/[.06] px-4 py-2 text-sm text-[#e8d69a]"><?= count($veiculos) ?> veículos</span>
    </header>

    <section class="grid grid-cols-1 items-stretch gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5" aria-label="Veículos BMW disponíveis">
        <?php foreach ($veiculos as $veiculo):
            $imagem = htmlspecialchars($veiculo['imagem'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
            $nome = htmlspecialchars($veiculo['nome'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
            $urlDetalhes = '../detalhes.php?' . http_build_query(['imagem' => $veiculo['imagem']], '', '&', PHP_QUERY_RFC3986);
        ?>
            <article class="elite-car-card">
                <img
                    class="elite-car-card__image"
                    src="../../<?= $imagem ?>"
                    alt="<?= $nome ?>"
                    loading="lazy"
                    decoding="async"
                >
                <div class="elite-car-card__content">
                    <h2 class="elite-car-card__title"><?= $nome ?></h2>
                    <dl class="elite-car-card__specs elite-car-card__specs--performance">
                        <div><dt>Motor</dt><dd><?= htmlspecialchars($veiculo['motor'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></dd></div>
                        <div><dt>Potência</dt><dd><?= htmlspecialchars($veiculo['potencia'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></dd></div>
                        <div><dt>0–100 km/h</dt><dd><?= htmlspecialchars($veiculo['aceleracao'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></dd></div>
                        <div><dt>Velocidade máxima</dt><dd><?= htmlspecialchars($veiculo['velocidade'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></dd></div>
                    </dl>
                    <p class="elite-car-card__price">R$ <?= number_format($veiculo['preco'], 2, ',', '.') ?></p>
                </div>
                <div class="elite-car-card__actions">
                    <a class="elite-car-card__button" href="<?= htmlspecialchars($urlDetalhes, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
                        Ver detalhes <span aria-hidden="true">→</span>
                    </a>
                </div>
            </article>
        <?php endforeach; ?>
    </section>
</main>
</body>
</html>
