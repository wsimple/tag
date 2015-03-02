<?php
if ($_REQUEST['action']!='') {
	switch ($_REQUEST['action']) {
		case 'insert':

			$query = mysql_query('SELECT id FROM translations_template WHERE label LIKE "'.$_REQUEST[label].'"') or die (mysql_error());

			if (mysql_num_rows($query)==0){
				mysql_query('INSERT INTO translations_template
								SET	section		= "'.$_REQUEST['section'].'",
									label		= "'.$_REQUEST['label'].'",
									text		= "'.$_REQUEST['text'].'",
									text_help	= "'.$_REQUEST['text_help'].'",
									date		= "'.date('Y-m-d H:i:s').'"') or die (mysql_error().' 1');

				mensajes("Successfully Processed", "?url=vistas/languages/template.php", "info");

			}else{

				mensajes("Duplicate Label", "?url=vistas/languages/template.php", "error");

			}
		break;

		case 'update':

			$query = mysql_query("SELECT id FROM translations_template WHERE label LIKE '".$_REQUEST[label]."'") or die (mysql_error());

			if (mysql_num_rows($query)==0){
				$sql = "UPDATE translations_template
							SET	text      = '".$_REQUEST[text]."',
								text_help = '".$_REQUEST[text_help]."',
								date      = '".date('Y-m-d H:i:s')."'
						WHERE id = '".$_REQUEST[id_consulta]."'";
			}else{
				$sql = "UPDATE translations_template
							SET	section   = '".$_REQUEST[section]."',
								label     = '".$_REQUEST[label]."',
								text      = '".$_REQUEST[text]."',
								text_help = '".$_REQUEST[text_help]."',
								date      = '".date('Y-m-d H:i:s')."'
						WHERE id = '".$_REQUEST[id_consulta]."'";
			}

			mysql_query($sql) or die (mysql_error().' 2');

			mensajes("Successfully Processed", "?url=vistas/languages/template.php", "info");

		break;
	}
}
?>

<table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
	<tr>
		<td>
<?php		$frm = new formulario('languages templates', '?url=vistas/languages/template.php', 'Send', 'Registers Languages', $metodo='post');
			$frm->inicio();
			if( $_REQUEST['id_consulta']!='' ) {
				$frm->consulta = true;
				$where = " WHERE id = '".$_REQUEST['id_consulta']."'";
				$frm->hidden("id_consulta", $_REQUEST['id_consulta']);
				$sql[0] = "	SELECT
								id AS valor,
								name AS descripcion
							FROM
								sections_page
							WHERE '1'='1' | AND id = '".campo("translations_template", "id", $_REQUEST['id_consulta'], 2)."'";
			} else
			{	$sql[0] = "SELECT id AS valor, name AS descripcion FROM sections_page";
			}
			$frm->selects(array("section"=>$sql[0]));

			$frm->inputs("SELECT
							t.label AS label_1,
							t.text AS text,
							t.text_help AS text_help
						  FROM
							translations_template t
						  $where");

			$frm->hidden('action',(($_REQUEST[id_consulta]!='')?'update':'insert'));
			$frm->fin(false); ?>
		</td>
	</tr>
	<tr>
		<td>
<?php		$frm->grilla("SELECT
							translations_template.id AS id,
							translations_template.label AS label,
							translations_template.text AS text,
							translations_template.text_help AS text_help
						  FROM
							translations_template
						  ", 1); ?>
		</td>
	</tr>
</table>
