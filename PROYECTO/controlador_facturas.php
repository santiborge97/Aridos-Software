<?php	
session_start();
include_once("gestionBD.php");
include_once("gestionFacturas.php");

if (isset($_REQUEST["OID_F"])){
	$factura["OID_F"]=$_REQUEST["OID_F"];
	
	$_SESSION["factura"] = $factura;
	
	if (isset($_REQUEST["desglose"])) Header("Location: pedidosPorFactura.php");
	else if (isset($_REQUEST["pagado"])){
		$conexion = crearConexionBD();

		$excepcion = modificar_factura($conexion, $factura["OID_F"]);
		cerrarConexionBD($conexion);
		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "facturas.php";
			Header("Location: excepcion.php");
		} else Header("Location:". $_SESSION['actualUrl']);
		
	} 
}
else 
	Header("Location: facturasPorCliente.php");

?>

