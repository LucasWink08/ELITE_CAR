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
            <img src="../../assets/imagens/cars/porsche/2017-10-04-porsche-panamera-turbo-sport-turismo-10.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">porsche panamera </h2>
                <p class="text-sm text-black mt-2">
                Motorização: V6 <br>
                Potência: 500 cv <br>
                Aceleração 0-100 km/h: 5,6 a 3,1 segundos <br>
                Velocidade máxima: Até 315 km/h  <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$ 630.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fporsche%2F2017-10-04-porsche-panamera-turbo-sport-turismo-10.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/porsche/2017-porsche-718-cayman.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">porsche cayman</h2>
               <p class="text-sm text-black mt-2">
               Motorização: Flat-4 <br>
               Potência: 420 cv <br>
               Velocidade máxima: Até 293 km/h  <br>
               Aceleração 0-100 km/h: 4,9 a 4,4 segundos <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 "> R$ 500.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fporsche%2F2017-porsche-718-cayman.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/porsche/911gt1s.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">porsche 911 gt1s</h2>
               <p class="text-sm text-black mt-2">
               Motorização: 3.2L Flat-6 biturbo <br>
               Potência: 537 cv <br>
               Aceleração 0-100 km/h: 3,9 segundos <br>
                Velocidade máxima: 310 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$ 30.000.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fporsche%2F911gt1s.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/porsche/porsche-718-spyder-rs-br.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">porsche 718 spider rs </h2>
               <p class="text-sm text-black mt-2">
               Motorização: 4.0L Flat-6 aspirado <br>
               Potência: 500 cv <br>
               Aceleração 0-100 km/h: 3,4 segundos<br>
               Velocidade máxima: 308 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$1.100.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fporsche%2Fporsche-718-spyder-rs-br.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/porsche/porsche-911-gt2-rs.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">porsche 911 gt2</h2>
               <p class="text-sm text-black mt-2">
               Motorização: 3.8L Flat-6 biturbo <br>
               Potência: 700 cv <br>
               Velocidade máxima: 340 km/h <br>
               Aceleração 0-100 km/h: 2,7 segundos <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$2.450.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fporsche%2Fporsche-911-gt2-rs.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/porsche/porsche-cayenne-2023.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">porsche cayenne </h2>
               <p class="text-sm text-black mt-2">
               Motorização: V6 <br>
               Potência: 335 cv <br>
               Velocidade máxima: Até 250 km/h <br>
               Aceleração 0-100 km/h: 6,2 segundos <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$1.150.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fporsche%2Fporsche-cayenne-2023.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/porsche/porsche-macan-rwd-2024.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">porsche macan</h2>
               <p class="text-sm text-black mt-2">
               Motorização: 4 cilindros e V6 <br>
               Potência: 350cv <br>
               Velocidade máxima: Até 270 km/h <br>
               Aceleração 0-100 km/h: 6,4 segundos <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$1.150.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fporsche%2Fporsche-macan-rwd-2024.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/porsche/Porsche_918_Spyder_IAA_2013.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">porsche 918 spider </h2>
               <p class="text-sm text-black mt-2">
               Motorização: 4.6L V8 + motores elétricos <br>
               Potência: 887 cv <br>
               Velocidade máxima: 345 km/h <br>
               Aceleração 0-100 km/h: 2,6 segundos <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 "> R$ 10.000.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fporsche%2FPorsche_918_Spyder_IAA_2013.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/porsche/porschegt3rs.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">porsche gt3 rs </h2>
               <p class="text-sm text-black mt-2">
               Motorização: 4.0L Flat-6 aspirado <br>
               Potência: 525 cv <br>
               Velocidade máxima: 296 km/h <br>
               Aceleração 0-100 km/h: 3,2 segundos <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 "> R$ 2.200.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fporsche%2Fporschegt3rs.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/porsche/porschetaycan1.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">porsche taycan</h2>
               <p class="text-sm text-black mt-2">
               Motorização: Motores elétricos <br>
               Potência: Até 761 cv <br>
               Velocidade máxima: 260 km/h <br>
               Aceleração 0-100 km/h: 5,4 a 2,8 segundos <br>
                </p>
                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$ 630.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fporsche%2Fporschetaycan1.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
    </div>
</body>
</html>

