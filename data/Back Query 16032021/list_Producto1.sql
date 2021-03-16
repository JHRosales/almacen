USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [dbo].[list_Producto1]    Script Date: 03/16/2021 13:17:54 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER procedure [dbo].[list_Producto1]
 @idCat int='0',
 @idSubCat int='0',
 @vMarca varchar(100)='',
 @vModelo varchar(100)='',
 @vNombre varchar(100)='',
 @vDescripcion varchar(100)='',
 @vcategoria varchar(100)='',
 @vsubcategoria varchar(100)='',
 @idProd varchar(100)=''

as

begin

	SELECT idProducto,b.idCat,
	c.vNombre as vNomCat,a.idSubCat,b.vNombre as vNomSubCat,
	a.vNombre
	 as vNombre,a.vMarca
	,a.vModelo,a.vResolucion,a.vCapacidad,a.vTecnologia,
	a.vDescrip
	as vDescrip,a.nCosto,a.nStock,a.vEstado,a.iadjunto,a.docadjunto,idTipoMon
	,a.nStockMinimo
	FROM producto a
	inner join subCategoria b on a.idSubCat=b.idSubCat
	inner join categoria c on b.idCat=c.idCat
	WHERE idProducto  like @idProd+'%' and
		a.vNombre like @vNombre+'%'
		and a.vDescrip like @vDescripcion+'%'
		 and a.vMarca like @vMarca+'%'
		 and c.idCat like @vcategoria+'%'
		 and b.idSubCat like @vsubcategoria+'%'
		 --and a.vEstado='1' 
		 and a.vModelo like @vModelo+'%'		 
		 or b.idCat=@idCat
		 
		/*(b.idCat=@idCat and a.idSubCat=@idSubCat and a.vMarca like '%'+@vMarca+'%' and a.vModelo like '%'+@vModelo+'%' and a.vNombre like '%'+@vNombre+'%')
		or
		(b.idCat=@idCat and @idSubCat=0 and a.vMarca like '%'+@vMarca+'%' and a.vModelo like '%'+@vModelo+'%' and a.vNombre like '%'+@vNombre+'%')
		or
		(@idCat=0 and a.vMarca like '%'+@vMarca+'%' and a.vModelo like '%'+@vModelo+'%' and a.vNombre like '%'+@vNombre+'%')*/
	
end
