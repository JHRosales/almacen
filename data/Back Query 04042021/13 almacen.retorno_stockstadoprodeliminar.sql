USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[retorno_stockstadoprodeliminar]    Script Date: 04/04/2021 19:36:43 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER proc [almacen].[retorno_stockstadoprodeliminar]
@p_idprodserie integer,
@p_idDetSalidaprod integer,
@p_idDetRetornoprod integer
as    
Declare @idprod as Integer
begin    


if @p_idDetRetornoprod>0
begin
	/**/
	--Si existe una salida posterior al retorno del producto entonces no se puede eliminar el retorno
	/*select * from almacen.detSalidaProd where idProdSeries=@p_idprodserie and vEstado=1 
	and dFecReg> (select dFecReg from almacen.detRetornoProd where idDetRetornoProd=@p_idDetRetornoprod)*/
	
	--Si tiene retorno ya no se puede eliminar
	if exists(
	select * from almacen.detRetornoProd where idRetornoProd in (
	select idRetornoProd from almacen.retornoProd where idSalidaProd in (
	select idSalidaProd from almacen.detSalidaProd where idDetSalidaProd=@p_idDetSalidaprod
	)) and idProdSeries=@p_idprodserie and vEstado=1 and idDetRetornoProd <>@p_idDetRetornoprod
	)
	begin 
	select 'ERR' as rpta,'Producto ya tiene Retorno, No se puede eliminar' as msg;
	end
	else
	begin
	--R : Retorno temporal
	--R : Eliminado temporal
		select @idprod=idProducto from almacen.prodSeries where idProdSeries=@p_idprodserie;
		update almacen.detRetornoProd set vEstado='5' where idDetRetornoProd =@p_idDetRetornoprod;
		update almacen.prodSeries set vEstAlmacen  ='R' where idProdSeries=@p_idprodserie
		UPDATE producto SET nStock=nStock-1,
									cCompra=case when nStockMinimo>=nStock-1 
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
   update almacen.prodSeries set vEstado='1' where idProdSeries=@p_idprodserie  
   UPDATE producto SET nStock=nStock+1,
									cCompra=case when nStockMinimo>=nStock+1
													then 1 else 0 end
								 WHERE idProducto= @idprod;
   select 'ok' as rpta,'Correcto' as msg;
end 

 end

