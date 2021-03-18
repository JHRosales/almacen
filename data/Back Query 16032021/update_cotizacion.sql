USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [dbo].[update_cotizacion]    Script Date: 03/18/2021 15:27:03 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER proc [dbo].[update_cotizacion]   
@p_idcotiz integer,     
@p_subt numeric(10,2),     
@p_igv  numeric(10,2),     
@p_tot numeric(10,2),
@p_tipoMon integer,
@p_tasacam numeric(10,2),
@p_Clientetec char(1),
@p_tiemEntrega varchar(250),
@p_vgarantia varchar(250),
@p_vmotivo varchar(250),
@p_vformapago varchar(250),
@p_vreferencial varchar(250),
@p_disco varchar(250),
@p_tiempo varchar(250)
as    
Declare 
@vnrodcot varchar(20),
@ultimo int
begin    
 update  compras.cotizacion set nSubTot=@p_subt, nIgv=@p_igv,nTotal=@p_tot,
 nTipoMoneda=@p_tipoMon,
 nTasaCambio=case when @p_tasacam !='0' then @p_tasacam  else dbo.obttasacambio(dfecCot) end,vClienteTecnico=@p_Clientetec,
 tiempEntrega=@p_tiemEntrega ,vGarantia=@p_vgarantia,vMotivo=@p_vmotivo,vFormaPago=@p_vformapago,vNota=@p_vreferencial,vDisco=@p_disco,tiempo=@p_tiempo
  where idCotiz=@p_idcotiz;
  
  select @vnrodcot = vnroCot from compras.cotizacion where idCotiz=@p_idcotiz;
  if @vnrodcot='' or @vnrodcot is null 
  begin
    /* select @vnrodcot= cast(datepart(YEAR,getdate()) as varchar) +'-'+ right(replicate('0',4) + cast(MAX(nultgen)+1 as varchar),6) 
    from correlativo where cperiodo=datepart(YEAR,getdate()); 
    update  compras.cotizacion  
  set vnroCot = @vnrodcot
  where idCotiz = @p_idcotiz     
     update correlativo set nultgen=nultgen+1 where cperiodo=datepart(YEAR,getdate()); */
  
	   if exists( select top 1 cast(SUBSTRING(vnroCot,6,13)as int) ncotiz from compras.cotizacion where vnroCot is not null and vnroCot!=''
	  and SUBSTRING(vnroCot,1,4)= YEAR(GETDATE())
	  order by idCotiz desc )
		  begin
		  --Obtenemos el ultimo numero
			select top 1 @ultimo= cast(SUBSTRING(vnroCot,6,13)as int)  from compras.cotizacion where vnroCot is not null and vnroCot!=''
			and SUBSTRING(vnroCot,1,4)= YEAR(GETDATE())
			order by idCotiz desc;
		  
		  --Generamos el numero de cotiz y luego insertamos en la tabla
			select @vnrodcot= cast(datepart(YEAR,getdate()) as varchar) +'-'+ right(replicate('0',4) + cast(MAX(@ultimo)+1 as varchar),6) 
			from correlativo where cperiodo=datepart(YEAR,getdate()); 
			update  compras.cotizacion  
			set vnroCot = @vnrodcot
			where idCotiz = @p_idcotiz
		   
		  end 
		else
		  begin
		  --Generamos e insertamos el primer numero del año
			   select @vnrodcot= cast(datepart(YEAR,getdate()) as varchar) +'-'+ right(replicate('0',4) + cast(MAX(0)+1 as varchar),6) ;

				update  compras.cotizacion  
				set vnroCot = @vnrodcot
				where idCotiz = @p_idcotiz;
		  end  
  end


--|| Se Elimina los que fueron marcados para eliminarse (de 5)
  delete from compras.detCotizacion where idCotiz= @p_idcotiz and vEstado='5'
  
  --|| Cuando se pasa de Opcional a Principal se pone 3 temporalmente hasta que se graba y pasa a 1 (de 3 a 1)
 update compras.detCotizacion set vEstado=1  where idCotiz= @p_idcotiz and vEstado='3' --De Opcional temporal para a Principal

--|| Confirmar que se agrego otro registro
update compras.detCotizacion set vEstado=1 where idCotiz=@p_idcotiz and vEstado='2';
end
