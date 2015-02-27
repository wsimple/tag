<table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
	<tr>
		<td>
		<?php
			$frm = new formulario('logs user', '?url=vistas/actions_points.view.php', 'Send', 'logs user', $metodo='post');
//			$frm->inicio();
//			$frm->consulta=true;
//			$frm->fin(false); 
			$frm->grilla("
				SELECT 
					a.id as id,
					u.name as name,
					u.last_name as last_name,					
					t.description as description,
					a.date as date
				FROM log_actions a 
				INNER JOIN type_actions t ON t.id=a.id_type
				INNER JOIN users u ON u.id=a.id_user", 1,'','',2);
		?>
		</td>
	</tr>
</table>