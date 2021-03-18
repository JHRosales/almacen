USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [dbo].[InsUpd_Producto]    Script Date: 03/18/2021 16:43:20 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER procedure [dbo].[InsUpd_Producto]  
@ttrans varchar(1),  
@idProducto int = 0,  
@idSubCat int = null,  
@vNombre varchar(500)='',  
@vMarca varchar(100)='',  
@vModelo varchar(100)='',  
@vResolucion varchar(25)='',  
@vCapacidad varchar(25)='',  
@vTecnologia varchar(25)='',  
@vDescrip varchar(max)='',  
@nCosto numeric(10,2)=0.00,  
@nStock int=0,  
@vUsernm varchar(50)='local',  
@vHostnm varchar(50)='local',  
@iadjunto varchar(800)='',  
@tipomon int=1,
@nstockMinimo int=0
  
as  
  
if (@ttrans='1') goto INSERTAR  
if (@ttrans='2') goto ACTUALIZAR  
  
INSERTAR:  
begin  
if not exists(select * from producto where vModelo = RTRIM(@vModelo))  
begin  
 declare @idmax int  
 select @idmax=isnull(max(idProducto),0)+1 from producto  
  
 insert into producto (idProducto,idSubCat,vNombre,vMarca,vModelo,vResolucion,vCapacidad,vTecnologia,vDescrip,nCosto,nStock,vEstado,vUsernm,vHostnm,dFecReg,iadjunto,idTipoMon,nStockMinimo,cCompra)  
 values (@idmax,@idSubCat,@vNombre,@vMarca,@vModelo,@vResolucion,@vCapacidad,@vTecnologia,@vDescrip,@nCosto,@nStock,'1',@vUsernm,@vHostnm,GETDATE(),@iadjunto,@tipomon,@nstockMinimo,1)  
select @idmax as idprod, 'Registrado Correctamente' msg;  
end  
else  
begin  
select 0 as idprod, 'Modelo ya registrado' msg;  
end  
  
return   
end  
  
ACTUALIZAR:  
begin  
if not exists(select * from producto where vModelo = RTRIM(@vModelo) and idProducto!=@idProducto)  
begin  
 update producto  
 set  
  idSubCat=@idSubCat,  
  vNombre=@vNombre,  
  vMarca=@vMarca,  
  vModelo=@vModelo,  
  vResolucion=@vResolucion,  
  vCapacidad=@vCapacidad,  
  vTecnologia=@vTecnologia,  
  vDescrip=@vDescrip,  
  nCosto=@nCosto,  
  nStock=@nStock,  
  vUsernm=@vUsernm,  
  vHostnm=@vHostnm,  
  dFecReg=GETDATE() ,
  idTipoMon=@tipomon ,
  nStockMinimo =@nstockMinimo,
  cCompra=case when @nStockMinimo>nStock then 1 else 0 end								
 where  
  idProducto=@idProducto;    
  select @idProducto as idprod,'Actualizado correctament' msg;  
 end  
 else  
 begin  
  select 0 as idprod, 'Modelo ya registrado en otro producto' msg;  
 end  
   
    
return  
end