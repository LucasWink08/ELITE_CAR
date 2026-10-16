

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
<link rel="stylesheet" href="../assets/css/site.css">
</head>
</html>


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
<div class="flex items-center justify-center h-screen gtimes text-black">
  <div class="bg-white rounded-xl shadow-2xl py-20 px-14 max-w-96 opacity-60">
    <h2 class="gtimes justify-center flex items-center text-black text-3xl">FINANCIAMENTO DE CARRO</h2><br>
    <form action="" method="post" class="space-y-5" enctype="multipart/form-data">
      
      <div>
        <label for="veiculo" class="block text-black mb-1">Veículo</label>
        <input 
          type="text"
          id="veiculo"
          name="veiculo"
          placeholder="Digite o modelo do carro" 
          class="w-full shadow-xl rounded-lg px-10 py-2 border border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-300"
        >
      </div>

      <div>
        <label for="year" class="block text-black mb-1">Ano</label>
        <input 
          type="number"
          id="year"
          name="year"
          placeholder="Digite o ano do carro" 
          class="w-full shadow-xl rounded-lg px-10 py-2 border border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-300"
        >
      </div>

      <div>
        <label for="valor" class="block text-black mb-1">Valor do Veículo</label>
        <input 
          type="number"
          id="valor"
          name="valor"
          placeholder="Digite o valor do carro" 
          class="w-full shadow-xl rounded-lg px-10 py-2 border border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-300"
        >
      </div>

      <div>
        <label for="entrada" class="block text-black mb-1">Entrada</label>
        <input 
          type="number"
          id="entrada"
          name="entrada"
          placeholder="Digite o valor da entrada" 
          class="w-full shadow-xl rounded-lg px-10 py-2 border border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-300"
        >
</div>

      <div>
        <label for="parcelas" class="block text-black mb-1">Parcelas Mensais</label>
        <input 
          type="number"
          id="parcelas"
          name="parcelas"
          placeholder="Digite o valor das parcelas mensais" 
          class="w-full shadow-xl rounded-lg px-10 py-2 border border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-300"
        >
      </div>

      <div class="justify-center items-center flex ">
        <input 
          type="submit" 
          value="Simular"
          class="w-full gtimes px-6 py-4 bg-black text-white rounded-lg transition ease-in-out duration-300 cursor-pointer"
        >
      </div>
    </form>
  </div>
</div>

<div class="overflow-x-auto max-w-4xl mx-auto mt-10 mb-10 rounded-lg gtimes">
<?php
$veiculo = isset($_POST['veiculo']) ? $_POST['veiculo'] : "";
$valor = isset($_POST['valor']) ? floatval($_POST['valor']) : 0;
$entrada = isset($_POST['entrada']) ? floatval($_POST['entrada']) : 0;
$parcelas = isset($_POST['parcelas']) ? intval($_POST['parcelas']) : 0;

if(isset($_POST['parcelas'])){
echo "<p class='text-center text-5xl gtimes mb-10'>$veiculo</p>";
}
function calcjuros($parcelas) {
    if ($parcelas <= 12) {
        return 0.02; // 2% ao mês
    } elseif ($parcelas > 12 && $parcelas <= 24) {
        return 0.03; // 3% ao mês
    } elseif ($parcelas > 24 && $parcelas <= 36) {
        return 0.04; 
    } else {
        return 0; 
    }
}

$juros = calcjuros($parcelas);

$saldoDevedor = $valor - $entrada; 
$prestacaoBase = $parcelas > 0 ? $saldoDevedor / $parcelas : 0; 

if ($parcelas > 0) {
    echo "<table class='min-w-full bg-white shadow-md rounded-lg'>
        <thead>
            <tr class='bg-gray-800 text-white'>
                <th class='py-2 px-4 text-left'>Mês</th>
                <th class='py-2 px-4 text-left'>Prestação (€)</th>
                <th class='py-2 px-4 text-left'>Juros (€)</th>
                <th class='py-2 px-4 text-left'>Amortização (€)</th>
                <th class='py-2 px-4 text-left'>Saldo Devedor (€)</th>
            </tr>
        </thead>
        <tbody>";
    
    for ($i = 1; $i <= $parcelas; $i++) {
      
        $valorJuros = $saldoDevedor * $juros;
        $prestacao = $prestacaoBase + $valorJuros;
        $amortizacao = $prestacaoBase;
        $saldoDevedor -= $amortizacao;

   
        echo "<tr class='border-b'>
            <td class='py-2 px-4 text-black'>$i</td>
            <td class='py-2 px-4 text-black'>" . number_format($prestacao, 2, ',', '.') . "</td>
            <td class='py-2 px-4 text-black'>" . number_format($valorJuros, 2, ',', '.') . "</td>
            <td class='py-2 px-4 text-black'>" . number_format($amortizacao, 2, ',', '.') . "</td>
            <td class='py-2 px-4 text-black'>" . number_format($saldoDevedor, 2, ',', '.') . "</td>
        </tr>";
    }

    echo "</tbody></table>";
} else {
    echo "Número de parcelas inválido.";
}
?>

</body>
</html>
