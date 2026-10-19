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

        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/ferrari/ferrarr.webp" alt="Carro"
                class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">ferrari 488 gtb</h2>
                <p class="text-sm text-black mt-2">
                    Motor:V8 biturbo de 670 cv<br>
                    Aceleração: 0-100 km/h em 3,0 segundos<br>
                    Velocidade máxima de 330 km/h<br>
                </p>
                <p class="text-black text-2xl gtimes -mb-4 mt-12">R$4.490.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fferrari%2Fferrarr.webp"
                    class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm  w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/ferrari/f40.webp" alt="Carro"
                class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">ferrari f40 v8 biturbo</h2>
                <p class="text-sm text-black mt-2">
                    Motor:V8 2.9L turbo de 478 cv<br>
                    Aceleração: 0-100 km/h em 3,8 segundos<br>
                    Velocidade máxima de 324 km/h<br>
                </p>
                <p class="text-black text-2xl gtimes -mb-4 mt-16">R$10.540.990</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fferrari%2Ff40.webp"
                    class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/ferrari/f8spider.jpg" alt="Carro"
                class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">ferrari f8 spider</h2>
                <p class="text-sm text-black mt-2">
                    Motor:V8 biturbo de 710 cv<br>
                    Aceleração: 0-100 km/h em 2,9 segundos<br>
                    Velocidade máxima de 340 km/h<br>
                </p>
                <p class="text-black text-2xl gtimes -mb-4 mt-12">R$5.399.990</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fferrari%2Ff8spider.jpg"
                    class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/ferrari/Ferrari 458 Italia.jpg" alt="Carro"
                class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">ferrari 458 itália</h2>
                <p class="text-sm text-black mt-2">
                    Motor:V8 de 570 cv<br>
                    Aceleração: 0-100 km/h em 3,4 segundos<br>
                    Velocidade máxima de 325 km/h<br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-12 ">R$3.340.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fferrari%2FFerrari%20458%20Italia.jpg"
                    class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/ferrari/ferrari-488 pista.jpg" alt="Carro"
                class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">ferrari 488 pista</h2>
                <p class="text-sm text-black mt-2">
                    Motor:V8 biturbo de 720 cv<br>
                    Aceleração: 0-100 km/h em 2,9 segundos<br>
                    Velocidade máxima de 340 km/h<br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-12">R$6.220.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fferrari%2Fferrari-488%20pista.jpg"
                    class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/ferrari/ferrari-purosangue-divulgacao1.jpg" alt="Carro"
                class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">ferrari purosangue</h2>
                <p class="text-sm text-black mt-2">
                    Motor:V12 de 725 cv<br>
                    Aceleração: 0-100 km/h em 3,3 segundos<br>
                    Velocidade máxima de 310 km/h<br>
                </p>

                <p class="text-black text-2xl gtimes mt-12 -mb-4">R$7.200.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fferrari%2Fferrari-purosangue-divulgacao1.jpg"
                    class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/ferrari/Ferrari296gtb.webp" alt="Carro"
                class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">ferrari 296 gtb</h2>
                <p class="text-sm text-black mt-2">
                    Motor:V6 híbrido de 830 cv<br>
                    Aceleração: 0-100 km/h em 2,9 segundos<br>
                    Velocidade máxima de 330 km/h<br>
                </p>
                <p class="text-black text-2xl gtimes mt-12 -mb-4">R$3.500.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fferrari%2FFerrari296gtb.webp"
                    class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/ferrari/Ferrari_FXX_K_Evo.webp" alt="Carro"
                class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">ferrari fxxk evo</h2>
                <p class="text-sm text-black mt-2">
                    Motor:V12 de 1050 cv<br>
                    Aceleração: 0-100 km/h em 2,5 segundos<br>
                    Velocidade máxima de 350 km/h<br>
                </p>
                <p class="text-black text-2xl gtimes mt-11 -mb-4">R$18.000.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fferrari%2FFerrari_FXX_K_Evo.webp"
                    class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/ferrari/laferrari.jpg" alt="Carro"
                class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">Ferrari la ferrari</h2>
                <p class="text-sm text-black mt-2">
                    Motor:V12 naturalmente aspirado de 800 cv<br>
                    Aceleração: 0-100 km/h em 2,6 segundos<br>
                    Velocidade máxima de 350 km/h<br>
                </p>
            </div>
            <p class="gtimes  text-2xl text-black mt-4 -mb-2">R$12.560.000</p>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fferrari%2Flaferrari.jpg"
                    class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-lg w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/ferrari/novitec-ferrari-sf90-stradale-2022.webp" alt="Carro"
                class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">Ferrari sf90</h2>
                <p class="text-sm text-black mt-2">
                    Motor:V8 biturbo de 1000 cv<br>
                    Aceleração: 0-100 km/h em 2,5 segundos<br>
                    Velocidade máxima de 340 km/h<br>
                </p>
                <p class="text-black text-2xl gtimes mt-16 -mb-4">R$6.230.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fferrari%2Fnovitec-ferrari-sf90-stradale-2022.webp"
                    class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
    </div>
</body>

</html>