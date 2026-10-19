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
            <img src="../../assets/imagens/cars/lamborghini/2024-lamborghini-revuelto-110-651719c597ac8.avif" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">lamborghini revuelto </h2>
                  <p class="text-sm text-black mt-2">
                  Motor : 6.5L V12 atmosférico, combinado com 3 motores elétricos <br>
                  Potência : 1.001 cv <br>
                  Aceleração 0-100 km/h : Aceleração de 0 a 100 km/h em menos de 2,5 segundos <br>
                  Velocidade máxima : Aproximadamente 350 km/h/h<br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$8.000.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Flamborghini%2F2024-lamborghini-revuelto-110-651719c597ac8.avif" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/lamborghini/aventador2021.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">lamborghini aventador</h2>
                 <p class="text-sm text-black mt-2">
                 Motor : 6.5L V12 atmosférico <br>
                 Potência : 730 cv <br>
                 Aceleração 0-100 km/h : 2,9 segundos <br>
                 Velocidade máxima : 350 km/h<br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$2.525.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Flamborghini%2Faventador2021.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/lamborghini/huracen2018.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">lamborghini huracan</h2>
                 <p class="text-sm text-black mt-2">
                 Motor : 5.2L V10 atmosférico <br>
                 Potência : 640 cv <br>
                 Aceleração 0-100 km/h : 2,9 segundos <br>
                 Velocidade máxima : 325 km/h<br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$1.300.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Flamborghini%2Fhuracen2018.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/lamborghini/lambo-revuelto-1.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">lamborghini revuelto</h2>
                <p class="text-sm text-black mt-2">
                  Motor : 6.5L V12 atmosférico, combinado com 3 motores elétricos <br>
                  Potência : 1.001 cv <br>
                  Aceleração 0-100 km/h : Aceleração de 0 a 100 km/h em menos de 2,5 segundos <br>
                  Velocidade máxima : Aproximadamente 350 km/h/h<br>
                </p>
                <p class="text-black text-2xl gtimes -mb-4 mt-10 ">R$9.770.700</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Flamborghini%2Flambo-revuelto-1.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/lamborghini/inovacoes-que-o-Lamborghini-Aventador.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">lamborghini aventador</h2>
                <p class="text-sm text-black mt-2">
                 Motor : 6.5L V12 atmosférico <br>
                 Potência : 730 cv <br>
                 Aceleração 0-100 km/h : 2,9 segundos <br>
                 Velocidade máxima : 350 km/h<br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$3.300.890</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Flamborghini%2Finovacoes-que-o-Lamborghini-Aventador.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/lamborghini/lamborghini-gallardo-5795139_1280.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">lamborghini gallardo</h2>
                 <p class="text-sm text-black mt-2">
                 Motor : 5.2L V10 atmosférico <br>
                 Potência : 560 cv <br>
                 Aceleração 0-100 km/h : 3,7 segundos<br>
                 Velocidade máxima : 320 km/h<br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$1.110.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Flamborghini%2Flamborghini-gallardo-5795139_1280.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/lamborghini/lamborghini-urus-s.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">lamborghini urus </h2>
                 <p class="text-sm text-black mt-2">
                 Motor : 4.0L V8 biturbo <br>
                 Potência : 650 cv <br>
                 Aceleração 0-100 km/h : 3,6 segundos <br>
                 Velocidade máxima : 305 km/h<br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$1.487.990</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Flamborghini%2Flamborghini-urus-s.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/lamborghini/lamborghini-veneno-6.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">lamborghini veneno</h2>
                 <p class="text-sm text-black mt-2">
                 Motor : 6.5L V12 atmosférico <br>
                 Potência : 750 cv<br>
                 Aceleração 0-100 km/h : 2,8 segundos <br>
                 Velocidade máxima : 355 km/h<br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$35.670.900</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Flamborghini%2Flamborghini-veneno-6.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/lamborghini/urus2024.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">lamborghini urus</h2>
                <p class="text-sm text-black mt-2">
                 Motor : 4.0L V8 biturbo <br>
                 Potência : 650 cv <br>
                 Aceleração 0-100 km/h : 3,6 segundos <br>
                 Velocidade máxima : 305 km/h<br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$3.335.890</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Flamborghini%2Furus2024.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/lamborghini/lamborghini-huracan-sto.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">lamborghini huracan</h2>
                <p class="text-sm text-black mt-2">
                 Motor : 5.2L V10 atmosférico <br>
                 Potência : 640 cv <br>
                 Aceleração 0-100 km/h : 2,9 segundos <br>
                 Velocidade máxima : 325 km/h<br>
                </p>


                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$1.275.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Flamborghini%2Flamborghini-huracan-sto.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
       
    </div>
</body>
</html>

