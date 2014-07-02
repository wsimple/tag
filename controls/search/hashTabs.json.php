<?php
include '../header.json.php';

	if (quitar_inyect()){

		$srh = $_REQUEST['search'];

		if($_REQUEST['more']!=1){
			$x = 0;
			$limit = 5;
		}else{
			$limit = '';
			if(!isset($_SESSION['ws-tags']['see_more']['hashTabs'])){
				$_SESSION['ws-tags']['see_more']['hashTabs']=5;
			}else{
				$_SESSION['ws-tags']['see_more']['hashTabs']+=5;
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
					if($limit==5){if(count($newText)>=$limit) break 2;}
				}
			}
		}


		$textCount = count($newText);

		if($_REQUEST['more']==1){
			$c = 0;
			if($textCount!=0){
				for($i=$_SESSION['ws-tags']['see_more']['hashTabs'];$i<($_SESSION['ws-tags']['see_more']['hashTabs']+6);$i++){
					if($newText[$i]!=''){
						$datos .= $newText[$i].'|';
						$c++;
					}
				}
			}
			die(jsonp(array(
				'hash'   => rtrim($datos),
				'cant'   => $c,
				'idsm'   => 'hash'
			)));
		}else{
			$_SESSION['ws-tags']['ws-user'][textCounter] = $textCount;

			die(jsonp(array(
				'hash'   => $newText,
				'cant'   => $textCount
			)));
		}

	}//quitar_inyect
?>