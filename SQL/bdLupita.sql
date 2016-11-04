GRANT SELECT, INSERT, UPDATE, DELETE, EXECUTE ON cinventario.* TO 'admininventario'@'%' IDENTIFIED BY 'sisadmin0303';
GRANT SELECT, INSERT, UPDATE, DELETE, EXECUTE ON cinventario.* TO 'admininventario'@'localhost' IDENTIFIED BY 'sisadmin0303';

CREATE DATABASE cinventario;
ALTER SCHEMA `cinventario`  DEFAULT CHARACTER SET utf8  DEFAULT COLLATE utf8_spanish2_ci ;
USE cinventario;
CREATE TABLE software (
                nIdSoftware INT AUTO_INCREMENT NOT NULL,
                sDescripcion VARCHAR(100) NOT NULL,
                PRIMARY KEY (nIdSoftware)
);


CREATE TABLE departamento (
                nIdDepto INT AUTO_INCREMENT NOT NULL,
                sDepto VARCHAR(100) NOT NULL,
                PRIMARY KEY (nIdDepto)
);


CREATE TABLE equipos (
                nIdEquipo INT AUTO_INCREMENT NOT NULL,
                sSt VARCHAR(30) NOT NULL,
                nIdDepto INT NOT NULL,
                PRIMARY KEY (nIdEquipo)
);


CREATE TABLE empleadas (
                nIdEmpleado INT AUTO_INCREMENT NOT NULL,
                sNombre VARCHAR(100) NOT NULL,
                nIdDepto INT NOT NULL,
                PRIMARY KEY (nIdEmpleado)
);


CREATE TABLE inventario (
                nIdInventario INT AUTO_INCREMENT NOT NULL,
                nIdSoftware INT NOT NULL,
                nIdEquipo INT NOT NULL,
                sVersion VARCHAR(100) NOT NULL,
                nSerial VARCHAR(100) NOT NULL,
                sRutaArchivo VARCHAR(200) NOT NULL,
                nIdEmpleado INT NOT NULL,
                PRIMARY KEY (nIdInventario, nIdSoftware, nIdEquipo)
);


CREATE TABLE usuarios (
                nIdUsuario INT AUTO_INCREMENT NOT NULL,
                sUsuario VARCHAR(50) NOT NULL,
                sClave VARCHAR(100) NOT NULL,
                PRIMARY KEY (nIdUsuario)
);

ALTER TABLE empleadas
ADD COLUMN nIdSucursal INT(11) NOT NULL AFTER nIdDepto;

CREATE TABLE IF NOT EXISTS Sucursales (
  nIdSucursal INT(11) NOT NULL,
  sNombre VARCHAR(200) NULL DEFAULT NULL,
  PRIMARY KEY (nIdSucursal))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

ALTER TABLE empleadas
ADD CONSTRAINT fk_empleadas_Sucursales1
  FOREIGN KEY (nIdSucursal)
  REFERENCES Sucursales (nIdSucursal)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;




ALTER TABLE inventario ADD CONSTRAINT software_inventario_fk
FOREIGN KEY (nIdSoftware)
REFERENCES software (nIdSoftware)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE equipos ADD CONSTRAINT departamento_equipos_fk
FOREIGN KEY (nIdDepto)
REFERENCES departamento (nIdDepto)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE equipos ADD CONSTRAINT departamento_equipos_fk1
FOREIGN KEY (nIdDepto)
REFERENCES departamento (nIdDepto)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE empleadas ADD CONSTRAINT departamento_empleadas_fk
FOREIGN KEY (nIdDepto)
REFERENCES departamento (nIdDepto)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE inventario ADD CONSTRAINT equipos_inventario_fk
FOREIGN KEY (nIdEquipo)
REFERENCES equipos (nIdEquipo)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE inventario ADD CONSTRAINT empleadas_inventario_fk
FOREIGN KEY (nIdEmpleado)
REFERENCES empleadas (nIdEmpleado)
ON DELETE NO ACTION
ON UPDATE NO ACTION;



