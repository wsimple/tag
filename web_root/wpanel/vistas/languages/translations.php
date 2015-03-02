<?php
if ($_REQUEST['action']!='') {
	switch ($_REQUEST['action']) {
		case 'insert':

			$query = mysql_query("SELECT id FROM translations WHERE id_lenguage	= '".$_REQUEST[language]."' AND label = '".$_REQUEST[label]."' ") or die (mysql_error());

			if (mysql_num_rows($query)==0){

				mysql_query("INSERT INTO translations
								SET	id_lenguage	= '".$_REQUEST[language]."',
									section		= '".$_REQUEST[section]."',
									label		= '".$_REQUEST[label]."',
									text		= '".$_REQUEST[text]."',
									text_help	= '".$_REQUEST[text_help]."',
									date		= '".date('Y-m-d H:i:s')."',
									cod			= '".$_REQUEST[cod]."'") or die (mysql_error());

				mensajes("Successfully Processed", $_SERVER['HTTP_REFERER'], "info");
				die();

			}else{

				mensajes("Duplicate Label", $_SERVER['HTTP_REFERER'], "error");
				die();

			}
		break;

		case 'update':

			$query = mysql_query("SELECT id FROM translations WHERE id_lenguage	= '".$_REQUEST[language]."' AND label = '".$_REQUEST[label]."' ") or die (mysql_error());

			if (mysql_num_rows($query)==0){
				$sql = "UPDATE translations
							SET	id_lenguage	= '".$_REQUEST[language]."',
								section		= '".$_REQUEST[section]."',
								label		= '".$_REQUEST[label]."',
								text		= '".$_REQUEST[text]."',
								text_help	= '".$_REQUEST[text_help]."',
								date		= '".date('Y-m-d H:i:s')."',
								cod			= '".$_REQUEST[cod]."'
						WHERE id = '".$_REQUEST[id_consulta]."'";
			}else{
				$sql = "UPDATE translations
							SET	text		= '".$_REQUEST[text]."',
								text_help	= '".$_REQUEST[text_help]."',
								date		= '".date('Y-m-d H:i:s')."',
								cod			= '".$_REQUEST[cod]."'
						WHERE id = '".$_REQUEST[id_consulta]."'";
			}

			mysql_query($sql) or die (mysql_error());

			mensajes("Successfully Processed",$_SERVER['HTTP_REFERER'], "info");
			die();
		break;
	}
}
?>

<table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
	<tr>
		<td>
<?php		$frm = new formulario('translations', '?url=vistas/languages/translations.php', 'Send', 'Registers Languages', $metodo='post');
			$frm->inicio();
			if ($_REQUEST['id_consulta']!='')
			{	$frm->consulta=true;
				$where = " WHERE id = '".$_REQUEST['id_consulta']."'";
				$frm->hidden("id_consulta", $_REQUEST['id_consulta']);
				$sql[0] = "SELECT id AS valor, name AS descripcion FROM languages WHERE status = '1' | AND id = '".campo("translations", "id", $_REQUEST['id_consulta'], 1)."'";
				$sql[1] = "SELECT id AS valor, concat(name,' - ', id) AS descripcion FROM sections_page WHERE 1=1 | AND id = '".campo("translations", "id", $_REQUEST['id_consulta'], 2)."'";
				$sql[2] = "SELECT label AS valor, label AS descripcion FROM translations_template  WHERE 1=1 | AND label = '".campo("translations", "id", $_REQUEST['id_consulta'], 3)."'";
			} else {

				if ($_REQUEST[_section_]!='') {

					$_sql_1  = "| and id like '".$_REQUEST[_languages_]."' ";
					$_sql_2  = "WHERE 1=1 | and id like '".$_REQUEST[_section_]."' ";
					$_sql_3  = "WHERE translations_template.section like '".$_REQUEST[_section_]."' and translations_template.label not in(SELECT translations.label FROM `translations` where translations.id_lenguage ='".$_REQUEST[_languages_]."' and TRIM(translations.label) like TRIM(translations_template.label)) | and translations_template.label ='".$_REQUEST[_label_]."' ";
				}

				$sql[0] = "SELECT id AS valor, name AS descripcion FROM languages WHERE status = '1' $_sql_1   ";



				$sql[1] = "SELECT sections_page.id AS valor, sections_page.name AS descripcion FROM sections_page $_sql_2 ";


				$sql[2] = "SELECT translations_template.label AS valor, translations_template.label AS descripcion FROM translations_template $_sql_3   ";
			}

			$frm->selects(array("language"=>$sql[0]));

			$frm->selects(array("section"=>$sql[1]));

			$frm->selects(array("label"=>$sql[2]));

			$frm->inputs("SELECT t.text AS text, t.text_help AS text_help FROM translations t $where");

			$frm->hidden('action',(($_REQUEST[id_consulta]!='')?'update':'insert'));

			$frm->hidden('cod',campo($_REQUEST[_languages_]!=''?"languages":"translations", "id", $_REQUEST[_languages_]!=''?$_REQUEST[_languages_]:$_REQUEST[id_consulta], "cod"));

			$frm->fin(false); 
			
			if ($_REQUEST[_label_]=='') {
				
				$label_select=explode('|',$sql[2]);
				$label_select=mysql_query($label_select[0].' LIMIT 1');
				$label_select=mysql_fetch_assoc($label_select);
				$_REQUEST[_label_]=$label_select[valor];
			
			} ?>
		</td>
	</tr>
	<tr>
		<td>

<?php

		if ($_REQUEST[_section_]!='') {

			$numLabels=mysql_query("SELECT id FROM translations_template ");
			$numLabelsLanguage=mysql_query("SELECT id FROM translations WHERE id_lenguage = '".$_REQUEST[_languages_]."' ");

			$currentLabels=mysql_query("SELECT text FROM translations_template where label = '".$_REQUEST[_label_]."'");
			$currentLabels=mysql_fetch_assoc($currentLabels);

			echo '<fieldset><legend>Translation remaining </legend><strong>'. round(100-((mysql_num_rows($numLabelsLanguage)*100)/mysql_num_rows($numLabels)),2).' % <br />Current template : <br /></strong>


				<div id="languageBlock" class="languageBlock" style="font-weight:normal;">'.$currentLabels[text].'</div>
				<br />&nbsp;';

		}

		$frm->grilla("SELECT
							id,
							label,
							text,
							text_help
						FROM translations", 1); ?>
		</td>
	</tr>
</table>
<script type="text/javascript">
	window.addEvent('domready', function() {
		$('translations_section').addEvent('change', function(){
			window.location = 'index.php?url=vistas/languages/translations.php&_section_='+this.value+'&_languages_='+valor('primero');
		});

		$('translations_label').addEvent('change', function(){
			window.location = 'index.php?url=vistas/languages/translations.php&_label_='+this.value+'&_section_='+valor('translations_section')+'&_languages_='+valor('primero');
		});

	});
	// Set the original/default language
</script>