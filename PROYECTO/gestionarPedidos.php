<?php
  /*
     * #===========================================================#
     * #	Este fichero contiene las funciones de gestión     			 
     * #	de pedidos de la capa de acceso a datos 		
     * #==========================================================#
     */
  
  
  function quitar_pedido($conexion,$OID_P) {
  	try {
  		$stmt=$conexion->prepare('DELETE FROM PEDIDOS P WHERE P.OID_P =:OID_P');
  		$stmt->bindParam(':OID_P',$OID_P);
  		$stmt->execute();
  		return "";
  	} catch(PDOException $e) {
  		return "Error a la hora de borrar el pedido.";
  	}
  }

  function modificar_pedido($conexion, $OID_P,$PRECIO, $DIRECCION, $FECHA, $OID_C, $OID_E, $OID_S, $OID_F) {
  	try {
  		$stmt=$conexion->prepare('UPDATE PEDIDOS P SET PRECIO=:precio, DIRECCION=:direccion, FECHA=:fecha, OID_C=:oidCliente, OID_E=:oidEmpleado, OID_S=:oidServicio, OID_F=:oidFactura WHERE P.OID_P =:OID_P');
  		$stmt->bindParam(':OID_P',$OID_P);
  		$stmt->bindParam(':precio',$PRECIO);
  		$stmt->bindParam(':direccion',$DIRECCION);
  		$stmt->bindParam(':fecha',$FECHA);
  		$stmt->bindParam(':oidCliente',$OID_C);
  		$stmt->bindParam(':oidEmpleado',$OID_E);
  		$stmt->bindParam(':oidServicio',$OID_S);
  		$stmt->bindParam(':oidFactura',$OID_F);
  		$stmt->execute();
  		return "";
  	} catch(PDOException $e) {
  		return "Error a la hora de modificar el pedido. Compruebe que los datos introducidos son correctos.";
  	}
  }

  function crearServicio($conexion, $TIPOSERVICIO, $DISTANCIAKM, $HORASGRUA, $TAMAÑOCUBA, $PESOKG){
  	try{
  		switch ($TIPOSERVICIO) {

  			case 'GRUA':
  			$stmt=$conexion->prepare('INSERT INTO SERVICIOS (TIPOSERVICIO,DISTANCIAKM,HORASGRUA,TAMAÑOCUBA,PESOKG, VOLUMENM3) VALUES (:TIPOSERVICIO,null,:HORASGRUA,null, null, null)');
  			$stmt->bindParam(':TIPOSERVICIO',$TIPOSERVICIO);
  			$stmt->bindParam(':HORASGRUA',$HORASGRUA);
  			$stmt->execute();

  			break;

  			case 'CUBA_ESCOMBROS':
  			$stmt=$conexion->prepare('INSERT INTO SERVICIOS (TIPOSERVICIO,DISTANCIAKM,HORASGRUA,TAMAÑOCUBA,PESOKG, VOLUMENM3) VALUES (:TIPOSERVICIO,:DISTANCIAKM,null,null, null, null)');
  			$stmt->bindParam(':TIPOSERVICIO',$TIPOSERVICIO);
  			$stmt->bindParam(':DISTANCIAKM',$DISTANCIAKM);
  			$stmt->execute();
  			break;

  			case 'CUBA_PODA':
  			$stmt=$conexion->prepare('INSERT INTO SERVICIOS (TIPOSERVICIO,DISTANCIAKM,HORASGRUA,TAMAÑOCUBA,PESOKG, VOLUMENM3) VALUES (:TIPOSERVICIO,null,null,:TAMAÑOCUBA, null, null)');
  			$stmt->bindParam(':TIPOSERVICIO',$TIPOSERVICIO);
  			$stmt->bindParam(':TAMAÑOCUBA',$TAMAÑOCUBA);
  			$stmt->execute();
  			break;

  			case 'CUBA_ESTIERCOL':
  			$stmt=$conexion->prepare('INSERT INTO SERVICIOS (TIPOSERVICIO,DISTANCIAKM,HORASGRUA,TAMAÑOCUBA,PESOKG, VOLUMENM3) VALUES (:TIPOSERVICIO,null,null,:TAMAÑOCUBA, null, null)');
  			$stmt->bindParam(':TIPOSERVICIO',$TIPOSERVICIO);
  			$stmt->bindParam(':TAMAÑOCUBA',$TAMAÑOCUBA);
  			$stmt->execute();
  			break;

  			case 'LEÑA':
  			$stmt=$conexion->prepare('INSERT INTO SERVICIOS (TIPOSERVICIO,DISTANCIAKM,HORASGRUA,TAMAÑOCUBA,PESOKG, VOLUMENM3) VALUES (:TIPOSERVICIO,null,null,null, :PESOKG, null)');
  			$stmt->bindParam(':TIPOSERVICIO',$TIPOSERVICIO);
  			$stmt->bindParam(':PESOKG',$PESOKG);
  			$stmt->execute();
  			break;

  			case 'ARIDOS':
  			$stmt=$conexion->prepare('INSERT INTO SERVICIOS (TIPOSERVICIO,DISTANCIAKM,HORASGRUA,TAMAÑOCUBA,PESOKG, VOLUMENM3) VALUES (:TIPOSERVICIO,:DISTANCIAKM,null,null, null, null)');
  			$stmt->bindParam(':TIPOSERVICIO',$TIPOSERVICIO);
  			$stmt->bindParam(':DISTANCIAKM',$DISTANCIAKM);
  			$stmt->execute();
  			break;

  			case 'OTROS_MATERIALES':
  			$stmt=$conexion->prepare('INSERT INTO SERVICIOS (TIPOSERVICIO,DISTANCIAKM,HORASGRUA,TAMAÑOCUBA,PESOKG, VOLUMENM3) VALUES (:TIPOSERVICIO,:DISTANCIAKM,null,null, null, null)');
  			$stmt->bindParam(':TIPOSERVICIO',$TIPOSERVICIO);
  			$stmt->bindParam(':DISTANCIAKM',$DISTANCIAKM);
  			$stmt->execute();
  			break;
  		}

  		

  		$stmt=$conexion->prepare('SELECT OID_S FROM SERVICIOS ORDER BY OID_S DESC');
  		$stmt->execute();
  		$fila = $stmt->fetch();
  		$OID_S = $fila["OID_S"];

  		return $OID_S;
  	}catch(PDOException $e) {
  		return "";
  	}
  }

  function checkEmpleado($conexion, $empleado){
  	try{
  		$stmt=$conexion->prepare('SELECT OID_E FROM EMPLEADOS WHERE NOMBREE=:empleado');
  		$stmt->bindParam(':empleado',$empleado);
  		$stmt->execute();

  		$fila = $stmt->fetch();
  		$OID_E = $fila["OID_E"];


  		return $OID_E;
  	}catch(PDOException $e) {
  		return "";
  	}
  }
  
  function crearPedido($conexion, $precio, $direccion, $fecha, $oid_c, $oid_e, $oid_s){
  	try{
  		$OID_P = 0;

  		$stmt=$conexion->prepare('INSERT INTO PEDIDOS (PRECIO,DIRECCION,FECHA,OID_C,OID_E, OID_S) VALUES (:PRECIO,:DIRECCION,to_date(:FECHA, \'YYYY/MM/DD\'),:OID_C, :OID_E, :OID_S)');
  		$stmt->bindParam(':PRECIO',$precio);
  		$stmt->bindParam(':DIRECCION',$direccion);
  		$stmt->bindParam(':FECHA',$fecha);
  		$stmt->bindParam(':OID_C',$oid_c);
  		$stmt->bindParam(':OID_E',$oid_e);
  		$stmt->bindParam(':OID_S',$oid_s);
  		$stmt->execute();

  		$stmt=$conexion->prepare('SELECT OID_P FROM PEDIDOS ORDER BY OID_P DESC');
  		$stmt->execute();
  		$fila = $stmt->fetch();
  		$OID_P = $fila["OID_P"];

  		return $OID_P;
  	}catch(PDOException $e) {
  		return "";
  	}
  }

  function checkUsuario($conexion, $correo){
  	try{
  		
  		$stmt=$conexion->prepare('SELECT OID_C FROM CLIENTES WHERE CORREOELECTRONICO=:correo');
  		$stmt->bindParam(':correo',$correo);
  		$stmt->execute();

  		$fila = $stmt->fetch();
  		$OID_C = $fila["OID_C"];
  		

  		return $OID_C;
  	}catch(PDOException $e) {
  		return "";
  	}
  }

  function getUltimoPedido($conexion){
  	try{
  		$stmt=$conexion->prepare("SELECT P.OID_P, PRECIO, P.DIRECCION, FECHA, P.OID_C, P.OID_E, P.OID_S, P.OID_F, CORREOELECTRONICO, NOMBREE, TIPOCAMION, TIPOSERVICIO FROM CLIENTES C, PEDIDOS P, EMPLEADOS E, FACTURAS F, SERVICIOS S WHERE (P.OID_C=C.OID_C AND P.OID_F = F.OID_F AND P.OID_E = E.OID_E AND P.OID_S = S.OID_S) ORDER BY P.OID_P DESC");
  		$stmt->execute();
  		$fila = $stmt->fetch();
  		return $fila;
  	}catch(PDOException $e) {
  		return "";
  	}
  }

  ?>