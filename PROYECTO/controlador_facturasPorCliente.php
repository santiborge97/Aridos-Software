<?php	
session_start();

if (isset($_REQUEST["OID_F"])){
	$factura["OID_F"]=$_REQUEST["OID_F"];
	$factura["FECHAEMISION"] = $_REQUEST["FECHAEMISION"];
	$factura["NUMPEDIDOS"] = $_REQUEST["UMPEDIDOS"];
	$factura["PRECIOSINIVA"] = $_REQUEST["PRECIOSINIVA"];
	$factura["PRECIOTOTAL"] = $_REQUEST["PRECIOTOTAL"];
	$factura["ESTAPAGADO"] = $_REQUEST["ESTAPAGADO"];
	$factura["FECHACREACION"] = $_REQUEST["FECHACREACION"];
	
	$_SESSION["factura"] = $factura;
	
	if (isset($_REQUEST["editar"])) Header("Location: pedidosPorCliente.php"); 
	else if (isset($_REQUEST["grabar"])) Header("Location: accion_modificar_pedido.php");
	else /* if (isset($_REQUEST["borrar"])) */ Header("Location: accion_borrar_pedido.php"); 
}
else 
	Header("Location: facturasPorCliente.php");

?>
