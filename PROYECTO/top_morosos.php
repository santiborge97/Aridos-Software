<?php
	//Lo de siempre
session_start();
include_once("gestionBD.php");
	//Comprobamos si somos el administrador
if($_SESSION["exitoLogin"]["usuario"]!= "cubashnosabreu@gmail.com" ){
	Header("Location: index.php");
}else{
	$conexion = crearConexionBD();
	$morosos = consultarMorosidad($conexion, 5);
	cerrarConexionBD($conexion);
	if($morosos==""){
		$_SESSION["excepcion"] = "Error crear la lista de morosos, inténtelo de nuevo en unos instantes.";
		header("Location: excepcion.php");
	}
}

//------------------------------------Función Consulta Clientes Morosos--------------------------------------------
function consultarMorosidad($conexion, $top_number){
	try {
		$stmt=$conexion->prepare('SELECT DISTINCT NOMBRE, PRECIOTOTAL, CORREOELECTRONICO FROM CLIENTES C, PEDIDOS P, FACTURAS F WHERE F.ESTAPAGADO=\'NO\' and (P.OID_C=C.OID_C AND P.OID_F = F.OID_F) ORDER BY F.PRECIOTOTAL DESC');
		$stmt->execute();
		for ($i=0; $i < $top_number; $i++) { 
			$fila = $stmt->fetch();
			$morosos[$i] = $fila;
		}
		
		
		return $morosos;

	} catch(PDOException $e) {
		return "";
	}
}


//--------------------------------------------HTML-----------------------------------------------------------------------//	

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Morosos | Hnos. Abreu</title>
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
	<link rel="stylesheet" type="text/css" href="css/css_fran.css">
</head>

<body>

	<?php
	include_once("cabecera.php");
	include_once("login.php");
	?>

	<div class="centrar"><h1>La lista de los 5 clientes que más deben es:</h1></div>

	<div style="overflow-x:auto" class="col-10 col-tab-10">
		<table>
			<tr>
				<th>Nombre</th>
				<th>Correo Eletrónico</th>
				<th>Cantidad adeudada</th>

			</tr>

			<?php

			foreach ($morosos as $moroso) {
				if($moroso["NOMBRE"]!=null){
					?>
					<tr class="moroso">
						<td><?=$moroso['NOMBRE']?></td>
						<td><?=$moroso['CORREOELECTRONICO']?></td>
						<td><?=$moroso['PRECIOTOTAL']?>€</td>
					</tr>

					<?php	
				}
			}

			?>
		</table>
	</div>
	
	<?php
	include_once("pie.php");
	?>

</body>
</html>