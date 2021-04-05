USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [dbo].[update_detEntradaProd]    Script Date: 04/04/2021 19:44:24 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER proc [dbo].[update_detEntradaProd]   
@p_idDetEntradaProd integer,     
@p_nPrecUnit numeric(10,2),     
@p_nCantidad integer,     
@p_nPrecTota numeric(10,2),
@p_vHost varchar(50),
@p_vUser varchar(50)
as    
Declare 
@iddetentr varchar(20),
@can int,
@idprodanterior int
begin    
if exists( select idDetEntradaProd from almacen.detEntradaProd where idDetEntradaProd=@p_idDetEntradaProd)
  begin	
  select @can= nCantidad from almacen.detEntradaProd where idDetEntradaProd=@p_idDetEntradaProd;
  select @idprodanterior= idProducto from almacen.detEntradaProd where idDetEntradaProd=@p_idDetEntradaProd;
  
		 update  almacen.detEntradaProd set 
		 nPrecioUnit=@p_nPrecUnit, 
		 nCantidad=@p_nCantidad,
		 nPrecioTotal=@p_nPrecTota,
		 vUsernm=@p_vUser,
		 vHostnm=@p_vHost
		  where idDetEntradaProd=@p_idDetEntradaProd;

		update dbo.producto set nStock=nStock-@can where idProducto=@idprodanterior;
		update dbo.producto set nStock=nStock+@p_nCantidad,
									cCompra=case when nStockMinimo>=nStock+@p_nCantidad 
													then 1 else 0 end
								 where idProducto=@idprodanterior;
		
  end



end

