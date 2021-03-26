USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[Bus_Activos]    Script Date: 03/26/2021 01:30:04 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER procedure [almacen].[Bus_Activos]
 @tBusqueda varchar(1)='0',
 @vDatoBus varchar(max) 

as

if (@tBusqueda='0') goto GENERAL
if (@tBusqueda='1') goto ID
if (@tBusqueda='2') goto NOMBRE
if (@tBusqueda='3') goto SERIE
if (@tBusqueda='4') goto MARCA

GENERAL:
begin

	select idActivos,a.vNombre,a.vSerie, vMarca,
	 a.vModelo,a.vDescripcion,a.nStock,a.vEstado, case when coalesce(disponible,'0')='0' then 'NO' else 'SI' end disponible
	from dbo.Activos a;
	
RETURN
END

ID:
begin

declare @nDatoBus int
select @nDatoBus=cast(@vDatoBus as int)

	select idActivos,a.vNombre,a.vSerie,  vMarca,
	 a.vModelo,a.vDescripcion,a.nStock,a.vEstado
	 , case when coalesce(disponible,'0')='0' then 'NO' else 'SI' end disponible
	from dbo.Activos a
	where 
	a.idActivos=@nDatoBus;

RETURN
END

NOMBRE:
begin

	select idActivos,a.vNombre,a.vSerie, vMarca,
	 a.vModelo,a.vDescripcion,a.nStock,a.vEstado
	 , case when coalesce(disponible,'0')='0' then 'NO' else 'SI' end disponible
	from dbo.Activos a
	where 
	a.vNombre LIKE '%'+@vDatoBus+'%';

RETURN
END

SERIE:
begin

	select idActivos,a.vNombre,a.vSerie, vMarca,
	 a.vModelo,a.vDescripcion,a.nStock,a.vEstado
	 , case when coalesce(disponible,'0')='0' then 'NO' else 'SI' end disponible
	from dbo.Activos a
	where 
	a.vSerie LIKE '%'+@vDatoBus+'%';

RETURN
end

MARCA:
begin

	select idActivos,a.vNombre,a.vSerie, vMarca,
	 a.vModelo,a.vDescripcion,a.nStock,a.vEstado
	 , case when coalesce(disponible,'0')='0' then 'NO' else 'SI' end disponible
	from dbo.Activos a
	where 
	a.vMarca LIKE '%'+@vDatoBus+'%'

return
end