USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [almacen].[InsUpd_entradaProd]    Script Date: 03/18/2021 16:36:39 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER procedure [almacen].[InsUpd_entradaProd]
@ttrans varchar(1),
@idEntrada int = 0,
@idProveedor int=0,
@vFacturaComp varchar(100)='',
@p_igv numeric(10,2)=0,
@p_sub numeric(10,2)=0,
@nPrecioTotal numeric(10,2)=0,
@dFecIngreso varchar(25)=null,
@vEstado char(1)='',
@vUsernm varchar(50)='',
@vHostnm varchar(50)='',
@vTipoMon int=1
as
set dateformat 'dmy'   
if (@ttrans='1') goto INSERTAR
if (@ttrans='2') goto ACTUALIZAR

INSERTAR:
begin

 if exists(select * from almacen.entradaProd where idEntradaProd = @idEntrada)    
 begin    
  update almacen.entradaProd  
  set     
   idProveedor = @idProveedor,     
   vUsernm = @vUsernm,     
   vHostnm = @vHostnm,     
   dFecReg = getdate(),
   nTipoMoneda=@vTipoMon  
  where idEntradaProd = @idEntrada
  
  select @idEntrada as idEntrada    
 end    
 else    
 begin    
  	declare @idmax int
	select @idmax=isnull(max(idEntradaProd),0)+1 from almacen.entradaProd;


	insert into almacen.entradaProd 
	(idEntradaProd,idProveedor,vFacturaComp,dFecIngreso,vEstado,vUsernm,vHostnm,dFecReg,nTipoMoneda)
	values
	(@idmax,@idProveedor,@vFacturaComp,GETDATE(),'1',@vUsernm,@vHostnm,GETDATE(),@vTipoMon)  

select @idmax as idEntrada
 end  



return 
end

ACTUALIZAR:
begin


Declare @idprod int,
	@cant int;
	DECLARE JCUR_regresarStock  
	CURSOR FOR select idProducto ,nCantidad  from almacen.detEntradaProd where idEntradaProd =@idEntrada and vEstado=0
	
	OPEN JCUR_regresarStock 
	FETCH NEXT FROM JCUR_regresarStock INTO @idprod ,@cant

	WHILE @@fetch_status = 0
		BEGIN
			UPDATE producto SET nStock=nStock+@cant,
									cCompra=case when nStockMinimo>nStock+@cant 
													then 1 else 0 end
								  where idProducto =@idprod
			
			FETCH NEXT FROM JCUR_regresarStock INTO @idprod ,@cant
		END
	CLOSE JCUR_regresarStock
	DEALLOCATE JCUR_regresarStock
	

	update almacen.detEntradaProd set vEstado=1 where idEntradaProd=@idEntrada and  vEstado=0;
	update almacen.entradaProd set vEstado=1 where idEntradaProd=@idEntrada and  vEstado=0;
	update almacen.prodSeries set vEstado=1 where idDetEntradaProd in (select idDetEntradaProd from almacen.detEntradaProd where idEntradaProd=@idEntrada) and  vEstado=0;

		
		
	update almacen.entradaProd
	set
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
		nTipoMoneda=@vTipoMon
	where
		idEntradaProd=@idEntrada;
		
		select @idEntrada as idEntrada;
return
end
