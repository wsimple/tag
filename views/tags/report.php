<?php
	include ("../../includes/session.php");
	include ("../../includes/functions.php");
	include ("../../includes/config.php");
	include ("../../class/wconecta.class.php");
	include ("../../includes/languages.config.php");

	$tipos = $GLOBALS['cn']->query("
		SELECT id, descrip
		FROM type_tag_report
		ORDER BY id
	");
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('select#tipo_reporte').selectmenu({
			menuWidth: 300,
			width: 300
		});		
	});
</script>
<div class="report-tag">
	<h4><?=MNUTAGREPORT_TEXT1?></h4>
	<div class="content"><?=MNUTAGREPORT_TEXT2?></div>
	<h5><?=ACTIONSTAGS_REPORTTAG_TITLESELECT?></h5>
	<div>
		<select name="tipo_reporte" id="tipo_reporte">
        <?php while ($tipo=mysql_fetch_assoc($tipos)){ 
			if(($tipo['id']!='6')&&($tipo['id']!='7')){
			?>
				<option value="<?=md5($tipo['id'])?>" <?php if ($tipo['id']=='5') echo "selected"; ?> ><?=lan($tipo['descrip'])?></option>
			<?php 
			}else if($_SESSION['ws-tags']['ws-user']['super_user']==1&&($tipo['id']=='6'||$tipo['id']=='7')){
			?>
				<option value="<?=md5($tipo['id'])?>"><?=lan($tipo['descrip'])?></option>	
			<?php
			}	
		} ?>
        </select>
	</div>
	<div class="result_report"></div>
</div>