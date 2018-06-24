<?php
include('session.php');
include('phpsqlajax_dbinfo.php');
include("includes/savelog.php");



//if($GPSPRIVILEGE=='End-User') header('location:restricted.php');

session_start();

$sql=mysql_query("SELECT * FROM users WHERE id='$GPSUSERID'");
$result=mysql_fetch_array($sql);
$GPSUSERNAME=($result['login']);

$Add=$_GET['Add'];
$EDID=$_GET['EDID'];
$DID=$_GET['DID'];
$Save=$_GET['Save'];
$Edit=$_GET['Edit'];
$Delete=$_GET['Delete'];
$Print=$_GET['Print'];
$Cerrar=$_GET['Cerrar'];

$nombre=$_GET['nombre'];
$vehiculo=$_GET['vehiculo'];
$descripcion=$_GET['descripcion'];
$direccion=$_GET['direccion'];
$telefono=$_GET['telefono'];
$email=$_GET['email'];
$estatus3=$_GET['estatus'];
$estatus2='Cerrado';
$estatus='Activo';
$estatus_device='Asignado';
$estatus_device2='No Asignado';
$borrado='Funcional';
$borrado2='Borrado';

$FromDate=$_GET['FromDate'];
$ToDate=$_GET['ToDate'];

if(isset($FromDate)) $FromDate=$FromDate; else $FromDate=date("Y-m-d H:i:s");
if(isset($ToDate)) $ToDate=$ToDate; else $ToDate=date("Y-m-d H:i:s");

if(isset($Add))
{

			$sql=mysql_query("SELECT * FROM orden WHERE orden.vehiculo='$vehiculo' or orden.nombre='$nombre'");
                        $sql1=mysql_query("SELECT * FROM devices JOIN orden ON orden.nombre=devices.name WHERE devices.name='$vehiculo' ");
			$count=mysql_num_rows($sql); 
			if($count==0)
			{
				$sql=mysql_query("INSERT INTO orden (`vehiculo`,`nombre`,`descripcion`,`direccion`,`telefono`,
				`email`,`estatus`,`usuarios`,`borrado`,`fechaorden`) VALUES ('$vehiculo','$nombre','$descripcion','$direccion','$telefono','$email','$estatus','$GPSUSERNAME','$borrado','$FromDate')");
				
				$sql1=mysql_query("UPDATE devices SET  estatus_dev='$estatus_device' WHERE name='$vehiculo'");
	                 }

	

                        else
                          while($row=mysql_fetch_array($sql))
                           if($row['estatus']=='Cerrado')
                         {
				$sql=mysql_query("INSERT INTO orden (`vehiculo`,`nombre`,`descripcion`,`direccion`,`telefono`,
				`email`,`estatus`,`usuarios`,`borrado`,`fechaorden`) VALUES ('$vehiculo','$nombre','$descripcion','$direccion','$telefono','$email','$estatus','$GPSUSERNAME','$borrado','$FromDate')");
                                $sql1=mysql_query("UPDATE devices SET  estatus_dev='$estatus_device' WHERE name='$vehiculo'");
}
else $ermsg="Esta este vehiculo ya tiene orden de trabajo existente en el sistema. Inténtelo de nuevo !";
}

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
$sql=("SELECT * FROM orden WHERE id='$id'"); //Hacemos la consulta a la base de datos
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
<title>Movilización de Vehiculos</title>
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

</head>

<body style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">

</div>

<div id="map-canvas">
<div style="width:100%;; padding:5px; background:#ffffff;">
<table width="100%" border="0">
  <tr>
    <td bgcolor="#000000"><div style="color:#FFF; font-weight:bold; background:url(images/top_bg.gif) repeat-x;">:: CREAR ORDEN DE TRABAJO</div></td>
  </tr>
  <tr>
    <td><div style="font-size:12px; color:#F00; font-weight:bold;"><?php echo $ermsg;?></div></td>
  </tr>
  <tr>
    <td>
    <form name="frmset" method="get" action="ordentrabajo.php">
    <table width="100%" border="0">
      <tr>
        <td width="200" align="left">Introduzca Nombre del Conductor</td>
        <td align="left"><label for="nombre"></label>
          <input type="text" name="nombre" id="nombre" value="<?php echo $ENombre;?>" placeholder="Nombre de Conductor" required="required" /> 
          <font color="#FF0000">*</font></td>
      </tr>

       <tr>
        <td align="left">Seleccione Vehículo</td>
        <td align="left">
        <select name="vehiculo" id="vehiculo">

        <?php 
		if(isset($EDID))
		echo '<option value="'.$EtypeId.'">'.$Etype.'</option>';
		else
		echo '<option value="0">- Seleccione Tipo del vehiculo -</option>';
		$sql=mysql_query("SELECT * FROM devices WHERE estatus_dev='No Asignado' ");
        while($row=mysql_fetch_array($sql))
		{    
		echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
		}
		


//////////////////////////////////////////////////////////////////
////		if($GPSPRIVILEGE=='admin')
//		{
	//		$sql=mysql_query("SELECT * FROM devices");
		//	while($row=mysql_fetch_array($sql))
		//	{
		////	if($row['estatus_dev']=='No Asignado')
                     //   	echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';	
		//	//}
		//}
		//else
		//{
	//		$sql=mysql_query("SELECT * FROM users_devices JOIN devices ON devices.id=users_devices.devices_id WHERE users_id='$GPSUSERID' ");
			//while($row=mysql_fetch_array($sql))
			//{
			//	echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';	
			//}
		//}			
		?>
        </select>         
          <font color="#FF0000">*</font></td>
      </tr>
      <tr>
        <td align="left">Introduzca Descripción</td>
        <td align="left"><label for="descripcion"></label>
          <textarea name="descripcion" id="descripcion" cols="40" rows="3"><?php echo $EDescripcion; ?></textarea></td>
      </tr>
      <tr>
        <td align="left">Introduzca la Dirección</td>
        <td align="left"><input name="direccion" type="text" id="direccion" size="40" value="<?php echo $EDireccion; ?>" placeholder="Dirección" /></td>
      </tr>
      <tr>
        <td align="left">Ingresa el Número de Teléfono(s)</td>
       <td align="left"><label for="telefono"></label>
          <input type="text" name="telefono" id="telefono" size="40" value="<?php echo $ETelefono;?>" placeholder="Telefono" required="required" /> 
          <font color="#FF0000">*</font></td>

      </tr>
      <tr>
        <td align="left">Introduzca su Dirección de Correo Electrónico</td>
        <td align="left">
        <input name="email" type="email" id="email" size="40" value="<?php echo $EEmail; ?>" placeholder="Correo Electrónico"/>
        <input name="EDID" type="hidden" id="EDID" value="<?php echo $EDID; ?>"/>
        </td>
      </tr>

      <tr>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">&nbsp;</td>
        <td align="left">
           

       <?php
		if(isset($_GET['Edit']) and ($GPSPRIVILEGE=='admin') )
        echo '<input type="submit" name="Cerrar" id="Save" value="Cerrar Orden de Trabajo" />';
           ?>

        <?php
		if(isset($_GET['Edit']))
        echo '<input type="submit" name="Save" id="Save" value="Actualizar Orden de Trabajo" />';

		else
        echo '<input type="submit" name="Add" id="Add" value="Agregar Orden de Trabajo" />';
		?>
        </td>
      </tr>
    </table></form>
    </td>
  </tr>
</table>

</div>
<br />
<div style="width:100%; padding:1px; background:#ffffff;">
  <table width="100%" border="0">
    <tr>
      <td bgcolor="#000000"><div style="color:#FFF; font-weight:bold; background:url(images/top_bg.gif) repeat-x;">:: Ordenes de Trabajos Activas</div></td>
    </tr>
    <tr>
      <td height="3px"></td>
    </tr>
    <tr>
      <td> 
     
      <table width="100%" border="0">
        <tr style="color:#FFF; background:#000; font-weight:bold;">
          <td width="50" align="left"  >NO</td>
          <td width="100" align="left" >NOMBRE DEL CONDUCTOR</td>
          <td width="120" align="left" >VEHICULO</td>
          <td width="200" align="left" >DIRECCION</td>
          <td width="100" align="left" >TELEFONO</td>
          <td width="150" align="left" >CORREO ELECTRONICO</td>
          <td width="100" align="center" >ESTATUS</td>
          <td width="450" align="left" >DESCRIPCION</td>
          <td width="150" align="center" >ACCIONES</td>

         </tr>
         </table>
         <div style="overflow: auto; height:200px; width: 100%; font-size:10px;">
         <table width="100%" border="0">
          <?php
		  $sql=mysql_query("SELECT * FROM orden WHERE borrado='Funcional'  ORDER BY id ASC");
		  $i=1;
		  while($row=mysql_fetch_array($sql))
		  {
			  if($i%2==1) $color="#fff"; else $color="#ddd";
			  echo '<form name="frmone" method="get" action="ordentrabajo.php"><tr height="20" style="background:'.$color.'; font-size:12px;">
			  <td width="50" align="left">'.$row['id'].'</td>
			  <td width="100" align="left">'.$row['nombre'].'</td>
			  <td width="120" align="left">'.$row['vehiculo'].'</td>
			  <td width="200" align="left">'.$row['direccion'].'</td>
			  <td width="100" align="left">'.$row['telefono'].'</td>
			  <td width="150" align="left">'.$row['email'].'</td>
			  <td width="100" align="center">'.$row['estatus'].'</td>			  
			  <td width="450" align="left">'.$row['descripcion'].'</td>
			  <td width="150" align="center"><input type="hidden" name="EDID" value="'.$row['id'].'">';
			  echo '<button type="submit" name="Edit" style="height:15px;"><img src="images/bg/edit.png" width="12" height="10"></button>
                                                   
                                                         <input type="hidden" name="EDID" value="'.$row['id'].'">';
			  echo '<button type="submit"  name="Print" style="height:15px;"><img src="images/bg/print.png" width="12" height="10"></button>';
				if($row['estatus']=='Activo')         
					echo '&nbsp;<button type="button" onclick="Ddialog('.$row['id'].')" name="Disable" style="height:15px;"><img src="images/bg/delete.png" width="12" height="10"></button>';
				else 
					echo '&nbsp;<button type="button" onclick="Edialog('.$row['id'].')" name="Enable" style="height:15px;"><img src="images/bg/enable.png" width="12" height="10"></button>';
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


<div title=":: Eliminar Orden" id="Ddraggable" class="ui-widget-content">
  <div style="margin-top:30px; text-align:left; font-size:14px; font-weight:bold; color:#000;">
 ¿Está seguro que desea eliminar esta Orden de Trabajo?
  </div>
<div style="text-align:center; margin-top:30px;">
<form name="popupfrm" method="get" action="ordentrabajo.php" style="background:transparent; border:none;">
<input type="hidden" name="DID" id="DID" />
<input style="width:50px; height:30px; box-shadow:1px 1px 2px #000000; border-radius:5px;" name="Delete" type="submit" value="Yes" />
&nbsp;&nbsp;&nbsp;
<input type="submit" style="width:50px; box-shadow:1px 1px 2px #000000; height:30px; border-radius:5px;" value="No" />
</form>
</div>
</div>

</body>
</html>


