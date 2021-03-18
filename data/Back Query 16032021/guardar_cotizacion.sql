USE [dhlalmacen]
GO
/****** Object:  StoredProcedure [dbo].[guardar_cotizacion]    Script Date: 03/18/2021 15:24:33 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER proc [dbo].[guardar_cotizacion]    
@p_idcotiz char(10),     
@p_idclient int,     
@p_idpersonal int,     
@p_iduser varchar(50),     
@p_idhost varchar(50)  
as    
Declare 
@vnrodcot varchar(20)
begin    
 if exists(select * from compras.cotizacion where idCotiz = @p_idcotiz)    
 begin    
  update  compras.cotizacion  
  set dfecCot =  getdate(),     
   idCliente = @p_idclient,     
   idPersonal = @p_idpersonal,     
   vUsernm = @p_iduser,     
   vHostnm = @p_idhost,     
   dFecReg = getdate()  
  where idCotiz = @p_idcotiz    
 end    
 else    
 begin    
  select @p_idcotiz = coalesce(max(idCotiz),0)+1 --right(replicate('0',10) + cast(isnull(max(idCotiz), 0) + 1  as varchar(10)),10)    
  from compras.cotizacion;
   
   --select @vnrodcot= cast(datepart(YEAR,getdate()) as varchar) +'-'+ right(replicate('0',4) + cast(MAX(nultgen)+1 as varchar),6) 
    --from correlativo where cperiodo=datepart(YEAR,getdate()); 

  insert into compras.cotizacion    
  (idCotiz, vnroCot, dfecCot, idCliente, idPersonal, vUsernm, vHostnm, dFecReg,nTasaCambio,Estado)    
  values(    
  @p_idcotiz,'', getdate(),@p_idclient, @p_idpersonal, @p_iduser, @p_idhost, getdate(), dbo.obttasacambio(getdate()),'1'
  );    
   -- update correlativo set nultgen=nultgen+1 where cperiodo=datepart(YEAR,getdate()); 
 end    
    
 select idCotiz, vnroCot,CONVERT(VARCHAR(10),dfecCot,103) as dfecCot,nTasaCambio from compras.cotizacion where idCotiz = @p_idcotiz  
end

