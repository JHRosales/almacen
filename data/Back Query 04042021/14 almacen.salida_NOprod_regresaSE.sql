USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[salida_NOprod_regresaSE]    Script Date: 04/04/2021 19:38:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO



ALTER proc [almacen].[salida_NOprod_regresaSE]
@p_idsalidaprod integer
as    

Declare @idprod as Integer
Declare @cant as Integer
Declare @idprodSeries as Integer
Declare 
@iddetentrada int  
Declare @idmat int;

begin    

if @p_idsalidaprod>0
begin

--si estaba salida temporal se regresa a almacen
--update almacen.prodSeries set vEstAlmacen ='1' where idDetEntradaProd in
-- (select idDetSalidaProd   from almacen.detSalidaProd where idSalidaProd =@p_idsalidaprod  ) and vEstAlmacen ='S'
 
 --Si estaba eliminado temporal se regresa a activo
 --update almacen.prodSeries set vEstado ='1' where idDetEntradaProd in
-- (select idDetSalidaProd   from almacen.detSalidaProd where idSalidaProd =@p_idsalidaprod  ) and vEstado ='5'

--Sie estaba eliminado temporal se regresa a activo
	DECLARE JCUR_regresarStock1  
	CURSOR FOR select b.idProducto ,1 cantidad, a.idProdSeries   from almacen.detSalidaProd a
inner join almacen.prodSeries b on a.idProdSeries =b.idProdSeries  where idSalidaProd =@p_idsalidaprod and a.vEstado ='5';
	
	OPEN JCUR_regresarStock1 
	FETCH NEXT FROM JCUR_regresarStock1 INTO @idprod ,@cant,@idprodSeries

	WHILE @@fetch_status = 0
		BEGIN
			UPDATE producto  SET nStock=nStock-@cant ,
									cCompra=case when nStockMinimo>=nStock-@cant 
													then 1 else 0 end
								 where idProducto =@idprod;
			update almacen.prodSeries set vEstAlmacen='2',vEstado ='1' where idProdSeries=@idprodSeries --idDetEntradaProd in (select idDetSalidaProd   from almacen.detSalidaProd where idSalidaProd =@p_idsalidaprod  ) and vEstado ='5';
			update almacen.detSalidaProd set vEstado='1' where idSalidaProd =@p_idsalidaprod and vEstado ='5';
			FETCH NEXT FROM JCUR_regresarStock1 INTO @idprod ,@cant,@idprodSeries
		END
	CLOSE JCUR_regresarStock1
	DEALLOCATE JCUR_regresarStock1

end 

	DECLARE JCUR_regresarStock  
	CURSOR FOR select idProducto , 1 cantidad, idProdSeries   from almacen.prodSeries where vEstAlmacen ='S';
	
	OPEN JCUR_regresarStock 
	FETCH NEXT FROM JCUR_regresarStock INTO @idprod ,@cant,@idprodSeries

	WHILE @@fetch_status = 0
		BEGIN
			UPDATE producto  SET nStock=nStock+@cant ,
									cCompra=case when nStockMinimo>=nStock+@cant 
													then 1 else 0 end
								 where idProducto =@idprod
			update almacen.prodSeries set vEstAlmacen=1 WHERE idProdSeries = @idprodSeries and vEstAlmacen ='S'
			FETCH NEXT FROM JCUR_regresarStock INTO @idprod ,@cant,@idprodSeries
		END
	CLOSE JCUR_regresarStock
	DEALLOCATE JCUR_regresarStock

	select 'ok' as rpta,'Correcto' as msg;
end

