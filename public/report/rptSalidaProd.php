<?php
// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');
require_once("Connections/coneccionReporte.php");
require_once("Connections/funciones_pg.php");
include "lib_fecha_texto.php";
class PDF1 extends TCPDF
{



	function Header()
	{


		//datos SQL
		global $fecha;
		global $idsalida;
		global $vobra;
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
		$this->Image('../img/logo.jpg', $lw + 3, $ln, 42, 20, 'PNG');

		$lh = $lh + 9;
		$this->SetFont('times', '', 10);
		$this->SetXY($lw + 114, $lh);
		$this->MultiCell(70, 3, 'Telf.: 471 7304 / 997 149 778', 0, 'R');
		$this->SetXY($lw + 114, $lh + 4);
		$this->MultiCell(70, 3, 'Av. Santa Catalina 104 dpto. 201', 0, 'R');
		$this->SetXY($lw + 114, $lh + 8);
		$this->MultiCell(70, 3, '(Av. Canadá cdra. 8) La Victoria', 0, 'R');
		$this->SetXY($lw + 152, $lh + 12);
		$this->MultiCell(1, 3, $this->addHtmlLink("", 'ventas@dhlsecurity.pe'), 0, 'R');
		/*$this->SetXY($lw+120,$lh+12);
		$this->MultiCell(70,3,'ventas@dhlsecurity.pe',0,'R');*/
		$this->SetXY($lw + 114, $lh + 16);
		$this->MultiCell(70, 3, 'www.dhlsecurity.pe', 0, 'R');

		$lh = $lh + 20;

		/*
		$this->SetLineWidth(0);
		$this->SetFillColor(255);
		//$this->RoundedRect($lw-5, $lh, 110+$tamcabecera, 27, 1, '');  //Cuadro redondeado
		$this->SetFont('times', '', 10);
		$this->SetXY($lw,$lh+2);
		$this->MultiCell(100,5,"Lima ".fechaATexto($fecha),0,'L');
		$this->SetFont('times', 'B', 10);
		$this->SetXY($lw,$lh+6);
		$this->MultiCell(80,5,"Cotización: ".$vobra,0,'L');

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
		$this->MultiCell(190,5,"".$idsalida,0,'C');*/




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

	function WriteResumen($x, $h, $corte, $topmar)
	{
		//datos SQL

		// $x = $x+5;
		$x = 5;
		$h = $this->GetY() + 0.2;
		$x = $this->GetX() + 0.2;
		$this->SetFont('dejavusans', 'B', 8);
		$this->SetXY($x, $h);
		$this->MultiCell(55, 5, 'Tipo de Cambio: 3.30', 0, 'L');

		$this->SetFont('dejavusans', '', 8);
		$this->SetXY($x, $h + 6);
		$this->MultiCell(80, 5, 'Condiciones de la instalacion', 0, 'L');
		$this->SetXY($x, $h + 10);
		$this->MultiCell(150, 5, 'El cliente brindará las facilidades para la instalación, incluyendo los permisos necesarios.', 0, 'L');
		$this->SetXY($x, $h + 20);
		$this->MultiCell(180, 5, 'Condiciones Comerciales', 0, 'L');
		$this->SetXY($x, $h + 25);

		$this->MultiCell(180, 5, 'Tiempo de entrega: 3 dias hábiles', 0, 'L');
		$this->SetXY($x, $h + 30);

		$this->MultiCell(180, 5, 'Garantía: 12 meses por equipos y 12 meses por instalacionón y Disco Duro', 0, 'L');
		$this->SetXY($x, $h + 35);
		$this->MultiCell(180, 5, 'Forma de pago: Adelando del 50% del total y al finalizar el pago del 50& con la conformidad de la obra', 0, 'L');
		$this->SetXY($x, $h + 45);
		$this->MultiCell(180, 5, 'Cuenta corriente BCP Soles: 191-1964430-0-26', 0, 'L');
		$this->SetXY($x, $h + 50);
		$this->MultiCell(180, 5, 'Cuenta corriente BCP dólares: 191-2040241-1-04', 0, 'L');
		$this->SetXY($x, $h + 60);
		$this->MultiCell(180, 5, 'Atte.', 0, 'L');

		$this->SetXY($x, $h + 70);
		$this->MultiCell(180, 5, '---------------------------------', 0, 'L');
		$this->SetXY($x + 2, $h + 73);
		$this->MultiCell(80, 5, 'Daniel Huaraca Livias', 0, 'L');

		$this->SetXY($x, $h + 77);
		$this->MultiCell(60, 5, 'JEFE DE PROYECTOS DHL SYSTEM SECURITY EIRL', 0, 'L');
	}

	function strip_tags_content($text, $tags = '', $invert = FALSE)
	{

		preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
		$tags = array_unique($tags[1]);

		if (is_array($tags) and count($tags) > 0) {
			if ($invert == FALSE) {
				return preg_replace('@<(?!(?:' . implode('|', $tags) . ')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
			} else {
				return preg_replace('@<(' . implode('|', $tags) . ')\b.*?>.*?</\1>@si', '', $text);
			}
		} elseif ($invert == FALSE) {
			return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
		}
		return $text;
	}


	function WriteCabecera($x, $h, $corte, $topmar)
	{
		//datos SQL
		global $fecha;
		global $idsalida;
		global $vobra;
		global $cliente;
		global $lugar;


		$lh = $this->GetY() - 5;
		$lw = $this->GetX() - 5;

		$this->SetLineWidth(0);
		$this->SetFillColor(255);
		//$this->RoundedRect($lw-5, $lh, 110+$tamcabecera, 27, 1, '');  //Cuadro redondeado




		/* if(strlen(trim($vPersContac))>0){

            $this->SetFont('times', '', 10);
            $this->SetXY($lw,$lh+4);
            $this->MultiCell(100,5,"Lima ".fechaATexto($fecha),0,'L');
            $this->SetFont('times', '', 10);
            $this->SetXY($lw,$lh+9);
            $this->MultiCell(80,5,"Cotización: ",0,'L');
            $this->SetFont('times', 'B', 10);
            $this->SetXY($lw+17,$lh+9);
            $this->MultiCell(80,5,$vobra,0,'L');


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


            $this->SetFont('times', 'B', 11);
            $this->SetXY($lw,$lh+35);
            $this->MultiCell(190,5,"".$idsalida,0,'C');

            $this->SetFont('times', '', 10);
            $this->SetXY($lw,$lh+40);

       }else{*/

		$this->SetFont('times', '', 10);
		$this->SetXY($lw, $lh + 4);
		$this->MultiCell(100, 5, "Lima " . fechaATexto($fecha), 0, 'L');
		$this->SetFont('times', '', 10);
		$this->SetXY($lw, $lh + 10);
		$this->MultiCell(80, 5, "Obra: ", 0, 'L');
		$this->SetFont('times', 'B', 10);
		$this->SetXY($lw + 10, $lh + 10);
		$this->MultiCell(80, 5, $vobra, 0, 'L');


		$this->SetFont('times', '', 10);
		$this->SetXY($lw, $lh + 16);
		$this->MultiCell(80, 5, "Lugar: ", 0, 'L');
		$this->SetFont('times', 'B', 10);
		$this->SetXY($lw + 12, $lh + 16);
		$this->MultiCell(80, 5, $lugar, 0, 'L');

		$this->SetFont('times', '', 11);
		$this->SetXY($lw, $lh + 22);
		$this->MultiCell(80, 5, "Cliente: ", 0, 'J');

		$this->SetFont('times', 'B', 11);
		$this->SetXY($lw + 15, $lh + 22);
		$this->MultiCell(180, 5, $cliente, 0, 'L');

		$this->SetFont('times', 'B', 11);
		$this->SetXY($lw, $lh + 27);
		$this->MultiCell(190, 5, "Reporte Inversion de Productos", 0, 'C');

		$this->SetFont('times', '', 10);
		$this->SetXY($lw, $lh + 40);
		//}


	}
}




$idsalida = $_GET['idSalida'];

$Rs_tipoPer = new TSPResult($ConeccionRatania, "");
$Rs_tipoPer->Poner_MSQL("select  a.vobra,a.vlugar,m.idProducto,m.vNombre nProducto,ps.vNroSerie,c.idcliente,c.vnombre as client,
c.vtipodoc,c.vdireccion,CONVERT(VARCHAR(10),a.dFecSalida,103) as dFecSalida,
1 cantidad
,coalesce((  select MAX(nPrecioUnit) nPrecioUnit from(
			select top 1 de.nPrecioUnit  from almacen.detEntradaProd de
			inner join almacen.entradaProd ent on de.idEntradaProd=ent.idEntradaProd
			 where de.idProducto=m.idProducto
			 and cast(ent.dFecIngreso as date) <= cast(a.dFecSalida as date)
			 order by ent.dFecIngreso  desc
  )abc ),0) precUnit,

coalesce((  select MAX(nPrecioUnit) nPrecioUnit from(
			select top 1 de.nPrecioUnit  from almacen.detEntradaProd de
			inner join almacen.entradaProd ent on de.idEntradaProd=ent.idEntradaProd
			 where de.idProducto=m.idProducto
			 and cast(ent.dFecIngreso as date) <= cast(a.dFecSalida as date)
			 order by ent.dFecIngreso  desc
  )abc  ),0)  total
  ,(select nTotal from compras.cotizacion where idCotiz=a.idCotiz) cotizacionTotal, case m.idTipoMon when 1 then 'S/'
  when 2 then '$' else ''end tipomoneda
 from almacen.salidaProd a inner join
		almacen.detSalidaProd b on a.idSalidaProd=b.idSalidaProd
		inner join almacen.prodSeries ps on ps.idProdSeries=b.idProdSeries
		inner join producto m on ps.idProducto=m.idProducto
		left join cliente c on a.idCliente=c.idCliente
		inner join tecnico t on a.idTecnico=t.idTecnico
		where a.vEstado =1 and b.vEstado=1
		and a.idSalidaProd=$idsalida
		and b.idDetSalidaProd not in (
			  select detretp.idDetSalidaProd from almacen.RetornoProd retP
			  inner join almacen.detRetornoProd detretp on retP.idRetornoProd=detretp.idRetornoProd
			  where retP.idSalidaProd=$idsalida  and detretp.vEstado=1)");
//$Rs_tipoPer->pg_Poner_Esquema("public");

$Rs_tipoPer->executeMSQL();
$rowTipoP = $Rs_tipoPer->pg_Get_Row();

$vobra = $rowTipoP['vobra'];
$lugar = $rowTipoP['vlugar'];
$cliente = $rowTipoP['client'];
$fecha = $rowTipoP['dFecSalida'];
$vPersContac = $rowTipoP['vPersContac'];
$vTipoMoneda = $rowTipoP['tipomoneda'];
$vCotizacionTotal = $rowTipoP['cotizacionTotal'];


// create new PDF document
$pdf = new PDF1(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Jhimi Rosales');
$pdf->SetTitle('Cotización');
$pdf->SetSubject('Detalle de la cotización');
$pdf->SetKeywords('TCPDF, PDF, cotizacion, detalle cotizacion');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "", PDF_HEADER_STRING);


// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 35.4, PDF_MARGIN_RIGHT, true); //margenes left - top - right (15-27-15) (PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT)
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER); //Margen top 5
$pdf->SetFooterMargin(5); //margen bot 10 PDF_MARGIN_FOOTER
$pdf->setPrintFooter(false);

// set auto page breaks
$pdf->SetAutoPageBreak(true, 14);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
	require_once(dirname(__FILE__) . '/lang/eng.php');
	$pdf->setLanguageArray($l);
}
$colCab = array('10', '40', '10', '105', '18', '18');
// ---------------------------------------------------------
$topIni = 10;
$marIni = 10;


// add a page
$pdf->AddPage();
//Cabecera
$pdf->WriteCabecera($lw, 0, 0, 0);

// set font
$pdf->SetFont('dejavusans', '', 8);
$lw = 5;
$var1 = $pdf->GetY() - 6.2;
$pdf->SetXY($lw + 2.5, $lh = $var1);




$personal = $rowTipoP['personal'];
$cargo = $rowTipoP['cargo'];
$garantia = $rowTipoP['garantia'];
$tentrega = $rowTipoP['tentrega'];
$formapago = $rowTipoP['formapago'];
$referencial = $rowTipoP['vNota'];
$disco = $rowTipoP['vDisco'];
$tcambio = $rowTipoP['nTasaCambio'];
$msubtotal = $rowTipoP['nSubTot'];
$migv = $rowTipoP['nIgv'];


$html = '<table border="0.1"  cellmargin="1" cellpadding="3" style=" border-collapse: collapse;margin:0px;border:1px solid black; ">
<tr align="center" style="background-color: #ffda07; font-family: sans-serif">
<td width="30px"><b>ITEM</b></td><td width="142px"><b>Nro Serie</b></td><td width="35px"><b>CANT</b>
</td><td width="300px"><b>Producto</b></td><td width="55px"><b>TIpo Moneda</b></td><td width="63.5px"><b> PU </b></td><td width="64px"><b> PT</b></td>
</tr>';

$N = 0;
$numsaltos = 0;
$mtotal1 = 0;
$numRows = $Rs_tipoPer->pg_Num_Rows();
while ($N < $numRows) {

	$row = $Rs_tipoPer->pg_Get_Row();
	//echo $row['detalle'] . " - " . $row['vNombrePSM']. " - " . $row['img']  . "<br>";
	$det = $row['detalle'];
	$det = str_replace("<p>", '', $det);
	$det = str_replace("</p>", '', $det);

	$det = str_replace("<ul>", '', $det);
	$det = str_replace("</ul>", '', $det);
	$det = str_replace("<li>", ' &#x27A2;', $det);
	$det = str_replace("</li>", '', $det);
	$det = str_replace("-", '&#x27A2;', $det);
	//$det = str_replace("-",'<br>&#x27A2;',$det);
	$det = str_replace("*", '&#x27A2;', $det);
	//$det = iconv('utf-8', 'cp1252', $det);
	$det = utf8_encode($det);

	//$cantiletras= strip_tags_content($det);
	$cant = $row['cantidad'];
	$nMate = $row['nProducto'];
	$mtotal = $row['total'];
	$pu = $row['precUnit'];
	$nserie = $row['vNroSerie'];
	$mtotal1 = $mtotal1 + $mtotal;

	$modelo = $row['Modelo'];
	$pt = $row['nPrecTotal'];
	$img = $row['img'];

	$img = '';

	$tipops = $row['tipops'];
	if ($tipops == '2') {
	} else {
		$Nombre = $Nombre;
		$x = "";


		$html .= '
	<tr nobr="true" style="text-align: center; vertical-align: 10%">
	<td width="30px" >' . ($N + 1) . '</td>
	<td width="142px" style="font-size: 9px;" ><b>' . $nserie . '</b>' . '</td>
	<td width="35px">' . $cant . '</td>
	<td  align="left" width="300px">' . $nMate . '</td>
	<td width="55px" > ' . $vTipoMoneda . '</td>
	<td width="63.5px" >' . $pu . '</td>
	<td width="64px" >' . $mtotal . '</td>';

		$html .= '	</tr>';
	}


	$Rs_tipoPer->pg_Move_Next();
	$N++;
}
/*
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
</td></tr>*/
$html .= '


<tr>
	<td COLSPAN="6" align="right" style="font-family:  Times, serif; font-size: 10px" >
<b>TOTAL</b>
</td><td  align="center" style="font-family:sans-serif; font-size: 10px;">
<b><span style="color: red"> ' . $vTipoMoneda . ' ' . $mtotal1 . '</span></b>
</td></tr>';
$html .= '
</table>
';

//Cotizacion

$Rs_tipoPer->Poner_MSQL("select detcot.vDescrip,m.vModelo,detcot.nCantidad,case coti.nTipoMoneda when 1 then '$'
when 2 then 'S/' else ''end tipomoneda,nPrecUnit,nPrecTotal,coti.vnroCot
from almacen.salidaProd  a inner join
almacen.detSalidaProd b on a.idSalidaProd=b.idSalidaProd
inner join almacen.prodSeries ps on ps.idProdSeries=b.idProdSeries
inner join producto m on ps.idProducto=m.idProducto
inner join compras.cotizacion coti on a.idCotiz=coti.idCotiz
inner join compras.detCotizacion  detcot on coti.idCotiz=detcot.idCotiz and m.idProducto=detcot.idProdServ and detcot.tipoPS=1
where a.vEstado =1 and b.vEstado=1
and a.idSalidaProd=$idsalida");
$Rs_tipoPer->executeMSQL();
$rowTipoP = $Rs_tipoPer->pg_Get_Row();
$nroCotiz = $rowTipoP['vnroCot'];


$html .= '
<h3>Cotizacion Nro: ' . $nroCotiz . ' </h3>
';



$html .= '<table border="0.1"  cellmargin="1" cellpadding="3" style=" border-collapse: collapse;margin:0px;border:1px solid black; ">
<tr align="center" style="background-color: #ffda07; font-family: sans-serif">
<td width="100px"><b>Modelo</b></td><td width="300px"><b>MATERIAL</b></td><td width="55px"><b>CANT</b>
</td><td width="55px"><b>Tipo Moneda</b>
</td><td width="63.5px"><b> PU</b></td><td width="64px"><b> PT</b></td>
</tr>';

$N = 0;
$numsaltos = 0;
$mtotal2 = 0;
$numRows = $Rs_tipoPer->pg_Num_Rows();
while ($N < $numRows) {

	$row = $Rs_tipoPer->pg_Get_Row();
	$cant = $row['nCantidad'];
	$mtotal = $row['nPrecTotal'];
	$pu = $row['nPrecUnit'];
	$mtotal2 = $mtotal2 + $mtotal;

	$det = $row['vDescrip'];
	$det = str_replace("<p>", '', $det);
	$det = str_replace("</p>", '', $det);

	$det = str_replace("<ul>", '', $det);
	$det = str_replace("</ul>", '', $det);
	$det = str_replace("<li>", ' &#x27A2;', $det);
	$det = str_replace("</li>", '', $det);
	$det = str_replace("-", '&#x27A2;', $det);
	$det = str_replace("*", '&#x27A2;', $det);
	$nMate = utf8_encode($det);


	$modelo = $row['Modelo'];
	$pt = $row['nPrecTotal'];
	$ptipoMoneda = $row['tipomoneda'];
	$vModelo = $row['vModelo'];

	$x = "";

	$html .= '
	<tr nobr="true" style="text-align: center; vertical-align: 10%">
	<td width="100px" >' . $vModelo . '</td>
	<td  align="left" width="300px"><b>' . $nMate . '</b></td>
	<td width="55px">' . $cant . '</td>	
	<td width="55px">' . $ptipoMoneda . '</td>	
	<td width="63.5px" >' . $pu . '</td>
	<td width="64px" >' . $mtotal . '</td>';

	$html .= '	</tr>';


	$Rs_tipoPer->pg_Move_Next();
	$N++;
}

$html .= '
<tr>
	<td COLSPAN="5" align="right" style="font-family:  Times, serif; font-size: 10px" >
<b>TOTAL</b>
</td><td  align="center" style="font-family:sans-serif; font-size: 10px;">
<b><span style="color: red"> ' . $vTipoMoneda . ' ' . $mtotal2 . '</span></b>
</td></tr>';
$html .= '
</table>
';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

$lw = 5;
$var1 = $pdf->GetY() + -0.8;
$pdf->SetXY($lw + 2.5, $var1);

if ($tentrega > '1') {
	$msj = $tentrega . " días hábiles";
} elseif ($tentrega == ' ' or $tentrega == '0') {
	$msj = "Inmediata";
} else {
	$msj = $tentrega . " día hábil";
}


if ($disco == ' ' or $disco == '0') {
	$ms = "";
} else {

	$ms = 'Grabación aproximada del disco duro ' . $disco . ' días' . '<br>';
}



//$lw=0;
//$var1 = $pdf->GetY();
//$pdf->WriteResumen($lw,$var1, 0,0);

/*
$html = 'Simple text <span style="color: rgb(255,66,14);">Orange</span> simple  <span style="color: rgb(12,128,128);">Turquoise</span>';
$pdf->writeHTML($html, true, false, true, false, '');
 * */

function limpia_espacios($cadena)
{
	$cadena = str_replace(' ', '', $cadena);
	return $cadena;
}


$pdf->Output('COTIZACION ' . $idsalida . '_' . str_replace(' ', '   ', $idsalida) . '.pdf', 'I');



//============================================================+
// END OF FILE
//============================================================+
