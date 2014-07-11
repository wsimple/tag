<div class="group-details" id="taglist-box">
	<div class="ui-single-box-title" style="display: none;">
		<span style="float:left;"><a href="#groups?" title=""><?=GROUPS_TITLENAMEGROUPPREFIJO?></a>&nbsp;>&nbsp;</span><div id="groupTitleStyle" title=""></span></div>
		<ul id="subMenuAdminGroups" class="mainMenu" style="float: right; background: #FFF;">
			<li>
				<a class="fNiv mo" ><?=GROUPS_MENUADMINISTRATION?></a>
				<ul>
					<li class="arrow" style=" padding-left: 35px"></li>
					<li id="btneditprofilegroup"></li>
					<li><a id="btnShowMembers" class="linkOptionGrouop"><?=GROUPS_NEWMEMBERS?></a></li>
					<li><a id="btnInviteFriends" class="linkOptionGrouop"><?=GROUPS_INVITEFRIENDSBTNINVITE?></a></li>
					<li><a id="btnLeaveGroup" class="linkOptionGrouop"><?=GROUPS_MENULEAVEGROUP?></a></li>
				</ul>
			</li>
		</ul>
		<a id="btnNewGroup" class="float-right"><?=GROUPS_TITLEWINDOWSNEW?></a>
		<a id="btncreateTags" class="float-right" ><?=MAINMNU_CREATETAG?></a>
		<form>
			<div class="tags-size">
				<?=RADIOBTN_VIEW?>:
				<input type="radio" name="radio" id="normal" <?=$_SESSION['ws-tags']['ws-user']['view_type_timeline']==0?'checked="checked"':''?>/><label title="Normal Tags" for="normal">&nbsp;</label>
				<input type="radio" name="radio" id="mini" <?=$_SESSION['ws-tags']['ws-user']['view_type_timeline']!=0?'checked="checked"':''?>/><label title="Mini Tags" for="mini">&nbsp;</label>
			</div>
		</form>
	</div>
	<br/>
    <div id="info-top-groups"></div>
    <div class="clearfix"></div>
	<div class="tags-list">
		<div class="tag-container" style="margin: 0 auto;"></div>
		<img src="css/smt/loader.gif" width="32" height="32" class="loader" style="display: none;"/>
	</div>
	<div class="clearfix"></div>
</div>
<script type="text/javascript">
	//ScrollPane Favoroites
	$(document).ready(function() {
		var $box=$('#taglist-box').last(),
			idg='<?=$_GET['grp']?$_GET['grp']:''?>';
		$('#subMenuAdminGroups').jMenu();
		if (idg!=''){
			$$.ajax({
				type	:	"GET",
				url		:	"controls/groups/listGroups.json.php?gid="+idg+"&profile=1",
				dataType:	"json",
				success	:	function (data) {
					if (data['list']){
						$('div#groupTitleStyle').attr('title',data['list'][0]['name']);
						$('div#groupTitleStyle').html(data['list'][0]['name']);
						if (data['list'][0]['isAdmin']){
						  console.log(data['list'][0]['sqlw'])
							$('.group-details .ui-single-box-title').css('display','block');
							$('.group-details .ui-single-box-title a#btncreateTags').attr('href','#creation?group=<?=$_GET['grp']?>');
							if (data['list'][0]['isAdmin']=='1'){
								$('li#btneditprofilegroup').html('<a class="linkOptionGrouop"><?=GROUPS_PROFILETITLE?></a>');
								$('#btneditprofilegroup a').click(function(){
									addNewGroup('<?=EDITGROUPS_PROFILETITLE?>','&grp='+idg);
								});
							}
							tagsListGroups();
							if ((data['list'][0]['salicitud']) && (data['list'][0]['salicitud']!='no-creador')){
								//membersGroups(5);
                                membersGroups(5,'<?=$_GET['grp']?>');
							}
							$('#btnNewGroup').click(function(){
								addNewGroup('<?=GROUPS_TITLEWINDOWSNEW?>','');
								return false;
							});
							$('#btnLeaveGroup').click(function(){
								actionGroup(idg,4,'');
								return false;
							});
							//Accion del boton ver miembros
							$('#btnShowMembers').click(function(){
								membersGroups('','<?=$_GET['grp']?>');
								return false;
							});
							$('#btnInviteFriends').click(function(){
								inviteFriendsToGroup('<?=GROUPS_INVITEFRIENDSBTNINVITE?>','<?=$_GET['grp']?>');
								return false;
							});
                            $('#info-top-groups').html(det_info(data['list'][0]));
                            $('#info-top-groups a').click(function(){
                                if ($(this).parents('article').hasClass('info')){ dialog_info(data['list'][0]); }
                                else if ($(this).parents('article').hasClass('member')){ membersGroups('','<?=$_GET['grp']?>');  }
                                return false;
                            });
						}else{
							if (data['list'][0]['noti']['body']){
								$('.tags-list').hide().after('<div id="info">'+data['list'][0]['noti']['body']+'</div>');
								$('.btn input#back').click(function(){ history.back(); });
							}
						}
					}else{
						$.dialog({
							title	: '<?=SIGNUP_CTRTITLEMSGNOEXITO?>',
							content	: '<?=TAGS_WHENTAGNOEXIST?>',
							height	: 200,
							close	: function(){ redir('#groups?'); }
						});
					}			
				}
			});
			function tagsListGroups(){
				$('.tags-size,.tray').buttonset()
				.find('[title]').tipsy({html:true,gravity:'n'});
				var ns='.tagsList',//namespace
					layer=$box.find('.tag-container')[0],
					opc={
						current:'group',
						layer:layer,
						grupo:'<?=$_GET['grp']?>',
						get:'&grupo=<?=$_GET['grp']?>'
					};
				var sizeTags='<?=$_SESSION['ws-tags']['ws-user']['view_type_timeline']==0?'normal':'mini'?>',interval,
					refresh=function(){ updateTags('refresh',opc,false); };
				$.on({
					open:function(){
						updateTags('reload',opc);
						interval=setInterval(refresh,30000);
						//scrolling
						$(window).on('scroll'+ns,function(){
							if(opc.actions.more===false){
								$(window).off('scroll'+ns);
							}else{
								var $layer=$('header',PAGE),//global
									scrollEnd=$(layer).height()-$layer.offset().top-$layer.height(),//window scroll ending position
									scroll=parseInt($(layer).offset().top),//actual content position
									offset=800;//when to
								if(scrollEnd+scroll<offset) updateTags('more',opc);
							}
						});


						var bandera=true;
						$('.tags-size').on('click','input',function(){
							var id=this.id;
							if(sizeTags!=id){
								if(id=='normal'){
									$box.removeClass('mini');
								}else{
									$box.addClass('mini');
								}
								console.log(bandera);
								sizeTags=id;
								if(bandera){
									bandera=false;
									$.ajax({
										url:'controls/users/viewTimeline.control.php?'+id,
										type:'get'
									}).done(function(){
										bandera=true;
									});
								}
							}
						});
					
						// $('tags-size').on('click','input',function(){
						// 	var id=this.id;
						// 	if(sizeTags!=id){
						// 		$.ajax({
						// 			url:'controls/users/viewTimeline.control.php?'+id,
						// 			success:function(data){
						// 				if(id=='normal'){ $box.removeClass('mini'); }
      //                                   else{ $box.addClass('mini'); }
						// 				sizeTags=id;
						// 			}
						// 		});
						// 	}
						// });
					},
					close:function(){
						$(window).off(ns);
						$box.off();
						clearInterval(interval);
					}
				});
			}
		}else{ history.back(); }
	});
</script>
