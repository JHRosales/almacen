USE dhlalmacen
GO
/*Tabla De Tecnicos Salida Productos*/
CREATE TABLE almacen.detTecnicoProd(
	idDetTecnicoProd int PRIMARY KEY NOT NULL,
	idSalidaProd int NOT NULL,
	idTecnico int NULL,	
	vEstado char(1) NULL,
	vUsernm varchar(50) NULL,
	vHostnm varchar(50) NULL,
	dFecReg datetime NULL	
) 
GO

ALTER TABLE almacen.detTecnicoProd  WITH CHECK ADD  CONSTRAINT fk_salProd_detTecProd FOREIGN KEY(idSalidaProd)
REFERENCES almacen.salidaProd (idSalidaProd)
GO