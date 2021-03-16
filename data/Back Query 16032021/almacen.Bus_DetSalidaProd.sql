USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[Bus_DetSalidaProd]    Script Date: 03/16/2021 15:02:18 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER procedure [almacen].[Bus_DetSalidaProd]    
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
    
 select  b.idDetSalidaProd,b.idSalidaProd ,p.idProducto
 ,p.vNombre as Producto, b.nStockSalida as nStock
 , b.idProdSeries, m.vNroSerie as Serie, b.vEstado ,p.vModelo  
 , convert( varchar(10), b.dFecSalidaProducto ,103) dFecSalidaProducto   
 from     
 almacen.detSalidaProd b     
 left join almacen.prodSeries m on  b.idProdSeries= m.idProdSeries
 left join dbo.producto p on m.idProducto=p.idProducto   
 where b.idSalidaProd= @vIdSalidaProd
 and b.vEstado=1 ;    
 
 
RETURN    
END    
    
ID:    
begin    
    
declare @nDatoBus int    
select @nDatoBus=cast(@vDatoBus as int)    
    
 select  b.idDetSalidaProd,b.idSalidaProd ,p.idProducto
 ,p.vNombre as Producto,b.nStockSalida as nStock
 , b.idProdSeries, m.vNroSerie as Serie, b.vEstado,p.vModelo
  , convert( varchar(10), b.dFecSalidaProducto ,103) dFecSalidaProducto        
 from     
 almacen.detSalidaProd b     
 left join almacen.prodSeries m on  b.idProdSeries= m.idProdSeries
 left join dbo.producto p on m.idProducto=p.idProducto     
 where     
 idDetSalidaProd=@nDatoBus    
 and b.idSalidaProd = @vIdSalidaProd
 and b.vEstado=1;    
RETURN    
END  