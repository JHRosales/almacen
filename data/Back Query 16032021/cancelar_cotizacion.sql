USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [dbo].[cancelar_cotizacion]    Script Date: 03/18/2021 15:04:50 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER proc [dbo].[cancelar_cotizacion]    
@p_idcotiz char(10)  
as    
Declare 
@v_idncotiz varchar(20),
@v_vnrocot varchar(20),
@p_subt numeric(10,2),     
@p_igv  numeric(10,2),     
@p_tot numeric(10,2),
@estado char(2)
begin  

set @p_tot=0;
   --Restaurando los montos de la cotizacion
   	DECLARE JCUR_regresarTotal  
	CURSOR FOR select nPrecTotal,vEstado from compras.detCotizacion where idCotiz=@p_idcotiz and vEstado in ('5');
	
	OPEN JCUR_regresarTotal 
	FETCH NEXT FROM JCUR_regresarTotal INTO @p_tot,@estado

	WHILE @@fetch_status = 0
		BEGIN
		set @p_subt=@p_tot/1.18;
		set @p_igv=@p_tot-@p_subt;
		
		update compras.cotizacion set nSubTot=nSubTot+@p_subt , nIgv=nIgv+@p_igv, nTotal=nTotal+@p_tot where idCotiz=@p_idcotiz;
			/*if @estado='5' --5
			begin
				update compras.cotizacion set nSubTot=nSubTot+@p_subt , nIgv=nIgv+@p_igv, nTotal=nTotal+@p_tot where idCotiz=@p_idcotiz;
			end
			else --3
			begin
				update compras.cotizacion set nSubTot=nSubTot-@p_subt , nIgv=nIgv-@p_igv, nTotal=nTotal-@p_tot where idCotiz=@p_idcotiz;
			end*/
			
			set @p_tot=0;
			FETCH NEXT FROM JCUR_regresarTotal INTO @p_tot,@estado
		END
	CLOSE JCUR_regresarTotal
	DEALLOCATE JCUR_regresarTotal
	
  --Si se cancela la Cotizacion Regresa a Activo los eliminados Temporales
update compras.detCotizacion set vEstado=1 where idCotiz=@p_idcotiz and vEstado='5';
update compras.detCotizacion set vEstado=1, opcional=1 where idCotiz=@p_idcotiz and vEstado='3';
  
  --Eliminar los registros que fueron agregados recientemente y se cancela la cotizacion
  delete from  compras.detCotizacion where idCotiz=@p_idcotiz and vEstado='2'; --Revertir los agregados 
   
   --Si aun no se grababa la Cotizacion entonces elimina el registro
select @v_vnrocot=vnroCot from compras.cotizacion where idCotiz=@p_idcotiz;
if (@v_vnrocot='')
	begin
		delete from compras.detCotizacion where idCotiz=@p_idcotiz;
		delete from compras.cotizacion where idCotiz=@p_idcotiz;		
	end
select @v_idncotiz as idcotiz;
 end


