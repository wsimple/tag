<?php
	include '../../includes/session.php';
	include '../../includes/config.php';
	include '../../includes/functions.php';
	include '../../class/wconecta.class.php';
	include '../../includes/languages.config.php';

	if( isset($_GET['default']) ) {

		$date	= $GLOBALS['cn']->query('   SELECT 
                                                id_image_cover,
                                                (SELECT date FROM images WHERE id=id_image_cover) AS date 
                                            FROM album 
                                            WHERE id_user='.$_GET['id_user'].' 
                                            AND name="profile"');
		$date	= mysql_fetch_assoc($date);
		$date	= $date['date'];

	} else {

		$date	= $GLOBALS['cn']->query('SELECT date FROM images WHERE md5(id)="'.$_GET['id_photo'].'"');
		$date	= mysql_fetch_assoc($date);
		$date	= $date['date'];
	}
?>

<script>

	function deletePhoto(idPhoto) {
		if( confirm('Are you sure that you want to delete this picture?') ) {
			$.ajax	({
				type: 'GET',
				url: 'controls/photos/photo.control.php?action=delete&id_photo='+idPhoto,
				dataType: 'html',
				success: function( ) {
					document.location.reload();
				}
			});
		}
	}

	function makeDefaultPhoto() {
		if( confirm('You are going to set this picture as you profile image, proceed?') ) {
			$.ajax	({
				type: 'GET',
				url: 'controls/photos/photo.control.php?action=makeDefault&id_photo=<?=$_GET[id_photo]?>',
				dataType: 'html',
				success: function(  ) {
					document.location.reload();
				}
			});
		}
	}

</script>

<?php
	$width	= 'width: 590px;';
	$height	= 'height: 410px;';
	$style	= '	font-size: 12px; position: absolute; padding-left: 2px;
				padding-right: 2px; color: white;';
	$opa	= '0.5';
?>




<?php // padding t l r b ?>

	<label style="opacity: <?=$opa?>; filter: alpha(opacity=<?=$opa*100?>); margin-top: 372px; background-color: black; width: 592px; height: 42px; <?=$style?>"></label>

	<label style="margin-left: 435px; margin-top: 385px; <?=$style?>">
		Uploaded at:
		<?php // h:i:s A (this is for showing upload time) ?>
		<?=date('Y-m-d',mktime(substr($date,11,2),substr($date,14,2),substr($date,17,2),substr($date,5,2),substr($date,8,2),substr($date,0,4)))?>
	</label>





<?php if( isset($_GET['showMenu']) && $_GET['id_photo'] ) { ?>

	<label style="margin-left: 5px; height: 15px; margin-top: 385px; <?=$style?>">
		<a onclick="deletePhoto('<?=$_GET['id_photo']?>');" style="<?php // border: solid 1px white; ?> border-radius: 5px; padding: 1px 4px 4px 4px; cursor: pointer; color: white;"><?=PRODUCTS_DELETE?></a>
	</label>

	<label style="margin-left: 70px; height: 15px; margin-top: 385px; <?=$style?>">
		<a onclick="makeDefaultPhoto()" style="<?php // border: solid 1px white; ?> border-radius: 5px; padding: 1px 4px 4px 4px; cursor: pointer; color: white;"><?=PICTURE_MAKEPROFILEPIC?></a>
	</label>

<?php } ?>






	<table border="0">
		<tr>
			<td style="<?=$width?> <?=$height?> vertical-align: middle; text-align: center;">
				<img src="<?=$_GET['src']?>" style="max-<?=$height?> max-<?=$width?> left: 50%; top: 50%;"/>
			</td>
		</tr>
	</table>
