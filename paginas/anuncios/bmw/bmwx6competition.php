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
        src: url(../../../assets/fontes/good_times/Good\ Times\ Rg.otf);
        font-weight: bold;
        font-style: normal;
    }
    .gtimes{
        font-family: 'gtimes', Arial, Helvetica, sans-serif;
    }
    @font-face {
        font-family: 'luxo';
        src: url(../../../assets/fontes/luxoorea/Luxoorea.otf);
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
<link rel="stylesheet" href="../../../assets/css/site.css">
</head>
<body class="bg-gradient-to-t from-black to-gray-700 text-white min-h-screen">
<?php require_once __DIR__ . '/../../../includes/navbar.php'; ?>
  <div class="justify between w-screen flex h-[500px] gap-x-2">
    <div class="justify-left w-[33%] h-full">
       <img src="../../../assets/imagens/cars/imgsanuncios/bmw/bmwx6competition/bmw-x-series-x6-m60i-gallery-image-impressions-02_890.jpg" alt="" class="w-full h-full object-cover">
    </div>
    <div class="justify-center w-[34%]  h-full">
      <img src="../../../assets/imagens/cars/imgsanuncios/bmw/bmwx6competition/bmw-x6-m-competition-graphite-1.jpg" alt="" class="w-full h-full object-cover">
    </div>
    <div class="justify-right w-[33%]  h-full">
      <img src="../../../assets/imagens/cars/imgsanuncios/bmw/bmwx6competition/BMW-.jpg" alt="" class="w-full h-full object-cover">
    </div>
  </div>



  <div class="flex justify-between mt-10 px-10">
 
  <div class="w-[45%] py-10 opacity-90 text-black">
    <div class="flex items-center justify-center h-full">
      <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full opacity-80">
        <div class="h-full">
          <p class="text-center text-black text-4xl font-bold mb-6 gtimes">bmw x6 competition</p>
          <div class="space-y-4 text-2xl text-black gtimes">
            <p><strong class="text-gray-600">Ano:</strong> 2023/2024</p>
            <p><strong class="text-gray-600">Cidade:</strong> itajai</p>
            <p><strong class="text-gray-600">Combustível:</strong> Gasolina</p>
            <p><strong class="text-gray-600">KM:</strong> 500km rodados</p>
            <p><strong class="text-gray-600">Potência:</strong> 617 CV</p>
            <p><strong class="text-gray-600">Motor:</strong> V8 Biturbo 4.4 Litros</p>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="w-[50%] py-10 px-15 gtimes opacity-90 text-black">
  <div class="flex items-center justify-center h-full">
    <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full opacity-80">
      <h2 class="text-center text-black text-4xl font-bold mb-6">R$630.000</h2>
      
      <form action="" method="post" class="space-y-6">

        <div>
          <label for="name" class="block text-black text-sm font-medium mb-2">Nome completo</label>
          <input 
            type="text" 
            id="name" 
            name="name" 
            placeholder="Digite seu nome completo" 
            class="w-full shadow-lg rounded-lg px-4 py-2 border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300"
          >
        </div>

        <div>
          <label for="email" class="block text-black text-sm font-medium mb-2">E-mail</label>
          <input 
            type="email" 
            id="email" 
            name="email" 
            placeholder="Digite seu e-mail" 
            class="w-full shadow-lg rounded-lg px-4 py-2 border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300"
          >
        </div>

        <div>
          <label for="phone" class="block text-black text-sm font-medium mb-2">Telefone</label>
          <input 
            type="text" 
            id="phone" 
            name="phone" 
            placeholder="Digite seu telefone" 
            class="w-full shadow-lg rounded-lg px-4 py-2 border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300"
          >
        </div>

        <div>
          <label for="cpf" class="block text-black text-sm font-medium mb-2">CPF</label>
          <input 
            type="text" 
            id="cpf" 
            name="cpf" 
            placeholder="Digite seu CPF" 
            class="w-full shadow-lg rounded-lg px-4 py-2 border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300"
          >
        </div>

        <div class="flex justify-between space-x-4">
          <input 
            type="submit" 
            value="Entrar em Contato" 
            class="flex-grow px-6 py-2 bg-black text-white rounded-lg shadow-md hover:bg-gray-800 cursor-pointer transition ease-in-out duration-300"
          >
          <a href="../../financiamento.php">
          <button 
            type="button" 
            class="flex-grow px-2 py-1 bg-black text-white rounded-lg shadow-md hover:bg-gray-800 cursor-pointer transition ease-in-out duration-300"
          >
           ver parcelas
          </button>
          </a>
        </div>
      </form>
    </div>
  </div>
</div>






</body>
</html>
