<?php
	include '../header.json.php';
	$arraytour=array();
		
		$sqlTour=tour_json(trim($_GET['hash']));

		//query para buscar los comentarios del tour
		if($sqlTour!=''){
			while($hashTours=mysql_fetch_array($sqlTour)){
					$arraytour[]=array(
						'id_div'=> $hashTours['id_div'],
						'title'=> utf8_encode(constant($hashTours['title'])),
						'message'=> utf8_encode(constant($hashTours['message'])),
						'position'=> $hashTours['position'],
						'hashTash'=> $hashTours['hash_tash']
					);//array
			}
			die(jsonp(array(
				'liTour'    => $arraytour,
				'firstTime' => tourHash_json($_GET['hash'])==0
			)));
		}
?>
