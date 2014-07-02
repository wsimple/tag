<?php
	include '../header.json.php';

	//UPDATE groups SET id_category=1;
        $fecha=explode('-',$_SESSION['ws-tags']['ws-user']['date_birth']);
        if (isset($_GET['infoG'])){
            //tipo de contenito que manejara el grupo
    		$orienteds = CON::query("
    			SELECT o.description AS des,
    				   o.id AS id
    			 FROM groups_oriented o
    			 WHERE o.status = '1' AND 
                 ((YEAR(CURDATE())-".$fecha[0]." + IF(DATE_FORMAT(CURDATE(),'%m-%d') > ".$fecha[1]."-".$fecha[1].", 0, -1))>=o.rule)
    			 ORDER BY o.id");
    		$info='';
    		while ($row=CON::fetchAssoc($orienteds)){
    			$row['des']=constant($row['des']);
    			$info[]=$row;
    		}
    		$res['oriented']=$info;
            //categoria que puede tener ese grupo
    		$category = CON::query("
    			SELECT  g.name AS name,
                        g.id AS id
    			 FROM groups_category g
    			 WHERE g.id_status = '1'
    			 ORDER BY g.id");
    		$info='';
    		while ($row=CON::fetchAssoc($category)){
    			$row['name']=constant($row['name']);
    			$info[]=$row;
    		}
    		$res['category']=$info;
    		//tipo de privacidad que manejara el grupo
    		$privacys = CON::query("
    			SELECT p.id AS id,
    				   p.name AS name,
    				   p.description AS des
    			 FROM groups_privacy p
    			 WHERE p.status = '1'
    			 ORDER BY p.id");
    		$info='';
    		while ($row=CON::fetchAssoc($privacys)){
    			$row['des']=  constant($row['des']);
    			$row['name']=  constant($row['name']);
    			$info[]=$row;
    		}
    		$res['privacy']=$info;
        }
        $numLimit=$mobile?'12':'6';
		$limit=  isset($_GET['limit'])?"LIMIT ".$_GET['limit'].",".$numLimit:"LIMIT 1";
		$join='';$where='';$i=0;
        $select=',(SELECT cg.name FROM groups_category cg WHERE cg.id=g.id_category) AS cname
                 ,(SELECT cg.summary FROM groups_category cg WHERE cg.id=g.id_category) AS csummary
                 ,(SELECT cg.icon FROM groups_category cg WHERE cg.id=g.id_category) AS cphoto';
        $userId=$_SESSION['ws-tags']['ws-user']['id'];
		if (isset($_GET['list'])){
            $where=safe_sql(" AND ( 
                            	(YEAR(NOW())-".$fecha[0].")>(SELECT q.rule FROM groups_oriented q WHERE q.id=g.id_oriented) 
                            	OR ( 
                            			(YEAR(NOW())-".$fecha[0].")=(SELECT rule FROM groups_oriented WHERE id=g.id_oriented) 
                            				AND 
                            			".$fecha[1].">=MONTH(NOW()) 
                            		) 
                            	)");
			if($_GET['list']=='my'){
				$join="		JOIN users_groups ug ON ug.id_group=g.id";
				$where.=safe_sql("	AND ug.id_user=? AND ug.status='1'",array($userId));
			}else{
				$select.=safe_sql("	,(SELECT ug.status FROM users_groups ug WHERE ug.id_group=g.id and ug.id_user=? LIMIT 1) AS integrant",array($userId));
				$where.=safe_sql("	AND (g.id_privacy!='3' OR (g.id_privacy='3' AND g.id=(SELECT ug.id_group FROM users_groups ug WHERE ug.id_group=g.id AND ug.id_user =? LIMIT 1)))",array($userId));
			}
            //categoria que puede tener ese grupo
            if (isset($_GET['limit']) && $_GET['limit']=='0' && !isset($_GET['srh']) && !$mobile){
                $category = CON::query("
        			SELECT  cg.name AS name,
                            MD5(cg.id) AS id,
                            cg.icon AS cphoto,
                            (SELECT COUNT(g.id) FROM groups g ".$join." WHERE g.id_category=cg.id ".$where.") AS num
        			 FROM groups_category cg
        			 WHERE cg.id_status = '1' AND (  SELECT SUM(g.id) 
                                                    FROM groups g ".$join."
                                                    WHERE g.id_category=cg.id ".$where.") > 0
        			 ORDER BY cg.id");
        		$info='';
        		while ($row=CON::fetchAssoc($category)){
        			$row['name']=formatoCadena(constant($row['name']));
                    $row['cphoto']=$row['cphoto']!=''?DOMINIO.'img/groups/category/'.$row['cphoto']:DOMINIO.'css/smt/menu_left/groups.png';
        			$info[]=$row;
        		}
        		$res['category']=$info;
            }
            //si viene la categoria se filtra por categoria 
    		if(isset($_GET['cate'])){ $where.=safe_sql(" AND md5(g.id_category) =? ",array($_GET['cate'])); }
            if(isset($_GET['srh'])){ //si viene palabra de busqueda se filtra por bur busqueda
    			$findhash=strpos($_GET['srh'],',');
    			if($findhash!=''){ $hash=explode(',',$_GET['srh']); }
                else{ $hash[0]=$_GET['srh']; }
                $where.=safe_sql(" AND g.name LIKE ?",array('%'.$hash[0].'%')); 
            }
		}elseif (isset ($_GET['gid'])){
			$select.="	,g.code AS code,gro.description AS des_o";$join='JOIN groups_oriented gro ON gro.id=g.id_oriented';
			$where=safe_sql("	AND md5(g.id)=? ",array($_GET['gid']));
			if (isset($_GET['profile'])){
				$select.=safe_sql("	,(SELECT ug.is_admin FROM users_groups ug WHERE ug.id_group=g.id AND ug.status='1' AND ug.id_user=? LIMIT 1) AS isAdmin
                            ,if(g.id_creator=?,(SELECT ug.id FROM users_groups ug WHERE ug.status='5' AND ug.id_group=g.id LIMIT 1),'no-creador') AS salicitud
                            ,(SELECT CONCAT(u.name,' ',u.last_name) FROM users u WHERE u.id=g.id_creator LIMIT 1 )AS name_create,DATE(g.date) AS date
                            ,(SELECT DATE(ug.date) FROM users_groups ug WHERE ug.id_group=g.id AND ug.status='1' AND ug.id_user=? LIMIT 1) AS date_join",array($userId,$userId,$userId));
			}
		}
        if ($where!=''){
            		$sql=safe_sql("SELECT DISTINCT DATE(g.date) AS fecha,
        				g.name AS name,
        				g.description AS des,
        				g.icon AS icon,
                        g.id_category AS category,
        				g.id_privacy AS privacy,
        				g.photo AS photo,
        				md5(g.id) AS id,
        				g.id_creator AS creator,
        				if (g.id_creator=?,(SELECT COUNT(*) AS num FROM users_groups u WHERE g.id=u.id_group AND u.status!=2),(SELECT COUNT(*) AS num FROM users_groups u WHERE g.id=u.id_group AND u.status!=2 AND u.status!=5)) AS num_members,
                        (SELECT COUNT(*) AS num FROM users_groups u WHERE g.id=u.id_group AND u.is_admin=1) AS num_admin,
        				g.id_oriented AS oriented
        				$select
        			FROM groups g
        			$join
        			WHERE g.status = '1'
        			$where
        			ORDER BY g.date DESC
        			$limit;",array($userId));
        		$results=CON::query($sql);            
        		$res['numResult']=  CON::numRows($results);
                if ($res['numResult']==0 && isset($_GET['limit']) && $_GET['limit']=='0'){
                    $res['msg']='<div class="messageAdver">'.NOT_MY_GROUP.'</div>';
                }
        		while($row=CON::fetchAssoc($results)){
                    $row['photo2']=FILESERVER.'img/groups/'.$row['photo'];
                    if (isset($_GET['infoG'])){ $row['photothis']=$row['photo']; }
                    $photo=FILESERVER.'img/groups/'.$row['photo'];
                    $photo=fileExistsRemote($photo)?$photo:'';
                    $row['photo']= $photo!=''? 'style="background-image:url(\''.$photo.'\');"':'';
                    $row['cname']=formatoCadena(constant($row['cname']));
                    $row['photoi']= $photo!=''? 'src="'.$photo.'" ':'src="'.DOMINIO.'css/smt/groups_default.png"';
                    if ($mobile){ $row['cate_name']=STORE_CATEGORIES2.': '.$row['cname']; }
                    $row['name']=  formatoCadena($row['name']);
                    $row['des']=  formatoCadena($row['des']);
                    $row['members']=  $row['num_members'];
                    $row['myPrivateGroup'] = 1;
                    switch ($row['integrant']){
                        case '1': $row['buttonGroup']=1; $row['userInGroup']=0; break;
                        case '2': $row['buttonGroup']=2; $row['userInGroup']=0; break;
                        case '5': $row['userInGroup']=1; break;
                        default : $row['buttonGroup']=0; $row['userInGroup']=0;
                    }
                    if (isset($row['des_o'])){ $row['des_o']=formatoCadena(constant($row['des_o'])); }
                    if (isset($_GET['profile'])){$row['name_create']=formatoCadena($row['name_create']); }
                    $row['ctitle']=$row['cname'].': '.constant($row['csummary']);
                    $row['cphoto']=$row['cphoto']!=''?DOMINIO.'img/groups/category/'.$row['cphoto']:DOMINIO.'css/smt/menu_left/groups.png';
        			if ((isset($_GET['list']))&&($_GET['list']=='my')){
        				$row['userInGroup'] = 0;
        				$row['buttonGroup'] =1;
        			}elseif(isset ($_GET['menbers']) || isset ($_GET['allMenbers'])){
        				if(isset ($_GET['menbers'])) $whereMembers=safe_sql(" AND g.id_user!=? AND g.id_user!=(SELECT id_creator FROM groups WHERE md5(id)=?)",array($userId,$row['id']));
        				else $whereMembers='';
        				$sqlMembers=safe_sql("SELECT md5(u.id) AS id,
        									g.is_admin AS admin,
        									CONCAT(u.name,' ',u.last_name) AS label
        							FROM users_groups g INNER JOIN users u ON g.id_user = u.id
        							WHERE md5(g.id_group) =? $whereMembers;",array($row['id']));
        				if (isset($_GET['debug'])) echo '<br><br>'.$sqlMembers.'<br><br>';
        				$members=$GLOBALS['cn']->query($sqlMembers);$allmenber='';
        				while ($member=  mysql_fetch_assoc($members)){
        					$member['label']=  formatoCadena($member['label']);
        					$allmenber[]=$member;
        					if ($member['admin']=='0'){ $memberA[]=$member; }
                            else{ $admin[]=$member; }
        				}
        				$row['allmenbers']=$allmenber;
        				$row['listMembers']=$memberA;
        				$row['listAdmins']=$admin;
        			}elseif(isset ($_GET['profile']) && !$row['isAdmin']){
                        $sqlNoti=  'SELECT 
                                         g.status
                                    FROM users_groups g
                                    WHERE g.id_user="'.$_SESSION['ws-tags']['ws-user']['id'].'" 
                                    AND md5(id_group)="'.$row['id'].'"';
                        $noti=$GLOBALS['cn']->query($sqlNoti);
                        
        				if (mysql_num_rows($noti)>0){
        					$noti=  mysql_fetch_assoc($noti);
        					$row['noti']=$noti;
                            if ($noti['status']=='5'){
                                $textBody='<div><div class="limitComent">'.GROUPS_VALIDATE_MSG_WAITING.'</div>
                                            <div class="btn" >
                                                    <input type="button" size="20" id="back"
                                                            value="'.JS_BACK.'">&nbsp;
                                            </div>
                                        </div>';
                            }else{
                                $textBody='<div><div class="limitComent" >'.GROUPS_ACCEPTINVITATION.'</div>
                                                <div class="btn" >
                                                    <input type="button" size="20"
                                                            value="'.GROUPS_ACCEPTUSERS.'"
                                                            action="acceptInv,'.$row['id'].'">&nbsp;
                                                    <input type="button" size="20"
                                                            value="'.GROUPS_REJECTTUSERS.'"
                                                            action="acceptInv,'.$row['id'].',none">&nbsp;
                                                    <input type="button" size="20" id="back"
                                                            value="'.JS_BACK.'">&nbsp;
                                                </div>
                                            </div>';
                            }
        				}else{
                            if ($row['privacy']!='3'){
                                $textBody='<div><div class="limitComent">'.GROUPS_NOHAVEPERMISSION.'</div>
                                                <div class="btn" >
                                                    <div id="autoriGr" class="messageSuccessGroupo" style="display: none;margin-top: 13px;">'.JS_GROUPS_WAITAPPROBATION.'</div>&nbsp;
                                                    <input type="button" size="20" id="joinGroup"
                                                            value="'.GROUPS_JOINTOTHEGROUP.'"
                                                            action="groupsAction,'.$row['id'].',none">&nbsp;
                                                    <input type="button" size="20" id="back"
                                                            value="'.JS_BACK.'">&nbsp;
                                                </div>
                                            </div>';
                            }else{ 
                                $body='<div><div class="messageAdver">'.GROUPS_VALIDATE_MSG_PRIVATE.'</div>
                                                <div class="btn" >
                                                    <input type="button" size="20" id="back"
                                                            value="'.JS_BACK.'" style="float: right; margin-right: 50px;">
                                                </div>
                                           </div>';$textBody='';
                            }
                        }
                        // <div class="bkgGroup" '.$row['photo'].'></div>
                        $body=$textBody!=''?'<div class="group_info">
                                <div class="bckOvergroup">
                                    <div class="bkgGroup" '.$row['photo'].'></div>
                                    <div class="DescripGroupType">
                                        <div class="TitleTypeGruop">
                                            <div class="limitTitle">
                                                <img src="css/smt/menu_left/groups.png" alt="Group Icons" title="Group" width="20" height="20">&nbsp;&nbsp;'.$row['name'].'
                                            </div>
                                            <div class="complementGruop" style="height: 70px;">'.$textBody.'</div>
                                        </div>
                                </div>
                              </div>':$body;
                        $row['noti']['body']=$body;
        			}
        			//privacidad del grupo
        			switch ($row['privacy']) {
        				case 1:
        					$row['privacidad'] = 'groupPublic'; //$classImgPrivacy
        					$row['etiquetaPrivacidad'] = GROUPS_LABELOPEN;  //$privacyGrp
        					break;
        				case 2:
        					$row['privacidad'] = 'groupPrivate';
        					$row['etiquetaPrivacidad'] = GROUPS_LABELCLOSED;
        					break;
        				case 3:
        					$row['privacidad'] = 'groupSecret';
        					$row['etiquetaPrivacidad'] = GROUPS_LABELPRIVATE;
        					break;
        			}	
        			$rows[]=$row;
        		}   
        }
		$res['list']=$rows;
		die(jsonp($res));
?>
