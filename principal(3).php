<?php
function fsalida($cad2){
$tres=substr($cad2, 0, 4);
$dos=substr($cad2, 5, 2);
$uno=substr($cad2, 8, 2);
$cad = ($uno."/".$dos."/".$tres);
return $cad;
}
session_start();
require "conexion.php";
if(!isset($_SESSION['datosUser']['nombreUser'])){
    header("location:Login/index.php");
}
$sql33="SELECT `conta` FROM `contador`";
 $contador=$conn->prepare($sql33);
 $contador->execute();
 $contador=($contador->fetch(PDO::FETCH_ASSOC));
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $fechaInicio=$_POST['fechaInicio'];
    $_SESSION['fecha']=fsalida($fechaInicio);
   
    $fechaFIN=$_POST['fechaFIN'];
   
    $sql = "SELECT * FROM `tabla1` WHERE fechaTabla BETWEEN :fechaInicio AND :fechaFIN";
    $res=$conn->prepare($sql);
    $res->bindparam(":fechaInicio",$fechaInicio);
    $res->bindparam(":fechaFIN",$fechaFIN);
    $res->execute();
    $results = ($res->fetchAll(PDO::FETCH_ASSOC));
    
    $_SESSION['datos']=$results;
   
}else{
    $sql="SELECT * FROM tabla1 order by idTabla desc LIMIT 8 ";
  
    $res=$conn->prepare($sql);

    $res->execute();

    $results = ($res->fetchAll(PDO::FETCH_ASSOC)); 
    $results=array_reverse($results);
    $_SESSION['datos']=$results;
//print_r($results);
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  <link rel="stylesheet" href="public/bootstrap.min.css">


  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Resultados</title>

</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <a class="navbar-brand" href="#">MICROS</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02"
        aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarColor02">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo $_SESSION['datosUser']['nombreUser'];?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="cerrarSesion.php">cerrar sesion</a>
            </div>
          </li>
        </ul>
        <form class="form-inline" action="" method="post">
          <input class="form-control mr-sm-2" name="fechaInicio" type="date">
          <input class="form-control mr-sm-2" name="fechaFIN" type="date">
          <button class="btn btn-secondary" type="submit">Filtrar</button>
        </form>
      </div>
    </nav>
    <h3 style="text-align:center;">planilla de recaudacion diaria N<input onkeyup="myFunction()" id="contador"
        style="width:70px;height:30px;margin-top:px;" value="<?php echo $contador['conta']?>"></h3>
  </header>
  <div class="container">
    <a style="margin:4px;" href="#addnew" class="btn btn-primary nueva" data-toggle="modal"><span
        class="fa fa-plus"></span> Nuevo</a>
    <?php 
                
                if(isset($_SESSION['message'])){
                    ?>
    <div class="alert alert-dismissible alert-success" style="margin-top:20px;">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <?php echo $_SESSION['message']; ?>
    </div>
    <?php

                    unset($_SESSION['message']);
                }
            ?>

    <table class="table table-bordered">
      <thead class="thead-light">
        <tr>
          <th>Recibo</th>
          <th>Empresa</th>
          <th>Cantidad</th>
          <th>Total</th>
          <th>Fecha</th>
          <th>Hora</th>
        </tr>
      </thead>
      <?php

foreach ($results as $key) {

?>

      <tr>
        <td><?php  echo $key['reciboTabla'];         ?></td>
        <td><?php  echo $key['empresaTabla'];        ?></td>
        <td><?php  echo $key['cantidadTabla'];       ?></td>
        <td><?php  echo "$".$key['totalTabla'];          ?></td>
        <td><?php  echo fsalida($key['fechaTabla']); ?></td>
        <td><?php  echo $key['horaTabla'];           ?></td>
      </tr>

      <?php
}
?>
    </table>
    <div style="text-align: right; margin-right: 15px;">
      <a href="pdf.php"><input type="button" class="btn btn-outline-success" value="Generar pdf"></a>
    </div </div>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
<script src="public/bootstrap.min.js"></script>
<script>
function myFunction() {
  let contador = document.getElementById("contador").value;
  let param = {
    "contador": contador
  }
  $.ajax({
    data: param,
    url: "contador.php",
    type: "post",
    //success: function(response)
    //{alert("exito")}
  })
}
</script>
<?php include('add_modal.php'); ?>

</html>