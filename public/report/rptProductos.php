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
		$this->SetXY($lw + 114, $lh + 16);
		$this->MultiCell(70, 3, 'www.dhlsecurity.pe', 0, 'R');

		$lh = $lh + 20;
	}

	function WriteResumen($x, $h, $corte, $topmar)
	{
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

		$lh = $this->GetY() - 5;
		$lw = $this->GetX() - 5;

		$this->SetLineWidth(0);
		$this->SetFillColor(255);

		$this->SetFont('times', '', 10);
		$this->SetXY($lw, $lh + 4);
		$this->MultiCell(100, 5, "Lima " . fechaATexto($fecha), 0, 'L');
		$this->SetFont('times', '', 10);
		$this->SetXY($lw, $lh + 10);
		$this->MultiCell(80, 5, "Productos: ", 0, 'L');
		$this->SetFont('times', 'B', 10);
		$this->SetXY($lw + 17, $lh + 10);
		$this->MultiCell(80, 5, '', 0, 'L');
	}
}


$data = $_POST['data']; //Data Selected

$idcotiz = $_GET['idCotiz'];
$Rs_tipoPer = new TSPResult($ConeccionRatania, "");
$Rs_tipoPer->Poner_MSQL("select  CONVERT(VARCHAR(10), SYSDATETIME(), 103) Fecha");
$Rs_tipoPer->executeMSQL();
$rowTipoP = $Rs_tipoPer->pg_Get_Row();

$fecha = $rowTipoP['Fecha'];


// create new PDF document
$pdf = new PDF1(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Jhimi Rosales');
$pdf->SetTitle('Productos');
$pdf->SetSubject('Detalle de Productos');
$pdf->SetKeywords('TCPDF, PDF, Productos, detalle productos');

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
$var1 = $pdf->GetY() + 2.2;
$pdf->SetXY($lw + 2.5, $lh = $var1);



// $this->Ln();


$html = '<table border="0.1"  cellmargin="1" cellpadding="3" style=" border-collapse: collapse;margin:0px;border:1px solid black; ">
<tr align="center" style="background-color: #ffda07; font-family: sans-serif">
<td width="30px"><b>ITEM</b></td>
<td width="90px"><b>MODELO</b></td>
<td width="300px"><b>NOMBRE</b></td>
<td width="100px"><b>MARCA</b></td>
<td width="90px"><b>STOCK</b></td>
<td width="90px"><b>STOCK MINIMO</b></td>
</tr>';

$N = 0;

// Data
foreach ($data as $row) {
	// foreach ($row as $col) {
	$html .= '
			<tr nobr="true" style="text-align: center; vertical-align: 10%">
			<td width="30px" >' . ($N + 1) . '</td>
			<td width="90px" >' .  $row["vModelo"] . '</td>
			<td width="300px" style="font-size: 9px;" align="left" ><b>' . $row["vNombre"] . '</b><br></td>
			<td width="100px">' .  $row["vMarca"] . '</td>
			<td  align="center" width="90px">' .  $row["nStock"] . '</td>
			<td width="90px" >' .  $row["nStockMinimo"] . '</td>';


	$html .= '	</tr>';
	// }
	$N++;
}


$html .= '
</table>
';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

$lw = 5;
$var1 = $pdf->GetY() + -0.8;
$pdf->SetXY($lw + 2.5, $var1);



function limpia_espacios($cadena)
{
	$cadena = str_replace(' ', '', $cadena);
	return $cadena;
}


$pdf->Output('MATERIALES.pdf', 'I');



//============================================================+
// END OF FILE
//============================================================+
