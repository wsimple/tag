<?php 
	include '../header.json.php';
	$raffles = $GLOBALS['cn']->query("
		SELECT 
			u.id AS id_user,
			concat_ws (' ', u.name, u.last_name) AS name_user,
			u.email AS email,
			md5(concat(u.id,'_', u.email,'_', u.id)) AS code,
			u.profile_image_url AS photo,
			u.username AS username,
			u.followers_count AS followers_count,
			(select a.name from countries a where u.country=a.id) AS country
		FROM users u JOIN store_raffle_join j ON u.id=j.id_user
		WHERE j.id_raffle = '".$_GET['raffle']."'
	");
	$body = '';
	while ($row = mysql_fetch_assoc($raffles)){		
		$body .= '
			<div class="divYourFriends thisPeople" style="width:450px; height: 70px;">
				<div style="float:left; width:80px; cursor:pointer;">
		        	<img src="'.(FILESERVER.getUserPicture($row['code'].'/'.$row['photo'],'img/users/default.png')).'" border="0"  width="62" height="62" />
		    	</div>
	    		<div style="float:left;">
	        		<div style="float:left;">
	            		<a href="javascript:void(0);" onclick="userProfile(\''.$row['name_user'].'\',\'Close\',\''.$row['id_user'].'\')">
	            			<img src="css/smt/menu_left/friends.png" alt="Friends Icons" title="Person" width="20" height="20">'.ucwords($row['name_user']).'
	            		</a>
	            		<br>';
	    
					    if ($row['username']!=''){
					    	$body.='<span class="titleField">'.USERS_BROWSERFRIENDSLABELEXTERNALPROFILE.':</span>&nbsp;<a style="color:#ccc; font-size:12px;" href="'.base_url($row['username']).'" onFocus="this.blur();" target="_blank">'.DOMINIO.$row['username'].'</a><br><div class="clearfix"></div>';
						}

						$body.='<span class="titleField">Email:</span>'.$row['email'].'<div class="clearfix"></div>';

						if ($row['country']!=''){
							$body.='<span class="titleField">'.USERS_BROWSERFRIENDSLABELCOUNTRY.':&nbsp;</span>'.$row['country'].'<div class="clearfix"></div><br>';
						}

		$body.='
					</div>
				</div>
			</div>
		';
	}
	echo $body;
?>