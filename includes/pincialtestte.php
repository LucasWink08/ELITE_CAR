<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/carrosel.css">
   <style>
    @font-face {
        font-family: 'gtimes';
        src: url(../assets/fontes/good_times/Good\ Times\ Rg.otf);
        font-weight: bold;
        font-style: normal;
    }
    .gtimes{
        font-family: 'gtimes', Arial, Helvetica, sans-serif;
    }
    @font-face {
        font-family: 'luxo';
        src: url(../assets/fontes/luxoorea/Luxoorea.ttf);
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
</head>
<body class="bg-gradient-to-t from-black to-gray-900 text-white min-h-screen">
    <div class="bg-black p-3">
        <div class="flex justify-between items-center">
            <div class="w">
            <ul>
                <li id="luxo" class="text-2xl text- text-white tracking-wider">
                    <h1>LXC</h1>
                </li>
             </ul>
             </div>
            <div class="hidden md:block">
                <ul class="flex space-x-5 text-white">
                    <li class="gtimes"><p class="hover-effect"><a href="../paginas/paginadeecompra.php" class="hover:text-yellow-500 transition duration-150 ease-in-out">COMPRAR</a></p></li>
                    <li class="gtimes"><p class="hover-effect"><a href="../paginas/anunciar.html" class="hover:text-yellow-500">ANUNCIAR</a></p></li>
                    <li class="gtimes"><p class="hover-effect"><a href="../paginas/contato.html" class="hover:text-yellow-500">CONTATO</a></p></li>
                </ul>
            </div>
    
            <div>
                <ul class="flex items-center space-x-1">
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EA3323"><path d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm246-164q-59 0-99.5-40.5T340-580q0-59 40.5-99.5T480-720q59 0 99.5 40.5T620-580q0 59-40.5 99.5T480-440Zm0 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q53 0 100-15.5t86-44.5q-39-29-86-44.5T480-280q-53 0-100 15.5T294-220q39 29 86 44.5T480-160Zm0-360q26 0 43-17t17-43q0-26-17-43t-43-17q-26 0-43 17t-17 43q0 26 17 43t43 17Zm0-60Zm0 360Z"/></svg>
                    </li>
                    <li class="gtimes">
                        <p class="hover-effectt"><p class="text-white hover:text-yellow-500"><?php
                        
                       
                              
                        ?></p></p>
                    </li>     
                </ul>
            </div>
        </div>
    </div>
    <div class="corpo">
        <div class="slider">
            <div class="slides">
                <div class="slide">
                    <img src="../assets/imagens/carrosel/ferrari.jpg" alt="Ferrari">
                </div>
                <div class="slide">
                    <img src="../assets/imagens/carrosel/koenisseg.jpg" alt="Koenigsegg">
                </div>
                <div class="slide">
                    <img src="../assets/imagens/carrosel/mclarne sena.jpg" alt="McLaren Senna">
                </div>
                <div class="slide">
                    <img src="../assets/imagens/carrosel/mercedes.jpg" alt="Mercedes">
                </div>
            </div>
        </div>
    </div>

    <script>
        
        let currentIndex = 0;
        const slides = document.querySelector('.slides');
        const totalSlides = slides.children.length;

        setInterval(() => {
            currentIndex = (currentIndex + 1) % totalSlides;
            slides.style.marginLeft = `-${currentIndex * 100}%`;
        }, 2500); 
    </script> <br><br>

<div class="flex space-x-9 items-center justify-center -">

<a href="./carrousel.php">
  <div
    class="w-40 h-40 bg-white rounded-full flex items-center justify-center overflow-hidden hover:scale-110 transition-shadow transition-transform duration-500">
    <img src="../assets/imagens/logos/bmww (1).png" alt="Logo BMW" class="object-contain">
  </div>
</a>

<a href="./carrousel.php">
  <div
    class="w-40 h-40 bg-white rounded-full flex items-center justify-center overflow-hidden hover:scale-110 transition-shadow transition-transform duration-500">
    <img src="../assets/imagens/logos/ferrarir (3).png" alt="Logo Ferrari" class="object-contain">
  </div>
</a>

<a href="./carrousel.php">
  <div
    class="w-40 h-40 bg-white rounded-full flex items-center justify-center overflow-hidden hover:scale-110 transition-shadow transition-transform duration-500">
    <img src="../assets/imagens/logos/mclaren (1).png" alt="Logo McLaren" class="object-contain">
  </div>
</a>

<a href="./carrousel.php">
  <div
    class="w-40 h-40 bg-white rounded-full flex items-center justify-center overflow-hidden hover:scale-110 transition-shadow transition-transform duration-500">
    <img src="../assets/imagens/logos/logo-lamborghini-1024 (1).png" alt="Logo Lamborghini" class="object-contain translate-y-1">
  </div>
</a>

<a href="./carrousel.php">
  <div
    class="w-40 h-40 bg-white rounded-full flex items-center justify-center overflow-hidden hover:scale-110 transition-shadow transition-transform duration-500">
    <img src="../assets/imagens/logos/mercedess (1).png" alt="Logo Mercedes" class="object-contain">
  </div>
</a>

<a href="./carrousel.php">
  <div
    class="w-40 h-40 bg-white rounded-full flex items-center justify-center overflow-hidden hover:scale-110 transition-shadow transition-transform duration-500">
    <img src="../assets/imagens/logos/audi.png" alt="Logo Audi" class="object-contain">
  </div>
</a>

<a href="./carrousel.php">
  <div
    class="w-40 h-40 bg-white rounded-full flex items-center justify-center overflow-hidden hover:scale-110 transition-shadow transition-transform duration-500">
    <img src="../assets/imagens/logos/koenisssge.png" alt="Logo Koenigsegg" class="object-contain">
  </div>
</a>

<a href="./carrousel.php">
  <div
    class="w-40 h-40 bg-white rounded-full flex items-center justify-center overflow-hidden hover:scale-110 transition-shadow transition-transform duration-500">
    <img src="../assets/imagens/logos/porsche (1).png" alt="Logo Porsche" class="object-contain">
  </div>
</a>

<a href="./carrousel.php">
  <div
    class="w-40 h-40 bg-white rounded-full flex items-center justify-center overflow-hidden hover:scale-110 transition-shadow transition-transform duration-500">
    <img src="../assets/imagens/logos/bugatti (1).png" alt="Logo Bugatti" class="object-contain">
  </div>
</a>
</div>


<div class="container mx-auto -mt-20">
    <!-- Título geral -->
    <div class="text-center mb-8">

    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-8 items-center justify-center min-h-screen">
        <!-- Card 1 -->
        <div class="w-60 p-2 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../assets/imagens/carrosel/mercedes.jpg" alt="" class="h-40 object-cover rounded-xl">
            <div class="p-2 text-center">
                <h2 class="font-bold text-lg text-black gtimes">Nome do Carro</h2>
                <p class="text-sm text-black mt-2">
                    Ex pariatur consequuntur sed aliquam harum deleniti nobis. Accusantium, obcaecati explicabo!
                </p>
            </div>
            <div class="mt-4 w-full">
                <a href="#" class="block bg-red-600 text-white py-3 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-lg text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="w-60 p-2 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../assets/imagens/carrosel/mercedes.jpg" alt="" class="h-40 object-cover rounded-xl">
            <div class="p-2 text-center">
                <h2 class="font-bold text-lg text-black gtimes">Nome do Carro</h2>
                <p class="text-sm text-black mt-2">
                    Ex pariatur consequuntur sed aliquam harum deleniti nobis. Accusantium, obcaecati explicabo!
                </p>
            </div>
            <div class="mt-4 w-full">
                <a href="#" class="block bg-red-600 text-white py-3 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-lg text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="w-60 p-2 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../assets/imagens/carrosel/mercedes.jpg" alt="" class="h-40 object-cover rounded-xl">
            <div class="p-2 text-center">
                <h2 class="font-bold text-lg text-black gtimes">Nome do Carro</h2>
                <p class="text-sm text-black mt-2">
                    Ex pariatur consequuntur sed aliquam harum deleniti nobis. Accusantium, obcaecati explicabo!
                </p>
            </div>
            <div class="mt-4 w-full">
                <a href="#" class="block bg-red-600 text-white py-3 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-lg text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="w-60 p-2 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../assets/imagens/carrosel/mercedes.jpg" alt="" class="h-40 object-cover rounded-xl">
            <div class="p-2 text-center">
                <h2 class="font-bold text-lg text-black gtimes">Nome do Carro</h2>
                <p class="text-sm text-black mt-2">
                    Ex pariatur consequuntur sed aliquam harum deleniti nobis. Accusantium, obcaecati explicabo!
                </p>
            </div>
            <div class="mt-4 w-full">
                <a href="#" class="block bg-red-600 text-white py-3 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-lg text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>

        <!-- Card 5 -->
        <div class="w-60 p-2 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../assets/imagens/carrosel/mercedes.jpg" alt="" class="h-40 object-cover rounded-xl">
            <div class="p-2 text-center">
                <h2 class="font-bold text-lg text-black gtimes">Nome do Carro</h2>
                <p class="text-sm text-black mt-2">
                    Ex pariatur consequuntur sed aliquam harum deleniti nobis. Accusantium, obcaecati explicabo!
                </p>
            </div>
            <div class="mt-4 w-full">
                <a href="#" class="block bg-red-600 text-white py-3 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-lg text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>

        <!-- Card 6 -->
        <div class="w-60 p-2 rounded-xl bg-white shadow-lg flex flex-col items-center">
            <img src="../assets/imagens/carrosel/mercedes.jpg" alt="" class="h-40 object-cover rounded-xl">
            <div class="p-2 text-center">
                <h2 class="font-bold text-lg text-black gtimes">Nome do Carro</h2>
                <p class="text-sm text-black mt-2">
                    Ex pariatur consequuntur sed aliquam harum deleniti nobis. Accusantium, obcaecati explicabo!
                </p>
            </div>
            <div class="mt-4 w-full">
                <a href="#" class="block bg-red-600 text-white py-3 rounded-md font-semibold hover:bg-red-500 focus:scale-95 transition-all duration-250 ease-out shadow-md text-lg text-center gtimes">
                    Ver Mais
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>

