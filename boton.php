

      <tr>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
     </tr>
      <tr>
        <td align="left">&nbsp;</td>
        <td align="center">
           



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

  </tr>
