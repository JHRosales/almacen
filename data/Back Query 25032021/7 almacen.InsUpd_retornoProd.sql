USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[InsUpd_retornoProd]    Script Date: 03/25/2021 22:52:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER procedure [almacen].[InsUpd_retornoProd]  
@ttrans varchar(1),  
@p_idretornoprod int = 0,  
@p_idsalidaprod int = 0, 
@p_obra varchar(150)='',  
@p_lugar varchar(150)='',  
@p_fecha varchar(50)='',  
@p_idtecnico int=0,  
@p_observa varchar(400),  
@vUsernm varchar(50)='',  
@vHostnm varchar(50)=''  
  
as  
set dateformat 'dmy'     
if (@ttrans='1') goto INSERTAR  
if (@ttrans='2') goto ACTUALIZAR  
  
INSERTAR:  
begin  
 declare @idmax int  
 select @idmax=isnull(max(idRetornoProd),0)+1 from almacen.retornoProd  
  
 insert into almacen.retornoProd  
 (idRetornoProd,idSalidaProd,dFecRetorno,vObra,vLugar,idTecnico,vEstado,vUsernm,vHostnm,dFecReg,Observacion)  
 values  
 (@idmax,@p_idsalidaprod,CAST (@p_fecha+' 00:00:00.000' AS datetime),@p_obra,@p_lugar,@p_idtecnico,'1',@vUsernm,@vHostnm,GETDATE(),@p_observa)  
  
 select '1' as a, @idmax as idRetornoProd  
  
return   
end  
  
ACTUALIZAR:  
begin  
 update almacen.retornoProd 
 set  
  --dFecRetorno=CAST (@p_fecha+' 00:00:00.000' AS datetime),  
  vObra=@p_obra,  
  vLugar=@p_lugar,  
  idTecnico=@p_idtecnico,  
  vUsernm=@vUsernm,  
  vHostnm=@vHostnm,  
  dFecReg=GETDATE(),
  Observacion=@p_observa  
 where  
  idSalidaProd=@p_idsalidaprod;  
    
  select @p_idretornoprod as idRetornoProd;  
return  
end
