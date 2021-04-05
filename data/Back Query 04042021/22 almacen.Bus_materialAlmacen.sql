USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[Bus_materialAlmacen]    Script Date: 04/04/2021 20:19:06 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER procedure [almacen].[Bus_materialAlmacen]
 @tBusqueda varchar(1)='0',
 @vDatoBus varchar(max) 

as

if (@tBusqueda='0') goto GENERAL
if (@tBusqueda='1') goto ID
if (@tBusqueda='2') goto NOMBRE
if (@tBusqueda='3') goto TIPOMATERIAL
if (@tBusqueda='4') goto MARCA

GENERAL:
begin
	UPDATE material_almacen SET cCompra=0 where nStock>=nStockMinimo
										
	select idMaterial,a.vNombre,a.idTipoMaterial,b.vNombre as vTipoMaterial, vMarca, a.idUnidadMed,
	 c.vNombre as vUnidadMed, nStock, a.vEstado,idTipoMon,nStockMinimo,
	 case cCompra when 0 then 'NO' else 'SI' end cCompra,
	 Coalesce((select top 1 coalesce(cmat.vNombre,'') Uproveedor from almacen.entradaMat amat
	inner join almacen.detEntradaMat bmat on amat.idEntradaMat=bmat.idEntradaMat
	inner join proveedor cmat on amat.idProveedor=cmat.idProveedor
	where idMaterial=a.idMaterial
	order by amat.dFecIngreso desc),'') Uproveedor
	from dbo.material_almacen a
	left join almacen.tipoMaterial b on a.idTipoMaterial=b.idTipoMaterial
	left join almacen.unidadMed c on a.idUnidadMed=c.idUnidadMed;
	
	
RETURN
END

ID:
begin

declare @nDatoBus int
select @nDatoBus=cast(@vDatoBus as int)

	select idMaterial,a.vNombre,a.idTipoMaterial,b.vNombre as vTipoMaterial, vMarca, a.idUnidadMed, 
	c.vNombre as vUnidadMed, nStock, a.vEstado,idTipoMon,nStockMinimo,
	case cCompra when 0 then 'NO' else 'SI' end cCompra,
	 Coalesce((select top 1 coalesce(cmat.vNombre,'') Uproveedor from almacen.entradaMat amat
	inner join almacen.detEntradaMat bmat on amat.idEntradaMat=bmat.idEntradaMat
	inner join proveedor cmat on amat.idProveedor=cmat.idProveedor
	where idMaterial=a.idMaterial
	order by amat.dFecIngreso desc),'') Uproveedor
	from dbo.material_almacen a
	left join almacen.tipoMaterial b on a.idTipoMaterial=b.idTipoMaterial
	left join almacen.unidadMed c on a.idUnidadMed=c.idUnidadMed
	where 
	a.idMaterial=@nDatoBus;

RETURN
END

NOMBRE:
begin

	select idMaterial,a.vNombre,a.idTipoMaterial,b.vNombre as vTipoMaterial, vMarca, a.idUnidadMed, 
	c.vNombre as vUnidadMed, nStock, a.vEstado,idTipoMon,nStockMinimo,
	case cCompra when 0 then 'NO' else 'SI' end cCompra,
	 Coalesce((select top 1 coalesce(cmat.vNombre,'') Uproveedor from almacen.entradaMat amat
	inner join almacen.detEntradaMat bmat on amat.idEntradaMat=bmat.idEntradaMat
	inner join proveedor cmat on amat.idProveedor=cmat.idProveedor
	where idMaterial=a.idMaterial
	order by amat.dFecIngreso desc),'') Uproveedor
	from dbo.material_almacen a
	left join almacen.tipoMaterial b on a.idTipoMaterial=b.idTipoMaterial
	left join almacen.unidadMed c on a.idUnidadMed=c.idUnidadMed
	where 
	a.vNombre LIKE '%'+@vDatoBus+'%';

RETURN
END

TIPOMATERIAL:
begin

	select idMaterial,a.vNombre,a.idTipoMaterial,b.vNombre as vTipoMaterial, vMarca, a.idUnidadMed,
	 c.vNombre as vUnidadMed, nStock, a.vEstado,idTipoMon,nStockMinimo,
	 case cCompra when 0 then 'NO' else 'SI' end cCompra,
	 Coalesce((select top 1 coalesce(cmat.vNombre,'') Uproveedor from almacen.entradaMat amat
	inner join almacen.detEntradaMat bmat on amat.idEntradaMat=bmat.idEntradaMat
	inner join proveedor cmat on amat.idProveedor=cmat.idProveedor
	where idMaterial=a.idMaterial
	order by amat.dFecIngreso desc),'') Uproveedor
	from dbo.material_almacen a
	left join almacen.tipoMaterial b on a.idTipoMaterial=b.idTipoMaterial
	left join almacen.unidadMed c on a.idUnidadMed=c.idUnidadMed
	where 
	b.vNombre LIKE '%'+@vDatoBus+'%';

RETURN
end

MARCA:
begin

	select idMaterial,a.vNombre,a.idTipoMaterial,b.vNombre as vTipoMaterial, vMarca, a.idUnidadMed, 
	c.vNombre as vUnidadMed, nStock,a.vEstado,idTipoMon,nStockMinimo,
	case cCompra when 0 then 'NO' else 'SI' end cCompra,
	 Coalesce((select top 1 coalesce(cmat.vNombre,'') Uproveedor from almacen.entradaMat amat
	inner join almacen.detEntradaMat bmat on amat.idEntradaMat=bmat.idEntradaMat
	inner join proveedor cmat on amat.idProveedor=cmat.idProveedor
	where idMaterial=a.idMaterial
	order by amat.dFecIngreso desc),'') Uproveedor
	from dbo.material_almacen a
	left join almacen.tipoMaterial b on a.idTipoMaterial=b.idTipoMaterial
	left join almacen.unidadMed c on a.idUnidadMed=c.idUnidadMed
	where 
	a.vMarca LIKE '%'+@vDatoBus+'%'

return
end