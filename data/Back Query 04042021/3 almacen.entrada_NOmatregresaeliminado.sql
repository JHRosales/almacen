USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[entrada_NOmatregresaeliminado]    Script Date: 04/04/2021 19:24:53 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER proc [almacen].[entrada_NOmatregresaeliminado]
@p_identradamat integer
as    
Declare @idprod as Integer
Declare @cant as Integer
Declare 
@iddetentrada int  
Declare @idmat int;

begin    

	
if @p_identradamat>0
begin
	DECLARE JCUR_regresarStock  
	CURSOR FOR  select idmaterial,ncantidad from almacen.detEntradaMat  where vEstado=5 and idEntradaMat  =  @p_identradamat
	
	OPEN JCUR_regresarStock 
	FETCH NEXT FROM JCUR_regresarStock INTO @idmat ,@cant

	WHILE @@fetch_status = 0
		BEGIN
			UPDATE material_almacen SET nStock=nStock+@cant,
										cCompra=case when nStockMinimo>=nStock+@cant 
													then 1 else 0 end 
										where idMaterial=@idmat
			FETCH NEXT FROM JCUR_regresarStock INTO @idmat ,@cant
		END
	CLOSE JCUR_regresarStock
	DEALLOCATE JCUR_regresarStock

	update almacen.detEntradaMat set vEstado ='1' where vEstado='5' and idEntradaMat  =@p_identradamat;

	select 'ok' as rpta,'Correcto' as msg;

end 


end

