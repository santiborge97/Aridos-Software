<?php
session_start();
require_once("gestionBD.php");
require_once("gestionarPedidos.php");

if($_SESSION["exitoLogin"]["usuario"]!= "cubashnosabreu@gmail.com" ){ 
	Header("Location: index.php");
}

if (isset($_SESSION["formularioPedido"])) {
	unset($_SESSION["formularioPedido"]);
}else{
	Header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Nuevo pedido | Hnos. Abreu</title>
	<link rel="stylesheet" type="text/css" href="css/css_calzado.css">
	<link rel="stylesheet" type="text/css" href="css/estilo.css">

</head>

<body>
	<?php
	include_once("cabecera.php");
	include_once("login.php");
	?>

	<h1 id="exitoPedido" class="col-10 col-tab-10">Pedido creado exitosamente:</h1>
	<p>
		<?php
		$conexion = crearConexionBD();
		$pedido = getUltimoPedido($conexion);
		cerrarConexionBD($conexion);
		if($pedido["OID_P"]==null){
			$_SESSION["excepcion"] = "El pedido no se ha insetado correctamente";
			$_SESSION["actualUrl"] = "nuevoPedido.php";
			Header("Location: excepcion.php");
		}
		?>


		
		<p class="prop col-10 col-tab-10"><u>Precio:</u> <?php echo $pedido["PRECIO"]; ?></p>
		<p class="prop col-10 col-tab-10"><u>Dirección del pedido:</u> <?php echo $pedido["DIRECCION"]; ?></p>
		<p class="prop col-10 col-tab-10"><u>Fecha del pedido:</u> <?php echo $pedido["FECHA"]; ?></p>
		<p class="prop col-10 col-tab-10"><u>Cliente:</u> <?php echo $pedido["CORREOELECTRONICO"]; ?></p>
		<p class="prop col-10 col-tab-10"><u>Empleado encargado:</u> <?php echo $pedido["NOMBREE"]; ?></p>
		<p class="prop col-10 col-tab-10"><u>Servicio:</u> <?php echo $pedido["TIPOSERVICIO"]; ?></p>
		<p class="prop col-10 col-tab-10"><u>Camión usado:</u> <?php echo $pedido["TIPOCAMION"]; ?></p>
		<p class="prop col-10 col-tab-10"><u>Nº de factura:</u> <?php echo $pedido["OID_F"]; ?></p>


		<h1 id="otroPedido" class="col-10 col-tab-10">Pulse <a href="nuevoPedido.php">aquí</a> para crear otro pedido</h1>
	</p>




	<?php
	include_once("pie.php");
	?>

</body>
</html>