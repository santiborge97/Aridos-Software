<?php	
session_start();	

if (isset($_SESSION["pedido"])) {
	$pedido = $_SESSION["pedido"];
	$erroresPedido = validarDatosPedido($pedido);
	if (count($erroresPedido)>0) {
			// Guardo en la sesión los mensajes de error y volvemos al formulario
		$_SESSION["erroresModificarPedido"] = $erroresPedido;
		Header('Location: pedidosPorFactura.php');
	} else{
		unset($_SESSION["pedido"]);
		
		require_once("gestionBD.php");
		require_once("gestionarPedidos.php");
		
		$conexion = crearConexionBD();		
		$excepcion = modificar_pedido($conexion,$pedido["OID_P"], $pedido["PRECIO"], $pedido["DIRECCION"], $pedido["FECHA"], $pedido["OID_C"], $pedido["OID_E"], $pedido["OID_S"], $pedido["OID_F"], $libro["TITULO"]);
		cerrarConexionBD($conexion);
		
		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "pedidosPorFactura.php";
			Header("Location: excepcion.php");
		}
		else
			Header("Location: pedidosPorFactura.php");
	}
} 
	else Header("Location: pedidosPorFactura.php"); // Se ha tratado de acceder directamente a este PHP




	function validarDatosPedido($pedido){

		if($pedido["PRECIO"]=="" || $pedido["PRECIO"]<1 || $pedido["PRECIO"]>9999 || !is_numeric($pedido["PRECIO"])) $erroresPedido[] = "<p>Introduzca un precio válido</p>";

		if($pedido["DIRECCION"]=="" || strlen($pedido["DIRECCION"])>50 || is_numeric($pedido["DIRECCION"])){
			$erroresPedido[] = "<p>Introduzca una dirección válida</p>";
		}

		if($pedido["FECHA"]=="" || !validacionFecha($pedido["FECHA"])){
			$erroresPedido[] = "<p>Introduzca una fecha válida</p>";
		}

		return $erroresPedido;
	}


	function validacionFecha($date){
		$res = 1;

    // Patrón a cumplir
		if(!preg_match("/^\d{2}\/\d{2}\/\d{2}$/", $date))
			return 0;

    // Parsear a enteros
		$date = explode('/',$date);
		$day = $date[0];
		$month = $date[1];
		$year = $date[2];

    // Comprobar que los parámetros están en el rango
		if($year < 00 || $year > 99 || $month == 0 || $month > 12)
			return 0;

		$monthLength = array( 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 );

    // Ajustar para años bixiestos
		if($year % 400 == 0 || ($year % 100 != 0 && $year % 4 == 0))
			$monthLength[1] = 29;

    // Comprobar que el dia está entre los días válidos del mes
		if($day <= 0 || $day > $monthLength[$month - 1]) 
			return 0;
		
		return $res;
		
		
	};
	?>
