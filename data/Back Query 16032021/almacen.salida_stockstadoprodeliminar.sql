USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[salida_stockstadoprodeliminar]    Script Date: 03/18/2021 16:42:34 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER proc [almacen].[salida_stockstadoprodeliminar]
@p_idprodserie integer,
@p_idDetSalidaprod integer
as    
Declare @idprod as Integer
begin    


if @p_idDetSalidaprod>0
begin
	if exists(select * from almacen.detRetornoProd where idRetornoProd in (
	select idRetornoProd from almacen.retornoProd where idSalidaProd in (
	select idSalidaProd from almacen.detSalidaProd where idDetSalidaProd=@p_idDetSalidaprod
	)) and idProdSeries=@p_idprodserie and vEstado=1)
	begin 
	select 'ERR' as rpta,'Producto ya tiene Retorno, No se puede eliminar' as msg;
	end
	else
	begin
	--R : Retorno temporal
	--E : Eliminado temporal
		select @idprod=idProducto from almacen.prodSeries where idProdSeries=@p_idprodserie;
		update almacen.detSalidaProd set vEstado=5 where idDetSalidaProd=@p_idDetSalidaprod;
		update almacen.prodSeries set vEstAlmacen=1,vEstado =5 where idProdSeries=@p_idprodserie
		UPDATE producto SET nStock=nStock+1,
									cCompra=case when nStockMinimo>nStock+1 
													then 1 else 0 end
								 WHERE idProducto = @idprod;
		select 'ok' as rpta,'Correcto' as msg;
		 
	end
end
else
begin
--no deberia entrar aca, si no existe entonces no hace nada
   --select @idprod=idProducto from almacen.prodSeries where idProdSeries=@p_idprodserie;
   select @idprod=idProducto from almacen.prodSeries where idProdSeries=@p_idprodserie;   
   update almacen.prodSeries set vEstAlmacen='1' where idProdSeries=@p_idprodserie  
   UPDATE producto SET nStock=nStock+1,
									cCompra=case when nStockMinimo>nStock+1 
													then 1 else 0 end
								 WHERE idProducto= @idprod;
   select 'ok' as rpta,'Correcto' as msg;
end 

 end

