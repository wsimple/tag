<?php 
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) =='xmlhttprequest'){
	include 'header.json.php';
}else{
	include '../includes/config.php';
	include RELPATH.'includes/session.php';
	include RELPATH.'includes/functions.php';
	include RELPATH.'class/wconecta.class.php';
	include RELPATH.'includes/languages.config.php';
}
require_once RELPATH.'controls/facebook/facebook.php';
$user=$facebook->getUser();
if($user){
	try {
		$user_profile = $facebook->api('/me/?fields=id,first_name,last_name,email,birthday,location,gender');

		//Si peticion es ajax del profile
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) =='xmlhttprequest') {
			$response = array('success'=>-1, 'email'=>'');
			$uid = $_SESSION['ws-tags']['ws-user']['id'];
			$query = "SELECT email FROM users 
				  WHERE id = '".$uid."' LIMIT 1";

			if( $email = current( $GLOBALS['cn']->queryRow($query) ) ){
				if ($email == $user_profile['email'] || isset( $_GET['forced'] )) {
					$query = "UPDATE users SET fbid='".$user_profile['id']."' WHERE id='$uid' LIMIT 1";
					$GLOBALS['cn']->query($query);
					$response['success'] = 1;
				}else{
					$response['success'] = 0;
					$response['email'] = $user_profile['email'];
				}
			}

			die(jsonp(array('fb'=>$response)));
		}
		$query = "SELECT *,CONCAT(name,' ',last_name) AS full_name,MD5(concat(id,'_',email,'_',id)) AS code 
				  FROM users 
				  WHERE fbid = '".$user_profile['id']."' LIMIT 1";
		if( $user = $GLOBALS['cn']->queryRow($query) ){
			createSession($user);
			redir('.');
		}else{
			redir('#signup?o=fb');
		}
	} catch (FacebookApiException $e) {
		$user = null;
	}
}
?>