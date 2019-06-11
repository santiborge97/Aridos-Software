<?php
session_start();

// Si no existen datos del formulario en la sesión, se crea una entrada con valores por defecto
if (!isset($_SESSION['formularioPresupuesto'])) {
  $formularioPresupuesto['tipoServicio'] = ""; 
  $formularioPresupuesto['distancia'] = "";
  $formularioPresupuesto['pesoLeña'] = "";
		//$formularioPresupuesto['volumen'] = "";
  $formularioPresupuesto['horasGrua'] = "";
  $formularioPresupuesto['tamañoCuba'] = "";
  
  $_SESSION['formularioPresupuesto'] = $formularioPresupuesto;
}
	// Si ya existían valores, los cogemos para inicializar el formulario
else
  $formularioPresupuesto = $_SESSION['formularioPresupuesto'];


	// Si hay errores de validación, hay que mostrarlos y marcar los campos
if(isset($_SESSION["erroresPresupuesto"]))
  $erroresPresupuesto = $_SESSION["erroresPresupuesto"];



?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Presupuesto | Hnos. Abreu</title>
  <link rel="stylesheet" type="text/css" href="css/estilo.css">
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
</head>

<body>
  <script> 
  	$(document).ready(function(){
  		$("#tipoServicio").on("input",function(){
  			if($("#tipoServicio").val()=="grua"){
  				$('#div_distancia').hide("fast");
  				$('#div_tamañoCuba').hide("fast");
  				$('#div_pesoLeña').hide("fast");
  				$('#div_horas_grua').show("fast");
  				$('#enviar_formulario_presupuesto').show("fast");
  				
  				//Se ponen los input necesarios con required, los demás no
  				document.getElementById("input_horas_grua").required = true;
  				document.getElementById("input_peso_leña").required = false;
  				document.getElementById("input_distancia").required = false;
  				document.getElementById("input_tamaño_cuba").required = false;

  			} else if($("#tipoServicio").val()=="leña"){
  				$('#div_distancia').hide("fast");
  				$('#div_tamañoCuba').hide("fast");
  				$('#div_pesoLeña').show("fast");
  				$('#div_horas_grua').hide("fast");
  				$('#enviar_formulario_presupuesto').show("fast");
  				
				//Se ponen los input necesarios con required, los demás no
        document.getElementById("input_horas_grua").required = false;
        document.getElementById("input_peso_leña").required = true;
        document.getElementById("input_distancia").required = false;
        document.getElementById("input_tamaño_cuba").required = false;

      }else if($("#tipoServicio").val()=="cuba_escombros" || $("#tipoServicio").val()=="aridos" || $("#tipoServicio").val()=="otros_materiales"){
        $('#div_distancia').show("fast");
        $('#div_tamañoCuba').hide("fast");
        $('#div_pesoLeña').hide("fast");
        $('#div_horas_grua').hide("fast");
        $('#enviar_formulario_presupuesto').show("fast");
        
				//Se ponen los input necesarios con required, los demás no
        document.getElementById("input_horas_grua").required = false;
        document.getElementById("input_peso_leña").required = false;
        document.getElementById("input_distancia").required = true;
        document.getElementById("input_tamaño_cuba").required = false;

      } else if($("#tipoServicio").val()=="cuba_poda" || $("#tipoServicio").val()=="cuba_estiercol"){
        $('#div_distancia').hide("fast");
        $('#div_tamañoCuba').show("fast");
        $('#div_pesoLeña').hide("fast");
        $('#div_horas_grua').hide("fast");
        $('#enviar_formulario_presupuesto').show("fast");
        
				//Se ponen los input necesarios con required, los demás no
        document.getElementById("input_horas_grua").required = false;
        document.getElementById("input_peso_leña").required = false;
        document.getElementById("input_distancia").required = false;
        document.getElementById("input_tamaño_cuba").required = true;
      }
    });

  	});
  </script>



  <?php
  include_once("cabecera.php");
  include_once("login.php");
  ?>
  <?php
	// Mostrar los erroes de validación (Si los hay)
  if (isset($erroresPresupuesto) && count($erroresPresupuesto)>0) { 
    echo "<div id=\"div_erroresPresupuesto\" class=\"error\">";
    echo "<h4> Errores en el formulario:</h4>";
    foreach($erroresPresupuesto as $error) echo $error; 
    echo "</div>";

    		//Borra los errores una vez que se han mostrado
    $_SESSION["erroresPresupuesto"]=null;
    $erroresPresupuesto=null;
  }

  ?>
  <h1 class="titulo_pantalla col-10 col-tab-10">Presupuesto</h1>
  <div class="warning">Seleccione un servicio y a continuación rellene el formulario. Si desea un servicio que no está entre los siguientes debe ponerse en contacto con la empresa pulsando <a href="contacto.php">aquí</a></div>
  <div id="form_presupuesto" >
   <form action="accion_presupuesto.php" method="GET">
    <div id ="div_tipoServicio">
      Tipo de Servicio: <select name="tipoServicio" id="tipoServicio" required>
      <option selected></option>
      <option value="cuba_escombros">Cuba de escombros</option>
      <option value="cuba_poda">Cuba de poda </option>
      <option value="cuba_estiercol" >Cuba de estiércol</option>
      <option value="leña">Leña</option>
      <option value="grua">Grúa</option>
      <option value="aridos">Áridos</option>
      <option value="otros_materiales">Otros materiales</option>
    </select><br></div>
    <div id="div_distancia" hidden>
      Distancia(Km): <input type="number" name="distancia" id="input_distancia" min="1" max="35" title="No puede ser superior a 35km" ><br></div>
      <div id="div_horas_grua" hidden>
        Horas de grúa: <input type="number" name="horasGrua" id="input_horas_grua" min="1" ><br></div>
        <div id="div_tamañoCuba" hidden>
          Tamaño de cuba: <select name="tamañoCuba" id="input_tamaño_cuba" >
          <option selected></option>
          <option value="pequeña" id="pequeña">Pequeña</option>
          <option value="mediana" id="mediana">Mediana</option>
          <option value="grande" id="grande">Grande</option>
        </select><br></div>
        <div id="div_pesoLeña" hidden>
          Peso(Kg): <input type="number" name="pesoLeña" id="input_peso_leña" min="100" max="4500"title="Tiene que ser superior a 100 y menor que 4500"><br></div>
          <input id="enviar_formulario_presupuesto" type="submit" value="Enviar" hidden> 
        </form></div>
        <?php
        include_once("pie.php");
        ?>

      </body>
      </html>

