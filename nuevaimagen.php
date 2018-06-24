<?php
include('session.php');
include('phpsqlajax_dbinfo_conavia.php');


$sql=mysql_query("SELECT * FROM users JOIN responsables ON responsables.id_resp=users.subacc_id WHERE id_user='$GPSUSERID'");
$result=mysql_fetch_array($sql);
$GPSUSERNAME=strtoupper($result['nombre_resp']);
?>

<script type="text/javascript" src="js/nuevaimagen.js"></script>

<form>
<div class="formulario-title"><span >SUBIR ARCHIVOS</span></div>
<div ><div ><div >
<table >
	<tr>
    	<td >
        <br/>
         Responsable del Proyecto
        <select name="txtdes" id="txtdes"  value="<?php echo @$_POST[responsables]?>" >

        <?php 

		if(isset($_POST["responsables"]))
                $estatus_obra=$_POST["responsables"];
                echo '<option value="">- Seleccione Responsable -</option>'; 
                $re1=mysql_query("SELECT * FROM responsables where nombre_resp='$GPSUSERNAME'");
               while($row=mysql_fetch_array($re1))
		{    
		echo '<option value="'.$row['id_resp'].'">'.$row['nombre_resp'].'</option>';
		}

      
		?>
        </select>   
        </td>
        <td><input id="file_upload" type="file" name="file_upload" /></td>
     </tr>
</table>
</div></div></div>
<div align="right">
<input class="button" type="button" value="Cargar" onclick="javascript:startUpload('file_upload', document.getElementById('txtdes'))"/>&nbsp;&nbsp;
</div>
</form>
