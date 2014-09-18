<?php
	    session_start();
		include ("../../includes/functions.php");
		include ("../../includes/config.php");
		include ("../../class/wconecta.class.php");
		include ("../../includes/languages.config.php");
		if($_GET['rfl']!=''){
			$query = $GLOBALS['cn']->query("
			SELECT
				a.id_user as id_user,
				u.id AS id_friend,
				u.email as email,
				md5(CONCAT(u.id, '_', u.email, '_', u.id)) AS code_friend,
				CONCAT(u.name, ' ', u.last_name) AS name_user,
				u.username AS username,
				u.profile_image_url AS photo_friend,
				u.country AS country,
				u.followers_count AS followers_count,
				u.friends_count AS friends_count

			FROM store_raffle_join a
			INNER JOIN users u ON u.id=a.id_user
			WHERE md5(a.id_raffle) = '".$_GET['rfl']."'");

		}else{
			$uid=$_SESSION['ws-tags']['ws-user']['id'];
			$tabla=$_GET['g']=='true'?'likes':'dislikes';
            $_GET['t']=  intToMd5($_GET['t']);
			$query = $GLOBALS['cn']->query("SELECT u.id AS id_friend,
													CONCAT(u.`name`, ' ', u.last_name) AS name_user,
													u.description AS description,
													u.email,
													u.country,
													u.followers_count,
													u.friends_count,
													u.profile_image_url AS photo_friend,
													md5(CONCAT(u.id, '_', u.email, '_', u.id)) AS code_friend,
													(SELECT `id_user` AS `id_user` FROM users_links WHERE `id_friend`=u.id AND `id_user`=".$uid.") AS follower
											FROM ".$tabla." f INNER JOIN users u ON f.id_user = u.id
											WHERE md5(f.id_source) = '".$_GET['t']."'
										   ");
		}
?>

<script type="text/javascript">

	$(document).ready(function(){

//		$("button, input:submit, input:reset, input:button").button();

	});


</script>

<?php
       while ($friend = mysql_fetch_assoc($query)){
		   $follower=$friend['follower'];
?>
                <!--<div id="div_<?=md5($friend['id_friend'])?>" style="margin:3px; background-color:#FFF; border:1px solid #CCC; height:75px; border-radius:5px; behavior: url(css/border-radius.htc); -moz-border-radius:5px; -webkit-border-radius:5px; font-size:11px;">-->
                <div class="divYourFriends thisPeople">
                   	<div style="float:left; width:80px; cursor:pointer;">
						<?php
							$fot_	=	FILESERVER.getUserPicture($friend['code_friend'].'/'.$friend['photo_friend'],'img/users/default.png');
						?>
                        <img onclick="$('#commentDialog').dialog('close'); $('#viewUserLikedTag').dialog('close');userProfile('<?=$friend['name_user']?>','Close','<?=md5($friend['id_friend'])?>')" src="<?=$fot_?>" width="60" height="60" style="border: 2px #666666 solid;" />
                    </div>

                    <div class="divYourFriendsDetails">
						<a href="javascript:void(0);"onclick="$('#commentDialog').dialog('close'); $('#viewUserLikedTag').dialog('close');userProfile('<?=$friend['name_user']?>','Close','<?=md5($friend['id_friend'])?>')">
							<?=$friend['name_user']?>
						</a><br>
						<span class="titleField">Email: </span><?=$friend['email']?> <br>
						<?php if ($friend['description'] != '' && $_GET['rfl']!=''){ ?>
						<span class="titleField">PRODUCTS_DESCRIPTION </span><?=$friend['description']?> <br>
						<?php } ?>
						<span class="titleField"><?=USER_LBLFOLLOWERS?>(<?=$friend['followers_count']?>)</span>
						<span class="titleField"><?=USER_LBLFRIENDS?>(<?=$friend['friends_count']?>)</span><br>
                        <?php  if ($friend['country']!= 0) {
							$countryFriend = $GLOBALS['cn']->query('
									SELECT name
									FROM countries
									WHERE id='.$friend['country'].'
									');
							$countryFriends= mysql_fetch_array($countryFriend);
						?>
						<span class="titleField"><?=USERS_BROWSERFRIENDSLABELCOUNTRY?>: </span><?=$countryFriends['name']?><br>
						<?php }  ?>
                    </div>
					<?php
					if($_GET['rfl']==''){
					 if ($friend['id_friend']!=$_SESSION['ws-tags']['ws-user']['id']){ ?>
					<div  style="float:right;">
							<input type="button" value="<?=USER_BTNLINK?>"
								   action="linkUser,<?=md5($friend['id_friend'])?>,2" <?=$follower?'style="display:none"':''?>/>
							<input type="button" value="<?=USER_BTNUNLINK?>"
								   action="linkUser,<?=md5($friend['id_friend'])?>,2" <?=$follower?'':'style="display:none"'?>/>
					</div>
					<?php }
					}?>
					<div class="clearfix"></div>
                </div>
<?php
   }

?>

