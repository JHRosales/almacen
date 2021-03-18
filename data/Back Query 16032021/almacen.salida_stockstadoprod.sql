USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[salida_stockstadoprod]    Script Date: 03/18/2021 16:42:08 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER proc [almacen].[salida_stockstadoprod]
@p_idprodserie integer
as    
Declare @idprod as Integer
begin    
   select @idprod=idProducto from almacen.prodSeries where idProdSeries=@p_idprodserie;
   
   update almacen.prodSeries set vEstAlmacen='S' where idProdSeries=@p_idprodserie   
   UPDATE producto SET nStock=nStock-1,
									cCompra=case when nStockMinimo>nStock-1 
													then 1 else 0 end
								 WHERE idProducto= @idprod;

select 'ok' as rpta;
 end


