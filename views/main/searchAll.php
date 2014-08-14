<?php 
$url=$_SERVER['REQUEST_URI']; 
$whereFriends= " WHERE u.status IN (1,5) AND u.id!='".$_SESSION['ws-tags']['ws-user']['id']."' ";
$srh='';
if(isset($_GET['srh'])){
	$srh=$_GET['srh'];
}elseif(isset($_GET['dato'])){
	$srh=$_GET['dato'];
}elseif(!isset($_GET['srh'])){
	$srh='invalid';
}

$srh = urldecode($srh); //Fix De hashtags
set_trending_topings($srh);
if($srh!=""){
	$srh = str_replace(' ', '%', $srh);
	$whereFriends.=' AND CONCAT(email," ",name," ",last_name) LIKE "%'.$srh.'%"';
	$whereGroups='CONCAT(g.description," ",g.name) LIKE "%'.$srh.'%"';
}
$friends=users($whereFriends,3);
//Sugerencia de personas si no hay resultados por criterio de busqueda
$friends_count = mysql_num_rows($friends);
if ($friends_count == 0) $friends = users('', 3, 0, true);

$groups=groups($whereGroups,3);
$groups_count = mysql_num_rows($groups);
//Sugerencias de grupos si no hay
if ($groups_count == 0) $groups=groups('', 3, 0, true);

$hashtags=tags($srh,5);
//die($hashtags);
if (mysql_num_rows($hashtags) == 0) $hashtags=tags('', 5, true);

if($srh=='invalid'){
	$srh=VARIABLE_INVALID;
}
?>
<div id="tabs" class="ui-single-box">
	<ul style="font-size:14px">
		<li><a id="all" href="<?=$url?>#tabs-1"><?=SEARCH_ALLRESULT?></a></li>
		<li><a id="tagsearch" href="<?=$url?>#tabs-2">Tag</a></li>
		<li><a id="hash" href="<?=$url?>#tabs-3"><?=SEARCH_HASHTAGS?></a></li>
		<li><a id="people" href="<?=$url?>#tabs-4"><?=SEARCH_FRIENDS?></a></li>
		<li><a id="group" href="<?=$url?>#tabs-5"><?=SEARCH_GROUPS?></a></li>
		<li><a id="product" href="<?=$url?>#tabs-6"><?=SEARCH_PRODUCT?></a></li>
	</ul>
	<div id="tabs-1">
		<div id="searchAll">
			<div id="contentHash">
				<div class="titleSearchAllhash"><?=SEARCH_HASHTAGS?></div>
				<?php if(@mysql_num_rows($hashtags)>0){?>
				<div>
					 <img id="loadingwaithash" src="css/smt/loader.gif" width="15" height="15"/>
					 <div id="hashJson"></div>
					 <div id="clickhash" class="seemoreSearch" style="display:none"><?=USER_BTNSEEMORE?></div>
					 <div id="msghashclick"><?=SEARCHALL_SEEMORETAGS?> <span id="hashClick"><?=SEARCHALL_SEEMORECLKHERE?></span></div>
					 <div class="clearfix"></div>
				</div>
				<?php }else{ ?>
				<div class="messageNoResultSearch"><?=SEARCHALL_NORESULT.' <span style="font-weight:bold">'.$srh.',</span> <span style="font-size:12px">'.SEARCHALL_NORESULT_COMPLE.'</span>'?></div>
				<?php } ?>
				<div class="clearfix"></div>
			</div>
			<?php //*************************amigos*************************// ?>
			<div class="titleSearchAllfriends"><?=SEARCHALL_PEOPLES?></div>
				<?php if($friends_count==0){ ?>
				<div class="messageNoResultSearch"><?=SEARCHALL_NORESULT.' <span style="font-weight:bold">'.$srh.',</span> <span style="font-size:12px">'.SEARCHALL_NORESULT_COMPLE.'</span>'?></div>
				<div class="ui-single-box-title"><?=SEARCHALL_PEOPLES.' '.EDITFRIEND_VIEWTITLESUGGES?></div>
			<?php } ?>
				<div>
					 <img id="loadingwaitfriends" src="css/smt/loader.gif" width="15" height="15"/>
					 <div id="friendsJson"></div>
					 <div id="clickpeople" class="seemoreSearch" style="display:none;"><?=USER_BTNSEEMORE?></div>
					 <div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
			<?php //*************************grupos*************************// ?>
				<div class="titleSearchAllhashgroup"><?=SEARCHALL_GROUPS?></div>
				<?php if($groups_count==0){ ?>
				<div class="messageNoResultSearch"><?=SEARCHALL_NORESULT.' <span style="font-weight:bold">'.$srh.',</span> <span style="font-size:12px">'.SEARCHALL_NORESULT_COMPLE.'</span>'?></div>
				<div class="ui-single-box-title"><?=SEARCHALL_GROUPS.' '.EDITFRIEND_VIEWTITLESUGGES ?></div>
				<?php } ?>
				<div>
					<img id="loadingwaitgroup" src="css/smt/loader.gif" width="15" height="15"/>
					<div id="groupJson"></div>
					<div id="clickgroup" class="seemoreSearch" style="display:none;"><?=USER_BTNSEEMORE?></div>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div><br>
				<!--**************************************PRODUCT**************************************************-->
					<div class="titleSearchAllhashgroup"><?=SEARCH_PRODUCT?></div>
					<div id="pruebaList">
						<div class="product-list produc"></div>
                         <div id="loaderStore2" style="display:none;width: 600px;float: left;"><span class="store-span-loader"><?=JS_LOADING.' '.PRODUCTS_LIST?></span>&nbsp;&nbsp;<img src="css/smt/loader.gif" width="25" height="25" /></div>
						<div class="clearfix"></div>
					</div>
					<div id="clickproduct" class="seemoreSearch" style="display:none;"><?=USER_BTNSEEMORE?></div>
					<div class="clearfix"></div>
		</div>
	</div>
	<div id="tabs-2">
		<?php include('views/users/search/tagsTabs.php') ?>
	</div>
	<div id="tabs-3">
		<?php include('views/users/search/hashtagsTabs.php') ?>
	</div>
	<div id="tabs-4">
		<?php include('views/users/search/friendsTabs.php') ?>
	</div>
	<div id="tabs-5">
		<?php include('views/users/search/groupsTabs.php') ?>
	</div>
	<div id="tabs-6">
		<?php include('views/users/search/productsTabs.php') ?>
	</div>
</div>
<script type="text/javascript">
$(function(){
	$('#tabs').tabs();
	//hash
	<?php if(mysql_num_rows($hashtags)>0){?>
		hashJson('#hashJson','#loadingwaithash',5,'<?=$srh?>','#clickhash');
	<?php }?>
	//friends
	friendsJson('#friendsJson','#loadingwaitfriends',3,'<?=$srh?>','#clickpeople');
	//groups
	groupsJson('#groupJson','#loadingwaitgroup',3,'<?=$srh?>','#clickgroup');
	$('#clickhash').click(function(){
		$('#hash').click();
		$('html,body').animate({scrollTop:0},'slow');
	});
	$('#clickpeople').click(function(){
		$('#people').click();
		$('html,body').animate({scrollTop:0},'slow');
	});
	$('#clickgroup').click(function(){
		$("#group").click();
		$('html,body').animate({scrollTop:0},'slow');
	});
	<?php if($_GET['in']==1){?>
		$('#tagsearch').click();
		$('html,body').animate({scrollTop:0},'slow');
	<?php } ?>
	$('#hashClick').click(function(){
		$('#tagsearch').click();
		$('html,body').animate({scrollTop:0},'slow');
	});
	
	$('#clickproduct').click(function(){
		$('#product').click();
		$('html,body').animate({scrollTop:0},'slow');
	});
	
	<?php if($_GET['in']==2){?>
		$('#product').click();
		$('html,body').animate({scrollTop:0},'slow');
	<?php } ?>
		
	$('#smTabsHash').click(function(){
		<?php if(isset($_SESSION['ws-tags']['see_more']['hashTabs'])){
			unset($_SESSION['ws-tags']['see_more']['hashTabs']);
		}?>
		var opc={
			data:{
				more   :1,
				search :'<?=$srh?>'
			}
		};
		seemoreNew('<?=$_SESSION['ws-tags']['ws-user']['fullversion']==1?'1':'0'?>','controls/search/hashTabs.json.php','#moreHash','#smTabsHash','#loading_groups','15','auto',opc);
	});


	$('#smTabsFriends').click(function(){
		<?php if(isset($_SESSION['ws-tags']['see_more']['friendsTabs'])){
			unset($_SESSION['ws-tags']['see_more']['friendsTabs']);
		}?>
		var opc={
			data:{
				more:1,
				srh:'<?=$srh?>'
			}
		};
		seemoreNew('<?=$_SESSION['ws-tags']['ws-user']['fullversion']==1?'1':'0'?>','controls/search/friendTabs.json.php','#friendsTabs','#smTabsFriends','#loading_friends','15','auto',opc);
	});

	$('#smTabsGroups').click(function(){
		<?php if(isset($_SESSION['ws-tags']['see_more']['friendsGroups'])){
			unset($_SESSION['ws-tags']['see_more']['friendsGroups']);
		}?>
		var opc={
			data:{
				more:1,
				srh:'<?=$srh?>'
			}
		};
		seemoreNew('<?=$_SESSION['ws-tags']['ws-user']['fullversion']==1?'1':'0'?>','controls/search/groupTabs.json.php','#groupTabs','#smTabsGroups','#loading_groups_search','15','auto',opc);
	});
});
</script>
