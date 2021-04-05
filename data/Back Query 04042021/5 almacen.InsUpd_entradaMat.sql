USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[InsUpd_entradaMat]    Script Date: 04/04/2021 19:27:31 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER procedure [almacen].[InsUpd_entradaMat]
@ttrans varchar(1),
@idEntrada int = 0,
@idServicio int=0,
@idProveedor int=0,
@vFacturaComp varchar(100)='',
@p_igv numeric(10,2)=0,
@p_sub numeric(10,2)=0,
@nPrecioTotal numeric(10,2)=0,
@dFecIngreso varchar(25)=null,
@vEstado char(1)='',
@vUsernm varchar(50)='',
@vHostnm varchar(50)='',
@vTipomon int=1

as
set dateformat 'dmy'   
if (@ttrans='1') goto INSERTAR
if (@ttrans='2') goto ACTUALIZAR

INSERTAR:
begin
if exists(select * from almacen.entradaMat where idEntradaMat = @idEntrada)    
 begin    
  update almacen.entradaMat  
  set     
   idProveedor = @idProveedor,     
   vUsernm = @vUsernm,     
   vHostnm = @vHostnm,     
   dFecReg = getdate(),
   nTipoMoneda=@vTipomon  
  where idEntradaMat = @idEntrada    
  
  select @idEntrada as idEntrada
 end    
 else    
 begin    
	declare @idmax int
	select @idmax=isnull(max(idEntradaMat),0)+1 from almacen.entradaMat

	insert into almacen.entradaMat
	(idEntradaMat,idServicio,idProveedor,vFacturaComp,nPrecioTotal,dFecIngreso,vEstado,vUsernm,vHostnm,dFecReg,nTipoMoneda)
	values
	(@idmax,@idServicio,@idProveedor,@vFacturaComp,@nPrecioTotal,GETDATE(),'1',@vUsernm,@vHostnm,GETDATE(),@vTipomon)
   
   select @idmax as idEntrada

 end

	

return 
end

ACTUALIZAR:
begin


	Declare @idmat int,
	@cant int;
	DECLARE JCUR_regresarStock  
	CURSOR FOR select idmaterial,ncantidad from almacen.detEntradaMat where idEntradaMat=@idEntrada and vEstado=0
	
	OPEN JCUR_regresarStock 
	FETCH NEXT FROM JCUR_regresarStock INTO @idmat ,@cant

	WHILE @@fetch_status = 0
		BEGIN
			UPDATE material_almacen SET nStock=nStock+@cant, 
				cCompra=case when nStockMinimo>=nStock+@cant then 1 else 0 end 
				where idMaterial=@idmat
			
			FETCH NEXT FROM JCUR_regresarStock INTO @idmat ,@cant
		END
	CLOSE JCUR_regresarStock
	DEALLOCATE JCUR_regresarStock
	
	update almacen.detEntradaMat set  vEstado=1 where idEntradaMat=@idEntrada and  vEstado=0;
	
	
	update almacen.entradaMat
	set
		idServicio=@idServicio,
		--idProveedor=@idProveedor,
		vFacturaComp=@vFacturaComp,
		nSubtotal=@p_sub,
		nIgv=@p_igv,
		nPrecioTotal=@nPrecioTotal,
		dFecIngreso=CAST (@dFecIngreso+' 00:00:00.000' AS datetime),
		vEstado=@vEstado,
		vUsernm=@vUsernm,
		vHostnm=@vHostnm,
		dFecReg=GETDATE(),
		nTipoMoneda=@vTipomon
	where
		idEntradaMat=@idEntrada;
		
		select @idEntrada as idEntrada;
return
end
