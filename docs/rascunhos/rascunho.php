<div class='m-0 static'>
            <div class='m-5 text-4xl float-start' id='titulo'>
                Seja bem-vindo à LuxCars, onde o luxo e a excelência se encontram.
            </div>
        </div>
 echo "<a href='../paginas/entrar.php'>SIGN IN</a>"

        
        <?php

$nome="";
if(isset($_POST['nome'])) {
   $nome=$_POST['nome'];
}   
session_start();
$_SESSION['nome']=$nome;

header("location:homepage.php");


         session_start();
         if(isset($_SESSION['nome'])){
             echo $_SESSION['nome'];
         }
        
         exit;
        ?>


echo "<a href='../paginas/entrar.php'>SIGN IN</a>"