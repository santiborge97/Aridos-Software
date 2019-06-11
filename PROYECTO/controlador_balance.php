<?php 
session_start();
include_once("gestionBD.php");

	/*
		//Comprobar que hemos llegado a esta página porque se ha rellenado el formulario
		if (isset($_SESSION["balance"])) {
		// Recogemos los datos del formulario
		$datosBalance["fechaInicial"] = $_REQUEST["fechaInicial"];
		$datosBalance["fechaFinal"] = $_REQUEST["fechaFinal"];
		$datosBalance["totalIngresos"] = $_REQUEST["totalIngresos"];
		$datosBalance["totalGastos"] = $_REQUEST["totalGastos"];
		$datosBalance["resultado"] = $_REQUEST["resultado"];
		

		// Guardar la variable local con los datos del formulario en la sesión.
		$_SESSION["balance"] = $datosBalance;

		// Validamos el formulario en servidor 
		$erroresBalance = validarDatosBalance($datosBalance);

		// Si se han detectado errores
		if (count($erroresBalance)>0) {
			// Guardo en la sesión los mensajes de error y volvemos al formulario
			$_SESSION["erroresBalance"] = $erroresBalance;
			Header('Location:balance.php');
		} else{
			$conexion = crearConexionBD();
			$datosBalance["resultado"] = consultarBalance($conexion, $datosBalance["fechaIncial"], $datosBalance["fechaFinal"]);

			cerrarConexionBD($conexion);

			if($datosBalance["resultado"] != 0){
				Header('Location: exito_balance.php');				
			} else {
				//VI ESTO EN EL CONTROLADOR DE NUEVO PEDIDO PERO NO LO ENTIENDO EN ESTE CASO
				//$_SESSION["excepcion"] = $OID_P;
				//$_SESSION["destino"] = "nuevoPedido.php";

				Header("Location: excepcion.php");
			}

			
		}

	} else // En caso contrario, vamos al formulario
		Header("Location: balance.php");  
	*/

	//SANTI

	if(isset($_REQUEST["fechaInicial"])){ //Comprobamos que venimos del formulario
		//Guardamos los datos del formulario
		$datosBalance["fechaInicial"] = $_REQUEST["fechaInicial"];
		$datosBalance["fechaFinal"] = $_REQUEST["fechaFinal"];
		//Comprobamos si hay errores de validacion
		$erroresBalance = validarDatosBalance($datosBalance);
		// Si se han detectado errores
		if (count($erroresBalance)>0) {
			// Guardo en la sesión los mensajes de error y volvemos al formulario
			$_SESSION["erroresBalance"] = $erroresBalance;
			Header('Location:balance.php');
		} else{ //Si no se han detectado errores realizamos la consulta a la BD
			$conexion = crearConexionBD();
			$resultadoBalance = consultarBalance($conexion, $datosBalance["fechaInicial"], $datosBalance["fechaFinal"]);
			$resultadoTotalFacturas=consultarSumaFacturas($conexion, $datosBalance["fechaInicial"], $datosBalance["fechaFinal"]);
			$resultadoTotalGastos=consultarSumaGastos($conexion, $datosBalance["fechaInicial"], $datosBalance["fechaFinal"]);

			cerrarConexionBD($conexion);

			if($resultadoBalance!==null && $resultadoBalance!=="" && $resultadoTotalGastos!==null && $resultadoTotalGastos!=="" && $resultadoTotalFacturas!==null && $resultadoTotalFacturas!=="" ){
				$_SESSION["BALANCE"]= $resultadoBalance;
				$_SESSION["SUMAFACTURAS"]= $resultadoTotalFacturas;
				$_SESSION["SUMAGASTOS"]= $resultadoTotalGastos;
				Header('Location: exito_balance.php');				
			} else {
				$_SESSION["excepcion"] = "Ha habido un error al calcular el balance (Probablemente haya introducido una fecha incorrecta).";
				$_SESSION["actualUrl"] = "balance.php";

				Header("Location: excepcion.php");
			}

			
		}

	} else // En caso contrario, vamos al formulario
	Header("Location: balance.php");
//----------------------------------------------------------------------Funcion validacion formulario balance
	function validarDatosBalance($datosBalance){
		if($datosBalance["fechaInicial"] >= $datosBalance["fechaFinal"] && ($datosBalance["fechaInicial"]!="" || $datosBalance["fechaInicial"]!=null) && ($datosBalance["fechaFinal"]!="" || $datosBalance["fechaFinal"]!=null)){
			$erroresBalance[] = "<p>La fecha incial no puede ser igual o posterior a la final</p>";
		}

		$fechaMax = "2099-12-31";
		$fechaMin = "2000-01-01";

		if($datosBalance["fechaInicial"] < $fechaMin && ($datosBalance["fechaInicial"]!="" || $datosBalance["fechaInicial"]!=null)){
			$erroresBalance[] = "<p>La fecha inicial no puede ser anterior al 01/01/2000</p>";
		}

		if($datosBalance["fechaFinal"] < $fechaMin && ($datosBalance["fechaFinal"]!="" || $datosBalance["fechaFinal"]!=null)){
			$erroresBalance[] = "<p>La fecha final no puede ser anterior al 01/01/2000</p>";
		}

		if($datosBalance["fechaInicial"] > $fechaMax && ($datosBalance["fechaInicial"]!="" || $datosBalance["fechaInicial"]!=null)){
			$erroresBalance[] = "<p>La fecha inicial no puede ser posterior al 31/12/2099</p>";
		}

		if($datosBalance["fechaFinal"] > $fechaMax && ($datosBalance["fechaFinal"]!="" || $datosBalance["fechaFinal"]!=null)){
			$erroresBalance[] = "<p>La fecha final no puede ser posterior al 31/12/2099</p>";
		}

		if($datosBalance["fechaInicial"]=="" || $datosBalance["fechaInicial"]==null){
			$erroresBalance[] = "<p>La fecha inicial no puede estar vacía o ser nula</p>";
		}

		if($datosBalance["fechaFinal"]=="" || $datosBalance["fechaFinal"]==null){
			$erroresBalance[] = "<p>La fecha final no puede estar vacía o ser nula</p>";
		}

		return $erroresBalance;
	}
//----------------------------------------------------------------------Funcion acceso a la BD para calcular el balance
	function consultarBalance($conexion,$fechaInicial,$fechaFinal){
		try {
			$stmt=$conexion->prepare('SELECT BALANCE(to_date(:fechaInicial,\'YYYY/MM/DD\'),to_date(:fechaFinal,\'YYYY/MM/DD\')+1) AS BALANCE FROM DUAL');
			$stmt->bindParam(':fechaInicial',$fechaInicial);
			$stmt->bindParam(':fechaFinal',$fechaFinal);
			$stmt->execute();
			$fila = $stmt->fetch();
			$balance = $fila["BALANCE"];
			return $balance;

		} catch(PDOException $e) {
			return "";
		}
	}
//----------------------------------------------------------------------Funcion acceso a la BD para calcular el balance
	function consultarSumaFacturas($conexion,$fechaInicial,$fechaFinal){
		try {
			

			$stmt=$conexion->prepare('SELECT SUM(PrecioTotal) AS SUMAFACTURAS FROM facturas F WHERE (F.EstaPagado=\'SI\' and F.FechaEmision between to_date(:fechaInicial,\'YYYY/MM/DD\') and to_date(:fechaFinal,\'YYYY/MM/DD\')+1)');
			$stmt->bindParam(':fechaInicial',$fechaInicial);
			$stmt->bindParam(':fechaFinal',$fechaFinal);
			$stmt->execute();
			$fila = $stmt->fetch();
			

			if($fila["SUMAFACTURAS"]==null){
				$sumaFacturas=0;
			} else{
				$sumaFacturas = $fila["SUMAFACTURAS"];
			}

			return $sumaFacturas;

		} catch(PDOException $e) {
			return "";
		}
	}
//----------------------------------------------------------------------Funcion acceso a la BD para calcular el balance
	function consultarSumaGastos($conexion,$fechaInicial,$fechaFinal){
		try {

			$stmt=$conexion->prepare('SELECT SUM(Coste) AS SUMAGASTOS FROM gastos G WHERE (G.FechaPago between to_date(:fechaInicial,\'YYYY/MM/DD\') and to_date(:fechaFinal,\'YYYY/MM/DD\')+1)');
			$stmt->bindParam(':fechaInicial',$fechaInicial);
			$stmt->bindParam(':fechaFinal',$fechaFinal);
			$stmt->execute();
			$fila = $stmt->fetch();

			if($fila["SUMAGASTOS"]==null){
				$sumaGastos=0;
			} else{
				$sumaGastos = $fila["SUMAGASTOS"];
			}

			return $sumaGastos;

		} catch(PDOException $e) {
			return "";
		}
	}
	
	?>		

