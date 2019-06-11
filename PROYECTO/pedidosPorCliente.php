<?php
session_start();
include_once("gestionBD.php");
include_once("paginacionConsulta.php");

if($_SESSION["exitoLogin"]["usuario"]!= "cubashnosabreu@gmail.com" ){ 
	Header("Location: index.php");
}

if (isset($_SESSION["pedido"])){
	$pedido = $_SESSION["pedido"];
	unset($_SESSION["pedido"]);
}

if (isset($_GET["correoConsultaAdmin"]) && filter_var($_GET["correoConsultaAdmin"], FILTER_VALIDATE_EMAIL)) {
	$_SESSION["correoConsultaAdmin"]= $_GET["correoConsultaAdmin"];
}



$correoConsulta = $_SESSION["correoConsultaAdmin"];

if(isset($_SESSION["paginacion"])){
	$paginacion = $_SESSION["paginacion"];/* Expresión para iniciar variable de sesión (si es que hay) */

}

if (isset($_GET["PAG_TAM"])) {
	$pag_tam=(int)$_GET["PAG_TAM"];
}else{
	if(isset($_SESSION["paginacion"])){
		$pag_tam=$_SESSION["paginacion"]["PAG_TAM"];
	}
	else{
		$pag_tam=4;
	}
}

if (isset($_GET["PAG_NUM"])) {
	$pagina_seleccionada=(int)$_GET["PAG_NUM"];
}else{
	if(isset($_SESSION["paginacion"])){
		$pagina_seleccionada=$_SESSION["paginacion"]["PAG_NUM"];
	}
	else{
		$pagina_seleccionada=1;
	}
}



if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
if ($pag_tam < 1) $pag_tam = 4;

unset($_SESSION["paginacion"]);

$conexion = crearConexionBD();

$query = "SELECT P.OID_P, PRECIO, P.DIRECCION, FECHA, P.OID_C, P.OID_E, P.OID_S, P.OID_F, CORREOELECTRONICO, NOMBREE, TIPOCAMION, TIPOSERVICIO FROM CLIENTES C, PEDIDOS P, EMPLEADOS E, FACTURAS F, SERVICIOS S WHERE CORREOELECTRONICO = '".$correoConsulta."' AND(P.OID_C=C.OID_C AND P.OID_F = F.OID_F AND P.OID_E = E.OID_E AND P.OID_S = S.OID_S) ORDER BY FECHA";

$total_registros= total_consulta($conexion, $query);
$total_paginas = ( $total_registros / $pag_tam );

if ( $total_registros % $pag_tam > 0 )
	$total_paginas++;

if ( $pagina_seleccionada > $total_paginas )
	$pagina_seleccionada = $total_paginas;


$paginacion["PAG_NUM"]=$pagina_seleccionada;
$paginacion["PAG_TAM"]=$pag_tam;
$_SESSION["paginacion"]=$paginacion;

$filas = consulta_paginada($conexion,$query,$pagina_seleccionada,$pag_tam);

cerrarConexionBD($conexion);

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Pedidos por cliente | Hnos. Abreu</title>
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>

<body>

	<?php
	include_once("cabecera.php");
	include_once("login.php");
	?>

	<main>
		<nav>
			<div id="enlaces">
				<?php
				for( $pagina = 1; $pagina <= $total_paginas; $pagina++ ) {
					if ( $pagina == $pagina_seleccionada ) {
						?>
						<span class="current"> <?php echo $pagina; ?></span>
						<?php
					} else {
						?>
						<a href="pedidosPorCliente.php?PAG_NUM= <?php echo $pagina; ?>&PAG_TAM= <?php echo $pag_tam; ?> "> <?php echo $pagina; ?> </a>
						<?php
					}
				}
				?>
			</div>
			
			<form method="get" action="pedidosPorCliente.php">
				<input type="hidden" name="PAG_NUM" id="PAG_NUM" value="<?php echo $pagina_seleccionada;?>" />

				Mostrando <input type="number" name="PAG_TAM" id="PAG_TAM" min="1" max="<?php echo $total_registros;?>" value="<?php echo $pag_tam;?>">
				entradas de <?php echo $total_registros; ?>

				<input type="submit" name="Cambiar">
			</form>
		</nav>

		<?php
		foreach($filas as $fila) {
			?>

			<article class="pedido">
				<form method="post" action="controlador_pedidosPorCliente.php">
					<div class="fila_pedido">
						<table>
							<tr>
								<th>Precio</th>
								<th>Dirección</th>
								<th>Fecha</th>
								<th>Cliente</th>
								<th>Nº Empleado</th>
								<th>Servicio</th>
								<th>Factura</th>
								<th>Correo electrónico</th>
								<th>Nombre empleado</th>
								<th>Tipo de camión</th>
								<th>Tipo de servicio</th>
								<th>Edición</th>
							</tr>

							<tr>
								<div class="datos_pedido"> 											 <!-- CAMBIAR DATOS PARA BORRAR O EDITAR PEDIDO -->		
									<input id="OID_P" name="OID_P"
									type="hidden" value="<?php echo $fila["OID_P"]; ?>"/>
									
									
									<?php
									if (isset($pedido) and ($pedido["OID_P"] == $fila["OID_P"])) { ?>
									<!-- Editando título -->
									<td><h3><input id="PRECIO" name="PRECIO" type="text" value="<?php echo $fila["PRECIO"]; ?>"/></h3></td>
									<td><h3><input id="DIRECCION" name="DIRECCION" type="text" value="<?php echo $fila["DIRECCION"]; ?>"/></h3></td>
									<td><h3><input id="FECHA" name="FECHA" type="text" value="<?php echo $fila["FECHA"]; ?>"/></h3></td>
									<td><h3><input id="OID_C" name="OID_C" type="text" value="<?php echo $fila["OID_C"]; ?>"/></h3></td>
									<td><h3><input id="OID_E" name="OID_E" type="text" value="<?php echo $fila["OID_E"]; ?>"/></h3></td>
									<td><h3><input id="OID_S" name="OID_S" type="text" value="<?php echo $fila["OID_S"]; ?>"/></h3></td>
									<td><h3><input id="OID_F" name="OID_F" type="text" value="<?php echo $fila["OID_F"]; ?>"/></h3></td>
									<td><div class="CORREOELECTRONICO"><b><?php echo $fila["CORREOELECTRONICO"]; ?></b></div></td>
									<td><div class="NOMBREE"><b><?php echo $fila["NOMBREE"]; ?></b></div></td>
									<td><div class="TIPOCAMION"><b><?php echo $fila["TIPOCAMION"]; ?></b></div></td>
									<td><div class="TIPOSERVICIO"><b><?php echo $fila["TIPOSERVICIO"]; ?></b></div></td>
									
									<?php }	else { ?>
						<!-- ejemplo (borrar despues)
						<input id="TITULO" name="TITULO" type="hidden" value="<?php echo $fila["TITULO"]; ?>"/>
						<div class="titulo"><b><?php echo $fila["TITULO"]; ?></b></div>
						<div class="autor">By <em><?php echo $fila["NOMBRE"]." ".$fila["APELLIDOS"]; ?></em></div> -->
						<h3><input type="hidden" id="PRECIO" name="PRECIO" type="text" value="<?php echo $fila["PRECIO"]; ?>"/></h3>
						<h3><input type="hidden" id="DIRECCION" name="DIRECCION" type="text" value="<?php echo $fila["DIRECCION"]; ?>"/></h3>
						<h3><input type="hidden" id="FECHA" name="FECHA" type="text" value="<?php echo $fila["FECHA"]; ?>"/></h3>
						<h3><input type="hidden" id="OID_C" name="OID_C" type="text" value="<?php echo $fila["OID_C"]; ?>"/></h3>
						<h3><input type="hidden" id="OID_E" name="OID_E" type="text" value="<?php echo $fila["OID_E"]; ?>"/></h3>
						<h3><input type="hidden" id="OID_S" name="OID_S" type="text" value="<?php echo $fila["OID_S"]; ?>"/></h3>
						<h3><input type="hidden" id="OID_F" name="OID_F" type="text" value="<?php echo $fila["OID_F"]; ?>"/></h3>
						<td><div class="PRECIO"><b><?php echo $fila["PRECIO"]; ?></b></div></td>
						<td><div class="DIRECCION"><b><?php echo $fila["DIRECCION"]; ?></b></div></td>
						<td><div class="FECHA"><b><?php echo $fila["FECHA"]; ?></b></div></td>
						<td><div class="OID_C"><b><?php echo $fila["OID_C"]; ?></b></div></td>
						<td><div class="OID_E"><b><?php echo $fila["OID_E"]; ?></b></div></td>
						<td><div class="OID_S"><b><?php echo $fila["OID_S"]; ?></b></div></td>
						<td><div class="OID_F"><b><?php echo $fila["OID_F"]; ?></b></div></td>
						<td><div class="CORREOELECTRONICO"><b><?php echo $fila["CORREOELECTRONICO"]; ?></b></div></td>
						<td><div class="NOMBREE"><b><?php echo $fila["NOMBREE"]; ?></b></div></td>
						<td><div class="TIPOCAMION"><b><?php echo $fila["TIPOCAMION"]; ?></b></div></td>
						<td><div class="TIPOSERVICIO"><b><?php echo $fila["TIPOSERVICIO"]; ?></b></div></td>
						<?php } ?>
					</div>
					
					<td>
						<div id="botones_fila">
							<?php if (isset($pedido) and ($pedido["OID_P"] == $fila["OID_P"])) { ?>
							<button id="grabar" name="grabar" type="submit" class="editar_fila">
								<img src="images/bag_menuito.bmp" class="editar_fila" alt="Guardar modificación">
							</button>
							<?php } else {?>
							<button id="editar" name="editar" type="submit" class="editar_fila">
								<img src="images/pencil_menuito.bmp" class="editar_fila" alt="Editar libro">
							</button>
							<?php } ?>
							<button id="borrar" name="borrar" type="submit" class="editar_fila">
								<img src="images/remove_menuito.bmp" class="editar_fila" alt="Borrar libro">
							</button>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</form>
</article>

<?php } ?>
</main>

<?php
include_once("pie.php");
?>

</body>
</html>
