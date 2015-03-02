<?php

$fields = "md5(id) AS id, super_user, name, last_name, email";

if( $_POST[name] || $_POST[last_name] || $_POST[email] ) {

	$query = mysql_query("SELECT ".$fields." FROM users WHERE ".($_POST[name] ? "name LIKE '%".$_POST[name]."%'" : '').
																($_POST[name] && $_POST[last_name] ? ' OR ' : '').
																($_POST[last_name] ? "last_name LIKE '%".$_POST[last_name]."%'" : '').
																($_POST[last_name] && $_POST[email] ? ' OR ' : '').
																($_POST[email] ? "email LIKE '%".$_POST[email]."%'" : '')
		);
} else {

	$query = mysql_query("SELECT ".$fields." FROM users");
}
?>




<form id="payments" name="payments" method="post" action="index.php?url=vistas/super_users.view.php" class="formulario" enctype="multipart/form-data">

<table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
    <tr>
        <td>
        <fieldset>
       	<legend>Filter</legend>
                <table width="450" border="0" align="center" cellpadding="2" cellspacing="2">

                <tr>
					<td class="etiquetas" style="text-align:left">email</td>
					<td class="etiquetas" style="text-align:left">Name</td>
					<td class="etiquetas" style="text-align:left">Last Name</td>
                </tr>

                <tr>
					<td>
						<input name="email" type="text" id="email" value="" size="20"/>
					</td>

					<td>
						<input name="name" type="text" id="name" value="" size="20"/>
					</td>

					<td>
						<input name="last_name" type="text" id="last_name" value="" size="20"/>
					</td>
                </tr>

                <tr><td>&nbsp;</td></tr>

                <tr style="background-color:#F4F4F4">
					<td style="text-align:center" colspan="3">
                <input type='button' class='boton' name='search' id='search' value='search' onclick='this.form.submit();' />
                </td>
                </tr>
                </table>
        </fieldset>
        </td>
    </tr>

<?php $style = "style='border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4; text-align:center;'";?>
    <tr>
        <td>
        <fieldset>
       	<legend>Super Users</legend>
                <table width="680" border="0" align="center" cellpadding="2" cellspacing="0" style="font-size:11px; margin-top:10px; margin-bottom:10px; font-weight:normal; text-align:left; border:1px solid #FBCBA4; border-bottom:none">
                <tr style="background-color:#FDE2CC; color:#000000; font-weight:bold">
                    <td <?=$style?>>email</td>
					<td <?=$style?>>Name</td>
                    <td <?=$style?>>Last Name</td>
                    <td <?=$style?>>SU</td>
                </tr>

                <?php

				while( $row = mysql_fetch_assoc($query) ) { ?>

						<tr valign="top">
							<td <?=$style?>> <?=$row['email']?></td>
							<td <?=$style?>> <?=$row['name']?></td>
							<td <?=$style?>> <?=$row['last_name']?></td>
							<td	<?=$style?> title="<?=($row['super_user']=='1' ? 'Remove' : 'Add' )?> SU">
								<img style="cursor: pointer; width: 20px; height: 20px;"
									 onclick="actionSU('<?=($row['super_user']=='1' ? '1' : '0' )?>', '<?=$row['id']?>')"
									 src="../img/menu_businessCard/<?=($row['super_user']=='1' ? 'd' : 'makeD')?>efault.png"/>
							</td>
						</tr>
						<?php
				} ?>
                </table>
        </fieldset>
        </td>
    </tr>
</table>

	<input style="display: none" type="submit"/>
</form>