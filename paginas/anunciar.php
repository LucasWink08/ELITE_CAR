<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/bootstrap.php';
\LuxCars\Core\Autenticacao::exigirLogin();
?>
<body style="background-image: url(../assets/imagens/cars/ferrari/fenuncio.jpg);" class="bg-cover bg-center h-screen w-screen">

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
<link rel="stylesheet" href="../assets/css/site.css">
</head>
</html>
<body style="background-image: url(../assets/imagens/cars/koenigsegg/koenigsegg.webp);" class="bg-cover bg-center h-screen w-screen">

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
   
</style>
<script src="https://cdn.tailwindcss.com"></script>
<body class="bg-gradient-to-t from-black to-gray-900 text-white min-h-screen">
<?php require_once __DIR__ . '/../includes/navbar.php'; ?>

<div class="flex items-center justify-center h-screen">
  <div class="bg-white rounded-xl shadow-2xl py-18 px-14 max-w-96 opacity-80">
    <h2 class="gtimes justify-center flex items-center text-black text-3xl">CRIAR ANÚNCIO</h2><br>
    <form action="" method="post" class="space-y-4" enctype="multipart/form-data">
      
      
    <div class="relative">
  <label for="image" class="block text-black mb-2 font-semibold">Imagem do Carro</label>
  <input 
    type="file"
    id="image"
    name="image"
    class="w-full opacity-0 absolute top-0 left-0 h-full cursor-pointer"
    
  >
  <div class="w-full bg-gray-100 p-4 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-between cursor-pointer">
    <span id="fileName" class="text-gray-700">Selecione uma imagem...</span>
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l4-4m0 0l4 4m-4-4v12"></path>
    </svg>
  </div>
</div>

      
      <div>
        <label for="descricao" class="block text-black mb-1">Descrição</label>
        <textarea 
          id="descricao"
          name="descricao"
          rows="4"
          placeholder="Digite uma breve descrição do carro" 
          class="w-full shadow-xl rounded-lg px-10 py-2 border border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-300"
        ></textarea>
      </div>

      
      <div>
        <label for="ano" class="block text-black mb-1">Ano</label>
        <input 
          type="number"
          id="ano"
          name="ano"
          placeholder="Digite o ano do carro" 
          class="w-full shadow-xl rounded-lg px-10 py-2 border border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-300"
        >
      </div>

      
      <div>
        <label for="modelo" class="block text-black mb-1">Modelo</label>
        <input 
          type="text"
          id="modelo"
          name="modelo"
          placeholder="Digite o modelo do carro" 
          class="w-full shadow-xl rounded-lg px-10 py-2 border border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-300"
        >
      </div>

     
      <div>
        <label for="fuel" class="block text-black mb-1">Combustível</label>
        <select 
          id="fuel"
          name="fuel"
          class="w-full shadow-xl rounded-lg px-10 py-2 border border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-300"
        >
          <option value="gasoline">Gasolina</option>
          <option value="ethanol">Álcool</option>
          <option value="diesel">Diesel</option>
          <option value="electric">Elétrico</option>
        </select>
      </div>

      
      <div>
        <label for="power" class="block text-black mb-1">Potência (em CV)</label>
        <input 
          type="number"
          id="power"
          name="power"
          placeholder="Digite a potência do carro (em CV)" 
          class="w-full shadow-xl rounded-lg px-10 py-2 border border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-300"
        >
      </div>

      
      <div class="justify-center items-center flex">
        <input 
          type="submit" 
          value="Criar Anúncio"
          class="w-full gtimes px-6 py-2 bg-black text-white rounded-lg transition ease-in-out duration-300 cursor-pointer"
        >
      </div>
    </form>
    
  </div>
</div>
</body>
</html>
