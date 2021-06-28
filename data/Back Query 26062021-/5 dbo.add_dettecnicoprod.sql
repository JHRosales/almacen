USE [dhlalmacen]
GO
CREATE proc dbo.add_dettecnicoprod  
@p_idDetTecnicoProd int,
@p_idsalidaprod int,
@p_idTecnico int
as    
Declare 
@iddetentr varchar(20),
@can int,
@idmatanterior int
begin 
--select * from almacen.detTecnicoProd

if exists( select idDetTecnicoProd from almacen.detTecnicoProd where idDetTecnicoProd=@p_idDetTecnicoProd)
  begin	
		update almacen.detTecnicoProd  set  
			idSalidaProd =@p_idsalidaprod
			,idTecnico= @p_idTecnico			
			,vEstado=1 
			,dFecReg=GETDATE()
		where idDetTecnicoProd=@p_idDetTecnicoProd;
		
  end
  else
  begin
		
  			select @iddetentr = coalesce(max(idDetTecnicoProd),0)  +1 --right(replicate('0',10) + cast(isnull(max(idCotiz), 0) + 1  as varchar(10)),10)    
			from almacen.detTecnicoProd;
			insert into almacen.detTecnicoProd    
			(idDetTecnicoProd, idSalidaProd , idTecnico ,vEstado ,dFecReg)    
			values(	@iddetentr,@p_idsalidaprod, @p_idTecnico, 1,GETDATE());	
 			
  end
  		
Select 'Agregado al detalle' as ok
end
