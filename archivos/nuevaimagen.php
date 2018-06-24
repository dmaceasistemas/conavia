<script type="text/javascript" src="js/nuevaimagen.js"></script>

<form>
<div class="formulario-title"><span >SUBIR ARCHIVOS</span></div>
<div ><div ><div >
<table >
	<tr>
    	<td valign="top"><span >Descripci&oacute;n</span><br/>
        <br/>
        <textarea class="cajas" cols="" name="txtdes" id="txtdes" style="width: 500px;height: 200px" ></textarea>
        </td>
        <td><input id="file_upload" type="file" name="file_upload" /></td>
     </tr>
</table>
</div></div></div>
<div align="right">
<input class="button" type="button" value="Cargar" onclick="javascript:startUpload('file_upload', document.getElementById('txtdes'))"/>&nbsp;&nbsp;
</div>
</form>
