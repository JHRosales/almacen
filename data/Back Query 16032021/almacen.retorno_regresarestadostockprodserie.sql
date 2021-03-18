USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[retorno_regresarestadostockprodserie]    Script Date: 03/18/2021 16:40:39 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER proc [almacen].[retorno_regresarestadostockprodserie]
@p_idprodserie integer,
@p_idDetSalidaprod integer,
@p_idDetRetornoprod integer
as    
Declare @idprod as Integer
begin    

--PARA RETORNOPRODUCTOS 

if @p_idDetRetornoprod>0
begin
	--if exists(select * from almacen.detRetornoProd where idRetornoProd in (
	--select idRetornoProd from almacen.retornoProd where idSalidaProd in (
	--select idSalidaProd from almacen.detSalidaProd where idDetSalidaProd=@p_idDetSalidaprod
	--)) and idProdSeries=@p_idprodserie and vEstado=1)
	--begin 
	--select 'ERR' as rpta,'Producto ya tiene Retorno, No se puede eliminar' as msg;
	--end
	--else
	--begin
	--R : Retorno temporal
	--E : Eliminado temporal
		select @idprod=idProducto from almacen.prodSeries where idProdSeries=@p_idprodserie;
		update almacen.detRetornoProd set vEstado='5' where idDetRetornoProd=@p_idDetRetornoprod;
		update almacen.prodSeries set vEstAlmacen='E' where idProdSeries=@p_idprodserie
		UPDATE producto SET nStock=nStock+1,
									cCompra=case when nStockMinimo>nStock+1
													then 1 else 0 end
								 WHERE idProducto = @idprod;
		select 'ok' as rpta,'Correcto' as msg;
		 
	--end
end
else
begin
--SI se agrego pero todavia no se guarda y se da click en el tachito, entonces regresa el stock y el estado al prodcutoserie como salida.
   select @idprod=idProducto from almacen.prodSeries where idProdSeries=@p_idprodserie;
   
   update almacen.prodSeries set vEstAlmacen='2' where idProdSeries=@p_idprodserie  
   UPDATE producto SET nStock=nStock-1,
									cCompra=case when nStockMinimo>nStock-1
													then 1 else 0 end
								 WHERE idProducto= @idprod;

   select 'ok' as rpta,'Correcto' as msg;
end 

 end

