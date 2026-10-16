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
            <img src="../../assets/imagens/cars/bmw/bmw i8.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">BMW i8 motor híbrido</h2>
                <p class="text-sm text-black mt-2">
                Motor: Híbrido <br>
                Potência: 362 cv <br>
                Aceleração 0-100 km/h: 4,4 segundos <br>
                Velocidade máxima: 250 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$ 1.100.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fbmw%2Fbmw%20i8.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/bmw/2020-bmw-x6-m-competition-1.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">BMW x6 competition</h2>
                <p class="text-sm text-black mt-2">
                Motor : V8 biturbo de 4,4 litros <br>
                Potência : 617 cv <br>
                Aceleração 0-100 km/h : 3,8 segundos <br>
                Velocidade máxima : 250 km/h (limitada eletronicamente) <br>
                </p> 

                <p class="text-black text-2xl gtimes -mb-4 mt-12 ">R$630.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fbmw%2F2020-bmw-x6-m-competition-1.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/bmw/BMW M5 CS.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">bmw m5 cs v8 biturbo</h2>
                <p class="text-sm text-black mt-2">
                   Motor:V8 biturbo de 4,4 litros <br>
                   Potência : 635 cv <br>
                   Aceleração 0-100 km/h : 3,0 segundos <br>
                   Velocidade máxima : 305 km/h (limitada eletronicamente) <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-12 ">R$900.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fbmw%2FBMW%20M5%20CS.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/bmw/bmw-i7-m70.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">bmw i7 m70 xdrive </h2>
                <p class="text-sm text-black mt-2">
                Motor : Elétrico <br>
                Potência:660 cv <br>
                Aceleração 0-100 km/h : 3,7 segundos <br>
                Velocidade máxima : 250 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$1.350.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fbmw%2Fbmw-i7-m70.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/bmw/BMW-X4-M40i-Individual_1.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">bmw x4 m40i</h2>
                <p class="text-sm text-black mt-2">
                Motor : 3.0L turboalimentado I6 <br>
                Potência : 382 cv <br>
                Aceleração 0-100 km/h : 4,4 segundos <br>
                Velocidade máxima : 250 km/h (limitada eletronicamente) <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-2 mt-16 ">R$ 500.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fbmw%2FBMW-X4-M40i-Individual_1.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/bmw/BMWM3G80CS.png" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">BMW m3 g80cs</h2>
                <p class="text-sm text-black mt-2">
                Motor : 3.0L turboalimentado I6 <br> 
                Potência : 543 cv <br>
                Aceleração 0-100 km/h : 3,4 segundos <br>
                Velocidade máxima : 302 km/h (limitada eletronicamente) <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-12 ">R$950.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fbmw%2FBMWM3G80CS.png" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/bmw/bmwm8grancoupe.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">bmw m8 gran coupe</h2>
                <p class="text-sm text-black mt-2">
                Motor : 4.4L V8 biturbo <br>
                Potência : 617 cv <br>
                Aceleração 0-100 km/h : 3,1 segundos <br>
                Velocidade máxima : 250 km/h (limitada eletronicamente) <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$1.150.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fbmw%2Fbmwm8grancoupe.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/bmw/m4competition.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">bmw m4</h2>
                <p class="text-sm text-black mt-2">
                Motor : 3.0L turboalimentado I6 <br>
                Potência : 473 cv <br>
                Aceleração 0-100 km/h : 4,1 segundos <br>
                Velocidade máxima : 250 km/h  <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$630.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fbmw%2Fm4competition.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/bmw/M4gts.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">bmw m4 gts </h2>
                <p class="text-sm text-black mt-2">
                Motor : 3.0L turboalimentado I6 <br>
                Potência : 493 cv <br>
                Aceleração 0-100 km/h : 3,7 segundos <br>
                Velocidade máxima : 305 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$1.100.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fbmw%2FM4gts.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/bmw/G90 BMW M5 saloon-13.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">bmw m5 </h2>
                <p class="text-sm text-black mt-2">
                Motor : 4.4L V8 biturbo <br>
                Potência : 625 cv <br>
                Aceleração 0-100 km/h : 3,3 segundos <br>
                Velocidade máxima : 250 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$920.990</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fbmw%2FG90%20BMW%20M5%20saloon-13.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
       
    </div>
</body>
</html>

