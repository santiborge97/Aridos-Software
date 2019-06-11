<?php
session_start();
require_once("gestionBD.php");
require_once("paginacionConsulta.php");

if(isset($_SESSION["paginacion_pedido"])){
	unset($_SESSION["paginacion_pedido"]);
}


if($_SESSION["exitoLogin"]["usuario"]!= "cubashnosabreu@gmail.com" || !isset($_GET["correoConsultaAdmin"])){ 
	Header("Location: index.php");
}else{

	if (isset($_SESSION["factura"])){
		$factura = $_SESSION["factura"];
		unset($_SESSION["factura"]);
	}

	$_SESSION["correoConsultaAdmin"]= $_GET["correoConsultaAdmin"];

	$_SESSION["urlPedidosFactura"]=$_SERVER["REQUEST_URI"];

	$correoConsulta = $_SESSION["correoConsultaAdmin"];

	if(isset($_SESSION["paginacion_facturas_cliente"])){
		$paginacion_facturas_cliente = $_SESSION["paginacion_facturas_cliente"];/* Expresión para iniciar variable de sesión (si es que hay) */

	}

	if (isset($_GET["PAG_TAM"])) {
		$pag_tam=(int)$_GET["PAG_TAM"];
	}else{
		if(isset($_SESSION["paginacion_facturas_cliente"])){
			$pag_tam=$_SESSION["paginacion_facturas_cliente"]["PAG_TAM"];
		}
		else{
			$pag_tam=4;
		}
	}

	if (isset($_GET["PAG_NUM"])) {
		$pagina_seleccionada=(int)$_GET["PAG_NUM"];
	}else{
		if(isset($_SESSION["paginacion_facturas_cliente"])){
			$pagina_seleccionada=$_SESSION["paginacion_facturas_cliente"]["PAG_NUM"];
		}
		else{
			$pagina_seleccionada=1;
		}
	}

	
	if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
	if ($pag_tam < 1) $pag_tam = 4;

	unset($_SESSION["paginacion_facturas_cliente"]);

	$conexion = crearConexionBD();

	$query = "SELECT DISTINCT F.OID_F, F.FECHAEMISION, F.NUMPEDIDOS, F.PRECIOSINIVA, F.PRECIOTOTAL, F.ESTAPAGADO, F.FECHACREACION FROM CLIENTES C, PEDIDOS P, EMPLEADOS E, FACTURAS F, SERVICIOS S WHERE C.CORREOELECTRONICO = '".$correoConsulta."' AND(P.OID_C=C.OID_C AND P.OID_F = F.OID_F AND P.OID_E = E.OID_E AND P.OID_S = S.OID_S) ORDER BY FECHAEMISION DESC";

	$total_registros= total_consulta($conexion, $query);
	$total_paginas = ( $total_registros / $pag_tam );

	if ( $total_registros % $pag_tam > 0 )
		$total_paginas++;
	
	if ( $pagina_seleccionada > $total_paginas )
		$pagina_seleccionada = $total_paginas;

	
	$paginacion_facturas_cliente["PAG_NUM"]=$pagina_seleccionada;
	$paginacion_facturas_cliente["PAG_TAM"]=$pag_tam;
	$_SESSION["paginacion_facturas_cliente"]=$paginacion_facturas_cliente;

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
	?>

	<main>
		<h1 class="titulo_pantalla col-10 col-tab-10">Facturas de <?php echo $correoConsulta; ?></h1>
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
						<a class="paginas_no_seleccionadas" href="facturasPorCliente.php?correoConsultaAdmin=<?php echo $_GET["correoConsultaAdmin"]; ?>&PAG_NUM= <?php echo $pagina; ?>&PAG_TAM= <?php echo $pag_tam; ?> "> <?php echo $pagina; ?> </a>
						<?php
					}
				}
				?>
			</div>
			
			<form class="col-10 col-tab-10" method="get" action="facturasPorCliente.php">
				<input type="hidden" name="PAG_NUM" id="PAG_NUM" value="<?php echo $pagina_seleccionada;?>" />
				<input type="hidden" name="correoConsultaAdmin" id="correoConsultaAdmin" value="<?php echo $_GET["correoConsultaAdmin"];?>" />

				Mostrando <input type="number" name="PAG_TAM" id="PAG_TAM" min="1" max="<?php echo $total_registros;?>" value="<?php echo $pag_tam;?>">
				entradas de <?php echo $total_registros; ?>

				<input type="submit" value="Cambiar">
			</form>
		</nav>

		<div style="overflow-x:auto" class="col-10 col-tab-10">
			<table>
				<tr>
					<th>Fecha emisión</th>
					<th>Nº pedidos</th>
					<th>Precio sin IVA</th>
					<th>Precio total</th>
					<th>¿Pagado?</th>
					<th>Fecha creación</th>
					<th>Opciones</th>
				</tr>

				<?php
				foreach($filas as $fila) {
					?>

					<article class="facturas">
						<form method="post" action="controlador_facturas.php">
							<div class="fila_factura">
								

								<tr>
									<div class="datos_factura">  <!-- CAMBIAR DATOS PARA BORRAR O EDITAR PEDIDO -->		
										<input id="OID_F" name="OID_F"
										type="hidden" value="<?php echo $fila["OID_F"]; ?>"/>				
										<td><div class="FECHAEMISION"><b><?php echo $fila["FECHAEMISION"]; ?></b></div></td>
										<td><div class="NUMPEDIDOS"><b><?php echo $fila["NUMPEDIDOS"]; ?></b></div></td>
										<td><div class="PRECIOSINIVA"><b><?php echo $fila["PRECIOSINIVA"]; ?></b></div></td>
										<td><div class="PRECIOTOTAL"><b><?php echo $fila["PRECIOTOTAL"]; ?></b></div></td>
										<td><div class="ESTAPAGADO"><b><?php echo $fila["ESTAPAGADO"]; ?></b></div></td>
										<td><div class="FECHACREACION"><b><?php echo $fila["FECHACREACION"]; ?></b></div></td>
									</div>
									
									<td>
										<div id="botones_fila">
											<button id="desglose" name="desglose" type="submit" class="desglose">
												<img src="images/desglose.png" class="desglose" alt="desglose factura" width="25px" height="25px">
											</button>
											
											<?php
											if($fila["ESTAPAGADO"]=='NO'){
												?>
												<button id="pagado" name="pagado" type="submit" class="pagado">
													<img src="images/icono_tick.jpg" class="editar_fila" alt="Pagar factura" width="25px" height="25px">
												</button>
												<?php
											}
											?>

										</div>
									</td>
								</tr>
								

							</div>

						</form>
						<?php
					}
					?>
				</table>
			</div>


		</article>
		

	</main>

	<?php
	include_once("pie.php");
	?>

</body>
</html>
