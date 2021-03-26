USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[Bus_DetRetornoActivos]    Script Date: 03/25/2021 21:26:16 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER procedure [almacen].[Bus_DetRetornoActivos]  
 @tBusqueda varchar(1)='0',  
 @vIdSalida varchar(max),  
 @vDatoBus varchar(max),  
 @vFecIni varchar(25) ='',  
 @vFecFin varchar(25)=''   
  
as  
set dateformat 'dmy'     
if (@tBusqueda='0') goto GENERAL  
if (@tBusqueda='1') goto ID  
  
GENERAL:  
begin  
  
   select  da.idDetRetornoActivos,s.idSalidaActivo,sa.idDetSalidaActivo ,sa.idActivos, m.vNombre as activos
       ,coalesce(da.nStock ,sa.nStockSalida) as nStock,sa.nCantidad,da.nCantidad as CantidadRetorno,da.vObserv, 
       sa.vEstado,m.vSerie,convert(varchar(10),da.dfecRetornoActivos,103) as dFecRetornoActivos   
          from almacen.salidaActivos s left join 
  almacen.detSalidaActivos sa on s.idSalidaActivo=sa.idSalidaActivo 
   left join dbo.activos m on  sa.idActivos= m.idActivos
    left join  almacen.retornoActivos d on s.idSalidaActivo=d.idSalidaActivos
    left join  almacen.detRetornoActivos da on d.idRetornoActivos=da.idRetornoActivos and sa.idActivos=da.idActivos
  and sa.idDetSalidaActivo=da.idDetSalidaActivos
  where s.idSalidaActivo = @vIdSalida
  and sa.vEstado =1; 
  
 
RETURN  
END  

  
ID:  
begin  
  
declare @nDatoBus int  
select @nDatoBus=cast(@vDatoBus as int)  
  
   select  da.idDetRetornoActivos,s.idSalidaActivo ,sa.idActivos, m.vNombre as activos, 
        coalesce(da.nStock ,sa.nStockSalida) as nStock,sa.nCantidad,da.nCantidad as CantidadRetorno,da.vObserv, 
        sa.vEstado,m.vSerie, convert(varchar(10),da.dfecRetornoActivos,103) as dFecRetornoActivos    
          from almacen.salidaActivos s left join 
  almacen.detSalidaActivos sa on s.idSalidaActivo=sa.idSalidaActivo 
	left join dbo.activos m on  sa.idActivos= m.idActivos
    left join  almacen.retornoActivos d on s.idSalidaActivo=d.idSalidaActivos
    left join  almacen.detRetornoActivos da on d.idRetornoActivos=da.idRetornoActivos and sa.idActivos=da.idActivos
  and sa.idDetSalidaActivo=da.idDetSalidaActivos
 where   
 sa.idDetSalidaActivo=@nDatoBus  
 and sa.idSalidaActivo = @vIdSalida
 and sa.vEstado =1;  
RETURN  
END
