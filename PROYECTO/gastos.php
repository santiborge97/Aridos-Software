<?php
session_start();
include_once("gestionBD.php");
include_once("paginacionConsulta.php");

	//Comprobamos que somos el administrador
if($_SESSION["exitoLogin"]["usuario"]!= "cubashnosabreu@gmail.com" ){ 
	Header("Location: index.php");
} else{

	//Comprobacion para la paginacion
	if(isset($_SESSION["paginacion_gastos"])){
		$paginacion_gastos = $_SESSION["paginacion_gastos"];/* Expresión para iniciar variable de sesión (si es que hay) */
	}

	if (isset($_GET["PAG_TAM"])) {
		$pag_tam=(int)$_GET["PAG_TAM"];
	}else{
		if(isset($_SESSION["paginacion_gastos"])){
			$pag_tam=$_SESSION["paginacion_gastos"]["PAG_TAM"];
		}
		else{
			$pag_tam=4;
		}
	}

	if (isset($_GET["PAG_NUM"])) {
		$pagina_seleccionada=(int)$_GET["PAG_NUM"];
	}else{
		if(isset($_SESSION["paginacion_gastos"])){
			$pagina_seleccionada=$_SESSION["paginacion_gastos"]["PAG_NUM"];
		}
		else{
			$pagina_seleccionada=1;
		}
	}


	
	
	if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
	if ($pag_tam < 1) $pag_tam = 4;

	unset($_SESSION["paginacion_gastos"]);

	$conexion = crearConexionBD();


	$query = "SELECT * FROM GASTOS ORDER BY FECHAPAGO DESC";

	$total_registros= total_consulta($conexion, $query);
	$total_paginas = ( $total_registros / $pag_tam );

	if ( $total_registros % $pag_tam > 0 )
		$total_paginas++;
	
	if ( $pagina_seleccionada > $total_paginas )
		$pagina_seleccionada = $total_paginas;

	
	$paginacion_gastos["PAG_NUM"]=$pagina_seleccionada;
	$paginacion_gastos["PAG_TAM"]=$pag_tam;
	$_SESSION["paginacion_gastos"]=$paginacion_gastos;

	$filas = consulta_paginada($conexion,$query,$pagina_seleccionada,$pag_tam);
	
	cerrarConexionBD($conexion);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Gastos | Hnos. Abreu</title>
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>

<body>

	<?php
	include_once("cabecera.php");
	include_once("login.php");
	?>

	<main>
		<h1 class="titulo_pantalla col-10 col-tab-10">Gastos</h1>

		<!-- ERRORES !-->
		<?php
		if (isset($_SESSION["erroresAñadirGasto"]) && count($_SESSION["erroresAñadirGasto"])>0) { 
			$erroresAñadirGasto=$_SESSION["erroresAñadirGasto"];
			echo "<div id=\"div_erroresAñadirGasto\" class=\"error\">";
			echo "<h4> Errores en el formulario:</h4>";
			foreach($erroresAñadirGasto as $error) echo $error; 
			echo "</div>";

    		//Borra los errores una vez que se han mostrado
    		//UNSET O PONER A NULL?
			$_SESSION["erroresAñadirGasto"]=null;
			$erroresAñadirGasto=null;
		} ?>

		<div>
			<form class="col-10 col-tab-10 " method="post" action="controlador_gastos.php">
				<fieldset class="formulario_gastos">
					<legend >
						Añadir nuevo gasto
					</legend>
					Nombre: <input  type="text" name="NOMBRE" required><br>
					Descripcion:  <input type="text" name="DESCRIPCION" required><br>
					Coste: <input type="number" name="COSTE" min="1" required><br>
					Fecha de pago: <input type="date" name="FECHAPAGO" min="2000-01-01" max="2099-12-31" required><br>
					Fecha de inicio: <input type="date" name="FECHAINICIO" min="2000-01-01" max="2099-12-31" required><br>
					Fecha de fin: <input type="date" name="FECHAFIN" min="2000-01-01" max="2099-12-31" required><br>
					<input type="submit" value="Añadir Gasto">
				</fieldset>
			</form>
		</div>
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
						<a class="paginas_no_seleccionadas" href="gastos.php?PAG_NUM= <?php echo $pagina; ?>&PAG_TAM= <?php echo $pag_tam; ?> "> <?php echo $pagina; ?> </a>
						<?php
					}
				}
				?>
			</div>
			
			<form class="col-10 col-tab-10" method="get" action="gastos.php">
				<input type="hidden" name="PAG_NUM" id="PAG_NUM" value="<?php echo $pagina_seleccionada;?>" />

				Mostrando <input type="number" name="PAG_TAM" id="PAG_TAM" min="1" max="<?php echo $total_registros;?>" value="<?php echo $pag_tam;?>">
				entradas de <?php echo $total_registros; ?>

				<input type="submit" name="Cambiar">
			</form>
		</nav>

		

		
		
		<div style="overflow-x:auto" class="col-10 col-tab-10">
			<table>
				<tr>
					<th>Nombre</th>
					<th>Descripción</th>
					<th>Coste</th>
					<th>IVA</th>
					<th>Fecha de pago</th>
					<th>Fecha de inicio</th>
					<th>Fecha de fin</th>
					<th>Opciones</th>
				</tr>


				<?php
				foreach($filas as $fila) {
					?>
					<article class="gasto">
						<form method="post" action="accion_borrar_gasto.php">
							<div id="fila_gastos">
								<tr>
									<div class="datos_gasto"> 											 <!-- CAMBIAR DATOS PARA BORRAR  PEDIDO -->		
										<input id="OID_G" name="OID_G"
										type="hidden" value="<?php echo $fila["OID_G"]; ?>"/>
										
										
						<!-- ejemplo (borrar despues)
						<input id="TITULO" name="TITULO" type="hidden" value="<?php echo $fila["TITULO"]; ?>"/>
						<div class="titulo"><b><?php echo $fila["TITULO"]; ?></b></div>
						<div class="autor">By <em><?php echo $fila["NOMBRE"]." ".$fila["APELLIDOS"]; ?></em></div> -->
						<h3><input type="hidden" id="NOMBRE" name="NOMBRE" type="text" value="<?php echo $fila["NOMBRE"]; ?>"/></h3>
						<h3><input type="hidden" id="DESCRIPCION" name="DESCRIPCION" type="text" value="<?php echo $fila["DESCRIPCION"]; ?>"/></h3>
						<h3><input type="hidden" id="COSTE" name="COSTE" type="text" value="<?php echo $fila["COSTE"]; ?>"/></h3>
						<h3><input type="hidden" id="IVA" name="IVA" type="text" value="<?php echo $fila["IVA"]; ?>"/></h3>
						<h3><input type="hidden" id="FECHAPAGO" name="FECHAPAGO" type="text" value="<?php echo $fila["FECHAPAGO"]; ?>"/></h3>
						<h3><input type="hidden" id="FECHAINICIO" name="FECHAINICIO" type="text" value="<?php echo $fila["FECHAINICIO"]; ?>"/></h3>
						<h3><input type="hidden" id="FECHAFIN" name="FECHAFIN" type="text" value="<?php echo $fila["FECHAFIN"]; ?>"/></h3>
						
						<td><b><?php echo $fila["NOMBRE"]; ?></b></td>
						<td><b><?php echo $fila["DESCRIPCION"]; ?></b></td>
						<td><b><?php echo $fila["COSTE"]; ?></b></td>
						<td><b><?php echo $fila["IVA"]; ?></b></td>
						<td><b><?php echo $fila["FECHAPAGO"]; ?></b></td>
						<td><b><?php echo $fila["FECHAINICIO"]; ?></b></td>
						<td><b><?php echo $fila["FECHAFIN"]; ?></b></td>
					</div>
					
					
					
					<td>
						<div id="botones_fila">
							<button id="borrar" name="borrar" type="submit" class="borrar_fila">
								<img src="images/remove_menuito.bmp" class="borrar_fila" alt="Borrar gasto">
							</button>
						</div>
					</td>
				</tr>
			</div>
		</form>
		
		<?php   } ?>
	</table>

</div>

</article>


</main>

<?php
include_once("pie.php");
?>

</body>
</html>

