USE [dhlalmacen]
GO
CREATE proc [dbo].[add_dettecnicomat]   
@p_idDetTecnicoMat int,
@p_idsalidamat int,
@p_idTecnico int
as    
Declare 
@iddetentr varchar(20),
@can int,
@idmatanterior int
begin 
--select * from almacen.detTecnicoMat

if exists( select idDetTecnicoMat from almacen.detTecnicoMat where idDetTecnicoMat=@p_idDetTecnicoMat)
  begin	
		update almacen.detTecnicoMat  set  
			idSalidaMat =@p_idsalidamat
			,idTecnico= @p_idTecnico			
			,vEstado=1 
			,dFecReg=GETDATE()
		where idDetTecnicoMat=@p_idDetTecnicoMat;
		
  end
  else
  begin
		
  			select @iddetentr = coalesce(max(idDetTecnicoMat),0)  +1 --right(replicate('0',10) + cast(isnull(max(idCotiz), 0) + 1  as varchar(10)),10)    
			from almacen.detTecnicoMat;
			insert into almacen.detTecnicoMat    
			(idDetTecnicoMat, idSalidaMat , idTecnico ,vEstado ,dFecReg)    
			values(	@iddetentr,@p_idsalidamat, @p_idTecnico, 1,GETDATE());	
 			
  end
  		
Select 'Agregado al detalle' as ok
end
