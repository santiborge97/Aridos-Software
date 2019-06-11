<?php
function quitar_cliente($conexion,$OID_C) {
	try {
		$stmt=$conexion->prepare('DELETE FROM CLIENTES C WHERE C.OID_C =:OID_C');
		$stmt->bindParam(':OID_C',$OID_C);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return "Ha ocurrido un error al borrar el cliente, no se puede borrar un cliente que tenga pedidos asignados";
	}
}

function modificar_cliente($conexion, $OID_C, $NOMBRE, $DIRECCION, $TELEFONO, $CORREOELECTRONICO) {
	try {
		$stmt=$conexion->prepare('UPDATE CLIENTES C SET NOMBRE=:nombre, DIRECCION=:direccion, NUMEROTELEFONO=:telefono, CORREOELECTRONICO=:correoElectronico WHERE C.OID_C =:OID_C');
		$stmt->bindParam(':OID_C',$OID_C);
		$stmt->bindParam(':nombre',$NOMBRE);
		$stmt->bindParam(':direccion',$DIRECCION);
		$stmt->bindParam(':telefono',$TELEFONO);
		$stmt->bindParam(':correoElectronico',$CORREOELECTRONICO);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return "Ha ocurrido un error al modificar el cliente, compruebe que los datos introducidos son correctos y que no existe un usuario con el mismo email.";
	}
}
?>