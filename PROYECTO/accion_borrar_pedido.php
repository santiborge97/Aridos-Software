<?php	
session_start();	

if (isset($_SESSION["pedido"])) {
	$pedido = $_SESSION["pedido"];
	unset($_SESSION["pedido"]);

	require_once("gestionBD.php");
	require_once("gestionarPedidos.php");
	
	$conexion = crearConexionBD();		
	$excepcion = quitar_pedido($conexion,$pedido["OID_P"]);
	cerrarConexionBD($conexion);
	
	if ($excepcion<>"") {
		$_SESSION["excepcion"] = $excepcion;
		$_SESSION["destino"] = "pedidosPorFactura.php";
		Header("Location: excepcion.php");
	}
	else Header("Location: pedidosPorFactura.php");
}
	else Header("Location: pedidosPorFactura.php"); // Se ha tratado de acceder directamente a este PHP
	?>
