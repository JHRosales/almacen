USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [dbo].[add_detretornoactivos]    Script Date: 03/18/2021 21:54:04 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER proc [dbo].[add_detretornoactivos]     
@p_idactivos int,  
@p_idretornoactivos int,  
@p_iddetretornoactivos int,  
@p_iddetsalidaactivos int,
@p_cantidad int ,
@p_observ varchar(150),
@p_stock int  
as      
Declare   
@iddetentr varchar(20),  
@can int,  
@idmatanterior int  
begin     
set dateformat dmy 
if exists( select idDetRetornoActivos from almacen.detRetornoActivos where idDetRetornoActivos=@p_iddetretornoactivos)  
  begin   
  select @can= nCantidad from almacen.detRetornoActivos where idDetRetornoActivos=@p_iddetretornoactivos;  
  select @idmatanterior= idActivos from almacen.detRetornoActivos where idDetRetornoActivos=@p_iddetretornoactivos;  
    
  update almacen.detRetornoActivos  set    
   idRetornoActivos =@p_idretornoactivos  
   ,idActivos= @p_idactivos  
   ,nCantidad=@p_cantidad 
   , vObserv=@p_observ 
   ,vEstado=1   
   ,dFecReg=GETDATE()   
   ,idDetSalidaActivos=@p_iddetsalidaactivos
   ,nStock=@p_stock 
  where idDetRetornoActivos=@p_iddetretornoactivos;  
  
  update dbo.activos set nStock=nStock-@can where idActivos=@idmatanterior;  
  update dbo.activos set nStock=nStock+@p_cantidad where idActivos=@p_idactivos;  
    
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
    
     select @iddetentr = coalesce(max(idDetRetornoActivos),0)  +1 --right(replicate('0',10) + cast(isnull(max(idCotiz), 0) + 1  as varchar(10)),10)      
   from almacen.detRetornoActivos;  
   insert into almacen.detRetornoActivos      
   (idDetRetornoActivos, idRetornoActivos , idActivos, nCantidad,vEstado ,dFecReg,vObserv,idDetSalidaActivos,nStock)      
   values( @iddetentr,@p_idretornoactivos, @p_idactivos,@p_cantidad, 1,GETDATE(),@p_observ ,@p_iddetsalidaactivos,@p_stock);  
    update dbo.activos set nStock=nStock+@p_cantidad where idActivos=@p_idactivos;  
  
  end  
    
  
    
Select 'Agregado al detalle' as ok  
end
