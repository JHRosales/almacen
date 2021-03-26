USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[List_RetornoProd]    Script Date: 03/25/2021 22:53:44 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER procedure [almacen].[List_RetornoProd]
 @tBusqueda varchar(1)='0',
 @vDatoBus varchar(max),
 @vFecIni varchar(25) ,
 @vFecFin varchar(25) 

as

if (@tBusqueda='0') goto GENERAL
if (@tBusqueda='1') goto FECHASAL
if (@tBusqueda='2') goto FECHARET
if (@tBusqueda='3') goto ID

GENERAL:
begin

	select a.idRetornoProd, a.idSalidaProd,c.dFecSalida,dFecRetorno,a.vObra,a.vLugar, b.idTecnico, b.vNombre as vTecnico,a.vEstado
	, a.Observacion
	from almacen.retornoProd a
	left join tecnico b on a.idTecnico=b.idTecnico
	left join almacen.salidaProd c on a.idSalidaProd=c.idSalidaProd
	
RETURN
END
FECHASAL:
begin

declare @dFecSalIni datetime
declare @dFecSalFin datetime

SELECT @dFecSalIni=CAST (@vFecIni+' 00:00:00.000' AS datetime)
SELECT @dFecSalFin=CAST (@vFecFin+' 23:59:59.999' AS datetime)

	select a.idRetornoProd, a.idSalidaProd,c.dFecSalida,dFecRetorno,a.vObra,a.vLugar, b.idTecnico
	, b.vNombre as vTecnico,c.idCliente,d.vNombre as cliente,a.vEstado, a.Observacion
	from almacen.retornoProd a
	left join tecnico b on a.idTecnico=b.idTecnico
	left join almacen.salidaProd c on a.idSalidaProd=c.idSalidaProd
	left join cliente d on c.idCliente=d.idCliente
	where 
	dFecSalida between @dFecSalIni and @dFecSalFin

RETURN
END


FECHARET:
begin

declare @dFecRetIni datetime
declare @dFecRetFin datetime

SELECT @dFecRetIni=CAST (@vFecIni+' 00:00:00.000' AS datetime)
SELECT @dFecRetFin=CAST (@vFecFin+' 23:59:59.999' AS datetime)

	select a.idRetornoProd, a.idSalidaProd,c.dFecSalida,dFecRetorno,a.vObra,a.vLugar, b.idTecnico,
	 b.vNombre as vTecnico,c.idCliente,d.vNombre as cliente,a.vEstado, a.Observacion
	from almacen.retornoProd a
	left join tecnico b on a.idTecnico=b.idTecnico
	left join almacen.salidaProd c on a.idSalidaProd=c.idSalidaProd
	left join cliente d on c.idCliente=d.idCliente
	where 
	dFecRetorno between @dFecRetIni and @dFecRetFin

RETURN
end

ID:  
begin  
  
	select a.idRetornoProd, c.idSalidaProd,
	CONVERT(VARCHAR(10),c.dFecSalida,103) as dFecSalida , 
	case when dFecRetorno is null then CONVERT(VARCHAR(10),GETDATE(),103)  else CONVERT(VARCHAR(10),dFecRetorno,103)  end as dFecRetorno,
	c.vObra,c.vLugar, 
	b.idTecnico, b.vNombre as vTecnico,c.idCliente,d.vNombre as cliente,a.vEstado, a.Observacion
	from almacen.retornoProd a
	right join almacen.salidaProd c on a.idSalidaProd=c.idSalidaProd
	left join tecnico b on A.idTecnico=b.idTecnico
	left join cliente d on c.idCliente=d.idCliente
	 where   
	 c.idSalidaProd=   @vDatoBus;  

RETURN  
END
