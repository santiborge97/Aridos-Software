<?php	
	session_start();

	require_once("gestionBD.php");
	require_once("gestionarPedidos.php");
	
	if (isset($_REQUEST["CORREOELECTRONICO"])){
		$nuevoPedido["CORREOELECTRONICO"] = $_REQUEST["CORREOELECTRONICO"];
		$nuevoPedido["NOMBRE"] = $_REQUEST["NOMBRE"];
		$nuevoPedido["DIRECCION_CLIENTE"] = $_REQUEST["DIRECCION_CLIENTE"];
		$nuevoPedido["NUMEROTELEFONO"] = $_REQUEST["NUMEROTELEFONO"];
		$nuevoPedido["TIPOSERVICIO"] = $_REQUEST["TIPOSERVICIO"];
		$nuevoPedido["DISTANCIAKM"] = $_REQUEST["DISTANCIAKM"];
		$nuevoPedido["HORASGRUA"] = $_REQUEST["HORASGRUA"];
		$nuevoPedido["TAMAÑOCUBA"] = $_REQUEST["TAMAÑOCUBA"];
		$nuevoPedido["PESOKG"] = $_REQUEST["PESOKG"];
		$nuevoPedido["EMPLEADO"] = $_REQUEST["EMPLEADO"];
		$nuevoPedido["PRECIO"] = $_REQUEST["PRECIO"];
		$nuevoPedido["DIRECCION"] = $_REQUEST["DIRECCION"];
		$nuevoPedido["FECHA"] = $_REQUEST["FECHA"];
		
		$_SESSION["formularioPedido"] = $nuevoPedido;

		$erroresPedido = validarDatosPedido($nuevoPedido);
			
		if (count($erroresPedido)>0) {
			// Guardo en la sesión los mensajes de error y volvemos al formulario
			$_SESSION["erroresPedido"] = $erroresPedido;
			Header('Location: nuevoPedido.php');
		} else{
			
			$conexion = crearConexionBD();
			$OID_C = checkUsuario($conexion, $nuevoPedido["CORREOELECTRONICO"]);
			$OID_S = crearServicio($conexion, $nuevoPedido["TIPOSERVICIO"], $nuevoPedido["DISTANCIAKM"], $nuevoPedido["HORASGRUA"], $nuevoPedido["TAMAÑOCUBA"], $nuevoPedido["PESOKG"]);
			$OID_E = checkEmpleado($conexion, $nuevoPedido["EMPLEADO"]);
			$exito = crearPedido($conexion, $nuevoPedido["PRECIO"], $nuevoPedido["DIRECCION"], $nuevoPedido["FECHA"], $OID_C, $OID_E, $OID_S);
			cerrarConexionBD($conexion);

			if($exito != 0){
				Header('Location: exito_nuevoPedido.php');				
			} else {
				$_SESSION["excepcion"] = "Ha ocurrido un error a la hora de crear el pedido. Compruebe los datos introducidos, y que el cliente existe";
				$_SESSION["actualUrl"] = "nuevoPedido.php";

				Header("Location: excepcion.php");
			}

		}
	}
	else 
		Header("Location: nuevoPedido.php");


	function validarDatosPedido($pedido){

		$fechaMax = "2099-12-31";
		$fechaMin = "2000-01-01";

		// Validación del correo			
		if($pedido["CORREOELECTRONICO"]!="" && strlen($pedido["CORREOELECTRONICO"])>60){
			$erroresPedido[] = "<p>El correo no puede tener más de 60 caracteres.</p>";
		}

		if($pedido["CORREOELECTRONICO"]==""){
			$erroresPedido[] = "<p>El correo no puede estar vacío.</p>";
		}

		if($pedido["CORREOELECTRONICO"]!="" && !filter_var($pedido["CORREOELECTRONICO"], FILTER_VALIDATE_EMAIL)){
			$erroresPedido[] = "<p>El correo no es válido.</p>";
		}

		switch ($pedido["TIPOSERVICIO"]) {
			case 'GRUA':
				if($pedido["HORASGRUA"]==""){
					$erroresPedido[] = "<p>Las horas de grúa no pueden estar vacías.</p>";
				}else if($pedido["HORASGRUA"]<1){
					$erroresPedido[] = "<p>Las horas de grúa deben ser mayor o igual que uno.</p>";
				}else if(!ctype_digit($pedido["HORASGRUA"])){
					$erroresPedido[] = "<p>Introduzca un valor entero válido para las horas.</p>";
				}else if(!is_numeric($pedido["HORASGRUA"])){
					$erroresPedido[] = "<p>Las horas de grúa se expresan sólo con números.</p>";
				}
			break;

			case 'CUBA_ESCOMBROS':
				if($pedido["DISTANCIAKM"]==""){
					$erroresPedido[] = "<p>La distancia no puede estar vacía.</p>";
				}else if($pedido["DISTANCIAKM"]<1){
					$erroresPedido[] = "<p>La distancia de ser mayor o igual que uno.</p>";
				}else if($pedido["DISTANCIAKM"]>35){
					$erroresPedido[] = "<p>La distancia debe ser menor o igual que 35.</p>";
				}else if(!ctype_digit($pedido["DISTANCIAKM"])){
					$erroresPedido[] = "<p>Introduzca un valor entero válido para la distancia.</p>";
				}else if(!is_numeric($pedido["DISTANCIAKM"])){
					$erroresPedido[] = "<p>La distancia se expresa sólo con números.</p>";
				}
			break;

			case 'CUBA_PODA':
				if($pedido["TAMAÑOCUBA"]==""){
					$erroresPedido[] = "<p>El tamaño no puede estar vacío.</p>";
				}else if ($pedido["TAMAÑOCUBA"]!="PEQUEÑA" && $pedido["TAMAÑOCUBA"]!="MEDIANA" && $pedido["TAMAÑOCUBA"]!="GRANDE"){
					$erroresPedido[] = "<p>Introduzca un tamaño válido</p>";
				}
			break;

			case 'CUBA_ESTIERCOL': 
				if($pedido["TAMAÑOCUBA"]==""){
					$erroresPedido[] = "<p>El tamaño no puede estar vacío.</p>";
				}else if ($pedido["TAMAÑOCUBA"]!="PEQUEÑA" && $pedido["TAMAÑOCUBA"]!="MEDIANA" && $pedido["TAMAÑOCUBA"]!="GRANDE"){
					$erroresPedido[] = "<p>Introduzca un tamaño válido</p>";
				}
			break;

			case 'LEÑA':
				if($pedido["PESOKG"]==""){
					$erroresPedido[] = "<p>El peso no puede estar vacío.</p>";
				}else if($pedido["PESOKG"]<100){
					$erroresPedido[] = "<p>El peso debe ser mayor o igual que 100.</p>";
				}else if($pedido["PESOKG"]>4500){
					$erroresPedido[] = "<p>El peso debe ser menor o igual que 4500.</p>";
				}else if(!ctype_digit($pedido["PESOKG"])){
					$erroresPedido[] = "<p>Introduzca un valor entero válido para el peso.</p>";
				}else if(!is_numeric($pedido["PESOKG"])){
					$erroresPedido[] = "<p>El peso se expresa sólo con números.</p>";
				}
			break;
			case 'ARIDOS':
				if($pedido["DISTANCIAKM"]==""){
					$erroresPedido[] = "<p>La distancia no puede estar vacía.</p>";
				}else if($pedido["DISTANCIAKM"]<1){
					$erroresPedido[] = "<p>La distancia de ser mayor o igual que uno.</p>";
				}else if($pedido["DISTANCIAKM"]>35){
					$erroresPedido[] = "<p>La distancia debe ser menor o igual que 35.</p>";
				}else if(!ctype_digit($pedido["DISTANCIAKM"])){
					$erroresPedido[] = "<p>Introduzca un valor entero válido para la distancia.</p>";
				}else if(!is_numeric($pedido["DISTANCIAKM"])){
					$erroresPedido[] = "<p>La distancia se expresa sólo con números.</p>";
				}
			break;

			case 'OTROS_MATERIALES':
				if($pedido["DISTANCIAKM"]==""){
					$erroresPedido[] = "<p>La distancia no puede estar vacía.</p>";
				}else if($pedido["DISTANCIAKM"]<1){
					$erroresPedido[] = "<p>La distancia de ser mayor o igual que uno.</p>";
				}else if($pedido["DISTANCIAKM"]>35){
					$erroresPedido[] = "<p>La distancia debe ser menor o igual que 35.</p>";
				}else if(!ctype_digit($pedido["DISTANCIAKM"])){
					$erroresPedido[] = "<p>Introduzca un valor entero válido para la distancia.</p>";
				}else if(!is_numeric($pedido["DISTANCIAKM"])){
					$erroresPedido[] = "<p>La distancia se expresa sólo con números.</p>";
				}
			break;

			default:
				$erroresPedido[] = "<p>Introduzca un tipo de servicio válido</p>";
			break;
		}


		if($pedido["EMPLEADO"]!="Paco" && $pedido["EMPLEADO"]!="Manuel"){
			$erroresPedido[] = "<p>Introduzca un empleado válido</p>";
		}

		if($pedido["PRECIO"]==""){
			$erroresPedido[] = "<p>El precio no puede estar vacío.</p>";
		}else if($pedido["PRECIO"]<1){
			$erroresPedido[] = "<p>El precio no puede ser menor que uno.</p>";
		}else if($pedido["PRECIO"]>9999){
			$erroresPedido[] = "<p>El precio no puede ser mayor que 9999.</p>";
		}else if(!is_numeric($pedido["PRECIO"])){
			$erroresPedido[] = "<p>El precio tiene que ser numérico.</p>";
		}else if(!ctype_digit($pedido["PRECIO"])){
			$erroresPedido[] = "<p>Introduzca un valor entero válido para el precio.</p>";
		};
		

		if($pedido["DIRECCION"]==""){
			$erroresPedido[] = "<p>La dirección no puede estar vacía.</p>";
		}

		if($pedido["DIRECCION"]!="" && strlen($pedido["DIRECCION"])>50){
			$erroresPedido[] = "<p>La dirección no puede tener más de 50 caracteres.</p>";
		}

		if($pedido["DIRECCION"]!="" && is_numeric($pedido["DIRECCION"])){
			$erroresPedido[] = "<p>La dirección no es válida.</p>";
		}

		if($pedido["FECHA"]!="" && ($pedido["FECHA"]<$fechaMin || $pedido["FECHA"]>$fechaMax)){
			$erroresPedido[] = "<p>Introduzca una fecha entre el 01/01/2000 y el 31/12/2099.</p>";
		}

		if($pedido["FECHA"]==""){
			$erroresPedido[] = "<p>La fecha no puede estar vacía.</p>";
		}


		return $erroresPedido;
	}

?>
