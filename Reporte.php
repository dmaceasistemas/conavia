<?php
include('session.php');
include('phpsqlajax_dbinfo.php');
include("includes/savelog.php");
/* incluimos primeramente el archivo que contiene la clase fpdf */
require('fpdf17/fpdf.php');
 
 
// Cabecera para solucionar el problema de los acentos y las ñ
header("Content-Type: text/html; charset=iso-8859-1 ");
 
 
class PDF extends FPDF
{
var $B;
var $I;
var $U;
var $HREF;
 
function PDF($orientation='P', $unit='mm', $size='A4')
{
    // Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$size);
    // Iniciación de variables
    $this->B = 0;
    $this->I = 0;
    $this->U = 0;
    $this->HREF = '';
}
 
//Función para escribir en código HTML y que se detecten las etiquetas
function WriteHTML($html)
{
    // Intérprete de HTML
    $html = str_replace("\n",' ',$html);
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
 
function OpenTag($tag, $attr)
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
 
// Cabecera de página
function Header()
{
  //   Logo de la cabecera del PDF
    $this->Image('images/bg/logo_pc.png',10,8);
 
}
 
// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','',8);
    // Número de página
    $this->Cell(0,10,'Pagina '.$this->PageNo(),0,0,'C');
}
 
}
 
$id= $_GET['EDID']; //Tomamos por GET el id del producto del que se desean extraer los datos de la BD
 
$sql= "SELECT * FROM orden WHERE id='$id'"; //Hacemos la consulta a la base de datos
$con= mysql_query($sql);
while ($row = mysql_fetch_array($con)) {
    // Guardamos en variables lo extraído de la BD, éste paso es, obviamente, opcional, yo lo hice por que me resulta mas cómodo
 //   $nombre= $row['nombre'];
 //   $vehiculo =$row['vehiculo'];
 //   $descripcion = $row['descripcion'];

}
 
 
//Antes de pasar los datos al PDF, hay que pasar las variables por la función html_entity_decode para decodificar los caracteres especiales, los acentos y las ñ 
// Siempre y cuando los datos extraídos de la BD sean UTF8 (no lo probe con otra codificación)
$vehiculo = html_entity_decode($vehiculo); 
$nombre = html_entity_decode($nombre);
 
 
//Creamos una nueva instancia de la clase
$pdf = new PDF();
 
// Aádimos la primera página
$pdf->AddPage();
$pdf->SetFont('Helvetica','',14);
$pdf->Ln(40);
$pdf->Line(10, 45, 200, 45);
$pdf->SetFontSize(12);
 
// Otra parte importante, luego de pasar las variables por la función html_entity_decode, para que se vean bien los acentos y las ñ, hay que pasarlas por otra 
// función que es utf8_decode
 
$pdf->WriteHTML(utf8_decode($nombre));
 
//La función WriteHTML es la que creamos anteriormente para que lea las etiquetas html como <br>, <b>, <i>, <p>, etc.
 
$pdf->Line(10,200, 200, 200);
$pdf->Cell(0,6,'Nombre de Conductor: '.$row['nombre'],0,1);
$pdf->Cell(0,10,'Vehiculo que Conduce: '.$row['vehiculo'],0,1);
$pdf->Cell(0,8,'Descripcion de la Orden de Trabajo: '.$row['descripcion'],0,1);
$pdf->Cell(0,10,$nombre,0,1,'R');
$pdf->Ln(110);
$pdf->SetLeftMargin(10);
$pdf->SetFontSize(12);
 
//Lo mismo que en la variable anterior, decodificamos la variable $html para que el texto se vea correctamente con los acentos y las ñ correspondientes.
 
$pdf->WriteHTML(utf8_decode($vehiculo));
 
//Con OutPut hacemos que se visualice el PDF que acabamos de crear
$pdf->Output();
?>
