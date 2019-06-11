<?php
session_start();
include_once("gestionBD.php");
	//Comprobamos si somos el administrador
if($_SESSION["exitoLogin"]["usuario"]!= "cubashnosabreu@gmail.com" ){ 
	Header("Location: index.php");
}

	//CREO QUE ESTO AQUI NO HACE FALTA (SANTI)
	// Si no existen datos del formulario en la sesión, se crea una entrada con valores por defecto
	//if (!isset($_SESSION['balance'])) {
	//	$balance['fechaInicial'] = ""; 
	//	$balance['fechaFinal'] = "";
	//	$balance['totalIngresos'] = "";
	//	$balance['totalGastos'] = "";
	//	$balance['resultado'] = "";

	//	$_SESSION['balance'] = $balance;
	//}
	// Si ya existían valores, los cogemos para inicializar el formulario
	//else
	//	$balance = $_SESSION['balance'];


	// Si hay errores de validación, hay que mostrarlos y marcar los campos
if(isset($_SESSION["erroresBalance"])){
	$erroresBalance = $_SESSION["erroresBalance"];
}



?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Balance | Hnos. Abreu</title>
	<link rel="stylesheet" type="text/css" href="css/css_calzado.css">
	<link rel="stylesheet" type="text/css" href="css/estilo.css">


	<script>
		
		var fechaInicial = document.getElementById(fechaInicial);
		var fechaFinal = document.getElementById(fechaFinal);

		function validar_fechaFinalMayorQueInicial(fechaInicial, fechaFinal){
			valuesStart=fechaInicial.split("/");
			valuesEnd=fechaFinal.split("/");
			
        // Verificamos que la fecha no sea posterior a la actual
        var dateStart=new Date(valuesStart[2],(valuesStart[1]-1),valuesStart[0]);
        var dateEnd=new Date(valuesEnd[2],(valuesEnd[1]-1),valuesEnd[0]);
        if(dateStart>=dateEnd){
        	return 0;
        }
        return 1;
    }

    if(validar_fechaFinalMayorQueInicial(fechaInicial,fechaFinal)){
    	document.write("La fecha "+fechaFinal+" es superior a la fecha "+fechaInicial);
    }else{
    	document.write("La fecha "+fechaFinal+" NO es superior a la fecha "+fechaInicial);
    }



</script>




</head>

<body id="cuerpoBalance">

	<?php
	include_once("cabecera.php");
	include_once("login.php");
	?>
	<?php
	// Mostrar los erroes de validación (Si los hay)
	if (isset($erroresBalance) && count($erroresBalance)>0) { 
		echo "<div id=\"div_erroresBalance\" class=\"error\">";
		echo "<h4> Errores en el balance:</h4>";
		foreach($erroresBalance as $error) echo $error; 
		echo "</div>";

    		//Borra los errores una vez que se han mostrado
    		//UNSET O PONER A NULL?
		$_SESSION["erroresBalance"]=null;
		$erroresPresupuesto=null;
	}

	?>
	<h3 id="indique" class="col-10 col-tab-10">Indique la fecha de inicio y de fin para calcular el balance</h3>
	<div id="formularioBalance" class="col-10 col-tab-10"><form action="controlador_balance.php" method="POST">
		<div>Fecha inicio: <input type="date" name="fechaInicial"  min="2000-01-01" max="2099-12-31" required><br></div>
		<div>Fecha fin: <input type="date" name="fechaFinal" min="2000-01-01" max="2099-12-31" required><br></div>
		<input type="submit" name="envioFechas"><br>
	</form></div>


	
	<?php
	include_once("pie.php");
	?>

</body>
</html>
