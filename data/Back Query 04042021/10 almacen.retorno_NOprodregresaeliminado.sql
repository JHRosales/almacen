USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[retorno_NOprodregresaeliminado]    Script Date: 04/04/2021 19:33:20 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER proc [almacen].[retorno_NOprodregresaeliminado]
@p_idretornoprod integer
as    
Declare @idprod as Integer
Declare @cant as Integer
Declare @idprodSeries as Integer

Declare 
@iddetentrada int  
Declare @idmat int;

begin    
 
if @p_idretornoprod>0
begin

update almacen.prodSeries set vEstado ='1' where idProdSeries  in
 (select idProdSeries from almacen.detRetornoProd  where idRetornoProd = @p_idretornoprod  ) and vEstado ='5'
 
 UPDATE b SET nStock=nStock+a.cant,cCompra=case when nStockMinimo>=nStock+a.cant 
													then 1 else 0 end
	from  (select idProducto,COUNT(*) cant from  almacen.prodSeries where idProdSeries  in
 (select idProdSeries from almacen.detRetornoProd  where idRetornoProd = @p_idretornoprod  ) and vEstAlmacen ='R'
 group by idProducto) a 
inner join producto b on a.idProducto=b.idProducto 

  --Si estaba con retorno y pasa a eliminado temporal (R) entonces se regresa a retorno
 update almacen.prodSeries set vEstAlmacen ='1' where idProdSeries  in
 (select idProdSeries from almacen.detRetornoProd  where idRetornoProd = @p_idretornoprod and vEstAlmacen ='R'  ) and vEstAlmacen ='R'
 
 --Si estaba con retorno temporal (R) entonces se regresa a salida 
 update almacen.prodSeries set vEstAlmacen ='2' where idProdSeries  in
 (select idProdSeries from almacen.detRetornoProd  where idRetornoProd = @p_idretornoprod  ) and vEstAlmacen ='R'

 

 
--Sie estaba eliminado temporal se regresa a activo
update almacen.detRetornoProd set vEstado='1' where idRetornoProd =@p_idretornoprod and vEstado ='5';




end 

	DECLARE JCUR_regresarStock  
	CURSOR FOR select idProducto , 1 cantidad, idProdSeries   from almacen.prodSeries where vEstAlmacen ='R';
	
	OPEN JCUR_regresarStock 
	FETCH NEXT FROM JCUR_regresarStock INTO @idprod ,@cant,@idprodSeries

	WHILE @@fetch_status = 0
		BEGIN
			UPDATE producto  SET nStock=nStock-@cant,
									cCompra=case when nStockMinimo>=nStock-@cant 
													then 1 else 0 end
								  where idProducto =@idprod
			update almacen.prodSeries set vEstAlmacen=2 WHERE idProdSeries = @idprodSeries and vEstAlmacen ='R'
			FETCH NEXT FROM JCUR_regresarStock INTO @idprod ,@cant,@idprodSeries
		END
	CLOSE JCUR_regresarStock
	DEALLOCATE JCUR_regresarStock

	select 'ok' as rpta,'Correcto' as msg;
end

