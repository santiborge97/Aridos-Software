<?php	
session_start();
include_once("gestionBD.php");

if (isset($_REQUEST["NOMBRE"])){
	$gasto["NOMBRE"] = $_REQUEST["NOMBRE"];
	$gasto["DESCRIPCION"] = $_REQUEST["DESCRIPCION"];
	$gasto["COSTE"] = $_REQUEST["COSTE"];
	$gasto["FECHAPAGO"] = $_REQUEST["FECHAPAGO"];
	$gasto["FECHAINICIO"] = $_REQUEST["FECHAINICIO"];
	$gasto["FECHAFIN"] = $_REQUEST["FECHAFIN"];

	$erroresAñadirGasto= validacionFormularioAñadirGasto($gasto);

	if (count($erroresAñadirGasto)>0) {
			// Guardo en la sesión los mensajes de error y volvemos al formulario
		$_SESSION["erroresAñadirGasto"] = $erroresAñadirGasto;
		Header('Location:gastos.php');
	} else{
		$conexion = crearConexionBD();		
		$excepcion = añadir_gasto($conexion,$gasto);
		cerrarConexionBD($conexion);

		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "gastos.php";
			Header("Location: excepcion.php");
		} else Header("Location: gastos.php");
	}

} else{
	Header("Location: gastos.php");
}


//------------------Funcion validacion formulario
function validacionFormularioAñadirGasto($gasto){
	$fechaMax = "2099-12-31";
	$fechaMin = "2000-01-01";

	if($gasto["NOMBRE"]=="" || $gasto["NOMBRE"]==null){
		$erroresAñadirGasto[] = "<p>El nombre no puede estar vacío</p>";
	}else if(is_numeric($gasto["NOMBRE"])){
		$erroresAñadirGasto[] = "<p>El nombre no puede ser numérico</p>";
	}else if(strlen($gasto["NOMBRE"])>50){
		$erroresAñadirGasto[] = "<p>El nombre no puede tener más de 50 carácteres</p>";
	}

	if($gasto["DESCRIPCION"]=="" || $gasto["DESCRIPCION"]==null){
		$erroresAñadirGasto[] = "<p>La descripción no puede estar vacía</p>";
	}else if(is_numeric($gasto["DESCRIPCION"])){
		$erroresAñadirGasto[] = "<p>La descripción no puede ser numérica</p>";
	}else if(strlen($gasto["DESCRIPCION"])>70){
		$erroresAñadirGasto[] = "<p>La descripción no puede tener más de 70 carácteres</p>";
	}

	if($gasto["COSTE"]==""|| $gasto["COSTE"]==null){
		$erroresAñadirGasto[] = "<p>El coste no puede estar vacío y debe ser numérico</p>";
	}else if (!is_numeric($gasto["COSTE"])){
		$erroresAñadirGasto[] = "<p>El coste debe ser númerico </p>";
	} else if ($gasto["COSTE"]<=0){
		$erroresAñadirGasto[] = "<p>El coste no puede ser menor o igual que 0 </p>";
	} else if(!ctype_digit($gasto["COSTE"])){
		$erroresAñadirGasto[] = "<p>El coste no puede ser decimal </p>";
	}

	if($gasto["FECHAPAGO"]==""|| $gasto["FECHAPAGO"]==null){
		$erroresAñadirGasto[] = "<p>La fecha de pago no puede estar vacía</p>";
	}else if($gasto["FECHAPAGO"]<$fechaMin || $gasto["FECHAPAGO"]>$fechaMax ){
		$erroresAñadirGasto[] = "<p>La fecha de pago no puede ser mayor que 2099-12-31 ni menor que 2000-01-01. </p>";
	}

	if($gasto["FECHAFIN"]==""|| $gasto["FECHAFIN"]==null){
		$erroresAñadirGasto[] = "<p>La fecha de fin no puede estar vacía</p>";
	}else if($gasto["FECHAFIN"]<$fechaMin || $gasto["FECHAFIN"]>$fechaMax ){
		$erroresAñadirGasto[] = "<p>La fecha de fin no puede ser mayor que 2099-12-31 ni menor que 2000-01-01. </p>";
	}

	if($gasto["FECHAINICIO"]==""|| $gasto["FECHAINICIO"]==null){
		$erroresAñadirGasto[] = "<p>La fecha de inicio no puede estar vacía</p>";
	}else if($gasto["FECHAINICIO"]<$fechaMin || $gasto["FECHAINICIO"]>$fechaMax ){
		$erroresAñadirGasto[] = "<p>La fecha de inicio no puede ser mayor que 2099-12-31 ni menor que 2000-01-01. </p>";
	}

	if($gasto["FECHAINICIO"]>$gasto["FECHAFIN"]){
		$erroresAñadirGasto[] = "<p>La fecha de inicio no puede ser posterior a la fecha fin </p>";
	}

	return $erroresAñadirGasto;

}

//-----------------------Funcion añadir gasto
function añadir_gasto($conexion,$gasto) {
	try {
		$stmt=$conexion->prepare('INSERT INTO GASTOS (NOMBRE,DESCRIPCION,COSTE,FECHAPAGO,FECHAINICIO,FECHAFIN) VALUES (:NOMBRE,:DESCRIPCION,:COSTE,to_date(:FECHAPAGO,\'YYYY/MM/DD\'),to_date(:FECHAINICIO,\'YYYY/MM/DD\'),to_date(:FECHAFIN,\'YYYY/MM/DD\'))');
		$stmt->bindParam(':NOMBRE',$gasto["NOMBRE"]);
		$stmt->bindParam(':DESCRIPCION',$gasto["DESCRIPCION"]);
		$stmt->bindParam(':COSTE',$gasto["COSTE"]);
		$stmt->bindParam(':FECHAPAGO',$gasto["FECHAPAGO"]);
		$stmt->bindParam(':FECHAINICIO',$gasto["FECHAINICIO"]);
		$stmt->bindParam(':FECHAFIN',$gasto["FECHAFIN"]);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return "Ha habido un error al añadir el gasto (Puede que haya introducido algun dato incorrecto).";
	}
}

?>