<?php
if ($_REQUEST['action']!=''){

	mysql_query("UPDATE config_system SET emails_admin_reports_tags = '".$_REQUEST[emails_admin_reports_tags]."', porcen_reporta_tag = '".$_REQUEST[porcen_reporta_tag]."' WHERE id = '1'") or die (mysql_error());

	 mensajes("Sucessfully Process", "?url=".$_REQUEST[url], "info");
 }

//Sentencia sql (sin limit) 
$_pagi_sql='SELECT r.id_tag, COUNT(r.id_tag) as cant FROM tags t JOIN  tags_report r ON r.id_tag = t.id where r.`status` = 1 GROUP BY r.id_tag ORDER BY COUNT(r.id_tag) DESC';

//cantidad de resultados por página (opcional, por defecto 20) 
$_pagi_cuantos = 3; 

$rp = 1;

//Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente 
include("includes/paginator.inc.php"); 

// echo  $_pagi_sql;

// $num = mysql_num_rows($_pagi_result);

// echo $num;

?>
<fieldset>
	<legend>Information</legend>
        <table width="680" border="1" align="center" cellpadding="2" cellspacing="0" style="font-size:11px; font-weight:normal; text-align:left; border:1px solid #FBCBA4;">
	    <tr style="background-color:#FDE2CC; color:#000000; font-weight:bold">
            <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="160">
                Emails
            </td>
	    </tr>
	    <tr>
	        <td>
				<?php
					$sql =$GLOBALS['cn']->query('SELECT id, emails_admin_reports_tags,porcen_reporta_tag FROM config_system WHERE id = 1');
					$email=mysql_fetch_assoc($sql);
					echo $email['emails_admin_reports_tags'];
	            ?>
	        </td>
	    </tr>
	    <tr style="background-color:#FDE2CC; color:#000000; font-weight:bold">
            <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="160">
                Porcent friends reports
            </td>
	    </tr>
	    <tr>
	    	<td><?=$email['porcen_reporta_tag']; ?></td>
	    </tr>
	    <tr>
	    	<td style="text-align: center">	
		    	<input type="button" onclick="editPorcent()" class="boton" name="Edit" value=" Edit ">
	    	</td>
	    </tr>
	    <?php 
	    	if(isset($_GET['editP'])){
	    	?>
	    	<tr>
		    	<td><br><br>
		    		<form action="?url=vistas/tags/reporTags.view.php" method="post" name="reporta_tag">
			    	<table width="680" border="1" align="center" cellpadding="2" cellspacing="0" style="font-size:11px; font-weight:normal; text-align:left; border:1px solid #FBCBA4;">
					    <tr style="background-color:#FDE2CC; color:#000000; font-weight:bold">
				            <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="160">
				                Emails
				            </td>
					    </tr>
					    <tr>
				            <td>
				            <textarea style="width: 500px" name="emails_admin_reports_tags" id="emails_admin_reports_tags"><?=$email['emails_admin_reports_tags']?></textarea>
				            </td>
					    </tr>
					    <tr style="background-color:#FDE2CC; color:#000000; font-weight:bold">
				            <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="160">
				                Porcent friends reports
				            </td>
					    </tr>
						<tr>
				            <td>
				               <input type="text" size="3" value="<?=$email['porcen_reporta_tag']?>" name="porcen_reporta_tag">
				            </td>
					    </tr>
					    <tr>
				            <td style="text-align: center">
				               <input type="hidden" id="action" name="action" value="1">
				               <input type="submit" id="save" name="save">

				            </td>
					    </tr>
					</table></form><br><br>
		    	</td>
		    </tr>
	    	<?php
	    	}
	    ?>
	</table>
</fieldset>
<br><br>

<fieldset>
	<legend>Reports Tags</legend>
        <table width="680" border="1" align="center" cellpadding="2" cellspacing="0" style="font-size:11px; font-weight:normal; text-align:left; border:1px solid #FBCBA4;">
			<?php 
			$ntag=mysql_num_rows($_pagi_result);
			// $tagsA=mysql_fetch_assoc($_pagi_result);
			// echo print_r($tagsA);
			if ($ntag>0) {
				while($tag=mysql_fetch_assoc($_pagi_result)){

				$infoTags=$GLOBALS['cn']->query('
				SELECT
					r.id_tag,
					ta.id_creator as creator,
					(select CONCAT(name," ",last_name) from users WHERE id=ta.id_creator) as owner,
					(SELECT text FROM translations_template WHERE label=t.descrip) as descrip
				FROM tags_report r
				JOIN type_tag_report t ON r.type_report = t.id
				JOIN users u ON r.id_user_creator = u.id
				JOIN users w ON r.id_user_report = w.id
				JOIN tags ta ON r.id_tag = ta.id
				WHERE r.id_tag = "'.$tag[id_tag].'" AND r.status = 1 ');
				
				$infoT=mysql_fetch_assoc($infoTags);
				
				//cantidad de reportes por tags
				// $Nreport=$GLOBALS['cn']->query('SELECT COUNT(id_tag) as cantidad FROM tags_report WHERE id_tag ="'.$tag[id_tag].'"');
				// $Nreports=mysql_fetch_assoc($Nreport);
				?>
				<tr style="background-color:#FDE2CC; color:#000000; font-weight:bold">
	                <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="160">
	                Who reported
	                </td>
	                <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="205">Number of reports</td>
	                <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="205">Owner</td>
	                <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="339">Decription</td>
	                <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="339">Tag</td>
	                <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="339">Action</td>
	            </tr> 
				<tr>
					<td onclick="my(<?=$infoT['id_tag']?>,<?=$infoT['creator']?>)" style="cursor: pointer;">Users</td>
					<td style="text-align: center"><?=$tag['cant']?></td>
					<td><?=$infoT['owner']?></td>
					<td><?=$infoT['descrip']?></td>
					<td><img src="<?=tagURL($infoT['id_tag'],true)?>" width="650"></td>
					<td align="center">
						<a style="font-weight:normal" href="javascript:void(0)" onClick="if(confirm('Are you sure to disabled this tag ?')){redirect('../controls/tags/actionsTags.controls.php?wpanel&action=6&tag=<?=$infoT['id_tag']?>&url=wpanel/?url=vistas/tags/reporTags.view.php&report')}">Disabled Tag</a>
					</td>
				</tr>
				<tr>
					<td colspan="7">&nbsp;</td>
				</tr>
			<?php } 
			}else{
				echo '<tr><td colspan="7">No records to show</td></tr>';
			}
		?>
	</table>
	<div><?="<p>".$_pagi_navegacion."</p>"?></div>
</fieldset>
<script type="text/javascript">
function my(id,id_tag){
	// alert('hola');
	window.open("vistas/tags/usersTagreport.php?tag="+id+"&creator="+id_tag,"usersTR","width=340,height=350,left=550,top=100,menubar=no");
}
function editPorcent(){
	// alert('hola');
	redirect('?url=vistas/tags/reporTags.view.php&editP=1');
}
</script>
