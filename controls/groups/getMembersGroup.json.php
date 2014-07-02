<?php
include '../header.json.php';

	if(!$mobile){
		$limit='';$body='';
		$select=',g.status';
		$orderBY='ORDER BY g.status,g.date DESC';
		$where=isset($_GET['status'])?' AND g.status="'.$_GET['status'].'"':'';
	}else{ $limit='LIMIT 0,18';$select='';$orderBY='ORDER BY g.date DESC';$where=''; }
	$sql="
		SELECT
			g.id AS id,
			CONCAT(u.name,' ',u.last_name) AS name,
			u.profile_image_url AS photo,
			md5(CONCAT(u.id,'_',u.email,'_',u.id)) AS code,
			md5(u.id) AS id_user,
			u.email,
			u.followers_count,
			u.friends_count,
			(SELECT c.name FROM countries c WHERE c.id=u.country) AS country,
            (SELECT COUNT(t.id) FROM tags t WHERE md5(t.id_group)='".$_GET['idGroup']."' AND t.id_creator=g.id_user) AS numTags,
            g.is_admin
			$select
		FROM users_groups g
		JOIN users u ON g.id_user=u.id
		WHERE md5(g.id_group) = '".$_GET['idGroup']."' $where 
		$orderBY
		$limit
	";
	$memberGroup=$GLOBALS['cn']->query($sql);
	if(!$mobile){
		if($_GET['actual']==''){
			$num=numRecord('users_groups','WHERE md5(id_group)="'.$_GET['idGroup'].'"');
			$resWeb['total']=$num;
			//$body='<div id="membersGroups">'.(!isset($_GET['status'])?'<div class="titlesGroups" style="padding: 0 1em">'.GROUPS_MEMBERSTITLE.'&nbsp;(<span>'.$num.'</span>)</div><br>':'');
		}
		$creador=campo('groups','md5(id)',$_GET['idGroup'],'id_creator');
		$resWeb['actual']=mysql_num_rows($memberGroup);
		$status=0;
		$i=0;
	}
	$res=array();
	while($friend=mysql_fetch_assoc($memberGroup)){
		$friend['photo']=FILESERVER.getUserPicture($friend['code'].'/'.$friend['photo'],'img/users/default.png');
		$friend['name']=utf8_encode(formatoCadena($friend['name']));
		if(!$mobile){
			if($status!=$friend['status']){
				$status=$friend['status'];
				switch($friend['status']){
					case '1':$body.='<div h="active"><div class="title">'.GROUPS_MEMBER_ACTIVE.'</div>';
						break;
					case '2':$body.='</div><div h="standBy"><div class="title">'.GROUPS_MEMBER_STANDBY.'</div>'; break;
					case '5':
						if($creador==$_SESSION['ws-tags']['ws-user']['id']){$body.=(!isset($_GET['status'])?'</div>':'').'<div h="resque"><div class="title">'.GROUPS_TITLEWINDOWS.'</div>';
							break;
						}else{
							$num=numRecord('users_groups','WHERE md5(id_group)="'.$_GET['idGroup'].'" AND status="5"');
							$resWeb['totalP']=$num;
							break 2;
						}//valido de que el usuario sea el creador
				}
			}
			$body.='
				<div class="membersGroupsWindows">
					<div class="divYourFriends">
						<div h="1">
							<img title="'.$friend['name'].'" width="60" height="60" src="'.$friend['photo'].'" action="profile,'.$friend['id_user'].','.$friend['name'].'"/>
						</div>
						<div h="2">
							<div>
								<a href="javascript:void(0);" action="profile,'.$friend['id_user'].','.$friend['name'].'">'.$friend['name'].'</a><br/>
								<span class="titleField">Email: </span>'.$friend['email'].'<br/>
								<span class="titleField">'.USER_LBLFOLLOWERS.' ('.$friend['followers_count'].')</span>
								<span class="titleField">'.USER_LBLFRIENDS.' ('.$friend['friends_count'].')</span>';
								if($friend['country']!=''){ $body.='<br/><span class="titleField">'.utf8_encode(USERS_BROWSERFRIENDSLABELCOUNTRY).':&nbsp;</span>'.utf8_encode($friend['country']).'<br/>'; }
                                if ($friend['id_user']==md5($creador)){ $body.='<span class="titleField">'.GROUPS_CREATOR.'</span><br/>'; }
                                elseif ($friend['is_admin']=='1'){ $body.='<span class="titleField">'.GROUPS_ADMIN_IS.'</span><br/>'; }
                                if ($friend['numTags']>0){ $body.='<span class="titleField">'.TOUR_TAGS_TITLE.' ('.$friend['numTags'].')</span>'; }
								$body.='
							</div>
						</div>
						<div h="3">';
							switch($friend['status']){
								case '2':$body.='<div class="messageSuccessGroupo">'.JS_GROUPS_WAITAPPROBATION_USERS.'</div>';break;
								case '5':$body.='
									<input type="button" size="20" value="'.GROUPS_ACCEPTUSERS.'" action="acceptUser,'.$_GET['idGroup'].','.$friend['id_user'].'"/>
									&nbsp;<input type="button" size="20" value="'.GROUPS_REJECTTUSERS.'" action="acceptUserN,'.$_GET['idGroup'].','.$friend['id_user'].'">';
								break;
							}
							$body.='
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			';
		}
		$res[]=$friend;
	}
	if(!$mobile){
		$body.='</div>';
		//if($_GET['actual']==''){
			//$body.='<div><input name="btnCloseMembers" id="btnCloseMembers" type="button" value="'.GROUPS_INVITEFRIENDSBTNBACK.'" style="float:right;margin: 1em;"></div></div>';
		//}
        if($resWeb['actual']=='0') unset($body);
		$resWeb['body']=$body;
        $res=$resWeb;
	}
	die(jsonp($res));
?>
