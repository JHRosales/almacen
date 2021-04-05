USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[entrada_NOActivosRegresaeliminado]    Script Date: 04/04/2021 21:04:16 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER proc [almacen].[entrada_NOActivosRegresaeliminado]
@p_identrada integer
as    
Declare @idprod as Integer
Declare @cant as Integer
Declare 
@iddetentrada int  
Declare @idmat int;

begin    

	
if @p_identrada>0
begin
	DECLARE JCUR_regresarStock  
	CURSOR FOR  select idActivos,ncantidad from almacen.detEntradaActivos  
						where vEstado=5 and idEntradaActivos  =  @p_identrada
	
	OPEN JCUR_regresarStock 
	FETCH NEXT FROM JCUR_regresarStock INTO @idmat ,@cant

	WHILE @@fetch_status = 0
		BEGIN
			UPDATE activos SET nStock=nStock+@cant, disponible=1  where idActivos=@idmat
			FETCH NEXT FROM JCUR_regresarStock INTO @idmat ,@cant
		END
	CLOSE JCUR_regresarStock
	DEALLOCATE JCUR_regresarStock

	update almacen.detEntradaActivos set vEstado ='1' where vEstado='5' and idEntradaActivos  =@p_identrada;

	select 'ok' as rpta,'Correcto' as msg;

end 


end

