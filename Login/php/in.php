<?php
require "../../conexion.php";

$usuario=$_POST['username'];
$password=$_POST['password'];

$sql="SELECT `idUser`, `nombreUser`, `paswordUser` FROM `users` WHERE nombreUser=:nombreUser AND paswordUser=:paswordUser";

$buscarUser=$conn->prepare($sql);
$buscarUser->bindParam(":nombreUser",$usuario);
$buscarUser->bindParam(":paswordUser",$password);
$buscarUser->execute();
$buscarUser2=$buscarUser->fetch(PDO::FETCH_ASSOC);
if($buscarUser2!=null){
    session_start();
    $_SESSION['datosUser']=$buscarUser2;
    header("location: ../../principal.php");
    
}

if ($usuario!=$buscarUser2['nombreUser']){
    $error="usuario incorrecto ";
echo '<script>alert("'.$error.'")</script>';
echo '<script>location.href = "../index.php"</script>';
}


















?>