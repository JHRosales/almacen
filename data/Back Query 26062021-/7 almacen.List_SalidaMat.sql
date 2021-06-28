USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[List_SalidaMat]    Script Date: 06/28/2021 00:07:10 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER procedure [almacen].[List_SalidaMat]
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
if (@tBusqueda='1') goto NOMMATERIAL
if (@tBusqueda='2') goto ID
if (@tBusqueda='3') goto NUMCOTIZACION
if (@tBusqueda='4') goto CLIENTE

GENERAL:
	begin

		select a.idSalidaMat,
			CONVERT(VARCHAR(10),dFecSalida,103) as dFecSalida,CONVERT(VARCHAR(10), r.dFecRetorno,103) dFecRetorno
			,a.vObra,a.vLugar, b.idTecnico, 			
			--b.vNombre as vTecnico
			coalesce(convert(text,(select STUFF(
				(
				SELECT CAST(', ' AS varchar(MAX)) + t.vNombre   
				FROM almacen.detTecnicoMat baa   
						INNER join tecnico t on baa.idTecnico =t.idTecnico
				where baa.idsalidaMat=a.idSalidaMat		
				ORDER BY t.vNombre   
				FOR XML PATH('')
				), 1, 1, ''))),b.vNombre) as vTecnico
			
			,a.idCliente,c.vNombre as cliente,coti.idCotiz,coti.vnroCot ,a.vEstado, a.Observacion
		from almacen.salidaMat a
		left join tecnico b on a.idTecnico=b.idTecnico
		left join almacen.retornoMat r on a.idSalidaMat=r.idSalidaMat
		left join cliente c on a.idCliente=c.idCliente
		left join compras.cotizacion coti on a.idcotiz=coti.idCotiz
		where a.vEstado =1 AND 
		dFecSalida between @dFecIni and @dFecFin
		
	RETURN
END


NOMMATERIAL:
	begin
		select distinct a.idSalidaMat,CONVERT(VARCHAR(10),dFecSalida,103) as dFecSalida,vObra,vLugar
			, b.idTecnico,
			-- b.vNombre as vTecnico
			coalesce(convert(varchar(max),(select STUFF(
				(
				SELECT CAST(', ' AS varchar(MAX)) + t.vNombre   
				FROM almacen.detTecnicoMat baa 
						INNER join tecnico t on baa.idTecnico =t.idTecnico
				where baa.idsalidaMat=a.idSalidaMat		
				ORDER BY t.vNombre   

				FOR XML PATH('')
				), 1, 1, ''))),b.vNombre) as vTecnico
			,a.idCliente,c.vNombre as cliente,coti.idCotiz,coti.vnroCot ,a.vEstado, a.Observacion
			from almacen.salidaMat a		
			left join tecnico b on a.idTecnico=b.idTecnico
			left join cliente c on a.idCliente=c.idCliente
			left join compras.cotizacion coti on a.idcotiz=coti.idCotiz
			left join almacen.detSalidaMat ds on a.idSalidaMat=ds.idSalidaMat
			left join material_almacen mat on ds.idMaterial=mat.idMaterial
			where 
			dFecSalida between @dFecIni and @dFecFin
			and mat.vNombre like '%'+@vDatoBus+'%'
			

		RETURN
END

ID:
	begin
		select a.idSalidaMat,CONVERT(VARCHAR(10),dFecSalida,103) as dFecSalida,vObra,vLugar
		, b.idTecnico, 
		--b.vNombre as vTecnico
		coalesce(convert(text,(select STUFF(
				(
				SELECT CAST(', ' AS varchar(MAX)) + t.vNombre   
				FROM almacen.detTecnicoMat baa  
						INNER join tecnico t on baa.idTecnico =t.idTecnico
				where baa.idsalidaMat=a.idSalidaMat		
				ORDER BY t.vNombre   

				FOR XML PATH('')
				), 1, 1, ''))),b.vNombre) as vTecnico
		,a.idCliente,c.vNombre as cliente,a.vEstado, a.Observacion,coti.idCotiz,coti.vnroCot
		from almacen.salidaMat a
		left join tecnico b on a.idTecnico=b.idTecnico
		left join cliente c on a.idCliente=c.idCliente
		left join compras.cotizacion coti on a.idCotiz=coti.idCotiz
		where 
		a.idSalidaMat=@vDatoBus;

	RETURN
END

NUMCOTIZACION:
	begin

		select a.idSalidaMat,CONVERT(VARCHAR(10),dFecSalida,103) as dFecSalida,vObra,vLugar
		, b.idTecnico, 
		--b.vNombre as vTecnico
		coalesce(convert(text,(select STUFF(
				(
				SELECT CAST(', ' AS varchar(MAX)) + t.vNombre   
				FROM almacen.detTecnicoMat baa   
						INNER join tecnico t on baa.idTecnico =t.idTecnico
				where baa.idsalidaMat=a.idSalidaMat		
				ORDER BY t.vNombre   

				FOR XML PATH('')
				), 1, 1, ''))),b.vNombre) as vTecnico
		,a.idCliente,c.vNombre as cliente,coti.idCotiz,coti.vnroCot,a.vEstado, a.Observacion
		from almacen.salidaMat a
		left join tecnico b on a.idTecnico=b.idTecnico
		left join cliente c on a.idCliente=c.idCliente
		left join compras.cotizacion coti on a.idcotiz=coti.idCotiz
		where 
		dFecSalida between @dFecIni and @dFecFin
		AND coti.vnroCot like '%'+@vDatoBus+'%'

	RETURN
END

CLIENTE:
	begin
		select a.idSalidaMat,CONVERT(VARCHAR(10),dFecSalida,103) as dFecSalida,vObra,vLugar
		, b.idTecnico, 
		--b.vNombre as vTecnico
		coalesce(convert(text,(select STUFF(
				(
				SELECT CAST(', ' AS varchar(MAX)) + t.vNombre   
				FROM almacen.detTecnicoMat baa   
						INNER join tecnico t on baa.idTecnico =t.idTecnico
				where baa.idsalidaMat=a.idSalidaMat		
				ORDER BY t.vNombre   

				FOR XML PATH('')
				), 1, 1, ''))),b.vNombre) as vTecnico
		,a.idCliente,c.vNombre as cliente,coti.idCotiz,coti.vnroCot,a.vEstado, a.Observacion
		from almacen.salidaMat a
		left join tecnico b on a.idTecnico=b.idTecnico
		left join cliente c on a.idCliente=c.idCliente
		left join compras.cotizacion coti on a.idcotiz=coti.idCotiz
		where 
		dFecSalida between @dFecIni and @dFecFin
		AND C.vNombre  like '%'+@vDatoBus+'%'

	RETURN
END