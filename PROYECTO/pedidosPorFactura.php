<?php
session_start();
include_once("gestionBD.php");
include_once("paginacionConsulta.php");


//Comprobamos que somos el administrador y que venimos de una factura
if($_SESSION["exitoLogin"]["usuario"]!= "cubashnosabreu@gmail.com" || !isset($_SESSION["factura"])){ 
	Header("Location: index.php");
}else{

	//Guardamos la factura en una variable local
	if (isset($_SESSION["factura"])){
		$factura = $_SESSION["factura"];
	// unset($_SESSION["factura"]);
	}

	//Guardamos el pedido a editar, si existe, en una variable local
	if (isset($_SESSION["pedido"])){
		$pedido = $_SESSION["pedido"];
		unset($_SESSION["pedido"]);
	}

	 //Guardamos el correo del cliente, si existe, en la variable session
	if (isset($_GET["correoConsultaAdmin"]) && filter_var($_GET["correoConsultaAdmin"], FILTER_VALIDATE_EMAIL)) {
		$_SESSION["correoConsultaAdmin"]= $_GET["correoConsultaAdmin"];
	}

	//Si al editar un pedido se han cometido errores, los guardamos
	if(isset($_SESSION["erroresModificarPedido"]))
		$erroresPedido = $_SESSION["erroresModificarPedido"];


	//$correoConsulta = $_SESSION["correoConsultaAdmin"];

	if(isset($_SESSION["paginacion_pedido"])){
		$paginacion_pedido = $_SESSION["paginacion_pedido"];/* Expresión para iniciar variable de sesión (si es que hay) */

	}

	if (isset($_GET["PAG_TAM"])) {
		$pag_tam=(int)$_GET["PAG_TAM"];
	}else{
		if(isset($_SESSION["paginacion_pedido"])){
			$pag_tam=$_SESSION["paginacion_pedido"]["PAG_TAM"];
		}
		else{
			$pag_tam=4;
		}
	}

	if (isset($_GET["PAG_NUM"])) {
		$pagina_seleccionada=(int)$_GET["PAG_NUM"];
	}else{
		if(isset($_SESSION["paginacion_pedido"])){
			$pagina_seleccionada=$_SESSION["paginacion_pedido"]["PAG_NUM"];
		}
		else{
			$pagina_seleccionada=1;
		}
	}
	
	
	if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
	if ($pag_tam < 1) $pag_tam = 4;

	unset($_SESSION["paginacion_pedido"]);

	$conexion = crearConexionBD();

	$query = "SELECT P.OID_P, PRECIO, P.DIRECCION, FECHA, P.OID_C, P.OID_E, P.OID_S, P.OID_F, CORREOELECTRONICO, NOMBREE, TIPOCAMION, TIPOSERVICIO, DISTANCIAKM, HORASGRUA, TAMAÑOCUBA, PESOKG FROM CLIENTES C, PEDIDOS P, EMPLEADOS E, FACTURAS F, SERVICIOS S WHERE P.OID_F = '".$factura["OID_F"]."' AND(P.OID_C=C.OID_C AND P.OID_F = F.OID_F AND P.OID_E = E.OID_E AND P.OID_S = S.OID_S) ORDER BY FECHA";

	$total_registros= total_consulta($conexion, $query);
	$total_paginas = ( $total_registros / $pag_tam );

	if ( $total_registros % $pag_tam > 0 )
		$total_paginas++;
	
	if ( $pagina_seleccionada > $total_paginas )
		$pagina_seleccionada = $total_paginas;

	
	$paginacion_pedido["PAG_NUM"]=$pagina_seleccionada;
	$paginacion_pedido["PAG_TAM"]=$pag_tam;
	$_SESSION["paginacion_pedido"]=$paginacion_pedido;

	$filas = consulta_paginada($conexion,$query,$pagina_seleccionada,$pag_tam);
	

	cerrarConexionBD($conexion);
}
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

	// Mostrar los erroes de validación (Si los hay)
	if (isset($erroresPedido) && count($erroresPedido)>0) { 
		echo "<div id=\"div_erroresPedido\" class=\"error\">";
		echo "<h4> Errores en el formulario:</h4>";
		foreach($erroresPedido as $error) echo $error; 
		echo "</div>";

    		//Borra los errores una vez que se han mostrado
		$_SESSION["erroresModificarPedido"]=null;
		$erroresPedido=null;
	}

	?>

	<main>

		<h1 class="titulo_pantalla col-10 col-tab-10">Pedidos de la factura nº <?php echo $factura["OID_F"]; ?> (<a href= "<?php echo $_SESSION["urlPedidosFactura"] ?>" >Volver a las facturas</a>) </h1>
		<nav>

			<div class="col-10 col-tab-10" id="enlaces">
				<?php
				for( $pagina = 1; $pagina <= $total_paginas; $pagina++ ) {
					if ( $pagina == $pagina_seleccionada ) {
						?>
						<span class="current pagina_seleccionada"> <?php echo $pagina; ?></span>
						<?php
					} else {
						?>
						<a class="paginas_no_seleccionadas" href="pedidosPorFactura.php?PAG_NUM= <?php echo $pagina; ?>&PAG_TAM= <?php echo $pag_tam; ?> "> <?php echo $pagina; ?> </a>
						<?php
					}
				}
				?>
			</div>
			
			<form class="col-10 col-tab-10" method="get" action="pedidosPorFactura.php">
				<input type="hidden" name="PAG_NUM" id="PAG_NUM" value="<?php echo $pagina_seleccionada;?>" />
				<input type="hidden" name="factura" id="factura" value="<?php echo $factura;?>" />

				Mostrando <input type="number" name="PAG_TAM" id="PAG_TAM" min="1" max="<?php echo $total_registros;?>" value="<?php echo $pag_tam;?>">
				entradas de <?php echo $total_registros; ?>

				<input type="submit" name="Cambiar">
			</form>
		</nav>

		

		
		<div style="overflow-x:auto" class="col-10 col-tab-10">
			<table>
				<tr>
					
					<th>Tipo de servicio</th>
					<th>Distancia(KM)</th>
					<th>Tamaño cuba</th>
					<th>Peso(KG)</th>
					<th>Horas</th>
					<th>Dirección</th>
					<th>Fecha</th>
					<th>Precio</th>
					<th>Nombre empleado</th>
					<th>Tipo de camión</th>
					<th>Correo electrónico</th>
					<th>Opciones</th>
				</tr>

				<?php
				foreach($filas as $fila) {

					?>
					<article class="pedidos">
						<form method="post" action="controlador_pedidosPorFactura.php" >
							<div>
								<tr>
									<div class="datos_pedido"> 											 <!-- CAMBIAR DATOS PARA BORRAR O EDITAR PEDIDO -->		
										<input id="OID_P" name="OID_P"
										type="hidden" value="<?php echo $fila["OID_P"]; ?>"/>
										
										
										<?php
										if (isset($pedido) and ($pedido["OID_P"] == $fila["OID_P"])) { ?>
										<!-- Editando pedido -->
										<h3><input type="hidden" id="OID_C" name="OID_C" type="text" value="<?php echo $fila["OID_C"]; ?>"/></h3>
										<h3><input type="hidden" id="OID_E" name="OID_E" type="text" value="<?php echo $fila["OID_E"]; ?>"/></h3>
										<h3><input type="hidden" id="OID_S" name="OID_S" type="text" value="<?php echo $fila["OID_S"]; ?>"/></h3>
										<h3><input type="hidden" id="OID_F" name="OID_F" type="text" value="<?php echo $fila["OID_F"]; ?>"/></h3>


										<td><div class="TIPOSERVICIO"><b><?php echo $fila["TIPOSERVICIO"]; ?></b></div></td>
										<td><div class="DISTANCIAKM"><b><?php echo $fila["DISTANCIAKM"]; ?></b></div></td>
										<td><div class="TAMAÑOCUBA"><b><?php echo $fila["TAMAÑOCUBA"]; ?></b></div></td>
										<td><div class="PESOKG"><b><?php echo $fila["PESOKG"]; ?></b></div></td>
										<td><div class="HORASGRUA"><b><?php echo $fila["HORASGRUA"]; ?></b></div></td>
										<td><h3><input id="DIRECCION" name="DIRECCION" type="text" value="<?php echo $fila["DIRECCION"]; ?>" required/></h3></td>
										<td><h3><input id="FECHA" name="FECHA" type="text" min="2000-01-01" max="2099-12-31" value="<?php echo $fila["FECHA"]; ?>" required/></h3></td>
										<td><h3><input id="PRECIO" name="PRECIO" type="number" min=1 max=9999 value="<?php echo $fila["PRECIO"]; ?>" required/></h3></td>
										
										
										<td><div class="NOMBREE"><b><?php echo $fila["NOMBREE"]; ?></b></div></td>
										<td><div class="TIPOCAMION"><b><?php echo $fila["TIPOCAMION"]; ?></b></div></td>
										<td><div class="CORREOELECTRONICO"><b><?php echo $fila["CORREOELECTRONICO"]; ?></b></div></td>
										
										
										<?php }	else { ?>
										
										<h3><input type="hidden" id="PRECIO" name="PRECIO" type="text" value="<?php echo $fila["PRECIO"]; ?>"/></h3>
										<h3><input type="hidden" id="DIRECCION" name="DIRECCION" type="text" value="<?php echo $fila["DIRECCION"]; ?>"/></h3>
										<h3><input type="hidden" id="FECHA" name="FECHA" type="text" value="<?php echo $fila["FECHA"]; ?>"/></h3>
										<h3><input type="hidden" id="OID_C" name="OID_C" type="text" value="<?php echo $fila["OID_C"]; ?>"/></h3>
										<h3><input type="hidden" id="OID_E" name="OID_E" type="text" value="<?php echo $fila["OID_E"]; ?>"/></h3>
										<h3><input type="hidden" id="OID_S" name="OID_S" type="text" value="<?php echo $fila["OID_S"]; ?>"/></h3>
										<h3><input type="hidden" id="OID_F" name="OID_F" type="text" value="<?php echo $fila["OID_F"]; ?>"/></h3>
										
										<td><div class="TIPOSERVICIO"><b><?php echo $fila["TIPOSERVICIO"]; ?></b></div></td>

										<td><div class="DISTANCIAKM"><b><?php echo $fila["DISTANCIAKM"]; ?></b></div></td>
										<td><div class="TAMAÑOCUBA"><b><?php echo $fila["TAMAÑOCUBA"]; ?></b></div></td>
										<td><div class="PESOKG"><b><?php echo $fila["PESOKG"]; ?></b></div></td>
										<td><div class="HORASGRUA"><b><?php echo $fila["HORASGRUA"]; ?></b></div></td>

										<td><div class="DIRECCION"><b><?php echo $fila["DIRECCION"]; ?></b></div></td>
										<td><div class="FECHA"><b><?php echo $fila["FECHA"]; ?></b></div></td>
										<td><div class="PRECIO"><b><?php echo $fila["PRECIO"]; ?></b></div></td>
										<td><div class="NOMBREE"><b><?php echo $fila["NOMBREE"]; ?></b></div></td>
										<td><div class="TIPOCAMION"><b><?php echo $fila["TIPOCAMION"]; ?></b></div></td>
										<td><div class="CORREOELECTRONICO"><b><?php echo $fila["CORREOELECTRONICO"]; ?></b></div></td>
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
							</div>
						</form>
						<?php } ?>
					</table>
				</div>
			</article>

			
		</main>

		<?php
		include_once("pie.php");
		?>

	</body>
	</html>
