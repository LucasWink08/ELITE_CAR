<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <?php
   $limite=0;
   if(isset($_POST['limite']))
   $limite=$_POST['limite'];

   $incremento=0;
   if(isset($_POST['incremento']))
   $incremento=$_POST['incremento'];
  
?>
</head>
<body>
  <form action="" method="post">
    digite o limite superior <input type="text" name="limite"><br>
    digite o incremento <input type="text" name="incremento" value="<?php echo $limite ?>">
    <input type="submit">
  </form>
  <?php
   if(isset($_POST['limite'])){
   for($i = 0; $i<=$limite; $i+=$incremento){
    echo "$i<br>";
   }
  }
  ?>
</body>
</html>