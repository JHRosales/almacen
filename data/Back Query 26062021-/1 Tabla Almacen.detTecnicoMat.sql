USE dhlalmacen
GO
/*Tabla De Tecnicos Salida Materiales*/
CREATE TABLE almacen.detTecnicoMat(
	idDetTecnicoMat int PRIMARY KEY NOT NULL,
	idSalidaMat int NOT NULL,
	idTecnico int NULL,	
	vEstado char(1) NULL,
	vUsernm varchar(50) NULL,
	vHostnm varchar(50) NULL,
	dFecReg datetime NULL	
) 
GO

ALTER TABLE almacen.detTecnicoMat  WITH CHECK ADD  CONSTRAINT fk_salMat_detTecMat FOREIGN KEY(idSalidaMat)
REFERENCES almacen.salidaMat (idSalidaMat)
GO


