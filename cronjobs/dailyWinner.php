<?php
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Content-type: application/json');
    header('Access-Control-Allow-Origin: *');
    $path='../';
    include $path.'includes/config.php';
    include $path.'includes/session.php';
    include $path.'includes/functions.php';
    include $path.'class/wconecta.class.php';
    include $path.'includes/languages.config.php';
	$uid=current($GLOBALS['cn']->queryRow('SELECT id FROM users WHERE email="wpanel@tagbum.com" OR email="wpanel@seemytag.com";'));
    if (!$uid) $wid=CON::getVal('SELECT id FROM users WHERE email="wpanel@tagbum.com" OR email="wpanel@seemytag.com";');
	$date=current($GLOBALS['cn']->queryRow('SELECT NOW();'));
	$fecha=strtotime($date);
    
    
    if (date('j',$fecha)==1){
        //if (date('m',$fecha)==1){
        //    $row=returnSQL('27');
        //    if (count($row)>0){
        //        logAction(27,$row['id_tag'],$row['id_user']);
        //        notifications($row['id_user'],$row['id_tag'],'27',"",$uid);
        //        $puntos=$GLOBALS['cn']->queryRow("SELECT points_owner AS puntos FROM action_points WHERE id_type='27' LIMIT 1");
        //        $totalprice=$puntos['puntos'];
        //        $GLOBALS['cn']->query("	UPDATE users 
        //							SET		accumulated_points = accumulated_points + '".$totalprice."',
        //									current_points = current_points + '".$totalprice."'
        //							WHERE id = '".$row['id_user']."'
        //						");
        //        echo '<br>AÑO<br>';
        //   }
        //}
        $row=returnSQL('26');
        if (count($row)>0){
            logAction(26,$row['id_tag'],$row['id_user']);
            notifications($row['id_user'],$row['id_tag'],'26',"",$uid);
            $puntos=$GLOBALS['cn']->queryRow("SELECT points_owner AS puntos FROM action_points WHERE id_type='26' LIMIT 1");
            $totalprice=$puntos['puntos'];
            $GLOBALS['cn']->query("	UPDATE users 
    							SET		accumulated_points = accumulated_points + '".$totalprice."',
    									current_points = current_points + '".$totalprice."'
    							WHERE id = '".$row['id_user']."'
    						");
            echo '<br>MES<br>';
        }
    }
    $row=returnSQL('22');
    if (count($row)>0){
        $puntos=$GLOBALS['cn']->queryRow("SELECT points_owner AS puntos FROM action_points WHERE id_type='22' LIMIT 1");
        $totalprice=$puntos['puntos'];
    	logAction(22,$row['id_tag'],$row['id_user']);
        notifications($row['id_user'],$row['id_tag'],22,'',$uid);
        $GLOBALS['cn']->query("	UPDATE users 
    							SET		accumulated_points = accumulated_points + '".$totalprice."',
    									current_points = current_points + '".$totalprice."'
    							WHERE id = '".$row['id_user']."'
    						");
        echo '<br>DIA<br>';
    }
    
    if (date('w',$fecha)==0){
        $row=returnSQL('25');
        if (count($row)>0){
            logAction(25,$row['id_tag'],$row['id_user']);
            notifications($row['id_user'],$row['id_tag'],'25',"",$uid);
            $puntos=$GLOBALS['cn']->queryRow("SELECT points_owner AS puntos FROM action_points WHERE id_type='25' LIMIT 1");
            $totalprice=$puntos['puntos'];
            $GLOBALS['cn']->query("	UPDATE users 
    							SET		accumulated_points = accumulated_points + '".$totalprice."',
    									current_points = current_points + '".$totalprice."'
    							WHERE id = '".$row['id_user']."'
    						");
            echo '<br>SEMANA<br>';
        }
    }
    function returnSQL($id_type){
        switch($id_type){
            case '22': $funtion='DAY';        
                $where='DATEDIFF(NOW(),[_TABLE_].date)=1'; 
                break;
            case '25': $funtion='WEEKOFYEAR';
                $where='WEEKOFYEAR([_TABLE_].date)=WEEKOFYEAR(NOW())-1 AND YEAR([_TABLE_].date)=YEAR(NOW())'; 
                break;
            case '26': $funtion='MONTH';
                $where='PERIOD_DIFF(CONCAT(YEAR(NOW()),MONTH(NOW())),CONCAT(YEAR([_TABLE_].date),MONTH([_TABLE_].date)))=1'; 
                break;
            case '27': $funtion='YEAR';
                $where='YEAR([_TABLE_].date)=YEAR(NOW())-1'; 
                break;
        }
        $where2=str_replace('[_TABLE_]','l',$where);
        $where=str_replace('[_TABLE_]','th',$where);
		$sql='
			SELECT t.id_user, th.id_tag, th.hits
			FROM tags_hits th
			JOIN tags t ON t.id=th.id_tag
			WHERE '.$where.'
				AND '.$funtion.'(th.date) NOT IN (  SELECT '.$funtion.'(l.date) 
                                                    FROM log_actions  l
                                                    WHERE l.id_type='.$id_type.' AND ('.$where2.' OR l.date IS NULL))
			ORDER BY th.hits DESC
			LIMIT 1
		';
        echo '<div><pre>'.$sql.'</pre></div>';
		return $GLOBALS['cn']->queryRow($sql);
    }
?>