<?php
	 session_start();
	 include ("../includes/config.php");
	 include ("../includes/functions.php");
	 include ("../class/wconecta.class.php");
	 include ("../includes/languages.config.php");
	 
	 if (isset($_GET['term'])) $_GET['tag']=$_GET['term'];
	 $query = ($_GET['value']!='') ? friendsHelp($_GET['tag'],true) : friendsHelp($_GET['tag']);
	 
	 if (isset($_GET['term'])){
		$result=array();
		while ($array = CON::fetchAssoc($query)){
			$result[]= array('term'=>$_GET['term'],'id'=>$array['value'],'text'=>utf8_encode($array['key']));
		}
		die(json_encode($result));
	 }else{
		 $salida= '[';								 
		 while ($array = CON::fetchAssoc($query)){
			 $array['key'] = utf8_encode( $array['key']);
		     $salida.= json_encode($array); 
		 }
	 	echo str_replace('}{','},{',$salida).']'; 
	 }




	 function friendsHelp($datos,$value=false){
		$user=$_SESSION['ws-tags']['ws-user']['id'];
		dropViews(array('view_friends'));
		$value=$value?"u.id":"u.email";
		//los que el usuario sigue detail as 'key',id as 'value'
		CON::query("CREATE VIEW view_friends AS
					SELECT DISTINCT
					CONCAT(u.name,' ',u.last_name) AS 'key',
					$value AS value,
					l.id_friend AS id_friend
					FROM users u JOIN users_links l ON u.id=l.id_friend
					WHERE l.id_user=?",array($user));
		//amigos
		$dato=explode(' ',$datos);$likes='';
		foreach ($dato as $key) {
			if ($key) $likes.=($likes==''?'':' AND ')."f.key LIKE '%%$key%'";
		}
		$friends=CON::query("	SELECT DISTINCT	f.key AS 'key', md5(f.value) AS value
								FROM view_friends f JOIN users_links u ON f.id_friend=u.id_user
								WHERE u.id_friend=? AND ($likes) LIMIT 0,15;",array($user));
		return $friends;
	}
?>