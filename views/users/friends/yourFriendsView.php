<?php
	global $section,$params;
	$myId=$_SESSION['ws-tags']['ws-user']['id'];
	if(empty($myId)) $myId=0;
	if($sc==2) $sc='find';
	$find=$sc=='find'||$sc=='dates'?true:false;
	$mod=isset($_GET['mod'])?$_GET['mod']:$sc;
	$numFriends=CON::getVal('SELECT COUNT(id_user) as num from users_links where id_user = ?',array($myId));
?>
<div id="tourSearchFriends"></div>
<div id="yourFriendsView" class="ui-single-box">
	<!-- BARRA TITULO Y BUSQUEDA DE AMIGO -->
	<h3 class="ui-single-box-title" style="background-size:50% 32px;">
		<div id="titleFriends" style="float:left;margin-right:5px;"></div>
		<div id="nf"></div>
		<?php if($find){ ?> 
			<?php if($sc=='dates'&&$_SESSION['ws-tags']['ws-user']['type']==0){ ?>
			<!-- <input id="settings" type="button"/> -->
			<?php }else{ ?>
				<input  id="txtSearchFriend" type="text" class="search" placeholder="<?=lan('USERS_BROWSERFRIENDSLABELTXT1')?>"/>
			<?php } ?>
		<?php } ?>
	</h3>
	<?php if($find){ ?>
	<!-- Filters -->
	<script> var search_filter={};</script>
	<?php
	if($sc=='dates'&&$_SESSION['ws-tags']['ws-user']['type']==0){
		$default_pref=json_decode('{"sex_preference":0,"wish_to":1,"min_age":18,"max_age":40}');
		$sex_preferences=CON::getObject('select id,label from users_sex_preferences');
		$wishes_to=CON::getObject('select id,label from users_wish_to where id>0');
		$pref=CON::getRowObject('select * from users_search_preferences where id>0 and id=?',array($myId));
		if($pref->id!=$myId||$myId==0)
			$pref=$default_pref;
		unset($pref->id);
	?>
	<script>search_filter=<?=json_encode($pref)?>;</script>
	<form id="form-filter" action="controls/users/search_filters.json.php?insert" method="post"><div id="filters" class="ui-single-box clearfix">
		<input id="save" type="submit" value="<?=lan('Save')?>" style="display:none;"/>
		<h3 class="ui-single-box-title">
			<!-- <div style="margin-bottom:30px;"><?=lan('filter','ucw')?></div> -->
			<!-- <input  id="back-settings" type="button"/> -->
			<input id="txtSearchFriend2" type="text" class="search" placeholder="<?=lan('USERS_BROWSERFRIENDSLABELTXT1')?>" style="width:98%;"/>
		</h3>
		<div style="display:none;" class="row">Preferences:<?=json_encode($pref)?></div>
		<div class="row">
			<div class="text"><?=lan('sex','ucw')?>:</div>
			<select name="sex_preference">
				<?php foreach ($sex_preferences as $el) {?>
					<option value="<?=$el->id?>" <?=$el->id==$pref->sex_preference?'selected':''?>><?=lan($el->label,'ucw')?></option>
				<?php } ?>
			</select>
			<div class="divisor"></div>
			<div class="text"><?=lan('wish to','ucf')?>:</div>
			<div id="wish_to">
				<input name="wish_to[]" type="hidden" value="0"/>
				<?php foreach ($wishes_to as $el) {?>
					<input type="checkbox" id="check<?=$el->id?>" name="wish_to[]" value="<?=$el->id?>" <?=($el->id&$pref->wish_to)?'checked':''?> />
					<label for="check<?=$el->id?>"><?=lan($el->label,'ucw')?></label>
				<?php } ?>
			</div>
		</div>
		<div id="age" class="row">
			<div class="text"><?=lan('age','ucw')?>:</div>
			<div id="age-slider"></div>
			<div id="age-values" class="text"></div>
			<input id="min_age" name="min_age" type="hidden" value="<?=$pref->min_age?>"/>
			<input id="max_age" name="max_age" type="hidden" value="<?=$pref->max_age?>"/>
		</div>
	</div></form> &nbsp;
	<?php } ?>
	<!-- END: Filters -->
	<h6 style="top:-10px;">
		<?=FINDFRIENDS_LEGENDOFSEARCHBAR?>
	</h6>
	<?php }else{ ?>
	<!-- RADIO BUTTONS NAV -->
	<form style="position: relative; float: right; top: -41px; display: inline-block;">
		<div id="radio-buttons">
			<input type="radio" id="friends" name="radio" checked="checked"><label for="friends"><?=USER_FINDFRIENDSTITLELINKS?></label>
			<input type="radio" id="unfollow" name="radio"><label for="follow"><?=USER_LBLFOLLOWERS?></label>
			<input type="radio" id="follow" name="radio"><label for="unfollow"><?=USER_LBLFRIENDS?></label>
		</div>
	</form>
	<!-- FIN RADIO BUTTONS NAV -->
	<div class="clearfix"></div>
	<h6>
	<?=YOURFRIENDSVIEW_MESSAGE1?>
		<a href="javascript:void(0);" onclick="message('messages', '<?=FRIENDS_LEARNMORETHIS?>', '<?=YOURFRIENDSVIEW_WHY?>', '', 500, 250);" onFocus="this.blur();"><?=YOURFRIENDSVIEW_MESSAGE2?></a>
	<?=YOURFRIENDSVIEW_MESSAGE3?>
	</h6>
	<?php } ?>
	<div id="tab" class="friends" style="background:#FFF; width:98%; margin:5px;">
		<?=FRIENDS_COMMENTSDINAMICO?><!-- Aquí se carga el contenido dinamicamente...-->
	</div>
</div>
<script type="text/javascript">
(function(){
	var title=new Array(),
		opc={mod:'friends',get:"",find:<?=$find?0:1?>},
		find=<?=$find?0:1?>,
		mod='<?=$sc?>',
		sto;
	opc.mod=mod=='2'?'find':mod;
	// dates
	title['friends'] = '<?=USER_FINDFRIENDSTITLELINKS?>';
	title['follow'] = '<?=USER_LBLFOLLOWERS?>';
	title['unfollow'] = '<?=USER_LBLFRIENDS?>';
	title['find'] = '<?=EDITFRIEND_VIEWLABELSEARCH?>';
	title['dates'] = '<?=EDITFRIEND_VIEWLABELSEARCH?>';
	console.log('titulos',title);
<?php if($sc=='dates'){ ?>
	var f=search_filter,
		values=[f.min_age,f.max_age],
		update=function(val,save){
			if(val) values=val;
			$('#age-values').html('['+values.join(' <?=lan('to')?> ')+']');
			if(sto) clearTimeout(sto);
			if(save) sto=setTimeout(function(){
				$('#filters #save').click();
			},1000);
		},
		update_ui=function(e,ui){
			update(ui.values,true);
		};
	$("#wish_to").buttonset();
	if($("#age-slider .ui-slider").length) $("#age-slider").slider('destroy');
	$("#age-slider").slider({
		min:13,
		max:80,
		range:true,
		step:1,
		values:values,
		change:update_ui,
		slide:update_ui
	});
	$('select').each(function(){
		var w=$(this).attr('w'),opc={};
		if(w) opc['menuWidth']=opc['width']=w;
		if(!this.id.match('_search')) opc['disableSearch']=true;
		$(this).chosen(opc);
	});
	update();
	$('form#form-filter select,form#form-filter input[type="checkbox"]').change(function(){
		$('#filters #save').click();	
	});
	$('#filters #save').click(function(){
		$('#filters #min_age').val(values[0]);
		$('#filters #max_age').val(values[1]);
	})
	$(function(){
		$('form#form-filter').ajaxForm({
			dataType:'json',
			success:function(data){//post-submit callback
				// console.log('filter save success.',data);
				delete data.id;
				search_filter=data;
				$('#tab').html("");
				friendsAndF(opc);
			},
			error:function(){
				console.log('filter save error.');
			},
			complete:function(){
				// console.log('filter save complete.');
			}
		});
	});
<?php }elseif($sc=='find'){ ?>
	$("#radio-buttons").buttonset();
<?php } ?>
<?php if($find){ ?>
	//Acción botones para navegación
	$( "#radio-buttons label" ).click( function(){
		opc.mod = $(this).attr('for');$('#tab').html("");
		redir('friends?sc=1&mod='+opc.mod);
		$('#yourFriendsView div#tab').removeAttr('class').addClass(opc.mod);
		$('#titleFriends').html(title[opc.mod]);
		// friendsAndF(opc);
	});
	$('#yourFriendsView div#tab').removeAttr('class').addClass(opc.mod);
	$('#titleFriends').html(title[opc.mod]);
	if (mod!='') {opc.mod = mod};
	$( "#radio-buttons input#"+opc.mod).click();
<?php }else{ ?>
	$('#tab').html("");
	$('#txtSearchFriend,#txtSearchFriend2').keyup(function() {
		opc.get = $.trim($(this).val());
		if (opc.get!="" && $(this).val().length>2)	{
			opc.get="&search="+opc.get;
			$('#tab').html("");
			friendsAndF(opc);
		}else if($(this).val().length==0){
			opc.get="";
			$('#tab').html("");
			friendsAndF(opc);
		}
	});
<?php } ?>
	$('#titleFriends').html(title[opc.mod]);
	friendsAndF(opc);
	// if (opc.mod=='friends' || opc.mod=='unfollow') {
	if (opc.mod=='friends') {
		$('#tab').on('click', '.divYourFriends.thisPeople input[type="button"]', function() {
			if ($('.divYourFriends.thisPeople').length==1) {
				opc.mod='suggest';
				friendsAndF(opc);
			}
		});
	}
	$('#tab').html('').on('click','#seemore',function(){
		$(this).remove().next('div.clearfix').remove();
		opc.get=(opc.get!=""?opc.get:"")+"&limit="+$("#tab .thisPeople ").length;
		friendsAndF(opc);
	});
	function friendsAndF(opc){
		$('#tab').append('<img src="css/smt/loader.gif" id="loader" width="32" height="32" class="loader" style="margin:0 auto;display:block;">');
		$.ajax({
			url:'controls/users/people.json.php?action=friendsAndFollow&withHtml&mod='+opc.mod+opc.get,
			type:'POST',
			dataType:'json',
			data:search_filter||{},
			success:function(data){
				$('#loader').remove();
				if(data['html']){
					$('#tab').append(data['html']);
					if (opc.find!=0 && opc.get.indexOf("limit")==-1) $('#nf').html('('+data['num']+')');
					if (data['datos'].length>=50) $('#tab').append('<a class="plus" id="seemore"><?=$lang["USER_BTNSEEMORE"]?></a><div class="clearfix"></div>');
				}else if (opc.get.indexOf("limit")==-1){
					if (opc.find==0){
						$('#nf').html('('+0+')');
						if (opc.get!='') $('#tab').html('<div class="messageAdver" style="width: 400px; margin: 70px auto;text-align: center;"><?=$lang["SEARCHALL_NORESULT"]?>: '+opc.get.replace('&search=','')+'</div>');
						else $('#tab').html('<div class="messageAdver" style="width: 400px; margin: 70px auto;text-align: center;"><?=$lang["FRIENDS_NORESULTS"]?></div>');
					}else $('#tab').html('');
				}
				opc.get="";
			}
		});
	}
	window.reloadFriendList=function(){
		friendsAndF(opc);
	};

})();
// console.log('<?=$numFriends?>');
if (<?=$find?1:0?>&&('<?=$numFriends?>'==0)) { tour(SECTION); };
</script>