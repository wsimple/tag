<?php 
	if ($_REQUEST['action']!='')
	{	switch ($_REQUEST['action'])
		{	case 'insert':
				mysql_query("INSERT INTO languages SET name = '".$_REQUEST[name]."', status = '1'") or die (mysql_error());
			break;
								
			case 'update':
				mysql_query("UPDATE languages SET name = '".$_REQUEST[name]."' WHERE id = '".$_REQUEST[id_consulta]."'") or die (mysql_error());
			break;
		}
		mensajes("Sucessfully Process", "?url=vistas/languages/master.php", "info");
	} ?>

<table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
	<tr>
		<td>
<?php		$frm = new formulario('languages', '?url=vistas/languages/master.php', 'Send', 'Registers Languages', $metodo='post');
			$frm->inicio();
			if ($_REQUEST['id_consulta']!='')
			{	$frm->consulta = true;
				$where = " WHERE id = '".$_REQUEST['id_consulta']."'";
				$frm->hidden("id_consulta", $_REQUEST['id_consulta']);
			} else
			{	$where = "";  
			}
			$frm->inputs("	SELECT
								languages.name AS name_1
							FROM
								languages
							$where
						");
			$frm->hidden('action',(($_REQUEST[id_consulta]!='')?'update':'insert'));
			$frm->fin(false); ?>
		</td>
	</tr>
	<tr>
		<td>
<?php		$frm->grilla("	SELECT
								id,
								languages.name as name,
								(select status.name from status where status.id = languages.status) as status
							FROM
								languages
							ORDER BY languages.name
						", 1); ?>
		</td>
	</tr>
</table>