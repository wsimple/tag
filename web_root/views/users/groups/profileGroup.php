<div class="group-details" id="taglist-box">

	<div class="ui-single-box-title" style="display: none;">
		
		<span style="float:left;">
			<a href="<?=base_url('groups')?>" title=""><?=$lang['GROUPS_TITLENAMEGROUPPREFIJO']?></a>&nbsp;>&nbsp;
		</span>
		<div id="groupTitleStyle" title=""></div>
		
		<!-- <a id="btncreateTags" class="float-right" ><?=$lang['MAINMNU_CREATETAG']?></a> -->
		<form>
			<div class="tags-size">
				<?=$lang['RADIOBTN_VIEW']?>:
				<input type="radio" name="radio" id="normal" <?=$_SESSION['ws-tags']['ws-user']['view_type_timeline']==0?'checked="checked"':''?>/><label title="Normal Tags" for="normal">&nbsp;</label>
				<input type="radio" name="radio" id="mini" <?=$_SESSION['ws-tags']['ws-user']['view_type_timeline']!=0?'checked="checked"':''?>/><label title="Mini Tags" for="mini">&nbsp;</label>
			</div>
		</form>
	</div>
	<div class="ui-single-box-title" style="display: none;">
		<ul id="subMenuAdminGroups" class="mainMenu float-left" style=" background: #FFF;">
			<li>
				<a class="fNiv mo" ><?=$lang['GROUPS_MENUADMINISTRATION']?></a>
				<ul>
					<li class="arrow" style=" padding-left: 35px"></li>
					<li id="btneditprofilegroup"></li>
					<li><a id="btnShowMembers" class="linkOptionGrouop"><?=$lang['GROUPS_NEWMEMBERS']?></a></li>
					<li><a id="btnInviteFriends" class="linkOptionGrouop"><?=$lang['GROUPS_INVITEFRIENDSBTNINVITE']?></a></li>
					<li><a id="btnLeaveGroup" class="linkOptionGrouop"><?=$lang['GROUPS_MENULEAVEGROUP']?></a></li>
				</ul>
			</li>
		</ul>
		<a id="btnNewGroup" class="float-left" ><?=$lang['GROUPS_TITLEWINDOWSNEW']?></a>
	</div>
	<br/>
    <div id="info-top-groups"></div>
    <div id="divctg">
    	<a class="ctgruop" id="btncreateTagsG" ><?=$lang['GROUPS_CONTRIBUTEGROUP']?></a>
    </div>
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
		//$('#btncreateTagsG').hide();
		var $box=$('#taglist-box').last(),
			idg='<?=$_GET['grp']?$_GET['grp']:''?>';
		$('#subMenuAdminGroups').jMenu();
		if (idg!=''){
			$.ajax({
				type	:	"GET",
				url		:	"controls/groups/listGroups.json.php?gid="+idg+"&profile=1",
				dataType:	"json",
				success	:	function (data) {
					if (data['list']){ 
						$('div#groupTitleStyle').attr('title',data['list'][0]['name']);
						$('div#groupTitleStyle').html(data['list'][0]['name']);
						if (data['list'][0]['date_join']) $('#divctg').addClass('ctg').find('a#btncreateTagsG').attr('href',BASEURL+'creation?group='+idg).show();
						if (data['list'][0]['isAdmin']){
							$('.group-details .ui-single-box-title').css('display','block');
							if (data['list'][0]['isAdmin']=='1'){
								$('li#btneditprofilegroup').html('<a class="linkOptionGrouop"><?=GROUPS_PROFILETITLE?></a>');
								$('#btneditprofilegroup a').click(function(){
									addNewGroup('<?=EDITGROUPS_PROFILETITLE?>','&grp='+idg);
								});
							}
							tagsListGroups();
							if ((data['list'][0]['salicitud']) && (data['list'][0]['salicitud']!='no-creador')){
								var	opc={ actual:0,total:'',layer: '',grupo: "<?=$_GET['grp']?>",status: status }
								membersGroups("<?=$_GET['grp']?>",opc,5);
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
								var	opc={ actual:0,total:'',layer: '',grupo: "<?=$_GET['grp']?>",status: status }
								membersGroups("<?=$_GET['grp']?>",opc);
								return false;
							});
							$('#btnInviteFriends').click(function(){
								inviteFriendsToGroup('<?=GROUPS_INVITEFRIENDSBTNINVITE?>','<?=$_GET['grp']?>');
								return false;
							});
                            $('#info-top-groups').html(det_info(data['list'][0]));
                            $('#info-top-groups a').click(function(){
                                if ($(this).parents('article').hasClass('info')){ dialog_info(data['list'][0]); }
                                else if ($(this).parents('article').hasClass('member')){ 
                                	var	opc={ actual:0,total:'',layer: '',grupo: "<?=$_GET['grp']?>",status: status }
                                	membersGroups("<?=$_GET['grp']?>",opc);  
                                }
                                return false;
                            });
						}else{
							$('.group-details .ui-single-box-title').remove();
							if (data['list'][0]['noti']['body']){
								$('.tags-list').hide().after('<div id="info">'+data['list'][0]['noti']['body']+'</div>');
								$('#btn input#back').click(function(){ history.back(); });
							}
						}
					}else{
						$.dialog({
							title	: '<?=SIGNUP_CTRTITLEMSGNOEXITO?>',
							content	: '<?=TAGS_WHENTAGNOEXIST?>',
							height	: 200,
							close	: function(){ redir('groups?'); }
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
