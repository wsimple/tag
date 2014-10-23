<?php
include('../includes/session.php');
include('../includes/config.php');
include('../includes/functions.php');
include('../class/wconecta.class.php');
include('../includes/languages.config.php');

//query
$whereFriends = " WHERE u.status IN (1,5) ";

$term = '';
if ($_GET['term'] != ''){
    $term = str_replace(' ', '%', $_GET['term']);
    //$term = $_GET['term'];
    $whereFriends .= ' AND CONCAT_WS( " ", email, name, last_name, screen_name, username) LIKE "%'.$term.'%"';
    $whereGroups = 'CONCAT_WS( " ",g.description, g.name) LIKE "%'.$term.'%"';
}

$friends = users($whereFriends, 3);
$groups  = groups($whereGroups, 3);
$tags    = tags($term,3);
$productSe  = productS($term,3);

//construye arreglo de resultados
$numrowsinit = mysql_num_rows($friends);
if(!$numrowsinit) $numrowsinit = 0;

for ($x = 0; $x < $numrowsinit; $x++) {
    $friend = mysql_fetch_assoc($friends);

    // $countryUser = $GLOBALS['cn']->query( "SELECT name FROM countries WHERE id = $friend[country]" );
    // $nameCountryUser  = mysql_fetch_assoc($countryUser);

    $jsonResult[$x] = array(
        "people"=> array(
            "category" => SEARCHALL_PEOPLES,
            "id"	   => md5($friend["id_friend"]),
            "name"	   => $friend["name_user"],
            "photo"    => FILESERVER.getUserPicture($friend['code_friend'].'/'.$friend['photo_friend'],'img/users/default.png'),
            "email"    => $friend['email']
        )
    );
}

$numgroups= mysql_num_rows($groups);
if(!$numgroups) $numgroups = 0;
//Al finalizar busqueda en persona busco en grupos
for ($x = $numrowsinit; $group = mysql_fetch_assoc($groups); $x++) {
	 $jsonResult[$x] = array(
        "group"=> array(
            "category"	  => SEARCHALL_GROUPS,
            "id"		  => md5($group["id"]),
            "name"		  => $group["name"],
            "description" => $group['des']
        )
    );
}

//Al finalizar busqueda en grupos busco en tags
$x = 0;
$limit = 5;
$newText = array();

while($tag = @mysql_fetch_assoc($tags)){
	$textHash = get_hashtags($tag['text']);
	$textHash = array_unique($textHash);
	$textCount = count($textHash);

	for($i=0;$i<$textCount;$i++){
		if(strpos($textHash[$i],$term)!==false){
			$newText[] = $textHash[$i];
			$newText = array_unique($newText);
			if(count($newText)>=$limit) break 2;
		}
	}
}
$textCount = count($newText);

for($i=0;$i<$textCount;$i++){
	if($newText[$i]!=''){
		$jsonResult[] = array(
			"hash"=> array(
				"category" => SEARCHALL_HASTASH,
				"hash"     => $newText[$i]
			)
		);
	}
}
//
$pro = $numrowsinit + $numgroups + $textCount;
if(!$pro) $pro = 0;

//Al finalizar busqueda en persona busco en productos
for ($x = $pro; $product = mysql_fetch_assoc($productSe); $x++) {
    $jsonResult[$x] = array(
        "product"=> array(
            "category" => SEARCH_PRODUCT,
            "id"	   => md5($product["id"]),
            "name"	   => $product["name"],
            "cate"     => $product['category'],
			"photo"    => fileExistsRemote(FILESERVER.'img/'.$product['photo'])? FILESERVER.'img/'.$product['photo']:DOMINIO.'imgs/defaultAvatar.png'
        )
    );
}
//_imprimir($jsonResult);
////Al finalizar busqueda en hash busco en productos
//$xp = 0;
//$limitp = 6;
//$newTextp = array();
//
//while($proh = @mysql_fetch_assoc($pHash)){
//	$textHashp = get_hashtags($proh['description']);
//	$textHashp = array_unique($textHashp);
//	$textCount = count($textHashp);
//
//	for($i=0;$i<$textCount;$i++){
//		if(strpos($textHashp[$i],$term)!==false){
//			$newTextp[] = $textHashp[$i];
//			$newTextp = array_unique($newTextp);
//			if(count($newTextp)>=$limitp) break 2;
//		}
//	}
//}
//$textCount = count($newTextp);
//
//for($i=0;$i<$textCount;$i++){
//	if($newTextp[$i]!=''){
//		$value = rtrim($newTextp[$i],'\,\.');
//		$jsonResult[] = array(
//			"product"=> array(
//				"category"	=> SEARCH_PRODUCT,
//				"product"	=> $value
//			)
//		);
//	}
//}

if( count($jsonResult) <= 0 || !isset($jsonResult) || $term == '' ){
    $jsonResult[0] = array(
        "noresult"=> array(
            "category" => NORESULTS,
            "id" => 100,
            "name" => FRIENDS_NORESULTS.'...',
        )
    );
}



//echo JSON to page
die(jsonp($jsonResult));
?>
