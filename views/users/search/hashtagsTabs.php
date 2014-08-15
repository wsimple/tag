<div id="hashTabs">
<?php
//PESTANA HASHTAGS
$hashtabs  = tags($srh);

$x = 0;
$limit = 5;
$newText = array();
while($tag = @mysql_fetch_assoc($hashtabs)){
	$textHash = get_hashtags($tag['text']);
	$textHash = array_unique($textHash);
	$textCount = count($textHash);

	for($i=0;$i<=$textCount;$i++){
		if( preg_match("/(".$srh.")([A-z])*/i", $textHash[$i]) ){
			$newText[] = $textHash[$i];
		}
	}
	$newText = array_unique($newText);
}
$textCount = count($newText);
if($textCount!=0){
	echo '<div style="padding: 10px 0; width: 100%;">';

	for($i=0;$i<$textCount;$i++){
		if($newText[$i]!=''){
			if((strlen($newText[$i])>55)){
				$hashP = substr($newText[$i], 0, 55);
				$sp = '...';
			}else{
				$hashP = $newText[$i];
				$sp = '';
			}
				
			echo  '<div class="searchHash"><a href="'.base_url('tagslist?current=hash&hash='.$newText[$i]).'">'.$hashP.$sp.'</a></div>';
		}
	}
	echo  '<div id="moreHash"></div><div class="clearfix"></div></div>';
}else{
	echo '<div class="messageNoResultSearch">'.SEARCHALL_NORESULT.' <span style="font-weight:bold">'.$srh.',</span> <span style="font-size:12px">'.SEARCHALL_NORESULT_COMPLE.'</span></div>';
}

?>
<div class="clearfix"></div>
</div>
<?php
if($textCount>=5){
 ?>
	<div id="smTabsHash" class="seemoreSearch"><?=USER_BTNSEEMORE?></div>
	<div class="clearfix"></div>
	<div id="loading_groups"></div>
<?php } ?>