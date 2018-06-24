<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<title>Conavia - Archivos</title>

		<!-- CSS -->
		<link rel="stylesheet" href="estilos/estilos.css" type="text/css" />
		<link href="http://fonts.googleapis.com/css?family=Aclonica:regular" rel="stylesheet" type="text/css" >

		<!-- Libreria JQuery -->
		<script src="js/jquery-1.7.2.min.js" type="text/javascript"></script><!--se modifica por la version de jquery que tengan -->
        
        <!--PARA SUBIR ARCHIVOS -->
        <link rel="stylesheet" href="uploadify/uploadify.css" type="text/css" />
		<script type="text/javascript" src="uploadify/jquery.uploadify.js"></script>

        <!--FUNCIONES GENERALES -->
		<script type="text/javascript" src="js/funciones.js"></script>
		
		
		<!-- Table IU -->
		<style type="text/css" title="currentStyle">
			@import "estilos/demo_table_jui.css";
			@import "themes_table_iu/black-tie/jquery-ui.css";
			.ui-tabs .ui-tabs-panel { padding: 10px }
		</style>
		<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
		<script type="text/javascript" language="javascript" src="js/jquery-ui-tabs.js"></script>
		
		<link rel="stylesheet" href="estilos/popup.css" />
		<script type="text/javascript" src="js/tinybox.js"></script>
</head>

<?php
include('session.php');
include('phpsqlajax_dbinfo_conavia.php');


$sql=mysql_query("SELECT * FROM users JOIN responsables ON responsables.id_resp=users.subacc_id WHERE id_user='$GPSUSERID'");
$result=mysql_fetch_array($sql);
$GPSUSERNAME=strtoupper($result['nombre_resp']);
?>



<style>

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

        <div align="right" style="margin: 9px 1px; font-size:15px; float:right; color:#FFF; 
        font:Georgia, 'Times New Roman', Times, serif bold; width:150px;">
  
        </div>

<body>
	<div id="cabecera"><h1>Gestor de Archivos</h1></div>
        <div id="contenedor">
    	<div id="nuevaimagen"></div>
        <div id="listadoimagenes"></div>
    </div>
    <footer>

    </footer>
</body>
</html>
