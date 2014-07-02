<?php
include '../header.json.php';
	
	if (quitar_inyect()){
		
		$monto_inversion = str_replace(',','',$_GET['amount']);
		
		//sondeo
		// $sql = "
		// 	SELECT 
		// 		id, 
		// 		amount_to, 
		// 		cost
		// 	FROM cost_points
		// 	WHERE '".factorBuyPoints($monto_inversion)."' BETWEEN amount_from AND amount_to
		// ";
		
		$sql = "SELECT
				cost_per_point 
			  FROM config_system WHERE id=1";
		
		$valida = $GLOBALS['cn']->queryRow($sql);

		// if (mysql_num_rows($valida)>0){
		// 	//$costos = $GLOBALS['cn']->query($sql);
		// 	$costos = $valida;
		// }elseif (mysql_num_rows($valida)==0){
		// 	$costos = $GLOBALS['cn']->query("
		// 		SELECT 
		// 			MAX(cost) AS cost,
		// 			id,
		// 			amount_to
		// 		FROM cost_points
		// 		GROUP BY cost
		// 		LIMIT 0, 1
		// 	");
		// }

		// $costo  = mysql_fetch_assoc($costos);
		
		//transaction insert
		
		// $pointsToUser = intval($monto_inversion/$costo['cost']);
		// 
		
		$pointsToUser = round($monto_inversion/$valida['cost_per_point']);
		
		$insert = $GLOBALS['cn']->query("
			INSERT INTO users_points_purchase SET
				id_cost = '".$valida['cost_per_point']."',
				id_user = '".$_SESSION['ws-tags']['ws-user']['id']."',
				id_currency = '1',
				cost_investment = '".$monto_inversion."',
				points_bought = '".$pointsToUser."',
				status = '2'
		");
		
		echo "views/pay.view.php?payAcc=buyPoints&uid=".md5(mysql_insert_id());
		
	}else{ //quitar_inyect
		
		echo 'notOk';
		
	}
?>