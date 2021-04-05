USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[entrada_NOprodregresaeliminado]    Script Date: 04/04/2021 19:26:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER proc [almacen].[entrada_NOprodregresaeliminado]
@p_identradaprod integer
as    
Declare @idprod as Integer
Declare @cant as Integer
Declare 
@iddetentrada int  
Declare @iddetE int;

begin    

	
	
	
if @p_identradaprod>0
begin
	DECLARE JCUR_regresarStock  
	CURSOR FOR  select idDetEntradaProd ,ncantidad from almacen.detEntradaProd  where vEstado=5	 and idEntradaProd    =@p_identradaprod
	 
	OPEN JCUR_regresarStock 
	FETCH NEXT FROM JCUR_regresarStock INTO @iddetE ,@cant

	WHILE @@fetch_status = 0
		BEGIN
			--Se regresa el Stock 
			select @idprod=idProducto  from almacen.detEntradaProd where idDetEntradaProd=@iddetE			
			update producto  set nStock=nStock+@cant,
									cCompra=case when nStockMinimo>=nStock+@cant 
													then 1 else 0 end
								where idProducto =@idprod;


			FETCH NEXT FROM JCUR_regresarStock INTO @iddetE ,@cant
		END
	CLOSE JCUR_regresarStock
	DEALLOCATE JCUR_regresarStock

			update almacen.detEntradaProd set vEstado=1 where vEstado=5 and idEntradaProd=@p_identradaprod;
			update almacen.prodSeries set vEstado=1 where vEstado=5  and  idDetEntradaProd in ( select idDetEntradaProd  from almacen.detEntradaProd  where  idEntradaProd    =@p_identradaprod);
	

	select 'ok' as rpta,'Correcto' as msg;

end 

end

