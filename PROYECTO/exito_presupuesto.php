<?php

session_start();
if($_SESSION["formularioPresupuesto"]["tipoServicio"]!=""){
	$formularioPresupuesto=$_SESSION["formularioPresupuesto"];
	unset($_SESSION["formularioPresupuesto"]);
	unset($_SESSION["erroresPresupuesto"]);
} else{
	Header("Location: presupuesto.php");
}

function generarPresupuesto($formularioPresupuesto){
		//funcion de calcular el presupuesto
	switch ($formularioPresupuesto["tipoServicio"]) {
		case 'grua':
		$precio=$formularioPresupuesto["horasGrua"] * 35;
		break;

		case 'cuba_escombros':
		if($formularioPresupuesto["distancia"]<16){
			$precio=50;
		} else{
			$precio=60;
		}
		break;

		case 'cuba_poda':
		if($formularioPresupuesto["tamañoCuba"]=="pequeña"){
			$precio=50;
		} else if($formularioPresupuesto["tamañoCuba"]=="mediana"){
			$precio=80;
		}else{
			$precio=100;
		}
		break;

		case 'cuba_estiercol': 
		if($formularioPresupuesto["tamañoCuba"]=="pequeña"){
			$precio=60;
		}else if($formularioPresupuesto["tamañoCuba"]=="mediana"){
			$precio=80;
		}else{
			$precio=100;
		}
		break;

		case 'leña':
		$precio=$formularioPresupuesto["pesoLeña"]*0.12;
		break;
		case 'aridos':
		if($formularioPresupuesto["distancia"]<16){
			$precio=50;
		} else{
			$precio=60;
		}
		break;

		default:
		if($formularioPresupuesto["distancia"]<16){
			$precio=50;
		} else{
			$precio=60;
		}
		break;
	}
	return $precio;
}

$resultado_presupuesto= generarPresupuesto($formularioPresupuesto);
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Resultado Presupuesto | Hnos. Abreu</title>
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
	<link rel="stylesheet" type="text/css" href="css/css_fran.css">
</head>

<body>

	<?php
	include_once("cabecera.php");
	include_once("login.php");

	//reescribimos la url a la que queremos redirigir en caso de error (para que $destino no nos mande aquí de nuevo)
	$_SESSION["actualUrl"] = "presupuesto.php";
	?>

	<?php
	if(is_numeric($resultado_presupuesto)){ ?>

	<div class="centrar">
		<h1>El presupuesto aproximado es de <?php echo $resultado_presupuesto; ?> €.</h1>
		<p><a href="presupuesto.php"><button>Calcular de nuevo</button></a></p>
	</div>

	<?php 
}else{ ?>

<div>
	<h1>Ha ocurrido un error, para volver a la página de inicio pulse <a href="index.php">aquí. </a></h1>
</div>
<?php
}
?>



<?php
include_once("pie.php");
?>

</body>
</html>