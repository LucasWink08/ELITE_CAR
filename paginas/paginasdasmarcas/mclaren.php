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
            <img src="../../assets/imagens/cars/mclaren/659scan-amspider.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">Mclaren 650s</h2>
                <p class="text-sm text-black mt-2">
                Motor : 3.8L V8 biturbo <br>
                Potência : 650 cv <br>
                Aceleração 0-100 km/h : 3,0 segundos <br>
                Velocidade máxima : 333 km/h<br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$2.750.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fmclaren%2F659scan-amspider.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/mclaren/720S-Coupe_hero_crop-16x9.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">mclaren 720s</h2>
               <p class="text-sm text-black mt-2">
               Motor : 4.0L V8 biturbo <br>
               Potência : 720 cv <br>
               Aceleração 0-100 km/h : 2,7 segundos <br>
               Velocidade máxima : 341 km/h<br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$3.335.890</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fmclaren%2F720S-Coupe_hero_crop-16x9.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/mclaren/765lt.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">Mclaren 765lt</h2>
               <p class="text-sm text-black mt-2">
               Motor : 4.0L V8 biturbo<br>
               Potência : 765 cv <br>
               Aceleração 0-100 km/h : 2,8 segundos <br>
               Velocidade máxima : 330 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$4.550.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fmclaren%2F765lt.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/mclaren/f1.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">mclaren f1</h2>
               <p class="text-sm text-black mt-2">
               Motor : 6.1L V12  <br>
               Potência : 627 cv <br>
               Aceleração 0-100 km/h : 3,2 segundos <br>
               Velocidade máxima : 391 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$20.000.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fmclaren%2Ff1.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/mclaren/McLaren_Senna_Genf_2018.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">mclaren senna </h2>
               <p class="text-sm text-black mt-2">
               Motor : 4.0L V8 biturbo <br>
               Potência : 800 cv <br>
               Aceleração 0-100 km/h : 2,8 segundos <br>
               Velocidade máxima : 335 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$11.500.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fmclaren%2FMcLaren_Senna_Genf_2018.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/mclaren/McLaren_Senna_GTR_Image_Front_Three_Quarters_crop-2x1.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">mclaren senna gtr</h2>
               <p class="text-sm text-black mt-2">
               Motor : 4.0L V8 biturbo <br>
               Potência : 825 cv <br>
               Aceleração 0-100 km/h : 2,8 segundos <br>
               Velocidade máxima : 335 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$15.000.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fmclaren%2FMcLaren_Senna_GTR_Image_Front_Three_Quarters_crop-2x1.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/mclaren/MClarneP1.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">mclaren p1</h2>
               <p class="text-sm text-black mt-2">
               Motor : 3.8L V8 biturbo + motor elétrico (híbrido) <br>
               Potência : 903 cv <br>
               Aceleração 0-100 km/h : 2,8 segundos <br>
               Velocidade máxima : 350 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$16.000.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fmclaren%2FMClarneP1.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/mclaren/p1gtr.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">mclaren p1 gtr</h2>
               <p class="text-sm text-black mt-2">
               Motor : 3.8L V8 biturbo + motor elétrico (híbrido) <br>
               Potência : 1.000 cv <br>
               Aceleração 0-100 km/h : 2,6 segundos <br>
               Velocidade máxima : 355 km/h <br>

                </p>

                <p class="text-black text-2xl gtimes -mb-2 mt-16 ">R$20.000.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fmclaren%2Fp1gtr.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/mclaren/solusgt.webp" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">Mclaren solus gt</h2>
               <p class="text-sm text-black mt-2">
               Motor : 5.2L V10 atmosférico <br>
               Potência : Aproximadamente 840 cv <br>
               Aceleração 0-100 km/h : Menos de 2,5 segundos  <br>
               Velocidade máxima : 322 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$19.990.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fmclaren%2Fsolusgt.webp" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
        <div class="luxcars-car-card max-w-sm w-64 p-4 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../../assets/imagens/cars/mclaren/speedtail.jpg" alt="Carro" class="h-40 w-full object-cover rounded-t-xl">
            <div class="p-3 text-center">
                <h2 class="font-bold text-lg text-black gtimes">mclaren speedtail</h2>
               <p class="text-sm text-black mt-2">
               Motor : 4.0L V8 biturbo + motor elétrico <br>
               Potência : 1.035 cv <br>
               Aceleração 0-100 km/h : 3,0 segundos <br>
               Velocidade máxima : 403 km/h <br>
                </p>

                <p class="text-black text-2xl gtimes -mb-4 mt-16 ">R$20.000.000</p>
            </div>
            <div class="mt-4 w-full">
                <a href="../detalhes.php?imagem=assets%2Fimagens%2Fcars%2Fmclaren%2Fspeedtail.jpg" class="block bg-red-600 text-white py-2 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
       
    </div>
</body>
</html>

