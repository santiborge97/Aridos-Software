<div id="barra_navegacion">

	<script>
		function myFunction() {
			var x = document.getElementById("myTopnav");
			if (x.className === "col-7 col-tab-10 topnav") {
				x.className += " responsive";
			} else {
				x.className = "col-7 col-tab-10 topnav";
			}
		}
	</script>

	<div class="col-7 col-tab-10 topnav" id="myTopnav">
		<a href="index.php">Inicio</a>
		<a href="servicios.php">Servicios</a>
		<a href="presupuesto.php">Presupuesto</a>
		<a href="contacto.php">Contacto</a>
		<a href="empresa.php">Empresa</a>
		<a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>
	</div>
	<?php 

	//Se guarda la dirección de la página actual para redirigirnos aquí en caso de login o logout.
	$_SESSION["actualUrl"] = $_SERVER["REQUEST_URI"];

	if (!isset($_SESSION['formularioLogin'])) {
		$formularioLogin['usuario'] = "";
		$formularioLogin['password'] = "";
		
		
		$_SESSION['formularioLogin'] = $formularioLogin;
	}
		// Si ya existían valores, los cogemos para inicializar el formulario
	else
		$formularioLogin = $_SESSION['formularioLogin'];

	//Guardamos los errores existentes en variable local
	if(isset($_SESSION["erroresLogin"]))
		$erroresLogin = $_SESSION["erroresLogin"];


	if (isset($_SESSION["exitoLogin"]))
		$exitoLogin = $_SESSION["exitoLogin"];


	


			/*En cada página comprobamos si el usuario ha iniciado sesión, y si es administrador o cliente.
			Hay que ver cómo diferenciar a un cliente de un administrador. Aquí estoy suponiendo que hay una
			fila en la base de datos que hemos creado para el administrador*/


			?>
			<div class="col-3 col-tab-10 login">
				<?php
				
				if(isset($exitoLogin["usuario"]) && isset($exitoLogin["password"]) && $exitoLogin["usuario"]!="" && $exitoLogin["password"]!=""){
					if($exitoLogin["usuario"] == "cubashnosabreu@gmail.com"){
						echo "<a href=\"administracion.php\"><button class=\"boton_login\">Administración</button></a>";
					}else{
						echo "<a href=\"pedidosUsuario.php\"><button class=\"boton_login\">Mis pedidos</button></a>";
					}
					echo "<a href=\"logout.php\"><button class=\"boton_login\">Cerrar sesión</button></a>";
				}else{ 
					?>
					
					<form action="accion_login.php" method="post" >
						<!--Usuario-->
						<input type="email" name="usuario" id="usuario" placeholder="Ingresar email" size=13 required>
						<!--Contraseña-->
						<input type="password" name="password" id="password" size=13 placeholder="Contraseña" required>
						<input id="submit_button" type="submit" value="Login"></br>
					</form>
				</div>


				<?php } 
	//Mostramos los errores
				if (isset($erroresLogin) && count($erroresLogin)>0) { 
					echo "<div id=\"div_erroresLogin\" class=\"error\">";
					echo "<h4> Errores en login:</h4>";

					foreach($erroresLogin as $error) echo $error; 
					
					echo "</div>";
		//Borra los errores una vez que se han mostrado
		//UNSET O PONER A NULL?
					$_SESSION["erroresLogin"]=null;
					$erroresLogin=null;
				}	
				?>
			</div>
