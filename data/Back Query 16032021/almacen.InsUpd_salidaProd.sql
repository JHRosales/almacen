USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[InsUpd_salidaProd]    Script Date: 03/18/2021 16:38:34 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER procedure [almacen].[InsUpd_salidaProd]
@ttrans varchar(1),
@p_idsalidaprod int = 0,
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
	declare @idmax int
	select @idmax=isnull(max(idSalidaProd),0)+1 from almacen.salidaProd

	insert into almacen.salidaProd
	(idSalidaProd,dFecSalida,vObra,vLugar,idTecnico,vEstado,vUsernm,vHostnm,dFecReg,idCliente,Observacion,idCotiz)
	values
	(@idmax,CAST (@p_fecha+' 00:00:00.000' AS datetime),@p_obra,@p_lugar,@p_idtecnico,'1',
	@vUsernm,@vHostnm,GETDATE(),@p_idcliente,@p_obs,@p_idcotizacion)

	select '1' as a, @idmax as idSalidaprod

return 
end

ACTUALIZAR:
begin
	--||TABLA: DETSALIDAPROD.-Se restaura los eliminados y se resta del stock
	/*Declare @idmat int,
	@idprodser int;
	
	DECLARE JCUR_regresarStock  
	CURSOR FOR select p.idProducto ,a.idProdSeries from almacen.detSalidaProd a inner join almacen.prodSeries  p
	on a.idProdSeries =p.idProdSeries where a.idSalidaProd =@p_idsalidaprod and a.vEstado=0 and p.vEstado <>4
	
	OPEN JCUR_regresarStock 
	FETCH NEXT FROM JCUR_regresarStock INTO @idmat ,@idprodser

	WHILE @@fetch_status = 0
		BEGIN
			UPDATE producto  SET nStock=nStock-1  where idProducto =@idmat
			update  almacen.prodSeries set vEstAlmacen=2 where idProdSeries =@idprodser
			FETCH NEXT FROM JCUR_regresarStock INTO @idmat ,@idprodser
		END
	CLOSE JCUR_regresarStock
	DEALLOCATE JCUR_regresarStock
	
	update almacen.detSalidaProd set  vEstado=1 where idSalidaProd=@p_idsalidaprod and  vEstado=0;
	
	--||TABLA: DETRETORNOPROD.-Se restaura los eliminados y se suma el stock
Declare @idprods1 int
Declare	@cant1 int;
	DECLARE JCUR_regresarStock  
	CURSOR FOR select idProdSeries ,1 ncantidad from almacen.detRetornoProd  a
		inner join almacen.retornoProd b on a.idRetornoProd =b.idRetornoProd  where idSalidaProd= @p_idsalidaprod and a.vEstado=0
	
	OPEN JCUR_regresarStock 
	FETCH NEXT FROM JCUR_regresarStock INTO @idprods1 ,@cant1

	WHILE @@fetch_status = 0
		BEGIN
			UPDATE producto  SET nStock=nStock+@cant1  where idProducto in  (select idProducto from almacen.prodSeries where idProdSeries = @idprods1 );
			update almacen.prodSeries set vEstAlmacen = 1 where idProdSeries = @idprods1
			
			FETCH NEXT FROM JCUR_regresarStock INTO @idprods1 ,@cant1
		END
	CLOSE JCUR_regresarStock
	DEALLOCATE JCUR_regresarStock*/
	
	Declare @idDetSalida int,
	@idprodser int;
	Declare @tipoM as Varchar(2);
	DECLARE JCUR_regresarStock  
	CURSOR FOR select 'S',idDetSalidaProd ,a.idProdSeries 
				from almacen.detSalidaProd a 
				inner join almacen.prodSeries  p on a.idProdSeries =p.idProdSeries 
				where a.idSalidaProd =@p_idsalidaprod and a.vEstado=0 and p.vEstado <>4
				union all
				select 'R',idDetSalidaProd ,idProdSeries
				from almacen.detRetornoProd  a
				inner join almacen.retornoProd b on a.idRetornoProd =b.idRetornoProd  
				where idSalidaProd=@p_idsalidaprod and a.vEstado=0
				order by 2 asc,1 desc
	
	OPEN JCUR_regresarStock 
	FETCH NEXT FROM JCUR_regresarStock INTO @tipoM,@idDetSalida ,@idprodser

	WHILE @@fetch_status = 0
		BEGIN
		if (@tipoM='S')
		begin
			UPDATE producto  SET nStock=nStock-1,
									cCompra=case when nStockMinimo>nStock-1
													then 1 else 0 end
								  where idProducto in  (select idProducto from almacen.prodSeries where idProdSeries = @idprodser );
			update  almacen.prodSeries set vEstAlmacen=2 where idProdSeries =@idprodser
			end
		else
			begin	
			UPDATE producto  SET nStock=nStock+1,
									cCompra=case when nStockMinimo>nStock+1
													then 1 else 0 end
								  where idProducto in  (select idProducto from almacen.prodSeries where idProdSeries = @idprodser );
			update almacen.prodSeries set vEstAlmacen = 1 where idProdSeries = @idprodser
			end
			
			FETCH NEXT FROM JCUR_regresarStock INTO @tipoM,@idDetSalida ,@idprodser
		END
	CLOSE JCUR_regresarStock
	DEALLOCATE JCUR_regresarStock


update almacen.detSalidaProd set  vEstado=1 where idSalidaProd=@p_idsalidaprod and  vEstado=0;
	
	update  almacen.detRetornoProd set  vEstado=1  where idRetornoProd in (
		select idRetornoprod from almacen.retornoProd   where idSalidaProd= @p_idsalidaprod)  and vEstado=0
	update  almacen.retornoProd set  vEstado=1  where idSalidaProd= @p_idsalidaprod  and vEstado=0
	

	--||Tabla almacen.salidaProd
	update almacen.salidaProd
	set
		--dFecSalida=CAST (@p_fecha+' 00:00:00.000' AS datetime),
		vObra=@p_obra,
		vLugar=@p_lugar,
		idTecnico=@p_idtecnico,
		vUsernm=@vUsernm,
		vHostnm=@vHostnm,
		dFecReg=GETDATE(),
		idCliente=@p_idcliente,
		Observacion=@p_obs,
		idCotiz=@p_idcotizacion
	where
		idSalidaProd=@p_idsalidaprod;
		
		select @p_idsalidaprod as idSalidaprod;
return
end
