<?php
include ('../../../includes/config.php');
include ('../../../class/wconecta.class.php');
include ('../../../includes/conexion.php');
include ('../../includes/funciones.php');

$tags=$GLOBALS['cn']->query('
	SELECT t.id_user_report, u.name, u.last_name, t.date
	FROM tags_report t
	JOIN users u ON u.id=t.id_user_report
	WHERE t.id_tag = "'.$_GET['tag'].'"
');

?>
<fieldset style="border: 1px solid #A5A4A4;">
	<legend>Users Reports Tags</legend>
        <table width="280" border="0" align="center" cellpadding="2" cellspacing="0" style="font-weight:normal; text-align:left; border:1px solid #FBCBA4;">
		<tr>
			<td colspan="6" style="background: #eee"> 
			<?php
				while($tag=mysql_fetch_assoc($tags)){
					echo '<span style="font-size: 14px">- '.$tag['name'].' '.$tag['last_name'].' '.$tag['date'].'</span><br>';
				}
			?>
			</td>
		</tr>
	</table>
</fieldset>
<script type="text/javascript">
// function my(){
// 	// alert('hola');
// 	window.open("http://www.tagbum.com","miventana","width=400,height=350,left=500,top=100,menubar=no");
// }
</script>
