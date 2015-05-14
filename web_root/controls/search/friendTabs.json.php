<?php
include '../header.json.php';

	if (quitar_inyect()){

		$friendsarray = array();

		$srh = $_REQUEST['search'];
		$limit = 3;

		if($_REQUEST['more']!=1){
			$ini = 0;
		}else{
			with_session(function($sesion){
				if(!isset($sesion['ws-tags']['see_more']['friendsTabs'])){
					$sesion['ws-tags']['see_more']['friendsTabs']=10;
				}else{
					$sesion['ws-tags']['see_more']['friendsTabs']+=10;
				}
				return $sesion;
			});
			$ini = $_SESSION['ws-tags']['see_more']['friendsTabs'];
		}

		$whereFriends = " WHERE u.status IN (1,5) AND u.id!='".$_SESSION['ws-tags']['ws-user']['id']."' ";
		$whereFriends .= ' AND CONCAT_WS( " ",email,  name,  last_name) LIKE "%'.$srh.'%"';
		$friends = users($whereFriends,$limit,$ini);

		$cant = mysql_num_rows($friends);

		if ($cant == 0) {
			$friends = users($whereFriends,$limit,$ini, true);
			$cant = mysql_num_rows($friends);
			$suggest = true;
		}

		while ($friend = mysql_fetch_assoc($friends)){
			$countryUser = $GLOBALS['cn']->query("SELECT name FROM countries WHERE id = '".$friend['country']."'");
			$nameCountryUser  = mysql_fetch_assoc($countryUser);

			$friend['name_user'] = formatoCadena($friend['name_user']);

			$friend['country'] = ($nameCountryUser['name']!='')? $nameCountryUser['name']:'';

			$friend['img'] = FILESERVER.getUserPicture($friend['code_friend'].'/'.$friend['photo_friend'],'img/users/default.png');
			$friendsarray[] = $friend;

		}
		die(jsonp(array(
			'friends' => $friendsarray,
			'cant'    => $cant,
			'idsm'    => 'friends',
			'suggest' => ($suggest) ? $suggest : false
		)));

	}//quitar_inyect
?>