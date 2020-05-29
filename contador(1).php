<?php 
require "conexion.php";
$conta=$_POST['contador'];

$update="UPDATE `contador` SET `conta`=:conta";
$upp=$conn->prepare($update);
$upp->bindParam(":conta",$conta);
$upp->execute();
?>