USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[Bus_DetSalidaMat]    Script Date: 03/16/2021 02:55:44 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER procedure [almacen].[Bus_DetSalidaMat]  
 @tBusqueda varchar(1)='0',  
 @vIdSalidaMat varchar(max),  
 @vDatoBus varchar(max),  
 @vFecIni varchar(25) ='',  
 @vFecFin varchar(25)=''   
  
as  
set dateformat dmy    
if (@tBusqueda='0') goto GENERAL  
if (@tBusqueda='1') goto ID  
  
GENERAL:  
begin  
  
 select  b.idDetSalidaMat,b.idSalidaMat ,b.idMaterial, m.vNombre as material,u.vNombre as UnidadMediad,b.nStockSalida as nStock,  
         b.nCantidad, b.vEstado, convert( varchar(10), b.dFecSalidaMaterial ,103) dFecSalidaMaterial
 from   
 almacen.detSalidaMat b   
 left join dbo.material_almacen m on  b.idMaterial = m.idMaterial  
 left join almacen.unidadMed u on m.idUnidadMed =u.idUnidadMed   
 where b.idSalidaMat = @vIdSalidaMat
  and b.vEstado=1 ;  
RETURN  
END  
  
ID:  
begin  
  
declare @nDatoBus int  
select @nDatoBus=cast(@vDatoBus as int)  
  
 select  b.idDetSalidaMat,b.idSalidaMat ,b.idMaterial, m.vNombre as material,u.vNombre as UnidadMediad,b.nStockSalida as nStock, 
         b.nCantidad, b.vEstado,convert( varchar(10), b.dFecSalidaMaterial ,103) dFecSalidaMaterial 
 from   
 almacen.detSalidaMat b   
 left join dbo.material_almacen m on  b.idMaterial = m.idMaterial   
  left join almacen.unidadMed u on m.idUnidadMed =u.idUnidadMed   
 where   
 idDetSalidaMat=@nDatoBus  
 and b.idSalidaMat = @vIdSalidaMat
  and b.vEstado=1 ;  
RETURN  
END
