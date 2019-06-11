--------------------------------------------------------------------------------------------------------------------------------
------------------------PROCEDIMIENTOS------------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------------------------------------------------


--Procedimiento lista de pedidos de un cliente (RF01 & RF02)

create or replace PROCEDURE pedidos_por_cliente (w_OID_C IN CLIENTES.OID_C%TYPE)
    IS

CURSOR cur_ped_cliente IS SELECT Nombre, TipoServicio, Fecha FROM Pedidos P, Servicios S, Clientes C WHERE (P.OID_C=W_OID_C and C.OID_C = W_OID_C AND P.OID_S = S.OID_S) ORDER BY Nombre;
BEGIN

FOR fila IN cur_ped_cliente LOOP
EXIT WHEN cur_ped_cliente%notfound;
DBMS_OUTPUT.PUT_LINE(fila.nombre||' '||fila.tiposervicio||' '||fila.fecha);
END LOOP;


END;
/



--Procedimiento pedidos por empleados (RF15)
create or replace PROCEDURE pedidos_por_empleado (w_OID_E IN EMPLEADOS.OID_E%TYPE)
	IS
	
CURSOR cur_ped_empleado IS SELECT NombreE, TipoServicio, Fecha FROM Pedidos P, Servicios S, Empleados E WHERE (P.OID_E=W_OID_E and E.OID_E = W_OID_E AND P.OID_S = S.OID_S) ORDER BY NombreE;

BEGIN

FOR fila IN cur_ped_empleado LOOP
EXIT WHEN cur_ped_empleado%notfound;
DBMS_OUTPUT.PUT_LINE(fila.nombreE||' '||fila.tiposervicio||' '||fila.fecha);
END LOOP;


END;
/
--Procedimiento pedidos entre dos fechas
create or replace PROCEDURE pedidos_por_fecha (w_fecha_inicio IN Pedidos.fecha%TYPE, w_fecha_fin IN Pedidos.fecha%TYPE)
	IS
	
CURSOR cur_ped_fechas IS SELECT Nombre, TipoServicio, Fecha FROM Pedidos P, Servicios S, Clientes C WHERE (P.fecha BETWEEN (w_fecha_inicio) and (w_fecha_fin));

BEGIN

FOR fila IN cur_ped_fechas LOOP
EXIT WHEN cur_ped_fechas%notfound;
DBMS_OUTPUT.PUT_LINE(fila.nombre||' '||fila.tiposervicio||' '||fila.fecha);
END LOOP;


END;
/

--------------------------------------------------------------------------------------------------------------------------------
------------------------FUNCIONES-----------------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------------------------------------------------

---------------------------------FUNCION CALCULAR PRECIO--------------------------
CREATE OR REPLACE FUNCTION calc_precio 
  (tipo_servicio IN Servicios.TipoServicio%TYPE, distancia_km IN Servicios.DistanciaKM%TYPE, peso_kg IN Servicios.PesoKG%TYPE, 
  volumen_m3 IN Servicios.VolumenM3%TYPE, horas_grua IN Servicios.HorasGrua%TYPE, cuba IN Servicios.TamañoCuba%TYPE)
  RETURN NUMBER IS precio PEDIDOS.PRECIO%TYPE;
  
BEGIN

RETURN CASE tipo_servicio 
    WHEN 'grua'
        THEN (horas_grua*35)
    
    WHEN 'cuba_escombros'
        THEN
            (CASE 
                WHEN (distancia_km<16) 
                    THEN 50 
                ELSE 60
            END)
    
    WHEN 'cuba_poda' 
        THEN
            (CASE cuba 
                WHEN 'pequeña' 
                    THEN 50 
                WHEN 'mediana' 
                    THEN 80 
                ELSE 100 
            END)
    
	WHEN 'cuba_estiercol'
		THEN 
			(CASE cuba
				WHEN 'pequeña'
					THEN 60
					
				ELSE 80
			END)
	
	WHEN 'aridos'
		THEN 
			(CASE
				WHEN (distancia_km<16)
					THEN 50
				ELSE 60
			END)
			
	WHEN 'leña'
		THEN (peso_kg*0.12)
		
	WHEN 'otros_materiales'
		THEN 
			(CASE 
				WHEN (distancia_km<16)
					THEN 50
				ELSE 60
			END)
				
    ELSE 0
    END;
    
END calc_precio;

/


----------------------------------------FUNCION BALANCE-------------------------------

create or replace FUNCTION balance
	(fechaInicial DATE, fechaFinal DATE)
	
RETURN NUMBER IS balance NUMBER(10,2);

SumaIngresos NUMBER(10,2);
SumaGastos NUMBER(10,2);
SumaTotal NUMBER(10,2);

BEGIN

SELECT SUM(PrecioTotal) INTO SumaIngresos FROM facturas F WHERE (F.EstaPagado='SI' and F.FechaEmision between (FechaInicial) and (FechaFinal));

SELECT SUM(Coste) INTO SumaGastos FROM gastos G WHERE (G.FechaPago between (FechaInicial) and (FechaFinal));

IF (SumaIngresos is null AND SumaGastos is not null)
  THEN
    SumaTotal:=SumaGastos*(-1);
ElSIF (SumaGastos is null AND SumaIngresos is not null)
  THEN
    SumaTotal:=SumaIngresos;
ElSIF (SumaGastos is null AND SumaIngresos is null)
  THEN
    SumaTotal:=0;
ELSE 
  SumaTotal:=SumaIngresos-SumaGastos;
END IF;

RETURN SumaTotal;

END;

/

