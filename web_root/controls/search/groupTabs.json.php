<?php
include '../header.json.php';

	if (quitar_inyect()){

		$groupsarray = array();
		$srh = $_REQUEST['search'];
		$limit = 3;
		if($_REQUEST['more']!=1){
			$ini = 0;
		}else{
			with_session(function(&$sesion){
				if(!isset($sesion['ws-tags']['see_more']['friendsGroups'])){
					$sesion['ws-tags']['see_more']['friendsGroups']=5;
				}else{
					$sesion['ws-tags']['see_more']['friendsGroups']+=5;
				}
			});
			$ini = $_SESSION['ws-tags']['see_more']['friendsGroups'];
		}

		$whereGroups = 'CONCAT_WS( " ",g.description, g.name) LIKE "%'.$srh.'%"';

		$groups  = groups($whereGroups,$limit,$ini);

		$cant = mysql_num_rows($groups);
		if ($cant == 0) {
			$groups = groups($whereGroups,$limit,$ini, true);
			$cant = mysql_num_rows($groups);
			$suggest = true;
		}

		while ($group = mysql_fetch_assoc($groups)){
				$group['members'] = $group['num_members']; //$num_members
                $group['name']=  utf8_encode($group['name']);
                $group['photo2']=FILESERVER.'img/groups/'.$group['photo'];
                $photo=FILESERVER.'img/groups/'.$group['photo'];
                $photo=fileExistsRemote($photo)?$photo:'';
                $group['photo']= $photo!=''? 'style="background-image:url(\''.$photo.'\');"':'';
                $group['cname']=formatoCadena(lan($group['cname']));
                $group['photoi']= $photo!=''? 'src="'.$photo.'" ':'src="'.DOMINIO.'css/smt/groups_default.png"';
                $group['ctitle']=$group['cname'].': '.lan($group['csummary']);
                $group['cphoto']=$group['cphoto']!=''?DOMINIO.'img/groups/category/'.$group['cphoto']:DOMINIO.'css/smt/menu_left/groups.png';
				//privacidad del grupo
				switch ($group['privacy']) {
					case 1:
						$group['privacidad'] = 'groupPublic'; //$classImgPrivacy
						$group['etiquetaPrivacidad'] = GROUPS_LABELOPEN;  //$privacyGrp
						break;
					case 2:
						$group['privacidad'] = 'groupPrivate';
						$group['etiquetaPrivacidad'] = GROUPS_LABELCLOSED;
						break;
					case 3:
						$group['privacidad'] = 'groupSecret';
						$group['etiquetaPrivacidad'] = GROUPS_LABELPRIVATE;
						break;
				}

//				$foto = getPicture(RELPATH."img/groups/".$group['photo'], '');
//				$group['photo'] = ($foto!='')?"style='background-image:url("."img/groups/".$group['photo'].")'":""; 
//
				$group['id'] = md5($group['id']); //$idGroup

				 //cortar la descripcion del grupo si supera los 300 caracteres

				 $cad = strlen($group['des']);//$cad

				 if($cad>300){
					$group['des'] = substr($group['des'], 0,300)."..."; //$cad_c
				 }

				//verificar si el usuario pertenece al grupo en lista
				 $isInGroup = $GLOBALS['cn']->query("SELECT status FROM users_groups WHERE md5(id_group) = '".$group['id']."' and id_user = '".$_SESSION['ws-tags']['ws-user'][id]."'");
                 $status=  mysql_fetch_assoc($isInGroup);
                    switch ($status['status']){
                        case '1': $group['userInGroup']=0; $group['buttonGroup']=1; break;
                        case '2': $group['userInGroup']=0; $group['buttonGroup']=2; break;
                        case '5': $group['userInGroup']=1; break;
                        default : $group['userInGroup']=0; $group['buttonGroup']=0;
                    }
				if (groupsOriented($group['oriented'])){

					if ($group['privacy']==3){

						$validate = $GLOBALS['cn']->query("
								 SELECT id_user
								 FROM users_groups
								 WHERE md5(id_group) = '".$group['id']."' AND id_user = '".$_SESSION['ws-tags']['ws-user']['id']."'");

					   if (mysql_num_rows($validate)>0 || $group['creator'] == $_SESSION['ws-tags']['ws-user']['id']){
						   $group['myPrivateGroup'] = 1;
					   }else{
						   $group['myPrivateGroup'] = 0;
					   }
					}
				}
				$groupsarray[] = $group;
		}

		die(jsonp(array(
			'group' => $groupsarray,
			'cant'  => $cant,
			'idsm'  => 'groups',
			'suggest' => ($suggest) ? $suggest : false
		)));
	}//quitar_inyect
?>