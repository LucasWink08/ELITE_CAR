<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @font-face {
            font-family: 'gtimes';
            src: url(../assets/fontes/good_times/Good\ Times\ Rg.otf);
            font-weight: bold;
            font-style: normal;
        }
        .gtimes {
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
<?php

if(!isset(($_POST['precoatual']))){
    header('location');
}

$preconicial = 0; 
if (isset($_POST['preconicial'])) {
    $preconicial = $_POST['preconicial'];
}

$precoatual = 0; 
if (isset($_POST['precoatual'])) {
    $precoatual = $_POST['precoatual'];
}

if (isset($_POST['preconicial'])) {
    function calcdesval($preconicial, $precoatual) {
        if ($precoatual != 0) {
            $desval = (($preconicial - $precoatual) / $preconicial * 100);     
        }
        return $desval;
    }

    $dsvl = calcdesval($preconicial, $precoatual);

}
?>



<link rel="stylesheet" href="../assets/css/site.css">
</head>
<script src="https://cdn.tailwindcss.com"></script>
<body class="bg-gradient-to-t from-black to-gray-900 text-white min-h-screen">
    <?php require_once __DIR__ . '/../includes/navbar.php'; ?>
    <div class="flex items-center justify-center h-screen gtimes text-black">
        <div class="bg-white rounded-xl shadow-2xl py-20 px-14 max-w-96 opacity-80">
            <h2 class="gtimes justify-center flex items-center text-black text-3xl">CÁLCULO DE DESVALORIZAÇÃO DE VEÍCULO</h2>
            <br>
            <form action="" method="post" class="space-y-6" enctype="multipart/form-data">
                <div>
                    <label for="vehicle" class="block text-black mb-1">Veículo</label>
                    <input type="text" id="vehicle" name="vehicle" placeholder="Digite o modelo do carro" class="w-full shadow-xl rounded-lg px-10 py-2 border border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-300">
                </div>
                <div>
                    <label for="year" class="block text-black mb-1">Ano de Fabricação</label>
                    <input type="number" id="year" name="year" placeholder="Digite o ano do carro" class="w-full shadow-xl rounded-lg px-10 py-2 border border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-300">
                </div>
                <div>
                    <label for="preconicial" class="block text-black mb-1">Preço Inicial</label>
                    <input type="number" id="preconicial" name="preconicial" placeholder="Digite o preço inicial do veículo" class="w-full shadow-xl rounded-lg px-10 py-2 border border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-300">
                </div>
                <div>
                    <label for="precoatual" class="block text-black mb-1">Preço Atual</label>
                    <input type="number" id="precoatual" name="precoatual" placeholder="Digite o preço atual do veículo" class="w-full shadow-xl rounded-lg px-10 py-2 border border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-300">
                </div>
                <div class="justify-center items-center flex">
                    <input type="submit" value="Calcular" class="w-full gtimes px-6 py-2 bg-black text-white rounded-lg transition ease-in-out duration-300 cursor-pointer">
                </div>
                <div>
                    <label for="accidents" class="block text-black mb-1">Índice de desvalorização</label>
                    <input type="text" 
                           id="accidents" 
                           placeholder="Índice de desvalorização" 
                           class="w-full shadow-xl rounded-lg px-10 py-2 border border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-300" 
                           readonly 
                         value="<?php 
                           if(isset($_POST['precoatual'])){
                         echo $dsvl; echo "%"; 
                           }
                         ?>">
                           
                </div>
            </form>     
        </div>
    </div>
</body>
</html>
