<?php 
session_start();

if(isset($_SESSION["excepcion"])){
	$excepcion = $_SESSION["excepcion"];
	unset($_SESSION["excepcion"]);
}else{
	$excepcion = "Acceso prohibido.";
}


if (isset($_SESSION["actualUrl"])) {
	$destino = $_SESSION["actualUrl"];
	unset($_SESSION["actualUrl"]);	
} else 
$destino = "";
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
	<title>Excepcion | Hnos. Abreu</title>
</head>
<body>	
	
	<?php	
	include_once("cabecera.php"); 
	?>	

	<div id="div_excepcion">
		<h2>Lo sentimos.</h2>
		<?php if ($destino<>"") { ?>
		<p>Ocurrió un problema durante el procesado de los datos. Pulse <a href="<?php echo $destino ?>">aquí</a> para volver.</p>
		<p><?php echo $excepcion ?></p>
		<?php } else { ?>
		<p>Ocurrió un problema para acceder a la base de datos. Pulse <a href="index.php">aquí</a> para volver a la página principal.</p>
		<?php } ?>
	</div>
	
	<?php	
	include_once("pie.php");
	?>	

</body>
</html>