<?php session_start() ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Transportes Hnos. Abreu</title>
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
	<link rel="stylesheet" type="text/css" href="css/css_fran.css">
</head>

<body>

	<?php
	include_once("cabecera.php");
	include_once("login.php");
	?>

	<!--Foto grande de la empresa que va después del encabezado-->
	<img src="images/pano.jpg" alt="Transportes Hnos. Abreu" width=100%>  <!--Definir estilo-->


	<!--Poner las fotos-->
	<div class="col-tab-5" class="divBotonesIndex">
		<a href="servicios.php"><img class="centrar" src="images/boton_servicios.png" alt="Servicios disponibles" width=30%>
			<h2 class="centrar" class="padding_index">Servicios</h2></a>
		</div>

		<div class="col-5" class="col-tab-5" class="divBotonesIndex">
			<a href="presupuesto.php"><img class="centrar" src="images/boton_presupuesto.png" alt="Cálculo presupuesto" width=30%>
				<h2 class="centrar" class="padding_index">Presupuesto</h2></a>
			</div>

			<div class="col-5" class="col-tab-5" class="centrar" class="divBotonesIndex">
				<a href="contacto.php"><img class="centrar" src="images/boton_contacto.png" alt="Contacto" width=30%>
					<h2 class="centrar" class="padding_index">Contacto</h2></a>
				</div>

				<div class="col-5" class="col-tab-5" class="divBotonesIndex">
					<a href="empresa.php"><img class="centrar" src="images/boton_empresa.png" alt="Empresa" width=30%>
						<h2 class="centrar" class="padding_index">Empresa</h2></a>
					</div>

					<?php
					include_once("pie.php");
					?>

				</body>
				</html>

