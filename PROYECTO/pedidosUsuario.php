<?php
session_start();

require_once("gestionBD.php");
require_once("paginacionConsulta.php");

	//Aqui hay que comprobar que venimos del login y tenemos que guardar en una variable local el usuario y la contraseña
if (!isset($_SESSION["exitoLogin"]) || $_SESSION["exitoLogin"]["usuario"] == "cubashnosabreu@gmail.com") {
	Header("Location: index.php");
} else{
	$datos_usuario=$_SESSION["exitoLogin"];
	

	//Esto es para las variables de tamaño pagina y numero de pagina para paginar la consulta
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

	//Esto es para las variables de tamaño pagina y numero de pagina para paginar la consulta
	if(isset($_SESSION["paginacion"])){
		$paginacion = $_SESSION["paginacion"];/* Expresión para iniciar variable de sesión (si es que hay) */

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
	
	// Borrar la variable de sesión respecto paginación
	// ...
	unset($_SESSION["paginacion"]);



	$conexion=crearConexionBD();

	// La consulta que ha de paginarse
	$query = 'SELECT PRECIO, P.DIRECCION, FECHA, NOMBREE, TIPOCAMION, TIPOSERVICIO,DISTANCIAKM, HORASGRUA, TAMAÑOCUBA,PESOKG, VOLUMENM3 FROM CLIENTES C, PEDIDOS P, EMPLEADOS E, FACTURAS F, SERVICIOS S WHERE CorreoElectronico = \''.$datos_usuario["usuario"].'\' AND(P.OID_C=C.OID_C AND P.OID_F = F.OID_F AND P.OID_E = E.OID_E AND P.OID_S = S.OID_S)';


	// Se comprueba que el tamaño de página, página seleccionada y total de registros son conformes. En caso de que no, se asume el tamaño de página propuesto, pero desde la página 1
	$total_registros= total_consulta($conexion, $query );
	$total_paginas = ( $total_registros / $pag_tam );
	

	if ( $total_registros % $pag_tam > 0 ) // resto de la división
	$total_paginas++;
	
	if ( $pagina_seleccionada > $total_paginas )
		$pagina_seleccionada = $total_paginas;

	
	// Generamos los valores de sesión para página e intervalo para volver a ella después de una operación
	$paginacion["PAG_NUM"]=$pagina_seleccionada;
	$paginacion["PAG_TAM"]=$pag_tam;
	$_SESSION["paginacion"]=$paginacion;

	$filas = consulta_paginada($conexion,$query,$pagina_seleccionada,$pag_tam);/* Nombre de la función */ /* (parámetros)*/;

	cerrarConexionBD($conexion);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Mis pedidos | Hnos. Abreu</title>
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>

<body>

	<?php
	include_once("cabecera.php");
	include_once("login.php");
	?>

	<main>

		<h1 class="titulo_pantalla col-10 col-tab-10">Mis pedidos</h1>
		<nav>
			<div class="col-10 col-tab-10" id="enlaces">
				<!-- Código para poner los enlaces a las páginas -->
				<?php
				for( $pagina = 1; $pagina <= $total_paginas; $pagina++ ) {
					if ( $pagina == $pagina_seleccionada ) { // página actual
						?>
						<span class="current pagina_seleccionada"> <?php echo $pagina; ?></span>
						<?php
					} else { // resto de páginas
						?>
						<a class="paginas_no_seleccionadas" href="pedidosUsuario.php?PAG_NUM= <?php echo $pagina; ?>&PAG_TAM= <?php echo $pag_tam; ?> " > <?php echo $pagina; ?> </a>
						<?php
					}
				}
				?>
			</div>
			
			
			<form class="col-10 col-tab-10" method="get" action="pedidosUsuario.php">
				<!-- Formulario que contiene el número y cambio de tamaño de página -->
				<input type="hidden" name="PAG_NUM" id="PAG_NUM" value="<?php echo $pagina_seleccionada;?>" />

				Mostrando <input type="number" name="PAG_TAM" id="PAG_TAM" min="1" max="<?php echo $total_registros;?>" value="<?php echo $pag_tam;?>">
				entradas de <?php echo $total_registros; ?>

				<input type="submit" name="Cambiar">
			</form>
		</nav>

		

		
		<div style="overflow-x:auto" class="col-10 col-tab-10">
			<table >
				<tr>
					<th>Precio </th> <th>Dirección del pedido </th> <th>Fecha del pedido </th> <th>Nombre de empleado </th> <th>Camión </th> <th>Tipo de servicio </th> <th>Distancia(Km) </th><th>Horas de grua </th> <th>Tamaño de cuba </th> <th>Peso(Kg) </th>
				</tr>
				<?php
				foreach($filas as $fila) {
					?>
					<tr class="pedido">
						<td><?=$fila['PRECIO']?></td>
						<td><?=$fila['DIRECCION']?></td>
						<td><?=$fila['FECHA']?></td>
						<td><?=$fila['NOMBREE']?></td>
						<td><?=$fila['TIPOCAMION']?></td>
						<td><?=$fila['TIPOSERVICIO']?></td>
						<td><?=$fila['DISTANCIAKM']?></td>
						<td><?=$fila['HORASGRUA']?></td>
						<td><?=$fila['TAMAÑOCUBA']?></td>
						<td><?=$fila['PESOKG']?></td>
					</tr>

					<?php } ?>
				</table>
			</div>
			
		</main>

		<?php
		include_once("pie.php");
		?>

	</body>
	</html>

