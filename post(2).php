<?php
//requiere la conexion 
require "conexion.php";
//tomo las variables por post
$recibo=$_POST['RECIBO'];
$empresa=$_POST['EMPRESA'];
$cantidad=$_POST['CANTIDAD'];
$total=$_POST['TOTAL'];
$fecha=$_POST['FECHA'];
$hora=$_POST['HORA'];
//preparo el sql

$sql2="SELECT count(reciboTabla) as cantidad FROM tabla1 WHERE `reciboTabla`=:recibo";
$res=$conn->prepare($sql2);
$res->bindParam(":recibo",$recibo);
$res->execute();
$res=($res->fetch(PDO::FETCH_ASSOC));

if($res['cantidad']==0){
    
$sql="INSERT INTO `tabla1`(`reciboTabla`,
                           `empresaTabla`, 
                           `cantidadTabla`, 
                           `totalTabla`, 
                           `fechaTabla`, 
                           `horaTabla`)
                   VALUES 
                          (:reciboTabla,
                           :empresaTabla,
                           :cantidadTabla,
                           :totalTabla,
                           :fechaTabla,
                           :horaTabla)";
            //preparo la carga de datos
            $CargaDatos=$conn->prepare($sql);
            $CargaDatos->bindparam(":reciboTabla",$recibo);
            $CargaDatos->bindparam(":empresaTabla",$empresa);
            $CargaDatos->bindparam(":cantidadTabla",$cantidad);
            $CargaDatos->bindparam(":totalTabla",$total);
            $CargaDatos->bindparam(":fechaTabla",$fecha);
            $CargaDatos->bindparam(":horaTabla",$hora);

                 if($CargaDatos->execute()){
                    echo "exito";
                }else{
                    echo "fallo";
                }

        
}else{
    echo "duplicado";
}














?>