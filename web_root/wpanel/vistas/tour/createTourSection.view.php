<?php
if ($_REQUEST['action']!='') {
	$trasTem = array();
	$tras = array();
	switch ($_REQUEST['action']) {
		case 'insert':
			
			$query = mysql_query("SELECT id_div, title, message FROM tour_comment WHERE id_div	= '".$_REQUEST['create_tour_section_div']."'") or die (mysql_error());
			$label_select=mysql_fetch_assoc($query);
			
			$trasTem[0] = "label = '".$label_select['title']."', text = '".$_REQUEST['create_tour_section_title']."',text_help = '".$_REQUEST['create_tour_section_title']."'";
			$trasTem[1] = "label = '".$label_select['message']."', text = '".$_REQUEST['create_tour_section_message']."',text_help = '".$_REQUEST['create_tour_section_message']."'";

			$tras[0] = "label = '".$label_select['title']."', text = '".$_REQUEST['create_tour_section_title']."',text_help = '".$_REQUEST['create_tour_section_title']."',  date = '".date('Y-m-d H:i:s')."', cod	= '".$_REQUEST['cod']."'";
			$tras[1] = "label = '".$label_select['message']."', text = '".$_REQUEST['create_tour_section_message']."',text_help = '".$_REQUEST['create_tour_section_message']."', date = '".date('Y-m-d H:i:s')."', cod	= '".$_REQUEST['cod']."'";
			
			//verifica que no sea duplicado
			$verifyaTrastem = mysql_query("SELECT id FROM translations_template WHERE id_lenguage = '".$_REQUEST['create_tour_section_language']."' AND label = '".$label_select['title']."' ") or die (mysql_error());
			$verifyTras = mysql_query("SELECT id FROM translations WHERE id_lenguage = '".$_REQUEST['create_tour_section_language']."' AND label = '".$label_select['title']."' ") or die (mysql_error());
			
			if (mysql_num_rows($verifyTras)==0&&mysql_num_rows($verifyaTrastem)==0){
				//inserta en translations_template
				for($i=0;$i<count($trasTem);$i++){
					mysql_query("INSERT INTO translations_template
									SET	id_lenguage	= '".$_REQUEST[language]."',
										section		= '11',
										$trasTem[$i]
					") or die (mysql_error());
				}
				
				//inserta en translations
				for($i=0;$i<count($tras);$i++){
					mysql_query("INSERT INTO translations
									SET	id_lenguage	= '".$_REQUEST[language]."',
										section		= '11',
										$tras[$i]
					") or die (mysql_error());
				}
				
				//activa el registro para el tour
				mysql_query("UPDATE tour_comment SET active = '1', position='".$_REQUEST['create_tour_section_position']."' WHERE id_div = '".$_REQUEST['create_tour_section_div']."'") or die (mysql_error());
				
				mensajes("Successfully Processed","?url=vistas/tour/createTourSection.view.php", "info");
				die();
			}else{
				mensajes("Duplicate Label", $_SERVER['HTTP_REFERER'], "error");
				die();
			}
			
//			echo 'leng:'.$_REQUEST['create_tour_section_language'].'<br>sec:'.$_REQUEST['create_tour_section_section'].'<br>';
//			echo 'title:'.$_REQUEST['create_tour_section_title'].'<br>msg:'.$_REQUEST['create_tour_section_content'].'<br>div:'.$_REQUEST['create_tour_section_div'].'<br>';
//			echo 'pos:'.$_REQUEST['create_tour_section_position'].'<br>'.$_REQUEST['action'].'<br>'.$_REQUEST['cod'];

		break;

		case 'update':

//			echo 'leng:'.$_REQUEST['create_tour_section_language'].'<br>sec:'.$_REQUEST['create_tour_section_section'].'<br>';
//			echo 'title:'.$_REQUEST['create_tour_section_title'].'<br>msg:'.$_REQUEST['create_tour_section_message'].'<br>div:'.$_REQUEST['create_tour_section_div'].'<br>';
//			echo 'pos:'.$_REQUEST['create_tour_section_position'].'<br>'.$_REQUEST['action'].'<br>'.$_REQUEST['cod'];
//			echo  $label_select['title'];
//			echo  $label_select['title'];		
			$query = mysql_query("SELECT id_div, title, message FROM tour_comment WHERE id_div	= '".$_REQUEST['create_tour_section_div']."'") or die (mysql_error());
			$label_select=mysql_fetch_assoc($query);
			
			if($_REQUEST['create_tour_section_language']=='1'){
				//echo 'translations_template-';
				$tabla = 'translations_template';
				$where[0] ='label = "'.$label_select['title'].'"';
				$where[1] ='label = "'.$label_select['message'].'"';
				$trasTem[0] = "text = '".$_REQUEST['create_tour_section_title']."',text_help = '".$_REQUEST['create_tour_section_title']."', date = '".date('Y-m-d H:i:s')."'";
				$trasTem[1] = "text = '".$_REQUEST['create_tour_section_message']."',text_help = '".$_REQUEST['create_tour_section_message']."', date = '".date('Y-m-d H:i:s')."'";
				$verifyTras = mysql_query("SELECT id FROM translations_template WHERE label = '".$label_select['title']."' ") or die (mysql_error());
			}else{
				//echo 'translations-';
				$tabla = 'translations';
				$where[0] ='label = "'.$label_select['title'].'"';
				$where[1] ='label = "'.$label_select['message'].'"';
				$tras[0] = "text = '".$_REQUEST['create_tour_section_title']."',text_help = '".$_REQUEST['create_tour_section_title']."',  date = '".date('Y-m-d H:i:s')."', cod	= '".$_REQUEST['cod']."'";
				$tras[1] = "text = '".$_REQUEST['create_tour_section_message']."',text_help = '".$_REQUEST['create_tour_section_message']."', date = '".date('Y-m-d H:i:s')."', cod	= '".$_REQUEST['cod']."'";
				$verifyTras = mysql_query("SELECT id FROM translations WHERE id_lenguage = '".$_REQUEST['create_tour_section_language']."' AND label = '".$label_select['title']."' ") or die (mysql_error());
			}
			
			//echo $label_select['title'].'-----'.$label_select['message'].'<br>';
			
			if($_REQUEST['create_tour_section_language']=='1'){
				if (mysql_num_rows($verifyTras)==0){
					//echo 'si 0 TT'.count($trasTem).'<br>';
					for($i=0;$i<count($trasTem);$i++){
						mysql_query("UPDATE $tabla
								SET	$trasTem[$i]
								WHERE $where[$i]
						") or die (mysql_error());
					}
					mysql_query("UPDATE tour_comment SET position= '".$_REQUEST['create_tour_section_position']."' WHERE id_div='".$_REQUEST['create_tour_section_div']."'") or die (mysql_error());

				}else{
					//echo 'no 0 TT'.'<br>';
					for($i=0;$i<count($trasTem);$i++){
						mysql_query("UPDATE $tabla
								SET	$where[$i],
									$trasTem[$i]
								WHERE $where[$i]
						") or die (mysql_error());
					}
					mysql_query("UPDATE tour_comment SET position= '".$_REQUEST['create_tour_section_position']."' WHERE id_div='".$_REQUEST['create_tour_section_div']."'") or die (mysql_error());
				}
				echo $sql;
			}else{
				if (mysql_num_rows($verifyTras)==0){
					//echo 'si 0 T'.count($tras).'<br>';
					for($i=0;$i<count($tras);$i++){
						mysql_query("UPDATE $tabla
								SET	id_lenguage	= '".$_REQUEST['create_tour_section_language']."',
									section		= '11',
									$tras[$i]
								WHERE $where[$i]
						") or die (mysql_error());
					}
					mysql_query("UPDATE tour_comment SET position= '".$_REQUEST['create_tour_section_position']."' WHERE id_div='".$_REQUEST['create_tour_section_div']."'") or die (mysql_error());

				}else{
					//echo 'no 0 T'.'<br>';
					for($i=0;$i<count($tras);$i++){
						mysql_query("UPDATE $tabla
								SET	$tras[$i]
								WHERE $where[$i]
						") or die (mysql_error());
					}
					mysql_query("UPDATE tour_comment SET position= '".$_REQUEST['create_tour_section_position']."' WHERE id_div='".$_REQUEST['create_tour_section_div']."'") or die (mysql_error());
				}
			}
//
			mensajes("Successfully Processed","?url=vistas/tour/createTourSection.view.php", "info");
			die();
		break;
	}
}

if( isset($_GET['make']) &&  isset($_GET['sc'])){
	mysql_query("UPDATE tour_section SET active='1' WHERE md5(id) = '".$_GET['sc']."';");
	mysql_query("UPDATE tour_comment SET sectionActive='1' WHERE md5(hash_tash) = '".$_GET['sec']."';");
	echo '<meta HTTP-EQUIV="REFRESH" content="0; url=?url=vistas/tour/createTourSection.view.php">';
} elseif( !isset($_GET['make']) &&  isset($_GET['sc'])){
	mysql_query("UPDATE tour_section SET active='0' WHERE md5(id) = '".$_GET['sc']."';");
	mysql_query("UPDATE tour_comment SET sectionActive='0' WHERE md5(hash_tash) = '".$_GET['sec']."';");
	echo '<meta HTTP-EQUIV="REFRESH" content="0; url=?url=vistas/tour/createTourSection.view.php">';
}

$query = mysql_query("SELECT id,sectionTour,active FROM tour_section");
?>
<table width="700" border="0" align="center" cellpadding="2" cellspacing="2">

<?php $style = "style='border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4; text-align:center;'";?>
    <tr>
        <td>
        <fieldset>
       	<legend>Sections of the tour</legend>
                <table width="680" border="0" align="center" cellpadding="2" cellspacing="0" style="font-size:11px; margin-top:10px; margin-bottom:10px; font-weight:normal; text-align:left; border:1px solid #FBCBA4; border-bottom:none">
                <tr style="background-color:#FDE2CC; color:#000000; font-weight:bold">
                    <td <?=$style?>>Section</td>
                    <td <?=$style?>>Active</td>
                </tr>
                <?php
				while( $row = mysql_fetch_assoc($query) ) { ?>

						<tr valign="top">
							<td <?=$style?>> <?=$row['sectionTour']?></td>
							<td	<?=$style?> title="<?=($row['active']=='1' ? 'Remove' : 'Add' )?> Active">
								<img style="cursor: pointer; width: 20px; height: 20px;"
									 onClick="inicio('<?=($row['active']=='1' ? '?url=vistas/tour/createTourSection.view.php&sc='.md5($row['id']).'&sec='.md5($row['sectionTour']).'' : '?url=vistas/tour/createTourSection.view.php&make&sc='.md5($row['id']).'&sec='.md5($row['sectionTour']).'' )?>')"
									 src="css/menu_businessCard/<?=($row['active']=='1' ? 'd' : 'makeD')?>efault.png"/>
							</td>
						</tr>
						<?php
				} ?>
                </table>
        </fieldset>
        </td>
    </tr>
</table>
<table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
	<tr>
		<td>
<?php		$frm = new formulario('Create_tour_section', '?url=vistas/tour/createTourSection.view.php', 'Send', 'Tour', $metodo='post');
			$frm->inicio();
			if ($_REQUEST['id_consulta']!=''){	
				$frm->consulta=true;
				
				$frm->hidden("id_consulta", $_REQUEST['id_consulta']);
				$info = mysql_query("SELECT id_div,title,message,position,hash_tash FROM tour_comment WHERE id = '".$_REQUEST['id_consulta']."'") or die (mysql_error());
				$infoTour=mysql_fetch_assoc($info);
				$wnereCons = "WHERE id = '".$_REQUEST['id_consulta']."'";
				$where = "and 1=1 | and sectionTour like '".$infoTour['hash_tash']."'";
				$whereL = "and 1=1 | and id like '".$_REQUEST[_languages_]."'";
				$secinfo = "SELECT id_div AS valor, id_div AS descripcion FROM tour_comment WHERE active = 1 and id= '".$_REQUEST['id_consulta']."' and 1=1 | and id like '".$_REQUEST['id_consulta']."'";
				$_REQUEST[_section_] = $infoTour['hash_tash'];
				
				
				if($_REQUEST[_languages_]==1){
					$fieldsG = "(SELECT t.text FROM translations_template t WHERE t.label=title) as title_1,(SELECT t.text FROM translations_template t WHERE t.label=message) as message_1";
				}else{
					$fieldsG = "(SELECT t.text FROM translations t WHERE t.label=title) as title_1,(SELECT t.text FROM translations t WHERE t.label=message) as message_1";
				}
			
			} else {
				//campo de titulo y mensaje
				$fieldsG = "title as title_1, message as message_1";
				
				if ($_REQUEST[_languages_]!='') {
					$whereL = "and 1=1 | and id like '".$_REQUEST[_languages_]."'";
				}

				if ($_REQUEST[_section_]!='') {
					$where = "and 1=1 | and sectionTour like '".$_REQUEST[_section_]."'";
					$whereL = "and 1=1 | and id like '".$_REQUEST[_languages_]."'";
					$secinfo = "SELECT id_div AS valor, id_div AS descripcion FROM tour_comment WHERE hash_tash='".$_REQUEST[_section_]."' AND active = 0";
				} 
			}
			
			$wnereG = "WHERE hash_tash='".$_REQUEST[_section_]."' AND active = '1'";
			$leng = "SELECT id AS valor, name AS descripcion FROM languages WHERE status = '1' $whereL";
			$sec = "SELECT sectionTour AS valor, sectionTour AS descripcion FROM tour_section WHERE active = 1 $where";
			
			$frm->selects(array("section"=>$sec));
			
			$frm->selects(array("language"=>$leng),(!isset($_REQUEST[_section_])?1:0));

			$frm->selects(array("div"=>$secinfo));			
			
			$frm->inputs("SELECT $fieldsG FROM tour_comment $wnereCons");
			
			$posi = ($infoTour['position']?$infoTour['position']:'');
			
			$frm->selects(array("position"=>positionTour($posi)));
			
			$frm->hidden('action',(($_REQUEST[id_consulta]!='')?'update':'insert'));

			$frm->hidden('cod',campo("languages", "id", $_REQUEST[_languages_], "cod"));
			
			$frm->fin(false); 
			
			
			?>
		</td>
	</tr>
	<tr>
		<td>

<?php

		if(isset($wnereG)){
			if($_REQUEST['_languages_']==1){
				$titleEn = "SELECT t.text FROM translations_template t WHERE t.label=title";
				$contentEn = "SELECT t.text FROM translations_template t WHERE t.label=message";
			}else{
				$titleEn = "SELECT t.text FROM translations t WHERE t.label=title";
				$contentEn = "SELECT t.text FROM translations t WHERE t.label=message";
			}
			
			$frm->grilla("
				SELECT 
					id,
					id_div, 
					($titleEn) as title, 
					($contentEn) as content,
					position as position,
					hash_tash as section 
				FROM tour_comment $wnereG", 1,$_REQUEST['_languages_']);
		}
		 ?>
		</td>
	</tr>
</table>
<script type="text/javascript">
	window.addEvent('domready', function() {
		$('primero').addEvent('change', function(){
			window.location = 'index.php?url=vistas/tour/createTourSection.view.php&_section_='+valor('primero')+'&_languages_=1';
		});

		$('create_tour_section_language').addEvent('change', function(){
			window.location = 'index.php?url=vistas/tour/createTourSection.view.php&_languages_='+valor('create_tour_section_language')+'&_section_='+valor('primero');
		});

	});
	// Set the original/default language
</script>