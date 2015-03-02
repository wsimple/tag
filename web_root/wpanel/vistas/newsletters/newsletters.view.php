<script type="text/javascript" src="../js/funciones.js"></script>

<?php
// ************** ACTIVATE/DESACTIVATE NEWSLETTER *************************************************************************************
if( $_REQUEST[activate] ) {

	mysql_query("UPDATE newsletters SET status = '1' WHERE md5(id) = '".$_REQUEST[activate]."'") or die(mysql_error());
	echo '<meta HTTP-EQUIV="REFRESH" content="0; url=\'?url=vistas/newsletters/newsletters.view.php\'">';

} elseif( $_REQUEST[desactivate] ) {

	mysql_query("UPDATE newsletters SET status = '2' WHERE md5(id) = '".$_REQUEST[desactivate]."'") or die(mysql_error());
	echo '<meta HTTP-EQUIV="REFRESH" content="0; url=\'?url=vistas/newsletters/newsletters.view.php\'">';
}
// ************** END - ACTIVATE/DESACTIVATE NEWSLETTER *******************************************************************************






// ************** INITIAL CONFIGURATION ***********************************************************************************************
$style	= "style='	border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4;
					text-align:center; vertical-align: middle; padding: 5px;'";
$show	= 5;	     /*1*/        /*2*/     /*3*/      /*4*/      /*5*/
$fields	= array("current_sent", "tittle", "content", "status", "date_sent",
				"md5(id) AS id", "content_old", "sending_failed");
// ************** END - INITIAL CONFIGURATION *****************************************************************************************






// ************** QUERY TO SHOW THE LIST **********************************************************************************************
$query = "SELECT ";
foreach ($fields as $field) {
	$query.= $field.", ";
}
$query[strlen($query)-2] = ' ';
$query.= "FROM newsletters ";
// ************** END - QUERY TO SHOW THE LIST ****************************************************************************************






// ************** FILTERING THE INFORMATION OF THE QUERY TO SHOW THE LIST *************************************************************
if( $_REQUEST[editId] ) { //when editing a newsletter (by clicking on "edit" in action menu)

	$query.= "WHERE md5(id) = '".$_REQUEST[editId]."'";
	$query = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_assoc($query);

} elseif( $_REQUEST[content_filter] || $_REQUEST[status_filter] || $_REQUEST[tittle_filter] ) { //when filtering newsletters (button search)

	$query.= "WHERE ".($_REQUEST[content_filter] ? "content LIKE '%".$_REQUEST[content_filter]."%'" : '' ).
					  ($_REQUEST[content_filter] && $_REQUEST[status_filter] ? ' AND ' : '' ).
					  ($_REQUEST[status_filter] ? "status LIKE '%".$_REQUEST[status_filter]."%'" : '' ).
					  (($_REQUEST[status_filter] && $_REQUEST[txt_tittle]) || ($_REQUEST[content_filter] && $_REQUEST[tittle_filter]) ? ' AND ' : '' ).
					  ($_REQUEST[tittle_filter] ? "tittle LIKE '%".$_REQUEST[tittle_filter]."%'" : '' );
	$query = mysql_query($query) or die(mysql_error());

} else {

	$query = mysql_query($query) or die(mysql_error());
}
// ************** END - FILTERING THE INFORMATION OF THE QUERY TO SHOW THE LIST *******************************************************
?>






<table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
	<tr>
	<td>
	<fieldset>
		<legend>Filters</legend>
		<form id="newsletters" method="post" action="controladores/newsletters/newsletters.control.php?<?= ($_REQUEST[editId] ? 'updateId='.$_REQUEST[editId] : 'newId') ?>" class="formulario" enctype="multipart/form-data">
			<table width="450" border="0" align="center" cellpadding="2" cellspacing="2">
			<tr>
				<td class="etiquetas" style="text-align:center; vertical-align: bottom">Tittle</td>
				<td class="etiquetas" style="text-align:center; vertical-align: bottom">Content</td>
			</tr>
			<tr>
				<td style="vertical-align: top">
					<input	id="txt_tittle" name="txt_tittle" type="text" size="20"
							onkeyup="document.getElementById('tittle_filter').value = this.value;"
							value="<?=($_REQUEST[txt_tittle] ? $_REQUEST[txt_tittle] : ($row[tittle] ? $row[tittle] : ($_REQUEST[tittle_filter] ? $_REQUEST[tittle_filter] : '')))?>" />
					<?php if( $_REQUEST[editId] ) { ?> <input id='id_newsletter' name='id_newsletter' type='text' value='".$_REQUEST[editId]."' style="display: none" /> <?php } ?>
				</td>
				<td style="vertical-align: top" rowspan="3">
					<textarea id="txt_content" name="txt_content" style="resize: none;" rows="6" cols="45"
							  onkeyup="document.getElementById('content_filter').value = this.value;"><?=($_REQUEST[txt_content] ? $_REQUEST[txt_content] : ($row[content] ? $row[content] : ($_REQUEST[content_filter] ? $_REQUEST[content_filter] : '')) )?></textarea>
				</td>
			</tr>
			<tr>
				<td class="etiquetas" style="text-align:center; vertical-align: bottom">Status</td>
			</tr>

			<?php
				for($i=0; $i<4; $i++)
					$selected[$i] = '';
				switch ( ($_REQUEST[txt_status] ? $_REQUEST[txt_status] : ($row[status] ? $row[status] : ($_REQUEST[status_filter] ? $_REQUEST[status_filter] : ''))) ) {
					case '1': $status[0] = 'selected'; break;
					case '2': $status[1] = 'selected'; break;
					case '5': $status[2] = 'selected'; break;
					case '6': $status[3] = 'selected'; break;
				}
			?>

			<tr>
				<td style="vertical-align: top">
					<select style="width: 150px" id="txt_status" name="txt_status" onmousedown="document.getElementById('status_filter').value = this.value;">
						<option <?=(!($status[0] || $status[1] || $status[2] || $status[3]) ? 'selected' : '')?>>---</option>
						<option <?=$status[0]?>>	Active	</option>
						<option <?=$status[1]?>>	Inactive</option>
						<option <?=$status[2]?>>	Pending	</option>
						<option <?=$status[3]?>>	Sent	</option>
					</select>
				</td>
			</tr>
			<tr style="background-color:#F4F4F4;">
				<td style="text-align:center" colspan="2">
					<?=($_REQUEST[editId] ? "<input type='button' class='boton' id='update' value='update' onclick='this.form.submit();'/>"
										  : ( !($_REQUEST[content_filter] || $_REQUEST[status_filter] || $_REQUEST[tittle_filter]) ? "<input type='button' class='boton' id='save' value='save' onclick='this.form.submit();'/>" : ''))?>
				</td>
			</tr>
			</table>
				<input style="display: none" type="submit"/>
		</form>

		<?php if( !$_REQUEST[editId] ) { ?>
			<form id="find" method="post" action="index.php?url=vistas/newsletters/newsletters.view.php" class="formulario" enctype="multipart/form-data">
				<table width="450" border="0" align="center" cellpadding="2" cellspacing="2">
				<tr style="background-color:#F4F4F4;">
					<td style="text-align:center">
						<input id="tittle_filter"	name="tittle_filter"	style="display: none"/>
						<input id="status_filter"	name="status_filter"	style="display: none"/>
						<input id="content_filter"	name="content_filter"	style="display: none"/>
						<input type='submit' class='boton' id='search' value='search'/>
					</td>
				</tr>
				</table>
			</form>
		<?php } ?>
	</fieldset>
	</td>
</tr>

<tr>
	<td>
		<fieldset>
			<legend>Newsletters</legend>
			<table width="680" border="0" align="center" cellpadding="2" cellspacing="0" style="font-size:11px;		margin-top:10px;
																								margin-bottom:10px;	font-weight:normal;
																								text-align:left;	border:1px solid #FBCBA4;
																								border-bottom:none">
			<tr style="background-color:#FDE2CC; color:#000000; font-weight:bold">
				<?php for($k=0; $k<$show; $k++) {
					echo "<td ".$style.">".$fields[$k]."</td>";
				} ?>
				<td <?=$style?>>Action</td>
			</tr>


			<?php
			if( $_REQUEST[editId] ) {

				showRow($row, $style);

			} else {

				while( $row = mysql_fetch_assoc($query) ) {

					showRow($row, $style);
						}
			} ?>
			</table>
		</fieldset>
	</td>
</tr>
</table>

<?php function showRow($row, $style) { ?>
	<tr valign="top">
		<td <?=$style?>> <?=$row['current_sent']?></td>
		<td <?=$style?>> <?=$row['tittle']?></td>
		<td <?=$style?>> <?=$row['content']?></td>
		<td <?=$style?>> <?=campo("status", "id", $row['status'], "name")?></td>
		<td <?=$style?>> <?=$row['date_sent']?></td>
		<td <?=$style?>>
			<table>
			<tr>
				<td>
					<?=$row['status']=='1'||$row['status']=='5'||$row['status']=='6' ? '<img src="../img/menu_tag/compartir.png" style="cursor: pointer; width: 16px; height: 16px" title="send newsletter" onclick="location.href=\'controladores/newsletters/newsletters.control.php?sendId='.$row['id'].'\'"/>' : ' '?>
				</td>
				<td>

					<?=($_REQUEST[editId] ? '' : '<img src="../img/edit.png" style="cursor: pointer; width: 16px; height: 16px" title="edit" onclick="location.href=\'?url=vistas/newsletters/newsletters.view.php&editId='.$row['id'].'\'"/>')?>
				</td>
			</tr>
			<tr>
				<td>
					<img src="../img/menu_businessCard/<?=$row['status']=='2' ? 'makeD' : 'd' ?>efault.png"
						 style="cursor: pointer; width: 16px; height: 16px"
						 title="<?=$row['status']=='2' ? 'a' : 'desa' ?>ctivate"
						 onclick="location.href='?url=vistas/newsletters/newsletters.view.php&<?=$row['status']=='2' ? 'a' : 'desa' ?>ctivate=<?=$row['id']?>'"/>
				</td>
				<td>
					<img src="../img/bullet.gif"
						 style="cursor: pointer; width: 16px; height: 16px"
						 title="Test"
						 onclick="redirect('../cronjobs/newsletters.php?send_one_mail='+prompt('Ingrese el Correo Electronico', '@gmail.com')+'|<?=$row['id']?>');"/>
				</td>
			</tr>
			</table>
		</td>
	</tr>
<?php } //redirect('../cronjobs/newsletters.php?send_one_mail=email|id') ?>