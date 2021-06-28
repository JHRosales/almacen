USE dhlalmacen
GO
CREATE procedure almacen.Bus_DetTecnicoProd 
 @tBusqueda varchar(1)='0',  
 @vIdSalidaProd varchar(max),  
 @vDatoBus varchar(max)
  
as  
set dateformat dmy    
if (@tBusqueda='0') goto GENERAL  
if (@tBusqueda='1') goto ID  
  
GENERAL:  
begin  
  
 select  b.idDetTecnicoProd,b.idSalidaProd,b.idTecnico, t.vNombre as NombreTecnico
 , b.vEstado
 from   
 almacen.detTecnicoProd b   
 INNER join tecnico t on b.idTecnico =t.idTecnico   
 where b.idSalidaProd = @vIdSalidaProd
  and b.vEstado=1 ;  
    
RETURN  
END  
  
ID:  
begin  
	  
	declare @nDatoBus int  
	select @nDatoBus=cast(@vDatoBus as int)  	  
	
		select  b.idDetTecnicoProd,b.idSalidaProd,b.idTecnico, t.vNombre as NombreTecnico
		, b.vEstado
		from   
		almacen.detTecnicoProd b   
		INNER join tecnico t on b.idTecnico =t.idTecnico   
		where   
		 idDetTecnicoProd=@nDatoBus  
		 and b.idSalidaProd = @vIdSalidaProd
		  and b.vEstado=1 ;  
		RETURN  
END
