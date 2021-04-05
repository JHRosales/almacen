USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [dbo].[list_Producto]    Script Date: 04/04/2021 20:43:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


ALTER procedure [dbo].[list_Producto]
 @idCat int='0',
 @idSubCat int='0',
 @vMarca varchar(100)='',
 @vModelo varchar(100)='',
 @vNombre varchar(100)='',
 @vDescripcion varchar(100)='',
 @vcategoria varchar(100)='',
 @vsubcategoria varchar(100)='',
 @idProd varchar(100)='',
 @vTecnolo varchar(100)=''

as

begin

	SELECT idProducto,b.idCat,
	c.vNombre as vNomCat,a.idSubCat,b.vNombre as vNomSubCat,
	
	Replace(Replace(Replace(REPLACE(REPLACE((a.vNombre),CHAR(10),''),CHAR(13),'<br>'), CHAR(9),''),'<li>','* '),'</li>','<p>')
	
	 as vNombre,a.vMarca
	,a.vModelo,a.vResolucion,a.vCapacidad, a.vTecnologia,
	Replace(Replace(Replace(REPLACE(REPLACE((a.vDescrip),CHAR(10),''),CHAR(13),'<br>'), CHAR(9),''),'<li>','* '),'</li>','<p>')
	as vDescrip,a.nCosto,a.nStock,a.vEstado,a.iadjunto,a.docadjunto
	,a.nStockMinimo,case coalesce(a.cCompra,0) when 0 then 'NO' else 'SI' end cCompra,
	
	 Coalesce((select top 1 coalesce(cprov.vNombre,'') Uproveedor from almacen.entradaProd amat
	inner join almacen.detEntradaProd bmat on amat.idEntradaProd=bmat.idEntradaProd
	inner join proveedor cprov on amat.idProveedor=cprov.idProveedor
	where bmat.idProducto=a.idProducto
	order by amat.dFecIngreso desc),'') Uproveedor
	
	FROM producto a
	inner join subCategoria b on a.idSubCat=b.idSubCat
	inner join categoria c on b.idCat=c.idCat
	WHERE idProducto  like @idProd+'%' and
		a.vNombre like '%'+@vNombre+'%'
		and a.vDescrip like '%' + @vDescripcion+'%'
		 and a.vMarca like '%' + @vMarca+'%'
		 and c.idCat like @vcategoria+'%'
		 and b.idSubCat like @vsubcategoria+'%'
		 and a.vModelo like @vModelo+'%'	
		 and a.vTecnologia like @vTecnolo+'%'		 
		 or b.idCat=@idCat
		 
		/*(b.idCat=@idCat and a.idSubCat=@idSubCat and a.vMarca like '%'+@vMarca+'%' and a.vModelo like '%'+@vModelo+'%' and a.vNombre like '%'+@vNombre+'%')
		or
		(b.idCat=@idCat and @idSubCat=0 and a.vMarca like '%'+@vMarca+'%' and a.vModelo like '%'+@vModelo+'%' and a.vNombre like '%'+@vNombre+'%')
		or
		(@idCat=0 and a.vMarca like '%'+@vMarca+'%' and a.vModelo like '%'+@vModelo+'%' and a.vNombre like '%'+@vNombre+'%')*/
	
end


