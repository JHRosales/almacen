USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [dbo].[buscar_detcotizacion]    Script Date: 03/18/2021 15:19:20 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER proc [dbo].[buscar_detcotizacion]
@p1_cod varchar(100) = '' --id detalle cotizacion
, @p2_idcotizacion varchar(100) = ''--id cotizacion
as
begin

if @p2_idcotizacion='' begin
set @p2_idcotizacion='a00';
end
	select distinct a.idDetCotiz,
	a.idCotiz,
	case when a.tipoPS='1' then dbo.ModeloProd(a.idProdServ) else '' end modelo,	
	REPLACE(REPLACE(REPLACE(dbo.udf_StripHTML(a.vNombrePSM),CHAR(10),''),CHAR(13),''), CHAR(9),'')
	 as vNombrePSM ,
	case when a.tipoPS!='1' then a.vDescrip else REPLACE(REPLACE(REPLACE(dbo.udf_StripHTML(a.vDescrip),CHAR(10),''),CHAR(13),''), CHAR(9),'') end
	 as  vDescrip,
	case when a.tipoPS='1' then dbo.stockProd(a.idProdServ) else '' end stock, 
	a.nPrecUnit,
	a.nCantidad,
	a.nDescuento as nDesc,
	a.nPrecTotal,
	a.vEstado,
	a.nOrden,
	a.tipoPS,
	opcional,
	a.idProdServ,
	case when a.tipoPS='1' then dbo.docadjunto(a.idProdServ) else '' end as docadjunto
	,coalesce(a.idServPadre,a.idDetCotiz) as idServPadre
    from compras.detcotizacion a
	where a.idDetCotiz like '%' + @p1_cod + '%'  
		and a.idCotiz = @p2_idcotizacion  
		and (opcional='0' or opcional='' or opcional is null ) 
		and vEstado in ('1','3','2') --1 activos 3 opcionales que pasan a principal pero no ha sido aceptado aun, 2 agregados que aun no han sido aceptados
	order by  idServPadre asc,idDetCotiz asc
	
	
	/*select * from compras.detcotizacion a
*/
end

