<?php
include('session.php');
include('phpsqlajax_dbinfo_conavia.php');
include("includes/savelog.php");



//if($GPSPRIVILEGE=='End-User') header('location:restricted.php');

//session_start();

//$sql=mysql_query("SELECT * FROM users WHERE id='$GPSUSERID'");
//$result=mysql_fetch_array($sql);
//$GPSUSERNAME=($result['login']);

$Add=$_POST['Add'];
$Add_detalle=$_POST['Add_detalle'];
$Add_detalle2=$_POST['Add_detalle2'];
$EDID=$_GET['EDID'];
$DID=$_GET['DID'];
$Save=$_GET['Save'];
$Edit=$_GET['Edit'];
$Delete=$_GET['Delete'];
$Print=$_GET['Print'];
$Cerrar=$_GET['Cerrar'];

$nombre_proyec=$_POST['nombre'];
$nombre_ente_contra=$_POST['nombre_contra'];
$nombre_ente_sol=$_POST['nombre_sol'];
$rif_ente_contra=$_POST['ente_contra'];
$rif_ente_sol=$_POST['ente_sol'];
$descripcion=$_POST['descripcion'];
$fecha_actual=$_POST['theDate_act'];
$estado=$_POST['estado'];
$municipio=$_POST['municipio'];
$parroquia=$_POST['parroquia'];
$sector=$_POST['sector'];
$fecha_inicio=$_POST['theDate'];
$fecha_estimada_cul=$_POST['theDate_cul'];
$fecha_estimada_ina=$_POST['theDate_ina'];
$estatus_obra=$_POST['estatus_obra'];
$consejo_comunal=$_POST['consejo_comu'];
$comuna=$_POST['comuna'];
$coordenadas_ini_este=$_POST['coor_inicio_este'];
$coordenadas_ini_norte=$_POST['coor_inicio_norte'];
$coordenadas_fina_este=$_POST['coor_fina_este'];
$coordenadas_fina_norte=$_POST['coor_fina_norte'];
$categoria1=$_POST['acondi'];
$categoria2=$_POST['engranzo'];
$categoria3=$_POST['pavi_R'];
$categoria4=$_POST['pavi_Flex'];
$categoria5=$_POST['obras_dre'];
$categoria6=$_POST['contencion'];
$responsable_proye=$_POST['responsables'];
$poblacion_benefi=$_POST['Poblacion_benefi'];
$produccion=$_POST['Produccion'];
$rubros1=$_POST['rubros1'];
$rubros2=$_POST['rubros2'];
$rubros3=$_POST['rubros3'];
$tiempo_ejecucion=$_POST['tiempo_eje'];
$monto_total=$_POST['monto_total'];
$etapas_proyec=$_POST['descripcion2'];



$num_habitantes=$_POST['numero_hab'];
$num_familias=$_POST['numero_fam'];
$num_produc=$_POST['numero_pro'];


$km_programa=$_POST['KM_pro'];
$km_ejecutado=$_POST['KM_Eje'];
$km_por_ejecutar=$_POST['KM_por_Eje'];
$avance_fisico=$_POST['ava_fisi'];
$avance_fisico_por_eje=$_POST['ava_fisi_eje'];
$avance_finan_ejecu=$_POST['ava_fin'];


$FromDate=$_GET['FromDate'];
$ToDate=$_GET['ToDate'];

if(isset($FromDate)) $FromDate=$FromDate; else $FromDate=date("Y-m-d H:i:s");
if(isset($ToDate)) $ToDate=$ToDate; else $ToDate=date("Y-m-d H:i:s");

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(isset($Add))
{

			$sql=mysql_query("SELECT * FROM proyecto");                       
			$count=mysql_num_rows($sql); 
			if($count==0)
			{
$sql=mysql_query("INSERT INTO proyecto(`nombre_proyec`,`nombre_ente_contra`,`nombre_ente_sol`,`codigo_situr`,`rif_ente_sol`,`descripcion`,`fecha_actual`,`estado`,
 `municipio`,`parroquia`,`sector`,`fecha_inicio`,`fecha_estimada_cul`,`fecha_estimada_ina`,`estatus_obra`,`consejo_comunal`,
 `comuna`,`coordenadas_ini_este`,`coordenadas_ini_norte`,`coordenadas_fina_este`,`coordenadas_fina_norte`,`categoria1`,
 `categoria2`,`categoria3`,`categoria4`,`categoria5`,`categoria6`,`responsable_proye`,`poblacion_benefi`,`produccion`,
 `rubros1`,`rubros2`,`rubros3`,`tiempo_ejecucion`,`monto_total`,`etapas_proyec`) VALUES ('$nombre_proyec','$nombre_ente_contra','$nombre_ente_sol','$rif_ente_contra','$rif_ente_sol','$descripcion','$fecha_actual','$estado',
 '$municipio','$parroquia','$sector','$fecha_inicio','$fecha_estimada_cul','$fecha_estimada_ina','$estatus_obra','$consejo_comunal',
 '$comuna','$coordenadas_ini_este','$coordenadas_ini_norte','$coordenadas_fina_este','$coordenadas_fina_norte','$categoria1',
 '$categoria2','$categoria3','$categoria4','$categoria5','$categoria6','$responsable_proye','$poblacion_benefi','$produccion',
 '$rubros1','$rubros2','$rubros3','$tiempo_ejecucion','$monto_total','$etapas_proyec')");

	                 }
				else
$sql=mysql_query("INSERT INTO proyecto(`nombre_proyec`,`nombre_ente_contra`,`nombre_ente_sol`,`codigo_situr`,`rif_ente_sol`,`descripcion`,`fecha_actual`,`estado`,
 `municipio`,`parroquia`,`sector`,`fecha_inicio`,`fecha_estimada_cul`,`fecha_estimada_ina`,`estatus_obra`,`consejo_comunal`,
 `comuna`,`coordenadas_ini_este`,`coordenadas_ini_norte`,`coordenadas_fina_este`,`coordenadas_fina_norte`,`categoria1`,
 `categoria2`,`categoria3`,`categoria4`,`categoria5`,`categoria6`,`responsable_proye`,`poblacion_benefi`,`produccion`,
 `rubros1`,`rubros2`,`rubros3`,`tiempo_ejecucion`,`monto_total`,`etapas_proyec`) VALUES ('$nombre_proyec','$nombre_ente_contra','$nombre_ente_sol','$rif_ente_contra','$rif_ente_sol','$descripcion','$fecha_actual','$estado',
 '$municipio','$parroquia','$sector','$fecha_inicio','$fecha_estimada_cul','$fecha_estimada_ina','$estatus_obra','$consejo_comunal',
 '$comuna','$coordenadas_ini_este','$coordenadas_ini_norte','$coordenadas_fina_este','$coordenadas_fina_norte','$categoria1',
 '$categoria2','$categoria3','$categoria4','$categoria5','$categoria6','$responsable_proye','$poblacion_benefi','$produccion',
 '$rubros1','$rubros2','$rubros3','$tiempo_ejecucion','$monto_total','$etapas_proyec')");
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(isset($Add_detalle))
{

			$sql=mysql_query("SELECT * FROM impacto_obra"); 
			$sql1=mysql_query("SELECT * FROM estatus_fisico");                    
			$count=mysql_num_rows($sql and $sql1); 
			if($count==0)
			{
$sql=mysql_query("INSERT INTO impacto_obra(`num_habitantes`,`num_familias`,`num_produc`) 
         VALUES ('$num_habitantes','$num_familias','$num_produc')");

$sql1=mysql_query("INSERT INTO estatus_fisico(`km_programa`,`km_ejecutados`,`km_por_ejecutar`,`avanse_fisico`,`avanse_fisico_por_eje`,`avanse_finan_ejecu`) 
         VALUES ('$km_programa','$km_ejecutado','$km_por_ejecutar','$avance_fisico','$avance_fisico_por_eje','$avance_finan_ejecu')");

	                 }
				else
$sql=mysql_query("INSERT INTO impacto_obra(`num_habitantes`,`num_familias`,`num_produc`) 
         VALUES ('$num_habitantes','$num_familias','$num_produc')");

$sql1=mysql_query("INSERT INTO estatus_fisico(`km_programa`,`km_ejecutados`,`km_por_ejecutar`,`avanse_fisico`,`avanse_fisico_por_eje`,`avanse_finan_ejecu`) 
         VALUES ('$km_programa','$km_ejecutado','$km_por_ejecutar','$avance_fisico','$avance_fisico_por_eje','$avance_finan_ejecu')");


}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(isset($Add_detalle2))
{

                        $sql1=mysql_query("SELECT * FROM estatus_fisico");                      
			$count=mysql_num_rows($sql1); 
			if($count==0)
			{

$sql1=mysql_query("INSERT INTO estatus_fisico(`km_programa`,`km_ejecutados`,`km_por_ejecutar`,`avanse_fisico`,`avanse_fisico_por_eje`,`avanse_finan_ejecu`) 
         VALUES ('$km_programa','$km_ejecutado','$km_por_ejecutar','$avance_fisico','$avance_fisico_por_eje','$avance_finan_ejecu')");
}

                       else

$sql1=mysql_query("INSERT INTO estatus_fisico(`km_programa`,`km_ejecutados`,`km_por_ejecutar`,`avanse_fisico`,`avanse_fisico_por_eje`,`avanse_finan_ejecu`) 
         VALUES ('$km_programa','$km_ejecutado','$km_por_ejecutar','$avance_fisico','$avance_fisico_por_eje','$avance_finan_ejecu')");


}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(isset($Save))
{

			$sql=mysql_query("SELECT * FROM orden WHERE nombre='$nombre' AND id=='$EDID'");
                        $sql1=mysql_query("SELECT * FROM devices JOIN orden ON orden.nombre=devices.name WHERE devices.name='$vehiculo' ");
			$count=mysql_num_rows($sql);
			if($count==0)
			{

				$sql=mysql_query("UPDATE orden SET  vehiculo='$vehiculo',nombre='$nombre',descripcion='$descripcion',
                                                  direccion='$direccion',telefono='$telefono',
				                  email='$email',estatus='$estatus',usuarios='$GPSUSERNAME',fechaorden='$FromDate'  WHERE id='$EDID'");
                                $sql1=mysql_query("UPDATE devices SET  estatus_dev='$estatus_device' WHERE name='$vehiculo'");
								

			}
			else
			$ermsg="Este nombre de usuario ya existe en el sistema. Inténtelo de nuevo !";

}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(isset($Cerrar))
{

			$sql=mysql_query("SELECT * FROM orden WHERE nombre='$nombre' AND id=='$EDID'");
                        $sql1=mysql_query("SELECT * FROM devices JOIN orden ON orden.nombre=devices.name WHERE devices.name='$vehiculo' ");
			$count=mysql_num_rows($sql);
                      
			if($count==0)
                             {
                              
				$sql=mysql_query("UPDATE orden SET  vehiculo='$vehiculo',nombre='$nombre',descripcion='$descripcion',
                                                  direccion='$direccion',telefono='$telefono',
				                  email='$email',estatus='Cerrado',usuarios='$GPSUSERNAME'  WHERE id='$EDID'");
                                $sql1=mysql_query("UPDATE devices SET  estatus_dev='$estatus_device2' WHERE name='$vehiculo'");
							

			}
			else


			$ermsg="Este nombre de usuario ya existe en el sistema. Inténtelo de nuevo !";

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(isset($Delete))
{
$sql=mysql_query("UPDATE orden SET  borrado='$borrado2', estatus='$estatus2' WHERE id='$DID'");
$sql1=mysql_query("UPDATE devices JOIN orden ON devices.name=orden.vehiculo SET  estatus_dev='$estatus_device2' WHERE devices.name=orden.vehiculo and orden.id='$DID'");

}

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
$sql=("SELECT * FROM orden WHERE id='$id'"); //Hacemos la consulta a la base de datos
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
$vehiculo = html_entity_decode($row['vehiculo']); 
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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(isset($_GET['Edit']))
{
	$sql=mysql_query("SELECT * FROM orden WHERE id='".$_GET['EDID']."'");
	$result=mysql_fetch_array($sql);
	
	$ENombre=$result['nombre'];
        $EtypeId=$result['vehiculo'];
	$Etype=$result['vehiculo'];
	$EDescripcion=$result['descripcion'];
	$EDireccion=$result['direccion'];
	$ETelefono=$result['telefono'];
	$EEmail=$result['email'];

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/smoothness/jquery-ui-1.8.2.custom.css" />
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script> 
<script type="text/javascript" src="js/jquery-ui-1.8.2.custom.min.js"></script>
<title>Conavia</title>
<style type="text/css">
#Ddraggable { display:none; }
#Edraggable { display:none; }
</style>


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

<link type="text/css" rel="stylesheet" href="dhtmlgoodies_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
	<SCRIPT type="text/javascript" src="dhtmlgoodies_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>

</head>

<body style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">

</div>

<div id="map-canvas">
<div style="width:100%; height:100%; padding:0px; background:#ffffff; overflow: auto;">
<table width="100%" height="30%" border="0">
  <tr>
    <td bgcolor="#faed95"><div style="color:#000; font-weight:bold; background:url(images/top_bg.gif) repeat-x;">:: FICHA DE PROYECTO</div></td>
  </tr>
  <tr>
    <td><div style="font-size:12px; color:#F00; font-weight:bold;"><?php echo $ermsg;?></div></td>
  </tr>
  <tr>
    <td>
    <form name="frmset" method="post" action="proyecto.php">
<fieldset style="border: 3px solid #5eb058;">
<legend align= "left">Ficha Proyecto</legend>
    <table  align="left" width="100%" height="20%" border="0">
      <tr>
        <td width="200" align="left">Introduzca Nombre del Proyecto</td>
       <td align="left"><label for="nombre"></label>
          <textarea name="nombre" id="nombre" cols="40" rows="5"><?php echo @$_POST[nombre]?></textarea></td>

        <td>Fecha de Carga(DD-MM-YYYY): </td>
        <td><input type="text" size="30" value="" readonly name="theDate_act"><input type="button" value="Cal" onclick="displayCalendar(document.forms[0].theDate_act,'dd-mm-yyyy',this)"></td>

      </tr>
      <tr>
        <td width="200" align="left">Organismo Responsable</td>
        <td align="left"><label for="nombre_contra"></label>
          <input type="text" size="38" name="nombre_contra" id="nombre_contra" value="<?php echo @$_POST[nombre_contra]?>" placeholder="Organismo Responsable"/> 
          </td>
          
        <td width="200"align="left">Código Situr</td>
        <td align="left"><label for="ente_contra"></label>
          <input type="text" name="ente_contra" id="ente_contra" value="<?php echo @$_POST[ente_contra]?>" placeholder="Código Situr" required="required" />  
         <font color="#FF0000">*</font></td>

      </tr>

      <tr>
        <td width="200" align="left">Ente Ejecutor</td>
        <td align="left"><label for="nombre_sol"></label>
          <input type="text" size="38" name="nombre_sol" id="nombre_sol" value="<?php echo @$_POST[nombre_sol]?>" placeholder="Ente Ejecutor" required="required" /> 
          <font color="#FF0000">*</font></td>

        <td width="200"align="left">Ente Ejecutor RIF</td>
        <td align="left"><label for="ente_sol"></label>
          <input type="text" name="ente_sol" id="ente_sol" value="<?php echo @$_POST[ente_sol]?>" placeholder="Ente Ejecutor RIF" required="required" /> 
         (G-XXXXXXXX-X) 
         <font color="#FF0000">*</font></td>
     </tr>


      <tr>
        <td align="left">Introduzca Descripción</td>
        <td align="left"><label for="descripcion"></label>
          <textarea name="descripcion" id="descripcion" cols="40" rows="5"><?php echo @$_POST[descripcion]?></textarea></td>

        <td align="left">Etapas del Proyecto</td>
        <td align="left"><label for="descripcion2"></label>
          <textarea name="descripcion2" id="descripcion2" cols="40" rows="5"><?php echo @$_POST[descripcion2]?></textarea></td>

       </tr>


       <tr>
        <td align="left">Seleccione Estado</td>
        <td align="left">
        <select name="estado" id="estado"  onchange="this.form.submit()" value="<?php echo @$_POST[estado]?>">

        <?php 
 
                      if(isset($_POST["estado"]))
                $estado=$_POST["estado"];
                   $sql2=mysql_query("SELECT * FROM estado where id=".$estado."");
	 while($row=mysql_fetch_array($sql2))
		{    
		echo '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';
		}
		$sql=mysql_query("SELECT * FROM estado");
        while($row=mysql_fetch_array($sql))
		{    
		echo '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';
		}
		

      
		?>
        </select>         
          <font color="#FF0000">*</font></td>
      </tr>

       <tr>
        <td align="left">Seleccione Municipio</td>
        <td align="left">
        <select name="municipio" id="municipio"  onchange="this.form.submit()" value="<?php echo @$_POST[municipio]?>">


        <?php 
		if(isset($_POST["estado"]))
                $estado=$_POST["estado"];
                 if(isset($_POST["municipio"]))
                $municipio=$_POST["municipio"];
                   $sql2=mysql_query("SELECT * FROM municipio where id=".$municipio."");
	         while($row=mysql_fetch_array($sql2))
		{    
		echo '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';
		}

                $re1=mysql_query("SELECT * FROM municipio WHERE estado_id=".$estado."");
               while($row=mysql_fetch_array($re1))
		{    
		echo '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';

		}
			
		?>
        </select>         
          <font color="#FF0000">*</font></td>
      </tr>

       <tr>
        <td align="left">Seleccione Parroquia</td>
        <td align="left">
        <select name="parroquia" id="parroquia" value="<?php echo @$_POST[parroquia]?>">

        <?php 
		if(isset($_POST["municipio"]))
                $municipio=$_POST["municipio"];
                //echo '<option value="0">- Seleccione Parroquia -</option>'; 
                $re1=mysql_query("SELECT * FROM parroquia WHERE municipio_id=".$municipio."");
               while($row=mysql_fetch_array($re1))
		{    
		echo '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';
		}
			
		?>
        </select>         
          <font color="#FF0000">*</font></td>

</tr>
      <tr>
        <td width="200" align="left">Introduzca Sector</td>
        <td align="left"><label for="sector"></label>
          <input type="text" size="38" name="sector" id="sector" value="<?php echo @$_POST[sector]?>" placeholder="Sector" required="required" /> 
          <font color="#FF0000">*</font></td>
        <td width="200" align="left">Estatus de la Obra</td>
        <td align="left">
        <select name="estatus_obra"  id="estatus_obra" value="<?php echo @$_POST[estatus_obra]?>" >

        <?php 

		if(isset($_POST["estatus_obra"]))
                $estatus_obra=$_POST["estatus_obra"];
                echo '<option value="">- Seleccione Estatus -</option>'; 
                $re1=mysql_query("SELECT * FROM proyecto_estatus");
               while($row=mysql_fetch_array($re1))
		{    
		echo '<option value="'.$row['id_esta'].'">'.$row['estatus'].'</option>';
		}

      
		?>
        </select>         
          <font color="#FF0000">*</font></td>


      </tr>

      <tr>
        <td width="200" align="left">Consejo Comunal</td>
        <td align="left"><label for="consejo_comu"></label>
          <input type="text" size="38" name="consejo_comu" id="consejo_comu" value="<?php echo @$_POST[consejo_comu]?>" placeholder="Consejo Comunal" required="required" /> 
          <font color="#FF0000">*</font></td>

       <td width="200" align="left">Coordenada de Inicio</td>
        <td align="left"><label for="coor_inicio_este"></label>
          <input type="text" size="30" name="coor_inicio_este" id="coor_inicio_este" value="<?php echo @$_POST[coor_inicio_este]?>" placeholder="Coordenada Inicio ESTE" required="required" /> 
        <input type="text" size="30" name="coor_inicio_norte" id="coor_inicio_norte" value="<?php echo @$_POST[coor_inicio_norte]?>" placeholder="Coordenada Inicio NORTE"/>
          <font color="#FF0000">*</font></td> 

   </tr>

      <tr>
        <td width="200" align="left">Comuna</td>
        <td align="left"><label for="comuna"></label>
          <input type="text" size="38" name="comuna" id="comuna" value="<?php echo @$_POST[comuna]?>" placeholder="Comuna" required="required" /> 
          <font color="#FF0000">*</font></td>

       <td width="200" align="left">Coordenada de Finalización</td>
        <td align="left"><label for="coor_fina_este"></label>
          <input type="text" size="30" name="coor_fina_este" id="coor_fina_este" value="<?php echo @$_POST[coor_fina_este]?>" placeholder="Coordenada Finalización ESTE" required="required" /> 
        <input type="text" size="30" name="coor_fina_norte" id="coor_fina_norte" value="<?php echo @$_POST[coor_fina_norte]?>" placeholder="Coordenada Finalización NORTE"/>
          <font color="#FF0000">*</font></td> 
      </tr>

	<tr>
        <td>Fecha Inicio (DD-MM-YYYY): </td>
        <td><input type="text" size="28" value="" readonly name="theDate"><input type="button" value="Cal" onclick="displayCalendar(document.forms[0].theDate,'dd-mm-yyyy',this)"></td></tr>

	<tr>
        <td>Fecha Estimada Culminacion (DD-MM-YYYY): </td>
        <td><input type="text" size="28" value="" readonly name="theDate_cul"><input type="button" value="Cal" onclick="displayCalendar(document.forms[0].theDate_cul,'dd-mm-yyyy',this)"></td></tr>

	<tr>
        <td>Fecha Estimada Inagurar (DD-MM-YYYY): </td>
        <td><input type="text" size="28" value="" readonly name="theDate_ina"><input type="button" value="Cal" onclick="displayCalendar(document.forms[0].theDate_ina,'dd-mm-yyyy',this)"></td>

<table  align="left" width="50%" border="0">  
     <td><fieldset style="border: 3px solid #5eb058;">
     <legend align= "left">Categoria</legend>

                 Acondicionamiento<br/>
                 <input type="text"  size="25" name="acondi" id="acondi" value="<?php echo @$_POST[acondi]?>" placeholder="Acondicionamiento">(Meta Fisica (M))
                 <br/>     
                 Engranzonado<br/>
                 <input type="text"  size="25" name="engranzo" id="engranzo" value="<?php echo @$_POST[engranzo]?>" placeholder="Engranzonado">(Meta Fisica (M))
                 <br/>                   
                 Pavimento Rígido<br/>
                 <input type="text" size="25" name="pavi_R" id="pavi_R" value="<?php echo @$_POST[pavi_R]?>" placeholder="Pavimento Rígido">(Meta Fisica (M))
                 <br/>                   
                 Pavimento Flexible<br/>
                 <input type="text" size="25" name="pavi_Flex" id="pavi_Flex" value="<?php echo @$_POST[pavi_Flex]?>" placeholder="Pavimento Flexible">(Meta Fisica (M))
                 <br/>                   
                 Obras de Drenaje<br/>
                 <input type="text" size="25" name="obras_dre" id="obras_dre" value="<?php echo @$_POST[obras_dre]?>" placeholder="Obras de Drenaje">(Meta Fisica (M))
                 <br/>                   
                 Contención<br/>
                 <input type="text" size="25" name="contencion" id="contencion" value="<?php echo @$_POST[contencion]?>" placeholder="Contención">(Meta Fisica (M))
 
  
      </td>


     <table  align="left" width="650px"  border="0">  
     <td><fieldset style="border: 3px solid #5eb058;">
     <legend align= "left">Responsables del Proyecto</legend>

        Responsable del Proyecto
        <select name="responsables" id="responsables"  value="<?php echo @$_POST[responsables]?>" >

        <?php 

		if(isset($_POST["responsables"]))
                $estatus_obra=$_POST["responsables"];
                echo '<option value="">- Seleccione Responsable -</option>'; 
                $re1=mysql_query("SELECT * FROM responsables");
               while($row=mysql_fetch_array($re1))
		{    
		echo '<option value="'.$row['id_resp'].'">'.$row['nombre_resp'].'</option>';
		}

      
		?>
        </select>   
         <font color="#FF0000">*</font></td>

  

      </td>

</tr>
    <table  align="left" width="650px" border="0">  
 <form name="frmset" method="post" action="proyecto.php">
     <td><fieldset style="border: 3px solid #5eb058;">
     <legend align= "left">Indicadores de Impacto</legend>
                 Población Beneficiada <input type="text" size="30" name="Poblacion_benefi" id="Poblacion_benefi" value="<?php echo @$_POST[Poblacion_benefi]?>" placeholder="N° habitantes" required="required" /> 
          <font color="#FF0000">*</font>
                 <br>
                 Producción (Tm)<input type="text" name="Produccion" id="Produccion" value="<?php echo @$_POST[Produccion]?>" placeholder="Producción">
                 <br>
                 Rubros<input type="text" size="15" name="rubros1" id="rubros1" value="<?php echo @$_POST[rubros1]?>" placeholder="Rubros">
                       <input type="text" size="15" name="rubros2" id="rubros2" value="<?php echo @$_POST[rubros2]?>" placeholder="Rubros">
                       <input type="text" size="15" name="rubros3" id="rubros3" value="<?php echo @$_POST[rubros3]?>" placeholder="Rubros">

 

      </td>
</tr>

 <table  align="left" width="658px" border="0">  
 <form name="frmset" method="post" action="proyecto.php">
     <td><fieldset style="border: 3px solid #5eb058;">
     <legend align= "left">Información Financiera</legend>
                 Tiempo Estimado de Ejecución (Meses) <input type="text" size="30" name="tiempo_eje" id="tiempo_eje" value="<?php echo @$_POST[tiempo_eje]?>" placeholder="Tiempo Ejecución" required="required" /> 
          <font color="#FF0000">*</font>
                 <br/>
<br/>
                 Monto Total Calculado (Bs)<input type="text" name="monto_total" id="monto_total" value="<?php echo @$_POST[monto_total]?>" placeholder="Monto Total">
                 <br/>
                 


      </td>
      </tr>


      <tr>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
     </tr>
      <tr>
 <table  align="center" width="15%" border="0">  
 <form name="frmset" method="post" action="proyecto.php">
     <td><fieldset style="border: 0px solid #5eb058;">

 

       <?php
		if(isset($_GET['Edit']) and ($GPSPRIVILEGE=='admin') )
        echo '<input type="submit" name="Cerrar" id="Save" value="Cerrar Orden de Trabajo" />';
           ?>

        <?php
		if(isset($_GET['Edit']))
        echo '<input type="submit" name="Save" id="Save" value="Actualizar Orden de Trabajo" />';

		else
        echo '<input type="submit" name="Add" id="Add" value="Agregar Proyecto" />';
		?>

        </td>
      </tr>
    </table></form>
    </td>
  </tr>
</table>
</table>
</table>
</fieldset>
     </fieldset>
     </fieldset>
     </fieldset>
     </fieldset>
     </fieldset>


