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
            <img src="../../assets/imagens/cars/bugatti/2018-08-24-bugatti-divo-37.avif" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">bugatti divo</h2>
                <p class="text-sm text-black mt-2">
                Motor: 8.0L W16 quad-turbo<br>
                Potência: 1.500 cv <br>
                Aceleração 0-100 km/h: Aproximadamente 2,4 segundos<br>
                Velocidade máxima: 380 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$ 40.000.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fbugatti%2F2018-08-24-bugatti-divo-37.avif" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/bugatti/veyron.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">bugatti veyron </h2>
                <p class="text-sm text-black mt-2">
               Motor: 8.0L W16 quad-turbo <br>
               Potência: 1.001 cv <br>
               Aceleração 0-100 km/h: Aproximadamente 2,5 segundos <br>
               Velocidade máxima: 407 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$7.150.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fbugatti%2Fveyron.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/bugatti/bugatti-chiron-super-sport-2021.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">bugatti chiron</h2>
               <p class="text-sm text-black mt-2">
               Motor: 8.0L W16 quad-turbo <br>
               Potência: 1.500 cv <br>
               Aceleração 0-100 km/h: Aproximadamente 2,5 segundos <br>
               Velocidade máxima: 420 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$ 35.000.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fbugatti%2Fbugatti-chiron-super-sport-2021.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/bugatti/Bugatti-Veyron-2015 (1).jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">bugatti veyron</h2>
               <p class="text-sm text-black mt-2">
               Motor: 8.0L W16 quad-turbo <br>
               Potência: 1.001 cv <br>
               Aceleração 0-100 km/h: Aproximadamente 2,5 segundos <br>
               Velocidade máxima: 407 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$ 6.000.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fbugatti%2FBugatti-Veyron-2015%20(1).jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/bugatti/Bugatti-W16_Mistral-2024-1280-f3cc71974aebcc89ec019de660555c0652.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">bugatti w16 mistral </h2>
               <p class="text-sm text-black mt-2">
               Motor: 8.0L W16 quad-turbo <br>
               Potência: 1.600 cv <br>
               Aceleração 0-100 km/h: Aproximadamente 2,5 segundos <br>
               Velocidade máxima: 420 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 "> R$ 30.000.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fbugatti%2FBugatti-W16_Mistral-2024-1280-f3cc71974aebcc89ec019de660555c0652.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/bugatti/centodieci.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">bugatti centodieci</h2>
               <p class="text-sm text-black mt-2">
               Motor: 8.0L W16 quad-turbo <br>
               Potência: 1.600 cv <br>
               Aceleração 0-100 km/h: Aproximadamente 2,4 segundos <br>
               Velocidade máxima: 380 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 "> R$ 40.000.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fbugatti%2Fcentodieci.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/bugatti/chiron.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">bugatti chiron</h2>
                <p class="text-sm text-black mt-2">
               Motor: 8.0L W16 quad-turbo <br>
               Potência: 1.500 cv <br>
               Aceleração 0-100 km/h: Aproximadamente 2,5 segundos <br>
               Velocidade máxima: 420 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$1.150.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fbugatti%2Fchiron.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/bugatti/eb110.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">bugatti eb110</h2>
               <p class="text-sm text-black mt-2">
               Motor: 3.5L V12 quad-turbo <br>
               Potência: 560 cv
 <br>
 Aceleração 0-100 km/h: Aproximadamente 3,2 segundos <br>
 Velocidade máxima: 343 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$ 2.500.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fbugatti%2Feb110.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/bugatti/lavoityre.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes la voituire noire">bugatti la voiture noire </h2>
                <p class="text-sm text-black mt-2">
               Motor: 8.0L W16 quad-turbo <br>
               Potência: 1.500 cv <br>
               Aceleração 0-100 km/h: Aproximadamente 2,5 segundos <br>
               Velocidade máxima: 420 km/h<br>
                </p>
                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$70.000.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fbugatti%2Flavoityre.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/bugatti/divo2.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">bugatti divo</h2>
                <p class="text-sm text-black mt-2">
                Motor: 8.0L W16 quad-turbo<br>
                Potência: 1.500 cv <br>
                Aceleração 0-100 km/h: Aproximadamente 2,4 segundos<br>
                Velocidade máxima: 380 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$40.000.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fbugatti%2Fdivo2.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
       
    </div>
</body>
</html>

