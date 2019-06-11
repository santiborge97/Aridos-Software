<?php
session_start();

	// Comprobar que hemos llegado a esta página porque se ha rellenado el formulario
if (isset($_SESSION["formularioContacto"])) {
		// Recogemos los datos del formulario
	$correo["nombre"] = $_REQUEST["nombre"];
	$correo["telefono"] = $_REQUEST["telefono"];
	$correo["email"] = $_REQUEST["email"];
	$correo["asunto"] = $_REQUEST["asunto"];
	$correo["texto"] = $_REQUEST["texto"];
			// Guardar la variable local con los datos del formulario en la sesión.
	$_SESSION["formularioContacto"] = $correo;

		// Validamos el formulario en servidor 
	$erroresContacto = validarDatosContacto($correo);
	
		// Si se han detectado errores
	if (count($erroresContacto)>0) {
			// Guardo en la sesión los mensajes de error y volvemos al formulario
		$_SESSION["erroresContacto"] = $erroresContacto;
		Header('Location: contacto.php');
	} else{
			Header('Location: index.php'); //esto es para probar
		} // Si todo va bien, enviamos el correo y vamos a la página de éxito o vamos a contacto.php pero mostramos un mensaje de exito(HAY QUE HABLARLO)

				//Aquí irá el bloque donde se envía el correo con los datos. Hay que preguntar en tutoría porque vaya paranoia de SMTP y demás

			//$exito = mail("angelmarmolfernandez@gmail.com", $correo["asunto"], $correo["texto"], "From: Cliente<".$correo["email"].">\r\n");
			//if($exito){
			//	Header('Location: cabecera.php');
			//}else{
			//	Header('Location: pie.php');

	} else{ // En caso contrario, vamos al formulario
		Header("Location: contacto.php");
	}

	function validarDatosContacto($correo){ //INTENTAR PONER ALGO DE VALIDACION EN CLIENTE EN PLAN QUE NO PUEDA ESTAR VACIO CON ALGUN ATRIBUTO
		// Validación del Nombre			
		if($correo["nombre"]==""){
			$erroresContacto[] = "<p>El nombre no puede estar vacío</p>";
		}
		// Validación del telefono			
		if($correo["telefono"]==""){
			$erroresContacto[] = "<p>El teléfono no puede estar vacío</p>";
		} else if(strlen($correo["telefono"])!=9 || !is_numeric ($correo["telefono"]) || !ctype_digit($correo["telefono"])){
			$erroresContacto[]="<p>El formato del teléfono no es correcto: " . $correo["telefono"] . "</p>";
		} 
		// Validación del email			
		if($correo["email"]==""){
			$erroresContacto[] = "<p>El email no puede estar vacío</p>";
		} else if(!filter_var($correo["email"], FILTER_VALIDATE_EMAIL)){
			$erroresContacto[] = $error . "<p>El email es incorrecto: " . $correo["email"]. "</p>";
		}
		// Validación del asunto			
		if($correo["asunto"]==""){
			$erroresContacto[] = "<p>El asunto no puede estar vacío</p>";
		}
		// Validación del texto			
		if($correo["texto"]==""){
			$erroresContacto[] = "<p>El texto no puede estar vacío</p>";
		}

		return $erroresContacto;
	}
	
	?>