<?php
session_start();

//Aqui hay que comprobar que venimos del Login y que somos el administrador
if($_SESSION["exitoLogin"]["usuario"]!= "cubashnosabreu@gmail.com" ){ 
	Header("Location: index.php");
}

// Si hay errores de validación, hay que mostrarlos y marcar los campos
if(isset($_SESSION["errorCorreoFactura"]))
	$errorCorreoFactura = $_SESSION["errorCorreoFactura"];



?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Administración | Hnos. Abreu</title>
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>

<body>

	<?php
	include_once("cabecera.php");
	include_once("login.php");


	if (isset($errorCorreoFactura)) { 
		echo "<div id=\"div_errorFactura\" class=\"error\">";
		echo "<h4> Error:</h4>";
		echo $errorCorreoFactura; 
		echo "</div>";

    		//Borra los errores una vez que se han mostrado
		$_SESSION["errorCorreoFactura"]=null;
		$errorCorreoFactura=null;
	}

	?>

	<h1 class="titulo_pantalla col-10 col-tab-10">Administración</h1>
	
	<ul class="col-10 col-tab-10">
		<li><form class ="col-tab-10 col-10" action="controlador_correoFacturas.php" method="get" ><h class="titulos_administracion">Facturas por cliente: </h>
			<input type="email" name="correoConsultaAdmin" placeholder="Correo Electrónico" size="10" required>
			<input type="submit" value="Enviar">
		</form></li><br>
		<li><h class="titulos_administracion">Top 5 morosos </h><input type="button" value="Ver" onClick=" window.location.href='top_morosos.php' "></li><br>
		<li><h class="titulos_administracion">Facturas </h><input type="button" value="Ver" onClick=" window.location.href='facturas.php' "></li><br>
		<li><h class="titulos_administracion">Gastos </h><input type="button" value="Ver" onClick=" window.location.href='gastos.php' "></li><br>
		
		<li><h class="titulos_administracion">Balance </h><input type="button" value="Ver" onClick=" window.location.href='balance.php' "></li><br>
		<li><h class="titulos_administracion">Nuevo pedido </h><input type="button" value="Ver" onClick=" window.location.href='nuevoPedido.php' "></li><br>
		<li><h class="titulos_administracion">Clientes </h><input type="button" value="Ver" onClick=" window.location.href='clientes.php' "></li><br>
	</ul>

	<?php
	include_once("pie.php");
	?>

</body>
</html>

