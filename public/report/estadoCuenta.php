<?php
define('FPDF_FONTPATH','font/');
require_once('tcpdf_include.php');
require_once('fpdf.php');
require_once('gisp_admincon.php');
require_once('qrcode.class.php');
require_once("Connections/coneccionReporte.php");
require_once("Connections/funciones_pg.php");
include "lib_fecha_texto.php";

class PDF extends FPDF{

var $angle=0;
var $javascript;
var $n_js;

	function IncludeJS($script) {
		$this->javascript=$script;
	}

	function _putjavascript() {
		$this->_newobj();
		$this->n_js=$this->n;
		$this->_out('<<');
		$this->_out('/Names [(EmbeddedJS) '.($this->n+1).' 0 R]');
		$this->_out('>>');
		$this->_out('endobj');
		$this->_newobj();
		$this->_out('<<');
		$this->_out('/S /JavaScript');
		$this->_out('/JS '.$this->_textstring($this->javascript));
		$this->_out('>>');
		$this->_out('endobj');
	}


function AutoPrint($dialog=false)
{
	//Open the print dialog or start printing immediately on the standard printer
	$param=($dialog ? 'true' : 'false');
	$script="print($param);";
	$this->IncludeJS($script);
}

function AutoPrintToPrinter($server, $printer, $dialog=false)
{
	//Print on a shared printer (requires at least Acrobat 6)
	$script = "var pp = getPrintParams();";
	if($dialog)
		$script .= "pp.interactive = pp.constants.interactionLevel.full;";
	else
		$script .= "pp.interactive = pp.constants.interactionLevel.automatic;";
	$script .= "pp.printerName = '\\\\\\\\".$server."\\\\".$printer."';";
	$script .= "print(pp);";
	$this->IncludeJS($script);
}


	function _putresources() {
		parent::_putresources();
		if (!empty($this->javascript)) {
			$this->_putjavascript();
		}
	}

	function _putcatalog() {
		parent::_putcatalog();
		if (!empty($this->javascript)) {
			$this->_out('/Names <</JavaScript '.($this->n_js).' 0 R>>');
		}
	}


function Rotate($angle,$x=-1,$y=-1)
{
	if($x==-1)
		$x=$this->x;
	if($y==-1)
		$y=$this->y;
	if($this->angle!=0)
		$this->_out('Q');
	$this->angle=$angle;
	if($angle!=0)
	{
		$angle*=M_PI/180;
		$c=cos($angle);
		$s=sin($angle);
		$cx=$x*$this->k;
		$cy=($this->h-$y)*$this->k;
		$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
	}
}

function _endpage()
{
	if($this->angle!=0)
	{
		$this->angle=0;
		$this->_out('Q');
	}
	parent::_endpage();
}

function RotatedText($x,$y,$txt,$angle)
{
    //Text rotated around its origin
    $this->Rotate($angle,$x,$y);
    $this->Text($x,$y,$txt);
    $this->Rotate(0);
}

function RoundedRect($x, $y, $w, $h, $r, $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op='f';
        elseif($style=='FD' || $style=='DF')
            $op='B';
        else
            $op='S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));
        $xc = $x+$w-$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));

        $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
        $xc = $x+$w-$r ;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
        $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
        $xc = $x+$r ;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
        $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
        $xc = $x+$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
        $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
    }

	function WriteHTML($html)
	{
		// Intérprete de HTML
		$html = str_replace("\n",'',$html);  //retorno de carro (saltodelinea)
		$a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
		foreach($a as $i=>$e)
		{
			if($i%2==0)
			{
				// Text
				if($this->HREF)
					$this->PutLink($this->HREF,$e);
				else
					$this->Write(5,$e);
			}
			else
			{
				// Etiqueta
				if($e[0]=='/')
					$this->CloseTag(strtoupper(substr($e,1)));
				else
				{
					// Extraer atributos
					$a2 = explode(' ',$e);
					$tag = strtoupper(array_shift($a2));
					$attr = array();
					foreach($a2 as $v)
					{
						if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
							$attr[strtoupper($a3[1])] = $a3[2];
					}
					$this->OpenTag($tag,$attr);
				}
			}
		}
	}

/*	function OpenTag($tag, $attr)
	{
		// Etiqueta de apertura
		if($tag=='B' || $tag=='I' || $tag=='U')
			$this->SetStyle($tag,true);
		if($tag=='A')
			$this->HREF = $attr['HREF'];
		if($tag=='BR')
			$this->Ln(5);
	}

	function CloseTag($tag)
	{
		// Etiqueta de cierre
		if($tag=='B' || $tag=='I' || $tag=='U')
			$this->SetStyle($tag,false);
		if($tag=='A')
			$this->HREF = '';
	}
*/
	function OpenTag($tag,$attr)
	{
		if($tag=='B' || $tag=='I' || $tag=='U')
			$this->SetStyle($tag,true);
		if($tag=='A')
			$this->HREF = $attr['HREF'];
		if($tag=='BR')
			$this->Ln(5);
		//Opening tag
		switch($tag){
			case 'STRONG':
			case 'B':
				if ($this->bi)
					$this->SetStyle('B',true);
				else
					$this->SetStyle('U',true);
				break;
			case 'H1':
				$this->Ln(5);
				$this->SetTextColor(150,0,0);
				$this->SetFontSize(22);
				break;
			case 'H2':
				$this->Ln(5);
				$this->SetFontSize(18);
				$this->SetStyle('U',true);
				break;
			case 'H3':
				$this->Ln(5);
				$this->SetFontSize(16);
				$this->SetStyle('U',true);
				break;
			case 'H4':
				$this->Ln(5);
				$this->SetTextColor(102,0,0);
				$this->SetFontSize(14);
				if ($this->bi)
					$this->SetStyle('B',true);
				break;
			case 'PRE':
				$this->SetFont('Courier','',11);
				$this->SetFontSize(11);
				$this->SetStyle('B',false);
				$this->SetStyle('I',false);
				$this->PRE=true;
				break;
			case 'RED':
				$this->SetTextColor(255,0,0);
				break;
			case 'BLOCKQUOTE':
				$this->mySetTextColor(100,0,45);
				$this->Ln(3);
				break;
			case 'BLUE':
				$this->SetTextColor(0,0,255);
				break;
			case 'I':
			case 'EM':
				if ($this->bi)
					$this->SetStyle('I',true);
				break;
			case 'U':
				$this->SetStyle('U',true);
				break;
			case 'A':
				$this->HREF=$attr['HREF'];
				break;
			case 'IMG':
				if(isset($attr['SRC']) && (isset($attr['WIDTH']) || isset($attr['HEIGHT']))) {
					if(!isset($attr['WIDTH']))
						$attr['WIDTH'] = 0;
					if(!isset($attr['HEIGHT']))
						$attr['HEIGHT'] = 0;
					$this->Image($attr['SRC'], $this->GetX(), $this->GetY(), px2mm($attr['WIDTH']), px2mm($attr['HEIGHT']));
					$this->Ln(3);
				}
				break;
			case 'LI':
				$this->Ln(2);
				$this->SetTextColor(190,0,0);
				$this->Write(5,'     » ');
				$this->mySetTextColor(-1);
				break;
			case 'TR':
				$this->Ln(7);
				$this->PutLine();
				break;
			case 'BR':
				$this->Ln(2);
				break;
			case 'P':
				$this->Ln(5);
				break;
			case 'HR':
				$this->PutLine();
				break;
			case 'FONT':
				if (isset($attr['COLOR']) && $attr['COLOR']!='') {
					$coul=hex2dec($attr['COLOR']);
					$this->mySetTextColor($coul['R'],$coul['G'],$coul['B']);
					$this->issetcolor=true;
				}
				if (isset($attr['FACE']) && in_array(strtolower($attr['FACE']), $this->fontlist)) {
					$this->SetFont(strtolower($attr['FACE']));
					$this->issetfont=true;
				}
				break;
		}
	}

	function CloseTag($tag)
	{

		//Closing tag
		if ($tag=='H1' || $tag=='H2' || $tag=='H3' || $tag=='H4'){
			$this->Ln(6);
			$this->SetFont('Times','',12);
			$this->SetFontSize(12);
			$this->SetStyle('U',false);
			$this->SetStyle('B',false);
			$this->mySetTextColor(-1);
		}
		if ($tag=='PRE'){
			$this->SetFont('Times','',12);
			$this->SetFontSize(12);
			$this->PRE=false;
		}
		if ($tag=='RED' || $tag=='BLUE')
			$this->mySetTextColor(-1);
		if ($tag=='BLOCKQUOTE'){
			$this->mySetTextColor(0,0,0);
			$this->Ln(3);
		}
		if($tag=='STRONG')
			$tag='B';
		if($tag=='EM')
			$tag='I';
		if((!$this->bi) && $tag=='B')
			$tag='U';
		if($tag=='B' || $tag=='I' || $tag=='U')
			$this->SetStyle($tag,false);
		if($tag=='A')
			$this->HREF='';
		if($tag=='FONT'){
			if ($this->issetcolor==true) {
				$this->SetTextColor(0,0,0);
			}
			if ($this->issetfont) {
				$this->SetFont('Times','',12);
				$this->issetfont=false;
			}
		}
	}
	function mySetTextColor($r,$g=0,$b=0){
		static $_r=0, $_g=0, $_b=0;

		if ($r==-1)
			$this->SetTextColor($_r,$_g,$_b);
		else {
			$this->SetTextColor($r,$g,$b);
			$_r=$r;
			$_g=$g;
			$_b=$b;
		}
	}
	function PutLine()
	{
		$this->Ln(2);
		$this->Line($this->GetX(),$this->GetY(),$this->GetX()+187,$this->GetY());
		$this->Ln(3);
	}

	function SetStyle($tag, $enable)
	{
		// Modificar estilo y escoger la fuente correspondiente
		$this->$tag += ($enable ? 1 : -1);
		$style = '';
		foreach(array('B', 'I', 'U') as $s)
		{
			if($this->$s>0)
				$style .= $s;
		}
		$this->SetFont('',$style);
	}

	function PutLink($URL, $txt)
	{
		// Escribir un hiper-enlace
		$this->SetTextColor(0,0,255);
		$this->SetStyle('U',true);
		$this->Write(5,$txt,$URL);
		$this->SetStyle('U',false);
		$this->SetTextColor(0);
	}

	function Header(){
		//datos SQL
		global $login;
		global $centro_costo;
		global $nom_oficina;
		global $cod_actproy;
		global $des_actproy;
		global $cod_nemonico;
		global $des_nemonico;
		global $title;
		global $nro_nec;
		global $ano_eje;
		global $fch_nec;
		global $tipo_bien;
		global $reqs_anuales;
		global $topIni;
		global $marIni;
		global $wcel;
		global $marcaAguaL4;global $marcaAguaP2;
		global $marcaAguaP3;
		global $marcaAguaP4;
		global $marcaDeAgua;
		global $repositorioFirmas;
		global $RUC;
		global $numero_recibo;
		global $codigoContrib;
		global $nombreContrib;
		global $nroDoc;
		global $direccionContrib;
		global $cajero;
		global $fechaEmision;
		global $fechaImpresion;
		global $fechaProyectado1;
		global $err;
		global $fechaRecargos;
		global $usuario;
		global $colCab;
		global $colSubCab;
                global $vadicon;


		$tamInfoCuadro = -16;
                $posInfoCuadro = 26;
                $tamInfoCuadro2 = -9;
                $posInfoCuadro2 = 9;
                $tamcabecera=30;

		$lw = $marIni;
		$ln = $topIni;
		$ls = 3;
		$lh = 0;
		//MArca de Agua
		//$this->Image('../img/marca/escudomarcaagua4.png',$marcaAguaL1-20,$marcaAguaL2,$marcaAguaL3+50,$marcaAguaL4+50,'PNG');

		//$this->RoundedRect(-10, 0, 220, 8, 1,'S');
		$this->Image('../img/logo.jpg',$lw,$ln,62,18,'PNG');

		//$this->SetFillColor(145,185,154); //verde agua
		$lh = $lh+9;
		$this->SetFont('Narrow','',9);
		$this->SetXY($lw+120,$lh);
		$this->MultiCell(70,3,'Telf.: 471 7304 / 997 149 778',0,'R');
		$this->SetXY($lw+120,$lh+4);
		$this->MultiCell(70,3,'Av. Santa Catalina 104 dpto. 201',0,'R');
		$this->SetXY($lw+120,$lh+8);
		$this->MultiCell(70,3,utf8_decode('(Av. Canadá cdra. 8) La Victoria'),0,'R');
		$this->SetXY($lw+120,$lh+12);
		$this->MultiCell(70,3,utf8_decode('ventas@dhlsecurity.pe'),0,'R');
		$this->SetXY($lw+120,$lh+16);
		$this->MultiCell(70,3,utf8_decode('www.dhlsecurity.pe'),0,'R');


		//definimos  ancho y color de rectangulo
		$lh = $lh+20;


		$nombreContrib1=utf8_decode($nombreContrib);
                if(strlen(trim($nombreContrib1))>45 and strlen(trim($nombreContrib1))<=60){
                   $this->SetFont('narrow','',10);
                }elseif(strlen(trim($nombreContrib1))>60 and strlen(trim($nombreContrib1))<=90 ){
                    $this->SetFont('narrow','',8);

                }elseif(strlen(trim($nombreContrib1))>90){
                    $this->SetFont('narrow','',6);

                }else{
                    $this->SetFont('narrow','',12);
                }


		$this->SetLineWidth(0.3);
		$this->SetFillColor(255);
		//$this->RoundedRect($lw-5, $lh, 110+$tamcabecera, 27, 1, '');  //Cuadro redondeado
		$this->SetFont('arial','',8);
		$this->SetXY($lw,$lh+2);
		$this->MultiCell(100,5,"Lima ".utf8_decode(fechaATexto("02/05/2017")),0,'L');
		$this->SetFont('arial','B',9);
		$this->SetXY($lw,$lh+6);
		$this->MultiCell(80,5,utf8_decode("Cotización: 02017 - 0001084"),0,'L');
		$this->SetXY($lw,$lh+11);
		$this->MultiCell(80,5,utf8_decode("Señor(a): BIOCHEMICAL Y NUTRITION LAB"),0,'L');
		$this->SetFont('arial','',9);
		$this->SetXY($lw,$lh+17);
		$this->MultiCell(80,5,utf8_decode("Presente:"),0,'J');
		$this->SetXY($lw,$lh+21);
		$this->MultiCell(180,5,utf8_decode("Por medio de la presente le enviamos la cotización solicitada: LOCAL JESUS MARIA"),0,'L');




		$lh = $lh +30;  //Inicio del detalle

		$this->SetFillColor(255, 195, 0);
		$ls=-5;
		$this->SetFont('arial','B',8);
		$this->SetXY($lw+$ls,$lh);
		$this->Cell($colCab[0],5,"",1,1,'L',true);
		$this->SetXY($lw+$ls,$lh+1);
		$this->MultiCell($colCab[0],3,'Item',0,'C');

		$ls=5;
		$this->SetFont('arial','B',8);
		$this->SetXY($lw+$ls,$lh);
		$this->Cell($colCab[1],5,"",1,1,'L',true);
		$this->SetXY($lw+$ls,$lh+1);
		$this->MultiCell($colCab[1],3,utf8_decode('CÓDIGO'),0,'C');


		$ls = 45;
		$this->SetFont('arial','B',8);
		$this->SetXY($lw+$ls,$lh);
		$this->Cell($colCab[2],5,"",1,1,'L',true);
		$this->SetXY($lw+$ls,$lh+1);
		$this->MultiCell($colCab[2],3,'CANT.',0,'C');


		$ls = 55;
		$this->SetFont('arial','B',8);
		$this->SetXY($lw+$ls,$lh);
		$this->Cell($colCab[3],5,"",1,1,'L',true);
		$this->SetXY($lw+$ls,$lh+1);
		$this->MultiCell($colCab[3],3,utf8_decode('DESCRIPCIÓN'),0,'C');

		$ls = 160;
		$this->SetFont('arial','B',8);
		$this->SetXY($lw+$ls,$lh);
		$this->Cell($colCab[4],5,"",1,1,'L',true);
		$this->SetXY($lw+$ls,$lh+1);
		$this->MultiCell($colCab[4],3,'P.U',0,'C');

		$ls = 178;
		$this->SetFont('arial','B',8);
		$this->SetXY($lw+$ls,$lh);
		$this->Cell($colCab[5],5,"",1,1,'L',true);
		$this->SetXY($lw+$ls,$lh+1);
		$this->MultiCell($colCab[5],3,'P.T',0,'C');


	}

	function Footer(){
		global $marini;
		global $nro_nec;
		global $ano_eje;
		global $nombreGispAdmincon;
		//Posición: a 1,5 cm del final
		$this->SetFont('Arial','',8);
		$this->SetXY($marini,-10);
		$this->Cell(0,5,utf8_decode('Pagina N° ').$this->PageNo().' de {nb}',0,0,'R');
		/*$this->SetXY($marini,-10);
		$this->Cell(79,5,'Titania - Gestor Integrado Tributario ',0,0,'L',0);*/
	}

	function WriteResumen($x,$h, $corte,$topmar){
		//datos SQL
		global $Coneccion;
		global $ano_eje;
		global $nro_nec;

		//datos DOC
		global $marini;
		global $topmar;
		global $repositorioFirmas;

		$x = $x-5;



		$this->SetXY($x,$h +=4);
		$var1 = $this->GetY();
		if($corte = $this->CheckPageBreak($var1)) $h = $topmar+7;
		$this->SetFont('Arial','',10);
		//Número de página
		#$Texto = "* Todos los Montos con Amnistia Tributaria fueron calculados en Base a la Ordenanza 230-2013/MDPP, por tanto el Contribuyente debe de cumplir con las condiciones especificadas en dicha Ordenanza para acceder a los BENEFICIOS";
		$this->SetXY($x,$h);
		$this->MultiCell(200,4,$Texto,0,'J');


		$var1 = $this->GetY();
		if($corte = $this->CheckPageBreak($var1)) $h = $topmar+7;


                $this->SetXY($x,$h +=8);
		$var1 = $this->GetY();
		if($corte = $this->CheckPageBreak($var1)) $h = $topmar+7;

		$this->SetFont('Arial','',10);
		//Número de página
		#$Texto = "* Todos los Montos con Beneficio Contribuyente Puntual 2014 fueron calculados en Base a la Ordenanza 229-2013/MDPP, que otorga el descuento del 30%  en arbitrios 2014 si se paga TODO el Impuesto Predial 2014, por tanto el Contribuyente debe de cumplir con las condiciones especificadas en dicha Ordenanza para acceder a los BENEFICIOS";
		$this->SetXY($x,$h);
		$this->MultiCell(200,4,$Texto,0,'J');

        $this->SetXY($x,$h +=15);
		$var1 = $this->GetY();
		if($corte = $this->CheckPageBreak($var1)) $h = $topmar+7;


		//Número de página
		$this->SetFont('arial','B',10);
		$this->SetXY($x,$h);
		$this->MultiCell(55,5,'Tipo de Cambio: 3.30',0,'L');
		$this->SetFont('Arial','',10);
		$this->SetXY($x,$h+6);
		$this->MultiCell(80,5,'Condiciones de la instalacion',0,'L');
		$this->SetXY($x,$h+10);
		$this->MultiCell(150,5,'El cliente brindara las facilidades para la instalaion, incluyendo los permisos necesarios.',0,'L');
		$this->SetXY($x,$h+20);
		$this->MultiCell(80,5,'Condiciones Comerciales',0,'L');
		$this->SetXY($x,$h+25);
		$this->MultiCell(80,5,utf8_decode('Tiempo de entrega: 3 dias hábiles'),0,'L');
		$this->SetXY($x,$h+30);
		$this->MultiCell(180,5,utf8_decode('Garantía: 12 meses por equipos y 12 meses por instalacionón y Disco Duro'),0,'L');
		$this->SetXY($x,$h+35);
		$this->MultiCell(180,5,utf8_decode('Forma de pago: Adelando del 50% del total y al finalizar el pago del 505 con la conformidad de la obra'),0,'L');
		$this->SetXY($x,$h+45);
		$this->MultiCell(180,5,utf8_decode('Cuenta corriente BCP Soles: 191-1964430-0-26'),0,'L');
		$this->SetXY($x,$h+50);
		$this->MultiCell(180,5,utf8_decode('Cuenta corriente BCP dólares: 191-2040241-1-04'),0,'L');
		$this->SetXY($x,$h+60);
		$this->MultiCell(180,5,utf8_decode('Atte.'),0,'L');

		$this->SetXY($x,$h+70);
		$this->MultiCell(180,5,utf8_decode('---------------------------------'),0,'L');
		$this->SetXY($x+2,$h+73);
		$this->MultiCell(80,5,utf8_decode('Daniel Huaraca Livias'),0,'L');

		$this->SetXY($x,$h+77);
		$this->MultiCell(60,5,utf8_decode('JEFE DE PROYECTOS DHL SYSTEM SECURITY EIRL'),0,'L');

		$var1 = $this->GetY();
		if($corte = $this->CheckPageBreak($var1)) $h = $topmar+7;

		#$this->MultiCell(110,5,'https://www.facebook.com/municipalidaddistritaldepuentepiedra',0,'L');
	}
/*  Obtener el y maximo de la fila
$maxy=$this->GetY();
if ($maxy<$this->GetY()){
$maxy=$this->GetY();
}*/

	function CheckPageBreak($h){
		if($h >= 265){
			$this->AddPage();
			return 1;
		}else{
			$this->SetY($h);
			return 0;
		}
		/*if($h >= 250){
			$this->AddPage('P','mm','A4');
			return true;
		}*/
	}

}


$idcotiz = $_GET['idCotiz'];

date_default_timezone_set('America/Lima');
$fechaImpresion=strftime('%d/%m/%Y %H:%M:%S');

if (!in_array($err, array('L', 'M', 'Q', 'H'))) $err = 'Q';

$colCab = array('10','40','10','105','18','18');
$colSubCab[0] = array('35','8','18');
$colSubCab[1] = array('18','20','25');
$colSubCab[2] = array('18','8','25');

$topIni = 10;
$marIni = 10;
$topmar = 65;
//$lw=10;

$pdf = new PDF('P','mm','A4');
$pdf->SetDisplayMode('fullpage');
//$pdf->AutoPrint();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);


$var1 = $pdf->GetY()+5;
//$var1 = $topmar+5;
$pdf->SetXY($lw,$lh = $var1);



	$sumImpSol = 0;
	$sumRejuste = 0;
	$sumMontoTotal = 0;
	$sumAbonado = 0;
	$sumSaldo = 0;

	$sumImpSol1 = 0;
	$sumRejuste1 = 0;
	$sumMontoTotal1 = 0;
	$sumAbonado1 = 0;
	$sumSaldo1 = 0;

	$sumImpSol2 = 0;
	$sumRejuste2 = 0;
	$sumMontoTotal2 = 0;
	$sumAbonado2 = 0;
	$sumSaldo2 = 0;

	$sumDescImpSol = 0;
	$sumDescRejuste = 0;
	$sumDescMontoTotal = 0;
	$sumDescAbonado = 0;
	$sumDescSaldo = 0;

	$sumDescImpSol1 = 0;
	$sumDescRejuste1 = 0;
	$sumDescMontoTotal1 = 0;
	$sumDescAbonado1 = 0;
	$sumDescSaldo1 = 0;

	$sumDescImpSol2 = 0;
	$sumDescRejuste2 = 0;
	$sumDescMontoTotal2 = 0;
	$sumDescAbonado2 = 0;
	$sumDescSaldo2 = 0;




	$sumConAmnistiaImpSol = 0;
	$sumConAmnistiaRejuste = 0;
	$sumConAmnistiaMontoTotal = 0;
	$sumConAmnistiaAbonado = 0;
	$sumConAmnistiaSaldo = 0;

	$sumConAmnistiaImpSol1 = 0;
	$sumConAmnistiaRejuste1 = 0;
	$sumConAmnistiaMontoTotal1 = 0;
	$sumConAmnistiaAbonado1 = 0;
	$sumConAmnistiaSaldo1 = 0;

	$sumConAmnistiaImpSol2 = 0;
	$sumConAmnistiaRejuste2 = 0;
	$sumConAmnistiaMontoTotal2 = 0;
	$sumConAmnistiaAbonado2 = 0;
	$sumConAmnistiaSaldo2 = 0;

	$sumSinAmnistiaImpSol = 0;
	$sumSinAmnistiaRejuste = 0;
	$sumSinAmnistiaMontoTotal = 0;
	$sumSinAmnistiaAbonado = 0;
	$sumSinAmnistiaSaldo = 0;

	$sumSinAmnistiaImpSol1 = 0;
	$sumSinAmnistiaRejuste1 = 0;
	$sumSinAmnistiaMontoTotal1 = 0;
	$sumSinAmnistiaAbonado1 = 0;
	$sumSinAmnistiaSaldo1 = 0;

	$sumSinAmnistiaImpSol2 = 0;
	$sumSinAmnistiaRejuste2 = 0;
	$sumSinSinAmnistiaMontoTotal2 = 0;
	$sumSinAmnistiaAbonado2 = 0;
	$sumSinAmnistiaSaldo2 = 0;






$Rs_tipoPer = new TSPResult($ConeccionRatania,"");
$Rs_tipoPer->Poner_MSQL("select a.idCotiz, a.vnroCot,CONVERT(VARCHAR(10),a.dfecCot,103) as dfecCot,nSubTot,nTotal,b.vNombrePSM,
 sum(b.nPrecUnit) as nPrecUnit,Case when SUBSTRING(b.vNombrePSM,0,9)='Material' then 'Global'
 else CAST(b.nCantidad AS varchar(5))  end nCantidad,sum(b.nPrecTotal)
  as nPrecTotal ,c.idCliente,c.vNombre as cliente , Case when b.tipoPS!='1' then '1.jpg'
 else  dbo.imgadjunto(b.idProdServ)   end as img,
  Case when b.tipoPS!='1' then ''
 else  dbo.ModeloProd(b.idProdServ)   end as Modelo,b.idprodserv,
 coalesce(a.tiempEntrega,'') as tentrega , coalesce(a.vGarantia,'') as garantia,
 p.vNombre as personal, a.nTasaCambio, case when dbo.tieneServ(a.idCotiz)='1' then 'Adelanto del 50% del total y al finalizar el pago del 50% con la conformidad de la Obra.' else 'Al contado' end as formapago
   ,dbo.detalleservicio(a.idCotiz,b.vNombrePSM,b.idprodserv) as detalle
  from compras.cotizacion
a left join compras.detCotizacion b on a.idCotiz =b.idCotiz
inner join cliente c on a.idCliente=c.idCliente
left join personal p on a.idPersonal=p.idPersonal
where a.idCotiz=$idcotiz
and opcional is null
group by  a.idCotiz,a.vnroCot,a.dfecCot,a.nSubTot,a.nTotal,b.vNombrePSM,b.nCantidad,c.idCliente,
c.vNombre,idProdServ,tipoPS, a.tiempEntrega , a.vGarantia,p.vNombre, a.nTasaCambio
order by tipoPS,b.idProdServ,nCantidad");
//$Rs_tipoPer->pg_Poner_Esquema("public");

$Rs_tipoPer->executeMSQL();
$rowTipoP= $Rs_tipoPer->pg_Get_Row();

$p_tipopersona = $rowTipoP['vNombrePSM'];
$p_tienebene = $rowTipoP['vNombre'];
$N = 0;
$numRows = $Rs_tipoPer->pg_Num_Rows();
while($N < $numRows) {
	$row = $Rs_tipoPer->pg_Get_Row();
	//echo $row['detalle'] . " - " . $row['vNombrePSM']. " - " . $row['img']  . "<br>";
	$html = $row['detalle'];
	$pdf->SetFont('arial','',8);
	$html1= str_replace('&bull;', '•', $html);
	$txtss = iconv('utf-8', 'cp1252', $html);
	//$pdf->MultiCell(185,6,$pdf->WriteHTML($html1),0,'J');
	$var1 = $pdf->GetY();
	if($corte == $pdf->CheckPageBreak($var1)) $lh = $topmar+7;
	$Rs_tipoPer->pg_Move_Next();
	$N ++;
}




		///// TOTAL FINAL


				$lz += 3;
				$ls=-5;
				$lw=$marIni;
				$pdf->Line($lw+$colCab[0], $lh + $lz , 205, $lh  + $lz, $style);
				$pdf->SetFont('arial','',8);
				$pdf->SetXY($lw+$ls,$lh+$lz);
				$pdf->MultiCell($colCab[3],4,'TOTAL INCLUIDO IGV',1,'L');

				$ls = 56;

				$pdf->SetXY($lw+$ls,$lh+$lz);
				$pdf->MultiCell($colSubCab[1][0],4,number_format($sumSinAmnistiaImpSol2,2,',',''),1,'R');
				$pdf->SetXY($lw+$ls+18,$lh+$lz);
				$pdf->MultiCell($colSubCab[1][1],4,number_format($sumSinAmnistiaRejuste2,2,',',''),1,'R');
				$pdf->SetXY($lw+$ls+38,$lh+$lz);
				$pdf->MultiCell($colSubCab[1][2],4,number_format($sumSinAmnistiaMontoTotal2,2,',',''),1,'R');

				$ls = 119;

				$pdf->SetXY($lw+$ls,$lh+$lz);
				$pdf->MultiCell($colSubCab[2][0],4,'',1,'C');
				$pdf->SetXY($lw+$ls+18,$lh+$lz);
				$pdf->MultiCell($colSubCab[2][1],4,'',1,'R');
				$pdf->SetXY($lw+$ls+26,$lh+$lz);
				$pdf->MultiCell($colSubCab[2][2],4,number_format($sumSinAmnistiaAbonado2,2,',',''),1,'R');

				$ls = 170;

				$pdf->SetXY($lw+$ls,$lh+$lz);
				$pdf->MultiCell($colCab[3],4,number_format($sumSinAmnistiaSaldo2,2,',',''),1,'R');

				$var1 = $pdf->GetY();
				if($corte = $pdf->CheckPageBreak($var1)) $lh = $topmar+7;

				$lz += 4;
				$lh += $lz;
				$lz = 0;


$lz += 0;
$ls=0;
$lw=$marIni;
$var1 = $pdf->GetY();

$html = ' <p>  DOMO <a style="color:#ff0000;">INT&bull;ERIOR</a> | CMOS 1/4&quot; | 1.0 MP | 3.6mm | DSP Cannon | IR Microcristal: 20m
 </p> ';
$pdf->SetFont('Arial','',11);
$pdf->SetXY($lw+$ls,$lh+$lz);

$html1= str_replace('&bull;', '•', $html);
$html1=str_replace("\n",'',$html1); //replace carriage returns with spaces
$html1=str_replace("\t",'',$html1); //replace carriage returns with spaces

//$html1= str_replace('<strong>', '<b>', $html);
//$html1= str_replace('</strong>', '</b>', $html);
$txtss = iconv('utf-8', 'cp1252', $html1);
//$txtss = htmlspecialchars( $html,ENT_NOQUOTES);
$txtss = html_entity_decode($txtss);

//$txtss = wordwrap($html);
$pdf->WriteHTML($txtss);



$pdf->SetXY(0,$ln+$var1+15);
$pdf->MultiCell(185,6,$html,0,'J');
$pdf->MultiCell(185,6,utf8_decode($html),0,'J');


///fcpdf



$var1 = $pdf->GetY();
if($corte == $pdf->CheckPageBreak($var1)) $lh = $topmar+7;
$pdf->SetXY($lw+20,$ln+$var1+25);
//$this->RoundedRect(-10, 0, 220, 8, 1,'S');
//$pdf->Image('../uploadDdocuments/'.$firmaaux,$lw+120,$ln+$var1+5,52,18,'PNG');


$Rs_tipoPer->pg_Move_First();
$N=0;
while($N < $numRows) {
	$row = $Rs_tipoPer->pg_Get_Row();
	//echo $row['detalle'] . " - " . $row['vNombrePSM']. " - " . $row['img']  . "<br>";
	$html = $row['vNombrePSM'];
	//$pdf->SetFont('arial','',8);
	$html1= str_replace('&bull;', '•', $html);
	//$html1= str_replace('<strong>', '<b>', $html);
	//$html1= str_replace('</strong>', '</b>', $html);
	//$txtss = iconv('utf-8', 'cp1252', $html);

	$txtss = wordwrap($html);
	//$pdf->MultiCell(185,6,$pdf->WriteHTML($txtss),0,'J');
	$var1 = $pdf->GetY();
	if($corte == $pdf->CheckPageBreak($var1)) $lh = $topmar+7;
	$Rs_tipoPer->pg_Move_Next();
	$N ++;
}

$var1 = $pdf->GetY();
$pdf->WriteResumen($lw,$var1, $corte,$topmar);
$pdf->Output();


?>