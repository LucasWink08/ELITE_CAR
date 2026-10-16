<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrossel Simplificado</title>
    <link rel="stylesheet" href="../assets/css/carrosel.css">

</head>
<body>
    
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
    </script>
</body>
</html>
