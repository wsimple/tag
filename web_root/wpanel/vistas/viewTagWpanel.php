<?php
	$tags=$GLOBALS['cn']->query('SELECT t.id AS id FROM tags t WHERE status=10 ORDER BY id DESC');
?>
<fieldset>
	<legend>Tags Home</legend>
	<table width="650" border="0" align="center" cellpadding="2" cellspacing="2">
		<?php while($tag=mysql_fetch_assoc($tags)){//echo $tag['id'].'- '.tagURL($tag['id']).'<br>'; ?>
		<tr>
			<td align="center">
				<img src="<?=tagURL($tag['id'])?>"/>
			</td>
		</tr>
		<tr>
			<td height="5">&nbsp;</td>
		</tr>
		<tr>
			<td style="text-align:right;background-color:#f4f4f4">
				<a style="font-weight:normal" href="javascript:void(0)" onClick="if(confirm('Are you sure to delete this tag ?')){redirect('../controls/tags/actionsTags.controls.php?wpanel&action=6&tag=<?=$tag['id']?>&url=wpanel/?url=vistas/viewTagWpanel.php')}">Delete Tag</a>
				|&nbsp;
				<a style="font-weight:normal" href="../#update?tag=<?=$tag['id']?>&wpanel">Edit Tag</a>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<?php } ?>
	</table>
</fieldset>
