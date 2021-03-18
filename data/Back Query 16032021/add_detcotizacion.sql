USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [dbo].[add_detcotizacion]    Script Date: 03/18/2021 14:44:24 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER proc [dbo].[add_detcotizacion]   
@p_idcotiz int,     
@p_id int,     
@p_nombre varchar(250),     
@p_descri varchar(max),     
@p_pu numeric(10,2),
@p_tipo char(1),
@p_opcional char(1),
@p_tipom char(1)=0,
@p_tasa numeric(5,2)=0.0
    
as    
Declare 
@iddetcot varchar(20)
begin    
if @p_tasa=0 
begin
set @p_tasa=0.001;
end


  if @p_tipo='2'
  begin
		select  @iddetcot = coalesce(max(idDetCotiz),0)  +1 --right(replicate('0',10) + cast(isnull(max(idCotiz), 0) + 1  as varchar(10)),10)    
		from compras.detCotizacion;
		insert into compras.detCotizacion    
		(idDetCotiz, idCotiz, nOrden, vNombrePSM, vDescrip, nPrecUnit, nCantidad, nPrecTotal,vEstado,idProdServ,tipoPS,opcional)    
		/*values(    
		@iddetcot,@p_idcotiz, 1,@p_nombre, @p_descri, @p_pu, 1, @p_pu,1,@p_id,@p_tipo,@p_opcional
		);*/
		select @iddetcot,@p_idcotiz,1,vNombre,vDescrip,@p_pu, 1, @p_pu,1,@p_id,@p_tipo,@p_opcional from servicio
		where idServicio=@p_id;
		

		 insert into compras.detCotizacion    
		(idDetCotiz, idCotiz, nOrden, vNombrePSM, vDescrip, nPrecUnit, nCantidad, nPrecTotal,vEstado,idProdServ,tipoPS,opcional,idMaterial,idServPadre )   
		
		select @iddetcot +ROW_NUMBER() over (order by a.idMaterial asc),@p_idcotiz,ROW_NUMBER() over (order by a.idMaterial asc),'MATERIALES' ,b.vNombre,
		case when b.idtipoMon=@p_tipom then coalesce(nCosto,0)
		when b.idtipoMon=2 then  coalesce(nCosto,0)/@p_tasa else coalesce(nCosto,0)*@p_tasa end
		,1,
		case when b.idtipoMon=@p_tipom then coalesce(nCosto,0)
		when b.idtipoMon=2 then  coalesce(nCosto,0)/@p_tasa else coalesce(nCosto,0)*@p_tasa end,
		2,@p_id,@p_tipo,@p_opcional,b.idMaterial,@iddetcot 
		from servMaterial a
		inner  join material b on a.idMaterial=b.idMaterial
		where a.idServicio=@p_id
		
  end  
  else
  begin
		select  @iddetcot = coalesce(max(idDetCotiz),0)  +1 --right(replicate('0',10) + cast(isnull(max(idCotiz), 0) + 1  as varchar(10)),10)    
		from compras.detCotizacion;
		insert into compras.detCotizacion    
		(idDetCotiz, idCotiz, nOrden, vNombrePSM, vDescrip, nPrecUnit, nCantidad, nPrecTotal,vEstado,idProdServ,tipoPS,opcional)    
		
		/*values(    
		@iddetcot,@p_idcotiz, 1,@p_nombre, @p_descri, @p_pu, 1, @p_pu,1,@p_id,@p_tipo,@p_opcional
		);*/
		select @iddetcot,@p_idcotiz,1,a.vNombre,a.vDescrip,
		case when a.idTipoMon=@p_tipom then nCosto 
		when a.idTipoMon=1 and @p_tipom=2 then coalesce(nCosto,0)*@p_tasa
		when a.idTipoMon=2 and @p_tipom=1 then  coalesce(nCosto,0)/@p_tasa else 0 end PrecioUnt,
		1,
		case when a.idTipoMon=@p_tipom then nCosto 
		when a.idTipoMon=1 and @p_tipom=2 then coalesce(nCosto,0)*@p_tasa
		when a.idTipoMon=2 and @p_tipom=1 then  coalesce(nCosto,0)/@p_tasa else 0 end total,
		2,@p_id,@p_tipo,@p_opcional from producto a
		where a.idProducto=@p_id
	
  end  
 select 'ok' as ok;
end
