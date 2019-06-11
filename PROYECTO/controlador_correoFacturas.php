<?php
session_start();
include_once("gestionBD.php");
include_once("gestionarPedidos.php");


if (isset($_GET["correoConsultaAdmin"]) && filter_var($_GET["correoConsultaAdmin"], FILTER_VALIDATE_EMAIL) && strlen($_GET["correoConsultaAdmin"])<=60) {
	$correoFactura= $_GET["correoConsultaAdmin"];

	$conexion=crearConexionBD();
	$cliente=checkUsuario($conexion,$correoFactura);
	cerrarConexionBD($conexion);

	if($cliente<>""){
		Header("Location: facturasPorCliente.php?correoConsultaAdmin=$correoFactura");
	}else{
		$_SESSION["errorCorreoFactura"] = "<p>Inserte un correo que pertenezca a un cliente registrado. </p>";
	Header("Location: administracion.php");
	}
	
} else{
	$_SESSION["errorCorreoFactura"] = "<p>Inserte un correo válido. </p>";
	Header("Location: administracion.php");
}

?>