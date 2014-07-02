<?php
	$lat1=10.217597;
	$alt1=-68.00964549999999;
	$lat2=10;
	$alt2=-68;
	$rel=1;//1=1km
	$sql="
		SELECT (
			6371 * ACOS(
				SIN(RADIANS($lat1)) * SIN(RADIANS($lat2)) +
				COS(RADIANS($lat1)) * COS(RADIANS($lat2)) *
				COS(RADIANS($alt1 - $alt2))
			) * $rel
		) AS distance
		FROM direcciones
		HAVING distance < 1
		ORDER BY distance ASC;
	";
?>
