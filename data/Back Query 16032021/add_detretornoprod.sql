USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [dbo].[add_detretornoprod]    Script Date: 03/18/2021 21:52:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER proc [dbo].[add_detretornoprod]     
@p_idprodser int,  
@p_idretornoprod int,  
@p_iddetretornoprod int,  
@p_iddetsalidaprod int,  
@p_observ varchar(150),
@p_stock int 
as      
Declare   
@iddetentr varchar(20),  
@idprod int,  
@idmatanterior int ,
@serie varchar(100); 
begin      
set dateformat dmy
if exists( select idDetRetornoProd from almacen.detRetornoProd where idDetRetornoProd=@p_iddetretornoprod)  
  begin   
 select @idprod= idProducto from almacen.prodSeries a where idProdSeries=@p_idprodser; 
 select  @serie= vNroSerie from almacen.prodSeries a where idProdSeries=@p_idprodser;  
  select @idmatanterior= idProdSeries from almacen.detRetornoProd where idDetRetornoProd=@p_iddetretornoprod;  
    
  update almacen.detRetornoProd  set    
   idRetornoProd =@p_idretornoprod  
   ,idProdSeries= @p_idprodser  
   ,idDetSalidaProd =@p_iddetsalidaprod 
   ,vNroSerie=@serie
   , vObserv=@p_observ 
   ,vEstado=1   
   ,dFecReg=GETDATE()     
   ,nstock=@p_stock
  where idDetRetornoProd=@p_iddetretornoprod;  
  
  --update dbo.producto set nStock=nStock-1  where idProducto=@idprod;  
  --update dbo.producto set nStock=nStock+1 where idProducto=@idprod;  
    
  end  
  else  
  begin  
    
  /*select top 1 @p_iddetretornoprod=idDetRetornoProd from almacen.detRetornoProd   
  where idRetornoProd=@p_idretornoprod and idProdSeries=@p_idprodser;  
    IF @p_iddetretornoprod>0  
    begin   
      
    select @idprod= idProducto from almacen.detRetornoProd a inner join 
  almacen.prodSeries b on a.idProdSeries=b.idProdSeries where idDetRetornoProd=@p_iddetretornoprod;  
  select @idmatanterior= idProdSeries from almacen.detRetornoProd  where idRetornoProd=@p_idretornoprod and idProdSeries=@p_idprodser;  
    
   update almacen.detRetornoProd  set    
     vObserv=@p_observ  
     
   --,nPrecioUnit=nPrecioUnit+@p_preciounitario  
   where idDetRetornoProd=@p_iddetretornoprod;
    
   --update dbo.producto set nStock=nStock-1 where idProducto=@idprod;  
  
    
    end  
    else  
    begin  */

	select @idprod= idProducto from almacen.prodSeries a where idProdSeries=@p_idprodser; 
	select  @serie= vNroSerie from almacen.prodSeries a where idProdSeries=@p_idprodser;  
	select @iddetentr = coalesce(max(idDetRetornoProd),0)  +1 --right(replicate('0',10) + cast(isnull(max(idCotiz), 0) + 1  as varchar(10)),10)      
	from almacen.detRetornoProd;  
	insert into almacen.detRetornoProd     
	(idDetRetornoProd , idRetornoProd , idProdSeries ,vNroSerie,vEstado ,dFecReg,vObserv,idDetSalidaProd ,nstock)      
	values( @iddetentr,@p_idretornoprod, @p_idprodser,@serie, 1,GETDATE(),@p_observ ,@p_iddetsalidaprod,@p_stock);  

	--update dbo.producto set nStock=nStock+1 where idProducto=@idprod;  
	update almacen.prodSeries set vEstAlmacen='1' where idProdSeries=@p_idprodser;  
	
	--end   
  end  
      
Select 'Agregado al detalle' as ok  
end
