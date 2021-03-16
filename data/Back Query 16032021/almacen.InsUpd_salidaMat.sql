USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[InsUpd_salidaMat]    Script Date: 03/16/2021 16:50:55 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER procedure [almacen].[InsUpd_salidaMat]
@ttrans varchar(1),
@p_idsalidamat int = 0,
@p_obra varchar(150)='',
@p_lugar varchar(150)='',
@p_fecha varchar(50)='',
@p_idtecnico int=0,
@p_idcliente int=0,
@p_idcotizacion int=0,
@p_obs varchar(500),
@vUsernm varchar(50)='',
@vHostnm varchar(50)=''

as
set dateformat 'dmy'   
if (@ttrans='1') goto INSERTAR
if (@ttrans='2') goto ACTUALIZAR

INSERTAR:
begin
if exists(select * from almacen.salidaMat  where idSalidaMat = @p_idsalidamat)    
 begin    
  update almacen.salidaMat  
  set     
	vObra=@p_obra,
	vLugar=@p_lugar,
	idTecnico=@p_idtecnico,
	idCliente=@p_idcliente,  
	idCotiz=@p_idcotizacion,   
	vUsernm = @vUsernm,     
	vHostnm = @vHostnm,     
	dFecReg = getdate()  
  where idSalidaMat = @p_idsalidamat    
 end    
 else    
 begin    
	declare @idmax int
	select @idmax=isnull(max(idSalidaMat),0)+1 from almacen.salidaMat

	insert into almacen.salidaMat
	(idSalidaMat,dFecSalida,vObra,vLugar,idCliente,vEstado,vUsernm,vHostnm,dFecReg,idTecnico,Observacion,idCotiz)
	values
	(@idmax,CAST (@p_fecha+' 00:00:00.000' AS datetime),@p_obra,@p_lugar,@p_idcliente,'1',@vUsernm,@vHostnm,GETDATE(),@p_idtecnico,@p_obs,@p_idcotizacion)
 end
 	--Insertando en SalidaActivos
		if not exists(select * from almacen.salidaActivos where idCotiz=@p_idcotizacion)
			begin
				--exec almacen.InsUpd_salidaActivos
				--			@ttrans='1',
				--			--@p_idsalidaActivos = 0,
				--			@p_obra=@p_obra,
				--			@p_lugar =@p_lugar,
				--			@p_fecha = @p_fecha,
				--			@p_idtecnico=@p_idtecnico,
				--			@p_idcliente=@p_idcliente,
				--			@p_idcotizacion=@p_idcotizacion,
				--			@p_obs =@p_obs,
				--			@vUsernm=@vUsernm,
				--			@vHostnm =@vHostnm	
					declare @idmax1 int
					select @idmax1=isnull(max(idSalidaActivo),0)+1 from almacen.salidaActivos

					insert into almacen.salidaActivos
					(idSalidaActivo,dFecSalida,vObra,vLugar,idCliente,vEstado,vUsernm,vHostnm,dFecReg,idTecnico,Observacion,idCotiz)
					values
					(@idmax1,CAST (@p_fecha+' 00:00:00.000' AS datetime),@p_obra,@p_lugar,@p_idcliente,'1',@vUsernm,@vHostnm,GETDATE(),@p_idtecnico,@p_obs,@p_idcotizacion)
				 		
			end
			
	select '1' as a, @idmax as idSalidaMat

return  
end

ACTUALIZAR:
begin


--||TABLA: DETRETORNOMAT.-Se restaura los eliminados y se suma el stock
Declare @idmat1 int,
	@cant1 int;
	DECLARE JCUR_regresarStock  
	CURSOR FOR select idmaterial,ncantidad from almacen.detRetornoMat  a
		inner join almacen.retornoMat b on a.idRetornoMat =b.idRetornoMat  where idSalidaMat= @p_idsalidamat and a.vEstado=0
	
	OPEN JCUR_regresarStock 
	FETCH NEXT FROM JCUR_regresarStock INTO @idmat1 ,@cant1

	WHILE @@fetch_status = 0
		BEGIN
			UPDATE material_almacen SET nStock=nStock+@cant1  where idMaterial=@idmat1
			
			FETCH NEXT FROM JCUR_regresarStock INTO @idmat1 ,@cant1
		END
	CLOSE JCUR_regresarStock
	DEALLOCATE JCUR_regresarStock
	
	update  almacen.detRetornoMat set  vEstado=1  where idRetornoMat in (
		select idRetornoMat from almacen.retornoMat   where idSalidaMat= @p_idsalidamat)  and vEstado=0
	

	--||TABLA: DETSALIDAMAT.-Se restaura los eliminados y se resta del stock
	Declare @idmat int,
	@cant int;
	DECLARE JCUR_regresarStock  
	CURSOR FOR select idmaterial,ncantidad from almacen.detSalidaMat  where idSalidaMat=@p_idsalidamat and vEstado=0
	
	OPEN JCUR_regresarStock 
	FETCH NEXT FROM JCUR_regresarStock INTO @idmat ,@cant

	WHILE @@fetch_status = 0
		BEGIN
			UPDATE material_almacen SET nStock=nStock-@cant  where idMaterial=@idmat
			
			FETCH NEXT FROM JCUR_regresarStock INTO @idmat ,@cant
		END
	CLOSE JCUR_regresarStock
	DEALLOCATE JCUR_regresarStock
	
	update almacen.detSalidaMat  set  vEstado=1 where idSalidaMat=@p_idsalidamat and  vEstado=0;
	
	--||Se actualiza cabecera de salidaMat 
	update almacen.salidaMat
	set
		dFecSalida=CAST (@p_fecha+' 00:00:00.000' AS datetime),
		vObra=@p_obra,
		vLugar=@p_lugar,
		idTecnico=@p_idtecnico,
		idCliente=@p_idcliente,
		vUsernm=@vUsernm,
		vHostnm=@vHostnm,
		dFecReg=GETDATE(),
		Observacion=@p_obs,
		idCotiz=@p_idcotizacion
	where
		idSalidaMat=@p_idsalidamat;	
		
		update almacen.salidaActivos
		set
			dFecSalida=CAST (@p_fecha+' 00:00:00.000' AS datetime),
			vObra=@p_obra,
			vLugar=@p_lugar,
			idCliente=@p_idcliente,
			dFecReg=GETDATE(),
			idTecnico=@p_idtecnico,
			Observacion=@p_obs		
			where idCotiz=@p_idcotizacion;			 		
		
		
	select @p_idsalidamat as idSalidaMat;
			

return
end
