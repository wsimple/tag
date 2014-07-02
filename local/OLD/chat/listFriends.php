<?php
 	include ("../includes/session.php");
	include ("../includes/config.php");
	include ("../includes/functions.php");
	include ("../class/wconecta.class.php");
	include ("../includes/languages.config.php");
	
	//_imprimir($_SESSION);
	//die();
	//sleep(5);
		$friends=viewChatFriends();
		$salida= '{"a":"1","f":[';
		$aux=array();
		$reload=false;
		while($friend=mysql_fetch_assoc($friends)){
			
			$fot_=FILESERVER."img/users/".$friend[c].'/'.$friend[p];
			
			$friend[n]=htmlentities(str_replace(chr(152),'',$friend[n]));
			//echo htmlentities($friend[s]).' '.ord("'").' &apos;<br />';
			$friend[s]=htmlentities(str_replace(chr(152),'',$friend[s]));
			
			
			$friend[p] = $friend[p]==''?'img/users/default.jpg':$fot_;
			if($_SESSION['ws-tags']['ws-user']['chatListFriends'][$friend[c]]!=$friend[t])$reload=true;
			   $_SESSION['ws-tags']['ws-user']['chatListFriends'][$friend[c]]=$friend[t];
				   
			$salida.= json_encode($friend);
		
		 }
		
		 
		if($reload||$_GET[p]==1){
	
			 echo str_replace('}{','},{',$salida).']}';
			 
		}else{
			
			echo '';
		}
	
?>