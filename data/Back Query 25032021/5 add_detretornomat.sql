USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [dbo].[add_detretornomat]    Script Date: 03/25/2021 22:19:31 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER proc [dbo].[add_detretornomat]     
@p_idmat int,  
@p_idretornomat int,  
@p_iddetretornomat int,  
@p_iddetsalidamat int,
@p_cantidad int ,
@p_observ varchar(150),
@p_stock int,
@p_fecRetornoMat varchar(10) = null    
as      
Declare   
@iddetentr varchar(20),  
@can int,  
@idmatanterior int  
begin   
	set dateformat dmy 
	
	if @p_fecRetornoMat='01/01/1900' or @p_fecRetornoMat='1900-01-01' or @p_fecRetornoMat=''
	begin
		set @p_fecRetornoMat=null
	end
	   
if exists( select idDetRetornoMat from almacen.detRetornoMat where idDetRetornoMat=@p_iddetretornomat)  
  begin   
  select @can= nCantidad from almacen.detRetornoMat where idDetRetornoMat=@p_iddetretornomat;  
  select @idmatanterior= idMaterial from almacen.detRetornoMat where idDetRetornoMat=@p_iddetretornomat;  
    
  update almacen.detRetornoMat  set    
   idRetornoMat =@p_idretornomat  
   ,idMaterial= @p_idmat  
   ,nCantidad=@p_cantidad 
   , vObserv=@p_observ 
   ,vEstado=1   
   ,dFecReg=GETDATE()   
   ,idDetSalidaMat=@p_iddetsalidamat 
   ,nStock=@p_stock 
   ,dFecRetornoMat=@p_fecRetornoMat
  where idDetRetornoMat=@p_iddetretornomat;  
  
  update dbo.material_almacen set nStock=nStock-@can where idMaterial=@idmatanterior;  
  update dbo.material_almacen set nStock=nStock+@p_cantidad,cCompra=case when nStockMinimo>nStock+@p_cantidad 
													then 1 else 0 end
												 where idMaterial=@p_idmat;  
    
  end  
  else  
  begin  
    
  --select top 1 @p_iddetretornomat=idRetornoMat from almacen.detRetornoMat   
  --where idRetornoMat=@p_idretornomat and idMaterial=@p_idmat;  
  --  IF @p_iddetretornomat>0  
  --  begin   
      
  --  select @can= nCantidad from almacen.detRetornoMat  where idRetornoMat=@p_idretornomat and idMaterial=@p_idmat;  
  --select @idmatanterior= idMaterial from almacen.detRetornoMat  where idRetornoMat=@p_idretornomat and idMaterial=@p_idmat;  
    
  -- update almacen.detRetornoMat  set    
  -- nCantidad=@p_cantidad 
  --  , vObserv=@p_observ   
  -- --,nPrecioUnit=nPrecioUnit+@p_preciounitario  
  -- where idDetRetornoMat=@p_iddetretornomat;  
  -- update dbo.material set nStock=nStock-@can where idMaterial=@idmatanterior;  
  -- update dbo.material set nStock=nStock+@p_cantidad where idMaterial=@p_idmat;  
  --  end  
  --  else  
  --  begin  
    
     select @iddetentr = coalesce(max(idDetRetornoMat),0)  +1 --right(replicate('0',10) + cast(isnull(max(idCotiz), 0) + 1  as varchar(10)),10)      
   from almacen.detRetornoMat;  
   insert into almacen.detRetornoMat      
   (idDetRetornoMat, idRetornoMat , idMaterial , nCantidad,vEstado ,dFecReg,vObserv,idDetSalidaMat,nStock,dFecRetornoMat)      
   values( @iddetentr,@p_idretornomat, @p_idmat,@p_cantidad, 1,GETDATE(),@p_observ ,@p_iddetsalidamat,@p_stock,@p_fecRetornoMat);  
   
   update dbo.material_almacen set nStock=nStock+@p_cantidad,
	cCompra=case when nStockMinimo>nStock-@p_cantidad 
													then 1 else 0 end
	 where idMaterial=@p_idmat;  
    
  --end   
  end  
    
  
    
Select 'Agregado al detalle' as ok  
end
