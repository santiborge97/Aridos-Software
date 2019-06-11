

---------------------Especificacion del paquete PRUEBAS_GASTOS---------------------
create or replace
PACKAGE PRUEBAS_GASTOS AS
	PROCEDURE inicializar;
	PROCEDURE insertar
	(nombre_prueba VARCHAR2, W_Nombre VARCHAR2, W_Descripcion VARCHAR2, W_Coste NUMBER, W_FechaPago DATE, W_FechaInicio DATE, W_FechaFin DATE, salidaEsperada BOOLEAN);
	PROCEDURE actualizar
	(nombre_prueba VARCHAR2, W_OID_G INTEGER, W_Nombre VARCHAR2, W_Descripcion VARCHAR2, W_Coste NUMBER, W_FechaPago DATE, W_FechaInicio DATE, W_FechaFin DATE, salidaEsperada BOOLEAN);
	PROCEDURE eliminar
	(nombre_prueba VARCHAR2, W_OID_G INTEGER, salidaEsperada BOOLEAN);
	
END PRUEBAS_GASTOS;
/

---------------------CUERPO DEL PAQUETE PRUEBAS_GASTOS---------------------
create or replace
PACKAGE BODY PRUEBAS_GASTOS AS
	--INICIALIZACION
	PROCEDURE inicializar AS
	BEGIN
	--Borrar contenido de la tabla--
		DELETE FROM GASTOS;
	END inicializar;
	
	--PRUEBA PARA LA INSERCION DE GASTOS--
	PROCEDURE insertar (nombre_prueba VARCHAR2, W_Nombre VARCHAR2, W_Descripcion VARCHAR2, W_Coste NUMBER, W_FechaPago DATE, W_FechaInicio DATE, W_FechaFin DATE, salidaEsperada BOOLEAN) AS
		salida BOOLEAN := true;
		gasto gastos%ROWTYPE;
		W_OID_G INTEGER;
	BEGIN 
		--Insertar gasto--
		INSERT INTO gastos(NOMBRE, DESCRIPCION, COSTE, FECHAPAGO, FECHAINICIO, FECHAFIN) VALUES(W_Nombre,W_Descripcion, W_Coste, W_FechaPago, W_FechaInicio, W_FechaFin); 
		--Seleccionar gasto y comprobar que los datos se insertan correctamente--
		W_OID_G:= sec_gastos.currval;
		SELECT * INTO gasto FROM gastos WHERE OID_G = W_OID_G;
		IF(GASTO.NOMBRE<>W_Nombre and GASTO.Descripcion<>W_Descripcion and GASTO.Coste<>W_Coste and GASTO.FechaPago<>W_FechaPago and GASTO.FechaInicio<>W_FechaInicio and GASTO.FechaFin<>W_FechaFin) THEN
			salida:=false;
		END IF;
		COMMIT WORK;
		
		--Mostrar resultado de la prueba--
		DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salidaEsperada));
		
		EXCEPTION 
		WHEN OTHERS THEN 
			DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
			ROLLBACK;
	END insertar;
	
	--PRUEBA PARA LA ACTUALIZACION DE GASTOS-- 
	PROCEDURE actualizar (nombre_prueba VARCHAR2, W_OID_G INTEGER, W_Nombre VARCHAR2, W_Descripcion VARCHAR2, W_Coste NUMBER, W_FechaPago DATE, W_FechaInicio DATE, W_FechaFin DATE, salidaEsperada BOOLEAN) AS
		salida BOOLEAN := true;
		gasto gastos%ROWTYPE;
	BEGIN
		--Actualizar empleado--
		UPDATE gastos SET Nombre=W_Nombre, Descripcion=W_Descripcion, Coste=W_coste, FechaPago=W_FechaPago, FechaInicio=W_FechaInicio, FechaFin=W_FechaFin WHERE OID_G=W_OID_G;
		
		--Seleccionar gasto y comprobar que los campos se actualizaron correctamente--
		SELECT * INTO gasto FROM GASTOS WHERE OID_G = W_OID_G;
		IF(GASTO.NOMBRE<>W_Nombre and GASTO.Descripcion<>W_Descripcion and GASTO.Coste<>W_Coste and GASTO.FechaPago<>W_FechaPago and GASTO.FechaInicio<>W_FechaInicio and GASTO.FechaFin<>W_FechaFin) THEN 
			salida:= false;
		END IF;
		COMMIT WORK;
		
		--Mostrar resultado de la prueba--
		DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salidaEsperada));
		
		EXCEPTION 
		WHEN OTHERS THEN 
			DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
			ROLLBACK;
	END actualizar;
	
	--PRUEBA PARA LA ELIMINACION DE GASTOS--
	PROCEDURE eliminar (nombre_prueba VARCHAR2, W_OID_G INTEGER, salidaEsperada BOOLEAN) AS
	salida BOOLEAN := true;
	n_gastos INTEGER;
	BEGIN
		--Eliminar gasto--
		DELETE FROM gastos WHERE OID_G=W_OID_G;
		
		--Verificar que el gasto no se encuentra en la BD--
		SELECT COUNT (*) INTO n_gastos FROM gastos WHERE OID_G=W_OID_G;
		IF(n_gastos<>0) THEN
			salida:=false;
		END IF;
		COMMIT WORK;
		
		--Mostrar resultado de la prueba--
		DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salidaEsperada));
		
		EXCEPTION 
		WHEN OTHERS THEN 
			DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
			ROLLBACK;
	END eliminar;
END PRUEBAS_GASTOS;
/
	
	
---------------------PRUEBA_CLIENTES-----------------------------------------------------------
create or replace
PACKAGE PRUEBAS_CLIENTES AS

	PROCEDURE inicializar;
	PROCEDURE insertar
		(nombre_prueba VARCHAR2, W_Nombre VARCHAR2, W_Direccion VARCHAR2, W_NumeroTelefono VARCHAR2, W_CorreoElectronico VARCHAR2, salidaEsperada BOOLEAN);
	PROCEDURE actualizar
		(nombre_prueba VARCHAR2, W_OID_C INTEGER, W_Nombre VARCHAR2, W_Direccion VARCHAR2, W_NumeroTelefono VARCHAR2, W_CorreoElectronico VARCHAR2, salidaEsperada BOOLEAN);
	PROCEDURE eliminar
		(nombre_prueba VARCHAR2, W_OID_C INTEGER, salidaEsperada BOOLEAN);
		
END PRUEBAS_CLIENTES;	
/

create or replace
PACKAGE BODY PRUEBAS_CLIENTES AS
	--INICIALIZACION
	PROCEDURE inicializar AS
	BEGIN
	--Borrar contenido de la tabla--
		DELETE FROM CLIENTES;
	END inicializar;
	
	--PRUEBA PARA LA INSERCION DE CLIENTES--
	PROCEDURE insertar (nombre_prueba VARCHAR2, W_Nombre VARCHAR2, W_Direccion VARCHAR2, W_NumeroTelefono VARCHAR2, W_CorreoElectronico VARCHAR2, salidaEsperada BOOLEAN) AS
		salida BOOLEAN := true;
		cliente clientes%ROWTYPE;
		W_OID_C INTEGER;
	BEGIN 
		--Insertar cliente--
		INSERT INTO clientes(NOMBRE, DIRECCION, NUMEROTELEFONO,CORREOELECTRONICO) VALUES(W_Nombre,W_Direccion, W_NumeroTelefono, W_CorreoElectronico); 
		--Seleccionar cliente y comprobar que los datos se insertan correctamente--
		W_OID_C:= sec_clientes.currval;
		SELECT * INTO cliente FROM clientes c WHERE c.OID_C = W_OID_C;
		IF(CLIENTE.NOMBRE<>W_Nombre and CLIENTE.Direccion<>W_Direccion and CLIENTE.NumeroTelefono<>W_NumeroTelefono and CLIENTE.CorreoElectronico<>W_CorreoElectronico) THEN
			salida:=false;
		END IF;
		COMMIT WORK;
		
		--Mostrar resultado de la prueba--
		DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salidaEsperada));
		
		EXCEPTION 
		WHEN OTHERS THEN 
			DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
			ROLLBACK;
	END insertar;

--PRUEBA PARA LA ACTUALIZACION DE CLIENTE--  
	PROCEDURE actualizar (nombre_prueba VARCHAR2, W_OID_C INTEGER, W_Nombre VARCHAR2, W_Direccion VARCHAR2, W_NumeroTelefono VARCHAR2, W_CorreoElectronico VARCHAR2, salidaEsperada BOOLEAN) AS
		salida BOOLEAN := true;
		cliente clientes%ROWTYPE;
	BEGIN
		--Actualizar cliente--
		UPDATE clientes SET Nombre=W_Nombre, Direccion=W_Direccion, NumeroTelefono=W_NumeroTelefono, CorreoElectronico=W_CorreoElectronico WHERE OID_C=W_OID_C;
		
		--Seleccionar cliente y comprobar que los campos se actualizaron correctamente--
		SELECT * INTO cliente FROM CLIENTES c WHERE c.OID_C = W_OID_C;
		IF(CLIENTE.NOMBRE<>W_Nombre and CLIENTE.Direccion<>W_Direccion and CLIENTE.NumeroTelefono<>W_NumeroTelefono and CLIENTE.CorreoElectronico<>W_CorreoElectronico) THEN 
			salida:= false;
		END IF;
		COMMIT WORK;
		
		--Mostrar resultado de la prueba--
		DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salidaEsperada));
		
		EXCEPTION 
		WHEN OTHERS THEN 
			DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
			ROLLBACK;
	END actualizar;

--PRUEBA PARA LA ELIMINACION DE CLIENTES--
	PROCEDURE eliminar (nombre_prueba VARCHAR2, W_OID_C INTEGER, salidaEsperada BOOLEAN) AS
	salida BOOLEAN := true;
	n_clientes INTEGER;
	BEGIN
		--Eliminar cliente--
		DELETE FROM CLIENTES C WHERE C.OID_C=W_OID_C;
		
		--Verificar que el cliente no se encuentra en la BD--
		SELECT COUNT (*) INTO n_clientes FROM clientes WHERE OID_C=W_OID_C;
		IF(n_clientes<>0) THEN
			salida:=false;
		END IF;
		COMMIT WORK;
		
		--Mostrar resultado de la prueba--
		DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salidaEsperada));
		
		EXCEPTION 
		WHEN OTHERS THEN 
			DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
			ROLLBACK;
	END eliminar;
END PRUEBAS_CLIENTES;
/

--------------PRUEBA EMPLEADOS---------------------------------------------------------------------
create or replace
PACKAGE PRUEBAS_EMPLEADOS AS
	PROCEDURE inicializar;
	PROCEDURE insertar
	(nombre_prueba VARCHAR2, W_NombreE VARCHAR2, W_TipoCamion VARCHAR2, salidaEsperada BOOLEAN);
	PROCEDURE actualizar
	(nombre_prueba VARCHAR2, W_OID_E INTEGER, W_NombreE VARCHAR2, W_TipoCamion VARCHAR2, salidaEsperada BOOLEAN);
	PROCEDURE eliminar
	(nombre_prueba VARCHAR2, W_OID_E INTEGER, salidaEsperada BOOLEAN);
	
END PRUEBAS_EMPLEADOS;
/
---------------------CUERPO DEL PAQUETE PRUEBAS_EMPLEADOS---------------------
create or replace
PACKAGE BODY PRUEBAS_EMPLEADOS AS
	--INICIALIZACION
	PROCEDURE inicializar AS
	BEGIN
	--Borrar contenido de la tabla--
		DELETE FROM EMPLEADOS;
	END inicializar;
	
	--PRUEBA PARA LA INSERCION DE EMPLEADOS--
	PROCEDURE insertar (nombre_prueba VARCHAR2, W_NombreE VARCHAR2, W_TipoCamion VARCHAR2, salidaEsperada BOOLEAN) AS
		salida BOOLEAN := true;
		empleado empleados%ROWTYPE;
		W_OID_E INTEGER;
	BEGIN 
		--Insertar empleado--
		INSERT INTO empleados(NOMBREE, TIPOCAMION) VALUES(W_NombreE, W_TipoCamion); 
		--Seleccionar empleado y comprobar que los datos se insertan correctamente--
		W_OID_E:= sec_empleados.currval;
		SELECT * INTO empleado FROM empleados WHERE OID_E = W_OID_E;
		IF(EMPLEADO.NOMBREE<>W_NombreE and EMPLEADO.TIPOCAMION<>W_TipoCamion) THEN
			salida:=false;
		END IF;
		COMMIT WORK;
		
		--Mostrar resultado de la prueba--
		DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salidaEsperada));
		
		EXCEPTION 
		WHEN OTHERS THEN 
			DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
			ROLLBACK;
	END insertar;
	
	--PRUEBA PARA LA ACTUALIZACION DE EMPLEADOS--  
	PROCEDURE actualizar (nombre_prueba VARCHAR2, W_OID_E INTEGER, W_NombreE VARCHAR2, W_TipoCamion VARCHAR2, salidaEsperada BOOLEAN) AS
		salida BOOLEAN := true;
		empleado empleados%ROWTYPE;
	BEGIN
		--Actualizar empleado--
		UPDATE empleados SET NombreE=W_NombreE, TipoCamion=W_TipoCamion WHERE OID_E=W_OID_E;
		
		--Seleccionar gasto y comprobar que los campos se actualizaron correctamente--
		SELECT * INTO empleado FROM EMPLEADOS WHERE OID_E = W_OID_E;
		IF(EMPLEADO.NOMBREE<>W_NombreE and EMPLEADO.TIPOCAMION<>W_TipoCamion) THEN 
			salida:= false;
		END IF;
		COMMIT WORK;
		
		--Mostrar resultado de la prueba--
		DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salidaEsperada));
		
		EXCEPTION 
		WHEN OTHERS THEN 
			DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
			ROLLBACK;
	END actualizar;
	
	--PRUEBA PARA LA ELIMINACION DE EMPLEADOS--
	PROCEDURE eliminar (nombre_prueba VARCHAR2, W_OID_E INTEGER, salidaEsperada BOOLEAN) AS
	salida BOOLEAN := true;
	n_empleados INTEGER;
	BEGIN
		--Eliminar empleado--
		DELETE FROM empleados WHERE OID_E=W_OID_E;
		
		--Verificar que el empleado no se encuentra en la BD--
		SELECT COUNT (*) INTO n_empleados FROM empleados WHERE OID_E=W_OID_E;
		IF(n_empleados<>0) THEN
			salida:=false;
		END IF;
		COMMIT WORK;
		
		--Mostrar resultado de la prueba--
		DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salidaEsperada));
		
		EXCEPTION 
		WHEN OTHERS THEN 
			DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
			ROLLBACK;
	END eliminar;
END PRUEBAS_EMPLEADOS;
/

----------------PRUEBA_SERVICIOS--------------------------------------------------------------------
create or replace
PACKAGE PRUEBAS_SERVICIOS AS
	PROCEDURE inicializar;
	PROCEDURE insertar
	(nombre_prueba VARCHAR2, W_TipoServicio VARCHAR2, W_DistanciaKM INTEGER, W_HorasGrua INTEGER, W_TamañoCuba VARCHAR2, W_PesoKG INTEGER, W_VolumenM3 INTEGER, salidaEsperada BOOLEAN);
	PROCEDURE actualizar
	(nombre_prueba VARCHAR2, W_OID_S INTEGER, W_TipoServicio VARCHAR2, W_DistanciaKM INTEGER, W_HorasGrua INTEGER, W_TamañoCuba VARCHAR2, W_PesoKG INTEGER, W_VolumenM3 INTEGER, salidaEsperada BOOLEAN);
	PROCEDURE eliminar
	(nombre_prueba VARCHAR2, W_OID_S INTEGER, salidaEsperada BOOLEAN);
	
END PRUEBAS_SERVICIOS;
/
---------------------CUERPO DEL PAQUETE PRUEBAS_SERVICIOS---------------------
create or replace
PACKAGE BODY PRUEBAS_SERVICIOS AS
	--INICIALIZACION
	PROCEDURE inicializar AS
	BEGIN
	--Borrar contenido de la tabla--
		DELETE FROM SERVICIOS;
	END inicializar;
	
	--PRUEBA PARA LA INSERCION DE SERVICIOS--
	PROCEDURE insertar (nombre_prueba VARCHAR2, W_TipoServicio VARCHAR2, W_DistanciaKM INTEGER, W_HorasGrua INTEGER, W_TamañoCuba VARCHAR2, W_PesoKG INTEGER, W_VolumenM3 INTEGER, salidaEsperada BOOLEAN) AS
		salida BOOLEAN := true;
		servicio servicios%ROWTYPE;
		W_OID_S INTEGER;
	BEGIN 
		--Insertar servicio--
		INSERT INTO servicios(TIPOSERVICIO,DISTANCIAKM, HORASGRUA, TAMAÑOCUBA,PESOKG,VOLUMENM3) VALUES(W_TipoServicio, W_DistanciaKM, W_HorasGrua, W_TamañoCuba, W_PesoKG, W_VolumenM3); 
		--Seleccionar empleado y comprobar que los datos se insertan correctamente--
		W_OID_S:= sec_servicios.currval;
		SELECT * INTO servicio FROM servicios WHERE OID_S = W_OID_S;
		IF(SERVICIO.TIPOSERVICIO<>W_TipoServicio and SERVICIO.DISTANCIAKM<>W_DistanciaKM and SERVICIO.HORASGRUA<>W_HorasGrua and SERVICIO.TAMAÑOCUBA<>W_TamañoCuba and SERVICIO.PESOKG<>W_PesoKG AND SERVICIO.VOLUMENM3<>W_VolumenM3) THEN
			salida:=false;
		END IF;
		COMMIT WORK;
		
		--Mostrar resultado de la prueba--
		DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salidaEsperada));
		
		EXCEPTION 
		WHEN OTHERS THEN 
			DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
			ROLLBACK;
	END insertar;
	
	--PRUEBA PARA LA ACTUALIZACION DE SERVICIOS--  
	PROCEDURE actualizar (nombre_prueba VARCHAR2, W_OID_S INTEGER, W_TipoServicio VARCHAR2, W_DistanciaKM INTEGER, W_HorasGrua INTEGER, W_TamañoCuba VARCHAR2, W_PesoKG INTEGER, W_VolumenM3 INTEGER, salidaEsperada BOOLEAN) AS
		salida BOOLEAN := true;
		servicio servicios%ROWTYPE;
	BEGIN
		--Actualizar empleado--
		UPDATE servicios SET TipoServicio=W_TipoServicio, DistanciaKM=W_DistanciaKM, HorasGrua=W_HorasGrua, TamañoCuba=W_TamañoCuba, PesoKG=W_PesoKG, VolumenM3=W_VolumenM3 WHERE OID_S=W_OID_S;
		
		--Seleccionar gasto y comprobar que los campos se actualizaron correctamente--
		SELECT * INTO servicio FROM SERVICIOS WHERE OID_S = W_OID_S;
		IF(SERVICIO.TIPOSERVICIO<>W_TipoServicio and SERVICIO.DISTANCIAKM<>W_DistanciaKM and SERVICIO.HORASGRUA<>W_HorasGrua and SERVICIO.TAMAÑOCUBA<>W_TamañoCuba and SERVICIO.PESOKG<>W_PesoKG AND SERVICIO.VOLUMENM3<>W_VolumenM3) THEN 
			salida:= false;
		END IF;
		COMMIT WORK;
		
		--Mostrar resultado de la prueba--
		DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salidaEsperada));
		
		EXCEPTION 
		WHEN OTHERS THEN 
			DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
			ROLLBACK;
	END actualizar;
	
	--PRUEBA PARA LA ELIMINACION DE SERVICIOS--
	PROCEDURE eliminar (nombre_prueba VARCHAR2, W_OID_S INTEGER, salidaEsperada BOOLEAN) AS
	salida BOOLEAN := true;
	n_servicios INTEGER;
	BEGIN
		--Eliminar servicio--
		DELETE FROM servicios WHERE OID_S=W_OID_S;
		
		--Verificar que el servicio no se encuentra en la BD--
		SELECT COUNT (*) INTO n_servicios FROM servicios WHERE OID_S=W_OID_S;
		IF(n_servicios<>0) THEN
			salida:=false;
		END IF;
		COMMIT WORK;
		
		--Mostrar resultado de la prueba--
		DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salidaEsperada));
		
		EXCEPTION 
		WHEN OTHERS THEN 
			DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
			ROLLBACK;
	END eliminar;
END PRUEBAS_SERVICIOS;
/


----------------PRUEBA_FACTURAS--------------------------------------------------------------------
create or replace
PACKAGE PRUEBAS_FACTURAS AS
	PROCEDURE inicializar;
	PROCEDURE insertar
	(nombre_prueba VARCHAR2, W_NumPedidos INTEGER, W_PrecioSinIva NUMBER, W_EstaPagado CHAR, W_FechaCreacion DATE, salidaEsperada BOOLEAN);
	PROCEDURE actualizar
	(nombre_prueba VARCHAR2, W_OID_F INTEGER, W_NumPedidos INTEGER, W_PrecioSinIva NUMBER, W_EstaPagado CHAR, W_FechaCreacion DATE, salidaEsperada BOOLEAN);
	PROCEDURE eliminar
	(nombre_prueba VARCHAR2, W_OID_F INTEGER, salidaEsperada BOOLEAN);
	
END PRUEBAS_FACTURAS;
/
---------------------CUERPO DEL PAQUETE PRUEBAS_FACTURAS---------------------
create or replace
PACKAGE BODY PRUEBAS_FACTURAS AS
	--INICIALIZACION
	PROCEDURE inicializar AS
	BEGIN
	--Borrar contenido de la tabla--
		DELETE FROM FACTURAS;
	END inicializar;
	
	--PRUEBA PARA LA INSERCION DE FACTURAS--
	PROCEDURE insertar 	(nombre_prueba VARCHAR2, W_NumPedidos INTEGER, W_PrecioSinIva NUMBER, W_EstaPagado CHAR, W_FechaCreacion DATE, salidaEsperada BOOLEAN) AS
		salida BOOLEAN := true;
		factura facturas%ROWTYPE;
		W_OID_F INTEGER;
	BEGIN 
		--Insertar factura--
		INSERT INTO facturas(NUMPEDIDOS,PrecioSinIva, ESTAPAGADO,FECHACREACION) VALUES(W_NumPedidos,W_PrecioSinIva, W_EstaPagado,W_FechaCreacion); 
		--Seleccionar factura y comprobar que los datos se insertan correctamente--
		W_OID_F:= sec_facturas.currval;
		SELECT * INTO factura FROM facturas WHERE OID_F = W_OID_F;
		IF(FACTURA.NUMPEDIDOS<>W_NumPedidos and FACTURA.PrecioSinIva<>w_PrecioSinIva and FACTURA.ESTAPAGADO<>W_EstaPagado and FACTURA.FechaCreacion<>W_FechaCreacion) THEN
			salida:=false;
		END IF;
		COMMIT WORK;
		
		--Mostrar resultado de la prueba--
		DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salidaEsperada));
		
		EXCEPTION 
		WHEN OTHERS THEN 
			DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
			ROLLBACK;
	END insertar;
	
	--PRUEBA PARA LA ACTUALIZACION DE FACTURAS--  
	PROCEDURE actualizar (nombre_prueba VARCHAR2, w_OID_F INTEGER,W_NumPedidos INTEGER, W_PrecioSinIva NUMBER, W_EstaPagado CHAR, W_FechaCreacion DATE, salidaEsperada BOOLEAN) AS
		salida BOOLEAN := true;
		factura facturas%ROWTYPE;
	BEGIN
		--Actualizar factura--
		UPDATE facturas SET NumPedidos=W_NumPedidos,PrecioSinIva=W_PrecioSinIva, EstaPagado=W_EstaPagado, FechaCreacion=W_FechaCreacion WHERE OID_F=W_OID_F;
		
		--Seleccionar factura y comprobar que los campos se actualizaron correctamente--
		SELECT * INTO factura FROM FACTURAS WHERE OID_F = W_OID_F;
		IF(FACTURA.NUMPEDIDOS<>W_NumPedidos and FACTURA.PrecioSinIva<>W_PrecioSinIva and FACTURA.ESTAPAGADO<>W_EstaPagado and FACTURA.FechaCreacion<>W_FechaCreacion) THEN 
			salida:= false;
		END IF;
		COMMIT WORK;
		
		--Mostrar resultado de la prueba--
		DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salidaEsperada));
		
		EXCEPTION 
		WHEN OTHERS THEN 
			DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
			ROLLBACK;
	END actualizar;
	
	--PRUEBA PARA LA ELIMINACION DE FACTURAS--
	PROCEDURE eliminar (nombre_prueba VARCHAR2, W_OID_F INTEGER, salidaEsperada BOOLEAN) AS
	salida BOOLEAN := true;
	n_facturas INTEGER;
	BEGIN
		--Eliminar servicio--
		DELETE FROM facturas WHERE OID_F=W_OID_F;
		
		--Verificar que la factura no se encuentra en la BD--
		SELECT COUNT (*) INTO n_facturas FROM facturas WHERE OID_F=W_OID_F;
		IF(n_facturas<>0) THEN
			salida:=false;
		END IF;
		COMMIT WORK;
		
		--Mostrar resultado de la prueba--
		DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salidaEsperada));
		
		EXCEPTION 
		WHEN OTHERS THEN 
			DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
			ROLLBACK;
	END eliminar;
END PRUEBAS_FACTURAS;
/

----------------PRUEBA_PEDIDOS--------------------------------------------------------------------
create or replace
PACKAGE PRUEBAS_PEDIDOS AS
	PROCEDURE inicializar;
	PROCEDURE insertar
	(nombre_prueba VARCHAR2, W_precio NUMBER, W_Direccion VARCHAR2, W_Fecha DATE, W_OID_C INTEGER, W_OID_E INTEGER, W_OID_S INTEGER, salidaEsperada BOOLEAN);
	PROCEDURE actualizar
	(nombre_prueba VARCHAR2, W_OID_P INTEGER, W_precio NUMBER, W_Direccion VARCHAR2, W_Fecha DATE, W_OID_C INTEGER, W_OID_E INTEGER, W_OID_S INTEGER, salidaEsperada BOOLEAN);
	PROCEDURE eliminar
	(nombre_prueba VARCHAR2, W_OID_P INTEGER, salidaEsperada BOOLEAN);
	
END PRUEBAS_PEDIDOS;
/
---------------------CUERPO DEL PAQUETE PRUEBAS_PEDIDOS---------------------
create or replace
PACKAGE BODY PRUEBAS_PEDIDOS AS
	--INICIALIZACION
	PROCEDURE inicializar AS
	BEGIN
	--Borrar contenido de la tabla--
		DELETE FROM PEDIDOS;
	END inicializar;
	
	--PRUEBA PARA LA INSERCION DE PEDIDOS--
	PROCEDURE insertar (nombre_prueba VARCHAR2, W_precio NUMBER, W_Direccion VARCHAR2, W_Fecha DATE, W_OID_C INTEGER, W_OID_E INTEGER, W_OID_S INTEGER, salidaEsperada BOOLEAN) AS
		salida BOOLEAN := true;
		pedido pedidos%ROWTYPE;
		W_OID_P INTEGER;
	BEGIN 
		--Insertar pedido--
		INSERT INTO pedidos(PRECIO,DIRECCION,FECHA, OID_C, OID_E, OID_S) VALUES(W_precio, W_Direccion, W_Fecha, W_OID_C, w_OID_E, W_OID_S); 
		--Seleccionar factura y comprobar que los datos se insertan correctamente--
		W_OID_P:= sec_pedidos.currval;
		SELECT * INTO pedido FROM pedidos WHERE OID_P = W_OID_P;
		IF(PEDIDO.DIRECCION<>W_Direccion and PEDIDO.FECHA<>W_Fecha and PEDIDO.OID_C<>W_OID_C AND PEDIDO.OID_E<>w_OID_E AND PEDIDO.OID_S<>w_OID_S) THEN
			salida:=false;
		END IF;
		COMMIT WORK;
		
		--Mostrar resultado de la prueba--
		DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salidaEsperada));
		
		EXCEPTION 
		WHEN OTHERS THEN 
			DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
			ROLLBACK;
	END insertar;
	
	--PRUEBA PARA LA ACTUALIZACION DE PEDIDOS--  
	PROCEDURE actualizar (nombre_prueba VARCHAR2, W_OID_P INTEGER, W_precio NUMBER, W_Direccion VARCHAR2, W_Fecha DATE, W_OID_C INTEGER, W_OID_E INTEGER, W_OID_S INTEGER, salidaEsperada BOOLEAN) AS
		salida BOOLEAN := true;
		pedido pedidos%ROWTYPE;
	BEGIN
		--Actualizar pedido--
		UPDATE pedidos SET OID_P=W_OID_P, Precio=W_Precio, Direccion=W_Direccion, Fecha=W_Fecha, OID_C=W_OID_C, OID_E=W_OID_E, OID_S=W_OID_S WHERE OID_P=W_OID_P;
		
		--Seleccionar pedido y comprobar que los campos se actualizaron correctamente--
		SELECT * INTO pedido FROM PEDIDOS WHERE OID_P = W_OID_P;
		IF(PEDIDO.DIRECCION<>W_Direccion and PEDIDO.FECHA<>W_Fecha and PEDIDO.OID_C<>W_OID_C AND PEDIDO.OID_E<>W_OID_E AND PEDIDO.OID_S<>w_OID_S) THEN 
			salida:= false;
		END IF;
		COMMIT WORK;
		
		--Mostrar resultado de la prueba--
		DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salidaEsperada));
		
		EXCEPTION 
		WHEN OTHERS THEN 
			DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
			ROLLBACK;
	END actualizar;
	
	--PRUEBA PARA LA ELIMINACION DE PEDIDOS--
	PROCEDURE eliminar (nombre_prueba VARCHAR2, W_OID_P INTEGER, salidaEsperada BOOLEAN) AS
	salida BOOLEAN := true;
	n_pedidos INTEGER;
	BEGIN
		--Eliminar pedido--
		DELETE FROM pedidos WHERE OID_P=W_OID_P;
		
		--Verificar que el pedido no se encuentra en la BD--
		SELECT COUNT (*) INTO n_pedidos FROM pedidos WHERE OID_P=W_OID_P;
		IF(n_pedidos<>0) THEN
			salida:=false;
		END IF;
		COMMIT WORK;
		
		--Mostrar resultado de la prueba--
		DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(salida, salidaEsperada));
		
		EXCEPTION 
		WHEN OTHERS THEN 
			DBMS_OUTPUT.put_line(nombre_prueba || ':' || ASSERT_EQUALS(false,salidaEsperada));
			ROLLBACK;
	END eliminar;
END PRUEBAS_PEDIDOS;
/




--ESTA ES LA FUNCION AUXILIAR DE LAS DIAPOSITIVAS
create or replace
FUNCTION ASSERT_EQUALS(salida BOOLEAN, salida_esperada BOOLEAN) RETURN VARCHAR2 AS
BEGIN 
	IF(salida = salida_esperada) THEN
		RETURN 'EXITO';
	ELSE 
		RETURN 'FALLO';
	END IF;
END ASSERT_EQUALS;
/

