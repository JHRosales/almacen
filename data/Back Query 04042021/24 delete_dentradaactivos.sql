USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [dbo].[delete_dentradaactivos]    Script Date: 04/04/2021 20:57:11 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER proc [dbo].[delete_dentradaactivos]   
@p_iddentradaact integer
as    
Declare @idact int,
@cant int;
begin 
--CUANDO se da en el tachito de entrama material (resta el stock y cambia el estado a EliminadoTemporal)   
select @idact=idActivos from almacen.detEntradaActivos where idDetEntradaActivos=@p_iddentradaact
select @cant=nCantidad from almacen.detEntradaActivos where idDetEntradaActivos=@p_iddentradaact


update activos set nStock=nStock-@cant, disponible=0 where idActivos=@idact

 --delete  from almacen.detEntradaMat   where idDetEntradaMat=@p_iddentradamat;
  update almacen.detEntradaActivos set vEstado =5  where idDetEntradaActivos=@p_iddentradaact;
  select @p_iddentradaact;
end

