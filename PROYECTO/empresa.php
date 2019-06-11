<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
	<meta charset="UTF-8" />
	<title>Empresa | Hnos. Abreu</title>
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
	<link rel="stylesheet" type="text/css" href="css/css_fran.css">

</head>
<body>

	<?php
	include_once("cabecera.php");
	include_once("login.php");
	?>

	<div class="centrar">
		<h1>¿Quiénes somos?</h1>

		<p>Transportes Hnos. Abreu es una empresa especializada en el transporte de materiales de construcción y escombros u otros residuos (estiércol, poda...) con más de 30 años en el sector.</p>

		<p>El ámbito de trabajo es de carácter local, abarcando el municipio de Cartaya y todos los pueblos limítrofes. También existe la posibilidad de realizar transportes más específicos a lugares más lejanos como Sevilla o Cádiz.</p>

		<p>La empresa cuenta con 3 empleados; un administrativo y dos camioneros. En cuanto a maquinaria, disponemos de un camión, un camión grúa, una retroexcavadora y un dumper pequeño.</p>

	</div>

	<div class="centrar">
		<img src="images/camiones_nave.jpg" alt="Camiones nave" width=40%>
		<img src="images/retro.jpg" alt="Retroexcavadora" width=40%>
		<img src="images/dumper.jpg" alt="Dumper pequeño" width=40%>
		<img src="images/cuba.jpg" alt="Cuba mediana" width=40%>
	</div>
	<?php
	include_once("pie.php");
	?>
</body>
</html>
