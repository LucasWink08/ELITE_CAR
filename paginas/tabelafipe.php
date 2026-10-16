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
<link rel="stylesheet" href="../assets/css/site.css">
<body class="bg-gradient-to-t from-black to-gray-900 text-white min-h-screen">
<?php require_once __DIR__ . '/../includes/navbar.php'; ?>
    <div class="overflow-x-auto max-w-4xl mx-auto mt-10 mb-10 rounded-lg gtimes">
        <table class="min-w-full bg-white shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-800 text-white">
                    <th class="py-2 px-4 text-left">Marca</th>
                    <th class="py-2 px-4 text-left">Modelo</th>
                    <th class="py-2 px-4 text-left">Preço (R$)</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">Ferrari</td>
                    <td class="py-2 px-4 text-black">296 "GTB"</td>
                    <td class="py-2 px-4 text-black">R$ 3.200.000</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">Ferrari</td>
                    <td class="py-2 px-4 text-black">458 Italia</td>
                    <td class="py-2 px-4 text-black">R$ 1.500.000</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">Ferrari</td>
                    <td class="py-2 px-4 text-black">488 "GTB"</td>
                    <td class="py-2 px-4 text-black">R$ 1.800.000</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">Ferrari</td>
                    <td class="py-2 px-4 text-black">488 Pista</td>
                    <td class="py-2 px-4 text-black">R$ 2.500.000</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">Ferrari</td>
                    <td class="py-2 px-4 text-black">F40</td>
                    <td class="py-2 px-4 text-black">R$ 5.000.000</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">Ferrari</td>
                    <td class="py-2 px-4 text-black">F8 Spider</td>
                    <td class="py-2 px-4 text-black">R$ 1.900.000</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">Ferrari</td>
                    <td class="py-2 px-4 text-black">FXXK Evo</td>
                    <td class="py-2 px-4 text-black">R$ 13.000.000</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">Ferrari</td>
                    <td class="py-2 px-4 text-black"> la Ferrari</td>
                    <td class="py-2 px-4 text-black">R$ 12.000.000</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">Ferrari</td>
                    <td class="py-2 px-4 text-black">Puro Sangue</td>
                    <td class="py-2 px-4 text-black">R$ 7.500.000</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">Ferrari</td>
                    <td class="py-2 px-4 text-black">SF90</td>
                    <td class="py-2 px-4 text-black">R$ 6.200.000</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">Koenigsegg</td>
                    <td class="py-2 px-4 text-black">Agera Odin</td>
                    <td class="py-2 px-4 text-black">R$ 20.000.000</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">Koenigsegg</td>
                    <td class="py-2 px-4 text-black">Agera</td>
                    <td class="py-2 px-4 text-black">R$ 15.000.000</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">Koenigsegg</td>
                    <td class="py-2 px-4 text-black">CC850</td>
                    <td class="py-2 px-4 text-black">R$ 11.000.000</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">Koenigsegg</td>
                    <td class="py-2 px-4 text-black">CCX</td>
                    <td class="py-2 px-4 text-black">R$ 8.500.000</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">Koenigsegg</td>
                    <td class="py-2 px-4 text-black">Jesko</td>
                    <td class="py-2 px-4 text-black">R$ 16.000.000</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">Koenigsegg</td>
                    <td class="py-2 px-4 text-black">Jesko Absolut</td>
                    <td class="py-2 px-4 text-black">R$ 18.000.000</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">Koenigsegg</td>
                    <td class="py-2 px-4 text-black">"One:1"</td>
                    <td class="py-2 px-4 text-black">R$ 15.500.000</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">McLaren</td>
                    <td class="py-2 px-4 text-black">650S</td>
                    <td class="py-2 px-4 text-black">R$ 2.800.000</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">McLaren</td>
                    <td class="py-2 px-4 text-black">720S</td>
                    <td class="py-2 px-4 text-black">R$ 3.000.000</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">McLaren</td>
                    <td class="py-2 px-4 text-black">765LT</td>
                    <td class="py-2 px-4 text-black">R$ 3.500.000</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">McLaren</td>
                    <td class="py-2 px-4 text-black">F1</td>
                    <td class="py-2 px-4 text-black">R$ 20.000.000</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">McLaren</td>
                    <td class="py-2 px-4 text-black">P1</td>
                    <td class="py-2 px-4 text-black">R$ 10.500.000</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">McLaren</td>
                    <td class="py-2 px-4 text-black">P1 GTR</td>
                    <td class="py-2 px-4 text-black">R$ 12.000.000</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">McLaren</td>
                    <td class="py-2 px-4 text-black">Senna</td>
                    <td class="py-2 px-4 text-black">R$ 7.500.000</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">McLaren</td>
                    <td class="py-2 px-4 text-black">Senna GTR</td>
                    <td class="py-2 px-4 text-black">R$ 9.000.000</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">McLaren</td>
                    <td class="py-2 px-4 text-black">Speedtail</td>
                    <td class="py-2 px-4 text-black">R$ 15.000.000</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 text-black">McLaren</td>
                    <td class="py-2 px-4 text-black">Solus GT</td>
                    <td class="py-2 px-4 text-black">R$ 8.000.000</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>

</body>
</html>
