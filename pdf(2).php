<?php
session_start();
require"conexion.php";
 $sql="SELECT `conta` FROM `contador`";
 $contador=$conn->prepare($sql);
 $contador->execute();
 $contador=($contador->fetch(PDO::FETCH_ASSOC));
ob_start();
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$fecha = date("d/m/Y");
$fecha = str_replace('/', '-', $fecha);
$fecha = date('Y-m-d', strtotime($fecha));
$fecha_menos1dia = date("d/m/Y", strtotime($fecha. "-1 day"));
 

?>
<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
         <link rel="stylesheet" href="public/bootstrap.min.css">
       
         </head>
    <body>
        <section style="border:1px solid;">
            
       <div id="page">
        <div class="columna-izquierda">
          
              <img class="img-fluid" style="margin-top:13px;margin-left:3px;" src="LOGITO_BN.jpg">
              
          
        </div>      
        <div class="columna-derecha">
          <label>Año 2020</label>
          <label>Municipalidad de Clorinda Provincia de Formosa </label>
          <br>
          <label>ADMINISTRACION CELAURO <B>"GENTE DE TRABAJO"</B></label>
          <br>
          <label>Fecha: <?php if($_SESSION['fecha']){echo $_SESSION['fecha'];}else{ echo $fecha_menos1dia;}?></label>
           <br>
          <label>Caja: N°6</label>
        </div>
     </div>

<br>
<br>
<br>
<br>
<br>
<br>
</section>
     <div class="cuadro-info"><h3>Planilla de recaudacion diaria N°<?php echo $contador['conta'];?></h3></div>
<div style=" margin-left:40%;"><h5>TITULO IIV</h5></div>
<div style=" margin-left:17%;"><p>Tasa de usufructo de la via publica por vehiculo automotor</p></div>
<div style="border:1px solid; margin-left:0%;"><label style="padding-left:5px;">7.50 Vehiculo para transporte publico de pasajeros a larga distancia. Se abonará por cada unidad que haga escala o ingrese al Ejido Municipal. Abonará por cada unidad en la oportunidad que haga escala o ingrese. 13 UT <br>Modificao por la <b>ORDENANZA</b> N°713/2016-Expediente N°107/H/2016.</label></div>   
<br>
        <table style="width: 100%;
	height: 10px;" class="table table-bordered">
            <thead class="thead-light">
            <tr>
               <th style="font-size:10px;">Recibo</th>
               <th style="font-size:10px;">Empresa</th>
               <th style="font-size:10px;">Cantidad</th>
               <th style="font-size:10px;">Total</th>
            </tr>
            </thead>
            <?php
        
            
            foreach ($_SESSION['datos'] as $key) {
             $cantidadMicros+=$key['cantidadTabla'];
             $totalRecaudado+=$key['totalTabla'];
            ?>

            <tr>
            <td style="font-size:10px;"><?php  echo $key['reciboTabla'];         ?></td>
            <td style="font-size:10px;"><?php  echo $key['empresaTabla'];        ?></td>
            <td style="font-size:10px;"><?php  echo $key['cantidadTabla'];       ?></td>
            <td style="font-size:10px;"><?php  echo "$".$key['totalTabla'];          ?></td>
            </tr>
            
           <?php
            }
            ?>
            <tr>
                <td style="font-size:11px;">TOTALES</td>
                <td></td>
                <td style="font-size:10px;"><?php echo $cantidadMicros;?></td>
                <td style="font-size:10px;"><?php echo "$".$totalRecaudado;?></td>
            </tr>
        </table>
        <br>
        <div class="columna">
            <p style="margin:-2.5% 0;">________</p>
            <p>Recaudor<p>
            </div>
        <div class="columna">
            <p style="margin:-2.5% 0;padding-left:15px;">____________</p>
            <p style="padding-left:15px;">Director rentas</p>
            </div>
        <div class="columna">
        <p style="margin:-2.5% 0;padding-left:30px;">________</p>
        <p style="padding-left:30px;">Recibido</p>
            </div>
        
    </body>
   <style>
#page {
    width: 660px;
    text-align: center;
}
 label{
     font-size:13px;
 }
 span{
     font-size:18px;
 }
.columna-derecha{
    float:left;
    width:340px;
    }
    
.columna-izquierda{
    text-align:left;
    margin-right:5px;
    padding-right:4px;
    
    float:left;
    width:140px;
    }
 

    
.cuadro-info{
    width:100%;
    margin-left:19%;
   
    
    }
 
.pregunta{
    margin-bottom:15px;
}
.columna {
  width:33%;
  float:left;
}

@media (max-width: 500px) {
  
  .columna {
    width:auto;
    float:none;
  }
  
}
   </style>
</html>

<?php
$dompdf = new Dompdf();
$dompdf->loadHtml(ob_get_clean());
$dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientaci車n
$dompdf->render(); // Generar el PDF desde contenido HTML
$pdf = $dompdf->output();// Obtener el PDF generado
$date="micros";
$dompdf->stream($date); // Enviar el PDF generado al navegador
unset($_SESSION['fecha']);

?>