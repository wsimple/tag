<?php
include('../../includes/session.php');
include('../../includes/config.php');
include('../../includes/functions.php');
include('../../class/wconecta.class.php');
include('../../includes/languages.config.php');

define('MAXSHOW', 10); //Numero de registros a mostrar por pagina

//Verificamos si hay alguna tab en petición
$o = '';
if( isset($_GET['tab']) ) $o = $_GET['tab'];
if ( isset( $_GET['c'] ) ) $page = $_GET['c'];
else $page = 1;

$id=="";
$user = ($id=="") ? md5($_SESSION['ws-tags']['ws-user']['id']) : md5($id);
dropViews( array("view_friends1") );
if( strlen($o) > 0){
	$sql='';$sql2='';
	switch ( $o ) {
		case 'rbAdmiradores':
			$sql='SELECT * FROM users_links l JOIN users u ON u.id = l.id_user WHERE md5(l.id_friend) = "'.$user.'" AND l.is_friend = 0';
		break;
		case 'rbAdmirados':
			$sql='SELECT * FROM users_links l JOIN users u ON u.id=l.id_friend WHERE md5(l.id_user) = "'.$user.'" AND l.is_friend = 0';
		break;
		default:
			$sql='SELECT * FROM users_links l JOIN users u ON u.id=l.id_friend WHERE md5(l.id_user)="'.$user.'" AND l.is_friend = 1';
		break;		
	}
	$result=$GLOBALS['cn']->query($sql);
	
}
//Si ya es mi amigo lo saco de la lista de admiradores
$numRs = mysql_num_rows($result);
//if ($sql2!=''){
//	$result2=$GLOBALS['cn']->query($sql2);
//	$numRs=$numRs-mysql_num_rows($result2);
//	unset($result2);	//Liberamos resultado...
//}
//unset($result);	//Liberamos resultado...

define('LASTPAG', ceil($numRs / MAXSHOW) );
$page=(int)$page;
if($page > LASTPAG) $page= LASTPAG;
if($page < 1) $page=1;

//echo $o;
if( strlen($o) > 0){
	//Selector de pestaña a mostrar
	switch ( $o ) {
		case 'rbAdmiradores':
			$follower=false;
			$no_id=rtrim($not_ids,',');
			$not_ids = ($not_ids!='') ? " AND l.id_user NOT IN (".$no_id.")" : "";
			$result = followers("", rtrim($not_ids,','), ($page -1) * MAXSHOW . ',' .MAXSHOW);
			$rnf = mysql_num_rows($result);
		break;
		case 'rbAdmirados':
			$follower=true;
			$result = following('', ($page -1) * MAXSHOW . ',' .MAXSHOW);
			$rnf = mysql_num_rows($result);
		break;
		default:
			$follower=true;
			$result = view_friends('','','', ($page -1) * MAXSHOW . ',' .MAXSHOW);			
			$rnf = mysql_num_rows($result);
		break;
		
	}
	if ($numRs==0 && $page==1){
		//relleno de sugerencias, por rand
		$result = randSuggestionFriends(""); //incremetar el 0 por si se necesita relleno
		$follower=false;
	}
	resultTab($result, $o, $page,$follower,$numRs);
}

function resultTab( $rs, $rb, $ft,$follower,$numRs){
	
	$ft += 1; //Incremento para la siguiente pagina
?>
<script>
	$(document).ready(function() {
		//$("button, input:submit, input:reset, input:button").button();
		var msj = '';
		var pag=<?=$ft?>;

		$( "#btnSeeMore" ).click( function(){
			//$("button, input:submit, input:reset, input:button").button();
			var msj = '<?=$rb?>';

			$(this).slideUp();
			$('#tabMore').attr('id', 'tabmore'+pag);
			send_ajax('controls/users/yourFriends.control.php?tab='+msj+'&c='+pag, '#tabmore'+pag, 0, 'html');
		});
	});
</script>
	<?php 
	if ($numRs==0 && $ft==2){
	?>
		<div class="ui-single-box-title">
			<?=HOME_SUGGESTFRIENDS?>
		</div>
	<?php
	}
	while($row = mysql_fetch_assoc( $rs )) { 
		if (!isFriend(($_GET['tab']=='rbAdmirados')?$row['id_friend']:$row['id_user'])){
	?>
	<div id="div_<?=$_GET['tab']=='rbAdmiradores'?md5($row['id_user']):md5($row['id_friend'])?>" class="divYourFriends">
		<div style="float:left; width:80px; cursor:pointer;">
	        <img onclick="userProfile('<?=$row['name_user']?>','Close','<?=md5($row['id_friend'])?>')" src="<?=FILESERVER.getUserPicture($row['code_friend'].'/'.$row['photo_friend'],'img/users/default.png')?>" border="0"  width="62" height="62" style="border: 1px solid #ccc" />
	    </div>
	    <div style="float:left; width:450px;
	    ">
	        <div style="width:450px; float: left;">
	            <a href="javascript:void(0);" onclick="userProfile('<?=$row['name_user']?>','Close','<?=md5($_GET['tab']!='rbAdmiradores'?$row['id_friend']:$row['id_user'])?>')">
	            	<img src="css/smt/menu_left/friends.png" alt="Friends Icons" title="Person" width="20" height="20">
	                <?=ucwords($row['name_user'])?>
	            </a><br>
				<?php if($row['username']!=''){?>
				<span class="titleField"><?=USERS_BROWSERFRIENDSLABELEXTERNALPROFILE?>:</span>&nbsp;<a style="color:#ccc; font-size:12px;" href="<?=base_url($row['username'])?>" onFocus="this.blur();" target="_blank"><?=DOMINIO.$row['username']?></a><br>
				<div class="clearfix"></div>
				<?php }?>
				<span class="titleField">Email:</span> <?=$row['email']?>
				<div class="clearfix"></div>
				<span class="titleField"><?=USER_LBLFOLLOWERS?>(<?=$row['followers_count']?>)</span> 
				<span class="titleField"><?=USER_LBLFRIENDS?>(<?=$row['friends_count']?>)</span><br>
				<?php if($nameCountryUser!=''){?>
				
				<span class="titleField"><?=USERS_BROWSERFRIENDSLABELCOUNTRY?>:&nbsp;</span><?=$nameCountryUser['name']?>
				<div class="clearfix"></div><br>
				<?php }?>
	        </div>
	        <div style="height:70px; width:0px;float: right; text-align: right;">
	            	<input name="btn_link_<?=md5($row['id_user'])?>"
					id="btn_link_<?=$_GET['tab']=='rbAdmiradores'?md5($row['id_user']):md5($row['id_friend'])?>"
					type="button" value="<?=USER_BTNLINK?>"
					action="linkUser,#div_<?=$_GET['tab']=='rbAdmiradores'?md5($row['id_user']):md5($row['id_friend'])?>,<?=$_GET['tab']=='rbAdmiradores'?md5($row['id_user']):md5($row['id_friend'])?>" <?=$follower?'style="display:none"':''?> />
					
					<input name="btn_unlink_<?=md5($row['id_user'])?>"
					id="btn_unlink_<?=$_GET['tab']=='rbAdmiradores'?md5($row['id_user']):md5($row['id_friend'])?>"
					type="button" value="<?=USER_BTNUNLINK?>"
					action="linkUser,#div_<?=$_GET['tab']=='rbAdmiradores'?md5($row['id_user']):md5($row['id_friend'])?>,<?=$_GET['tab']=='rbAdmiradores'?md5($row['id_user']):md5($row['id_friend'])?>,true" <?=$follower?'':'style="display:none"'?> />
	        </div>
	    </div>
	    <div class="clearfix"></div>
	</div>
	<?php
			} //Fin del comprobación de amigo
		$not_ids .= "'".$row['id_friend']."',";
	}// Fin del while...

	if( $ft-1 < LASTPAG && $ft-1 > 0){ ?>
	<div id="tabMore">
		<a id="btnSeeMore" class="plus"><?=USER_BTNSEEMORE?></a>
		<div class="clearfix"></div>
	</div>
	<?php } 

} ?>
<script type="text/javascript">
		$(document).ready(function()
		{
			$('#nf').html('('+<?=$numRs?>+')');
		});

</script>
