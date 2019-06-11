<?php
session_start();
include_once("gestionBD.php");
include_once("paginacionConsulta.php");

if(isset($_SESSION["paginacion_pedido"])){
	unset($_SESSION["paginacion_pedido"]);
}

//Comprobamos que somos administrador
if($_SESSION["exitoLogin"]["usuario"]!= "cubashnosabreu@gmail.com"){ 
	Header("Location: index.php");
} else{



//Variable factura que significa que venimos del controlador_facturas
	if (isset($_SESSION["factura"])){
		$factura = $_SESSION["factura"];
		unset($_SESSION["factura"]);
	}


	$_SESSION["urlPedidosFactura"]=$_SERVER["REQUEST_URI"];


//Tema de paginación
	if(isset($_SESSION["paginacion_facturas"])){
		$paginacion_facturas = $_SESSION["paginacion_facturas"];/* Expresión para iniciar variable de sesión (si es que hay) */
	}

	if (isset($_GET["PAG_TAM"])) {
		$pag_tam=(int)$_GET["PAG_TAM"];
	}else{
		if(isset($_SESSION["paginacion_facturas"])){
			$pag_tam=$_SESSION["paginacion_facturas"]["PAG_TAM"];
		}
		else{
			$pag_tam=4;
		}
	}

	if (isset($_GET["PAG_NUM"])) {
		$pagina_seleccionada=(int)$_GET["PAG_NUM"];
	}else{
		if(isset($_SESSION["paginacion_facturas"])){
			$pagina_seleccionada=$_SESSION["paginacion_facturas"]["PAG_NUM"];
		}
		else{
			$pagina_seleccionada=1;
		}
	}

	
	
	if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
	if ($pag_tam < 1) $pag_tam = 4;

	unset($_SESSION["paginacion_facturas"]);

	$conexion = crearConexionBD();

	if(isset($_REQUEST["FECHAINICIAL"]) && isset($_REQUEST["FECHAFINAL"]) && $_REQUEST["FECHAINICIAL"]!=null && $_REQUEST["FECHAFINAL"]!=null && $_REQUEST["FECHAINICIAL"]!="" && $_REQUEST["FECHAFINAL"]!=""){
		$fechasFactura["fechaInicial"]=$_REQUEST["FECHAINICIAL"];
		$fechasFactura["fechaFinal"]=$_REQUEST["FECHAFINAL"];

		$erroresFactura=validarDatosFactura($fechasFactura);

		if(count($erroresFactura)==1){
			
			$fechaInicial=strtotime('+ 0 day',strtotime($_REQUEST["FECHAINICIAL"]));
			$fechaInicial=date('d/m/y',$fechaInicial);
			$fechaFinal=strtotime('+ 0 day',strtotime($_REQUEST["FECHAFINAL"]));
			$fechaFinal=date('d/m/y',$fechaFinal);

			$query='SELECT DISTINCT F.OID_F, FECHAEMISION, NUMPEDIDOS, PRECIOSINIVA, PRECIOTOTAL, ESTAPAGADO, FECHACREACION, CORREOELECTRONICO
			FROM FACTURAS F, CLIENTES C, PEDIDOS P 
			WHERE (P.OID_C = C.OID_C AND P.OID_F = F.OID_F) AND (FECHACREACION BETWEEN to_date(\''.$fechaInicial.'\',\'DD/MM/YY\') AND to_date(\''.$fechaFinal.'\',\'DD/MM/YY\'))
			ORDER BY ESTAPAGADO, CORREOELECTRONICO, FECHACREACION';
		} else{
			$fechasFactura["fechaInicial"]="";
			$fechasFactura["fechaFinal"]="";
			$query = "SELECT DISTINCT F.OID_F, FECHAEMISION, NUMPEDIDOS, PRECIOSINIVA, PRECIOTOTAL, ESTAPAGADO, FECHACREACION, CORREOELECTRONICO
			FROM FACTURAS F, CLIENTES C, PEDIDOS P WHERE (P.OID_C = C.OID_C AND P.OID_F = F.OID_F) ORDER BY ESTAPAGADO, CORREOELECTRONICO, FECHACREACION";
		}
	}else{
		$fechasFactura["fechaInicial"]="";
		$fechasFactura["fechaFinal"]="";
		$query = "SELECT DISTINCT F.OID_F, FECHAEMISION, NUMPEDIDOS, PRECIOSINIVA, PRECIOTOTAL, ESTAPAGADO, FECHACREACION, CORREOELECTRONICO
		FROM FACTURAS F, CLIENTES C, PEDIDOS P WHERE (P.OID_C = C.OID_C AND P.OID_F = F.OID_F) ORDER BY ESTAPAGADO, CORREOELECTRONICO, FECHACREACION";
	}

	

	$total_registros= total_consulta($conexion, $query);
	$total_paginas = ( $total_registros / $pag_tam );

	if ( $total_registros % $pag_tam > 0 )
		$total_paginas++;
	
	if ( $pagina_seleccionada > $total_paginas )
		$pagina_seleccionada = $total_paginas;

	
	$paginacion_facturas["PAG_NUM"]=$pagina_seleccionada;
	$paginacion_facturas["PAG_TAM"]=$pag_tam;
	$_SESSION["paginacion_facturas"]=$paginacion_facturas;

	$filas = consulta_paginada($conexion,$query,$pagina_seleccionada,$pag_tam);
	
	cerrarConexionBD($conexion);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Facturas | Hnos. Abreu</title>
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>

<body>

	<?php
	include_once("cabecera.php");
	include_once("login.php");
	?>
	<?php
	// Mostrar los erroes de validación (Si los hay)
	if (isset($erroresFactura) && count($erroresFactura)>1) { 
		echo "<div id=\"div_erroresFactura\" class=\"error\">";
		echo "<h4> Errores en el formulario:</h4>";
		foreach($erroresFactura as $error) echo $error; 
		echo "</div>";

    		//Borra los errores una vez que se han mostrado
		$_SESSION["erroresFactura"]=null;
		$erroresFactura=null;
	}

	?>

	<main>
		<h1 class="titulo_pantalla col-10 col-tab-10">Facturas</h1>
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
						<a class="paginas_no_seleccionadas" href="facturas.php?PAG_NUM= <?php echo $pagina; ?>&PAG_TAM= <?php echo $pag_tam; ?>&FECHAINICIAL=<?php echo $fechasFactura["fechaInicial"]; ?>&FECHAFINAL=<?php echo $fechasFactura["fechaFinal"]; ?>"> <?php echo $pagina; ?> </a>
						<?php
					}
				}
				?>
			</div>
			
			<form class="col-10 col-tab-10" method="get" action="facturas.php">
				<input type="hidden" name="PAG_NUM" id="PAG_NUM" value="<?php echo $pagina_seleccionada;?>" />
				<input type="hidden" name="FECHAINICIAL" id="FECHAINICIAL" value="<?php echo $fechasFactura["fechaInicial"];?>" />
				<input type="hidden" name="FECHAFINAL" id="FECHAFINAL" value="<?php echo $fechasFactura["fechaFinal"];?>" />

				Mostrando <input type="number" name="PAG_TAM" id="PAG_TAM" min="1" max="<?php echo $total_registros;?>" value="<?php echo $pag_tam;?>">
				entradas de <?php echo $total_registros; ?>

				<input type="submit" name="Cambiar">
			</form>
		</nav>
		<div class="col-10">
			<form method="get" action="facturas.php">
				<h class="col-tab-10">Fecha Inicial: <input type="date" name="FECHAINICIAL" min="2000-01-01" max="2099-12-31" required></h>
				<h class="col-tab-10">Fecha Final:  <input type="date" name="FECHAFINAL" min="2000-01-01" max="2099-12-31" required></h>
				<input clas="col-tab-10" type="submit" value="Consultar Facturas"><div class="warning">Debe introducir fechas completas, en caso contrario se mostrarán todas las facturas.</div>
			</form>
		</div>

		<div style="overflow-x:auto" class="col-10 col-tab-10">
			<table>
				<tr>
					<th>Nº Factura</th>
					<th>Fecha de emisión</th>
					<th>Número de pedidos</th>
					<th>Precio (Sin IVA)</th>
					<th>Precio (Con IVA)</th>
					<th>Pagada</th>
					<th>Fecha de creación</th>
					<th>Correo electrónico de cliente</th>
					<th>Opciones</th>
				</tr>
				<?php
				foreach($filas as $fila) {
					?>

					<article class="facturas">
						<form method="post" action="controlador_facturas.php">
							<div class="fila_factura">
								

								<tr>
									<div class="datos_factura"> 											 <!-- CAMBIAR DATOS PARA BORRAR O EDITAR PEDIDO -->		
										<input id="OID_F" name="OID_F" type="hidden" value="<?php echo $fila["OID_F"]; ?>"/>
										<td><div class="OID_F"><b><?php echo $fila["OID_F"]; ?></b></div></td>
										<td><div class="FECHAEMISION"><b><?php echo $fila["FECHAEMISION"]; ?></b></div></td>
										<td><div class="NUMPEDIDOS"><b><?php echo $fila["NUMPEDIDOS"]; ?></b></div></td>
										<td><div class="PRECIOSINIVA"><b><?php echo $fila["PRECIOSINIVA"]; ?></b></div></td>
										<td><div class="PRECIOTOTAL"><b><?php echo $fila["PRECIOTOTAL"]; ?></b></div></td>
										<td><div class="ESTAPAGADO"><b><?php echo $fila["ESTAPAGADO"]; ?></b></div></td>
										<td><div class="FECHACREACION"><b><?php echo $fila["FECHACREACION"]; ?></b></div></td>
										<td><div class="CORREOELECTRONICO"><b><?php echo $fila["CORREOELECTRONICO"]; ?></b></div></td>
										
									</div>
									
									<td>
										<div id="botones_fila">
											<button id="desglose" name="desglose" type="submit" class="desglose">
												<img src="images/desglose.png" class="desglose" alt="desglose factura"  width="25px" height="25px">
											</button>
											
											<?php
											if($fila["ESTAPAGADO"]=='NO'){
												?>
												<button id="pagado" name="pagado" type="submit" class="pagado">
													<img src="images/icono_tick.jpg" class="editar_fila" alt="Pagar factura"  width="25px" height="25px">
												</button>
												<?php
											}
											?>
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

	<!--/////////////////////////////////////////////////// FUNCION DE VALIDACION////////////////////////////////////////////////////////// -->

	<?php 
	function validarDatosFactura($datosFactura){

		$erroresFactura[] = "";

		if($datosFactura["fechaInicial"] >= $datosFactura["fechaFinal"] && ($datosFactura["fechaInicial"]!="" || $datosFactura["fechaInicial"]!=null) && ($datosFactura["fechaFinal"]!="" || $datosFactura["fechaFinal"]!=null)){
			$erroresFactura[] = "<p>La fecha inicial no puede ser igual o posterior a la final</p>";
		}

		$fechaMax = "2099-12-31";
		$fechaMin = "2000-01-01";

		if($datosFactura["fechaInicial"] < $fechaMin && ($datosFactura["fechaInicial"]!="" || $datosFactura["fechaInicial"]!=null)){
			$erroresFactura[] = "<p>La fecha inicial no puede ser anterior al 01/01/2000</p>";
		}

		if($datosFactura["fechaFinal"] < $fechaMin && ($datosFactura["fechaFinal"]!="" || $datosFactura["fechaFinal"]!=null)){
			$erroresFactura[] = "<p>La fecha final no puede ser anterior al 01/01/2000</p>";
		}

		if($datosFactura["fechaInicial"] > $fechaMax && ($datosFactura["fechaInicial"]!="" || $datosFactura["fechaInicial"]!=null)){
			$erroresFactura[] = "<p>La fecha inicial no puede ser posterior al 31/12/2099</p>";
		}

		if($datosFactura["fechaFinal"] > $fechaMax && ($datosFactura["fechaFinal"]!="" || $datosFactura["fechaFinal"]!=null)){
			$erroresFactura[] = "<p>La fecha final no puede ser posterior al 31/12/2099</p>";
		}

		if($datosFactura["fechaInicial"]=="" || $datosFactura["fechaInicial"]==null){
			$erroresFactura[] = "<p>La fecha inicial no puede estar vacía o ser nula</p>";
		}

		if($datosFactura["fechaFinal"]=="" || $datosFactura["fechaFinal"]==null){
			$erroresFactura[] = "<p>La fecha final no puede estar vacía o ser nula</p>";
		}

		return $erroresFactura;
	}
	?>
