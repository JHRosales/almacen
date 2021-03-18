USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[InsUpd_materialAlmacen]    Script Date: 03/18/2021 16:17:21 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER procedure [almacen].[InsUpd_materialAlmacen]
@ttrans varchar(1),
@idMaterial int=0,
@vNombreMat varchar(max)='',
@idTipoMaterial int=null,
@vMarca varchar(150)='',
@idUnidadMed int=null,
@stockMinimo int=0,
@nCosto numeric(10,2)=0.00, 
@tipomon int=1,
@vEstado char(1)='',
@vUsernm varchar(50)='',
@vHostnm varchar(50)=''

as

if (@ttrans='1') goto INSERTAR
if (@ttrans='2') goto ACTUALIZAR

INSERTAR:
begin
if exists(select * from dbo.material_almacen where Rtrim(vNombre)=Rtrim(@vNombreMat))
 begin
 select @idMaterial as idMaterial,'Err' Estado, 'Ya Existe un Material con ese Nombre'  Msg
 end
 else
 begin
	declare @idmax int
	select @idmax=isnull(max(idMaterial),0)+1 from dbo.material_almacen

	insert into dbo.material_almacen
	(idMaterial,vNombre,idTipoMaterial,vMarca,idUnidadMed,nStock,vEstado,vUsernm,vHostnm,dFecReg,nStockMinimo,cCompra,idTipoMon)
	values
	(@idmax,@vNombreMat,@idTipoMaterial,@vMarca,@idUnidadMed,0,@vEstado,@vUsernm,@vHostnm,GETDATE(),@stockMinimo,1,@tipomon)

	select @idmax as idMaterial,'Ok' Estado, 'Registrado Correctamente' Msg 
END
return 
end

ACTUALIZAR:
begin
if exists(select * from dbo.material_almacen where Rtrim(vNombre)=Rtrim(@vNombreMat) and idMaterial!=@idMaterial)
 begin
 select @idMaterial as idMaterial,'Err' Estado, 'Ya Existe un Material con ese Nombre '  Msg
 end
 else
 begin

	update dbo.material_almacen
	set
		vNombre=@vNombreMat,
		idTipoMaterial=@idTipoMaterial,
		vMarca=@vMarca,
		idUnidadMed=@idUnidadMed,
		vEstado=@vEstado,
		vUsernm=@vUsernm,
		vHostnm=@vHostnm,
		dFecReg=GETDATE(),
		nStockMinimo=@stockMinimo,
		idTipoMon=@tipomon,
		cCompra=case when @stockMinimo>nStock then 1 else 0 end 
	where
		idMaterial=@idMaterial;
				
	select @idMaterial as idMaterial, 'Ok' Estado, 'Registrado Correctamente' Msg 
END
return
end