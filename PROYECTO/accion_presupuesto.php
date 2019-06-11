<?php 
session_start();

	// Comprobar que hemos llegado a esta página porque se ha rellenado el formulario
if (isset($_SESSION["formularioPresupuesto"])) {
		// Recogemos los datos del formulario
	$presupuesto["tipoServicio"] = $_REQUEST["tipoServicio"];
	$presupuesto["distancia"] = $_REQUEST["distancia"];
	$presupuesto["pesoLeña"] = $_REQUEST["pesoLeña"];
	$presupuesto["horasGrua"] = $_REQUEST["horasGrua"];
	$presupuesto["tamañoCuba"] = $_REQUEST["tamañoCuba"];


		// Guardar la variable local con los datos del formulario en la sesión.
	$_SESSION["formularioPresupuesto"] = $presupuesto;

		// Validamos el formulario en servidor 
	$erroresPresupuesto = validarDatosPresupuesto($presupuesto);

			// Si se han detectado errores
	if (count($erroresPresupuesto)>0) {
			// Guardo en la sesión los mensajes de error y volvemos al formulario
		$_SESSION["erroresPresupuesto"] = $erroresPresupuesto;
		Header('Location:presupuesto.php');
	} else{
		Header('Location:exito_presupuesto.php');
	}

	} else // En caso contrario, vamos al formulario
	Header("Location:presupuesto.php");



	
	
	

	function validarDatosPresupuesto($presupuesto){
		//Aqui tenemos que validar los datos del presupuesto (Validacion en servidor)
		switch ($presupuesto["tipoServicio"]) {
			case 'grua':
				if($presupuesto["horasGrua"]==""){
					$erroresPresupuesto[] = "<p>Las horas de grúa no pueden estar vacías.</p>";
				}else if($presupuesto["horasGrua"]<1){
					$erroresPresupuesto[] = "<p>Las horas de grúa deben ser mayor o igual que uno.</p>";
				}else if(!ctype_digit($presupuesto["horasGrua"])){
					$erroresPresupuesto[] = "<p>Introduzca un valor entero válido para las horas.</p>";
				}else if(!is_numeric($presupuesto["horasGrua"])){
					$erroresPresupuesto[] = "<p>Las horas de grúa se expresan sólo con números.</p>";
				}
			break;

			case 'cuba_escombros':
				if($presupuesto["distancia"]==""){
					$erroresPresupuesto[] = "<p>La distancia no puede estar vacía.</p>";
				}else if($presupuesto["distancia"]<1){
					$erroresPresupuesto[] = "<p>La distancia de ser mayor o igual que uno.</p>";
				}else if($presupuesto["distancia"]>35){
					$erroresPresupuesto[] = "<p>La distancia debe ser menor o igual que 35.</p>";
				}else if(!ctype_digit($presupuesto["distancia"])){
					$erroresPresupuesto[] = "<p>Introduzca un valor entero válido para la distancia.</p>";
				}else if(!is_numeric($presupuesto["distancia"])){
					$erroresPresupuesto[] = "<p>La distancia se expresa sólo con números.</p>";
				}
			break;

			case 'cuba_poda':
				if($presupuesto["tamañoCuba"]==""){
					$erroresPresupuesto[] = "<p>El tamaño no puede estar vacío.</p>";
				}else if ($presupuesto["tamañoCuba"]!="pequeña" && $presupuesto["tamañoCuba"]!="mediana" && $presupuesto["tamañoCuba"]!="grande"){
					$erroresPresupuesto[] = "<p>Introduzca un tamaño válido</p>";
				}
			break;

			case 'cuba_estiercol': 
				if($presupuesto["tamañoCuba"]==""){
					$erroresPresupuesto[] = "<p>El tamaño no puede estar vacío.</p>";
				}else if ($presupuesto["tamañoCuba"]!="pequeña" && $presupuesto["tamañoCuba"]!="mediana" && $presupuesto["tamañoCuba"]!="grande"){
					$erroresPresupuesto[] = "<p>Introduzca un tamaño válido</p>";
				}
			break;

			case 'leña':
				if($presupuesto["pesoLeña"]==""){
					$erroresPresupuesto[] = "<p>El peso no puede estar vacío.</p>";
				}else if($presupuesto["pesoLeña"]<100){
					$erroresPresupuesto[] = "<p>El peso debe ser mayor o igual que 100.</p>";
				}else if($presupuesto["pesoLeña"]>4500){
					$erroresPresupuesto[] = "<p>El peso debe ser menor o igual que 4500.</p>";
				}else if(!ctype_digit($presupuesto["pesoLeña"])){
					$erroresPresupuesto[] = "<p>Introduzca un valor entero válido para el peso.</p>";
				}else if(!is_numeric($presupuesto["pesoLeña"])){
					$erroresPresupuesto[] = "<p>El peso se expresa sólo con números.</p>";
				}
			break;
			case 'aridos':
				if($presupuesto["distancia"]==""){
					$erroresPresupuesto[] = "<p>La distancia no puede estar vacía.</p>";
				}else if($presupuesto["distancia"]<1){
					$erroresPresupuesto[] = "<p>La distancia de ser mayor o igual que uno.</p>";
				}else if($presupuesto["distancia"]>35){
					$erroresPresupuesto[] = "<p>La distancia debe ser menor o igual que 35.</p>";
				}else if(!ctype_digit($presupuesto["distancia"])){
					$erroresPresupuesto[] = "<p>Introduzca un valor entero válido para la distancia.</p>";
				}else if(!is_numeric($presupuesto["distancia"])){
					$erroresPresupuesto[] = "<p>La distancia se expresa sólo con números.</p>";
				}
			break;

			case 'otros_materiales':
				if($presupuesto["distancia"]==""){
					$erroresPresupuesto[] = "<p>La distancia no puede estar vacía.</p>";
				}else if($presupuesto["distancia"]<1){
					$erroresPresupuesto[] = "<p>La distancia de ser mayor o igual que uno.</p>";
				}else if($presupuesto["distancia"]>35){
					$erroresPresupuesto[] = "<p>La distancia debe ser menor o igual que 35.</p>";
				}else if(!ctype_digit($presupuesto["distancia"])){
					$erroresPresupuesto[] = "<p>Introduzca un valor entero válido para la distancia.</p>";
				}else if(!is_numeric($presupuesto["distancia"])){
					$erroresPresupuesto[] = "<p>La distancia se expresa sólo con números.</p>";
				}
			break;

			default:
				$erroresPresupuesto[] = "<p>Introduzca un tipo de servicio válido</p>";
			break;
		}

		return $erroresPresupuesto;
	}

	?>