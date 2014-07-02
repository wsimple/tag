<?php 
// _imprimir($_REQUEST);
if ($_REQUEST['action']!=''){
	switch ($_REQUEST['action']){
		case 'update':
			$status      = 0;
			$queryStatus = '';

			switch ($_REQUEST['status']) {
				case 1:
					$status = 1;
					$queryDate = "end_date=DATE_ADD(NOW(), INTERVAL 10 YEAR),";
					break;
				case 2:
					$status = 3;
					$queryDate = "end_date=NOW(),";
					break;
				case 5:
					$queryDate = "end_date=DATE_ADD(init_date, INTERVAL 15 DAY),";
					break;
			}
			// Cambio status de usuario a desactivado
			$query = 'UPDATE users SET status = '.$status.' 
					  WHERE id = '.$_REQUEST['id_consulta'].' LIMIT 1';
			$queryStatus = "UPDATE users_plan_purchase SET ".$queryDate." 
							  		notes = '".$_REQUEST['note']."' 
					  		  		WHERE id_user = ".$_REQUEST['id_consulta'].' 
					  		  		LIMIT 1';
			mysql_query($query) or die (mysql_error());
			mysql_query($queryStatus) or die (mysql_error());
		break;
	}
	mensajes("Sucessfully Process", "?url=".$_REQUEST['url'], "info");
}
?>
<table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
	<?php 
		$frm = new formulario('Manage accounts nonprofit', '?url='.$_GET['url'], 'Send', 'Manage accounts nonprofit', $metodo='post');
		if ($_REQUEST['id_consulta']!=''){ 
	?>
    <tr>
        <td>
			<?php
				$frm->inicio();
				$frm->consulta=true;
				$query = mysql_query("
					SELECT MD5( CONCAT(id,'_',email,'_',id) ) AS code 
					FROM users 
					WHERE id=".$_REQUEST['id_consulta']
				) or die (mysql_error());
				$array = mysql_fetch_assoc($query);
				$frm->inputs("
					SELECT notes AS note 
					FROM users_plan_purchase 
					WHERE id_user = '".$_REQUEST['id_consulta']."'
				");
				$allowedStatus = ($_REQUEST['status'] == 1) ? ', 5' : '';
				$frm->selects(array("status"=>"
					SELECT 
						id AS valor,
						name AS descripcion
					FROM status
					WHERE id IN ('1','2'".$allowedStatus.")
					| AND 
					id = '".campo("store_products", "id", $_REQUEST['id_consulta'], 2)."'
				"));
				$frm->insertColspan();
				$frm->hidden("id_consulta", $_REQUEST['id_consulta']);
				$frm->insertColspan();
				$frm->insertTitle('Documents of company');
				$frm->insertColspan();				
				for ($i=0;$i<5;$i++){
					$src = FILESERVER.'img/documents/'.$array['code'].'/document_'.$i.'.jpg';
					if (fileExistsRemote($src)){ 
						$frm->insertHtml('Document ('.($i+1).')','
							<a href="'.$src.'" target="_blank" title="view">
							<img src="'.$src.'" width="100" height="100" style="cursor:pointer; margin:2px 0 2px 3px; border:1px solid #ccc" />
							</a>
						'
						);
					}
				}
				$frm->insertColspan();
				$frm->hidden('url',$_GET['url']);
				$frm->hidden('action',(($_REQUEST['id_consulta']!='')?'update':'update'));
				$frm->fin(false);
            ?>
        </td>
    </tr>
	<?php } ?>
    <tr>
        <td>
			<?php
				$frm->grilla("
					SELECT
						u.id AS id,
						p.id_user,
						CONCAT(u.name,' ', u.last_name) AS name, 
						p.end_date AS closing_date,
						(SELECT name FROM status WHERE id = u.status) AS status
					FROM users_plan_purchase p INNER JOIN users u ON p.id_user=u.id
					WHERE p.id_plan = 0
					ORDER BY end_date DESC
				",1);
            ?>
        </td>
    </tr>
</table>