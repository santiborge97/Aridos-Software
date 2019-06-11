<?php
session_start();


if($_SESSION["exitoLogin"]["usuario"]!= "cubashnosabreu@gmail.com" ){ 
	Header("Location: index.php");
}
	//Comprobamos si hay datos en el resultado del balance
if(isset($_SESSION["BALANCE"])){
	$resultadoBalance=$_SESSION["BALANCE"];
	$resultadoTotalFacturas=$_SESSION["SUMAFACTURAS"];
	$resultadoTotalGastos=$_SESSION["SUMAGASTOS"];

}
else
	Header("Location: balance.php");


?>



<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Balance | Hnos. Abreu</title>
	<link rel="stylesheet" type="text/css" href="css/css_calzado.css">
	<link rel="stylesheet" type="text/css" href="css/estilo.css">

</head>

<body>
	<?php
	include_once("cabecera.php");
	include_once("login.php");
	?>

	<h1 id="resBalance" class="col-10 col-tab-10">El resultado del balance según el intervalo de tiempo indicado es:</h1>
	<p id="bal" class="col-10 col-tab-10"><b>Balance: <?php echo $resultadoBalance; ?> €</b></p>
	<p id="ing" class="col-10 col-tab-10"><b>Total ingresos: <?php echo $resultadoTotalFacturas; ?> €</b></p>
	<p id="gas" class="col-10 col-tab-10"><b>Total gastos: <?php echo $resultadoTotalGastos; ?> €</b></p>






	<?php
	include_once("pie.php");
	?>

</body>
</html>
