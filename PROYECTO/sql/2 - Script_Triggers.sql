-------------TRIGGERS------------
--trigger IVA gastos-- 

CREATE OR REPLACE TRIGGER trigger_IVA_gastos
BEFORE INSERT OR UPDATE OF COSTE, IVA ON GASTOS
FOR EACH ROW
BEGIN
    :NEW.IVA := :New.Coste-(:NEW.Coste/1.21);
END;
/

----------------------------------------------------------------------------------------------------------------	
----------------------------------------------------------------------------------------------------------------

--trigger IVA facturas-- 

CREATE OR REPLACE TRIGGER trigger_IVA_facturas
BEFORE INSERT OR UPDATE OF PRECIOTOTAL, PRECIOSINIVA ON FACTURAS
FOR EACH ROW
BEGIN
	:NEW.PrecioTotal := :NEW.PrecioSinIva*1.21;
END;
/


----------------------------------------------------------------------------------------------------------------	
----------------------------------------------------------------------------------------------------------------


--trigger fecha emision-- 

CREATE OR REPLACE TRIGGER trigger_fecha_emision
BEFORE UPDATE OR INSERT ON FACTURAS
FOR EACH ROW
BEGIN
	IF (:NEW.EstaPagado = 'NO' AND :NEW.FechaEmision IS NOT null)
	THEN raise_application_error(-20600,'La fecha de emision no puede ser distinto de null si la factura no esta pagada');
	END IF;
END;
/


	
--trigger fecha emision 2--
CREATE OR REPLACE TRIGGER trigger_fecha_emision_2
BEFORE UPDATE OF ESTAPAGADO OR INSERT ON FACTURAS
FOR EACH ROW
BEGIN
	IF :NEW.EstaPagado = 'SI'
	
	THEN :NEW.FechaEmision := SYSDATE;
	
	END IF;
END;
/



----------------------------------------------------------------------------------------------------------------	
----------------------------------------------------------------------------------------------------------------

--trigger asignacion factura-- 


CREATE OR REPLACE TRIGGER asignacion_factura
BEFORE INSERT ON Pedidos
FOR EACH ROW
DECLARE
CONTADOR integer;
OIDFACTURA integer;
BEGIN
SELECT COUNT(*) into CONTADOR FROM (SELECT * FROM facturas F NATURAL JOIN pedidos P WHERE (P.OID_C=:NEW.OID_C AND F.estapagado='NO') ORDER BY F.FECHACREACION DESC) WHERE ROWNUM =1;

IF CONTADOR =0

    THEN 
    INSERT INTO FACTURAS(NUMPEDIDOS, PRECIOSINIVA, ESTAPAGADO, FECHACREACION) VALUES (1, :NEW.PRECIO, 'NO', SYSDATE);
    :NEW.OID_F := sec_facturas.CURRVAL;
	
    ELSE
    SELECT oid_f into OIDFACTURA FROM (SELECT OID_F FROM facturas F NATURAL JOIN pedidos P WHERE (P.OID_C=:NEW.OID_C AND F.estapagado='NO') ORDER BY F.FECHACREACION DESC) WHERE ROWNUM =1;
    :NEW.OID_F := OIDFACTURA;
    UPDATE FACTURAS F SET F.PRECIOSINIVA = (F.preciosiniva + :NEW.PRECIO), F.NUMPEDIDOS = (F.NUMPEDIDOS + 1)   WHERE F.OID_F = OIDFACTURA;


	END IF;
END;
/


-----------------------------------------------------------------------------------------------------------------------
-- Trigger borrar_pedido--
-- Actualiza los datos de factura y servicios al borrar un pedido

CREATE OR REPLACE TRIGGER borrar_pedido
AFTER DELETE ON Pedidos
FOR EACH ROW
DECLARE
NUMERO INTEGER;

BEGIN

UPDATE FACTURAS F SET F.NUMPEDIDOS = F.NUMPEDIDOS -1, F.PRECIOSINIVA = F.PRECIOSINIVA - :OLD.PRECIO WHERE F.OID_F = :OLD.OID_F RETURNING F.NUMPEDIDOS INTO NUMERO;

IF NUMERO <= 0
    THEN DELETE FACTURAS F WHERE F.OID_F = :OLD.OID_F;
    END IF;
	
DELETE SERVICIOS S WHERE S.OID_S = :OLD.OID_S; 

END;
/
-- Trigger actualizar_pedido--
create or replace TRIGGER actualizar_pedido
BEFORE UPDATE ON Pedidos
FOR EACH ROW

BEGIN

UPDATE FACTURAS F SET F.PRECIOSINIVA = F.PRECIOSINIVA - :OLD.PRECIO + :NEW.PRECIO WHERE F.OID_F = :OLD.OID_F;

END;
/


	
	

	
  



	