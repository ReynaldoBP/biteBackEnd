/*-------------------------------------------------------------------------------------*/
DROP DATABASE IF EXISTS massvisi_bitte;
CREATE DATABASE IF NOT EXISTS massvisi_bitte; 
USE massvisi_bitte;
DROP TABLE IF EXISTS INFO_USUARIO;
CREATE TABLE IF NOT EXISTS INFO_USUARIO (
    ID_USUARIO INT AUTO_INCREMENT,
    TIPO_ROL_ID INT,
    IDENTIFICACION VARCHAR(50) NOT NULL,
	NOMBRES VARCHAR(255) NOT NULL,
    APELLIDOS VARCHAR(255) NOT NULL,
    CONTRASENIA VARCHAR(50),
    IMAGEN VARCHAR(400),
    CORREO VARCHAR(100),
    ESTADO VARCHAR(100) NOT NULL,
	PAIS VARCHAR(100) NOT NULL,
    CIUDAD VARCHAR(100) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
	FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_USUARIO)
);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS ADMI_TIPO_ROL;
CREATE TABLE IF NOT EXISTS ADMI_TIPO_ROL (
    ID_TIPO_ROL INT AUTO_INCREMENT,
    DESCRIPCION_TIPO_ROL VARCHAR(255) NOT NULL,
    ESTADO VARCHAR(100) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
	FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_TIPO_ROL)
);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_USUARIO
ADD FOREIGN KEY FK_TIPO_ROL_ID(TIPO_ROL_ID)
REFERENCES ADMI_TIPO_ROL(ID_TIPO_ROL);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS ADMI_TIPO_COMIDA;
CREATE TABLE IF NOT EXISTS ADMI_TIPO_COMIDA (
    ID_TIPO_COMIDA INT AUTO_INCREMENT,
    DESCRIPCION_TIPO_COMIDA VARCHAR(255) NOT NULL,
    ESTADO VARCHAR(100) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
	FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_TIPO_COMIDA)
);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS INFO_RESTAURANTE;
CREATE TABLE IF NOT EXISTS INFO_RESTAURANTE (
    ID_RESTAURANTE INT AUTO_INCREMENT,
    TIPO_COMIDA_ID INT,
    TIPO_IDENTIFICACION VARCHAR(50) NOT NULL,
    IDENTIFICACION VARCHAR(100) NOT NULL,
	RAZON_SOCIAL VARCHAR(255) NOT NULL,
    NOMBRE_COMERCIAL VARCHAR(255),
    REPRESENTANTE_LEGAL VARCHAR(255),
    DIRECCION_TRIBUTARIO VARCHAR(400),
    URL_CATALOGO VARCHAR(255),
    IMAGEN VARCHAR(450),
    ICONO VARCHAR(450),
    NUMERO_CONTACTO VARCHAR(100),
    ESTADO VARCHAR(100) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
	FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_RESTAURANTE)
);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_RESTAURANTE
ADD FOREIGN KEY FK_TIPO_COMIDA_ID(TIPO_COMIDA_ID)
REFERENCES ADMI_TIPO_COMIDA(ID_TIPO_COMIDA);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS INFO_SUCURSAL;
CREATE TABLE IF NOT EXISTS INFO_SUCURSAL (
    ID_SUCURSAL INT AUTO_INCREMENT,
    RESTAURANTE_ID INT,
    DESCRIPCION VARCHAR(100),
	ES_MATRIZ VARCHAR(50) NOT NULL,
    EN_CENTRO_COMERCIAL VARCHAR(50) NOT NULL,
	DIRECCION VARCHAR(255),
    NUMERO_CONTACTO VARCHAR(100),
	ESTADO_FACTURACION VARCHAR(255) NOT NULL,
    ESTADO VARCHAR(100) NOT NULL,
    LATITUD DOUBLE,
    LONGITUD DOUBLE,
	PAIS VARCHAR(100) NOT NULL,
    PROVINCIA VARCHAR(100) NOT NULL,
    CIUDAD VARCHAR(100) NOT NULL,
    PARROQUIA VARCHAR(100) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
	FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_SUCURSAL)
);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_SUCURSAL
ADD FOREIGN KEY FK_RESTAURANTE_ID(RESTAURANTE_ID)
REFERENCES INFO_RESTAURANTE(ID_RESTAURANTE);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS ADMI_MODULO;
CREATE TABLE IF NOT EXISTS ADMI_MODULO (
    ID_MODULO INT AUTO_INCREMENT,
    DESCRIPCION VARCHAR(255) NOT NULL,
    ESTADO VARCHAR(100) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
	FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_MODULO)
);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS ADMI_ACCION;
CREATE TABLE IF NOT EXISTS ADMI_ACCION (
    ID_ACCION INT AUTO_INCREMENT,
    DESCRIPCION VARCHAR(255) NOT NULL,
    ESTADO VARCHAR(100) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
	FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_ACCION)
);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS INFO_PERFIL;
CREATE TABLE IF NOT EXISTS INFO_PERFIL (
    ID_PERFIL INT AUTO_INCREMENT,
    MODULO_ACCION_ID INT,
    USUARIO_ID INT,
    DESCRIPCION VARCHAR(255) NOT NULL,
    ESTADO VARCHAR(100) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
	FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_PERFIL)
);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_PERFIL
ADD FOREIGN KEY FK_USUARIO_ID_PERFIL(USUARIO_ID)
REFERENCES INFO_USUARIO(ID_USUARIO);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS ADMI_PARAMETRO;
CREATE TABLE IF NOT EXISTS ADMI_PARAMETRO (
    ID_PARAMETRO INT AUTO_INCREMENT,
    DESCRIPCION VARCHAR(255) NOT NULL,
    VALOR1 VARCHAR(255) NOT NULL,
    VALOR2 VARCHAR(255) NOT NULL,
    VALOR3 VARCHAR(255) NOT NULL,
    ESTADO VARCHAR(100) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
	FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_PARAMETRO)
);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS INFO_CLIENTE;
CREATE TABLE IF NOT EXISTS INFO_CLIENTE (
    ID_CLIENTE INT AUTO_INCREMENT,
    USUARIO_ID INT,
    CONTRASENIA VARCHAR(50),
    AUTENTICACION_RS VARCHAR(1),
    TIPO_CLIENTE_PUNTAJE_ID INT,
    IDENTIFICACION VARCHAR(100),
    NOMBRE VARCHAR(255) NOT NULL,
    APELLIDO VARCHAR(255),
    CORREO VARCHAR(255) NOT NULL,
    DIRECCION VARCHAR(100),
	EDAD VARCHAR(50) NOT NULL,
    TIPO_COMIDA VARCHAR(100),
    GENERO VARCHAR(100) NOT NULL,
    ESTADO VARCHAR(100) NOT NULL,
    SECTOR VARCHAR(100) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
	FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_CLIENTE)
);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_CLIENTE
ADD FOREIGN KEY FK_USUARIO_ID_CLIENTE(USUARIO_ID)
REFERENCES INFO_USUARIO(ID_USUARIO);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS INFO_CLIENTE_INFLUENCER;
CREATE TABLE IF NOT EXISTS INFO_CLIENTE_INFLUENCER (
    ID_CLIENTE_INFLUENCER INT AUTO_INCREMENT,
    CLIENTE_ID INT,
    IMAGEN VARCHAR(400),
    ESTADO VARCHAR(100) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
	FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_CLIENTE_INFLUENCER)
);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_CLIENTE_INFLUENCER
ADD FOREIGN KEY FK_CLIENTE_ID_INFLUENCER(CLIENTE_ID)
REFERENCES INFO_CLIENTE(ID_CLIENTE);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS INFO_CLIENTE_PUNTO;
CREATE TABLE IF NOT EXISTS INFO_CLIENTE_PUNTO (
    ID_CLIENTE_PUNTO INT AUTO_INCREMENT,
    CLIENTE_ID INT,
    RESTAURANTE_ID INT,
    CANTIDAD_PUNTOS INT,
    ESTADO VARCHAR(100) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
	FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_CLIENTE_PUNTO)
);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_CLIENTE_PUNTO
ADD FOREIGN KEY FK_CLIENTE_ID_PTO(CLIENTE_ID)
REFERENCES INFO_CLIENTE(ID_CLIENTE);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_CLIENTE_PUNTO
ADD FOREIGN KEY FK_RESTAURANTE_ID_CLT_PTO(RESTAURANTE_ID)
REFERENCES INFO_RESTAURANTE(ID_RESTAURANTE);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS INFO_CLIENTE_PUNTO_GLOBAL;
CREATE TABLE IF NOT EXISTS INFO_CLIENTE_PUNTO_GLOBAL (
    ID_CLIENTE_PUNTO_GLOBAL INT AUTO_INCREMENT,
    CLIENTE_ID INT,
    CANTIDAD_PUNTOS INT,
    ESTADO VARCHAR(100) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
	FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_CLIENTE_PUNTO_GLOBAL)
);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_CLIENTE_PUNTO_GLOBAL
ADD FOREIGN KEY FK_CLIENTE_ID_PTO_GLOBAL(CLIENTE_ID)
REFERENCES INFO_CLIENTE(ID_CLIENTE);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS ADMI_TIPO_CLIENTE_PUNTAJE;
CREATE TABLE IF NOT EXISTS ADMI_TIPO_CLIENTE_PUNTAJE (
    ID_TIPO_CLIENTE_PUNTAJE INT AUTO_INCREMENT,
    DESCRIPCION VARCHAR(255) NOT NULL,
    VALOR VARCHAR(255) NOT NULL,
    ESTADO VARCHAR(100) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
	FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_TIPO_CLIENTE_PUNTAJE)
);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_CLIENTE
ADD FOREIGN KEY FK_TIPO_CLIENTE_PUNTAJE_ID(TIPO_CLIENTE_PUNTAJE_ID)
REFERENCES ADMI_TIPO_CLIENTE_PUNTAJE(ID_TIPO_CLIENTE_PUNTAJE);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS INFO_PROMOCION;
CREATE TABLE IF NOT EXISTS INFO_PROMOCION (
    ID_PROMOCION INT AUTO_INCREMENT,
    RESTAURANTE_ID INT,
    DESCRIPCION_TIPO_PROMOCION VARCHAR(255) NOT NULL,
    IMAGEN VARCHAR(400),
    PREMIO VARCHAR(2),
    CANTIDAD_PUNTOS INT,
    ACEPTA_GLOBAL VARCHAR(50) NOT NULL,
    ESTADO VARCHAR(100) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
	FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_PROMOCION)
);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_PROMOCION
ADD FOREIGN KEY FK_RESTAURANTE_ID_PROMO(RESTAURANTE_ID)
REFERENCES INFO_RESTAURANTE(ID_RESTAURANTE);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS INFO_CLIENTE_PROMOCION_HISTORIAL;
CREATE TABLE IF NOT EXISTS INFO_CLIENTE_PROMOCION_HISTORIAL (
    ID_CLIENTE_PUNTO_HISTORIAL INT AUTO_INCREMENT,
    PROMOCION_ID INT,
    CLIENTE_ID INT,
    ESTADO VARCHAR(100) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
	FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_CLIENTE_PUNTO_HISTORIAL)
);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_CLIENTE_PROMOCION_HISTORIAL
ADD FOREIGN KEY FK_PROMOCION_ID(PROMOCION_ID)
REFERENCES INFO_PROMOCION(ID_PROMOCION);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_CLIENTE_PROMOCION_HISTORIAL
ADD FOREIGN KEY FK_CLIENTE_ID_PROMO(CLIENTE_ID)
REFERENCES INFO_CLIENTE(ID_CLIENTE);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS INFO_PUBLICIDAD;
CREATE TABLE IF NOT EXISTS INFO_PUBLICIDAD (
    ID_PUBLICIDAD INT AUTO_INCREMENT,
    DESCRIPCION VARCHAR(100),
	IMAGEN VARCHAR(400),
    ORIENTACION VARCHAR(50),
    EDAD_MAXIMA INT,
    EDAD_MINIMA INT,
    GENERO VARCHAR(50),
	PAIS VARCHAR(100) NOT NULL,
    PROVINCIA VARCHAR(100) NOT NULL,
    CIUDAD VARCHAR(100) NOT NULL,
    PARROQUIA VARCHAR(100) NOT NULL,
	ESTADO VARCHAR(50) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
	FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_PUBLICIDAD)
);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS INFO_ENCUESTA;
CREATE TABLE IF NOT EXISTS INFO_ENCUESTA (
    ID_ENCUESTA INT AUTO_INCREMENT,
    DESCRIPCION VARCHAR(100),
    TITULO VARCHAR(255),
	ESTADO VARCHAR(50) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
	FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_ENCUESTA)
);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS INFO_PREGUNTA;
CREATE TABLE IF NOT EXISTS INFO_PREGUNTA (
    ID_PREGUNTA INT AUTO_INCREMENT,
    ENCUESTA_ID INT,
    OPCION_RESPUESTA_ID INT,
    DESCRIPCION VARCHAR(100),
    EN_CENTRO_COMERCIAL VARCHAR(2) NOT NULL,
    OBLIGATORIA VARCHAR(50),
	ESTADO VARCHAR(50) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
	FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_PREGUNTA)
);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_PREGUNTA
ADD FOREIGN KEY FK_ENCUESTA_ID(ENCUESTA_ID)
REFERENCES INFO_ENCUESTA(ID_ENCUESTA);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS INFO_OPCION_RESPUESTA;
CREATE TABLE IF NOT EXISTS INFO_OPCION_RESPUESTA (
    ID_OPCION_RESPUESTA INT AUTO_INCREMENT,
    TIPO_RESPUESTA VARCHAR(255) NOT NULL,
    DESCRIPCION VARCHAR(100),
    VALOR VARCHAR(100),
    ESTADO VARCHAR(50) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
    FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_OPCION_RESPUESTA)
);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_PREGUNTA
ADD FOREIGN KEY FK_OPCION_RESPUESTA_ID(OPCION_RESPUESTA_ID)
REFERENCES INFO_OPCION_RESPUESTA(ID_OPCION_RESPUESTA);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS INFO_RESPUESTA;
CREATE TABLE IF NOT EXISTS INFO_RESPUESTA (
    ID_RESPUESTA INT AUTO_INCREMENT,
    PREGUNTA_ID INT,
    CLIENTE_ID INT,
    CLT_ENCUESTA_ID INT,
    RESPUESTA VARCHAR(100),
	ESTADO VARCHAR(50) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
	FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_RESPUESTA)
);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_RESPUESTA
ADD FOREIGN KEY FK_RESPUESTA_PREGUNTA_ID(PREGUNTA_ID)
REFERENCES INFO_PREGUNTA(ID_PREGUNTA);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_RESPUESTA
ADD FOREIGN KEY FK_CLIENTE_ID_RESPUESTA(CLIENTE_ID)
REFERENCES INFO_CLIENTE(ID_CLIENTE);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS INFO_REDES_SOCIALES;
CREATE TABLE IF NOT EXISTS INFO_REDES_SOCIALES (
    ID_REDES_SOCIALES INT AUTO_INCREMENT,
    DESCRIPCION VARCHAR(100),
	ESTADO VARCHAR(50) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
	FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_REDES_SOCIALES)
);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS INFO_CONTENIDO_SUBIDO;
CREATE TABLE IF NOT EXISTS INFO_CONTENIDO_SUBIDO (
    ID_CONTENIDO_SUBIDO INT AUTO_INCREMENT,
    CLIENTE_ID INT,
    REDES_SOCIALES_ID INT,
    DESCRIPCION VARCHAR(100),
    IMAGEN VARCHAR(400),
	ESTADO VARCHAR(50) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
	FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_CONTENIDO_SUBIDO)
);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_CONTENIDO_SUBIDO
ADD FOREIGN KEY FK_CLIENTE_ID_CONT(CLIENTE_ID)
REFERENCES INFO_CLIENTE(ID_CLIENTE);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_CONTENIDO_SUBIDO
ADD FOREIGN KEY FK_REDES_SOCIALES_ID(REDES_SOCIALES_ID)
REFERENCES INFO_REDES_SOCIALES(ID_REDES_SOCIALES);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS ADMI_PAIS;
CREATE TABLE IF NOT EXISTS ADMI_PAIS (
  ID_PAIS INT AUTO_INCREMENT,
  PAIS_NOMBRE VARCHAR(100),
  ESTADO VARCHAR(50) NOT NULL DEFAULT 'ACTIVO',
  PRIMARY KEY (ID_PAIS)
);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS ADMI_PROVINCIA;
CREATE TABLE IF NOT EXISTS ADMI_PROVINCIA (
  ID_PROVINCIA INT AUTO_INCREMENT,
  PROVINCIA_NOMBRE VARCHAR(100),
  REGION_NOMBRE VARCHAR(100),
  PAIS_ID INT NOT NULL,
  ESTADO VARCHAR(50) NOT NULL DEFAULT 'ACTIVO',
  PRIMARY KEY (ID_PROVINCIA)
);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE ADMI_PROVINCIA
ADD FOREIGN KEY FK_PAIS_ID(PAIS_ID)
REFERENCES ADMI_PAIS(ID_PAIS);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS ADMI_CIUDAD;
CREATE TABLE IF NOT EXISTS ADMI_CIUDAD (
  ID_CIUDAD INT AUTO_INCREMENT,
  PROVINCIA_ID INT NOT NULL,
  CIUDAD_NOMBRE VARCHAR(100),
  ESTADO VARCHAR(50) NOT NULL DEFAULT 'ACTIVO',
  PRIMARY KEY (ID_CIUDAD)
);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE ADMI_CIUDAD
ADD FOREIGN KEY FK_PROVINCIA_ID(PROVINCIA_ID)
REFERENCES ADMI_PROVINCIA(ID_PROVINCIA);
/*-------------------------------------------------------------------------------------*/

DROP TABLE IF EXISTS ADMI_PARROQUIA;
CREATE TABLE IF NOT EXISTS ADMI_PARROQUIA (
  ID_PARROQUIA INT AUTO_INCREMENT,
  CIUDAD_ID INT NOT NULL,
  PARROQUIA_NOMBRE VARCHAR(100),
  ESTADO VARCHAR(50) NOT NULL DEFAULT 'ACTIVO',
  PRIMARY KEY (ID_PARROQUIA)
);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE ADMI_PARROQUIA
ADD FOREIGN KEY FK_CIUDAD_ID(CIUDAD_ID)
REFERENCES ADMI_CIUDAD(ID_CIUDAD);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS ADMI_SECTOR;
CREATE TABLE IF NOT EXISTS ADMI_SECTOR (
  ID_SECTOR INT AUTO_INCREMENT,
  PARROQUIA_ID INT NOT NULL,
  SECTOR_NOMBRE VARCHAR(100),
  ESTADO VARCHAR(50) NOT NULL DEFAULT 'ACTIVO',
  PRIMARY KEY (ID_SECTOR)
);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE ADMI_SECTOR
ADD FOREIGN KEY FK_PARROQUIA_ID(PARROQUIA_ID)
REFERENCES ADMI_PARROQUIA(ID_PARROQUIA);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS INFO_USUARIO_RES;
CREATE TABLE IF NOT EXISTS INFO_USUARIO_RES (
    ID_USUARIO_RES INT AUTO_INCREMENT,
    USUARIO_ID INT,
    RESTAURANTE_ID INT,
	ESTADO VARCHAR(50) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
	FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_USUARIO_RES)
);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_USUARIO_RES
ADD FOREIGN KEY FK_USUARIO_ID_RES(USUARIO_ID)
REFERENCES INFO_USUARIO(ID_USUARIO);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_USUARIO_RES
ADD FOREIGN KEY FK_RESTAURANTE_ID_RES(RESTAURANTE_ID)
REFERENCES INFO_RESTAURANTE(ID_RESTAURANTE);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS INFO_PUBLICIDAD_COMIDA;
CREATE TABLE IF NOT EXISTS INFO_PUBLICIDAD_COMIDA (
    ID_PUBLICIDAD_COMIDA INT AUTO_INCREMENT,
    PUBLICIDAD_ID INT,
    TIPO_COMIDA_ID INT,
	ESTADO VARCHAR(50) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
	FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_PUBLICIDAD_COMIDA)
);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_PUBLICIDAD_COMIDA
ADD FOREIGN KEY FK_PUBLICIDAD_ID(PUBLICIDAD_ID)
REFERENCES INFO_PUBLICIDAD(ID_PUBLICIDAD);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_PUBLICIDAD_COMIDA
ADD FOREIGN KEY FK_TIPO_COMIDA_ID_COM(TIPO_COMIDA_ID)
REFERENCES ADMI_TIPO_COMIDA(ID_TIPO_COMIDA);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS INFO_LIKE_RES;
CREATE TABLE IF NOT EXISTS INFO_LIKE_RES (
    ID_LIKE INT AUTO_INCREMENT,
    RESTAURANTE_ID INT,
    CLIENTE_ID INT,
    ESTADO VARCHAR(50) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
    FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_LIKE)
);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_LIKE_RES
ADD FOREIGN KEY FK_CLIENTE_ID_LIKE(CLIENTE_ID)
REFERENCES INFO_CLIENTE(ID_CLIENTE);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_LIKE_RES
ADD FOREIGN KEY FK_RESTAURANTE_ID_LIKE(RESTAURANTE_ID)
REFERENCES INFO_RESTAURANTE(ID_RESTAURANTE);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS INFO_CLIENTE_ENCUESTA;
CREATE TABLE IF NOT EXISTS INFO_CLIENTE_ENCUESTA (
    ID_CLT_ENCUESTA INT AUTO_INCREMENT,
    SUCURSAL_ID INT,
    CLIENTE_ID INT,
    ENCUESTA_ID INT,
    CONTENIDO_ID INT,
    ESTADO VARCHAR(50) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
    FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_CLT_ENCUESTA)
);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_CLIENTE_ENCUESTA
ADD FOREIGN KEY FK_CLIENTE_CLT_ENC(CLIENTE_ID)
REFERENCES INFO_CLIENTE(ID_CLIENTE);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_CLIENTE_ENCUESTA
ADD FOREIGN KEY FK_ENCUESTA_CLT_ENC(ENCUESTA_ID)
REFERENCES INFO_ENCUESTA(ID_ENCUESTA);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_RESPUESTA
ADD FOREIGN KEY FK_CLT_ENCUESTA_ID(CLT_ENCUESTA_ID)
REFERENCES INFO_CLIENTE_ENCUESTA(ID_CLT_ENCUESTA);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_CLIENTE_ENCUESTA
ADD FOREIGN KEY FK_CONTENIDO_CLT_ENC(CONTENIDO_ID)
REFERENCES INFO_CONTENIDO_SUBIDO(ID_CONTENIDO_SUBIDO);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_CLIENTE_ENCUESTA
ADD FOREIGN KEY FK_ENCUESTA_SUCURSAL_ID(SUCURSAL_ID)
REFERENCES INFO_SUCURSAL(ID_SUCURSAL);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS INFO_MODULO_ACCION;
CREATE TABLE IF NOT EXISTS INFO_MODULO_ACCION (
    ID_MODULO_ACCION INT AUTO_INCREMENT,
    MODULO_ID INT,
    ACCION_ID INT,
    ESTADO VARCHAR(50) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
    FE_CREACION DATE,
    USR_MODIFICACION VARCHAR(255),
    FE_MODIFICACION DATE,
    PRIMARY KEY (ID_MODULO_ACCION)
);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_MODULO_ACCION
ADD FOREIGN KEY FK_MODULO_ID(MODULO_ID)
REFERENCES ADMI_MODULO(ID_MODULO);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_MODULO_ACCION
ADD FOREIGN KEY FK_ACCION_ID(ACCION_ID)
REFERENCES ADMI_ACCION(ID_ACCION);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_PERFIL
ADD FOREIGN KEY FK_MODULO_ACCION_ID(MODULO_ACCION_ID)
REFERENCES INFO_MODULO_ACCION(ID_MODULO_ACCION);
/*-------------------------------------------------------------------------------------*/
DROP TABLE IF EXISTS INFO_VISTA_PUBLICIDAD;
CREATE TABLE IF NOT EXISTS INFO_VISTA_PUBLICIDAD (
    ID_VISTA_PUBLICIDAD INT AUTO_INCREMENT,
    CLIENTE_ID INT,
    RESTAURANTE_ID INT,
    PUBLICIDAD_ID INT,
    ESTADO VARCHAR(100) NOT NULL,
    USR_CREACION VARCHAR(255) NOT NULL,
	FE_CREACION DATE,
    PRIMARY KEY (ID_VISTA_PUBLICIDAD)
);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_VISTA_PUBLICIDAD
ADD FOREIGN KEY FK_CLIENTE_PUB(CLIENTE_ID)
REFERENCES INFO_CLIENTE(ID_CLIENTE);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_VISTA_PUBLICIDAD
ADD FOREIGN KEY FK_RESTAURANTE_PUB(RESTAURANTE_ID)
REFERENCES INFO_RESTAURANTE(ID_RESTAURANTE);
/*-------------------------------------------------------------------------------------*/
ALTER TABLE INFO_VISTA_PUBLICIDAD
ADD FOREIGN KEY FK_PUBLICIDAD_ID_PUB(PUBLICIDAD_ID)
REFERENCES INFO_PUBLICIDAD(ID_PUBLICIDAD);