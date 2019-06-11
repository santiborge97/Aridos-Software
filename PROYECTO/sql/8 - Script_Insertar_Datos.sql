delete from PEDIDOS;
delete from CLIENTES;
delete from EMPLEADOS;
delete from SERVICIOS;
delete from FACTURAS;
delete from GASTOS;



INSERT INTO CLIENTES (OID_C, NOMBRE, NUMEROTELEFONO, CORREOELECTRONICO) VALUES (12345, 'Administrador', 123456789, 'cubashnosabreu@gmail.com');

------------------------Innsertar gastos--------------------------------------------------------------------
INSERT INTO GASTOS (Nombre, Descripcion, Coste, FechaPago, FechaInicio, FechaFin) values ('Gasoil', 'Total de gasoil mes de enero', 1500, to_date('02/02/17','DD/MM/RR'), to_date('01/01/17','DD/MM/RR'), to_date('31/01/17','DD/MM/RR'));
INSERT INTO GASTOS (Nombre, Descripcion, Coste, FechaPago, FechaInicio, FechaFin) values ('Seguros', 'Seguros mes de enero', 300, to_date('05/02/17','DD/MM/RR'), to_date('01/01/17','DD/MM/RR'), to_date('31/01/17','DD/MM/RR'));
INSERT INTO GASTOS (Nombre, Descripcion, Coste, FechaPago, FechaInicio, FechaFin) values ('Herramientas', 'Gato electrico', 1500, to_date('02/02/17','DD/MM/RR'), to_date('02/02/17','DD/MM/RR'), to_date('03/02/17','DD/MM/RR'));
INSERT INTO GASTOS (Nombre, Descripcion, Coste, FechaPago, FechaInicio, FechaFin) values ('Neumaticos', 'Cambio neumaticos traseos Camion Grua', 400, to_date('02/02/17','DD/MM/RR'), to_date('30/01/17','DD/MM/RR'), to_date('31/01/17','DD/MM/RR'));
INSERT INTO GASTOS (Nombre, Descripcion, Coste, FechaPago, FechaInicio, FechaFin) values ('Gasoil', 'Total de gasoil mes de febrero', 2000, to_date('02/03/17','DD/MM/RR'), to_date('01/02/17','DD/MM/RR'), to_date('28/02/17','DD/MM/RR'));
INSERT INTO GASTOS (Nombre, Descripcion, Coste, FechaPago, FechaInicio, FechaFin) values ('Seguros', 'Seguros mes de febrero', 300, to_date('05/03/17','DD/MM/RR'), to_date('01/02/17','DD/MM/RR'), to_date('28/02/17','DD/MM/RR'));
INSERT INTO GASTOS (Nombre, Descripcion, Coste, FechaPago, FechaInicio, FechaFin) values ('Gasoil', 'Total de gasoil mes de marzo', 1800, to_date('02/04/17','DD/MM/RR'), to_date('01/03/17','DD/MM/RR'), to_date('31/03/17','DD/MM/RR'));
INSERT INTO GASTOS (Nombre, Descripcion, Coste, FechaPago, FechaInicio, FechaFin) values ('Seguros', 'Seguros mes de marzo', 300, to_date('05/04/17','DD/MM/RR'), to_date('01/03/17','DD/MM/RR'), to_date('31/03/17','DD/MM/RR'));
INSERT INTO GASTOS (Nombre, Descripcion, Coste, FechaPago, FechaInicio, FechaFin) values ('Herramientas', 'Maza y destornillador', 40, to_date('13/04/17','DD/MM/RR'), to_date('12/04/17','DD/MM/RR'), to_date('12/04/17','DD/MM/RR'));
INSERT INTO GASTOS (Nombre, Descripcion, Coste, FechaPago, FechaInicio, FechaFin) values ('Neumaticos', 'Cambio neumaticos delanteros Camion Grua', 300, to_date('20/05/17','DD/MM/RR'), to_date('19/05/17','DD/MM/RR'), to_date('19/05/17','DD/MM/RR'));
INSERT INTO GASTOS (Nombre, Descripcion, Coste, FechaPago, FechaInicio, FechaFin) values ('Gasoil', 'Total de gasoil mes de abril', 1300, to_date('02/05/17','DD/MM/RR'), to_date('01/04/17','DD/MM/RR'), to_date('30/04/17','DD/MM/RR'));
INSERT INTO GASTOS (Nombre, Descripcion, Coste, FechaPago, FechaInicio, FechaFin) values ('Seguros', 'Seguros mes de abril', 300, to_date('05/05/17','DD/MM/RR'), to_date('01/04/17','DD/MM/RR'), to_date('30/04/17','DD/MM/RR'));
INSERT INTO GASTOS (Nombre, Descripcion, Coste, FechaPago, FechaInicio, FechaFin) values ('Gasoil', 'Total de gasoil mes de mayo', 1500, to_date('02/06/17','DD/MM/RR'), to_date('01/05/17','DD/MM/RR'), to_date('31/05/17','DD/MM/RR'));
INSERT INTO GASTOS (Nombre, Descripcion, Coste, FechaPago, FechaInicio, FechaFin) values ('Seguros', 'Seguros mes de mayo', 300, to_date('05/06/17','DD/MM/RR'), to_date('01/05/17','DD/MM/RR'), to_date('31/05/17','DD/MM/RR'));
INSERT INTO GASTOS (Nombre, Descripcion, Coste, FechaPago, FechaInicio, FechaFin) values ('Oficina', 'Reparar ordenador', 30, to_date('15/06/17','DD/MM/RR'), to_date('14/06/17','DD/MM/RR'), to_date('14/06/17','DD/MM/RR'));
INSERT INTO GASTOS (Nombre, Descripcion, Coste, FechaPago, FechaInicio, FechaFin) values ('Neumaticos', 'Neumático delantero derecho dumper', 120, to_date('21/06/17','DD/MM/RR'), to_date('20/06/17','DD/MM/RR'), to_date('20/06/17','DD/MM/RR'));
INSERT INTO GASTOS (Nombre, Descripcion, Coste, FechaPago, FechaInicio, FechaFin) values ('Gasoil', 'Total de gasoil mes de junio', 1900, to_date('02/07/17','DD/MM/RR'), to_date('01/06/17','DD/MM/RR'), to_date('30/06/17','DD/MM/RR'));
INSERT INTO GASTOS (Nombre, Descripcion, Coste, FechaPago, FechaInicio, FechaFin) values ('Seguros', 'Seguros mes de junio', 300, to_date('05/07/17','DD/MM/RR'), to_date('01/06/17','DD/MM/RR'), to_date('30/06/17','DD/MM/RR'));



DECLARE

OID_EMP_1 INTEGER;
OID_EMP_2 INTEGER;

OID_CLI_1 INTEGER;
OID_CLI_2 INTEGER;
OID_CLI_3 INTEGER;
OID_CLI_4 INTEGER;
OID_CLI_5 INTEGER;
OID_CLI_6 INTEGER;
OID_CLI_7 INTEGER;
OID_CLI_8 INTEGER;
OID_CLI_9 INTEGER;
OID_CLI_10 INTEGER;
OID_CLI_11 INTEGER;


OID_SER_1 INTEGER;
OID_SER_2 INTEGER;
OID_SER_3 INTEGER;
OID_SER_4 INTEGER;
OID_SER_5 INTEGER;
OID_SER_6 INTEGER;
OID_SER_7 INTEGER;
OID_SER_8 INTEGER;
OID_SER_9 INTEGER;
OID_SER_10 INTEGER;
OID_SER_11 INTEGER;
OID_SER_12 INTEGER;
OID_SER_13 INTEGER;
OID_SER_14 INTEGER;
OID_SER_15 INTEGER;
OID_SER_16 INTEGER;
OID_SER_17 INTEGER;
OID_SER_18 INTEGER;
OID_SER_19 INTEGER;
OID_SER_20 INTEGER;
OID_SER_21 INTEGER;
OID_SER_22 INTEGER;
OID_SER_23 INTEGER;
OID_SER_24 INTEGER;
OID_SER_25 INTEGER;


BEGIN

------------------------Empleado 1--------------------------------------------------------------------
INSERTAR_EMPLEADO('Paco', 'Camion');
SELECT SEC_EMPLEADOS.CURRVAL INTO OID_EMP_1 FROM DUAL;

------------------------Empleado 2--------------------------------------------------------------------
INSERTAR_EMPLEADO('Manuel', 'Camion_Grua');
SELECT SEC_EMPLEADOS.CURRVAL INTO OID_EMP_2 FROM DUAL;


------------------------Cliente 1--------------------------------------------------------------------
INSERTAR_CLIENTE('Pedro', 'Hospital 18', '664296350', 'pedro@a.com');
SELECT SEC_CLIENTES.CURRVAL INTO OID_CLI_1 FROM DUAL;


------------------------Servicios del cliente 1--------------------------------------------------------------------
INSERTAR_SERVICIO('CUBA_ESCOMBROS', 30, null, null, null);
SELECT SEC_SERVICIOS.CURRVAL INTO OID_SER_1 FROM DUAL;

INSERTAR_PEDIDO(50, 'Calle Marchena', to_date('02/01/17','DD/MM/RR'), OID_CLI_1, OID_EMP_1, OID_SER_1);

INSERTAR_SERVICIO('CUBA_PODA', null, null, 'PEQUEÑA', null);
SELECT SEC_SERVICIOS.CURRVAL INTO OID_SER_2 FROM DUAL;

INSERTAR_PEDIDO(20, 'Luis Daoiz', to_date('02/01/17','DD/MM/RR'), OID_CLI_1, OID_EMP_1, OID_SER_2);

INSERTAR_SERVICIO('CUBA_PODA', null, null,'MEDIANA', null);
SELECT SEC_SERVICIOS.CURRVAL INTO OID_SER_3 FROM DUAL;

INSERTAR_PEDIDO(30, 'Plaza de la Vitoria', to_date('02/01/17','DD/MM/RR'), OID_CLI_1, OID_EMP_1, OID_SER_3);

INSERTAR_SERVICIO('CUBA_PODA', null, null, 'GRANDE', null);
SELECT SEC_SERVICIOS.CURRVAL INTO OID_SER_4 FROM DUAL;

INSERTAR_PEDIDO(55, 'Alameda', to_date('02/01/17','DD/MM/RR'), OID_CLI_1, OID_EMP_1, OID_SER_4);

INSERTAR_SERVICIO('CUBA_ESTIERCOL', null, null, 'PEQUEÑA', null);
SELECT SEC_SERVICIOS.CURRVAL INTO OID_SER_5 FROM DUAL;

INSERTAR_PEDIDO(60, 'Marquesa de Sales', to_date('02/01/17','DD/MM/RR'), OID_CLI_1, OID_EMP_1, OID_SER_5);

INSERTAR_SERVICIO('CUBA_ESTIERCOL', null, null,'MEDIANA', null);
SELECT SEC_SERVICIOS.CURRVAL INTO OID_SER_6 FROM DUAL;

INSERTAR_PEDIDO(100, 'La Sierra', to_date('02/01/17','DD/MM/RR'), OID_CLI_1, OID_EMP_1, OID_SER_6);




------------------------Cliente 2--------------------------------------------------------------------
INSERTAR_CLIENTE('Ana', 'Pescadores 18', '776673756', 'ana@a.com');
SELECT SEC_CLIENTES.CURRVAL INTO OID_CLI_2 FROM DUAL;

------------------------Servicios del cliente 2--------------------------------------------------------------------
INSERTAR_SERVICIO('CUBA_ESTIERCOL', null, null, 'GRANDE', null);
SELECT SEC_SERVICIOS.CURRVAL INTO OID_SER_7 FROM DUAL;

INSERTAR_PEDIDO(100, 'Ramira', to_date('02/01/17','DD/MM/RR'), OID_CLI_2, OID_EMP_1, OID_SER_7);

INSERTAR_SERVICIO('CUBA_PODA', null, null, 'PEQUEÑA', null);
SELECT SEC_SERVICIOS.CURRVAL INTO OID_SER_8 FROM DUAL;

INSERTAR_PEDIDO(80, 'Avenida Titanic', to_date('02/01/17','DD/MM/RR'), OID_CLI_2, OID_EMP_1, OID_SER_8);

INSERTAR_SERVICIO('GRUA', null, 20, null, null);
SELECT SEC_SERVICIOS.CURRVAL INTO OID_SER_9 FROM DUAL;

INSERTAR_PEDIDO(30, 'Pantano', to_date('02/01/17','DD/MM/RR'), OID_CLI_2, OID_EMP_1, OID_SER_9);



------------------------Cliente 3--------------------------------------------------------------------
INSERTAR_CLIENTE('Manuel', 'Tenerias 18', '620658290', 'manuel@a.com');
SELECT SEC_CLIENTES.CURRVAL INTO OID_CLI_3 FROM DUAL;


INSERTAR_SERVICIO('OTRO_MATERIALES', 20, null, null, null);
SELECT SEC_SERVICIOS.CURRVAL INTO OID_SER_10 FROM DUAL;

INSERTAR_PEDIDO(45, 'Pozo Nuevo', to_date('02/01/17','DD/MM/RR'), OID_CLI_3, OID_EMP_2, OID_SER_10);

INSERTAR_SERVICIO('OTRO_MATERIALES', 35, null, null, null);
SELECT SEC_SERVICIOS.CURRVAL INTO OID_SER_11 FROM DUAL;

INSERTAR_PEDIDO(50, 'Calle Argentina', to_date('02/01/17','DD/MM/RR'), OID_CLI_3, OID_EMP_2, OID_SER_11);


INSERTAR_SERVICIO('OTRO_MATERIALES', 5, null, null, null);
SELECT SEC_SERVICIOS.CURRVAL INTO OID_SER_12 FROM DUAL;

INSERTAR_PEDIDO(60, 'Ciudadela', to_date('02/01/17','DD/MM/RR'), OID_CLI_3, OID_EMP_2, OID_SER_12);



------------------------Cliente 4--------------------------------------------------------------------
INSERTAR_CLIENTE('Lola', 'Gibraleón 18', '663165977', 'lola@a.com');
SELECT SEC_CLIENTES.CURRVAL INTO OID_CLI_4 FROM DUAL;

INSERTAR_SERVICIO('OTRO_MATERIALES', 20, null, null, null);
SELECT SEC_SERVICIOS.CURRVAL INTO OID_SER_13 FROM DUAL;

INSERTAR_PEDIDO(180, 'Calle Nueva', to_date('02/01/17','DD/MM/RR'), OID_CLI_4, OID_EMP_2, OID_SER_13);


INSERTAR_SERVICIO('OTRO_MATERIALES', 30, null, null, null);
SELECT SEC_SERVICIOS.CURRVAL INTO OID_SER_14 FROM DUAL;

INSERTAR_PEDIDO(180, 'Rúa Vieja', to_date('02/01/17','DD/MM/RR'), OID_CLI_4, OID_EMP_2, OID_SER_14);


------------------------Cliente 5--------------------------------------------------------------------
INSERTAR_CLIENTE('Juan Andrés', 'Flor 18', '657342551', 'juanandres@a.com');
SELECT SEC_CLIENTES.CURRVAL INTO OID_CLI_5 FROM DUAL;

INSERTAR_SERVICIO('LEÑA', null, null, null, 1000);
SELECT SEC_SERVICIOS.CURRVAL INTO OID_SER_15 FROM DUAL;

INSERTAR_PEDIDO(35, 'Calle Bosque', to_date('02/01/17','DD/MM/RR'), OID_CLI_5, OID_EMP_2, OID_SER_15);

INSERTAR_SERVICIO('LEÑA', null, null, null, 2000);
SELECT SEC_SERVICIOS.CURRVAL INTO OID_SER_16 FROM DUAL;

INSERTAR_PEDIDO(100, 'Calle Sandía', to_date('02/01/17','DD/MM/RR'), OID_CLI_5, OID_EMP_2, OID_SER_16);

INSERTAR_SERVICIO('LEÑA', null, null, null, 2050);
SELECT SEC_SERVICIOS.CURRVAL INTO OID_SER_17 FROM DUAL;

INSERTAR_PEDIDO(150, 'Calle Tomate', to_date('02/01/17','DD/MM/RR'), OID_CLI_5, OID_EMP_2, OID_SER_17);

INSERTAR_SERVICIO('LEÑA', null, null, null, 1999);
SELECT SEC_SERVICIOS.CURRVAL INTO OID_SER_18 FROM DUAL;

INSERTAR_PEDIDO(80, 'Calle Manzana', to_date('02/01/17','DD/MM/RR'), OID_CLI_5, OID_EMP_2, OID_SER_18);


------------------------Cliente 6--------------------------------------------------------------------
INSERTAR_CLIENTE('Luisa', 'Lepe 18', '743544505', 'luisa@a.com');
SELECT SEC_CLIENTES.CURRVAL INTO OID_CLI_6 FROM DUAL;

INSERTAR_SERVICIO('LEÑA', null, null, null, 2500);
SELECT SEC_SERVICIOS.CURRVAL INTO OID_SER_19 FROM DUAL;

INSERTAR_PEDIDO(200, 'Poeta Benitez Carrasco', to_date('02/01/17','DD/MM/RR'), OID_CLI_6, OID_EMP_2, OID_SER_19);

INSERTAR_SERVICIO('LEÑA', null, null, null, 1500);
SELECT SEC_SERVICIOS.CURRVAL INTO OID_SER_20 FROM DUAL;

INSERTAR_PEDIDO(50, 'Parroco González Abato', to_date('02/01/17','DD/MM/RR'), OID_CLI_6, OID_EMP_2, OID_SER_20);

INSERTAR_SERVICIO('LEÑA', null, null, null, 3500);
SELECT SEC_SERVICIOS.CURRVAL INTO OID_SER_21 FROM DUAL;

INSERTAR_PEDIDO(400, 'Calle Miguel Cifredo', to_date('02/01/17','DD/MM/RR'), OID_CLI_6, OID_EMP_2, OID_SER_21);


------------------------Cliente 7--------------------------------------------------------------------
INSERTAR_CLIENTE('Javier', 'Pila 18', '670091319', 'javier@a.com');
SELECT SEC_CLIENTES.CURRVAL INTO OID_CLI_7 FROM DUAL;

INSERTAR_SERVICIO('LEÑA', null, null, null, 4300);
SELECT SEC_SERVICIOS.CURRVAL INTO OID_SER_22 FROM DUAL;

INSERTAR_PEDIDO(100, 'Soledad', to_date('02/01/17','DD/MM/RR'), OID_CLI_7, OID_EMP_1, OID_SER_22);

------------------------Cliente 8--------------------------------------------------------------------
INSERTAR_CLIENTE('Marcos', 'Plaza 18', '612352360', 'marcos@a.com');
SELECT SEC_CLIENTES.CURRVAL INTO OID_CLI_8 FROM DUAL;

INSERTAR_SERVICIO('GRUA', null, 1, null, null);
SELECT SEC_SERVICIOS.CURRVAL INTO OID_SER_23 FROM DUAL;

INSERTAR_PEDIDO(50, 'Turel', to_date('02/01/17','DD/MM/RR'), OID_CLI_8, OID_EMP_1, OID_SER_23);

INSERTAR_SERVICIO('GRUA', null, 10, null, null);
SELECT SEC_SERVICIOS.CURRVAL INTO OID_SER_24 FROM DUAL;

INSERTAR_PEDIDO(100, 'Jaén', to_date('02/01/17','DD/MM/RR'), OID_CLI_8, OID_EMP_1, OID_SER_24);


------------------------Cliente 9--------------------------------------------------------------------
INSERTAR_CLIENTE('Zambrano', 'Nueva 18', '637152620', 'zambrano@a.com');
SELECT SEC_CLIENTES.CURRVAL INTO OID_CLI_9 FROM DUAL;

INSERTAR_SERVICIO('GRUA', null, 1, null, null);
SELECT SEC_SERVICIOS.CURRVAL INTO OID_SER_25 FROM DUAL;

INSERTAR_PEDIDO(50, 'Portal de Belén', to_date('02/01/17','DD/MM/RR'), OID_CLI_9, OID_EMP_1, OID_SER_25);


COMMIT;

END;