<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
   <style>
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
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-y-10 gap-x-8 p-8">

        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/audi/2023-audi-r8-gt-front-three-quarters-motion-3-1664827965.avif" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">Audi r8 gt</h2>
                <p class="text-sm text-black mt-2">
                Motor : 5.2L V10 atmosférico <br>
                Potência : 560 cv<br>
                Aceleração 0-100 km/h : Aproximadamente 3,6 segundos <br>
                Velocidade máxima : 320 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$1.850.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Faudi%2F2023-audi-r8-gt-front-three-quarters-motion-3-1664827965.avif" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/audi/audi-rs6-avant-gt.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">audi rs6 avant</h2>
                 <p class="text-sm text-black mt-2">
                 Motor : 4.0L V8 biturbo <br>
                 Potência : 600 cv<br>
                 Aceleração 0-100 km/h : Aproximadamente 3,5 segundos <br>
                Velocidade máxima : 320 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$1.350.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Faudi%2Faudi-rs6-avant-gt.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/audi/audi-tt rs.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">audi tt rs</h2>
                 <p class="text-sm text-black mt-2">
                 Motor : 2.5L 5 cilindros turboalimentado <br>
                 Potência : 400 cv<br>
                 Aceleração 0-100 km/h : Aproximadamente 3,7 segundos <br>
                 Velocidade máxima : 280 km/h<br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$455.800</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Faudi%2Faudi-tt%20rs.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/audi/mtmrs6evo.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">audi mtm rs6 evo</h2>
                 <p class="text-sm text-black mt-2">
                 Motor : 4.0L V8 biturbo, modificado <br>
                 Potência : 1.000 cv<br>
                 Aceleração 0-100 km/h : Aproximadamente 3,0 segundos <br>
                 Velocidade máxima : Acima de 330 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$ 1.500.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Faudi%2Fmtmrs6evo.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/audi/nova-audi-rs6-avant-performance-frente.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">audi rs6 avant</h2>
                 <p class="text-sm text-black mt-2">
                 Motor : 4.0L V8 biturbo <br>
                 Potência : 600 cv<br>
                 Aceleração 0-100 km/h : Aproximadamente 3,5 segundos <br>
                 Velocidade máxima : 280 km/h (limitada eletronicamente) <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 "> R$ 1.400.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Faudi%2Fnova-audi-rs6-avant-performance-frente.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/audi/RS3 Sportback 12021.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">audi rs3 Sportback</h2>
                 <p class="text-sm text-black mt-2">
                 Motor : 2.5L 5 cilindros turboalimentado <br>
                 Potência : 400 cv<br>
                 Aceleração 0-100 km/h : Aproximadamente 3,8 segundos <br>
                Velocidade máxima : 320 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$ 450.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Faudi%2FRS3%20Sportback%2012021.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/audi/rs4-avant_2.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">audi rs4 avant</h2>
                 <p class="text-sm text-black mt-2">
                 Motor : 2.9L V6 biturbo<br>
                 Potência : 450 cv<br>
                 Aceleração 0-100 km/h : Aproximadamente 4,1 segundos<br>
                 Velocidade máxima : 250 km/h (limitada eletronicamwnte) <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$ 700.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Faudi%2Frs4-avant_2.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/audi/rs7 2025.avif" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">audi rs7</h2>
                 <p class="text-sm text-black mt-2">
                 Motor : 4.0L V8 biturbo <br>
                 Potência : 600 cv<br>
                 Aceleração 0-100 km/h : Aproximadamente 3,6 segundos <br>
                 Velocidade máxima : 250 km/h (limitada eletronicamente) <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$ 1.200.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Faudi%2Frs7%202025.avif" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/audi/image.png" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">audi r8</h2>
                <p class="text-sm text-black mt-2">
                Motor : 5.2L V10 atmosférico <br>
                Potência : 560 cv<br>
                Aceleração 0-100 km/h : Aproximadamente 3,6 segundos <br>
                Velocidade máxima : 320 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$1.250.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Faudi%2Fimage.png" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/audi/rs32025.png" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">audi rs3 </h2>
                <p class="text-sm text-black mt-2">
                Motor : 5.2L V10 atmosférico <br>
                Potência : 560 cv<br>
                Aceleração 0-100 km/h : Aproximadamente 3,6 segundos <br>
                Velocidade máxima : 320 km/h <br>
                </p>


                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$450.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Faudi%2Frs32025.png" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
       
    </div>
</body>
</html>

