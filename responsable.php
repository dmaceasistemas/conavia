<?php
include('session.php');
include('phpsqlajax_dbinfo_conavia.php');
include("includes/savelog.php");
include("libs/mysql.inc.php");

if($GPSPRIVILEGE=='End-User') header('location:restricted.php');

session_start();

$sql=mysql_query("SELECT * FROM users WHERE id_user='$GPSUSERID'");
$result=mysql_fetch_array($sql);
$GPSUSERNAME=strtoupper($result['login']);

$Add=$_POST['Add'];
$Add_USUARIO=$_POST['Add_USUARIO'];
$Add_detalle2=$_POST['Add_detalle2'];
$EDID=$_GET['EDID'];
$DID=$_GET['DID'];
$Save=$_GET['Save'];
$Edit=$_GET['Edit'];
$Delete=$_GET['Delete'];
$Print=$_GET['Print'];
$Cerrar=$_GET['Cerrar'];

$nombre_resp=strtoupper($_POST['nombre_resp']);
$unidad_adscrita=$_POST['unidad_adscri'];
$cargo=$_POST['cargo'];
$telefono=$_POST['telefono'];
$correo=$_POST['email'];


$user=$_POST['user'];
$privilege=$_POST['privilege'];
$password=$_POST['password'];
$repassword=$_POST['repassword'];
$description=$_POST['description'];
$address=$_POST['address'];
$telephone=$_POST['telephone'];
$email2=$_POST['email2'];
$responsable=$_POST['responsables2'];

$FromDate=$_GET['FromDate'];
$ToDate=$_GET['ToDate'];

if(isset($FromDate)) $FromDate=$FromDate; else $FromDate=date("Y-m-d H:i:s");
if(isset($ToDate)) $ToDate=$ToDate; else $ToDate=date("Y-m-d H:i:s");

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(isset($Add))
{

			$sql=mysql_query("SELECT * FROM responsables");                       
			$count=mysql_num_rows($sql); 
			if($count==0)
			{
$sql=mysql_query("INSERT INTO responsables(`nombre_resp`,`unidad_adscrita`,`cargo`,`telefono`,`correo`) VALUES ('$nombre_resp','$unidad_adscrita','$cargo','$telefono','$correo')");

	                 }
				else
$sql=mysql_query("INSERT INTO responsables(`nombre_resp`,`unidad_adscrita`,`cargo`,`telefono`,`correo`) VALUES ('$nombre_resp','$unidad_adscrita','$cargo','$telefono','$correo')");
}


if(isset($Add_USUARIO))
{
	if(!empty($user) and $status<>'0' and !empty($password) and !empty($repassword))
	{
		if($password <> $repassword)
		{
			$ermsg='Contraseña incorrecta. Inténtelo de nuevo !';
		}
		else
		{
			$sql=mysql_query("SELECT * FROM users WHERE login='$user'");
			$count=mysql_num_rows($sql);
			if($count==0)
			{
				$password=($password);
				$sql=mysql_query("INSERT INTO users (`privilege`,`login`,`password`,`userSettings_id`,`status`,`description`,`address`,`telephone`,
				`email`,`subacc_id`,`nombre_usuario`) VALUES ('$privilege','$user','$password','1','Active','$description','$address','$telephone','$email2','$responsable',
				'$GPSUSERID')");
				if($sql)
				{
					SaveLog($GPSUSERID,'Un nuevo usuario añadido al sistema. Username '.$login.'');
				}
				else $ermsg="Se produjo un error al agregar usuarios. Inténtelo de nuevo !";
			}
			else
			$ermsg="Este nombre de usuario ya existe en el sistema. Inténtelo de nuevo !";
		}
	}
	else
	$ermsg="Nombre de usuario, Contraseña y Privilegio requerido !";
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Conavia - Agregar</title>
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





<table width="100%" height="30%" border="0">
  <tr>
    <td bgcolor="#faed95"><div style="color:#000; font-weight:bold; background:url(images/top_bg.gif) repeat-x;">:: RESPONSABLES</div></td>
  </tr>
  <tr>
    <td><div style="font-size:12px; color:#F00; font-weight:bold;"><?php echo $ermsg;?></div></td>
  </tr>
  <tr>
    <td>
    <form name="frmset" method="post" action="responsable.php">
<fieldset style="border: 3px solid #5eb058;">
<legend align= "left">Agregar Personas Responsables</legend>
    <table  align="left" width="80%" height="20%" border="0">
      <tr>
        <td width="200" align="left">Nombre</td>
        <td align="left"><label for="nombre_resp"></label>
          <input type="text" size="30" name="nombre_resp" id="nombre_resp" value="" placeholder="Nombre"/> 
          </td>

      </tr>
      <tr>
        <td width="200" align="left">Unidad Adscrita</td>
        <td align="left"><label for="unidad_adscri"></label>
          <input type="text" size="30" name="unidad_adscri" id="unidad_adscri" value="" placeholder="Unidad Adscrita"/> 
          </td>

  <tr>

        <td width="200" align="left">Cargo</td>
        <td align="left"><label for="cargo"></label>
          <input type="text" size="30" name="cargo" id="cargo" value="" placeholder="Cargo"/> 
          </td>
</tr>
  <tr>
        <td width="200" align="left">Teléfono(s)</td>
        <td align="left"><label for="telefono"></label>
          <input type="text" size="30" name="telefono" id="telefono" value="" placeholder="Teléfono"/> 
          </td>
</tr>
  <tr>
        <td width="200" align="left">Correo</td>
        <td align="left"><label for="email"></label>
         <input name="email" size="30" type="email" id="email" size="40" value="" placeholder="Correo Electrónico"/>
          </td>
</tr>



    <tr>
 <table  align="center" width="15%" border="0">  
 <form name="frmset" method="post" action="responsable.php">
     <td><fieldset style="border: 0px solid #5eb058;">

 

       <?php
		if(isset($_GET['Edit']) and ($GPSPRIVILEGE=='admin') )
        echo '<input type="submit" name="Cerrar" id="Save" value="Cerrar Orden de Trabajo" />';
           ?>

        <?php
		if(isset($_GET['Edit']))
        echo '<input type="submit" name="Save" id="Save" value="Actualizar Orden de Trabajo" />';

		else
        echo '<input type="submit" name="Add" id="Add" value="Agregar Responsable" />';
		?>

     </td>
      </tr>
    </table></form>
    </td>
  </tr>
</table>
</fieldset>


<table width="100%" height="10%" border="0">
  <tr>
    <td bgcolor="#faed95"><div style="color:#000; font-weight:bold; background:url(images/top_bg.gif) repeat-x;">:: USUARIOS</div></td>
  </tr>
  <tr>
    <td><div style="font-size:12px; color:#F00; font-weight:bold;"><?php echo $ermsg;?></div></td>
  </tr>

  <tr>
    <td>
    <form name="frmset" method="post" action="responsable.php">
<fieldset style="border: 3px solid #5eb058; overflow: auto;">
<legend align= "left">Usuarios al Sistema</legend>
    <table  align="left" width="80%" height="20%" border="0">
    <tr>
        <td width="100" align="left">Nombre de Usuario </td>
        <td align="left"><label for="user"></label>
          <input type="text" size="23" name="user" id="user" value="" placeholder="Nombre de usuario (Login)" required="required" /> 
          <font color="#FF0000">*</font></td>
      </tr>
      <tr>
        <td align="left">Seleccione Privilegios</td>
        <td align="left">
        <select name="privilege">
        <?php 
		if(isset($Edit))
		echo '<option value="'.$Eprivilege.'">'.$Eprivilege.'</option>';
		else
		echo '<option value="0">- Seleccione Privilegios -</option>';
		
        if($GPSPRIVILEGE=='admin') echo '<option value="Distributor">Distribuidor</option>';			
		?>
        <option value="End-User">Usuario Final</option>    
        </select>        
          <font color="#FF0000">*</font></td>
      </tr>
      <tr>
        <td align="left"><strong>Contraseña</strong></td>
        <td align="left">
          <input type="password" name="password" id="password" placeholder="Contraseña" required="required"/>
          <font color="#FF0000">*</font></td>
      </tr>
      <tr>
        <td align="left"><strong>Confirme Contraseña</strong></td>
        <td align="left">
        <input type="password" name="repassword" id="repassword" placeholder="Confirme" required="required"/>
          <font color="#FF0000">*</font></td>
      </tr>
      <tr>
        <td align="left">Descripción</td>
        <td align="left"><label for="description"></label>
          <textarea name="description" id="description" cols="40" rows="3"></textarea></td>
      </tr>
      <tr>
        <td align="left">Unidad Adscrita</td>
        <td align="left"><input name="address" type="text" id="address" size="40" value="" placeholder="Dirección" /></td>
      </tr>
      <tr>
        <td align="left">Número de Teléfono(s)</td>
        <td align="left"><input name="telephone" type="text" id="telephone" size="40" value="" placeholder="Teléfono"/></td>
      </tr>
      <tr>
        <td align="left">Dirección de Correo Electrónico</td>
        <td align="left">
        <input name="email2" type="email" id="email2" size="40" value="" placeholder="Correo Electrónico"/>
        </td>
      </tr>

       <tr>
        <td align="left">Responsable del Proyecto</td>
        <td align="left">        
        <select name="responsables2" id="responsables2"  value="<?php echo @$_POST[responsables2]?>" >

        <?php 

		if(isset($_POST["responsables2"]))
                $estatus_obra=$_POST["responsables2"];
                echo '<option value="0">- Seleccione Responsable -</option>'; 
                $re1=mysql_query("SELECT * FROM responsables");
               while($row=mysql_fetch_array($re1))
		{    
		echo '<option value="'.$row['id_resp'].'">'.$row['nombre_resp'].'</option>';
		}

      
		?>
        </select>   
         <font color="#FF0000">*</font></td>
</tr>


<table  align="center" width="15%" border="0">  
 <form name="frmset" method="post" action="responsable.php">
     <td><fieldset style="border: 0px solid #5eb058;">

          <?php
		if(isset($_GET['Edit']) and ($GPSPRIVILEGE=='admin') )
        echo '<input type="submit" name="Cerrar" id="Save" value="Cerrar Orden de Trabajo" />';
           ?>

        <?php
		if(isset($_GET['Edit']))
        echo '<input type="submit" name="Save" id="Save" value="Actualizar Orden de Trabajo" />';

		else
        echo '<input type="submit" name="Add_USUARIO" id="Add_USUARIO" value="Agregar USUARIO" />';
		?>

     </fieldset>
      </td>
      </tr>
    </table>


