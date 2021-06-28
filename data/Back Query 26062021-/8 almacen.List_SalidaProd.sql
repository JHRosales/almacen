USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[List_SalidaProd]    Script Date: 06/28/2021 00:22:52 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER procedure [almacen].[List_SalidaProd]  
 @tBusqueda varchar(1)='0',  
 @vDatoBus varchar(max)='',  
 @vModelo varchar(max)='',  
 @vSerie varchar(max)='',  
 @vRazonSoc varchar(max)='',  
 @vNroCotizacion varchar(max)='', 
 @vFecIni varchar(25)='' ,  
 @vFecFin varchar(25)=''   
  
as  
begin
set dateformat 'dmy'   
set @vFecIni = case when @vFecIni !='' then @vFecIni else '01/01/1990' end        
set @vFecFin = case when @vFecFin !='' then @vFecFin else '31/12/2025' end  

declare @dFecIni datetime  
declare @dFecFin datetime  
  
SELECT @dFecIni=CAST (@vFecIni+' 00:00:00.000' AS datetime)  
SELECT @dFecFin=CAST (@vFecFin+' 23:59:59.999' AS datetime) 
   
if (@tBusqueda='0') goto GENERAL  
if (@tBusqueda='1') goto FECHA  
if (@tBusqueda='2') goto ID  
  
GENERAL:  
begin  

   if @vModelo!='' or @vSerie!='' 
  begin
	select distinct a.idSalidaProd,  
	CONVERT(VARCHAR(10),dFecSalida,103) as dFecSalida  
	,a.vObra,a.vLugar, b.idTecnico, 
	--b.vNombre as vTecnico
	coalesce(convert(varchar(max),(select STUFF(
				(
				SELECT CAST(', ' AS varchar(MAX)) + t.vNombre   
				FROM almacen.detTecnicoProd baa  
						INNER join tecnico t on baa.idTecnico =t.idTecnico
				where baa.idsalidaProd=a.idSalidaProd		
				ORDER BY t.vNombre   

				FOR XML PATH('')
				), 1, 1, ''))),b.vNombre) as vTecnico
	
	,a.vEstado  ,CONVERT(VARCHAR(10),
	 r.dFecRetorno,103) dFecRetorno,a.idCliente,c.vNombre as cliente,a.vEstado, a.Observacion
	 ,cotiz.idCotiz,cotiz.vnroCot
	from almacen.salidaProd a  
	left join tecnico b on a.idTecnico=b.idTecnico  
	left join almacen.retornoProd r on a.idSalidaProd=r.idSalidaProd
	left join almacen.detSalidaProd ds on a.idSalidaProd=ds.idSalidaProd
	left join almacen.prodSeries p on ds.idProdSeries=p.idProdSeries
	left join producto x on p.idProducto=x.idProducto
	left join cliente c on a.idCliente=c.idCliente
	left join compras.cotizacion cotiz on a.idCotiz=cotiz.idCotiz
	where p.vEstado=1 and ds.vEstado=1
	and x.vModelo like '%'+@vModelo+'%'
	and p.vNroSerie like '%'+@vSerie+'%'
	and cast(dFecSalida as date) BETWEEN   cast(@dFecIni as date) AND cast(@dFecFin    as date) 
	and a.vEstado=1
  end
  else
  begin
	select a.idSalidaProd,  
	CONVERT(VARCHAR(10),dFecSalida,103) as dFecSalida  
	,a.vObra,a.vLugar, b.idTecnico, 
	--b.vNombre as vTecnico
	coalesce(convert(varchar(max),(select STUFF(
				(
				SELECT CAST(', ' AS varchar(MAX)) + t.vNombre   
				FROM almacen.detTecnicoProd baa  
						INNER join tecnico t on baa.idTecnico =t.idTecnico
				where baa.idsalidaProd=a.idSalidaProd		
				ORDER BY t.vNombre   

				FOR XML PATH('')
				), 1, 1, ''))),b.vNombre) as vTecnico
	,a.vEstado  ,CONVERT(VARCHAR(10), 
	r.dFecRetorno,103) dFecRetorno,a.idCliente,c.vNombre as cliente,a.vEstado, a.Observacion
	,cotiz.idCotiz, cotiz.vnroCot
	from almacen.salidaProd a  
	left join tecnico b on a.idTecnico=b.idTecnico  and  b.vNombre like '%'+@vRazonSoc+'%'
	left join almacen.retornoProd r on a.idSalidaProd=r.idSalidaProd
	left join cliente c on a.idCliente=c.idCliente
	left join compras.cotizacion cotiz on a.idCotiz=cotiz.idCotiz
	where
	 coalesce(cotiz.vnroCot,'') like '%'+@vNroCotizacion+'%'
	and cast(dFecSalida as date) BETWEEN   cast(@dFecIni as date) AND cast(@dFecFin    as date) 
	and a.vEstado=1
  end
  
   
RETURN  
END  
  
FECHA:  
begin  
    
 select a.idSalidaProd,CONVERT(VARCHAR(10),dFecSalida,103) as dFecSalida
 ,a.vObra,a.vLugar, b.idTecnico,
 -- b.vNombre as vTecnico
 coalesce(convert(varchar(max),(select STUFF(
				(
				SELECT CAST(', ' AS varchar(MAX)) + t.vNombre   
				FROM almacen.detTecnicoProd baa  
						INNER join tecnico t on baa.idTecnico =t.idTecnico
				where baa.idsalidaProd=a.idSalidaProd		
				ORDER BY t.vNombre   

				FOR XML PATH('')
				), 1, 1, ''))),b.vNombre) as vTecnico
 ,a.vEstado  ,CONVERT(VARCHAR(10),
  r.dFecRetorno,103) dFecRetorno,a.idCliente,c.vNombre as cliente,a.vEstado, a.Observacion
  ,coti.idCotiz,coti.vnroCot
 from almacen.salidaProd a  
 left join tecnico b on a.idTecnico=b.idTecnico  
 left join almacen.retornoProd r on a.idSalidaProd=r.idSalidaProd
 left join cliente c on a.idCliente=c.idCliente
 left join compras.cotizacion coti on a.idCotiz=coti.idCotiz
 where   
 dFecSalida between @dFecIni and @dFecFin  
 and a.vEstado=1
  
RETURN  
END  
  
ID:  
begin  
  
 select a.idSalidaProd,CONVERT(VARCHAR(10),dFecSalida,103) as dFecSalida
 ,a.vObra,a.vLugar, b.idTecnico, 
 --b.vNombre as vTecnico
 coalesce(convert(varchar(max),(select STUFF(
				(
				SELECT CAST(', ' AS varchar(MAX)) + t.vNombre   
				FROM almacen.detTecnicoProd baa  
						INNER join tecnico t on baa.idTecnico =t.idTecnico
				where baa.idsalidaProd=a.idSalidaProd		
				ORDER BY t.vNombre   

				FOR XML PATH('')
				), 1, 1, ''))),b.vNombre) as vTecnico
 ,a.vEstado  ,CONVERT(VARCHAR(10),
  r.dFecRetorno,103) dFecRetorno,a.idCliente,c.vNombre as cliente,a.vEstado, a.Observacion
  ,coti.idCotiz,coti.vnroCot
 from almacen.salidaProd a  
 left join tecnico b on a.idTecnico=b.idTecnico  
 left join almacen.retornoProd r on a.idSalidaProd=r.idSalidaProd
 left join cliente c on a.idCliente=c.idCliente
 left join compras.cotizacion coti on a.idCotiz=coti.idCotiz
 where   
 a.idSalidaProd=@vDatoBus
 and a.vEstado=1;  
  
RETURN  
END  
end