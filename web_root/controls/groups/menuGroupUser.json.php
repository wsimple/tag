<?php
	include '../header.json.php';
	if (!$myId) {
		die('{}');
	}
    if (isset($_GET['code'])){
        $users = CON::query("SELECT id FROM users WHERE md5(concat(id,'_',email,'_',id)) = ? ",array($_GET['code']));
        //$users = CON::query("SELECT id FROM users WHERE id = 7 ");
        $user  = CON::fetchAssoc($users);
        $mnUseGrp = $user['id'];
    }

	switch ($_GET['action']){
		case '1':
        $fecha=explode('-',$_SESSION['ws-tags']['ws-user']['date_birth']);
		//grupos del usuario
		 $userGrpName = CON::query("
			SELECT DATE(g.date) AS fecha,
				g.id AS id,
				g.name AS name
			FROM groups g INNER JOIN users_groups t ON  g.id = t.id_group
			WHERE g.status = '1' 
            AND t.id_user = ?
            AND t.status=1 
            AND ((YEAR(CURDATE())-".$fecha[0]." + IF(DATE_FORMAT(CURDATE(),'%m-%d') > ".$fecha[1]."-".$fecha[1].", 0, -1))>=(SELECT o.rule FROM groups_oriented o WHERE o.id=g.id_oriented))   
			ORDER BY t.date_update DESC
			LIMIT 0, 2
		",array($mnUseGrp));

//		while ($grpUname = mysql_fetch_array($userGrpName)){
		while ($grpUname = CON::fetchAssoc($userGrpName)){
			$grpUname['icon'] = (DOMINIO.'img/groups/icons/'. $grpUname['icon']);
			$arrayMyGroups[] = array(
				'id'			=> $grpUname['id'],
				'name'			=> utf8_encode($grpUname['name'])
			);
		}

		//grupos en general
		$GrpNames = CON::query("
			SELECT DATE(g.date) AS fecha,
				g.id AS id,
				g.name AS name,
				g.description AS des,
				g.photo as photo,
				g.id_creator AS creator
			FROM groups g
			WHERE g.status = '1' 
            AND g.id_privacy NOT IN (3) 
            AND g.id NOT IN(    SELECT users_groups.id_group 
                                FROM `users_groups` 
                                WHERE users_groups.id_user = ?
                                AND users_groups.status='1')
            AND ((YEAR(CURDATE())-".$fecha[0]." + IF(DATE_FORMAT(CURDATE(),'%m-%d') > ".$fecha[1]."-".$fecha[1].", 0, -1))>=(SELECT o.rule FROM groups_oriented o WHERE o.id=g.id_oriented))
			ORDER BY RAND()
			LIMIT 0, 2
		",array($mnUseGrp));

		//while ($grpname = mysql_fetch_array($GrpNames)){
		while ($grpname = CON::fetchAssoc($GrpNames)){
			$grpname['name']=utf8_encode($grpname['name']);
			$arrayAllGroups[] = $grpname;
		}
	break;
	case '2':
		//grupos en general
		$GrpNames = CON::query("
			SELECT DATE(g.date) AS fecha,
				g.id AS id,
				g.id_privacy AS privacy,
				g.name AS name,
				g.description AS des,
				g.photo as photo,
				g.icon as icon,
				g.id_creator AS creator
			FROM groups g
			WHERE g.status = '1' AND g.id_privacy!='3' OR (g.id_privacy='3' AND g.id=(SELECT ug.id_group FROM users_groups ug WHERE ug.id_group=g.id AND ug.id_user = ? LIMIT 1))
			ORDER BY g.date DESC
		",array($mnUseGrp));

		//while ($grpname = mysql_fetch_array($GrpNames)){
		while ($grpname = CON::fetchAssoc($GrpNames)){
			//orientacion del grupo
			if($grpname['privacy']=='1'){ $typePrivacy = 'Public'; }
            elseif($grpname['privacy']==2){ $typePrivacy = 'Close';
			}elseif($grpname['privacy']==3){ $typePrivacy = 'Private'; }
			//n° de miembros del grupo
			$members = CON::query("SELECT COUNT(*) AS cant FROM users_groups WHERE id_group ='".$grpname['id']."'");
			$membersGrp = CON::fetchAssoc($members);

			//$arrayAllGroups[] = $grpname;
			//$grpname['photo'] = (DOMINIO.'img/groups/'. $grpname['photo']);
			if (file_exists(DOMINIO.'img/groups/icons/'.$grpname['icon'])||($grpname['icon']!='')){
				$icon = DOMINIO.'img/groups/icons/'.$grpname['icon'];
			}else{ $icon = DOMINIO.'img/groups/icons/0.png'; }


//			$grpname['icon'] = (DOMINIO.'img/groups/icons/'.$grpname['icon']);
//			$icon = $grpname['icon']==''?DOMINIO.'img/groups/icons/0.png':$grpname['icon'];
			$arrayAllGroups[] = array(
				'id'			=> $grpname['id'],
				'name'			=> utf8_encode($grpname['name']),
				'privacy'		=> $typePrivacy,
				'members'		=> $membersGrp['cant'],
				'fecha'			=> $grpname['fecha'],
				'icon'			=> $icon
			);
		}

		$out = '2';

	break;
	case '3':
		//grupos del usuario
		$userGrpName = CON::query("
			SELECT DATE(g.date) AS fecha,
				g.id AS id,
				g.id_privacy AS privacy,
				g.name AS name,
				g.description AS des,
				g.photo as photo,
				g.icon as icon,
				g.id_creator AS creator
			FROM groups g
			WHERE g.status = '1' AND g.id in( SELECT users_groups.id_group FROM `users_groups` WHERE users_groups.id_user = ? )
			ORDER BY g.date DESC
		",array($mnUseGrp));

		while ($grpUname = CON::fetchAssoc($userGrpName)){
			//orientacion del grupo
			if($grpUname['privacy']=='1'){ $typePrivacy = 'Public'; }
            elseif($grpUname['privacy']==2){ $typePrivacy = 'Close'; }
            elseif($grpUname['privacy']==3){ $typePrivacy = 'Private'; }
			//n° de miembros del grupo
			$members = CON::query("SELECT COUNT(*) AS cant FROM users_groups WHERE id_group = ? ", array($grpUname['id']));
			$membersGrp = CON::fetchAssoc($members);

			// $arrayMyGroups[] = $grpUname;
			//$grpUname['photo'] = (DOMINIO.'img/groups/'. $grpUname['photo']);
			if (file_exists(DOMINIO.'img/groups/icons/'.$grpname['icon'])||($grpname['icon']!='')){
				$icon = DOMINIO.'img/groups/icons/'.$grpname['icon'];
			}else{ $icon = DOMINIO.'img/groups/icons/0.png'; }
//			$grpUname['icon'] = (DOMINIO.'img/groups/icons/'. $grpUname['icon']);
//			$icon = $grpname['icon']==''?DOMINIO.'img/groups/icons/0.png':$grpname['icon'];
			$arrayMyGroups[] = array(
				'id'			=> $grpUname['id'],
				'name'			=> utf8_encode($grpUname['name']),
				'privacy'		=> $typePrivacy,
				'members'		=> $membersGrp['cant'],
				'fecha'			=> $grpUname['fecha'],
				'icon'			=> $icon
			);
		}
		$out = '3';

	break;
	case '4':
		//nombre del grupos
		$userGrpName = CON::query('
			SELECT
				g.id AS id,
				g.name AS name
			FROM groups g
			WHERE md5(g.id)= ? 
		',array($_GET['idGroup']));

		$grpUname = CON::fetchAssoc($userGrpName);

		//actualizar fecha de actividad en el grupo por el usuario
		$date_update = CON::query("UPDATE users_groups SET	date_update = now() WHERE id_group= ? AND id_user= ? ", array($grpUname['id'],$mnUseGrp));

		if($_GET['tag']==0){
			//valida si el usuario esta registrado en el grupo y activa el boton ADD TAG
			$addTag = CON::query("SELECT id_group FROM users_groups WHERE id_user = ? AND md5(id_group) = ? AND status=1", array($mnUseGrp, $_GET["idGroup"]));
//			$inGroup = (mysql_num_rows($addTag)>0) ? '1': '0';
			$inGroup = (CON::numRows($addTag)>0) ? '1': '0';
			
		}else{
			$inGroup = '0';
		}

		$out = '4';

		die(jsonp(array(
			'name'		=>  utf8_encode($grpUname['name']),
			'out'		=>  $out,
			'inGroup'	=>  $inGroup,
			'tag'		=>  $_GET['tag']
		)));

	break;
	case '5':
        $mnUseGrp;
		$userGrpPrivacy = CON::query("
			SELECT 
                id_privacy,
                (SELECT status FROM users_groups WHERE md5(id_group)= ? AND id_user= ?) AS status
            FROM groups 
            WHERE md5(id)= ? LIMIT 1;
                ", array($_GET['idGroup'], $mnUseGrp, $_GET['idGroup']));
        $result=  CON::fetchAssoc($userGrpPrivacy);
		if($result['id_privacy']=='1'){ 
		  switch($result['status']){
                case '2': $out = 'invit';  break;
                case '5': $out = 'pend';  break;
                default : $out = 'no';
            }        
        }else{ 
            switch($result['status']){
                case '1': $out = 'no';  break;
                case '2': $out = 'invit';  break;
                case '5': $out = 'pend';  break;
                default : $out = 'si';
            }
        }

		die(jsonp(array(
			'idGroup'	=>  $_GET['idGroup'],
			'out'		=>  $out
		)));
	break;
	case '6':
		$users = CON::query("SELECT id_user,is_admin,
									(SELECT COUNT(id) FROM users_groups WHERE is_admin='1' AND md5(id_group) =?) AS numAdm
			FROM users_groups WHERE md5(id_group) =? AND id_user=? AND status='1' LIMIT 1",array($_GET['idGroup'],$_GET['idGroup'],$mnUseGrp));
		if (CON::numRows($users)>0){
			$admin='';$numAdm='';
			while ($row=CON::fetchAssoc($users)) {
				$admin=$row['is_admin'];
				$numAdm=$row['numAdm'];
			}
			die(jsonp(array('isMember'=>true,'admin'=>$admin,'numAdm'=>$numAdm)));
		}else die(jsonp(array('isMember'=>false)));
	break;
	case '7':
		if((isset($_GET[idGroup]))&&!existe('users_groups', 'id_user', " WHERE md5(id_group) ='".$_GET['idGroup']."' AND id_user='".$mnUseGrp."'")){

			$id_group = campo('groups', 'md5(id)', $_GET[idGroup], 'id');

			$GLOBALS['cn']->query("INSERT INTO users_groups
									SET id_group = '".$id_group."',
										id_user  = '".$mnUseGrp."',
										date_update = now()
			");

			$out = '1';
			die(jsonp($out));

		}else{
			$out = '0';
			die(jsonp($out));
		}

	break;
	}

	// die(jsonp($arrayMyGroups));
	if(($_GET[action]!=4)||($_GET[action]!=5)||($_GET[action]!=6)||($_GET[action]!=7)){
		die(jsonp(array(
			'myGroups'		=> $arrayMyGroups ,
			'allGroups'		=> $arrayAllGroups,
			'out'			=> $out
		)));
	}
?>
