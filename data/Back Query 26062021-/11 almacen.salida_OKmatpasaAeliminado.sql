USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[salida_OKmatpasaAeliminado]    Script Date: 28/06/2021 13:00:10 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER proc almacen.salida_OKmatpasaAeliminado
@p_idSalidamat integer
as    
begin    

if @p_idSalidamat>0
begin
		update almacen.detSalidaMat set vEstado=4 where idSalidaMat=@p_idSalidamat and vEstado=5;
		--Se pasa a anulado los tecnincos que estan anulados temporalmente
		update almacen.detTecnicoMat set vEstado=4 where idSalidaMat=@p_idSalidamat and vEstado=5;
		 select 'ok' as rpta,'Correcto' as msg;
end 

 end
