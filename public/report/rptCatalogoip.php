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



		$lh = $lh+20;

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
		$this->MultiCell(150,5,'El cliente brindara las facilidades para la instalaion, incluyendo los permisos necesarios.',0,'L');
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
        global $topIni;
        global $marIni;
        global $nombreContrib;
        global $colCab;

        $lh = $this->GetY()-30;
        $lw = $this->GetX();

        $this->SetLineWidth(0);
        $this->SetFillColor(255);
        //$this->RoundedRect($lw-5, $lh, 110+$tamcabecera, 27, 1, '');  //Cuadro redondeado
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
        $this->SetXY($lw+150,$lh+12);
        $this->MultiCell(70,3,$this->addHtmlLink("",'ventas@dhlsecurity.pe'),0,'R');
        /*$this->SetXY($lw+120,$lh+12);
        $this->MultiCell(70,3,'ventas@dhlsecurity.pe',0,'R');*/
        $this->SetXY($lw+114,$lh+16);
        $this->MultiCell(70,3,'www.dhlsecurity.pe',0,'R');
        $this->SetFont('times', 'B', 12);
        $this->SetXY($lw,$lh+20);
        $this->MultiCell(170,3,'LISTA DE PRECIOS IP',0,'C');
        $this->SetXY($lw+122,$lh+28);
        $this->MultiCell(70,3,'Valido desde ENERO 2018',1,'C');

    }
}




$idcotiz = $_GET['idCotiz'];

$Rs_tipoPer = new TSPResult($ConeccionRatania,"");
$Rs_tipoPer->Poner_MSQL("
      select
  idProducto,b.orden,a.vNombre,vMarca,vModelo,a.vResolucion,vCapacidad,vTecnologia,
vDescrip,nCosto,nStock,a.vEstado, Case when iadjunto='' then '1.jpg'
 else  iadjunto   end as img,b.vNombre + ' '+Case when vTecnologia='Todas' then ''
 else vTecnologia    end + ' - '+a.vResolucion as subcateria,isnull(c.norden,0)


 from producto a

 inner join subCategoria b on a.idSubCat=b.idSubCat
 left join vw_orden_resol c on a.vResolucion= c.vresolucion
 where
	(vTecnologia in('IP','IP WIFI')and 	vMarca='Dahua')
	OR (b.vnombre = 'Monitores / Tv' and vmarca='Dahua')
	OR (b.vnombre = 'Disco Duro' and vmarca='Western Digital')
	OR (b.vnombre = 'Video Tester' and 	vModelo <> 'DH-PFM905')

	 OR (b.vnombre like '%Arreglo de Discos%')
 order by b.orden asc,vTecnologia DESC,isnull(c.norden,0) asc");

$Rs_tipoPer->executeMSQL();
$rowTipoP= $Rs_tipoPer->pg_Get_Row();


// create new PDF document
$pdf = new PDF1(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('JR');
$pdf->SetTitle('Catalogo');
$pdf->SetSubject('Lista de Productos');
$pdf->SetKeywords('TCPDF, PDF, catalogo, detalle catalogo');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH,"", PDF_HEADER_STRING);


// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 10.4, PDF_MARGIN_RIGHT,true); //margenes left - top - right (15-27-15) (PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT)
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
//$var1 = $pdf->GetY()+2.2;
$var1 = $pdf->GetY();
$pdf->SetXY($lw+2.5,$lh = $var1);

$kit =  utf8_encode($rowTipoP['subcateria']);
$html= '<table border="1"  cellmargin="1" cellpadding="3" style=" border-collapse: collapse;margin:0px;border:1px solid black; "width="689.5px" >
<tr  align="center" style="background-color: #525659; font-family: sans-serif;color:#FFFFFF;font-size: 14px"><th><b>'.strtoupper($kit).'</b></th></tr>
<tr align="center" style="background-color: #FFDD00; font-family: sans-serif;color:#000000">
<td width="30px"><b>ITEM</b></td>
<td width="142px"><b>MODELO</b></td>
<td width="120px"><b>IMAGEN</b></td>
<td width="337.5px"><b>DESCRIPCIÓN</b></td>
<td width="60px"><b>PRECIO $</b></td>
</tr>
';

$N = 0;
$numRows = $Rs_tipoPer->pg_Num_Rows();
while($N < $numRows) {

    $row = $Rs_tipoPer->pg_Get_Row();
    //echo $row['detalle'] . " - " . $row['vNombrePSM']. " - " . $row['img']  . "<br>";
    /*$det = $row['vDescrip'];*/

    $vDescrip = $row['vDescrip'];

    $vDescrip = str_replace("<p>",'<br>',$vDescrip);
    $vDescrip = str_replace("</p>",'<br>',$vDescrip);

    $vDescrip = str_replace("<ul>",'',$vDescrip);
    $det = str_replace("</ul>",'',$det);
    $det = str_replace("<li>",' &#x27A2;',$det);
    $det = str_replace("</li>",'<br>',$det);
    $det = str_replace("-",'&#x27A2;',$det);
    //$det = str_replace("-",'<br>&#x27A2;',$det);
    $det = str_replace("*",'&#x27A2;',$det);
    //$det = iconv('utf-8', 'cp1252', $det);
    $vDescrip = utf8_encode($vDescrip);

    $kit1 = utf8_encode($row['subcateria']);
    $idprod = $row['idProducto'];
    $idsubcat = $row['idSubCat'];
    $vnombre = $row['vNombre'];
    $marca = $row['vMarca'];
    $vmodelo = $row['vModelo'];
    $resolucio = $row['vResolucion'];
    $vcapcidad = $row['vCapacidad'];
    $vTecnologo = $row['vTecnologia'];
    $Costo = $row['nCosto'];
    $stock = $row['nStock'];
    $estado = $row['vEstado'];
    $vTipoMoneda="$";

    $img= $row['img'];
    if($img=='1.jpg'){
        $img='';
    }else{
        $img='<img src="../uploadDdocuments/'.$img.'" border="0" align="top" />';
    }

    $x="";

if($kit1!=$kit){

    $html.= '
<tr  align="center" style="background-color: #525659; color:#FFFFFF; font-family: sans-serif;font-size: 14px"><td colspan="5"><b>'.strtoupper($kit1).'</b></td></tr>
<tr align="center" style="background-color: #FFDD00; color:#000000; font-family: sans-serif">
<td width="30px"><b>ITEM</b></td>
<td width="142px"><b>MODELO</b></td>
<td width="120px"><b>IMAGEN</b></td>
<td width="337.5px"><b>DESCRIPCIÓN</b></td>
<td width="60px"><b>PRECIO $</b></td>
</tr>';
    $kit=$kit1;
}



    $vnombre='<br>'.$vnombre.'<br>';

    $vnombre=	str_replace("<p>",'',$vnombre);
    $vnombre = str_replace("</p>",'',$vnombre);



    IF($N==76){
        $vDescrip=$vDescrip."<br>";
    }

    IF($N==81){
        $vDescrip=$vDescrip."<br><br><br><br>";
    }

    IF($N==85){
        $vDescrip=$vDescrip."<br><br><br><br><br><br><br><br><br><br><br><br>";
    }

    IF($N==100){
        $vDescrip=$vDescrip."<br>";
    }





    IF($N==119){
        $vDescrip=$vDescrip."<br><br><br><br><br><br><br><br><br>";
    }












    $html .= '
	<tr nobr="true" style="text-align: center; vertical-align: 10%">


	<td width="30px" >'.str_repeat('<br>',6).($N+1).'</td>


	<td width="142px"  >'.str_repeat('<br>',6).$vmodelo.'</td>
	<td width="120px" style="font-size: 9px;" ><br><br><br>'.$img.'</td>





	<td align="left" width="337.5px"><b>'.$vnombre.'</b>'
        .$vDescrip.'</td>





	<td width="60px">'.str_repeat('<br>',6).$vTipoMoneda.' '.$Costo.'</td>';





    $html .= '	</tr>';

    $Rs_tipoPer->pg_Move_Next();
    $N ++;
}


$html .= '
</table>
';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

/*
$html = 'Simple text <span style="color: rgb(255,66,14);">Orange</span> simple  <span style="color: rgb(12,128,128);">Turquoise</span>';
$pdf->writeHTML($html, true, false, true, false, '');
 * */

function limpia_espacios($cadena){
    $cadena = str_replace(' ', '', $cadena);
    return $cadena;
}


$pdf->Output('Catalogo'.'.pdf', 'I');



//============================================================+
// END OF FILE
//============================================================+

