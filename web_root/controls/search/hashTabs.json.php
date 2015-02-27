<?php
include '../header.json.php';

	if (quitar_inyect()){
		if($_REQUEST['more']!=1){
			$x = 0;
			$limit = 16;
		}else{
			$limit = '';
			if(!isset($_SESSION['ws-tags']['see_more']['hashTabs'])){
				$_SESSION['ws-tags']['see_more']['hashTabs']=5;
			}else{
				$_SESSION['ws-tags']['see_more']['hashTabs']+=5;
			}
		}

		$srh = urldecode($_REQUEST['search']);
		$hashtags  = tags($srh,$limit);
		$cant = mysql_num_rows($hashtags);

		if ($cant == 0) {
			$hashtags  = tags('',$limit, true);
			$suggest = true;
		}
		$newText = array();
		while($tag = @mysql_fetch_assoc($hashtags)){
			$textHash = get_hashtags(strtolower($tag['text']));
			//$textHash = array_unique($textHash);
			$textCount = count($textHash);

			for($i=0;$i<=$textCount;$i++){
				if( $suggest || preg_match("/(".$srh.")([A-z0-9])*/i", $textHash[$i]) ){
					$newText[] = $textHash[$i];
					if (count($newText) > $limit) break 2;
				}
			}
		}
		//$newText = array_unique($newText);
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
				'hash'   => array_unique($newText),
				'cant'   => $textCount,
				'suggest' => ($suggest) ? $suggest : false
			)));
		}

	}//quitar_inyect
?>