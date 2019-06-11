--SCRIPT CONSULTAS

------------------------------RF03 (Lista de pedidos que están por pagar)

SELECT * FROM Facturas NATURAL JOIN pedidos WHERE EstaPagado='NO' ORDER BY pedidos.oid_c;



------------------------------RF17 (Los cinco clientes que deban más dinero a la empresa)

DECLARE

CURSOR cur_morosos IS
  SELECT NOMBRE, PrecioSinIva FROM CLIENTES C, PEDIDOS P, FACTURAS F WHERE F.ESTAPAGADO='NO' and (P.OID_C=C.OID_C AND P.OID_F = F.OID_F) ORDER BY F.PrecioSinIva DESC;

BEGIN
    FOR fila IN cur_morosos LOOP
    EXIT WHEN cur_morosos%ROWCOUNT >5;
    DBMS_OUTPUT.PUT_LINE(fila.NOMBRE);
    END LOOP;
END;
/



----------------------------CONSULTA QUE DEVUELVE LISTA DE PEDIDOS DE UNA FACTURA

Select Nombre, TipoServicio, DistanciaKM,  PesoKG, VolumenM3, TamañoCuba, Precio HorasGrua FROM Pedidos P, Servicios S, Facturas F, Clientes C WHERE (P.OID_C=C.OID_C and P.OID_F=F.OID_F) ORDER BY P.Fecha;


