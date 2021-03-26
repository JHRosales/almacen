USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[Bus_DetRetornoMat]    Script Date: 03/25/2021 22:23:55 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER procedure [almacen].[Bus_DetRetornoMat]  
 @tBusqueda varchar(1)='0',  
 @vIdSalidaMat varchar(max),  
 @vDatoBus varchar(max),  
 @vFecIni varchar(25) ='',  
 @vFecFin varchar(25)=''   
  
as  
set dateformat 'dmy'     
if (@tBusqueda='0') goto GENERAL  
if (@tBusqueda='1') goto ID  
  
GENERAL:  
begin  
  
   select  da.idDetRetornoMat,s.idSalidaMat,sa.idDetSalidaMat ,sa.idMaterial, m.vNombre as material,m.idUnidadMed,u.vNombre as unidadMedida,  
         coalesce(da.nStock ,sa.nStockSalida) as nStock,sa.nCantidad,da.nCantidad as CantidadRetorno,da.vObserv, sa.vEstado 
         ,convert(varchar(10),da.dfecRetornoMat,103) as dFecRetornoMat  
          from almacen.SalidaMat s left join 
  almacen.detSalidaMat sa on s.idSalidaMat=sa.idSalidaMat 
   left join dbo.material_almacen m on  sa.idMaterial = m.idMaterial  
    left join almacen.unidadMed u on m.idUnidadMed=u.idUnidadMed  left join
  almacen.retornoMat d on s.idSalidaMat=d.idSalidaMat left join
  almacen.detRetornoMat da on d.idRetornoMat=da.idRetornoMat and sa.idMaterial=da.idMaterial
  and sa.idDetSalidaMat=da.idDetSalidaMat
  where s.idSalidaMat = @vIdSalidaMat
  and sa.vEstado =1; 
  
 
RETURN  
END  



  

  
ID:  
begin  
  
declare @nDatoBus int  
select @nDatoBus=cast(@vDatoBus as int)  
  
   select  da.idDetRetornoMat,s.idSalidaMat ,sa.idMaterial, m.vNombre as material,m.idUnidadMed,u.vNombre as unidadMedida,  
        coalesce(da.nStock ,sa.nStockSalida) as nStock,sa.nCantidad,da.nCantidad as CantidadRetorno,da.vObserv, sa.vEstado  
        ,convert(varchar(10),da.dfecRetornoMat,103) as dFecRetornoMat  
          from almacen.SalidaMat s left join 
  almacen.detSalidaMat sa on s.idSalidaMat=sa.idSalidaMat 
   left join dbo.material_almacen m on  sa.idMaterial = m.idMaterial  
    left join almacen.unidadMed u on m.idUnidadMed=u.idUnidadMed  left join
  almacen.retornoMat d on s.idSalidaMat=d.idSalidaMat left join
  almacen.detRetornoMat da on d.idRetornoMat=da.idRetornoMat and sa.idMaterial=da.idMaterial 
  and sa.idDetSalidaMat=da.idDetSalidaMat
 where   
 sa.idDetSalidaMat=@nDatoBus  
 and sa.idSalidaMat = @vIdSalidaMat
 and sa.vEstado =1;  
RETURN  
END
