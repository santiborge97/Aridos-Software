<?php


function modificar_factura($conexion, $OID_F) {
	try {
		$stmt=$conexion->prepare('UPDATE FACTURAS F SET ESTAPAGADO=\'SI\' WHERE F.OID_F =:OID_F');
		$stmt->bindParam(':OID_F',$OID_F);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return "Ha ocurrido un error al modificar la factura, compruebe que los datos introducidos son correctos.";
	}
}


?>