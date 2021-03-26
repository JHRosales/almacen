USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[Bus_DetRetornoProd]    Script Date: 03/25/2021 22:25:06 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER procedure [almacen].[Bus_DetRetornoProd]  
 @tBusqueda varchar(1)='0',  
 @vIdSalidaProd varchar(max),  
 @vDatoBus varchar(max),  
 @vFecIni varchar(25) ='',  
 @vFecFin varchar(25)=''   
  
as  
set dateformat 'dmy'     
if (@tBusqueda='0') goto GENERAL  
if (@tBusqueda='1') goto ID  
  
GENERAL:  
begin  
  
	select  da.idDetRetornoProd,s.idSalidaProd,sa.idDetSalidaProd ,sa.idProdSeries,
	 m.vNombre as Producto,coalesce(da.nStock, sa.nStockSalida) as nStock,
	ps.vNroSerie as Serie ,da.vObserv, sa.vEstado   
	,convert(varchar(10),da.dfecRetornoProd,103) as dFecRetornoProd 
	from almacen.salidaProd s left join 
	almacen.detSalidaProd sa on s.idSalidaProd=sa.idSalidaProd 
	left join  almacen.prodSeries ps on sa.idProdSeries=ps.idProdSeries  
	left join dbo.producto m on  ps.idProducto = m.idProducto  inner join
	almacen.retornoProd d on s.idSalidaProd=d.idSalidaProd inner join
	almacen.detRetornoProd da on d.idRetornoProd=da.idRetornoProd and sa.idProdSeries=da.idProdSeries
	and sa.idDetSalidaProd=da.idDetSalidaProd
  where s.idSalidaProd = @vIdSalidaProd
  and sa.vEstado =1
  and da.vEstado<>4;   
RETURN  
END  
 

  
ID:  
begin  
  
declare @nDatoBus int  
select @nDatoBus=cast(@vDatoBus as int)  
  
	select  da.idDetRetornoProd,s.idSalidaProd ,sa.idDetSalidaProd,sa.idProdSeries,
	 m.vNombre as Producto,coalesce(da.nStock, sa.nStockSalida)  as nStock,
	ps.vNroSerie as Serie ,da.vObserv, sa.vEstado  
	,convert(varchar(10),da.dfecRetornoProd,103) as dFecRetornoProd  
	from almacen.salidaProd s left join 
	almacen.detSalidaProd sa on s.idSalidaProd=sa.idSalidaProd 
	left join  almacen.prodSeries ps on sa.idProdSeries=ps.idProdSeries  
	left join dbo.producto m on  ps.idProducto = m.idProducto  left join
	almacen.retornoProd d on s.idSalidaProd=d.idSalidaProd left join
	almacen.detRetornoProd da on d.idRetornoProd=da.idRetornoProd and sa.idProdSeries=da.idProdSeries
	and sa.idDetSalidaProd=da.idDetSalidaProd
	 where   
	 idDetEntradaProd=@nDatoBus  
	 and sa.idSalidaProd = @vIdSalidaProd
	 and sa.vEstado =1;     
RETURN  
END
