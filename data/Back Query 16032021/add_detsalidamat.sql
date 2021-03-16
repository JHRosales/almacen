USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [dbo].[add_detsalidamat]    Script Date: 03/09/2021 01:36:46 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER proc [dbo].[add_detsalidamat]   
@p_idmat int,
@p_idsalidamat int,
@p_iddetsalidamat int,
@p_cantidad int ,
@p_nstocksalida int,
@p_fecsalidamaterial date = null
as    
Declare 
@iddetentr varchar(20),
@can int,
@idmatanterior int
begin    

if @p_fecsalidamaterial='01/01/1900'
begin
	set @p_fecsalidamaterial=null
end


if exists( select idDetSalidaMat from almacen.detSalidaMat where idDetSalidaMat=@p_iddetsalidamat)
  begin	
  select @can= nCantidad from almacen.detSalidaMat where idDetSalidaMat=@p_iddetsalidamat;
  select @idmatanterior= idMaterial from almacen.detSalidaMat where idDetSalidaMat=@p_iddetsalidamat;
  
		update almacen.detSalidaMat  set  
			idSalidaMat =@p_idsalidamat
			,idMaterial= @p_idmat
			,nCantidad=@p_cantidad
			,vEstado=1 
			,nStockSalida=@p_nstocksalida
			,dFecReg=GETDATE()
			,dFecSalidaMaterial=@p_fecsalidamaterial 
		where idDetSalidaMat=@p_iddetsalidamat;

		update dbo.material_almacen set nStock=nStock+@can where idMaterial=@idmatanterior;
		update dbo.material_almacen set nStock=nStock-@p_cantidad where idMaterial=@p_idmat;
		
  end
  else
  begin
  
		--  select top 1 @p_iddetsalidamat=idDetSalidaMat from almacen.detSalidaMat 
		--  where idSalidaMat=@p_idsalidamat and idMaterial=@p_idmat;
  --		IF @p_iddetsalidamat>0
  --		begin 
  		
  --		select @can= nCantidad from almacen.detSalidaMat  where idSalidaMat=@p_idsalidamat and idMaterial=@p_idmat;
		--select @idmatanterior= idMaterial from almacen.detSalidaMat  where idSalidaMat=@p_idsalidamat and idMaterial=@p_idmat;
 
		--	update almacen.detSalidaMat  set  
		--	nCantidad=@p_cantidad ,
		--	--,nPrecioUnit=nPrecioUnit+@p_preciounitario
		--	vEstado =1
		--	where idDetSalidaMat=@p_iddetsalidamat;
		--	update dbo.material set nStock=nStock+@can where idMaterial=@idmatanterior;
		--	update dbo.material set nStock=nStock-@p_cantidad where idMaterial=@p_idmat;
  --		end
  --		else
  --		begin
  		
  			select @iddetentr = coalesce(max(idDetSalidaMat),0)  +1 --right(replicate('0',10) + cast(isnull(max(idCotiz), 0) + 1  as varchar(10)),10)    
			from almacen.detSalidaMat;
			insert into almacen.detSalidaMat    
			(idDetSalidaMat, idSalidaMat , idMaterial , nCantidad,vEstado ,dFecReg,nStockSalida,dFecSalidaMaterial)    
			values(	@iddetentr,@p_idsalidamat, @p_idmat,@p_cantidad, 1,GETDATE(),@p_nstocksalida,@p_fecsalidamaterial);
 			update dbo.material_almacen set nStock=nStock-@p_cantidad where idMaterial=@p_idmat;
 			
 			
		--end 
  end
  

		
Select 'Agregado al detalle' as ok
end
