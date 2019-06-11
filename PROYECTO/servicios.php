<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es-ES">
<head>
	<meta charset="UTF-8" />
	<title>Servicios | Hnos. Abreu</title>
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
	<link rel="stylesheet" type="text/css" href="css/css_calzado.css">

</head>
<body>

	<?php
	include_once("cabecera.php");
	include_once("login.php");
	?>
	<div class="cuerpoServicios">
		<h1 class="titulosSer col-10 col-tab-10">Catálogo de servicios que ofrecemos</h1>

		<h2 class="titulosSer col-10 col-tab-10">Áridos</h2>

		<img class="fotosServicios col-3 col-tab-3" src="images/arena1.jpg" alt="Áridos" width=30%>
		<p class="espacioImgServ col-1 col-tab-1"> </p>
		<img class="fotosServicios col-3 col-tab-3" src="images/arena2.jpg" alt="Áridos" width=30%>

		<p class="descripcion col-3 col-tab-3">  Amplia gama de áridos, se transportan en cubas de 3 y 5 metros cúbicos, el límite por transporte son de 5 metros cúbicos.</p>

		<h2 class="titulosSer col-10 col-tab-10">Leña</h2>

		<img class="fotosServicios col-3 col-tab-3" src="images/monton_leña.jpg" alt="Montón de leña" width=30%>
		<p class="espacioImgServ col-1 col-tab-1"> </p>
		<img class="fotosServicios col-3 col-tab-3" src="images/cuba_leña.jpg" alt="Cuba de leña" width=30%>

		<p class="descripcion col-3 col-tab-3">  Venta de hasta 4500kg de leña en un solo transporte.</p>

		<h2 class="titulosSer col-10 col-tab-10">Grúa</h2>
		<img class="fotosServicios col-3 col-tab-3" src="images/grua.jpg" alt="Montón de leña" width=30%>
		<p class="espacioImgServ col-1 col-tab-1"> </p>
		<img class="fotosServicios col-3 col-tab-3" src="images/grua2.jpg" alt="Cuba de leña" width=30%>

		<p class="descripcion col-3 col-tab-3">  Contamos con un camión-grúa para el transporte de sacas   (1 metro cúbico). </p>

		<h2 class="titulosSer col-10 col-tab-10">Recogida de escombros u otros residuos</h2>
		
		<img class="fotosServiciosSer col-3 col-tab-3" src="images/cuba_estiercol.jpg" alt="Cuba estiércol" width=30%>
		<p class="espacioImgServ col-1 col-tab-1"> </p>
		<img class="fotosServicios col-3 col-tab-3" src="images/poda.jpg" alt="Cuba de leña" width=30%>

		<p class="descripcion col-3 col-tab-3">Tenemos a su disposición cubas de 3 metros cúbicos para escombros y cubas de hasta 10 metros cúbicos para la recogida de poda, estiércol u otros residuos de baja densidad</p>

		<h4 class="calcular col-10 col-tab-10">Todos estos servicios serán realizados a una DISTANCIA MÁXIMA DE TRANSPORTE de 35 km. Si quiere obtener un precio aproximado del servicio que necesita acceda a <a href="presupuesto.php" alt="Cálculo presupuesto">Presupuesto</a></h4>
	</div>
	<?php
	include_once("pie.php");
	?>
</body>
</html>