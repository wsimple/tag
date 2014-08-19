<table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
<tr>
<td>
<fieldset>
<legend>Delete Item</legend>	
<?php
	
	$delete = true;

	switch ($_GET['tabla']){
		
		case 'users_publicity':
			if (in_array($_SERVER['SERVER_NAME'],array('68.109.244.199','tagbum.com','www.tagbum.com'))){
				define (_PATH_, "../newDesign/img/publicity/");
			}else{
				define (_PATH_, "../img/publicity/");
			}
			$query = mysql_query("
				SELECT 
					picture
				FROM ".$_GET['tabla']."
				WHERE id = '".$_GET['id_consulta']."'
			") or die (mysql_error());
			$array = mysql_fetch_assoc($query);
			@unlink(_PATH_.$array['picture']);
		break;
	
		case 'banners':
			if (in_array($_SERVER['SERVER_NAME'],array('68.109.244.199','tagbum.com','www.tagbum.com'))){
				define (_PATH_, "../newDesign/img/publicity/banners/");
			}else{
				define (_PATH_, "../img/publicity/banners/");
			}
			$query = mysql_query("
				SELECT picture 
				FROM banners_picture
				WHERE id_banner = '".$_GET['id_consulta']."'
			");
			while ($array = mysql_fetch_assoc($query)){
				unlink(_PATH_.'/'.$array['picture']);
			}
			mysql_query("DELETE FROM banners_picture WHERE id_banner = '".$_GET['id_consulta']."'");
		break;
		
		case 'store_category':
			mysql_query("UPDATE store_category SET id_status = '2' WHERE id = '".$_GET['id_consulta']."' ");
			$delete = false;
		break;
	
		case 'store_sub_category':
			mysql_query ("UPDATE store_sub_category SET id_status = '2' WHERE id = '".$_GET['id_consulta']."' ");
			$delete = false;
		break;//store_category
		
		case 'store_products':
			mysql_query ("UPDATE store_products SET id_status = '2' WHERE id = '".$_GET['id_consulta']."' ");
			$delete = false;
		break;//store_category

		case 'subscription_plans':
			$query = "SELECT id_plan FROM users_plan_purchase WHERE id_plan = '".$_GET['id_consulta']."' LIMIT 1";
			$result = mysql_query($query);

			if(mysql_num_rows($result) > 0){
				mysql_query('UPDATE subscription_plans SET status=2 WHERE id = '.$_GET['id_consulta']);
				$delete = false;
			}else{
				mysql_query('DELETE FROM  subscription_plans WHERE id = '.$_GET['id_consulta']);
			}
		break;
		case 'tour_comment':
			mysql_query ("UPDATE tour_comment SET active = '0' WHERE id = '".$_GET['id_consulta']."' ");
			
			$result = mysql_query("SELECT title,message FROM ".$_GET['tabla']." WHERE id = '".$_GET['id_consulta']."'");
			$array = mysql_fetch_assoc($result);
			
			//if($_GET['_languages_']=='1'){
				mysql_query("DELETE FROM translations_template WHERE label = '".$array['title']."'") or die (mysql_error());
				mysql_query("DELETE FROM translations_template WHERE label = '".$array['message']."'") or die (mysql_error());
			
				mysql_query("DELETE FROM translations WHERE label = '".$array['title']."' ") or die (mysql_error());
				mysql_query("DELETE FROM translations WHERE label = '".$array['message']."' ") or die (mysql_error());
			//}
			$activeDel = '1';
			$delete = false;
		break;
	}
	
	if ($delete){
		mysql_query("
			DELETE FROM ".$_GET['tabla']." 
			WHERE id = '".$_GET['id_consulta']."'
		") or die (mysql_error());
	}else{
		echo 'Sucessfully Process';
	}
	mensajes("Sucessfully Process", ($activeDel=='1'?"?url=vistas/tour/createTourSection.view.php":$_SERVER['HTTP_REFERER'].(!$delete?'&delete=0':'')), "info");
?>			
</fieldset>
</td>
</tr>
</table>