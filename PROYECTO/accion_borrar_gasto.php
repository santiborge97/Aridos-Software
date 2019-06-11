<?php	
session_start();	


require_once("gestionBD.php");
require_once("gestionarPedidos.php");

if (isset($_REQUEST["OID_G"])){
	$gasto["OID_G"]=$_REQUEST["OID_G"];
	$gasto["NOMBRE"] = $_REQUEST["NOMBRE"];
	$gasto["DESCRIPCION"] = $_REQUEST["DESCRIPCION"];
	$gasto["COSTE"] = $_REQUEST["COSTE"];
	$gasto["FECHAPAGO"] = $_REQUEST["FECHAPAGO"];
	$gasto["FECHAINICIO"] = $_REQUEST["FECHAINICIO"];
	$gasto["FECHAFIN"] = $_REQUEST["FECHAFIN"];
	
	
	$conexion = crearConexionBD();		
	$excepcion = quitar_gasto($conexion,$gasto["OID_G"]);
	cerrarConexionBD($conexion);
	
	if ($excepcion<>"") {
		$_SESSION["excepcion"] = $excepcion;
		$_SESSION["destino"] = "gastos.php";
		Header("Location: excepcion.php");
	}
	else Header("Location: gastos.php");
}
	else Header("Location: gastos.php"); // Se ha tratado de acceder directamente a este PHP

//--------Funcion de borrar gasto
	function quitar_gasto($conexion,$OID_G) {
		try {
			$stmt=$conexion->prepare('DELETE FROM GASTOS G WHERE G.OID_G =:OID_G');
			$stmt->bindParam(':OID_G',$OID_G);
			$stmt->execute();
			return "";
		} catch(PDOException $e) {
			return "Ha habido un error al borrar el gasto.";
		}
	}

	?>