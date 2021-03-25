USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [dbo].[add_detsalidaActivos]    Script Date: 03/18/2021 20:51:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER proc [dbo].[add_detsalidaActivos]   
@p_idActivo int,
@p_idsalidaActivo int,
@p_iddetsalidaActivo int,
@p_cantidad int ,
@p_nstocksalida int ,
@p_fecsalidaactivos varchar(10) = null
as    
Declare 
@iddetentr varchar(20),
@can int,
@idmatanterior int
begin    

if @p_fecsalidaactivos ='1900-01-01'
begin
set @p_fecsalidaactivos=null
end

if exists( select idDetSalidaActivo from almacen.detSalidaActivos where idDetSalidaActivo=@p_iddetsalidaActivo)
  begin	
  select @can= nCantidad from almacen.detSalidaActivos where idDetSalidaActivo=@p_iddetsalidaActivo;
  select @idmatanterior= idActivos from almacen.detSalidaActivos where idDetSalidaActivo=@p_iddetsalidaActivo;
  
		update almacen.[detSalidaActivos]  set  
			[idSalidaActivo] =@p_idsalidaActivo
			,[idActivos]= @p_idActivo
			,nCantidad=@p_cantidad
			,vEstado=1 
			,nStockSalida=@p_nstocksalida
			,dFecReg=GETDATE() 
			,dFecSalidaActivos=@p_fecsalidaactivos 
		where [idDetSalidaActivo]=@p_iddetsalidaActivo;


		update dbo.activos set nStock=nStock+@can where idActivos=@idmatanterior;
		update dbo.activos set nStock=nStock-@p_cantidad where idActivos=@p_idActivo;
		
  end
  else
  begin

  		
  			select @iddetentr = coalesce(max(idDetSalidaActivo),0)  +1 --right(replicate('0',10) + cast(isnull(max(idCotiz), 0) + 1  as varchar(10)),10)    
			from almacen.detSalidaActivos;
			insert into almacen.detSalidaActivos    
			(idDetSalidaActivo, idSalidaActivo , idActivos , nCantidad,vEstado ,dFecReg,nStockSalida,dFecSalidaActivos)    
			values(	@iddetentr,@p_idsalidaActivo, @p_idActivo,@p_cantidad, 1,GETDATE(),@p_nstocksalida,@p_fecsalidaactivos);
 			
 			update dbo.activos set nStock=nStock-@p_cantidad where idActivos=@p_idActivo;
 			
 
  end
  

		
Select 'Agregado al detalle' as ok
end
