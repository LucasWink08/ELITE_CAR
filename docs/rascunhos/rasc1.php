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
                    <input type="text" placeholder="" class="w-full shadow-xl rounded-lg px-10 py-2 border border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-300" readonly value="<?php echo isset($indice) ? $indice . '%' : ''; ?>">
                </div>
            </form>
        </div>
    </div>