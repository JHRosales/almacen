USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[salida_NOmatregresaeliminado]    Script Date: 28/06/2021 12:50:11 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER proc [almacen].[salida_NOmatregresaeliminado]
@p_idSalidamat integer
as    
Declare @idprod as Integer
Declare @cant as Integer
Declare 
@iddetentrada int  
Declare @idmat int;

begin    
 
if @p_idSalidamat>0
begin
	DECLARE JCUR_regresarStock  
	CURSOR FOR select idmaterial,ncantidad from almacen.detSalidaMat where vEstado=5 and idSalidaMat  =@p_idSalidamat
	
	OPEN JCUR_regresarStock 
	FETCH NEXT FROM JCUR_regresarStock INTO @idmat ,@cant

	WHILE @@fetch_status = 0
		BEGIN
			UPDATE material_almacen SET nStock=nStock-@cant,
										cCompra=case when nStockMinimo>nStock-@cant 
													then 1 else 0 end
										where idMaterial=@idmat
			FETCH NEXT FROM JCUR_regresarStock INTO @idmat ,@cant
		END
	CLOSE JCUR_regresarStock
	DEALLOCATE JCUR_regresarStock

	update almacen.detSalidaMat set vEstado =1 where vEstado=5 and idSalidaMat  =@p_idSalidamat;
	--Se regresa a activos los tecnicos eliminados terporalmente
	update almacen.detTecnicoMat set vEstado =1 where vEstado=5 and idSalidaMat  =@p_idSalidamat;

	select 'ok' as rpta,'Correcto' as msg;

end 

end

