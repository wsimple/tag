<?php
//includes
include '../header.json.php';

if (quitar_inyect()){
    $res=array();
    if (isset($_REQUEST['search'])){ $srh = $_REQUEST['search']; }
    else{ $srh =''; }
    /*AMIGOS*/
    if($_GET['type']==''||$_GET['type']=='friends'){
        if (isset($_GET['limit'])){
            switch($_GET['limit']){
                case 'basic':   $array['limit']='LIMIT 0,6'; $res['f_maxR']=5; break;
                case 'more' :   $array['limit']='LIMIT '.$_REQUEST['f_limitIni'].',10'; $res['f_maxR']=9; break;
                case 'perso':   $array['limit']='LIMIT '.$_REQUEST['f_limitIni'].','.$_REQUEST['f_limitEnd']; break;
            }   
        }
        $array['where']=    'u.status IN (1,5)';
        $array['where'].=    colocaAND($array['where']).'u.id!="'.$_SESSION['ws-tags']['ws-user']['id'].'"';
        if ($srh!=''){ $array['where'].=colocaAND($array['where']).'CONCAT_WS( " ",u.email, u.name, u.last_name) LIKE "%'.$srh.'%"'; }
        $array['order']='ORDER BY u.name ASC, u.email ASC';
        $friends = peoples($array);
        $friendsarray=array();
        while ($friend=CON::fetchAssoc($friends)){
    		$friend['name_user'] = utf8_encode(formatoCadena($friend['name_user']));
    		$friend['img'] = FILESERVER.getUserPicture($friend['code_friend'].'/'.$friend['photo_friend'],'img/users/default.png');
    		$friendsarray[] = $friend;
    	}
        $num=count($friendsarray);
        $res['friends']=$num>0?$friendsarray:'';
        $res['num_friends']=$num;
    }else $res['friends']='';
    /*GRUPOS*/
    if($_GET['type']==''||$_GET['type']=='groups'){ unset($array);
        if (isset($_GET['limit'])){
            switch($_GET['limit']){
                case 'basic':   $array['limit']='LIMIT 0,6'; $res['g_maxR']=5; break;
                case 'more' :   $array['limit']='LIMIT '.$_REQUEST['g_limitIni'].',10'; $res['g_maxR']=9; break;
                case 'perso':   $array['limit']='LIMIT '.$_REQUEST['g_limitIni'].','.$_REQUEST['g_limitEnd']; break;
            }   
        }
        $array['select']="	,(SELECT ug.status FROM users_groups ug WHERE ug.id_group=g.id and ug.id_user='".$_SESSION['ws-tags']['ws-user']['id']."' LIMIT 1) AS integrant";
        $array['where']=    "(g.id_privacy!='3' OR (g.id_privacy='3' AND g.id=(SELECT ug.id_group FROM users_groups ug WHERE ug.id_group=g.id AND ug.id_user = '".$_SESSION['ws-tags']['ws-user']['id']."' LIMIT 1)))";
        if ($srh!=''){ $array['where'].=colocaAND($array['where']).'CONCAT_WS( " ",g.description, g.name) LIKE "%'.$srh.'%"'; }
        $array['order']='ORDER BY g.date DESC';
        $results = groupss($array);
        $groups=array();
        while($row=  mysql_fetch_assoc($results)){
            $row['name']=  utf8_encode(formatoCadena($row['name']));
    		$row['des']=  utf8_encode(formatoCadena($row['des']));
    		$row['members']=  $row['num_members'];
    		if (!isset($_GET['mobile'])){
        		$row['myPrivateGroup'] = 1;
                switch ($row['integrant']){
                    case '1': $row['buttonGroup']=1; $row['userInGroup']=0; break;
                    case '2': $row['buttonGroup']=2; $row['userInGroup']=0; break;
                    case '5': $row['userInGroup']=1; break;
                    default : $row['buttonGroup']=0; $row['userInGroup']=0;
                }
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
    		}else{
                switch ($row['privacy']) {
    				case 1: $row['privacidad'] = 'Public'; break;
    				case 2: $row['privacidad'] = 'Close'; break;
    				case 3: $row['privacidad'] = 'Private'; break;
    			}
                if (file_exists(DOMINIO.'img/groups/icons/'.$grpname['icon'])||($grpname['icon']!='')){
    				$row['icon'] = DOMINIO.'img/groups/icons/'.$grpname['icon'];
    			}else{ $row['icon'] = DOMINIO.'img/groups/icons/0.png'; }
    		}
            $groups[]=$row;
    	}
        $num=count($groups);
        $res['groups']=$num>0?$groups:'';
        $res['num_groups']=$num;
    }else $res['groups']='';
    /*HASH*/
    if($_GET['type']==''||$_GET['type']=='hash'){ unset($array);
        if (isset($_GET['limit'])){
            switch($_GET['limit']){
                case 'basic':   $limit=5; break;
                case 'more' :   $limit=''; break;
                case 'perso':   $limit=$_REQUEST['h_limitEnd']; break;
            }   
        }
        $hashtags  = tags($srh,$limit);
        $newText = array();
    	while($tag = @mysql_fetch_assoc($hashtags)){
    		$textHash = get_hashtags($tag['text']);
    		$textHash = array_unique($textHash);
    		$textCount = count($textHash);
    		for($i=0;$i<$textCount;$i++){
    			if(strpos($textHash[$i],$srh)!==false){
    				$newText[] = $textHash[$i];
    				$newText = array_unique($newText);
    				if($limit==5){ if(count($newText)>=$limit) break 2;}
    			}
    		}
    	}
        $num=count($newText);
        $res['hash']=$num>0?$newText:'';
        $res['num_hash']=$num;
    }
    /*PRODUCTOS*/
    if($_GET['type']==''||$_GET['type']=='store'){ unset($array);
        if (isset($_GET['limit'])){
            switch($_GET['limit']){
                case 'basic':   $array['limit']='LIMIT 0,7'; $res['s_maxR']=6; break;
                case 'more' :   $array['limit']='LIMIT '.$_REQUEST['s_limitIni'].',10'; $res['s_maxR']=9; break;
                case 'perso':   $array['limit']='LIMIT '.$_REQUEST['s_limitIni'].','.$_REQUEST['s_limitEnd']; break;
            }   
        }
        $array['where']="p.id_status=1 AND p.stock>0";
        if (isset($_GET['mobile'])){ $array['where'].=' AND p.formPayment=0 AND p.id_user!="'.$_SESSION['ws-tags']['ws-user']['id'].'"';}
        $array['select']=',p.formPayment AS pago';
        if($srh!=''){ //si viene palabra de busqueda se filtra por bur busqueda
			$findhash=strpos($srh,',');
			if($findhash!=''){
				$hash=explode(',',$srh);
				$array['where'].=" AND p.description LIKE  '%#".$hash[0]."%'";
                $_SESSION['store']['temp']=$hash[0];
			}else{ 
                $array['where'].=" AND CONCAT_WS( " ",p.name,  p.description) LIKE '%".$srh."%'"; 
                $_SESSION['store']['temp']=$srh;
            }
		}
        $products = array();
        $result=product($array);
        while ($row=  mysql_fetch_assoc($result)){
            $row['id']=md5($row['id']);
            $row['seller'] = utf8_encode(formatoCadena($row['seller']));
            if ($row['id_user']==$_SESSION['ws-tags']['ws-user']['id']){ $row['raffle']=true; }
            if ($array['storeList']) $row['listStore']=true; 
            $row['category'] = utf8_encode(formatoCadena(constant($row['category'])));
            $row['subCategory'] = utf8_encode(formatoCadena(constant($row['subCategory'])));			
            $row['name'] = utf8_encode(formatoCadena($row['name']));
            $photo = FILESERVER.'img/'.$row['photo'];
            if(fileExistsRemote($photo)){ $row['photo'] = $photo; }
            else{ $row['photo'] = DOMINIO.'imgs/defaultAvatar.png'; }
            if (isset($_GET['mobile'])){
                $row['description'] = utf8_encode(formatoCadena((strlen($row['description'])>300) ? substr($row['description'], 0,55)." ..." : $row['description']));
                $row['titleList'] = $row['category'].' > '.$row['subCategory'];
                $row['mid_category'] = md5($row['id_category']);
            }else{ $row['description'] = utf8_encode($row['description']); }
            $products[]=$row;
        }
        $num=count($products);
        $res['store']=$num>0?$products:'';
        $res['num_store']=$num;
    }else $res['store']='';
    die(jsonp($res));
}
function colocaAND($text){ return $text!=''?' AND ':''; }
?>
