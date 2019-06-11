<?php	
session_start();

if (isset($_REQUEST["OID_P"])){
	$pedido["OID_P"]=$_REQUEST["OID_P"];
	$pedido["PRECIO"] = $_REQUEST["PRECIO"];
	$pedido["DIRECCION"] = $_REQUEST["DIRECCION"];
	$pedido["FECHA"] = $_REQUEST["FECHA"];
	$pedido["OID_C"] = $_REQUEST["OID_C"];
	$pedido["OID_E"] = $_REQUEST["OID_E"];
	$pedido["OID_S"] = $_REQUEST["OID_S"];
	$pedido["OID_F"] = $_REQUEST["OID_F"];
	
	$_SESSION["pedido"] = $pedido;
	
	if (isset($_REQUEST["editar"])) Header("Location: pedidosPorFactura.php"); 
	else if (isset($_REQUEST["grabar"])) Header("Location: accion_modificar_pedido.php");
	else /* if (isset($_REQUEST["borrar"])) */ Header("Location: accion_borrar_pedido.php"); 
}
else 
	Header("Location: pedidosPorFactura.php");

?>
