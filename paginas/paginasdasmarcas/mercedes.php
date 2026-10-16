<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mercedes-Benz | LuxCars</title>
    <script src="https://cdn.tailwindcss.com"></script>
   <style>
    .vehicle-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(min(100%, 250px), 1fr));
        gap: 1.5rem;
        max-width: 1440px;
        margin: 0 auto;
        padding: 2.5rem clamp(1rem, 4vw, 3rem);
    }
    .vehicle-grid > header {
        grid-column: 1 / -1;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.16);
    }
    .vehicle-grid > div {
        width: 100%;
        max-width: 360px;
        padding: 0;
        overflow: hidden;
        align-items: stretch;
        color: #f4f5f6;
        background: #171a1d;
        border: 1px solid #34393e;
        border-radius: 0.75rem;
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.24);
        transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
    }
    .vehicle-grid > div:hover {
        transform: translateY(-4px);
        border-color: #aeb6bc;
        box-shadow: 0 18px 36px rgba(0, 0, 0, 0.38);
    }
    .vehicle-grid > div > img {
        width: 100%;
        height: 190px;
        object-fit: cover;
        border-radius: 0;
        background: #252a2f;
    }
    .vehicle-grid > div > div:nth-child(2) {
        display: flex;
        flex: 1;
        flex-direction: column;
        align-items: stretch;
        padding: 1.1rem 1.1rem 0.5rem;
        text-align: left;
    }
    .vehicle-grid h2 {
        min-height: 3rem;
        color: #f4f5f6;
        font-size: 1rem;
        line-height: 1.5rem;
    }
    .vehicle-grid > div > div:nth-child(2) > p:first-of-type {
        margin-top: 0.65rem;
        color: #b9c0c5;
        font-size: 0.8rem;
        line-height: 1.55;
    }
    .vehicle-grid > div > div:nth-child(2) > p.text-2xl {
        margin: auto 0 0;
        padding-top: 1rem;
        color: #fff;
        font-size: 1.35rem;
    }
    .vehicle-grid > div > div:last-child {
        margin-top: 0;
        padding: 0 1.1rem 1.1rem;
    }
    .vehicle-grid a.block {
        padding: 0.75rem 1rem;
        color: #111518;
        background: #c8d0d5;
        border-radius: 0.35rem;
        box-shadow: none;
        transition: background-color 0.2s ease, transform 0.2s ease;
    }
    .vehicle-grid a.block:hover {
        color: #111518;
        background: #eef1f3;
    }
    @media (max-width: 640px) {
        .vehicle-grid {
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 230px), 1fr));
            gap: 1rem;
            padding-top: 1.5rem;
        }
    }
    @font-face {
        font-family: 'gtimes';
        src: url(../../assets/fontes/good_times/Good\ Times\ Rg.otf);
        font-weight: bold;
        font-style: normal;
    }
    .gtimes{
        font-family: 'gtimes', Arial, Helvetica, sans-serif;
    }
    @font-face {
        font-family: 'luxo';
        src: url(../../assets/fontes/luxoorea/Luxoorea.otf);
        font-weight: bold;
        font-style: normal;
    }
    #luxo {
        font-family: 'luxo', Arial, Helvetica, sans-serif;
        font-weight: 800;
        font-style: normal;
    }
        .hover-effect {
            transition: transform 0.3s ease;
        }
        .hover-effect:hover {
            transform: translateY(-3px); 
        }
    
   </style>
<link rel="stylesheet" href="../../assets/css/site.css">
</head>
<body class="bg-gradient-to-t from-black to-gray-900 text-white min-h-screen">
<?php require_once __DIR__ . '/../../includes/navbar.php'; ?>
    <main class="vehicle-grid">
        <header>
            <p class="gtimes text-xs tracking-widest text-gray-400">LUXCARS / MARCAS</p>
            <h1 class="gtimes mt-2 text-2xl text-white sm:text-3xl">Mercedes-Benz</h1>
            <p class="mt-2 text-sm text-gray-400">Esportividade, tecnologia e desempenho em cada modelo.</p>
        </header>

        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/mercedes/2023-mercedes-amg-e63-s-4matic-103-1671563913.avif" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">mercedes amg e63s</h2>
                <p class="text-sm text-black mt-2">
                Motor : 4.0L V8 biturbo <br>
                Potência : 612 cv <br>
                Aceleração 0-100 km/h : 3,4 segundos <br>
                Velocidade máxima : 300 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$920.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fmercedes%2F2023-mercedes-amg-e63-s-4matic-103-1671563913.avif" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/mercedes/a200amg.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">mercedes a200amg</h2>
                <p class="text-sm text-black mt-2">
                Motor : 1.3L 4 cilindros turbo <br>
                Potência : 163 cv <br>
                Aceleração 0-100 km/h : Aproximadamente 8,1 segundos <br>
                Velocidade máxima : 225 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$240.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fmercedes%2Fa200amg.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/mercedes/amg gtr pro2018.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">mercedes amg gt r pro</h2>
                <p class="text-sm text-black mt-2">
                Motor : 4.0L V8 biturbo<br>
                Potência : 585 cv <br>
                Aceleração 0-100 km/h : Aproximadamente 3,5 segundos <br>
                Velocidade máxima : 318 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$1.990.900</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fmercedes%2Famg%20gtr%20pro2018.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/mercedes/AMGcle53.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">mercedes amg cle53</h2>
                <p class="text-sm text-black mt-2">
                Motor : 3.0L 6 cilindros em linha turboalimentado com sistema híbrido leve (EQ Boost)<br>
                Potência : 435 cv <br>
                Aceleração 0-100 km/h : Aproximadamente 4,5 segundos <br>
                Velocidade máxima : 250 km/h (limitada eletronicamente) <br>
                </p>
                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$670.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fmercedes%2FAMGcle53.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/mercedes/amggt63s.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">mercedes amg gt63s</h2>
                <p class="text-sm text-black mt-2">
                Motor : 4.0L V8 biturbo <br>
                Potência : 639 cv<br>
                Aceleração 0-100 km/h : Aproximadamente 3,2 segundos<br>
                Velocidade máxima : 315 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$1.355.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fmercedes%2Famggt63s.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/mercedes/c300.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">mercedes c300</h2>
                <p class="text-sm text-black mt-2">
                Motor : 2.0L 4 cilindros turbo <br>
                Potência : 258 cv<br>
                Aceleração 0-100 km/h : Aproximadamente 6,0 segundos <br>
                Velocidade máxima : 250 km/h (limitada eletronicamente) <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$300.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fmercedes%2Fc300.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/mercedes/cls63amg.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">mercedes cls63amg</h2>
                <p class="text-sm text-black mt-2">
                Motor : 4.0L V8 <br>
                Potência: 612 cv <br>
                Aceleração 0-100 km/h : Aproximadamente 3,4 segundos <br>
                Velocidade máxima : 250 km/h (limitada eletronicamente) <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$1.090.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fmercedes%2Fcls63amg.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/mercedes/gla2021.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">mercedes gla</h2>
                <p class="text-sm text-black mt-2">
                Motor : motores 1.3L turbo <br>
                Potência : Entre 163 cv <br>
                Aceleração 0-100 km/h : Aproximadamente 8,0 segundos <br>
                Velocidade máxima : Até 250 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$260.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fmercedes%2Fgla2021.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/mercedes/Mercedes-AMG-GT-63S-E-Performance-e-hibrido-plug-in-mais-rapido-da-historia-da-Mercedes.png" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">mercedes amg gt63s</h2>
                <p class="text-sm text-black mt-2">
                Motor : 4.0L V8 biturbo <br>
                Potência : 639 cv<br>
                Aceleração 0-100 km/h : Aproximadamente 3,2 segundos<br>
                Velocidade máxima : 315 km/h <br>
                </p>


                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$1.150.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fmercedes%2FMercedes-AMG-GT-63S-E-Performance-e-hibrido-plug-in-mais-rapido-da-historia-da-Mercedes.png" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/mercedes/Mercedes-Benz_SLR_McLaren_2.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">mercedes slr mclaren</h2>
                <p class="text-sm text-black mt-2">
                Motor : 5.4L V8 superalimentado<br>
                Potência : 617 cv <br>
                Aceleração 0-100 km/h : Aproximadamente 3,8 segundos <br>
                Velocidade máxima : 334 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$2.500.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fmercedes%2FMercedes-Benz_SLR_McLaren_2.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
       
    </main>
</body>
</html>

