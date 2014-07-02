<?php
	if ($_REQUEST['action']!='')
	{
		switch ($_REQUEST['action'])
		{
			case 'insert':
				mysql_query("	INSERT INTO ayudas

									SET	id_lenguage	= '".$_REQUEST[lenguage]."',
										section = '".$_REQUEST[section]."',
										label   = '".$_REQUEST[label]."',
										text    = '".$_REQUEST[text]."',
										date    = '".date('Y-m-d H:i:s')."'") or die (mysql_error());
			break;

			case 'update':
				mysql_query("	UPDATE ayudas

								SET	id_lenguage	= '".$_REQUEST[lenguage]."',
									section = '".$_REQUEST[section]."',
									label   = '".$_REQUEST[label]."',
									text    = '".$_REQUEST[text]."',
									date    = '".date('Y-m-d H:i:s')."'

								WHERE id = '".$_REQUEST[id_consulta]."'") or die (mysql_error());
			break;
		}
		mensajes("Successfully Processed", "?url=vistas/helps.view.php", "info");
	} ?>

<table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
	<tr>
		<td>
<?php		$frm = new formulario('Helps', '?url=vistas/helps.view.php', 'Send', 'Registers Languages', $metodo='post');
            
			$frm->inicio();
			
			if( $_REQUEST['id_consulta']!='' )
			
			{
			
				$frm->consulta = true;
				$where = " WHERE id = '".$_REQUEST['id_consulta']."'";
 				$frm->hidden("id_consulta", $_REQUEST['id_consulta']);
				
				$sql[0] = "SELECT id AS valor, name AS descripcion FROM languages WHERE status = '1' | AND id = '".campo("ayudas", "id", $_REQUEST['id_consulta'], 1)."'";

				$sql[1] = "	SELECT id AS valor,	name AS descripcion	FROM sections_page WHERE '1'='1' | AND id = '".campo("ayudas", "id", $_REQUEST['id_consulta'], 2)."'";
			
			} else {
				
				
				
			
				$sql[0] = "SELECT id AS valor, name AS descripcion FROM languages WHERE status = '1'";
				$sql[1] = "SELECT id AS valor, name AS descripcion FROM sections_page";
			
			}
			
			$frm->selects(array("lenguage"=>$sql[0]));
			$frm->selects(array("section"=>$sql[1]));

			$frm->inputs("SELECT
							t.label AS label_1,
							t.text AS text_1,
							t.section AS section_l
						  FROM
							ayudas t
						  $where");

			$frm->hidden('action',(($_REQUEST[id_consulta]!='')?'update':'insert'));
			$frm->fin(false); 
			
			?>
		</td>
	</tr>
	<tr>
		<td>
<?php		$frm->grilla("SELECT
							ayudas.id AS id,
							ayudas.label AS label,
							ayudas.text AS text
						  FROM
							ayudas
						  ORDER BY ayudas.id", 1); ?>
		</td>
	</tr>
</table>
