<?php
// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');
require_once("Connections/coneccionReporte.php");
require_once("Connections/funciones_pg.php");
include "lib_fecha_texto.php";
class PDF1 extends TCPDF{



	function Header(){


		//datos SQL
		global $fecha;
		global $motivo;
		global $nroCotiz;
		global $cliente;
		global $vPersContac;

		global $topIni;
		global $marIni;
		global $nombreContrib;
		global $colCab;

		$lw = $marIni;
		$ln = $topIni;
		$ls = 3;
		$lh = 0;
		$this->Image('../img/logo.jpg',$lw+3,$ln,42,20,'PNG');

		$lh = $lh+9;
		$this->SetFont('times', '', 10);
		$this->SetXY($lw+114,$lh);
		$this->MultiCell(70,3,'Telf.: 471 7304 / 997 149 778',0,'R');
		$this->SetXY($lw+114,$lh+4);
		$this->MultiCell(70,3,'Av. Santa Catalina 104 dpto. 201',0,'R');
		$this->SetXY($lw+114,$lh+8);
		$this->MultiCell(70,3,'(Av. Canadá cdra. 8) La Victoria',0,'R');
		$this->SetXY($lw+152,$lh+12);
		$this->MultiCell(1,3,$this->addHtmlLink("",'ventas@dhlsecurity.pe'),0,'R');
		/*$this->SetXY($lw+120,$lh+12);
		$this->MultiCell(70,3,'ventas@dhlsecurity.pe',0,'R');*/
		$this->SetXY($lw+114,$lh+16);
		$this->MultiCell(70,3,'www.dhlsecurity.pe',0,'R');

        $this->SetXY($lw+114,$lh+20);
        $this->MultiCell(70,3,'RUC: 20548115354',0,'R');

		$lh = $lh+20;

/*
		$this->SetLineWidth(0);
		$this->SetFillColor(255);
		//$this->RoundedRect($lw-5, $lh, 110+$tamcabecera, 27, 1, '');  //Cuadro redondeado
		$this->SetFont('times', '', 10);
		$this->SetXY($lw,$lh+2);
		$this->MultiCell(100,5,"Lima ".fechaATexto($fecha),0,'L');
		$this->SetFont('times', 'B', 10);
		$this->SetXY($lw,$lh+6);
		$this->MultiCell(80,5,"Cotización: ".$nroCotiz,0,'L');

		if(strlen(trim($vPersContac))>0){
			$this->SetXY($lw,$lh+10);
			$this->MultiCell(80,5,"Señores: ".$cliente,0,'L');
			$this->SetXY($lw,$lh+14);
			$this->MultiCell(80,5,"Atención: ".$vPersContac,0,'L');
		}else{
			$this->SetXY($lw,$lh+10);
			$this->MultiCell(80,5,"Señor(a): ".$cliente,0,'L');
		}


		$this->SetFont('times', 'B', 11);
		$this->SetXY($lw,$lh+18);
		$this->MultiCell(80,5,"Presente:",0,'J');
		$this->SetXY($lw,$lh+22);
		$this->MultiCell(190,5,"".$motivo,0,'C');*/




	/*	$lh = $lh +30;  //Inicio del detalle

		$this->SetFillColor(255, 195, 0);
		$ls=-5;
		$this->SetFont('times', 'B', 9);
		$this->SetXY($lw+$ls,$lh);
		$this->Cell($colCab[0],5,"",1,1,'L',true);
		$this->SetXY($lw+$ls,$lh+1);
		$this->MultiCell($colCab[0],3,'ITEM',0,'C');

		$ls=5;
		$this->SetFont('times', 'B', 9);
		$this->SetXY($lw+$ls,$lh);
		$this->Cell($colCab[1],5,"",1,1,'L',true);
		$this->SetXY($lw+$ls,$lh+1);
		$this->MultiCell($colCab[1],3,'CÓDIGO',0,'C');


		$ls = 45;
		$this->SetFont('times', 'B', 9);
		$this->SetXY($lw+$ls,$lh);
		$this->Cell($colCab[2]+1,5,"",1,1,'L',true);
		$this->SetXY($lw+$ls,$lh+1);
		$this->MultiCell($colCab[2]+1,3,'CANT.',0,'C');


		$ls = 56;
		$this->SetFont('times', 'B', 9);
		$this->SetXY($lw+$ls,$lh);
		$this->Cell($colCab[3],5,"",1,1,'L',true);
		$this->SetXY($lw+$ls,$lh+1);
		$this->MultiCell($colCab[3],3,'DESCRIPCIÓN',0,'C');

		$ls = 160;
		$this->SetFont('times', 'B', 9);
		$this->SetXY($lw+$ls,$lh);
		$this->Cell($colCab[4],5,"",1,1,'L',true);
		$this->SetXY($lw+$ls,$lh+1);
		$this->MultiCell($colCab[4],3,'P.U',0,'C');

		$ls = 178;
		$this->SetFont('times', 'B', 9);
		$this->SetXY($lw+$ls,$lh);
		$this->Cell($colCab[5],5,"",1,1,'L',true);
		$this->SetXY($lw+$ls,$lh+1);
		$this->MultiCell($colCab[5],3,'P.T',0,'C');
*/

	}

	 function WriteResumen($x,$h, $corte,$topmar){
		//datos SQL

		// $x = $x+5;
		 $x =5;
		 $h = $this->GetY()+0.2;
		 $x = $this->GetX()+0.2;
		 $this->SetFont('dejavusans','B',8);
		$this->SetXY($x,$h);
		$this->MultiCell(55,5,'Tipo de Cambio: 3.30',0,'L');

		$this->SetFont('dejavusans','',8);
		$this->SetXY($x,$h+6);
		$this->MultiCell(80,5,'Condiciones de la instalacion',0,'L');
		$this->SetXY($x,$h+10);
		$this->MultiCell(150,5,'El cliente brindará las facilidades para la instalación, incluyendo los permisos necesarios.',0,'L');
		$this->SetXY($x,$h+20);
		$this->MultiCell(180,5,'Condiciones Comerciales',0,'L');
		$this->SetXY($x,$h+25);

		$this->MultiCell(180,5,'Tiempo de entrega: 3 dias hábiles',0,'L');
		$this->SetXY($x,$h+30);

		$this->MultiCell(180,5,'Garantía: 12 meses por equipos y 12 meses por instalacionón y Disco Duro',0,'L');
		$this->SetXY($x,$h+35);
		$this->MultiCell(180,5,'Forma de pago: Adelando del 50% del total y al finalizar el pago del 50& con la conformidad de la obra',0,'L');
		$this->SetXY($x,$h+45);
		$this->MultiCell(180,5,'Cuenta corriente BCP Soles: 191-1964430-0-26',0,'L');
		$this->SetXY($x,$h+50);
		$this->MultiCell(180,5,'Cuenta corriente BCP dólares: 191-2040241-1-04',0,'L');
		$this->SetXY($x,$h+60);
		$this->MultiCell(180,5,'Atte.',0,'L');

		$this->SetXY($x,$h+70);
		$this->MultiCell(180,5,'---------------------------------',0,'L');
		$this->SetXY($x+2,$h+73);
		$this->MultiCell(80,5,'Daniel Huaraca Livias',0,'L');

		$this->SetXY($x,$h+77);
		$this->MultiCell(60,5,'JEFE DE PROYECTOS DHL SYSTEM SECURITY EIRL',0,'L');
	}

	function strip_tags_content($text, $tags = '', $invert = FALSE) {

		preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
		$tags = array_unique($tags[1]);

		if(is_array($tags) AND count($tags) > 0) {
			if($invert == FALSE) {
				return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
			}
			else {
				return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
			}
		}
		elseif($invert == FALSE) {
			return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
		}
		return $text;
	}


	function WriteCabecera($x,$h, $corte,$topmar){
//datos SQL
		global $fecha;
		global $motivo;
		global $nroCotiz;
		global $cliente;
		global $vPersContac;


        $lh = $this->GetY()-5;
        $lw = $this->GetX()-5;

        $this->SetLineWidth(0);
        $this->SetFillColor(255);
        //$this->RoundedRect($lw-5, $lh, 110+$tamcabecera, 27, 1, '');  //Cuadro redondeado




        if(strlen(trim($vPersContac))>0){

            $this->SetFont('times', '', 10);
            $this->SetXY($lw,$lh+4);
            $this->MultiCell(100,5,"Lima ".fechaATexto($fecha),0,'L');
            $this->SetFont('times', '', 10);
            $this->SetXY($lw,$lh+9);
            $this->MultiCell(80,5,"Cotización: ",0,'L');
            $this->SetFont('times', 'B', 10);
            $this->SetXY($lw+17,$lh+9);
            $this->MultiCell(80,5,$nroCotiz,0,'L');


            $this->SetFont('times', '', 10);
            $this->SetXY($lw,$lh+14);
            $this->MultiCell(80,5,"Señores: ",0,'L');
            $this->SetFont('times', 'B', 10);
            $this->SetXY($lw+13,$lh+14);
            $this->MultiCell(80,5,$cliente,0,'L');

            $this->SetFont('times', '', 10);
            $this->SetXY($lw,$lh+19);
            $this->MultiCell(80,5,"Atención: ",0,'L');
            $this->SetFont('times', 'B', 10);
            $this->SetXY($lw+15,$lh+19);
            $this->MultiCell(80,5,$vPersContac,0,'L');

            $this->SetFont('times', '', 11);
            $this->SetXY($lw,$lh+24);
            $this->MultiCell(80,5,"Presente.-",0,'J');

            $this->SetFont('times', '', 11);
            $this->SetXY($lw,$lh+29);
            $this->MultiCell(100,5,"Por medio de la presente le enviamos la cotización solicitada",0,'J');


            $this->SetFont('times', 'B', 11);
            $this->SetXY($lw,$lh+35);
            $this->MultiCell(190,5,"".$motivo,0,'C');

            $this->SetFont('times', '', 10);
            $this->SetXY($lw,$lh+40);

        }else{

            $this->SetFont('times', '', 10);
            $this->SetXY($lw,$lh+4);
            $this->MultiCell(100,5,"Lima ".fechaATexto($fecha),0,'L');
            $this->SetFont('times', '', 10);
            $this->SetXY($lw,$lh+10);
            $this->MultiCell(80,5,"Cotización: ",0,'L');
            $this->SetFont('times', 'B', 10);
            $this->SetXY($lw+17,$lh+10);
            $this->MultiCell(80,5,$nroCotiz,0,'L');


            $this->SetFont('times', '', 10);
            $this->SetXY($lw,$lh+16);
            $this->MultiCell(80,5,"Señor(a): ",0,'L');
            $this->SetFont('times', 'B', 10);
            $this->SetXY($lw+14,$lh+16);
            $this->MultiCell(90,5,$cliente,0,'L');

            $this->SetFont('times', '', 11);
            $this->SetXY($lw,$lh+22);
            $this->MultiCell(80,5,"Presente.-",0,'J');

            $this->SetFont('times', '', 11);
            $this->SetXY($lw,$lh+27);
            $this->MultiCell(100,5,"Por medio de la presente le enviamos la cotización solicitada.",0,'J');

            $this->SetFont('times', 'B', 11);
            $this->SetXY($lw,$lh+34);
            $this->MultiCell(190,5,"".$motivo,0,'C');

            $this->SetFont('times', '', 10);
            $this->SetXY($lw,$lh+40);
        }


    }
}




$idcotiz = $_GET['idCotiz'];

$Rs_tipoPer = new TSPResult($ConeccionRatania,"");
$Rs_tipoPer->Poner_MSQL("select a.idCotiz, a.vnroCot,CONVERT(VARCHAR(10),a.dfecCot,103) as dfecCot,
CONVERT(varchar, convert(money, nSubTot), 1)as nSubTot
,CONVERT(varchar, convert(money, a.nIgv), 1) as nIgv
,CONVERT(varchar, convert(money, nTotal), 1) as nTotal,b.vNombrePSM ,
 --Case when SUBSTRING(b.vNombrePSM,0,9)='Materiales' then 'GLOBAL' else CAST(sum(b.nPrecUnit)AS varchar(10))  end
 Case when b.tipoPS!='1' then 'GLOBAL' else CONVERT(varchar, convert(money, sum(b.nPrecUnit)), 1)  end
 as nPrecUnit,Case when b.tipoPS!='1' then '-'
 else CAST(b.nCantidad AS varchar(5))  end nCantidad,CONVERT(varchar, convert(money, sum(b.nPrecTotal)), 1)
  as nPrecTotal ,c.idCliente,c.vNombre as cliente , Case when b.tipoPS!='1' then '1.jpg'
 else  dbo.imgadjunto(b.idProdServ)   end as img,
  Case when b.tipoPS!='1' then ''
 else  dbo.ModeloProd(b.idProdServ)   end as Modelo,b.idprodserv,
 coalesce(a.tiempEntrega,'') as tentrega , coalesce(a.vGarantia,'') as garantia,
 p.vNombre as personal,  p.vCargo as cargo,a.nTasaCambio,
  a.vNota ,a.vDisco ,a.tiempo,a.vFormaPago
  /*case when dbo.tieneServ(a.idCotiz)='1' then 'Adelanto del 50% del total y al finalizar el pago del 50% con la conformidad de la Obra.' else 'Al contado' end*/ as formapago
   ,
   case when b.tipoPS!='1' then REPLACE(dbo.detalleservicio(a.idCotiz,b.vNombrePSM,b.idprodserv),CHAR(10),'<br>') else
   dbo.detalleservicio(a.idCotiz,b.vNombrePSM,b.idprodserv) end as detalle,b.tipops, a.vMotivo,c.vPersContac,
   case when a.nTipoMoneda='1' then '$' else 'S/.' end tipomoneda,Case when b.tipoPS!='1' then '0'
 else  dbo.Subcat(b.idProdServ)   end as subcat
  from compras.cotizacion
a left join compras.detCotizacion b on a.idCotiz =b.idCotiz
inner join cliente c on a.idCliente=c.idCliente
left join personal p on a.idPersonal=p.idPersonal
where a.idCotiz=$idcotiz
and (opcional is null or opcional='' or opcional='0' )
group by  a.idCotiz,a.vnroCot,a.dfecCot,a.nSubTot,a.nIgv,a.nTotal,b.vNombrePSM,b.nCantidad,c.idCliente,
c.vNombre,idProdServ,tipoPS, a.tiempEntrega , a.vGarantia,p.vNombre,p.vCargo, a.nTasaCambio,b.tipops, a.vMotivo,c.vPersContac,a.nTipoMoneda,a.vFormaPago,a.vNota,a.vDisco,a.tiempo
order by tipoPS,subcat,b.vNombrePSM desc");
//$Rs_tipoPer->pg_Poner_Esquema("public");

$Rs_tipoPer->executeMSQL();
$rowTipoP= $Rs_tipoPer->pg_Get_Row();

$nroCotiz = $rowTipoP['vnroCot'];
$motivo = $rowTipoP['vMotivo'];
$motivo = str_replace("&ntilde;",'ñ',$motivo);
$motivo = str_replace("&Ntilde;",'Ñ',$motivo);



$motivo = str_replace("&aacute;",'á',$motivo);
$motivo = str_replace("&eacute;",'é',$motivo);
$motivo = str_replace("&iacute;",'í',$motivo);
$motivo = str_replace("&oacute;",'ó',$motivo);
$motivo = str_replace("&uacute;",'ú',$motivo);
$motivo = str_replace("&Aacute;",'Á',$motivo);
$motivo = str_replace("&Eacute;",'É',$motivo);
$motivo = str_replace("&Iacute;",'Í',$motivo);
$motivo = str_replace("&Oacute;",'Ó',$motivo);
$motivo = str_replace("&Uacute;",'Ú',$motivo);

$cliente = $rowTipoP['cliente'];
$cliente = str_replace("&ntilde;",'ñ',$cliente);
$cliente = str_replace("&Ntilde;",'Ñ',$cliente);
$cliente = str_replace("&aacute;",'á',$cliente);
$cliente = str_replace("&eacute;",'é',$cliente);
$cliente = str_replace("&iacute;",'í',$cliente);
$cliente = str_replace("&oacute;",'ó',$cliente);
$cliente = str_replace("&uacute;",'ú',$cliente);
$cliente = str_replace("&Aacute;",'Á',$cliente);
$cliente = str_replace("&Eacute;",'É',$cliente);
$cliente = str_replace("&Iacute;",'Í',$cliente);
$cliente = str_replace("&Oacute;",'Ó',$cliente);
$cliente = str_replace("&Uacute;",'Ú',$cliente);

$fecha = $rowTipoP['dfecCot'];
$vPersContac = $rowTipoP['vPersContac'];
$vTipoMoneda = $rowTipoP['tipomoneda'];



//preguntando si tiene opcional
$Rs_tieneOpcio = new TSPResult($ConeccionRatania,"");
$Rs_tieneOpcio->Poner_MSQL("select count(*) cant
  from  compras.detCotizacion
where idCotiz=$idcotiz
and  opcional='1'");
$Rs_tieneOpcio->executeMSQL();
$rowTieneopcio= $Rs_tieneOpcio->pg_Get_Row();
$tieneOpcional=$rowTieneopcio["cant"];

// create new PDF document
$pdf = new PDF1(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Jhimi Rosales');
$pdf->SetTitle('Cotización');
$pdf->SetSubject('Detalle de la cotización');
$pdf->SetKeywords('TCPDF, PDF, cotizacion, detalle cotizacion');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH,"", PDF_HEADER_STRING);


// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 35.4, PDF_MARGIN_RIGHT,true); //margenes left - top - right (15-27-15) (PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT)
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER); //Margen top 5
$pdf->SetFooterMargin(5); //margen bot 10 PDF_MARGIN_FOOTER
$pdf->setPrintFooter(false);

// set auto page breaks
$pdf->SetAutoPageBreak(true, 14);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}
$colCab = array('10','40','10','105','18','18');
// ---------------------------------------------------------
$topIni = 10;
$marIni = 10;


// add a page
$pdf->AddPage();
//Cabecera
$pdf->WriteCabecera($lw,0, 0,0);

// set font
$pdf->SetFont('dejavusans', '', 8);
$lw=5;
$var1 = $pdf->GetY()+2.2;
$pdf->SetXY($lw+2.5,$lh = $var1);




$personal = $rowTipoP['personal'];
$cargo = $rowTipoP['cargo'];
$garantia = $rowTipoP['garantia'];
$tentrega = $rowTipoP['tentrega'];
$formapago = $rowTipoP['formapago'];
$referencial= $rowTipoP['vNota'];
$disco= $rowTipoP['vDisco'];
$tcambio = $rowTipoP['nTasaCambio'];
$mtotal = $rowTipoP['nTotal'];
$msubtotal = $rowTipoP['nSubTot'];
$migv = $rowTipoP['nIgv'];
$periodo = $rowTipoP['tiempo'];


$html= '<table border="0.1"  cellmargin="1" cellpadding="3" style=" border-collapse: collapse;margin:0px;border:1px solid black; ">
<tr align="center" style="background-color: #ffda07; font-family: sans-serif">
<td width="30px"><b>ITEM</b></td><td width="142px"><b>CÓDIGO</b></td><td width="35px"><b>CANT</b>
</td><td width="355px"><b>DESCRIPCIÓN</b></td><td width="63.5px"><b> PU '.$vTipoMoneda.'</b></td><td width="64px"><b> PT '.$vTipoMoneda.'</b></td>
</tr>';

$N = 0;
$numsaltos=0;
$numRows = $Rs_tipoPer->pg_Num_Rows();
while($N < $numRows) {

	$row = $Rs_tipoPer->pg_Get_Row();
	//echo $row['detalle'] . " - " . $row['vNombrePSM']. " - " . $row['img']  . "<br>";
	$det = $row['detalle'];
	$det = str_replace("<p>",'',$det);
	$det = str_replace("</p>",'<br>',$det);

	$det = str_replace("<ul>",'',$det);
	$det = str_replace("</ul>",'',$det);
	$det = str_replace("<li>",' &#x27A2;',$det);
	$det = str_replace("</li>",'<br>',$det);
	$det = str_replace("-",'&#x27A2;',$det);
    //$det = str_replace("-",'<br>&#x27A2;',$det);
	$det = str_replace("*",'&#x27A2;',$det);
	//$det = iconv('utf-8', 'cp1252', $det);
	$det = utf8_encode($det);

	//$cantiletras= strip_tags_content($det);
	$cant= $row['nCantidad'];
	$Nombre= $row['vNombrePSM'];
	$modelo= $row['Modelo'];
	$pu= $row['nPrecUnit'];
	$pt= $row['nPrecTotal'];
	$img= $row['img'];
	if($img=='1.jpg'){
		$img='';
	}else{
		$img='<img src="../uploadDdocuments/'.$img.'" border="0" align="top" />';
	}
	$tipops= $row['tipops'];
if($tipops=='2'){
    $saltos=substr_count($det, '<br>');
    /*if($saltos>1){
        $saltos=5;
    }else{
        $saltos=2;
    }*/




	$modelo=str_repeat('<br>',$saltos-2).$Nombre;
	$Nombre='';
    $det=$det.'<br>';


	/*$cantiletras= strlen(html_entity_decode($det)); //saber cuantas letras tiene
	$numlineas=$cantiletras/70;
		$numsaltos = $numlineas+1;*/

    $x='<b>'.'Condiciones de la instalación: '.'</b>'.'<br>'.'El cliente brindará las facilidades para la instalación, incluyendo los permisos necesarios.'.'<br>'.'<br>';


    $html .= '
	<tr nobr="true" style="text-align: center; vertical-align: 10%">
	<td width="30px" >'.str_repeat('<br>',$saltos).($N+1).'</td>
	<td width="142px" style="font-size: 9px;" ><b><br>'.$modelo.'</b><br>'.$img.'</td>
	<td width="35px">'.str_repeat('<br>',$saltos).$cant.'</td>
	<td  align="left" width="355px"><b>'.$Nombre.'</b>'.
        $det.'
</td>
	<td width="63.5px" >'.str_repeat('<br>',$saltos).$pu.'</td>
	<td width="64px" >'.str_repeat('<br>',$saltos).' '.$pt.'</td>';

    $html .= '	</tr>';

	}else{

	$Nombre='<br>'.$Nombre.'<br>';

	/*$cantiletras= strlen(html_entity_decode($det)); //saber cuantas letras tiene, pero no es exacto ya que no considera los saltos de linea
	 $numlineas=$cantiletras/70;
	if($numlineas>3){
		$numsaltos=round($numlineas+1,0);
	}else{
		$numsaltos=4;
	}
	.str_repeat('<br>',$numsaltos)  //Linea que se pone antes de los datos donde repite os saltos de liena para centrar el texto
	*/

    $x="";

    $Nombre=	str_replace("<p>",'',$Nombre);
    $Nombre = str_replace("</p>",'',$Nombre);

    $html .= '
	<tr nobr="true" style="text-align: center; vertical-align: 10%">
	<td width="30px" >'.str_repeat('<br>',5).($N+1).'</td>
	<td width="142px" style="font-size: 9px;" ><b><br>'.$modelo.'</b><br>'.$img.'</td>
	<td width="35px">'.str_repeat('<br>',5).$cant.'</td>
	<td  align="left" width="355px"><b>'.$Nombre.'</b>'.
        $det.'
</td>
	<td width="63.5px" >'.str_repeat('<br>',5).' '.$pu.'</td>
	<td width="64px" >'.str_repeat('<br>',5).' '.$pt.'</td>';

    $html .= '	</tr>';
}
	$Nombre=	str_replace("<p>",'',$Nombre);
	$Nombre = str_replace("</p>",'',$Nombre);

	/*  $html .= '
	<tr nobr="true" style="text-align: center; vertical-align: 10%">
	<td width="30px" >'.str_repeat('<br>',5).($N+1).'</td>
	<td width="142px" style="font-size: 9px;" ><b><br>'.$modelo.'</b><br>'.$img.'</td>
	<td width="35px">'.str_repeat('<br>',5).$cant.'</td>
	<td  align="left" width="355px"><b>'.$Nombre.'</b>'.
		$det.'
</td>
	<td width="63.5px" >'.str_repeat('<br>',5).$vTipoMoneda.' '.$pu.'</td>
	<td width="64px" >'.str_repeat('<br>',5).$vTipoMoneda.' '.$pt.'</td>';

	$html .= '	</tr>';  */


	//$pdf->MultiCell(185,6,$pdf->writeHTML($html, true, false, true, false, ''),0,'J');
	//$var1 = $pdf->GetY();

	$Rs_tipoPer->pg_Move_Next();
	$N ++;
}
$html .= '
<tr >
	<td COLSPAN="5" align="right" style="font-family:  Times, serif; font-size: 10px;" >
<b >SUB-TOTAL</b>
</td><td  align="center" style="font-family:sans-serif; font-size: 10px;">
<b>'.$vTipoMoneda.' '.$msubtotal.'</b>
</td></tr>

<tr>
	<td COLSPAN="5" align="right" style="font-family:  Times, serif; font-size: 10px" >
<b>IGV</b>
</td><td  align="center" style="font-family:sans-serif; font-size: 10px;">
<b>'.$vTipoMoneda.' '.$migv.'</b>
</td></tr>

<tr>
	<td COLSPAN="5" align="right" style="font-family:  Times, serif; font-size: 10px" >
<b>TOTAL</b>
</td><td  align="center" style="font-family:sans-serif; font-size: 10px;">
<b><span style="color: red"> '.$vTipoMoneda.' '.$mtotal.'</span></b>
</td></tr>';
$html .= '
</table>
';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

$lw=5;
$var1 = $pdf->GetY()+-0.8;
$pdf->SetXY($lw+2.5,$var1);

if($tieneOpcional>0){
//OPCIONAL
$Rs_opcional = new TSPResult($ConeccionRatania,"");
$Rs_opcional->Poner_MSQL("select a.idCotiz,b.vNombrePSM,
 --sum(b.nPrecUnit) as nPrecUnit,
 --Case when SUBSTRING(b.vNombrePSM,0,9)='Materiales' then '-' else CAST(b.nCantidad AS varchar(5))  end nCantidad,sum(b.nPrecTotal)  as nPrecTotal ,
   Case when b.tipoPS!='1' then 'GLOBAL' else CAST(sum(b.nPrecUnit)AS varchar(10))  end as nPrecUnit,
   Case when b.tipoPS!='1' then '-' else CAST(b.nCantidad AS varchar(5))  end nCantidad,cast(sum(b.nPrecTotal)as numeric(12,2))
  as nPrecTotal,

  Case when b.tipoPS!='1' then '1.jpg'
 else  dbo.imgadjunto(b.idProdServ)   end as img,
  Case when b.tipoPS!='1' then ''
 else  dbo.ModeloProd(b.idProdServ)   end as Modelo,b.idprodserv
  ,dbo.detalleservicio_opcional(a.idCotiz,b.vNombrePSM,b.idprodserv) as detalle,b.tipops,

  case when b.tipoPS!='1' then REPLACE(dbo.detalleservicio_opcional(a.idCotiz,b.vNombrePSM,b.idprodserv),CHAR(10),'<br>') else
   dbo.detalleservicio_opcional(a.idCotiz,b.vNombrePSM,b.idprodserv) end as detalle

  from compras.cotizacion
a left join compras.detCotizacion b on a.idCotiz =b.idCotiz
inner join cliente c on a.idCliente=c.idCliente
left join personal p on a.idPersonal=p.idPersonal
where a.idCotiz=$idcotiz
and opcional='1'
group by  a.idCotiz,a.nSubTot,a.nTotal,b.vNombrePSM,b.nCantidad,idProdServ,tipoPS, p.vNombre
order by tipoPS,b.idProdServ,nCantidad");
$Rs_opcional->executeMSQL();
$rowopcional= $Rs_opcional->pg_Get_Row();

	$var1 = $pdf->GetY();
$htmlOpcional= '<table border="0.1"  cellmargin="1" cellpadding="3" style=" border-collapse: collapse;margin:0px;border:1px solid black;">
<tr>
<td width="690px"><span style="color: red">
OPCIONAL:</span>
</td>
</tr>';
$N = 0;
$totalop=0.00;
$numRows = $Rs_opcional->pg_Num_Rows();
    while($N < $numRows) {

        $row = $Rs_opcional->pg_Get_Row();
        $det = $row['detalle'];
        $det = str_replace("<p>",'',$det);
        $det = str_replace("</p>",'<br>',$det);

        $det = str_replace("<ul>",'',$det);
        $det = str_replace("</ul>",'',$det);
        $det = str_replace("<li>",' &#x27A2;',$det);
        $det = str_replace("</li>",'<br>',$det);

        $det = str_replace("*",'&#x27A2;',$det);

        $det = utf8_encode($det);

        $cant= $row['nCantidad'];
        $Nombre= $row['vNombrePSM'];
        $modelo= $row['Modelo'];
        $pu= $row['nPrecUnit'];
        $pt= $row['nPrecTotal'];
        $img= $row['img'];
        $totalop=$totalop+$row['nPrecTotal'];
        if($img=='1.jpg'){
            $img='';
        }else{
            $img='<img src="../uploadDdocuments/'.$img.'" border="0" align="top" />';
        }
        $tipops= $row['tipops'];
        if($tipops=='2'){
            $saltos=substr_count($det, '<br>');
            /*if($saltos>1){
                $saltos=5;
            }else{
                $saltos=2;
            }*/

            $modelo=str_repeat('<br>',$saltos-2).$Nombre;
            $Nombre='';
            $det=$det.'<br>';
        }else{
            $Nombre='<br>'.$Nombre.'<br>';
        }

        $Nombre=	str_replace("<p>",'',$Nombre);
        $Nombre = str_replace("</p>",'',$Nombre);
        $htmlOpcional .= '
	<tr nobr="true">
	<td width="30px" align="center" >'.str_repeat('<br>',$saltos).($N+1).'</td>

	<td width="142px" align="center" ><b><br>'.$modelo.'</b> <BR>'.$img.'</td>

	<td width="35px" align="center" style="vertical-align: middle">'.str_repeat('<br>',$saltos).$cant.'</td>

	<td  align="left" width="355px"><b>'.$Nombre.'</b>'.
            $det.'
</td>
	<td width="63.5px" align="center" style="text-align:center;vertical-align:middle">'.str_repeat('<br>',$saltos).$vTipoMoneda.' '.$pu.'</td>
	<td width="64px" align="center" valign="middle">'.str_repeat('<br>',$saltos).$vTipoMoneda.' '.$pt.'</td>';
        $htmlOpcional .= '	</tr>';
        $Rs_opcional->pg_Move_Next();
        $N ++;
    }
  $htmlOpcional .= '<tr>
	<td COLSPAN="5" align="right" style="font-family:  Times, serif; font-size: 10px" >
<b>TOTAL OPCIONAL INCLUIDO IGV</b>
</td><td  align="center" style="font-family:sans-serif; font-size: 11px;">
<b><span style="color: red"> '.$vTipoMoneda.' '.number_format($totalop, 2, '.', ',').'</span></b>
</td></tr>';
$htmlOpcional .= '
</table>
';

$pdf->writeHTML($htmlOpcional, true, false, true, false, '');
}



if ($tentrega > '1' and $periodo=='Habil' ) {
    $msj= $tentrega." días ".$periodo."es";

}

else if($tentrega > '1' and $periodo=='Calendario' ) {
    $msj= $tentrega." días ".$periodo."s";

}

elseif ($tentrega == ' ' or $tentrega == '0') {
    $msj= "Inmediata";
}


else {
    $msj= $tentrega." día ".$periodo;
}


if($disco == ' ' or $disco == '0' ){
    $ms="";
}

else{

    $ms='Grabación aproximada del disco duro '.$disco.' días'.'<br>';
}

if($vTipoMoneda == '$' ){
    $g ='Tipo de Cambio: '.$tcambio.'
    <br>';

}


if($disco == ' ' or $disco == '0' ){
    $ms="";
}

else{

    $ms='Grabación aproximada del disco duro '.$disco.' días'.'<br>';
}

if($vTipoMoneda == '$' ){
    $g ='Tipo de Cambio: '.$tcambio.'
    <br>';

}



//Resumen
$htmlresumen .= '<table border="0">
<tr><td>

<b>Nota: </b> <span style="color: red">'.$referencial.'</span>
<br>
'.$ms.'


'.$g.'
<br>
'.$x.'

<b>Condiciones Comerciales:</b>
<br>
Tiempo de entrega: '.$msj.'
<br>
Garantía:   '.$garantia.' meses
<br>
Forma de pago: '.$formapago.'
<br><br>
Cuenta corriente BCP Soles: 191-1964430-0-26
<br>
Cuenta corriente BCP dólares: 191-2040241-1-04
<br>
Cuenta corriente BBVA Soles: 0011-0131-0100049557
<br>
<br>
Atte.
<br><br>

<b> '.$personal.'</b><br>
'.$cargo.'

<br>


</td>
</tr>



</table>
';
$pdf->writeHTML($htmlresumen, true, false, true, false, '');


//$lw=0;
//$var1 = $pdf->GetY();
//$pdf->WriteResumen($lw,$var1, 0,0);

/*
$html = 'Simple text <span style="color: rgb(255,66,14);">Orange</span> simple  <span style="color: rgb(12,128,128);">Turquoise</span>';
$pdf->writeHTML($html, true, false, true, false, '');
 * */

function limpia_espacios($cadena){
    $cadena = str_replace(' ', '', $cadena);
    return $cadena;
}


$pdf->Output('COTIZACION '.$nroCotiz.'_'.str_replace(' ', '   ', $motivo).'.pdf', 'I');



//============================================================+
// END OF FILE
//============================================================+

