USE [dhlalmacen]
GO

CREATE proc almacen.salida_tecnicosprodeliminar
@p_idtecnico integer,
@p_idDetTecnicoprod integer
as    
Declare @idprod as Integer
begin    
	if @p_idDetTecnicoprod>0
		begin
			--R : Retorno temporal
			--5 : Eliminado temporal
				update almacen.detTecnicoProd set vEstado=5 where idDetTecnicoProd=@p_idDetTecnicoprod;

				select 'ok' as rpta,'Correcto' as msg;
	
		end
 end

