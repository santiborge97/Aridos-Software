<?php
session_start();

if($_SESSION["exitoLogin"]["usuario"]!= "cubashnosabreu@gmail.com" ){ 
	Header("Location: index.php");
}

if (!isset($_SESSION['formularioPedido'])) {
	$formularioPedido['CORREOELECTRONICO'] = "";
	$formularioPedido['TIPOSERVICIO'] = "";
	$formularioPedido['DISTANCIAKM'] = "";
	$formularioPedido['HORASGRUA'] = "";
	$formularioPedido['TAMAÑOCUBA'] = "";
	$formularioPedido['PESOKG'] = "";
	$formularioPedido['EMPLEADO'] = "";
	$formularioPedido['PRECIO'] = "";
	$formularioPedido['DIRECCION'] = "";
	$formularioPedido['FECHA'] = "";
	
	
	$_SESSION['formularioPedido'] = $formularioPedido;
}
	// Si ya existían valores, los cogemos para inicializar el formulario
else
	$formularioPedido = $_SESSION['formularioPedido'];

if(isset($_SESSION["erroresPedido"]))
	$erroresPedido = $_SESSION["erroresPedido"];

$_SESSION["formularioPedido"]=null;
?>



<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Nuevo pedido | Hnos. Abreu</title>
	<link rel="stylesheet" type="text/css" href="css/css_calzado.css">
	<link rel="stylesheet" type="text/css" href="css/estilo.css">

	<script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
	<script> 
		$(document).ready(function(){
			$("#tipoServicio").on("input",function(){
				if($("#tipoServicio").val()=="GRUA"){
					$('#div_distancia').hide("fast");
					$('#div_tamañoCuba').hide("fast");
					$('#div_pesoLeña').hide("fast");
					$('#div_horas_grua').show("fast");
					
  				//Se ponen los input necesarios con required, los demás no
  				document.getElementById("input_horas_grua").required = true;
  				document.getElementById("input_peso_leña").required = false;
  				document.getElementById("input_distancia").required = false;
  				document.getElementById("input_tamaño_cuba").required = false;

  			} else if($("#tipoServicio").val()=="LEÑA"){
  				$('#div_distancia').hide("fast");
  				$('#div_tamañoCuba').hide("fast");
  				$('#div_pesoLeña').show("fast");
  				$('#div_horas_grua').hide("fast");
  				
				//Se ponen los input necesarios con required, los demás no
				document.getElementById("input_horas_grua").required = false;
				document.getElementById("input_peso_leña").required = true;
				document.getElementById("input_distancia").required = false;
				document.getElementById("input_tamaño_cuba").required = false;

			}else if($("#tipoServicio").val()=="CUBA_ESCOMBROS" || $("#tipoServicio").val()=="ARIDOS" || $("#tipoServicio").val()=="OTROS_MATERIALES"){
				$('#div_distancia').show("fast");
				$('#div_tamañoCuba').hide("fast");
				$('#div_pesoLeña').hide("fast");
				$('#div_horas_grua').hide("fast");
				
				//Se ponen los input necesarios con required, los demás no
				document.getElementById("input_horas_grua").required = false;
				document.getElementById("input_peso_leña").required = false;
				document.getElementById("input_distancia").required = true;
				document.getElementById("input_tamaño_cuba").required = false;

			} else if($("#tipoServicio").val()=="CUBA_PODA" || $("#tipoServicio").val()=="CUBA_ESTIERCOL"){
				$('#div_distancia').hide("fast");
				$('#div_tamañoCuba').show("fast");
				$('#div_pesoLeña').hide("fast");
				$('#div_horas_grua').hide("fast");
				
				//Se ponen los input necesarios con required, los demás no
				document.getElementById("input_horas_grua").required = false;
				document.getElementById("input_peso_leña").required = false;
				document.getElementById("input_distancia").required = false;
				document.getElementById("input_tamaño_cuba").required = true;

			}
		});
		});
	</script>
</head>

<body>

	<?php
	include_once("cabecera.php");
	include_once("login.php");
	?>

	<?php
	// Mostrar los erroes de validación (Si los hay)
	if (isset($erroresPedido) && count($erroresPedido)>0) { 
		echo "<div id=\"div_erroresPedido\" class=\"error\">";
		echo "<h4> Errores en el formulario:</h4>";
		foreach($erroresPedido as $error) echo $error; 
		echo "</div>";

    		//Borra los errores una vez que se han mostrado
		$_SESSION["erroresPedido"]=null;
		$erroresPedido=null;
	}
	?>

	<h1 id="new" class="col-10 col-tab-10">Nuevo pedido</h1>

	<form action="controlador_creacionPedido.php" method="post" novalidate>

		<div id="div_cliente" class=" titulosNP col-10 col-tab-10">
			<h2>Cliente(Pulse <a href="clientes.php">aquí</a> para ver el listado completo de clientes)</h2>
			
			<p>Ingresar email: <input type="email" name="CORREOELECTRONICO" placeholder="Correo del usuario" value="<?php echo $formularioPedido['CORREOELECTRONICO'];?>" required></p>

		</div>
		<div id="div_servicio" class=" titulosNP col-10 col-tab-10">
			<h2 >Servicio</h2>
			Tipo de Servicio: <select id="tipoServicio" name="TIPOSERVICIO" required>
			<option selected></option>
			<option value="CUBA_ESCOMBROS">Cuba de escombros</option>
			<option value="CUBA_PODA">Cuba de poda </option>
			<option value="CUBA_ESTIERCOL" >Cuba de estiércol</option>
			<option value="LEÑA">Leña</option>
			<option value="GRUA">Grúa</option>
			<option value="ARIDOS">Áridos</option>
			<option value="OTROS_MATERIALES">Otros materiales</option>
		</select><br>

		<div id="div_distancia" hidden>
			Distancia(Km): <input type="number" name="DISTANCIAKM" min="1" max="35" title="No puede ser superior a 35km" id="input_distancia"><br></div>
			<div id="div_horas_grua" hidden>
				Horas de grúa: <input type="number" name="HORASGRUA" min="1" id="input_horas_grua"><br></div>
				<div id="div_tamañoCuba" hidden>
					Tamaño de cuba: <select name="TAMAÑOCUBA" id="input_tamaño_cuba">
					<option selected></option>
					<option value="PEQUEÑA" id="pequeña">Pequeña</option>
					<option value="MEDIANA" id="mediana">Mediana</option>
					<option value="GRANDE" id="grande">Grande</option>
				</select><br></div>
				<div id="div_pesoLeña" hidden>
					Peso(Kg): <input type="number" name="PESOKG" id="input_peso_leña" min="100" max="4500" title="Tiene que ser superior a 100 y menor que 4500"  ><br></div>
				</div>

				<div id="div_nuevo_pedido" class=" titulosNP col-10 col-tab-10">
					<h2>Pedido</h2>
					Empleado: <select name="EMPLEADO" required>
					<option value="Paco">Francisco Abreu</option>
					<option value="Manuel">Manuel Abreu</option>
				</select><br>
				Precio: <input type="number" min="1" max="9999" name="PRECIO" value="<?php echo $formularioPedido['PRECIO'];?>" required><br>
				Dirección: <input type="text" name="DIRECCION" value="<?php echo $formularioPedido['DIRECCION'];?>" required><br>
				Fecha: <input type="date" name="FECHA" min="2000-01-01" max="2099-12-31" value="<?php echo $formularioPedido['FECHA'];?>" required><br>
			</div>

			<p id="submitNP"><input type="submit" value="Crear pedido"></p>

		</form>



		<?php
		include_once("pie.php");
		?>

	</body>
	</html>