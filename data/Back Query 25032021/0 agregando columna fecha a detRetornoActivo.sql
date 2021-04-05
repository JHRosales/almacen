USE [dhlalmacen]
GO
--AGREGANDO COLUMNA FECHA EN LA TABLA DETRETORNOACTIVOS
IF NOT EXISTS(
			SELECT *
			FROM INFORMATION_SCHEMA.COLUMNS
			WHERE TABLE_NAME = N'detRetornoActivos' AND COLUMN_NAME='dFecRetornoActivos')
		BEGIN
			ALTER TABLE almacen.detRetornoActivos 
			ADD dFecRetornoActivos DATE NULL
		END
		
--AGREGANDO COLUMNA FECHA EN LA TABLA DETRETORNOMat
IF NOT EXISTS(
			SELECT *
			FROM INFORMATION_SCHEMA.COLUMNS
			WHERE TABLE_NAME = N'detRetornoMat' AND COLUMN_NAME='dFecRetornoMat')
		BEGIN
			ALTER TABLE almacen.detRetornoMat 
			ADD dFecRetornoMat DATE NULL
		END

--AGREGANDO COLUMNA FECHA EN LA TABLA DETRETORNOProd
IF NOT EXISTS(
			SELECT *
			FROM INFORMATION_SCHEMA.COLUMNS
			WHERE TABLE_NAME = N'detRetornoProd' AND COLUMN_NAME='dFecRetornoProd')
		BEGIN
			ALTER TABLE almacen.detRetornoProd 
			ADD dFecRetornoProd DATE NULL
		END
	
--AGREGANDO COLUMNA FECHA EN LA TABLA Activos
IF NOT EXISTS(
			SELECT *
			FROM INFORMATION_SCHEMA.COLUMNS
			WHERE TABLE_NAME = N'activos' AND COLUMN_NAME='disponible')
		BEGIN
			ALTER TABLE dbo.activos 
			ADD disponible varchar(2) NULL
		END
		

/*
--Cambios en add_salidaactivos
actualizar el campo de disponible de la tabla activos
--Cambios en add_entradaactvivos
actualizar el campo de disponible de la tabla activos
--Cambios en add_retornoactivos
actualizar el campo de disponible de la tabla activos
*/



		