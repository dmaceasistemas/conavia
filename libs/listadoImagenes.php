		<script type="text/javascript" charset="utf-8">
            $(document).ready(function(){
                $('#datatables').dataTable({
                    "sPaginationType":"two_button",//or "full_numbers"
                    "aaSorting":[[2, "desc"]],
                    "bJQueryUI":true
                    //Este plugin permite iniciar la busqueda mediante una palabra
                    //"oSearch": {"sSearch": "a"}
                    //Esta pugin te permite cargar datos desde otra fuente
                    //"sAjaxSource": "http://www.sprymedia.co.uk/dataTables/json.php"
                   
                });
            });

        </script>
<?php
include("mysql.inc.php");
include('session.php');
include('phpsqlajax_dbinfo_conavia.php');


session_start();
	



	$db = new MySQL();
        $sql=mysql_query("SELECT * FROM users JOIN tbl_temp_files ON tbl_temp_files.descripcion=users.subacc_id  
                                              JOIN responsables ON responsables.id_resp=tbl_temp_files.descripcion WHERE id_user='$GPSUSERID'  ");
                                             
        $result=mysql_fetch_array($sql);
        $GPSUSERNAME=strtoupper($result['nombre_resp']);
           
	      $listar=mysql_query("SELECT * FROM tbl_temp_files JOIN responsables ON responsables.id_resp=tbl_temp_files.descripcion
                                                          WHERE responsables.nombre_resp='$GPSUSERNAME'
                                                          ORDER BY id_files ASC");

        
    
if($db->num_rows($listar)>0){

	echo "<form method='POST' action='libs/eliminar.php' >";
	echo '<div align="right" style="color:#FFF;font-family:Arial; margin-bottom:10px">Eliminar elementos seleccionados <input class="button" type="submit" name"borrar" value="Borrar"></div>';
	echo '<table cellpadding="0" cellspacing="0" border="0" id="datatables" class="display">';
		echo '<thead>';
			echo '<tr>';

				echo '<td width="10">Estado</td>
                                
				<td>Responsable</td>
				<td width="70">Vista</td>
				<td width="70">Opciones</td>';
			echo '</tr>';
		echo '</thead>';
			echo '<tbody>';
				while($row=($db->fetch_array($listar))){
					echo '<tr class="odd gradeA">';
						if ($row['status']==1) {
							echo "<td><img src='images/001_18.png' width='20'></td>";
						} else {
							echo "<td><img src='images/001_19.png' width='20'></td>";
						}
						echo"<td>".$row['nombre_resp']."</td>";                                                
						switch ($row['tipo']) {
						case 'pdf':
								echo"<td><a target='_Blank' href='uploads/".$row['nombre']."'><img src='images/pdf.png' width='70' height='70'></a></td>";
							break;
						case 'docx':
								echo"<td><a target='_Blank' href='uploads/".$row['nombre']."'><img src='images/doc.png' width='70' height='70'></a></td>";
							break;
						case 'xlsx':
								echo"<td><a target='_Blank' href='uploads/".$row['nombre']."'><img src='images/xls.png' width='70' height='70'></a></td>";
							break;
						case 'html':
								echo"<td><a target='_Blank' href='uploads/".$row['nombre']."'><img src='images/html.png' width='70' height='70'></a></td>";
							break;
						case 'txt':
								echo"<td><a target='_Blank' href='uploads/".$row['nombre']."'><img src='images/txt.png' width='70' height='70'></a></td>";
							break;
						case 'zip':
								echo"<td><a target='_Blank' href='uploads/".$row['nombre']."'><img src='images/zip.png' width='70' height='70'></a></td>";
							break;
								
						default:
								echo"<td><img border=\"0\" src=\"uploads/".$row['nombre']."\" width='70' height='70'></a></td>";
							break;
						}
						echo "<td>&nbsp;&nbsp;<input type='checkbox' name='delete[]' id='delete' value='".$row['id_files']."'><ul class=\"tinybox\"><li onclick=\"TINY.box.show({url:'libs/detalles.php',post:'id=".$row['id_files']."',width:500,height:200,opacity:20,topsplit:3})\"><img  title=\"Ver detalles\" src=\"images/detailed.png\"></li></ul></td>";
					echo '</tr>';
				}	
			echo '<tbody>';
	echo '</table>';	
	echo "</form>";
}else{
	echo"<div id='mensajevacio' align=\"center\">No hay archivos por el momento</div>";
}

?>

