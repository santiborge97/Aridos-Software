<?php	
session_start();
include_once("gestionBD.php");

if (isset($_REQUEST["NOMBRE"])){
	$cliente["NOMBRE"] = $_REQUEST["NOMBRE"];
	$cliente["DIRECCION"] = $_REQUEST["DIRECCION"];
	$cliente["TELEFONO"] = $_REQUEST["TELEFONO"];
	$cliente["CORREOELECTRONICO"] = $_REQUEST["CORREOELECTRONICO"];

	$erroresAñadirCliente= validacionFormularioAñadirCliente($cliente); 

	if (count($erroresAñadirCliente)>0) {
			// Guardo en la sesión los mensajes de error y volvemos al formulario
		$_SESSION["erroresAñadirCliente"] = $erroresAñadirCliente;
		Header('Location:clientes.php');
	} else{
		$conexion = crearConexionBD();		
		$excepcion = añadir_cliente($conexion, $cliente);
		cerrarConexionBD($conexion);

		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "clientes.php";
			Header("Location: excepcion.php");
		} else Header("Location: clientes.php");
	}

} else{
	Header("Location: clientes.php");
}

//------------------Funcion validacion formulario
function validacionFormularioAñadirCliente($cliente){
	if($cliente["NOMBRE"]=="" || $cliente["NOMBRE"]==null){
		$erroresAñadirCliente[] = "<p>El nombre no puede estar vacío ni ser nulo</p>";
	}else if(is_numeric($cliente["NOMBRE"])){
		$erroresAñadirCliente[] = "<p>El nombre no puede ser numérico</p>";
	}else if(strlen($cliente["NOMBRE"])>50){
		$erroresAñadirCliente[] = "<p>El nombre no puede tener más de 50 carácteres</p>";
	}

	if($cliente["DIRECCION"]=="" || $cliente["DIRECCION"]==null){
		$erroresAñadirCliente[] = "<p>La dirección no puede estar vacía ni ser nula</p>";
	}else if(is_numeric($cliente["DIRECCION"])){
		$erroresAñadirCliente[] = "<p>La direccion no puede ser numérica</p>";
	}else if(strlen($cliente["DIRECCION"])>50){
		$erroresAñadirCliente[] = "<p>La dirección no puede tener más de 50 carácteres</p>";
	}

	if($cliente["TELEFONO"]=="" || $cliente["TELEFONO"]==null){
		$erroresAñadirCliente[] = "<p>El teléfono no puede estar vacío ni ser nulo</p>";
	}else if($cliente["TELEFONO"]<0){
		$erroresAñadirCliente[]="<p>El teléfono no puede ser negativo</p>";
	}else if (strlen($cliente["TELEFONO"])!=9){
		$erroresAñadirCliente[] = "<p>El teléfono debe contener 9 dígitos</p>";
	}else if(!is_numeric($cliente["TELEFONO"])){
		$erroresAñadirCliente[]="<p>El teléfono no puede contener letras</p>";
	}

	if($cliente["CORREOELECTRONICO"]=="" || $cliente["CORREOELECTRONICO"]==null){
		$erroresAñadirCliente[] = "<p>El correo electrónico no puede estar vacío ni ser nulo</p>";
	} else if (!filter_var($cliente["CORREOELECTRONICO"], FILTER_VALIDATE_EMAIL)){
		$erroresAñadirCliente[] = "<p>El correo electrónico no es válido</p>";
	}else if(strlen($cliente["CORREOELECTRONICO"])>60){
		$erroresAñadirCliente[] = "<p>El correo electrónico no puede tener más de 60 carácteres</p>";
	}


	return $erroresAñadirCliente;

}

//-----------------------Funcion añadir cliente
function añadir_cliente($conexion, $cliente){
	try {
		$stmt=$conexion->prepare('INSERT INTO CLIENTES (NOMBRE,DIRECCION,NUMEROTELEFONO,CORREOELECTRONICO) VALUES (:nombre,:direccion,:telefono,:correo)');
		$stmt->bindParam(':nombre',$cliente["NOMBRE"]);
		$stmt->bindParam(':direccion',$cliente["DIRECCION"]);
		$stmt->bindParam(':telefono',$cliente["TELEFONO"]);
		$stmt->bindParam(':correo',$cliente["CORREOELECTRONICO"]);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return "Ha habido un error al añadir el cliente (Probablemente ya exista un cliente con ese correo electrónico).";
	}
}

?>