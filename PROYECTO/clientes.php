<?php
session_start();
include_once("gestionBD.php");
include_once("paginacionConsulta.php");

if($_SESSION["exitoLogin"]["usuario"]!= "cubashnosabreu@gmail.com" ){ 
	Header("Location: index.php");
}else{
	if (isset($_SESSION["cliente"])){
		$cliente = $_SESSION["cliente"];
		unset($_SESSION["cliente"]);
	}

	if(isset($_SESSION["paginacion_clientes"])){
		$paginacion_clientes = $_SESSION["paginacion_clientes"];/* Expresión para iniciar variable de sesión (si es que hay) */

	}

	if (isset($_GET["PAG_TAM"])) {
		$pag_tam=(int)$_GET["PAG_TAM"];
	}else{
		if(isset($_SESSION["paginacion_clientes"])){
			$pag_tam=$_SESSION["paginacion_clientes"]["PAG_TAM"];
		}
		else{
			$pag_tam=4;
		}
	}

	if (isset($_GET["PAG_NUM"])) {
		$pagina_seleccionada=(int)$_GET["PAG_NUM"];
	}else{
		if(isset($_SESSION["paginacion_clientes"])){
			$pagina_seleccionada=$_SESSION["paginacion_clientes"]["PAG_NUM"];
		}
		else{
			$pagina_seleccionada=1;
		}
	}
	
	
	if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
	if ($pag_tam < 1) $pag_tam = 4;

	unset($_SESSION["paginacion_clientes"]);

	$conexion = crearConexionBD();

	$query = "SELECT * FROM CLIENTES WHERE CORREOELECTRONICO != 'cubashnosabreu@gmail.com' ORDER BY NOMBRE";

	$total_registros= total_consulta($conexion, $query);
	$total_paginas = ( $total_registros / $pag_tam );

	if ( $total_registros % $pag_tam > 0 )
		$total_paginas++;
	
	if ( $pagina_seleccionada > $total_paginas )
		$pagina_seleccionada = $total_paginas;

	
	$paginacion_clientes["PAG_NUM"]=$pagina_seleccionada;
	$paginacion_clientes["PAG_TAM"]=$pag_tam;
	$_SESSION["paginacion_clientes"]=$paginacion_clientes;

	$filas = consulta_paginada($conexion,$query,$pagina_seleccionada,$pag_tam);
	
	cerrarConexionBD($conexion);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Clientes | Hnos. Abreu</title>
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>

<body>

	<?php
	include_once("cabecera.php");	include_once("login.php");
	?>

	<main>
		<h1 class="titulo_pantalla col-10 col-tab-10">Clientes</h1>

		<!-- ERRORES !-->
		<?php
		if (isset($_SESSION["erroresAñadirCliente"]) && count($_SESSION["erroresAñadirCliente"])>0) { 
			$erroresAñadirCliente=$_SESSION["erroresAñadirCliente"];
			echo "<div id=\"div_erroresAñadirCliente\" class=\"error\">";
			echo "<h4> Errores en el formulario:</h4>";
			foreach($erroresAñadirCliente as $error) echo $error; 
			echo "</div>";

			
			$_SESSION["erroresAñadirCliente"]=null;
			$erroresAñadirCliente=null;
			
		} else if (isset($_SESSION["erroresModificarCliente"]) && count($_SESSION["erroresModificarCliente"])>0) { 
			$erroresModificarCliente=$_SESSION["erroresModificarCliente"];
			echo "<div id=\"div_erroresModificarCliente\" class=\"error\">";
			echo "<h4> Errores en el formulario:</h4>";
			foreach($erroresModificarCliente as $error) echo $error; 
			echo "</div>";

			
			$_SESSION["erroresModificarCliente"]=null;
			$erroresModificarCliente=null;
		} ?>

		<div>
			<form class="col-10 col-tab-10 " method="post" action="controlador_nuevo_cliente.php">
				<fieldset class="formulario_clientes">
					<legend >
						Añadir nuevo cliente
					</legend>
					Nombre: <input  type="text" name="NOMBRE" required><br>
					Dirección: <input  type="text" name="DIRECCION" required><br>
					Teléfono:<input  type="text" name="TELEFONO" pattern="[0-9]{9}" required><br>
					Correo Electrónico: <input  type="email" name="CORREOELECTRONICO" required><br>
					<input type="submit" value="Añadir Cliente">
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
						<a class="paginas_no_seleccionadas" href="clientes.php?PAG_NUM= <?php echo $pagina; ?>&PAG_TAM= <?php echo $pag_tam; ?> "> <?php echo $pagina; ?> </a>
						<?php
					}
				}
				?>
			</div>
			
			<form class="col-10 col-tab-10" method="get" action="clientes.php">
				<input type="hidden" name="PAG_NUM" id="PAG_NUM" value="<?php echo $pagina_seleccionada;?>" />

				Mostrando <input type="number" name="PAG_TAM" id="PAG_TAM" min="1" max="<?php echo $total_registros;?>" value="<?php echo $pag_tam;?>">
				entradas de <?php echo $total_registros; ?>

				<input type="submit" name="Cambiar">
			</form>
		</nav>
		
		
		<div style="overflow-x:auto" class="col-10 col-tab-10">
			<table>
				<tr>
					<th>Número de cliente</th>
					<th>Nombre</th>
					<th>Dirección</th>
					<th>Número de teléfono</th>
					<th>Correo Electrónico</th>
					<th>Opciones</th>
				</tr>
				<?php
				foreach($filas as $fila) {
					if ($fila["CORREOELECTRONICO"]!=="cubashnosabreu@gmail.com") {
				
					?>
					<article class="clientes">
						<form method="post" action="controlador_clientes.php">
							<div class="fila_cliente">
								<tr>
									<div class="datos_cliente"> 											 <!-- CAMBIAR DATOS PARA BORRAR O EDITAR PEDIDO -->		
										<input id="OID_C" name="OID_C"
										type="hidden" value="<?php echo $fila["OID_C"]; ?>"/>
										
										
										<?php
										if (isset($cliente) and ($cliente["OID_C"] == $fila["OID_C"])) { ?>
										<!-- Editando título -->
										<td><div class="OID_C"><b><?php echo $fila["OID_C"]; ?></b></div></td>
										<td><h3><input id="NOMBRE" name="NOMBRE" type="text" value="<?php echo $fila["NOMBRE"]; ?>" required/></h3></td>
										<td><h3><input id="DIRECCION" name="DIRECCION" type="text" value="<?php echo $fila["DIRECCION"]; ?>" required/></h3></td>
										<td><h3><input id="NUMEROTELEFONO" name="NUMEROTELEFONO" type="text" pattern="[0-9]{9}" value="<?php echo $fila["NUMEROTELEFONO"]; ?>" required/></h3></td>
										<td><h3><input id="CORREOELECTRONICO" name="CORREOELECTRONICO" type="email" value="<?php echo $fila["CORREOELECTRONICO"]; ?>" required/></h3></td>

										<?php }	else { ?>
						<!-- ejemplo (borrar despues)
						<input id="TITULO" name="TITULO" type="hidden" value="<?php echo $fila["TITULO"]; ?>"/>
						<div class="titulo"><b><?php echo $fila["TITULO"]; ?></b></div>
						<div class="autor">By <em><?php echo $fila["NOMBRE"]." ".$fila["APELLIDOS"]; ?></em></div> -->
						<h3><input type="hidden" id="OID_C" name="OID_C" type="text" value="<?php echo $fila["OID_C"]; ?>"/></h3>
						<h3><input type="hidden" id="NOMBRE" name="NOMBRE" type="text" value="<?php echo $fila["NOMBRE"]; ?>"/></h3>
						<h3><input type="hidden" id="DIRECCION" name="DIRECCION" type="text" value="<?php echo $fila["DIRECCION"]; ?>"/></h3>
						<h3><input type="hidden" id="NUMEROTELEFONO" name="NUMEROTELEFONO" type="text" value="<?php echo $fila["NUMEROTELEFONO"]; ?>"/></h3>
						<h3><input type="hidden" id="CORREOELECTRONICO" name="CORREOELECTRONICO" type="text" value="<?php echo $fila["CORREOELECTRONICO"]; ?>"/></h3>
						
						<td><div class="OID_C"><b><?php echo $fila["OID_C"]; ?></b></div></td>
						<td><div class="NOMBRE"><b><?php echo $fila["NOMBRE"]; ?></b></div></td>
						<td><div class="DIRECCION"><b><?php echo $fila["DIRECCION"]; ?></b></div></td>
						<td><div class="NUMEROTELEFONO"><b><?php echo $fila["NUMEROTELEFONO"]; ?></b></div></td>
						<td><div class="CORREOELECTRONICO"><b><?php echo $fila["CORREOELECTRONICO"]; ?></b></div></td>
						<?php } ?>
					</div>
					
					<td>
						<div id="botones_fila">
							<?php if (isset($cliente) and ($cliente["OID_C"] == $fila["OID_C"])) { ?>
							<button id="grabar" name="grabar" type="submit" class="editar_fila">
								<img src="images/bag_menuito.bmp" class="editar_fila" alt="Guardar modificación">
							</button>
							<?php } else {?>
							<button id="editar" name="editar" type="submit" class="editar_fila">
								<img src="images/pencil_menuito.bmp" class="editar_fila" alt="Editar cliente">
							</button>
							<?php } ?>
							<button id="borrar" name="borrar" type="submit" class="editar_fila">
								<img src="images/remove_menuito.bmp" class="editar_fila" alt="Borrar cliente">
							</button>
						</div>
					</td>
				</tr>
			</div>
		</form>
		<?php }
		   } ?>
	</table>
</div>

</article>


</main>

<?php
include_once("pie.php");
?>

</body>
</html>