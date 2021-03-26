USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[List_SalidaActivos]    Script Date: 03/26/2021 02:33:57 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER procedure [almacen].[List_SalidaActivos]
 @tBusqueda varchar(1)='0',
 @vDatoBus varchar(max),
 @vFecIni varchar(25)='' ,
 @vFecFin varchar(25)='' 

as
declare @dFecIni datetime
declare @dFecFin datetime

set dateformat dmy  

IF @vFecIni =''
SET @vFecIni='03/06/1990'

IF @vFecFin =''
SET @vFecFin=CONVERT(varchar(10),GETDATE(),103) 


SELECT @dFecIni=CAST (@vFecIni+' 00:00:00.000' AS datetime)
SELECT @dFecFin=CAST (@vFecFin+' 23:59:59.999' AS datetime)

if (@tBusqueda='0') goto GENERAL
if (@tBusqueda='1') goto NOMACTIVO
if (@tBusqueda='2') goto ID
if (@tBusqueda='3') goto NUMCOTIZACION
if (@tBusqueda='4') goto CLIENTE
if (@tBusqueda='5') goto SERIE

GENERAL:
	begin

		select a.idSalidaActivo,
			CONVERT(VARCHAR(10),dFecSalida,103) as dFecSalida,CONVERT(VARCHAR(10), r.dFecRetorno,103) dFecRetorno
			,a.vObra,a.vLugar, b.idTecnico, b.vNombre as vTecnico
			,a.idCliente,c.vNombre as cliente,coti.idCotiz,coti.vnroCot ,a.vEstado, a.Observacion
		from almacen.salidaActivos a
		left join tecnico b on a.idTecnico=b.idTecnico
		left join almacen.retornoActivos r on a.idSalidaActivo=r.idSalidaActivos
		left join cliente c on a.idCliente=c.idCliente
		left join compras.cotizacion coti on a.idcotiz=coti.idCotiz
		where a.vEstado =1 AND 
		dFecSalida between @dFecIni and @dFecFin
		
	RETURN
END

NOMACTIVO:
	begin
		select distinct a.idSalidaActivo,CONVERT(VARCHAR(10),dFecSalida,103) as dFecSalida,CONVERT(VARCHAR(10), r.dFecRetorno,103) dFecRetorno,
			a.vObra,a.vLugar
			, b.idTecnico, b.vNombre as vTecnico
			,a.idCliente,c.vNombre as cliente,coti.idCotiz,coti.vnroCot ,a.vEstado, a.Observacion
			from almacen.salidaActivos a		
			left join tecnico b on a.idTecnico=b.idTecnico
			left join cliente c on a.idCliente=c.idCliente
			left join almacen.retornoActivos r on a.idSalidaActivo=r.idSalidaActivos
			left join compras.cotizacion coti on a.idcotiz=coti.idCotiz
			left join almacen.detSalidaActivos ds on a.idSalidaActivo=ds.idSalidaActivo
			left join activos mat on ds.idActivos=mat.idActivos
			where a.vEstado =1 AND 
			dFecSalida between @dFecIni and @dFecFin
			and mat.vNombre like '%'+@vDatoBus+'%'
			

		RETURN
END

ID:
	begin
		select a.idSalidaActivo,CONVERT(VARCHAR(10),dFecSalida,103) as dFecSalida,vObra,vLugar
		, b.idTecnico, b.vNombre as vTecnico
		,a.idCliente,c.vNombre as cliente,a.vEstado, a.Observacion,coti.idCotiz,coti.vnroCot
		from almacen.salidaActivos a
		left join tecnico b on a.idTecnico=b.idTecnico
		left join cliente c on a.idCliente=c.idCliente
		left join compras.cotizacion coti on a.idCotiz=coti.idCotiz
		where a.vEstado =1 AND 
		a.idSalidaActivo=@vDatoBus;

	RETURN
END

NUMCOTIZACION:
	begin

		select a.idSalidaActivo,CONVERT(VARCHAR(10),dFecSalida,103) as dFecSalida,vObra,vLugar
		, b.idTecnico, b.vNombre as vTecnico
		,a.idCliente,c.vNombre as cliente,coti.idCotiz,coti.vnroCot,a.vEstado, a.Observacion
		from almacen.salidaActivos a
		left join tecnico b on a.idTecnico=b.idTecnico
		left join cliente c on a.idCliente=c.idCliente
		left join compras.cotizacion coti on a.idcotiz=coti.idCotiz
		where a.vEstado =1 AND 
		dFecSalida between @dFecIni and @dFecFin
		AND coti.vnroCot like '%'+@vDatoBus+'%'

	RETURN
END

CLIENTE:
	begin
		select a.idSalidaActivo,CONVERT(VARCHAR(10),dFecSalida,103) as dFecSalida,vObra,vLugar
		, b.idTecnico, b.vNombre as vTecnico
		,a.idCliente,c.vNombre as cliente,coti.idCotiz,coti.vnroCot,a.vEstado, a.Observacion
		from almacen.salidaActivos a
		left join tecnico b on a.idTecnico=b.idTecnico
		left join cliente c on a.idCliente=c.idCliente
		left join compras.cotizacion coti on a.idcotiz=coti.idCotiz
		where a.vEstado =1 AND 
		dFecSalida between @dFecIni and @dFecFin
		AND C.vNombre  like '%'+@vDatoBus+'%'

	RETURN
END

SERIE:
	begin
		select distinct a.idSalidaActivo,CONVERT(VARCHAR(10),dFecSalida,103) as dFecSalida,CONVERT(VARCHAR(10), r.dFecRetorno,103) dFecRetorno,
			a.vObra,a.vLugar
			, b.idTecnico, b.vNombre as vTecnico
			,a.idCliente,c.vNombre as cliente,coti.idCotiz,coti.vnroCot ,a.vEstado, a.Observacion
			from almacen.salidaActivos a		
			left join tecnico b on a.idTecnico=b.idTecnico
			left join cliente c on a.idCliente=c.idCliente
			left join almacen.retornoActivos r on a.idSalidaActivo=r.idSalidaActivos
			left join compras.cotizacion coti on a.idcotiz=coti.idCotiz
			left join almacen.detSalidaActivos ds on a.idSalidaActivo=ds.idSalidaActivo
			left join activos mat on ds.idActivos=mat.idActivos
			where a.vEstado =1 AND 
			dFecSalida between @dFecIni and @dFecFin
			and mat.vSerie like '%'+@vDatoBus+'%'
	

		RETURN
END