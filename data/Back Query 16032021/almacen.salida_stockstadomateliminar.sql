USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[salida_stockstadomateliminar]    Script Date: 03/18/2021 16:31:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER proc [almacen].[salida_stockstadomateliminar]
@p_idmaterial integer,
@p_idDetSalidamat integer
as    
Declare @idprod as Integer
Declare @cant as Integer
begin    

if @p_idDetSalidamat>0
begin

	--Para validar se tiene que pregunatar si existe mas de un mismo material en el detalle de salida entonces se puede eliminar, si hay uno se valida que no haya retornado sino no se podria eliminar
	--Se quita la validacion 	
	
	--if exists(
	--select * from almacen.detRetornoMat where idRetornoMat in (
	--select idRetornoMat from almacen.retornoMat where idSalidaMat in (
	--select idSalidaMat from almacen.detSalidaMat where idDetSalidaMat=@p_idDetSalidamat
	--)) and idMaterial=@p_idmaterial
	--)
	--begin 
		--select 'ERR' as rpta,'Material ya tiene Retorno, No se puede eliminar' as msg;
	--end
	--else
	--begin
		select  @cant=nCantidad from almacen.detSalidaMat where idDetSalidaMat=@p_idDetSalidamat;
		
		update almacen.detSalidaMat set vEstado=5 where idDetSalidaMat=@p_idDetSalidamat;
		 UPDATE material_almacen SET nStock=nStock+@cant,
									cCompra=case when nStockMinimo>nStock+@cant 
													then 1 else 0 end
					 WHERE idMaterial= @p_idmaterial;
		 select 'ok' as rpta,'Correcto' as msg;
	--end
--end
--else
--begin
 
    
--   UPDATE material SET nStock=nStock+1 WHERE idMaterial = @p_idmaterial;
--   select 'ok' as rpta,'Correcto' as msg;

end 

end

