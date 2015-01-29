<?php
	global $section,$params;
	$myId=$_SESSION['ws-tags']['ws-user']['id'];
	if(empty($myId)) $myId=0;
	$find=$sc=='2'||$sc=='find'?true:false;
	$numFriends=CON::getVal('SELECT COUNT(id_user) as num from users_links where id_user = ?',array($myId));
?>
<div id="tourSearchFriends"></div>
<div id="yourFriendsView" class="ui-single-box">
	<!-- BARRA TITULO Y BUSQUEDA DE AMIGO -->
	<h3 class="ui-single-box-title" style="background-size:50% 32px;">
		<div id="titleFriends" style="float:left;margin-right:5px;"></div>
		<div id="nf"></div>
	</h3>
	<?php if($find){ ?>
	<input name="txtSearchFriend" id="txtSearchFriend" type="text" class="txt_box_seekFriendsBrowsers" style="width:200px;position:relative;left:430px;top:-72px;background-repeat:no-repeat;z-index:200;" placeholder="<?=USERS_BROWSERFRIENDSLABELTXT1?>"/>
	<h6 style="top:-10px;">
		<?=FINDFRIENDS_LEGENDOFSEARCHBAR?>
	</h6>
	<!-- Filters -->
	<?php
	if(is_debug()){
		$default_pref=json_decode('{"sex_preference":0,"interest":0,"min_age":18,"max_age":40}');
		$sex_preferences=CON::getObject('select id,label from users_sex_preferences');
		$interests=CON::getObject('select id,label from users_interests');
		$pref=CON::getRowObject('select * from users_search_preferences where id=?',array($myId));
		if($pref->id!=$myId||$myId==0)
			$pref=$default_pref;
	?>
	<style>
		#filters{
			background-color:rgba(245,113,51,0.1);
		}
		#filters > *{
			margin:10px;
		}
		#filters > button{
			margin:0 10px;
		}
		#filters .row{
			float:left;
			width:100%;
		}
		#filters .row > .text{
			margin-top:-4px;
		}
		#filters .row > *{
			float:left;
		}
		#age .ui-slider{
			width:70%;
			margin:0 20px;
			border-color:#ccc;
		}
		#age .ui-widget-content .ui-state-active{
			/*border-color:#c83b0b;*/
			background-color:#FF9D7B;
		}
		#filters > button{
			float:right;
		}
		#filters .chzn-container{
			margin:-6px 5px 0;
		}
	</style>
	<div id="filters" class="ui-single-box clearfix">
		<button><?=lan('Save')?></button>
		<h3 class="ui-single-box-title">
			<div style="margin-bottom:30px;"><?=lan('filter','ucw')?></div>
		</h3>
		<div class="row">Preferences:<?=json_encode($pref)?></div>
		<div id="sex_preferences" class="row">
			<div class="text"><?=lan('sex','ucw')?>:</div>
			<select name="" id="">
				<?php foreach ($sex_preferences as $el) {?>
					<option value="<?=$el->id?>" <?=$el->id==$pref->sex_preference?'selected':''?>><?=lan($el->label,'ucw')?></option>
				<?php } ?>
			</select>
		</div>
		<div id="interests" class="row">
			<div class="text"><?=lan('interests','ucw')?>:</div>
			<select name="" id="">
				<?php foreach ($interests as $el) {?>
					<option value="<?=$el->id?>" <?=$el->id==$pref->interest?'selected':''?>><?=lan($el->label,'ucw')?></option>
				<?php } ?>
			</select>
		</div>
		<div id="age" class="row">
			<div class="text"><?=lan('age','ucw')?>:</div>
			<div id="age-slider"></div>
			<div id="age-values" class="text"></div>
		</div>
	</div>
	<script>(function(){
		var values=[<?=empty($pref->min_age)?18:$pref->min_age?>,<?=empty($pref->max_age)?40:$pref->max_age?>],
			update=function(val){
				if(val) values=val;
				$('#age-values').html('['+values.join(' <?=lan('to')?> ')+']')
			},
			update_ui=function(e,ui){
				update(ui.values);
			};
		if($("#age-slider .ui-slider").length) $("#age-slider").slider('destroy');
		update();
		$("#age-slider").slider({
			min:10,
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
	})();</script>
	<?php } ?>
	<!-- END: Filters -->
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
$(document).ready(function(){
	var title=new Array(),opc={mod:'friends',get:""},find=('<?=$find?0:1?>')*1,mod='<?=$_GET[mod]?>';

	title['friends'] = '<?=USER_FINDFRIENDSTITLELINKS?>';
	title['follow'] = '<?=USER_LBLFOLLOWERS?>';
	title['unfollow'] = '<?=USER_LBLFRIENDS?>';
	title['find'] = '<?=EDITFRIEND_VIEWLABELSEARCH?>';
	if (find!=0){
		//Acción botones para navegación
		$( "#radio-buttons" ).buttonset();
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

	}else{
		opc.mod='find';$('#tab').html("");
		$('#txtSearchFriend').keyup(function() {
			opc.get = $.trim($(this).val());

			if (opc.get!="" && $(this).val().length>2)	{
				opc.get="&search="+opc.get;$('#tab').html("");

				friendsAndF(opc);
			}
		});
	}
	opc.find=find;
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
		opc.get="&limit="+$("#tab .thisPeople ").length;
		friendsAndF(opc);
	});
	function friendsAndF(opc){
		$('#tab').append('<img src="css/smt/loader.gif" id="loader" width="32" height="32" class="loader" style="margin: 0 auto;display:block;">');
		$.ajax({
			url: 'controls/users/people.json.php?action=friendsAndFollow&withHtml&mod='+opc.mod+opc.get,
			type: 'POST',
			dataType: 'json',
			success:function(data){
				$('#loader').remove();
				if (data['html']){
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
});

// console.log('<?=$numFriends?>');
if (('<?=$sc?>'==2)&&('<?=$numFriends?>'==0)) { tour(SECTION); };

</script>