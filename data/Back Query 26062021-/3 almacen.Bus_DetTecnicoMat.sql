USE dhlalmacen
GO
CREATE procedure almacen.Bus_DetTecnicoMat 
 @tBusqueda varchar(1)='0',  
 @vIdSalidaMat varchar(max),  
 @vDatoBus varchar(max)
  
as  
set dateformat dmy    
if (@tBusqueda='0') goto GENERAL  
if (@tBusqueda='1') goto ID  
  
GENERAL:  
begin  
  
 select  b.idDetTecnicoMat,b.idSalidaMat ,b.idTecnico, t.vNombre as NombreTecnico
 , b.vEstado
 from   
 almacen.detTecnicoMat b   
 INNER join tecnico t on b.idTecnico =t.idTecnico   
 where b.idSalidaMat = @vIdSalidaMat
  and b.vEstado=1 ;  
    
RETURN  
END  
  
ID:  
begin  
	  
	declare @nDatoBus int  
	select @nDatoBus=cast(@vDatoBus as int)  
	  
	select  b.idDetTecnicoMat,b.idSalidaMat ,b.idTecnico, t.vNombre as NombreTecnico
	 , b.vEstado
	 from   
	 almacen.detTecnicoMat b   
	 INNER join tecnico t on b.idTecnico =t.idTecnico  
	 where   
	 idDetTecnicoMat=@nDatoBus  
	 and b.idSalidaMat = @vIdSalidaMat
	  and b.vEstado=1 ;  
	RETURN  
END
