<?php
//?tag=758&ajax=1&publicity

if($_GET['asyn']==1 || isset($_GET['publicity'])) {
	include '../../includes/config.php';
	include '../../includes/functions.php';
	include '../../class/wconecta.class.php';
	include '../../includes/languages.config.php';
	include '../../includes/qr/qrlib.php';
	$campoId = 't.id='.$_GET['tag'];
} else {
	if (count($_GET)==1 && isset($_GET['tag']) ){ 
		$campoId = 'substring(md5(t.id),-15) = "'.$_GET['tag'].'"';
	}elseif ($_GET['email']=='' && $_GET['referee']==''){
		include '../../includes/config.php';
		include '../../includes/functions.php';
		include '../../class/wconecta.class.php';
		include '../../includes/languages.config.php';
		include '../../includes/qr/qrlib.php';
		$campoId = 't.id='.$_GET['tag'];
	}else{
		$campoId = 'md5(t.id)="'.$_GET['tag'].'"';
	}
}

	
	$tag = getTagData($_GET['tag']);
	if($tag['idOwner']!=''){

		//if called from mail
		if( $_GET['ajax']!=1 ) {
			$result = $GLOBALS['cn']->query('
				SELECT	view
				FROM	tags_share_mails
				WHERE	md5(id_tag)			= "'.$_GET['tag'].'" AND
						md5(email_destiny)	= "'.$_GET['email'].'" AND
						view				= 0 AND
						referee_number		= "'.$_GET['referee'].'"
			');

			//if the tag comes from mail and it's the first time that the user look at this tag,
			//then add points to the user that sends the tag
			if( mysql_num_rows($result)>0 ) {
				$GLOBALS['cn']->query('
					UPDATE users SET
						accumulated_points	= accumulated_points + '.$tag['points'].',
						current_points		= current_points + '.$tag['points'].'
					WHERE md5(CONCAT(id, "_", email, "_", id) ) = "'.$_GET['referee'].'"');
				$GLOBALS['cn']->query('
					UPDATE tags_share_mails SET
						view = "1"
					WHERE
						md5(id_tag)			= "'.$_GET['tag'].'" AND
						referee_number		= "'.$_GET['referee'].'" AND
						md5(email_destiny)	= "'.$_GET['email'].'"');
				//adding one hit to this tag
				incHitsTag( $_GET['tag'] );
			}
		}
?>
	<div class="html_carousel">
		<div id="tagLineFavorites">
			<?=displayTag($tag)?>
		</div>
		<div class="clearfix"></div>
	</div>
<?php
	}
?>
