USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [dbo].[eliminar_cliente]    Script Date: 03/16/2021 02:28:53 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create proc [dbo].[eliminar_proveedor]    
@p_idsigma int
as
begin    
    
 delete from proveedor    
 where idProveedor=@p_idsigma
     
 select @p_idsigma as 'idProveedor'    
end


