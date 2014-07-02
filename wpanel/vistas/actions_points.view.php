<?php
//echo $_POST['action-points_points_owner'].'--'.$_POST['action-points_points_user'].'--'.$_REQUEST['id'];
if($_REQUEST['action']=='update'){
	if( $_POST['action-points_points_owner']!='' || $_POST['action-points_points_user']!='' || $_REQUEST['id']!='') {

		mysql_query("UPDATE action_points SET 
						points_owner = '".$_POST['action-points_points_owner']."', 
						points_user='".$_POST['action-points_points_user']."' 
					WHERE id = '".$_REQUEST['id']."'
		") or die (mysql_error());

		mensajes("Successfully Processed","?url=vistas/actions_points.view.php", "info");
	}else{
		mensajes("Empty field(s)", $_SERVER['HTTP_REFERER'], "error");
	}				
}

?>
<table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
	<tr>
		<td>
		<?php 
		$frm = new formulario('action points', '?url=vistas/actions_points.view.php', 'Send', 'Actions', $metodo='post');
		$frm->inicio();
		if ($_REQUEST['id_consulta']!=''){	
			$frm->consulta=true;
			$query = mysql_query("
						SELECT  a.id as id,
								a.id_type as id_type
						FROM action_points a INNER JOIN type_actions t ON t.id=a.id_type 
						WHERE a.id = '".$_REQUEST['id_consulta']."'") or die (mysql_error());
			$actions=mysql_fetch_assoc($query);
			
			$whereDes = "WHERE id = '".$actions['id_type']."'";
			$whereOU = "WHERE id = '".$_REQUEST['id_consulta']."'";
			
		}
		
		$frm->inputs("SELECT description FROM type_actions $whereDes",1);
		
		$frm->inputs("SELECT points_owner FROM action_points $whereOU",($_REQUEST['id_consulta']=='')?1:'');
		
		$frm->inputs("SELECT points_user FROM action_points $whereOU",($_REQUEST['id_consulta']=='')?1:'');
		
		$frm->hidden('id', $_REQUEST['id_consulta']);
		$frm->hidden('action','update');
		$frm->fin(false); 
		?>
		</td>
	</tr>
	<tr>
		<td>
		<?php
		$frm->grilla("
			SELECT a.id as id,
				   t.description as description,
				   a.points_owner as points_owner,
				   a.points_user as points_user
			FROM action_points a INNER JOIN type_actions t ON t.id=a.id_type", 1,'',"ASC",1);
		?>
		</td>
	</tr>
</table>