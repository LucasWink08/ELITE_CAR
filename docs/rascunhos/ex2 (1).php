<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
        $num = 0;
        if(isset($_POST['num']))
            $num = $_POST['num'];
        $nome = "";
        if(isset($_POST['nome']))
            $nome = $_POST['nome']; 
        /*echo $num;
        echo $nome;*/
    ?>
</head>
<body>
    <form action="" method="post">
        Número da camiseta: <input type="text" value="<?php echo $num ?>" name="num" id=""><br>
        Nome do jogador: <input type="text" value="<?php echo $nome ?>" name="nome" id=""><br>
        <input type="submit" value="Enviar">
    </form>
    <?php
        if($num == 1 && strtolower($nome) == "weverton pereira"){
            echo "Goleiro"; 
        }
        if($num == 2 && strtolower($nome) == "zeca"){
            echo "Lateral";
        }
        if($num == 3 && strtolower($nome) == "rodrigo caio"){
            echo "Lateral";
        }
        if($num == 4 && strtolower($nome) == "marquinhos"){
            echo "Zagueiro";
        }
        if($num == 5 && strtolower($nome) == "renato augusto"){
            echo "Volante";
        }
        if($num == 6 && $nome == "Douglas Santos"){
            echo "Volante";
        }
        if($num == 7 && $nome == "Luan"){
            echo "Meio campo";
        }
        if($num == 8 && $nome == "Wallace"){
            echo "Meio campo";
        }
        if($num == 9 && $nome == "Gabriel Barbosa"){
            echo "Atacante";
        }
        if($num == 10 && $nome == "Neymar"){
            echo "Meio campo";
        }
        if($num == 11 && $nome == "Gabriel Jesus"){
            echo "Atacante";
        }
        if($num >= 12){
            echo "Número inválido";
        }

    ?>
</body>
</html>