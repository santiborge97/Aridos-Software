<?php
session_start();

// Si no existen datos del formulario en la sesión, se crea una entrada con valores por defecto
if (!isset($_SESSION['formularioContacto'])) {
	$formularioContacto['nombre'] = "";
	$formularioContacto['email'] = "";
	$formularioContacto['asunto'] = "";
	$formularioContacto['texto'] = "";
	$formularioContacto['telefono'] = "";
	
	
	$_SESSION['formularioContacto'] = $formularioContacto;
}
	// Si ya existían valores, los cogemos para inicializar el formulario
else
	$formularioContacto = $_SESSION['formularioContacto'];

// Si hay errores de validación, hay que mostrarlos y marcar los campos
if(isset($_SESSION["erroresContacto"]))
	$erroresContacto = $_SESSION["erroresContacto"];
?>




<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Contacto | Hnos. Abreu</title>
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
	<link rel="stylesheet" type="text/css" href="css/css_fran.css">
</head>

<body>

	<?php
	include_once("cabecera.php");
	include_once("login.php");
	?>

	<?php
	// Mostrar los erroes de validación (Si los hay)
	if (isset($erroresContacto) && count($erroresContacto)>0) { 
		echo "<div id=\"div_erroresContacto\" class=\"error\">";
		echo "<h4> Errores en el formulario:</h4>";
		foreach($erroresContacto as $error) echo $error; 
		echo "</div>";

    		//Borra los errores una vez que se han mostrado
		$_SESSION["erroresContacto"]=null;
		$erroresContacto=null;
	}
	?>


	<div class="centrar">

		<p><h2><ins>Teléfonos:</ins> </h2>
			<ins>Camión:</ins> 607 439 034<br>
			<ins>Camión Grúa:</ins> 607 439 035<br>
			<ins>Oficina:</ins> 959 39 00 00<br>
		</p>

		<p><h2><ins>Correo electrónico:</h2>
			cubasabreu@gmail.com
		</p>

	</div>

	<div class="centrar">
		<p><h2><ins>Dirección:</ins> </h2>
			Carretera Prado Viejo S/N (Nave roja)
		</p>
		<a href="https://www.google.es/maps/place/Diseminado+Diseminados,+824,+21450+Cartaya,+Huelva/@37.2756323,-7.1457571,1849m/data=!3m1!1e3!4m5!3m4!1s0xd10325d43247f09:0x79d33596853e3750!8m2!3d37.27469!4d-7.14556" target="_blank">
			<div style="overflow-x:auto">	<img src="images/mapa.jpg"></div>
		</a>

	</div>
<!--
	<div class="centrar">
	<h1>Contactar</h1>
		<form action="accion_contacto.php" method="post"> Todos los atributos son obligatorios?
			Nombre:<br>
			 <input type="text" name="nombre" id="nombre" value="<?php echo $formularioContacto['nombre'];?>" size="20" maxlength="40" required><br>
			Teléfono:<br>
			 <input type="text" name="telefono" id="telefono" value="<?php echo $formularioContacto['telefono'];?>" pattern="[0-9]{9}" required><br>
			Email:<br>
			 <input type="email" name="email" id="email" placeholder="usuario@dominio.extension" value="<?php echo $formularioContacto['email'];?>" size="40" required><br>
			Asunto:<br>
			 <input type="text" name="asunto" id="asunto" value="<?php echo $formularioContacto['asunto'];?>" size="40" required><br>
			Texto:<br>
			 <textarea id="texto" name="texto" rows="10" cols="50" value="<?php echo $formularioContacto['texto'];?>" required></textarea><br>
			
			<input type="submit" value="Enviar"><br>
		</form>

	</div>
-->

<?php
include_once("pie.php");
?>

</body>
</html>