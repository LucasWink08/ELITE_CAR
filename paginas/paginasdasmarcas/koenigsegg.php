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
            <img src="../../assets/imagens/cars/koenigsegg/agera.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">koenigsegg agera "odin"</h2>
                  <p class="text-sm text-black mt-2">
                  Motor : 5.0L V8 biturbo <br>
                  Potência : De 1.000 cv <br>
                  Aceleração 0-100 km/h : Aproximadamente 2,8 segundos<br>
                  Velocidade máxima : Acima de 450 km/h<br>
                </p>
                   <p class="text-black text-2xl gtimes -mb-4 mt-8 ">R$12.766.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fkoenigsegg%2Fagera.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/koenigsegg/CC850.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">koenigsegg CC850</h2>
                 <p class="text-sm text-black mt-2">
                 Motor : 5.0L V8 biturbo <br>
                 Potência : 1.185 cv <br>
                 Aceleração 0-100 km/h : Aproximadamente 2,8 segundos<br>
                 Velocidade máxima : Acima de 400 km/h
                </p>
                   <p class="text-black text-2xl gtimes -mb-4 mt-16"> R$15.890.900</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fkoenigsegg%2FCC850.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/koenigsegg/ccx.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">koenigsegg ccx</h2>
                 <p class="text-sm text-black mt-2">
                 Motor : 4.7L V8 biturbo <br>
                 Potência : 806 cv <br>
                 Aceleração 0-100 km/h : Aproximadamente 3,2 segundos <br>
                 Velocidade máxima : Acima de 400 km/h<br>
                </p>
                   <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$6.000.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fkoenigsegg%2Fccx.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/destaques/golden.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">koenigsegg jesko "golden"</h2>
                 <p class="text-sm text-black mt-2">
                 Motor : 5.0L V8 biturbo <br>
                 Potência : Até 1.600 cv <br>
                 Aceleração 0-100 km/h : Aproximadamente 2,5 segundos<br>
                 Velocidade máxima : Acima de 480 km/h<br>
                </p>
                   <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$14.340.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fdestaques%2Fgolden.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/koenigsegg/Jesko+Odin+Front.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">koenigsegg jesko odin </h2>
                <p class="text-sm text-black mt-2">
                 Motor : 5.0L V8 biturbo <br>
                 Potência : Até 1.600 cv <br>
                 Aceleração 0-100 km/h : Aproximadamente 2,5 segundos<br>
                 Velocidade máxima : Acima de 430 km/h<br>
                </p>
                   <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$17.000.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fkoenigsegg%2FJesko%2BOdin%2BFront.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/koenigsegg/one1.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">koenigsegg one 1</h2>
                 <p class="text-sm text-black mt-2">
                 Motor : 5.0L V8 biturbo <br>
                 Potência : 1.341 cv <br>
                 Aceleração 0-100 km/h : Aproximadamente 2,8 segundos <br>
                 Velocidade máxima : Aproximadamente 450 km/h<br>
                </p>
                   <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$13.000.990</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fkoenigsegg%2Fone1.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/koenigsegg/ragera.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">koenigsegg ragera</h2>
                 <p class="text-sm text-black mt-2">
                 Motor : 5.0L V8 biturbo + 3 motores elétricos <br>
                 Potência : 1.500 cv <br>
                 Aceleração 0-100 km/h : Aproximadamente 2,8 segundos <br>
                 Velocidade máxima : Acima de 400 km/h<br>
                </p>
                   <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$18.000.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fkoenigsegg%2Fragera.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/koenigsegg/ageraR.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">koenigsegg agera R</h2>
                 <p class="text-sm text-black mt-2">
                 Motor : 5.0L V8 biturbo <br>
                 Potência : 1.160 cv <br>
                 Aceleração 0-100 km/h : Aproximadamente 2,8 segundos <br>
                 Velocidade máxima : Aproximadamente 440 km/h<br>
                </p>
                   <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$17.000.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fkoenigsegg%2FageraR.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/koenigsegg/Koenigsegg_Jesko_Genf_2019_1Y7A5546.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">koenigsegg jesko</h2>
                <p class="text-sm text-black mt-2">
                 Motor : 5.0L V8 biturbo <br>
                 Potência : Até 1.600 cv <br>
                 Aceleração 0-100 km/h : Aproximadamente 2,5 segundos<br>
                 Velocidade máxima : Acima de 430 km/h<br>
                </p>
                   <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$19.990.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fkoenigsegg%2FKoenigsegg_Jesko_Genf_2019_1Y7A5546.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="elite-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/koenigsegg/jeskoabsolut.png" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">koenigsegg jesko absolut</h2>
                <p class="text-sm text-black mt-2">
                 Motor : 5.0L V8 biturbo <br>
                 Potência : Até 1.600 cv <br>
                 Aceleração 0-100 km/h : Aproximadamente 2,5 segundos<br>
                 Velocidade máxima : Acima de 480 km/h<br>
                </p>
                   <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$20.000.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fkoenigsegg%2Fjeskoabsolut.png" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
       
    </div>
</body>
</html>

