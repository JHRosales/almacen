USE [dhlalmacen]
GO

CREATE proc almacen.salida_tecnicoMateliminar
@p_idtecnico integer,
@p_idDetTecnicomat integer
as    
Declare @idprod as Integer
Declare @cant as Integer
begin    

if @p_idDetTecnicomat>0
begin

--Eliminado temporal (5)
		update almacen.detTecnicoMat set vEstado=5 where idDetTecnicoMat=@p_idDetTecnicomat;

		 select 'ok' as rpta,'Correcto' as msg;

end 

end

