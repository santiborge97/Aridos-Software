<?php	
session_start();

if (isset($_REQUEST["OID_C"])){
	$cliente["OID_C"]=$_REQUEST["OID_C"];
	$cliente["NOMBRE"]=$_REQUEST["NOMBRE"];
	$cliente["DIRECCION"]=$_REQUEST["DIRECCION"];
	$cliente["NUMEROTELEFONO"]=$_REQUEST["NUMEROTELEFONO"];
	$cliente["CORREOELECTRONICO"]=$_REQUEST["CORREOELECTRONICO"];
	
	$_SESSION["cliente"] = $cliente;
	
	if (isset($_REQUEST["editar"])) Header("Location: clientes.php"); 
	else if (isset($_REQUEST["grabar"])) Header("Location: accion_modificar_cliente.php");
	else /* if (isset($_REQUEST["borrar"])) */ Header("Location: accion_borrar_cliente.php"); 
}
else 
	Header("Location: clientes.php");

?>
