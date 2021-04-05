USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[salida_stockstadoprodcancelar]    Script Date: 04/04/2021 19:41:08 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER proc [almacen].[salida_stockstadoprodcancelar]
@p_idprodserie integer,
@p_idDetSalidaprod integer
as    
Declare @idprod as Integer
begin    

if @p_idDetSalidaprod>0
begin
	if exists(	select * from almacen.detSalidaProd where idDetSalidaProd=@p_idDetSalidaprod
	 and idProdSeries=@p_idprodserie and vEstado=1)
	begin 
	select 'ERR' as rpta,'Producto registrado' as msg;
	end
	else
	begin
		/*select @idprod=idProducto from almacen.prodSeries where idProdSeries=@p_idprodserie;
		update almacen.detSalidaProd set vEstado=0 where idDetSalidaProd=@p_idDetSalidaprod;
		 update almacen.prodSeries set vEstAlmacen='1' where idProdSeries=@p_idprodserie
		 UPDATE producto SET nStock=nStock+1 WHERE idProducto = @idprod;*/
		 select 'ok' as rpta,'Correcto' as msg;
	end
end
else
begin
   select @idprod=idProducto from almacen.prodSeries where idProdSeries=@p_idprodserie;
   
   update almacen.prodSeries set vEstAlmacen='1' where idProdSeries=@p_idprodserie   
   UPDATE producto SET nStock=nStock+1,
									cCompra=case when nStockMinimo>=nStock+1 
													then 1 else 0 end
								 WHERE idProducto = @idprod;
   select 'ok' as rpta,'Correcto' as msg;
end 

 end


