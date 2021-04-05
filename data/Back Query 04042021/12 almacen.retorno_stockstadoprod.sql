USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[retorno_stockstadoprod]    Script Date: 04/04/2021 19:35:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER proc [almacen].[retorno_stockstadoprod]
@p_idprodserie integer
as    
Declare @idprod as Integer
begin    
--AL seleccionar el producto serie para el retorno (se marca como (R) retorno temporal al producto serie)
   select @idprod=idProducto from almacen.prodSeries where idProdSeries=@p_idprodserie;
   
   update almacen.prodSeries set vEstAlmacen='R' where idProdSeries=@p_idprodserie   
   UPDATE producto SET nStock=nStock+1 ,
									cCompra=case when nStockMinimo>=nStock+1 
													then 1 else 0 end
								WHERE idProducto= @idprod;

select 'ok' as rpta;
 end


