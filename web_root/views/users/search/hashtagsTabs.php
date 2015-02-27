<div id="hashTabs">
<?php
//PESTANA HASHTAGS
if (mysql_num_rows($hashtabsAll) == 0) {
	$hashtabsAll = $hashtags;
	$suggest = true;
	echo '<div class="messageNoResultSearch">'.SEARCHALL_NORESULT.' <span style="font-weight:bold">'.$srh.',</span> <span style="font-size:12px">'.SEARCHALL_NORESULT_COMPLE.'</span></div><div class="ui-single-box-title">'.EDITFRIEND_VIEWTITLESUGGES.'</div>';
}else{
	$hashtabsAll  = tags($srh);
}

$x = 0;
$limit = 5;
$newText = array();
while($tag = @mysql_fetch_assoc($hashtabsAll)){
	$textHash = get_hashtags($tag['text']);
	$textHash = array_unique($textHash);
	$textCount = count($textHash);

	for($i=0;$i<=$textCount;$i++){
		if( $suggest || preg_match("/(".$srh.")([\w])+/i", $textHash[$i]) ){
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
				
			echo  '<div class="searchHash"><a href="'.base_url('tagslist?current=hash&hash='.urlencode($newText[$i])).'">'.$hashP.$sp.'</a></div>';
		}
	}
	echo  '<div id="moreHash"></div><div class="clearfix"></div></div>';
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