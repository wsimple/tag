<?php

if( isset($_GET['make']) &&  isset($_GET['sc'])){
	mysql_query("UPDATE tour_section SET active='1' WHERE md5(id) = '".$_GET['sc']."';");
	echo '<meta HTTP-EQUIV="REFRESH" content="0; url=?url=vistas/tour/tourActivate.view.php">';
} elseif( !isset($_GET['make']) &&  isset($_GET['sc'])){
	mysql_query("UPDATE tour_section SET active='0' WHERE md5(id) = '".$_GET['sc']."';");
	echo '<meta HTTP-EQUIV="REFRESH" content="0; url=?url=vistas/tour/tourActivate.view.php">';
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
									 onClick="inicio('<?=($row['active']=='1' ? '?url=vistas/tour/tourActivate.view.php&sc='.md5($row['id']).'' : '?url=vistas/tour/tourActivate.view.php&make&sc='.md5($row['id']).'' )?>')"
									 src="../img/menu_businessCard/<?=($row['active']=='1' ? 'd' : 'makeD')?>efault.png"/>
							</td>
						</tr>
						<?php
				} ?>
                </table>
        </fieldset>
        </td>
    </tr>
</table>
