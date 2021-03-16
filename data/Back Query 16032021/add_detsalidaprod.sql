USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [dbo].[add_detsalidaprod]    Script Date: 03/16/2021 15:36:15 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER proc [dbo].[add_detsalidaprod]   
@p_idsalidaprod int,
@p_iddetsalidaprod int,
@p_idSerie int,
@p_Serie varchar(100) ,
@p_nstocksalida int ,
@p_fecSalidaProducto date= null
as    
Declare 
@iddetentr varchar(20),
@can int,
@idmatanterior int
begin    
if @p_fecSalidaProducto='01/01/1900'
begin
	set @p_fecSalidaProducto=null
end

if exists( select idDetSalidaProd from almacen.detSalidaProd where idDetSalidaProd=@p_iddetsalidaprod and vestado=1)
  begin	
  --select @can= nCantidad from almacen.detSalidaProd where idDetSalidaMat=@p_iddetsalidamat;
  select @idmatanterior= idProdSeries from almacen.detSalidaProd where idDetSalidaProd=@p_iddetsalidaprod;
  
		update almacen.detSalidaProd  set  
			idSalidaProd =@p_idsalidaprod
			,idProdSeries= @p_idSerie
			,vNroSerie=@p_Serie
			,vEstado=1
			,dFecReg=GETDATE() 
			,nStockSalida=@p_nstocksalida
			,dFecSalidaProducto=@p_fecSalidaProducto  
		where idDetSalidaProd=@p_iddetsalidaprod;
		
		if not exists(select * from almacen.detRetornoProd where idRetornoProd in (
	select idRetornoProd from almacen.retornoProd where idSalidaProd in (
	select idSalidaProd from almacen.detSalidaProd where idDetSalidaProd=@p_idDetSalidaprod
	)) and idProdSeries=@p_idSerie)
	begin
		--update almacen.prodSeries set vEstAlmacen=1 where vEstAlmacen='S';
 		update almacen.prodSeries set vEstAlmacen=2 where idProdSeries=@p_idSerie;	
 	end
  end
  else
  begin
  
			--select top 1 @p_iddetsalidaprod=idDetSalidaProd from almacen.detSalidaProd 
			--where idSalidaProd=@p_idsalidaprod and idProdSeries=@p_idSerie;
			--IF @p_iddetsalidaprod>0
			--begin 

			----select @can= nCantidad from almacen.detSalidaProd  where idSalidaMat=@p_idsalidamat and idMaterial=@p_idmat;
			--select @idmatanterior= idProdSeries from almacen.detSalidaProd  where idSalidaProd=@p_idsalidaprod and idProdSeries=@p_idSerie and vEstado=1;

			--update almacen.detSalidaProd  set  
			--idProdSeries=@p_idSerie,
			--vNroSerie= @p_Serie,
			--vEstado=1
			----,nPrecioUnit=nPrecioUnit+@p_preciounitario
			--where idDetSalidaProd=@p_iddetsalidaprod;
			----update almacen.prodSeries set vEstAlmacen=1 where vEstAlmacen='S';
			----update almacen.prodSeries set vEstAlmacen=2 where idProdSeries=@p_idSerie;
			--end
			--else
			--begin
			
  			select @iddetentr = coalesce(max(idDetSalidaProd),0)  +1 --right(replicate('0',10) + cast(isnull(max(idCotiz), 0) + 1  as varchar(10)),10)    
			from almacen.detSalidaProd;
			insert into almacen.detSalidaProd    
			(idDetSalidaProd, idSalidaProd , idProdSeries , vNroSerie,vEstado ,dFecReg,nStockSalida,dFecSalidaProducto)    
			values(	@iddetentr,@p_idsalidaprod, @p_idSerie,@p_Serie, 1,GETDATE(),@p_nstocksalida,@p_fecSalidaProducto);
			
			update almacen.prodSeries set vEstAlmacen=1 where vEstAlmacen='S';
 			update almacen.prodSeries set vEstAlmacen=2,vEstado=1 where idProdSeries=@p_idSerie;
 			
		--end 
  end

		
Select 'Agregado al detalle' as ok
end
