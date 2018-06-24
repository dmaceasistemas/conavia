<?php
include('session.php');
include('phpsqlajax_dbinfo_conavia.php');
include("includes/savelog.php");

$sql=mysql_query("SELECT * FROM users  WHERE id_user='$GPSUSERID'");
$result=mysql_fetch_array($sql);
$GPSUSERNAME=($result['subacc_id']);

$EDID=$_GET['EDID'];
$DID=$_GET['DID'];
$Save=$_GET['Save'];
$Edit=$_GET['Edit'];
$Delete=$_GET['Delete'];
$Print=$_GET['Print'];

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['Print']))

{
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
 
function PDF($orientation='P', $unit='mm', $size='letter')
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
    $this->Image('images/bg/Cabezal 2.jpg',10,8);
 
}
 
// Pie de página
function Footer()

{
$id= $_GET['EDID'];
$sql=("SELECT * FROM proyecto WHERE id='$id'"); //Hacemos la consulta a la base de datos
$con= mysql_query($sql);
while ($row = mysql_fetch_array($con)) 

{
//$GPSUSERNAME=strtoupper($result['login']);
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','',8);
    // Número de página
    $this->Cell(1,10,'Usuario: '.$row['usuarios'],0,0,'L');
    $this->Cell(0,10,'Pagina '.$this->PageNo(),0,0,'C');
    $this->Cell(0,10,date('"h:i-d/m/Y"'),0,0,'R');

}
}
 
}
 
$id= $_GET['EDID']; //Tomamos por GET el id del producto del que se desean extraer los datos de la BD
 //$sql=("SELECT * FROM orden WHERE id='$id'"); 
//$con= mysql_query($sql);
//while ($row = mysql_fetch_array($con))
$sql=("SELECT * FROM proyecto WHERE id='$id'"); //Hacemos la consulta a la base de datos
$con= mysql_query($sql);
while ($row = mysql_fetch_array($con)) 
{
$name = substr($row["descripcion"],0,100);
    // Guardamos en variables lo extraído de la BD, éste paso es, obviamente, opcional, yo lo hice por que me resulta mas cómodo
 //   $nombre= $row['nombre'];
 //   $vehiculo =$row['vehiculo'];
 //   $descripcion = $row['descripcion'];


 
 
//Antes de pasar los datos al PDF, hay que pasar las variables por la función html_entity_decode para decodificar los caracteres especiales, los acentos y las ñ 
// Siempre y cuando los datos extraídos de la BD sean UTF8 (no lo probe con otra codificación)
$nombre_proyec = html_entity_decode($row['nombre_proyec']); 
$nombre = html_entity_decode($row['nombre']);
 
 
//Creamos una nueva instancia de la clase
$pdf = new PDF();
 
// Aádimos la primera página
$pdf->AddPage();

$pdf->SetFont('Helvetica','',10);
$pdf->Ln(40);
$pdf->Line(10, 60, 200, 60);
$pdf->Cell(0,3,'Orden No. '.$row['id'],0,1,'R');
$pdf->Cell(0,5,'ORDEN DE MOVILIZACION',0,1,'C');
$pdf->SetFontSize(10);
 
// Otra parte importante, luego de pasar las variables por la función html_entity_decode, para que se vean bien los acentos y las ñ, hay que pasarlas por otra 
// función que es utf8_decode
 
//$pdf->WriteHTML(utf8_decode($nombre));
 
//La función WriteHTML es la que creamos anteriormente para que lea las etiquetas html como <br>, <b>, <i>, <p>, etc.
$pdf->Line(10,91, 200, 91);
$pdf->Cell(0,10,'DATOS DEL CONDUCTOR',0,1,'L');
$pdf->Cell(0,6,'Nombre: '.$row['nombre'],0,1);
$pdf->Cell(0,10,'Vehiculo: '.$row['vehiculo'],0,1);
$pdf->Cell(0,8,'Numero de Telefono: '.$row['telefono'],0,1);
$pdf->Cell(0,14,'ORDEN DE TRABAJO',0,1,'L');
$pdf->MultiCell(0,14,$name,0,1);
$pdf->Cell(0,18,'ESTATUS DE LA ORDEN: '.$row['estatus'],0,1); 
$pdf->Line(10,120, 200, 120); 
$pdf->Ln(110);
$pdf->SetLeftMargin(10);
$pdf->SetFontSize(10);

//$pdf->Line(10,120, 200, 120);

//$pdf->Line(10,225, 50, 225);
$pdf->Cell(0,0,'Firma del Conductor',0,1,'L');
$pdf->Cell(0,0,'Firma de Transporte',0,1,'C');
$pdf->Cell(0,0,'Firma en Destino',0,1,'R');
//$pdf->Cell(0,8,$row['usuarios'],0,1,'L');
//$pdf->Cell(0,,date('d/m/Y'),0,1,'R');
//Lo mismo que en la variable anterior, decodificamos la variable $html para que el texto se vea correctamente con los acentos y las ñ correspondientes.
 
//$pdf->WriteHTML(utf8_decode($vehiculo));
 

//Con OutPut hacemos que se visualice el PDF que acabamos de crear
$pdf->Output();


}

}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Conavia - Proyectos</title>
<style type="text/css">
	#map-canvas {position:fixed !important; position:absolute; top:0; left:1px; right:0; bottom:0; }
	.ITitle { font:Georgia, "Times New Roman", Times, serif; font-size:15px; }
	
.vname { 
	background:url(images/bg/u_online.gif) left no-repeat; 
	width:100%; 
	margin-bottom:3px; 
	font-size:12px; 
	font-family:Arial, Helvetica, sans-serif; 
	float:left; 
}
.vname a { text-decoration:none; color:#22cc22; margin:1px 1px 2px 18px; }
.vname a:hover { text-decoration:underline; color:#22cc22; margin:1px 1px 2px 18px; }

</style>

</head>

<script type="text/javascript">
function Ddialog(did) {
$("#Ddraggable").dialog({modal:true});	
document.getElementById("DID").value=did;
}

function Edialog(did) {
$("#Edraggable").dialog({modal:true});	
document.getElementById("EID").value=did;
}

</script>
<body style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">

</div>

<div id="map-canvas">


<style>
html, body
	{
		height: 100%;
		width: 100%;
		margin: 0px;
		padding: 0px;
		overflow: hidden;
	}
#iframe { width:100%; height:650px;; }
.ITitle { font:Georgia, "Times New Roman", Times, serif; font-size:15px; }
.lnk { 
	padding-top:2px;
	margin:2px;
	background:#0066FF url(images/bg/meun_out.gif) repeat-x;
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	font-weight:bold;
	width:60px;
	height:22px;
	float:left;
	border-radius:5px;
	border:1px solid #006;
	border-bottom:none;
	text-align:center;
}
a:hover .lnk { background:#0066FF url(images/bg/menu_over.gif) repeat-x; }
a:active .lnk { background:#0066FF url(images/bg/menu_over.gif) repeat-x; }
</style>



<div style="width:100%; height:100%; padding:1px; background:#ffffff;">
 
 <table width="100%" border="0">
    <tr> 
      <td bgcolor="#faed95"><div style="color:#000; font-weight:bold; background:url(images/top_bg2.gif) repeat-x;">:: Proyectos Activos</div></td>
    </tr>
    <tr>
      <td height="3px"></td>
    </tr>   
 <tr>
      <td> 
     
      <table width="100%" border="0">
        <tr style="color:#FFF; background:#5eb058; font-weight:bold;">
          <td width="30" align="left"  >NO</td>
          <td width="120" align="left" >Nombre Proyecto</td>
          <td width="120" align="left" >Ente Ejecutor</td>
          <td width="120" align="left" >Organismo Responsable</td>
          <td width="100" align="center" >Estatus Obra</td>
          <td width="250" align="left" >Descripción</td>
          <td width="100" align="left" >Fecha de Inicio</td>
          <td width="100" align="left" >Fecha Culminación</td>
          <td width="100" align="left" >Fecha Inaguración</td>
          <td width="100" align="center" >Acciones</td>

         </tr>
         </table>
         <div style="overflow: auto; height:400px; width: 100%; font-size:10px;">
         <table width="100%" border="0">
           <?php
		 if($GPSUSERNAME<>'0') 

                 $sql=mysql_query("SELECT * FROM proyecto JOIN proyecto_estatus ON proyecto_estatus.id_esta=proyecto.estatus_obra 
                                                            WHERE proyecto.responsable_proye='$GPSUSERNAME'
                                                           ORDER BY id ASC");
      
                 else

                 $sql=mysql_query("SELECT * FROM proyecto JOIN proyecto_estatus ON proyecto_estatus.id_esta=proyecto.estatus_obra 
                                                           ORDER BY id ASC");
                  
		  $i=1;
		  while($row=mysql_fetch_array($sql))
		  {
			  if($i%2==1) $color="#EEE"; else $color="#EEE";
			  echo '<form name="frmone" method="get" action="mostrar.php"><tr height="20" style="background:'.$color.'; font-size:11px;">
			  <td width="30" align="left">'.$row['id'].'</td>
			  <td width="120" align="left">'.$row['nombre_proyec'].'</td>
			  <td width="120" align="left">'.$row['nombre_ente_sol'].'</td>
			  <td width="120" align="left">'.$row['nombre_ente_contra'].'</td>
			  <td width="100" align="center">'.$row['estatus'].'</td>
			  <td width="250" align="left">'.$row['descripcion'].'</td>
			  <td width="100" align="center">'.$row['fecha_inicio'].'</td>			  
			  <td width="100" align="center">'.$row['fecha_estimada_cul'].'</td>
			  <td width="100" align="center">'.$row['fecha_estimada_ina'].'</td>
			  <td width="100" align="center"><input type="hidden" name="EDID" value="'.$row['id'].'">';
			  echo '<button type="submit" name="Edit" style="height:18px;"><img src="images/bg/edit.png" width="12" height="10"></button>
                                                   
                                                         <input type="hidden" name="EDID" value="'.$row['id'].'">';
			  echo '<button type="submit"  name="Print" style="height:18px;"><img src="images/bg/print.png" width="12" height="10"></button>';
				if($row['estatus']=='Activo')         
					echo '&nbsp;<button type="button" onclick="Ddialog('.$row['id'].')" name="Disable" style="height:18px;"><img src="images/bg/delete.png" width="12" height="10"></button>';
				else 
					echo '&nbsp;<button type="button" onclick="Edialog('.$row['id'].')" name="archivo" style="height:18px;"><img src="images/bg/enable.png" width="12" height="10"></button>';
			  echo '</td>
			  </tr></form>';
		  }
          ?>
      </table>
      </div>
      </td>
    </tr>
    <tr>
      <td height="3px"></td>
    </tr>
  </table>
</div>
</div>

