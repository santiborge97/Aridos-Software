<?php
session_start();
include_once("gestionBD.php");
include_once("gestionar_login.php");


/*Si venimos desde cualquier página del proyecto,
se redirige allí. Si no, se redirige al index*/
if(isset($_SESSION["actualUrl"])){
	$url = $_SESSION["actualUrl"];
} else {
	$url = "index.php";
}


	//Comprobamos que venimos del formulario
if(isset($_SESSION["formularioLogin"])){
	$formularioLogin["usuario"] = $_REQUEST["usuario"];
	$formularioLogin["password"] = $_REQUEST["password"];
	$_SESSION["formularioLogin"] = $formularioLogin;


	$erroresLogin = validarDatosLogin($formularioLogin);

	if(count($erroresLogin)>0){
		$_SESSION["erroresLogin"] = $erroresLogin;
		Header("Location:$url");
	} else {
		
			//No hay errores de validación, comprobamos que el usuario existe
		$conexion = crearConexionBD();
		$exito = loginUsuario($conexion, $formularioLogin["usuario"], $formularioLogin["password"]);
		cerrarConexionBD($conexion);
			//Si la contraseña del usuario en la BD coincide con la que escrita en el navegador, se crea
			//la variable $exitoLogin que tiene los datos del usuario logueado. Si no, se vuelve a la página
			//anterior con un error

		if($exito){
			$_SESSION["exitoLogin"] = $formularioLogin;
			unset($formularioLogin);
			unset($erroresLogin);
			Header("Location: $url");
		} else{
			$erroresLogin[]="<p>El usuario no existe, o la contraseña es incorrecta.</p>";
			$_SESSION["erroresLogin"] = $erroresLogin;
			Header("Location: $url");
		}
	}

}else{
	Header("Location:$url");
}



//-----------------------------------------------------------------------------------Función auxiliar
function validarDatosLogin($formularioLogin){
	if(!filter_var($formularioLogin["usuario"], FILTER_VALIDATE_EMAIL)){
		$erroresLogin[] = "<p>Inserte un usuario válido</p>";
	}

	if(!is_numeric($formularioLogin["password"]) || $formularioLogin["password"]=""){
		$erroresLogin[] = "<p>Inserte una contraseña válida</p>";
	}

	return $erroresLogin;
}

?>