<?php

function loginUsuario($conexion,$usuario,$password){
	try{

		//res será Verdadero o Falso. No se si se puede hacer más corto que esto, o si es legal hacerlo to del tirón
		$res=0;
		$stmt=$conexion->prepare("SELECT * FROM Clientes WHERE CorreoElectronico =:usuario");
		$stmt->bindParam(':usuario',$usuario);
		$stmt->execute();
		$fila = $stmt->fetch();
		if($fila["OID_C"] === $password){
			$res = 1;
		}

		return $res;
	} catch(PDOException $e){
		return "";
	}
}
?>