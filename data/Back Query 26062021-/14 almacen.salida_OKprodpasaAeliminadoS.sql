USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[salida_OKprodpasaAeliminadoS]    Script Date: 28/06/2021 14:26:14 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER proc almacen.salida_OKprodpasaAeliminadoS
@p_idsalidaprod integer
as    
begin    

if @p_idsalidaprod>0
begin
		--si estaba salida temporal se pasa a salida
--update almacen.prodSeries set vEstAlmacen ='2' where idDetEntradaProd in
-- (select idDetSalidaProd   from almacen.detSalidaProd where idSalidaProd =@p_idsalidaprod  ) and vEstAlmacen ='S'
 
 --Si estaba eliminado temporal se pasa a Activo
 --update almacen.prodSeries set vEstado ='1',vEstAlmacen=1 where idDetEntradaProd in
 --(select idDetSalidaProd   from almacen.detSalidaProd where idSalidaProd =@p_idsalidaprod  ) and vEstado ='5'

--Sie estaba eliminado temporal se pasa a eliminado
update almacen.detSalidaProd set vEstado='4' where idSalidaProd =@p_idsalidaprod and vEstado ='5';

--Pasa a anulado todos los tecnicos eliminados temporalmente
update almacen.detTecnicoProd set vEstado=4 where idSalidaProd =@p_idsalidaprod and vEstado =5;

		 select 'ok' as rpta,'Correcto' as msg;
end 

 end
