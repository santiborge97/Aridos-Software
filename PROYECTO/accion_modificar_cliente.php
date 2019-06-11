<?php	
session_start();	

if (isset($_SESSION["cliente"])) {
	$cliente = $_SESSION["cliente"];
	unset($_SESSION["cliente"]);
	
	require_once("gestionBD.php");
	require_once("gestionarClientes.php");

	$erroresModificarCliente= validacionFormularioModificarCliente($cliente); 


	if (count($erroresModificarCliente)>0) {
			// Guardo en la sesión los mensajes de error y volvemos al formulario
		$_SESSION["erroresModificarCliente"] = $erroresModificarCliente;
		Header('Location:clientes.php');
	} else{
		$conexion = crearConexionBD();		
		$excepcion = modificar_cliente($conexion,$cliente["OID_C"], $cliente["NOMBRE"], $cliente["DIRECCION"], $cliente["NUMEROTELEFONO"],$cliente["CORREOELECTRONICO"]);
		cerrarConexionBD($conexion);

		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "clientes.php";
			Header("Location: excepcion.php");
		} else{
			Header("Location: clientes.php");
		}
	}
	} else Header("Location: clientes.php"); // Se ha tratado de acceder directamente a este PHP
	


//------------------Funcion validacion formulario
	function validacionFormularioModificarCliente($cliente){
		if($cliente["NOMBRE"]=="" || $cliente["NOMBRE"]==null){
			$erroresModificarCliente[] = "<p>El nombre no puede estar vacío ni ser nulo</p>";
		}else if(is_numeric($cliente["NOMBRE"])){
			$erroresModificarCliente[] = "<p>El nombre no puede ser numérico</p>";
		}else if(strlen($cliente["NOMBRE"])>50){
			$erroresModificarCliente[] = "<p>El nombre no puede tener más de 50 carácteres</p>";
		}

		if($cliente["DIRECCION"]=="" || $cliente["DIRECCION"]==null){
			$erroresModificarCliente[] = "<p>La dirección no puede estar vacía ni ser nula</p>";
		}else if(is_numeric($cliente["DIRECCION"])){
			$erroresModificarCliente[] = "<p>La dirección no puede ser numérica</p>";
		}else if(strlen($cliente["DIRECCION"])>50){
			$erroresModificarCliente[] = "<p>La dirección no puede tener más de 50 carácteres</p>";
		}

		if($cliente["NUMEROTELEFONO"]=="" || $cliente["NUMEROTELEFONO"]==null){
			$erroresModificarCliente[] = "<p>El teléfono no puede estar vacío ni ser nulo</p>";
		}else if($cliente["NUMEROTELEFONO"]<0){
			$erroresModificarCliente[]="<p>El teléfono no puede ser negativo</p>";
		}else if (strlen($cliente["NUMEROTELEFONO"])!=9){
			$erroresModificarCliente[] = "<p>El teléfono debe contener 9 dígitos</p>";
		}else if(!is_numeric($cliente["NUMEROTELEFONO"])){
			$erroresModificarCliente[]="<p>El teléfono no puede contener letras</p>";
		}

		if($cliente["CORREOELECTRONICO"]=="" || $cliente["CORREOELECTRONICO"]==null){
			$erroresModificarCliente[] = "<p>El correo electrónico no puede estar vacío ni ser nulo</p>";
		}else if (!filter_var($cliente["CORREOELECTRONICO"], FILTER_VALIDATE_EMAIL)){
			$erroresModificarCliente[] = "<p>El correo electrónico no es válido</p>";
		}else if(strlen($cliente["CORREOELECTRONICO"])>60){
			$erroresModificarCliente[] = "<p>El correo electrónico no puede tener más de 60 carácteres</p>";
		}


		return $erroresModificarCliente;

	}
	?>
